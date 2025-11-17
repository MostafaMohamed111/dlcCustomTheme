/**
 * Main Theme Script - Mobile Menu Toggle and Scroll Lock
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile Menu Toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navRight = document.querySelector('.nav-right');
    const body = document.body;
    
    if (mobileToggle && navRight) {
        // Close menu on page load (in case it was open from previous page)
        mobileToggle.classList.remove('active');
        navRight.classList.remove('active');
        body.style.overflow = '';
        
        mobileToggle.addEventListener('click', function() {
            const isActive = mobileToggle.classList.toggle('active');
            navRight.classList.toggle('active');
            
            // Disable/enable scroll when menu is open/closed
            if (isActive) {
                body.style.overflow = 'hidden';
            } else {
                body.style.overflow = '';
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!navRight.contains(event.target) && !mobileToggle.contains(event.target)) {
                if (navRight.classList.contains('active')) {
                    mobileToggle.classList.remove('active');
                    navRight.classList.remove('active');
                    body.style.overflow = '';
                }
            }
        });
    }

});

// Function to open/toggle mobile nav (used in header.php)
function toggleMobileNav() {
    const mobileNav = document.querySelector('.mobile-nav');
    const body = document.body;
    
    if (mobileNav) {
        // Add active class to trigger slide-in animation
        mobileNav.classList.add('active');
        // Disable body scroll
        body.style.overflow = 'hidden';
    }
}

// Function to close mobile nav (used in header.php)
function closeMobileNav() {
    const mobileNav = document.querySelector('.mobile-nav');
    const body = document.body;
    
    if (mobileNav) {
        // Remove active class to trigger slide-out animation
        mobileNav.classList.remove('active');
        // Re-enable body scroll
        body.style.overflow = '';
    }
}

// Ensure mobile nav is closed on page load (no animation on page changes)
window.addEventListener('DOMContentLoaded', function() {
    const mobileNav = document.querySelector('.mobile-nav');
    const body = document.body;
    
    if (mobileNav) {
        // Remove any active state without animation
        mobileNav.style.transition = 'none';
        mobileNav.classList.remove('active');
        body.style.overflow = '';
        
        // Re-enable transition after a brief moment
        setTimeout(function() {
            mobileNav.style.transition = '';
        }, 50);
    }
});

// Values Carousel
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('valuesCarousel');
    const wrapper = carousel ? carousel.closest('.values-carousel-wrapper') : null;
    const indicators = document.querySelectorAll('.indicator');
    const prevBtn = document.getElementById('carouselPrev');
    const nextBtn = document.getElementById('carouselNext');
    let currentSlide = 0;
    let carouselInterval;

    if (!carousel || indicators.length === 0) return;

    const totalSlides = carousel.children.length;
    const isRTL = document.documentElement.dir === 'rtl';

    function showSlide(index) {
        const direction = isRTL ? '' : '-';
        carousel.style.transform = `translateX(${direction}${index * 100}%)`;
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('active', i === index);
        });
        currentSlide = index;
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }

    function startCarousel() {
        stopCarousel();
        carouselInterval = setInterval(nextSlide, 3000);
    }

    function stopCarousel() {
        if (carouselInterval) {
            clearInterval(carouselInterval);
            carouselInterval = null;
        }
    }

    // Navigation arrows
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            stopCarousel();
            nextSlide();
            startCarousel();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            stopCarousel();
            prevSlide();
            startCarousel();
        });
    }

    // Indicator navigation
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function() {
            stopCarousel();
            showSlide(index);
            startCarousel();
        });
    });

    // Stop on hover (entire wrapper)
    if (wrapper) {
        wrapper.addEventListener('mouseenter', stopCarousel);
        wrapper.addEventListener('mouseleave', startCarousel);
    }

    // Initialize first slide
    showSlide(0);
    startCarousel();
});

// Achievements Counter Animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.achievement-number');
    
    if (counters.length === 0) return;
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString();
            }
        };
        
        updateCounter();
    };
    
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                if (!counter.classList.contains('animated')) {
                    counter.classList.add('animated');
                    animateCounter(counter);
                }
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
});

// Categories Dropdown Toggle
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.categories-dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.closest('.categories-dropdown');
            dropdown.classList.toggle('active');
        });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.categories-dropdown')) {
            document.querySelectorAll('.categories-dropdown').forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });
});