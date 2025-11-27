/**
 * Archive Page AJAX - Load posts without page refresh
 */

(function($) {
    'use strict';
    
    // Helper: Get category data from link or URL
    const getCategoryData = ($link, url) => {
        const data = {
            id: 0,
            parentId: 0,
            name: ''
        };
        
        if ($link?.length) {
            data.id = parseInt($link.data('category-id')) || 0;
            data.parentId = parseInt($link.data('parent-category-id')) || 0;
            data.name = $link.find('.category-name').text();
        } else if (url) {
            const match = url.match(/\/category\/([^\/\?#]+)/);
            if (match && match[1] !== 'blog' && !url.includes('#category-title')) {
                // Could fetch from existing links
                const $existingLink = $('.category-link[href*="' + url.split('#')[0] + '"]');
                if ($existingLink.length) {
                    data.id = parseInt($existingLink.data('category-id')) || 0;
                    data.parentId = parseInt($existingLink.data('parent-category-id')) || 0;
                }
            }
        }
        
        return data;
    };
    
    // Helper: Update UI state
    const updateUIState = (categoryName) => {
        $('.category-link').removeClass('active');
        if (categoryName) $('.toggle-text').text(categoryName);
    };

    // Initialize
    $(document).ready(function() {
        $('.category-link').on('click', function(e) {
            e.preventDefault();
            
            const $link = $(this);
            const url = $link.attr('href');
            const categoryData = getCategoryData($link, url);
            
            $link.addClass('active');
            updateUIState(categoryData.name);
            loadArchivePosts(categoryData.id, url, categoryData.parentId);
        });
    });

    /**
     * Load archive posts/services via AJAX
     */
    function loadArchivePosts(categoryId, url, parentCategoryId) {
        const isServicesPage = (parentCategoryId || 0) > 0;
        const contentType = isServicesPage ? 'services' : 'posts';
        
        // Get containers
        const $mainContainer = isServicesPage ? $('#services-main') : $('#posts-container');
        const $gridContainer = isServicesPage ? $('#services-grid') : $('#posts-grid');
        const $paginationWrapper = $('.pagination-wrapper');
        
        // Show loading
        $mainContainer.addClass('loading');
        const loadingHtml = `<div class="loading-posts" style="text-align: center; padding: 40px; color: var(--white);">
            <i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 10px;"></i>
            <p>Loading ${contentType}...</p>
        </div>`;
        ($gridContainer.length ? $gridContainer : $mainContainer).html(loadingHtml);
        
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
                        const gridClass = isServicesPage ? '.services-grid' : '.posts-grid';
                        const innerContent = $('<div>').html(response.data.posts_html).find(gridClass).html();
                        $gridContainer.html(innerContent);
                    } else {
                        $mainContainer.html(response.data.posts_html);
                    }
                    
                    // Update pagination
                    if (response.data.pagination_html) {
                        $paginationWrapper.html(response.data.pagination_html);
                    }
                    
                    // Update and scroll to title
                    const titleSelector = isServicesPage ? '#services-title' : '#category-title';
                    const $title = $(titleSelector);
                    if (response.data.category_title && $title.length) {
                        $title.text(response.data.category_title);
                    }
                    if ($title.length) {
                        $('html, body').animate({ scrollTop: $title.offset().top - 100 }, 500);
                    }
                    
                    // Update URL
                    if (window.history?.pushState) {
                        window.history.pushState({path: url.split('#')[0]}, '', url.split('#')[0]);
                    }
                } else {
                    showError(response.data || 'Please try again.');
                }
            },
            error: function() {
                $mainContainer.removeClass('loading');
                showError('An error occurred. Please refresh the page.');
            }
        });
    }
    
    // Helper: Display error message
    const showError = (message) => {
        const errorHtml = `<div class="no-posts">
            <i class="fa-solid fa-file-circle-question"></i>
            <h3>Error loading ${contentType}</h3>
            <p>${message}</p>
        </div>`;
        ($gridContainer.length ? $gridContainer : $mainContainer).html(errorHtml);
    };

    // Handle browser back/forward buttons
    $(window).on('popstate', function(e) {
        if (!e.originalEvent.state) return;
        
        const url = window.location.href;
        const $link = $('.category-link[href*="' + url.split('#')[0] + '"]');
        const categoryData = getCategoryData($link, url);
        
        if ($link.length) {
            $link.addClass('active');
            updateUIState(categoryData.name);
        } else {
            updateUIState();
        }
        
        loadArchivePosts(categoryData.id, url, categoryData.parentId);
    });

})(jQuery);

