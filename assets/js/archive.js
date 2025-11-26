/**
 * Archive Page AJAX - Load posts without page refresh
 */

(function($) {
    'use strict';

    // Initialize
    $(document).ready(function() {
        // Intercept category link clicks
        $('.category-link').on('click', function(e) {
            e.preventDefault();
            
            const $link = $(this);
            const url = $link.attr('href');
            const categoryId = $link.data('category-id') !== undefined ? parseInt($link.data('category-id')) || 0 : getCategoryIdFromUrl(url);
            const parentCategoryId = $link.data('parent-category-id') !== undefined ? parseInt($link.data('parent-category-id')) || 0 : 0;
            
            // Update active state
            $('.category-link').removeClass('active');
            $link.addClass('active');
            
            // Update toggle button text
            const categoryName = $link.find('.category-name').text();
            $('.toggle-text').text(categoryName);
            
            // Load posts/services via AJAX
            loadArchivePosts(categoryId, url, parentCategoryId);
        });
    });

    /**
     * Extract category ID from URL or data attribute
     */
    function getCategoryIdFromUrl(url) {
        // Try to get from data attribute first (most reliable)
        const $link = $('.category-link[href*="' + url.split('#')[0] + '"]');
        if ($link.length) {
            const categoryId = $link.data('category-id');
            if (categoryId !== undefined) {
                return parseInt(categoryId) || 0;
            }
        }
        
        // Fallback: Extract from URL
        const match = url.match(/\/category\/([^\/\?#]+)/);
        if (match) {
            const slug = match[1];
            // For "All Posts" or blog parent, return 0
            if (slug === 'blog' || url.indexOf('#category-title') !== -1) {
                return 0; // All posts
            }
        }
        
        return 0;
    }

    /**
     * Load archive posts/services via AJAX
     */
    function loadArchivePosts(categoryId, url, parentCategoryId) {
        // Detect if this is a services page or blog page
        parentCategoryId = parentCategoryId || 0;
        const isServicesPage = parentCategoryId > 0;
        
        // Get appropriate containers
        const $postsContainer = $('#posts-container');
        const $postsGrid = $('#posts-grid');
        const $servicesMain = $('#services-main');
        const $servicesGrid = $('#services-grid');
        const $paginationWrapper = $('.pagination-wrapper');
        
        // Determine which containers to use
        const $mainContainer = isServicesPage ? $servicesMain : $postsContainer;
        const $gridContainer = isServicesPage ? $servicesGrid : $postsGrid;
        
        // Show loading state
        $mainContainer.addClass('loading');
        const loadingHtml = '<div class="loading-posts" style="text-align: center; padding: 40px; color: var(--white);"><i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 10px;"></i><p>Loading ' + (isServicesPage ? 'services' : 'posts') + '...</p></div>';
        
        if ($gridContainer.length) {
            $gridContainer.html(loadingHtml);
        } else {
            $mainContainer.html(loadingHtml);
        }
        
        // Get current page from URL or default to 1
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
                    // Update grid
                    if ($gridContainer.length) {
                        // For services pages, the AJAX response includes the services-grid wrapper
                        // We need to extract just the inner content (service cards) to avoid nested grids
                        if (isServicesPage) {
                            const $tempDiv = $('<div>').html(response.data.posts_html);
                            const $innerContent = $tempDiv.find('.services-grid').html();
                            $gridContainer.html($innerContent);
                        } else {
                            // For blog posts, extract the posts-grid content
                            const $tempDiv = $('<div>').html(response.data.posts_html);
                            const $innerContent = $tempDiv.find('.posts-grid').html();
                            $gridContainer.html($innerContent);
                        }
                    } else {
                        $mainContainer.html(response.data.posts_html);
                    }
                    
                    // Update pagination if it exists
                    if (response.data.pagination_html && $paginationWrapper.length) {
                        $paginationWrapper.html(response.data.pagination_html);
                    }
                    
                    // Update page title if needed
                    const titleSelector = isServicesPage ? '#services-title' : '#category-title';
                    if (response.data.category_title && $(titleSelector).length) {
                        $(titleSelector).text(response.data.category_title);
                    }
                    
                    // Scroll to title smoothly
                    const $title = $(titleSelector);
                    if ($title.length) {
                        $('html, body').animate({
                            scrollTop: $title.offset().top - 100
                        }, 500);
                    }
                    
                    // Update URL without page reload
                    if (window.history && window.history.pushState) {
                        const newUrl = url.split('#')[0];
                        window.history.pushState({path: newUrl}, '', newUrl);
                    }
                } else {
                    const errorMsg = response.data || 'Please try again.';
                    const errorHtml = '<div class="no-posts"><i class="fa-solid fa-file-circle-question"></i><h3>Error loading ' + (isServicesPage ? 'services' : 'posts') + '</h3><p>' + errorMsg + '</p></div>';
                    if ($gridContainer.length) {
                        $gridContainer.html(errorHtml);
                    } else {
                        $mainContainer.html(errorHtml);
                    }
                }
            },
            error: function() {
                $mainContainer.removeClass('loading');
                const errorHtml = '<div class="no-posts"><i class="fa-solid fa-file-circle-question"></i><h3>Error loading ' + (isServicesPage ? 'services' : 'posts') + '</h3><p>An error occurred. Please refresh the page.</p></div>';
                if ($gridContainer.length) {
                    $gridContainer.html(errorHtml);
                } else {
                    $mainContainer.html(errorHtml);
                }
            }
        });
    }

    // Handle browser back/forward buttons
    $(window).on('popstate', function(e) {
        if (e.originalEvent.state) {
            const url = window.location.href;
            // Try to find the link that matches this URL
            const $link = $('.category-link[href*="' + url.split('#')[0] + '"]');
            const categoryId = $link.length ? ($link.data('category-id') !== undefined ? parseInt($link.data('category-id')) || 0 : getCategoryIdFromUrl(url)) : getCategoryIdFromUrl(url);
            const parentCategoryId = $link.length ? ($link.data('parent-category-id') !== undefined ? parseInt($link.data('parent-category-id')) || 0 : 0) : 0;
            
            // Update active state
            $('.category-link').removeClass('active');
            if ($link.length) {
                $link.addClass('active');
                const categoryName = $link.find('.category-name').text();
                $('.toggle-text').text(categoryName);
            }
            
            loadArchivePosts(categoryId, url, parentCategoryId);
        }
    });

})(jQuery);

