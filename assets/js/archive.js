/**
 * Archive Page AJAX - Load posts without page refresh
 * Works with blog, services (companies, individual, international), and general archive pages
 */

(function($) {
    'use strict';
    
    // Helper: Extract category ID from URL
    const getCategoryIdFromUrl = (url) => {
        if (!url) return 0;
        
        // Clean URL: remove page numbers, anchors, query params
        const cleanUrl = url.split('#')[0].split('?')[0].replace(/\/page\/\d+\//, '').replace(/\/page\/\d+$/, '').replace(/\/$/, '');
        
        // Try to find matching link by URL
        const $matchingLink = $('.category-link, .archive-category-nav-item').filter(function() {
            const linkUrl = $(this).attr('href').split('#')[0].split('?')[0].replace(/\/$/, '');
            const normalizedLinkUrl = linkUrl.replace(/\/$/, '');
            const normalizedCleanUrl = cleanUrl.replace(/\/$/, '');
            return normalizedLinkUrl === normalizedCleanUrl || 
                   normalizedCleanUrl.endsWith(normalizedLinkUrl) || 
                   normalizedLinkUrl.endsWith(normalizedCleanUrl);
        });
        
        if ($matchingLink.length) {
            return parseInt($matchingLink.first().data('category-id')) || 0;
        }
        
        // Try to extract from URL pattern: /category/slug/ or /ar/category/slug/
        const categoryMatch = cleanUrl.match(/\/(?:ar\/)?category\/([^\/]+)/);
        if (categoryMatch) {
            const categorySlug = categoryMatch[1];
            // Try to find a link with this slug in the href
            const $slugLink = $('.category-link, .archive-category-nav-item').filter(function() {
                const href = $(this).attr('href') || '';
                return href.includes('/category/' + categorySlug) || href.includes(categorySlug);
            });
            
            if ($slugLink.length) {
                return parseInt($slugLink.first().data('category-id')) || 0;
            }
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
    
    // Helper: Get current category context from page
    const getCurrentCategoryContext = () => {
        const context = {
            categoryId: 0,
            parentCategoryId: 0,
            baseUrl: '',
            anchorId: '#category-title'
        };
        
        // Try to get from active category link
        const $activeLink = $('.category-link.active, .archive-category-nav-item.active').first();
        if ($activeLink.length) {
            context.categoryId = parseInt($activeLink.data('category-id')) || 0;
            const rawParentId = parseInt($activeLink.data('parent-category-id')) || 0;
            
            // Only use parentId if it's in services context
            const isInServicesContext = $activeLink.closest('.services-sidebar, .services-main').length > 0;
            const isInGeneralNav = $activeLink.hasClass('archive-category-nav-item');
            
            if (isInServicesContext && !isInGeneralNav && rawParentId > 0) {
                context.parentCategoryId = rawParentId;
            }
            
            // Get URL from active link
            const linkUrl = $activeLink.attr('href');
            if (linkUrl) {
                context.baseUrl = linkUrl.split('#')[0].split('?')[0];
            }
        }
        
        // Try to get from pagination wrapper data attributes
        const $paginationWrapper = $('.pagination-wrapper').first();
        if ($paginationWrapper.length) {
            const paginationCategoryId = parseInt($paginationWrapper.data('category-id')) || 0;
            const paginationParentId = parseInt($paginationWrapper.data('parent-category-id')) || 0;
            const paginationBaseUrl = $paginationWrapper.data('base-url') || '';
            const paginationAnchor = $paginationWrapper.data('anchor-id') || '#category-title';
            
            if (paginationCategoryId > 0 || paginationParentId > 0) {
                context.categoryId = paginationCategoryId;
                context.parentCategoryId = paginationParentId;
            }
            
            if (paginationBaseUrl) {
                context.baseUrl = paginationBaseUrl;
            }
            
            if (paginationAnchor) {
                context.anchorId = paginationAnchor;
            }
        }
        
        // Fallback: try to extract from current URL
        if (!context.categoryId) {
            const currentUrl = window.location.href;
            const extractedCategoryId = getCategoryIdFromUrl(currentUrl);
            if (extractedCategoryId > 0) {
                context.categoryId = extractedCategoryId;
                if (isServicesCategory(extractedCategoryId)) {
                    context.parentCategoryId = detectParentCategoryId(currentUrl, extractedCategoryId);
                }
            }
        }
        
        // Always update baseUrl from current URL if not set
        if (!context.baseUrl) {
            const currentUrl = window.location.href;
            context.baseUrl = currentUrl.split('#')[0].split('?')[0].replace(/\/page\/\d+\//, '').replace(/\/page\/\d+$/, '');
        }
        
        return context;
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
        
        // Handle pagination clicks
        $(document).on('click', '.pagination-link', function(e) {
            e.preventDefault();
            
            const $link = $(this);
            const pageNumber = parseInt($link.data('page')) || 1;
            const href = $link.attr('href');
            
            // Get current category context
            const context = getCurrentCategoryContext();
            
            // Build URL with page number
            let targetUrl = context.baseUrl || href.split('#')[0].split('?')[0];
            
            // Remove existing page from URL
            targetUrl = targetUrl.replace(/\/page\/\d+\//, '/').replace(/\/page\/\d+$/, '');
            
            // Add page number
            if (pageNumber > 1) {
                targetUrl = targetUrl + 'page/' + pageNumber + '/';
            }
            
            // Add anchor if available
            if (context.anchorId) {
                targetUrl = targetUrl + context.anchorId;
            }
            
            // Load posts with pagination
            loadArchivePosts(context.categoryId, targetUrl, context.parentCategoryId, pageNumber);
        });
    });

    /**
     * Load archive posts/services via AJAX
     */
    function loadArchivePosts(categoryId, url, parentCategoryId, pagedOverride = null) {
        // Determine page type - check if it's a services page (including secure-yourself)
        // Secure pages also use services-grid, so we need to detect them
        let isServicesPage = (parentCategoryId || 0) > 0;
        
        // Check if current page has services-grid container (secure pages use it too)
        if (!isServicesPage && $('#services-grid').length > 0) {
            isServicesPage = true;
        }
        
        // Also check if category is secure-yourself type
        if (!isServicesPage && categoryId > 0) {
            const $categoryLink = $('.category-link[data-category-id="' + categoryId + '"], .archive-category-nav-item[data-category-id="' + categoryId + '"]');
            if ($categoryLink.length) {
                // Check if we're on a secure page by looking at the current URL or page structure
                const currentUrl = window.location.href;
                if (currentUrl.includes('secure-yourself') || currentUrl.includes('امن-نفسك')) {
                    isServicesPage = true;
                }
            }
        }
        
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
        
        // Extract page number from URL or use override
        let paged = 1;
        if (pagedOverride !== null) {
            paged = pagedOverride;
        } else {
            // Try to extract from URL path (e.g., /page/2/)
            const urlPath = url.split('?')[0];
            const pageMatch = urlPath.match(/\/page\/(\d+)\//);
            if (pageMatch) {
                paged = parseInt(pageMatch[1]) || 1;
            } else {
                // Fallback to query parameter
                const urlParams = new URLSearchParams(url.split('?')[1] || '');
                paged = parseInt(urlParams.get('paged')) || 1;
            }
        }
        
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
                    const $tempDiv = $('<div>').html(response.data.posts_html);
                    
                    // Extract pagination from posts_html if it exists
                    const $paginationInResponse = $tempDiv.find('.pagination-wrapper');
                    
                    if ($gridContainer.length) {
                        const gridClass = isServicesPage ? '.services-grid' : '.posts-grid';
                        const $gridContent = $tempDiv.find(gridClass);
                        
                        if ($gridContent.length) {
                            // Remove pagination from grid content if it exists
                            $gridContent.find('.pagination-wrapper').remove();
                            $gridContainer.html($gridContent.html());
                        } else {
                            // If grid wrapper not found, try to find the content directly
                            $tempDiv.find('.pagination-wrapper').remove();
                            $gridContainer.html($tempDiv.html());
                        }
                    } else {
                        // Remove pagination from main container content
                        $tempDiv.find('.pagination-wrapper').remove();
                        $mainContainer.html($tempDiv.html());
                    }
                    
                    // Update pagination wrapper (use pagination from response or separate pagination_html)
                    if ($paginationWrapper.length) {
                        if ($paginationInResponse.length) {
                            // Use pagination from posts_html
                            $paginationWrapper.html($paginationInResponse.html());
                        } else if (response.data.pagination_html) {
                            // Use separate pagination_html if available
                            $paginationWrapper.html(response.data.pagination_html);
                        }
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
                        // Store category context in history state for back/forward navigation
                        window.history.pushState({
                            path: cleanUrl,
                            categoryId: categoryId,
                            parentCategoryId: parentCategoryId
                        }, '', cleanUrl);
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
        let categoryId = categoryData.id;
        let parentCategoryId = categoryData.parentId;
        
        // Ensure secure pages are treated as services pages
        // Check URL for secure-yourself indicators or if services-grid exists
        if ((url.includes('secure-yourself') || url.includes('امن-نفسك') || $('#services-grid').length > 0) && !parentCategoryId) {
            // If we're on a secure page but don't have parentCategoryId, set it
            // Try to get from pagination wrapper
            const $paginationWrapper = $('.pagination-wrapper').first();
            if ($paginationWrapper.length) {
                const paginationParentId = parseInt($paginationWrapper.data('parent-category-id')) || 0;
                const paginationCategoryId = parseInt($paginationWrapper.data('category-id')) || 0;
                if (paginationParentId > 0) {
                    parentCategoryId = paginationParentId;
                } else if (paginationCategoryId > 0) {
                    // For secure pages, use category_id as parent_category_id
                    parentCategoryId = paginationCategoryId;
                }
            }
            
            // If still no parent, use categoryId as parent for secure pages
            if (!parentCategoryId && categoryId > 0) {
                parentCategoryId = categoryId;
            } else if (!parentCategoryId) {
                // Last resort: set a non-zero value to trigger services page detection
                parentCategoryId = 1;
            }
        }
        
        updateUIState(categoryData.name, categoryId);
        loadArchivePosts(categoryId, url, parentCategoryId);
    });

})(jQuery);
