/**
 * Certificates & Clients Carousel JavaScript
 * Auto-rotating carousel showing multiple logos at a time
 * Supports multiple carousels on the same page
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        // Get all carousel wrappers on the page
        const carouselWrappers = document.querySelectorAll('.certificates-carousel-wrapper');
        
        console.log('Certificates/Clients Carousel: Found ' + carouselWrappers.length + ' carousel(s)');
        
        if (carouselWrappers.length === 0) return;

        // Initialize each carousel independently
        carouselWrappers.forEach(function(carouselWrapper, index) {
            console.log('Initializing carousel #' + (index + 1));
            initCarousel(carouselWrapper);
        });
    });

    function initCarousel(carouselWrapper) {
        const carouselTrack = carouselWrapper.querySelector('.certificates-carousel-track');
        const prevBtn = carouselWrapper.querySelector('.certificates-carousel-prev');
        const nextBtn = carouselWrapper.querySelector('.certificates-carousel-next');
        
        if (!carouselTrack || !prevBtn || !nextBtn) return;

        const items = Array.from(carouselTrack.querySelectorAll('.certificate-item'));
        const totalItems = items.length;
        
        if (totalItems === 0) return;

        let currentSlide = 0; // Current slide position (moves by 1)
        let visibleItems = 6; // Show 6 logos at a time
        let autoRotateInterval = null;
        const rotateInterval = 3000; // 3 seconds
        let isTransitioning = false;

        // Calculate visible items based on screen size
        function calculateVisibleItems() {
            const width = window.innerWidth;
            if (width <= 480) {
                visibleItems = 2;
            } else if (width <= 768) {
                visibleItems = 3;
            } else if (width <= 992) {
                visibleItems = 4;
            } else {
                visibleItems = 6;
            }
            
            // Don't show more items than we have
            if (visibleItems > totalItems) {
                visibleItems = totalItems;
            }
        }

        // Initialize visible items calculation
        calculateVisibleItems();

        // Clone items for infinite loop if we have more than visibleItems
        function cloneItemsForInfiniteLoop() {
            // Remove any existing clones first
            carouselTrack.querySelectorAll('.certificate-item.clone').forEach(el => el.remove());
            
            // Only clone if we have enough items for infinite scroll
            if (totalItems > visibleItems) {
                // Clone all items to enable smooth infinite loop
                // Clone first set and append to end
                for (let i = 0; i < totalItems; i++) {
                    const clone = items[i].cloneNode(true);
                    clone.classList.add('clone');
                    carouselTrack.appendChild(clone);
                }
                
                // Clone last set and prepend to beginning
                for (let i = totalItems - 1; i >= 0; i--) {
                    const clone = items[i].cloneNode(true);
                    clone.classList.add('clone');
                    carouselTrack.insertBefore(clone, carouselTrack.firstChild);
                }
                
                // Set initial position to show first actual items (after prepended clones)
                currentSlide = totalItems;
                updateCarouselPosition(false);
            } else {
                // Not enough items for infinite scroll
                currentSlide = 0;
                updateCarouselPosition(false);
            }
        }

        // Calculate total slides
        function getTotalSlides() {
            return Math.ceil(totalItems / visibleItems);
        }

        // Create indicators (not used, but kept for compatibility)
        function createIndicators() {
            // Indicators are hidden via CSS, so we don't need to create them
        }

        // Update indicators (not used, but kept for compatibility)
        function updateIndicators() {
            // Indicators are hidden via CSS
        }

        // Update carousel position
        function updateCarouselPosition(smooth = true) {
            if (!smooth) {
                carouselTrack.style.transition = 'none';
            } else {
                carouselTrack.style.transition = 'transform 0.5s ease-in-out';
            }
            
            // Move by one complete item width at a time
            // Each item is 100% / visibleItems wide
            const itemWidthPercent = 100 / visibleItems;
            const translatePercent = -(currentSlide * itemWidthPercent);
            carouselTrack.style.transform = `translateX(${translatePercent}%)`;
        }

        // Move to next slide (infinite loop) - moves by 1 item
        function nextSlide() {
            if (isTransitioning || totalItems === 0) return;
            
            // Don't auto-rotate if all items are visible
            if (totalItems <= visibleItems) return;
            
            isTransitioning = true;
            currentSlide++;
            
            updateCarouselPosition(true);
            
            setTimeout(() => {
                // If we've moved past the second set of items (in cloned section at end)
                if (currentSlide >= totalItems * 2) {
                    currentSlide = totalItems;
                    updateCarouselPosition(false);
                }
                isTransitioning = false;
            }, 500);
        }

        // Move to previous slide (infinite loop) - moves by 1 item
        function prevSlide() {
            if (isTransitioning || totalItems === 0) return;
            
            // Don't navigate if all items are visible
            if (totalItems <= visibleItems) return;
            
            isTransitioning = true;
            currentSlide--;
            
            updateCarouselPosition(true);
            
            setTimeout(() => {
                // If we've moved before the first set (in cloned section at start)
                if (currentSlide < totalItems) {
                    currentSlide = totalItems * 2 - 1;
                    updateCarouselPosition(false);
                }
                isTransitioning = false;
            }, 500);
        }

        // Start auto rotation
        function startAutoRotate() {
            // Only auto-rotate if we have more items than visible
            if (totalItems <= visibleItems) return;
            
            stopAutoRotate();
            autoRotateInterval = setInterval(nextSlide, rotateInterval);
        }

        // Stop auto rotation
        function stopAutoRotate() {
            if (autoRotateInterval) {
                clearInterval(autoRotateInterval);
                autoRotateInterval = null;
            }
        }

        // Event listeners with proper event handling
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (isTransitioning) return;
            stopAutoRotate();
            prevSlide();
            startAutoRotate();
        });

        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (isTransitioning) return;
            stopAutoRotate();
            nextSlide();
            startAutoRotate();
        });

        // Pause on hover
        carouselWrapper.addEventListener('mouseenter', stopAutoRotate);
        carouselWrapper.addEventListener('mouseleave', startAutoRotate);

        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                stopAutoRotate();
                const oldVisibleItems = visibleItems;
                calculateVisibleItems();
                
                // Reset position if visible items changed
                if (oldVisibleItems !== visibleItems) {
                    cloneItemsForInfiniteLoop();
                    updateCarouselPosition(false);
                }
                
                startAutoRotate();
            }, 250);
        });

        // Initialize this carousel
        cloneItemsForInfiniteLoop();
        updateCarouselPosition(false);
        startAutoRotate();
    }

})();

