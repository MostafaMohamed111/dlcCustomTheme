/**
 * Archive Page AJAX - Load posts without page refresh
 * Works with blog, services (companies, individual, international), and general archive pages
 */

(function($) {
    'use strict';
    
    // Helper: Extract category ID from URL
    const getCategoryIdFromUrl = (url) => {
        if (!url) return 0;
        
        // Try to find matching link by URL
        const cleanUrl = url.split('#')[0].split('?')[0];
        const $matchingLink = $('.category-link, .archive-category-nav-item').filter(function() {
            const linkUrl = $(this).attr('href').split('#')[0].split('?')[0];
            return linkUrl === cleanUrl || cleanUrl.endsWith(linkUrl) || linkUrl.endsWith(cleanUrl);
        });
        
        if ($matchingLink.length) {
            return parseInt($matchingLink.first().data('category-id')) || 0;
        }
        
        return 0;
    };
    
    // Helper: Detect parent category ID from URL or page context
    const detectParentCategoryId = (url, categoryId) => {
        // First, try to get from link data attribute
        const cleanUrl = url.split('#')[0].split('?')[0];
        const $matchingLink = $('.category-link, .archive-category-nav-item').filter(function() {
            const linkUrl = $(this).attr('href').split('#')[0].split('?')[0];
            return linkUrl === cleanUrl || cleanUrl.endsWith(linkUrl) || linkUrl.endsWith(cleanUrl);
        });
        
        if ($matchingLink.length) {
            const parentId = parseInt($matchingLink.first().data('parent-category-id')) || 0;
            if (parentId > 0) return parentId;
        }
        
        // If we have a category ID, check if it's a child category
        if (categoryId > 0) {
            // Check all category links to see if this category is a child
            $('.category-link[data-category-id="' + categoryId + '"]').each(function() {
                const parentId = parseInt($(this).data('parent-category-id')) || 0;
                if (parentId > 0) return parentId;
            });
        }
        
        return 0;
    };
    
    // Helper: Check if a category is a services category
    const isServicesCategory = (categoryId) => {
        if (!categoryId) return false;
        
        // Check if the link is in a services sidebar (not general archive nav)
        const $link = $('.category-link[data-category-id="' + categoryId + '"]');
        if ($link.length) {
            // If it's in a services sidebar, it's a services category
            const $servicesSidebar = $link.closest('.services-sidebar, .services-main');
            if ($servicesSidebar.length) {
                return true;
            }
        }
        
        // Check if it's in general archive nav (not services)
        const $navLink = $('.archive-category-nav-item[data-category-id="' + categoryId + '"]');
        if ($navLink.length) {
            // General archive nav means it's NOT a services page
            return false;
        }
        
        return false;
    };
    
    // Helper: Get category data from link or URL
    const getCategoryData = ($link, url) => {
        const data = {
            id: 0,
            parentId: 0,
            name: ''
        };
        
        if ($link?.length) {
            data.id = parseInt($link.data('category-id')) || 0;
            const rawParentId = parseInt($link.data('parent-category-id')) || 0;
            
            // Only set parentId if this is actually a services category
            // General archive nav items have parent_category_id but aren't services
            if (rawParentId > 0) {
                // Check if this link is in a services context
                const isInServicesContext = $link.closest('.services-sidebar, .services-main').length > 0;
                const isInGeneralNav = $link.hasClass('archive-category-nav-item');
                
                // Only use parentId if it's in services context, not general nav
                if (isInServicesContext && !isInGeneralNav) {
                    data.parentId = rawParentId;
                }
            }
            
            data.name = $link.find('.category-name').text().trim() || $link.text().trim();
        }
        
        // If we don't have data from link, try to extract from URL
        if (!data.id && url) {
            data.id = getCategoryIdFromUrl(url);
            if (data.id) {
                // Only detect parent if it's a services category
                if (isServicesCategory(data.id)) {
                    data.parentId = detectParentCategoryId(url, data.id);
                }
            }
        }
        
        return data;
    };
    
    // Helper: Update UI state
    const updateUIState = (categoryName, categoryId) => {
        // Update sidebar toggle text
        if (categoryName && $('.toggle-text').length) {
            $('.toggle-text').text(categoryName);
        }
        
        // Update active states
        $('.category-link, .archive-category-nav-item').removeClass('active');
        
        if (categoryId > 0) {
            $('.category-link[data-category-id="' + categoryId + '"], .archive-category-nav-item[data-category-id="' + categoryId + '"]').addClass('active');
        } else {
            // For "All" links (category-id="0")
            $('.category-link[data-category-id="0"], .archive-category-nav-item[data-category-id="0"]').addClass('active');
        }
    };

    // Initialize
    $(document).ready(function() {
        // Handle sidebar category links
        $(document).on('click', '.category-link', function(e) {
            e.preventDefault();
            
            const $link = $(this);
            const url = $link.attr('href');
            const categoryData = getCategoryData($link, url);
            
            updateUIState(categoryData.name, categoryData.id);
            loadArchivePosts(categoryData.id, url, categoryData.parentId);
        });
        
        // Handle navigation bar category links
        $(document).on('click', '.archive-category-nav-item', function(e) {
            e.preventDefault();
            
            const $link = $(this);
            const url = $link.attr('href');
            const categoryData = getCategoryData($link, url);
            
            // General archive nav items should NEVER send parent_category_id
            // They have it for navigation display purposes only, but aren't services pages
            categoryData.parentId = 0;
            
            updateUIState(categoryData.name, categoryData.id);
            loadArchivePosts(categoryData.id, url, categoryData.parentId);
        });
    });

    /**
     * Load archive posts/services via AJAX
     */
    function loadArchivePosts(categoryId, url, parentCategoryId) {
        // Determine page type
        const isServicesPage = (parentCategoryId || 0) > 0;
        const contentType = isServicesPage ? 'services' : 'posts';
        
        // Get containers - check for all possible container IDs
        let $mainContainer = $('#posts-container');
        let $gridContainer = $('#posts-grid');
        
        if (isServicesPage) {
            $mainContainer = $('#services-main');
            $gridContainer = $('#services-grid');
        }
        
        // Fallback: if containers not found, try to find them
        if (!$mainContainer.length) {
            $mainContainer = $('.posts-container, .services-main').first();
        }
        if (!$gridContainer.length) {
            $gridContainer = $('.posts-grid, .services-grid').first();
        }
        
        const $paginationWrapper = $('.pagination-wrapper, .archive-pagination');
        
        // Show loading
        $mainContainer.addClass('loading');
        const loadingHtml = `<div class="loading-posts" style="text-align: center; padding: 40px;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 10px; color: var(--primary-blue);"></i>
            <p style="color: var(--dark-gray);">Loading ${contentType}...</p>
        </div>`;
        ($gridContainer.length ? $gridContainer : $mainContainer).html(loadingHtml);
        
        // Extract page number from URL
        const urlParams = new URLSearchParams(url.split('?')[1] || '');
        const paged = urlParams.get('paged') || 1;
        
        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_archive_posts',
                category_id: categoryId,
                parent_category_id: parentCategoryId,
                paged: paged,
                security: ajax_object.nonce || ''
            },
            success: function(response) {
                $mainContainer.removeClass('loading');
                
                if (response.success) {
                    // Extract and update content
                    if ($gridContainer.length) {
                        const $tempDiv = $('<div>').html(response.data.posts_html);
                        const gridClass = isServicesPage ? '.services-grid' : '.posts-grid';
                        const $gridContent = $tempDiv.find(gridClass);
                        
                        if ($gridContent.length) {
                            $gridContainer.html($gridContent.html());
                        } else {
                            // If grid wrapper not found, try to find the content directly
                            $gridContainer.html($tempDiv.html());
                        }
                    } else {
                        $mainContainer.html(response.data.posts_html);
                    }
                    
                    // Update pagination
                    if (response.data.pagination_html && $paginationWrapper.length) {
                        $paginationWrapper.html(response.data.pagination_html);
                    }
                    
                    // Update and scroll to title
                    const titleSelector = isServicesPage ? '#services-title' : '#category-title, .archive-main-title';
                    const $title = $(titleSelector).first();
                    if (response.data.category_title && $title.length) {
                        $title.text(response.data.category_title);
                    }
                    
                    // Scroll to title or top of content
                    if ($title.length) {
                        $('html, body').animate({ scrollTop: $title.offset().top - 100 }, 500);
                    } else if ($mainContainer.length) {
                        $('html, body').animate({ scrollTop: $mainContainer.offset().top - 100 }, 500);
                    }
                    
                    // Update URL without page reload
                    if (window.history && window.history.pushState) {
                        const cleanUrl = url.split('#')[0];
                        window.history.pushState({path: cleanUrl}, '', cleanUrl);
                    }
                } else {
                    showError(response.data || 'Please try again.', contentType, $gridContainer, $mainContainer);
                }
            },
            error: function() {
                $mainContainer.removeClass('loading');
                showError('An error occurred. Please refresh the page.', contentType, $gridContainer, $mainContainer);
            }
        });
    }
    
        // Helper: Display error message
    const showError = (message, contentType, $gridContainer, $mainContainer) => {
        const errorHtml = `<div class="no-posts" style="text-align: center; padding: 60px 20px;">
            <i class="fa-solid fa-file-circle-question" style="font-size: 48px; color: var(--gray); margin-bottom: 20px; opacity: 0.5;"></i>
            <h3 style="color: var(--light-blue); margin-bottom: 10px;">Error loading ${contentType}</h3>
            <p style="color: var(--dark-gray);">${message}</p>
            </div>`;
            ($gridContainer.length ? $gridContainer : $mainContainer).html(errorHtml);
        };

    // Handle browser back/forward buttons
    $(window).on('popstate', function(e) {
        const url = window.location.href;
        
        // Try to find matching link
        const cleanUrl = url.split('#')[0].split('?')[0];
        const $link = $('.category-link, .archive-category-nav-item').filter(function() {
            const linkUrl = $(this).attr('href').split('#')[0].split('?')[0];
            return linkUrl === cleanUrl || cleanUrl.endsWith(linkUrl) || linkUrl.endsWith(cleanUrl);
        });
        
        const categoryData = getCategoryData($link, url);
        updateUIState(categoryData.name, categoryData.id);
        loadArchivePosts(categoryData.id, url, categoryData.parentId);
    });

})(jQuery);
