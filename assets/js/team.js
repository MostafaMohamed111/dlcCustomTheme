/**
 * Team Carousel JavaScript
 * Auto-rotating carousel showing 3 team member cards at a time
 * Infinite loop with smooth transitions and touch/drag support
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const carouselWrapper = document.querySelector('.team-carousel-wrapper');
        if (!carouselWrapper) return;

        const carouselTrack = carouselWrapper.querySelector('.team-carousel-track');
        const carouselContainer = carouselWrapper.querySelector('.team-carousel-container');
        const prevBtn = carouselWrapper.querySelector('.team-carousel-prev');
        const nextBtn = carouselWrapper.querySelector('.team-carousel-next');
        const indicatorsContainer = carouselWrapper.querySelector('.team-carousel-indicators');
        
        if (!carouselTrack || !prevBtn || !nextBtn || !indicatorsContainer) return;

        const cards = Array.from(carouselTrack.querySelectorAll('.team-card'));
        const totalCards = cards.length;
        
        if (totalCards === 0) return;

        let currentIndex = 0;
        let visibleCards = 3;
        let autoRotateInterval = null;
        const rotateInterval = 5000; // 5 seconds
        let isTransitioning = false;
        
        // Drag/Swipe support
        let isDragging = false;
        let startPos = 0;
        let currentTranslate = 0;
        let prevTranslate = 0;
        let animationID = 0;

        // Calculate visible cards based on screen size
        function calculateVisibleCards() {
            const width = window.innerWidth;
            if (width <= 768) {
                visibleCards = 1;
            } else if (width <= 992) {
                visibleCards = 2;
            } else {
                visibleCards = 3;
            }
        }

        // Initialize visible cards calculation
        calculateVisibleCards();

        // Clone cards for infinite loop if we have more than visibleCards
        function cloneCardsForInfiniteLoop() {
            // Remove any existing clones first
            carouselTrack.querySelectorAll('.team-card.clone').forEach(el => el.remove());
            
            // Only clone if we have more cards than visible
            if (totalCards > visibleCards) {
                // Clone enough cards for smooth infinite scrolling
                const clonesToAdd = visibleCards;
                
                // Clone first cards and append to end
                for (let i = 0; i < clonesToAdd; i++) {
                    const clone = cards[i].cloneNode(true);
                    clone.classList.add('clone');
                    carouselTrack.appendChild(clone);
                }
                
                // Clone last cards and prepend to beginning
                for (let i = 0; i < clonesToAdd; i++) {
                    const clone = cards[totalCards - 1 - i].cloneNode(true);
                    clone.classList.add('clone');
                    carouselTrack.insertBefore(clone, carouselTrack.firstChild);
                }
                
                // Set initial position to account for prepended clones
                currentIndex = clonesToAdd;
                updateCarouselPosition(false);
            }
        }

        // Calculate total slides
        function getTotalSlides() {
            return Math.ceil(totalCards / visibleCards);
        }

        // Create indicators
        function createIndicators() {
            indicatorsContainer.innerHTML = '';
            const totalSlides = getTotalSlides();
            
            for (let i = 0; i < totalSlides; i++) {
                const indicator = document.createElement('button');
                indicator.className = 'indicator';
                if (i === 0) indicator.classList.add('active');
                indicator.setAttribute('aria-label', `Go to slide ${i + 1}`);
                indicator.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (isTransitioning) return;
                    stopAutoRotate();
                    goToSlide(i);
                    startAutoRotate();
                });
                indicatorsContainer.appendChild(indicator);
            }
        }

        // Update indicators
        function updateIndicators() {
            const indicators = indicatorsContainer.querySelectorAll('.indicator');
            const totalSlides = getTotalSlides();
            
            // Calculate actual position (accounting for clones)
            let actualIndex = currentIndex;
            if (totalCards > visibleCards) {
                actualIndex = currentIndex - visibleCards;
            }
            
            const currentSlide = Math.floor(actualIndex / visibleCards);
            const normalizedSlide = ((currentSlide % totalSlides) + totalSlides) % totalSlides;
            
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === normalizedSlide);
            });
        }

        // Update carousel position
        function updateCarouselPosition(smooth = true) {
            if (!smooth) {
                carouselTrack.style.transition = 'none';
            } else {
                carouselTrack.style.transition = 'transform 0.5s ease-in-out';
            }
            
            // Calculate percentage based on visible cards
            const cardWidth = 100 / visibleCards;
            const translateX = -(currentIndex * cardWidth);
            carouselTrack.style.transform = `translateX(${translateX}%)`;
        }

        // Move to next slide (infinite loop)
        function nextSlide() {
            if (isTransitioning) return;
            
            isTransitioning = true;
            currentIndex++;
            
            updateCarouselPosition(true);
            updateIndicators();
            
            // Check if we need to reset position (after transition completes)
            if (totalCards > visibleCards) {
                setTimeout(() => {
                    // If we're past the actual cards (in the cloned section)
                    if (currentIndex >= totalCards + visibleCards) {
                        currentIndex = visibleCards;
                        updateCarouselPosition(false);
                    }
                    isTransitioning = false;
                }, 500);
            } else {
                // No infinite loop for few cards
                if (currentIndex >= totalCards) {
                    currentIndex = 0;
                }
                setTimeout(() => {
                    isTransitioning = false;
                }, 500);
            }
        }

        // Move to previous slide (infinite loop)
        function prevSlide() {
            if (isTransitioning) return;
            
            isTransitioning = true;
            currentIndex--;
            
            updateCarouselPosition(true);
            updateIndicators();
            
            // Check if we need to reset position (after transition completes)
            if (totalCards > visibleCards) {
                setTimeout(() => {
                    // If we're before the actual cards (in the cloned section)
                    if (currentIndex < visibleCards) {
                        currentIndex = totalCards + visibleCards - 1;
                        updateCarouselPosition(false);
                    }
                    isTransitioning = false;
                }, 500);
            } else {
                // No infinite loop for few cards
                if (currentIndex < 0) {
                    currentIndex = totalCards - 1;
                }
                setTimeout(() => {
                    isTransitioning = false;
                }, 500);
            }
        }

        // Move carousel to specific slide
        function goToSlide(slideIndex) {
            if (isTransitioning) return;
            
            isTransitioning = true;
            const totalSlides = getTotalSlides();
            
            // Normalize slide index
            if (slideIndex < 0) {
                slideIndex = totalSlides - 1;
            } else if (slideIndex >= totalSlides) {
                slideIndex = 0;
            }
            
            // Account for cloned cards if infinite loop is enabled
            if (totalCards > visibleCards) {
                currentIndex = visibleCards + (slideIndex * visibleCards);
            } else {
                currentIndex = slideIndex * visibleCards;
                
                // Ensure we don't go beyond available cards
                if (currentIndex + visibleCards > totalCards) {
                    currentIndex = Math.max(0, totalCards - visibleCards);
                }
            }
            
            updateCarouselPosition(true);
            updateIndicators();
            
            setTimeout(() => {
                isTransitioning = false;
            }, 500);
        }

        // Start auto rotation
        function startAutoRotate() {
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
                const oldVisibleCards = visibleCards;
                calculateVisibleCards();
                
                // Reset position if visible cards changed
                if (oldVisibleCards !== visibleCards) {
                    cloneCardsForInfiniteLoop();
                    createIndicators();
                    updateCarouselPosition(false);
                    updateIndicators();
                }
                
                startAutoRotate();
            }, 250);
        });

        // Initialize
        cloneCardsForInfiniteLoop();
        createIndicators();
        updateCarouselPosition(false);
        updateIndicators();
        startAutoRotate();
    });

})();
