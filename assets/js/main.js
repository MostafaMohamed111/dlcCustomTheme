/**
 * Main Theme Script - Mobile Menu Toggle and Scroll Lock
 */

// Mobile Nav Toggle (used in header.php and header-ar.php)
function toggleMobileNav() {
    const mobileNav = document.querySelector('.mobile-nav');
    const body = document.body;
    const html = document.documentElement;
    
    if (mobileNav) {
        const isActive = mobileNav.classList.contains('active');
        
        if (isActive) {
            // Close nav
            mobileNav.classList.remove('active');
            // Restore scroll position
            const scrollY = body.style.top;
            body.style.position = '';
            body.style.top = '';
            body.style.overflow = '';
            body.style.width = '';
            html.style.overflow = '';
            
            if (scrollY) {
                window.scrollTo(0, parseInt(scrollY || '0') * -1);
            }
        } else {
            // Open nav
            mobileNav.classList.add('active');
            // Store current scroll position
            const scrollY = window.scrollY;
            // Disable scrolling
            body.style.position = 'fixed';
            body.style.top = `-${scrollY}px`;
            body.style.width = '100%';
            body.style.overflow = 'hidden';
            html.style.overflow = 'hidden';
        }
    }
}

// Function to close mobile nav (used in header.php and header-ar.php)
function closeMobileNav() {
    const mobileNav = document.querySelector('.mobile-nav');
    const body = document.body;
    const html = document.documentElement;
    
    if (mobileNav) {
        // Remove active class to trigger slide-out animation
        mobileNav.classList.remove('active');
        
        // Restore scroll position
        const scrollY = body.style.top;
        body.style.position = '';
        body.style.top = '';
        body.style.overflow = '';
        body.style.width = '';
        html.style.overflow = '';
        
        if (scrollY) {
            window.scrollTo(0, parseInt(scrollY || '0') * -1);
        }
    }
}

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

    // Reset transform to show first slide initially
    carousel.style.transform = 'translateX(0)';

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
        // For RTL, auto-slide should go backwards (prevSlide)
        if (isRTL) {
            carouselInterval = setInterval(prevSlide, 3000);
        } else {
            carouselInterval = setInterval(nextSlide, 3000);
        }
    }

    function stopCarousel() {
        if (carouselInterval) {
            clearInterval(carouselInterval);
            carouselInterval = null;
        }
    }

    // Navigation arrows (reversed for RTL)
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            stopCarousel();
            if (isRTL) {
                prevSlide();
            } else {
                nextSlide();
            }
            startCarousel();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            stopCarousel();
            if (isRTL) {
                nextSlide();
            } else {
                prevSlide();
            }
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

// Dropdown Management - Unified handler for all dropdowns
document.addEventListener('DOMContentLoaded', function() {
    // Helper: Close all dropdowns of a specific type
    const closeDropdowns = (selector) => {
        document.querySelectorAll(selector).forEach(el => el.classList.remove('active'));
    };
    
    // Helper: Setup dropdown toggle
    const setupDropdown = (parentSelector, toggleSelector, closeOthers = false) => {
        document.querySelectorAll(parentSelector).forEach(parent => {
            const toggle = toggleSelector ? parent.querySelector(toggleSelector) : parent.querySelector('[class*="toggle"]');
            if (!toggle) return;
            
            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                if (closeOthers) {
                    document.querySelectorAll(parentSelector).forEach(other => {
                        if (other !== parent) other.classList.remove('active');
                    });
                }
                parent.classList.toggle('active');
            });
        });
    };
    
    // Setup all dropdown types
    setupDropdown('.categories-dropdown', '.categories-dropdown-toggle');
    setupDropdown('.sign-in-dropdown', '.sign-in-toggle', true);
    
    // Categories widget (legacy)
    const categoriesToggle = document.querySelector('.categories-toggle-btn');
    const categoriesWidget = document.querySelector('.categories-widget');
    if (categoriesToggle && categoriesWidget) {
        categoriesToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            categoriesWidget.classList.toggle('active');
        });
    }
    
    // Global click handler to close all dropdowns
    document.addEventListener('click', () => {
        closeDropdowns('.categories-dropdown');
        closeDropdowns('.sign-in-dropdown');
        if (categoriesWidget) categoriesWidget.classList.remove('active');
    });
});

// Comments AJAX and View All
document.addEventListener('DOMContentLoaded', function() {
    // View All Comments Button
    const viewAllBtn = document.querySelector('.view-all-comments-btn');
    const hideCommentsBtn = document.querySelector('.hide-comments-btn');
    
    if (viewAllBtn) {
        viewAllBtn.addEventListener('click', function() {
            const hiddenList = document.querySelector('.comment-list-hidden');
            if (hiddenList) {
                hiddenList.style.display = 'block';
                viewAllBtn.style.display = 'none';
                if (hideCommentsBtn) {
                    hideCommentsBtn.style.display = 'block';
                }
                // Scroll to show new comments
                hiddenList.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    }
    
    // Hide Comments Button
    if (hideCommentsBtn) {
        hideCommentsBtn.addEventListener('click', function() {
            const hiddenList = document.querySelector('.comment-list-hidden');
            if (hiddenList) {
                hiddenList.style.display = 'none';
                hideCommentsBtn.style.display = 'none';
                if (viewAllBtn) {
                    viewAllBtn.style.display = 'block';
                }
                // Scroll back to view all button
                if (viewAllBtn) {
                    viewAllBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }

    // AJAX Comment Form Submission - Prevent page reload
    const commentForm = document.getElementById('commentform');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(commentForm);
            const submitBtn = commentForm.querySelector('#submit');
            const originalText = submitBtn ? submitBtn.value : 'Comment';
            
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.value = 'Submitting...';
            }
            
            // Use WordPress comment form action URL
            const actionUrl = commentForm.action;
            
            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok');
            })
            .then(data => {
                // Reset form
                commentForm.reset();
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.value = originalText;
                }
                
                // Show success message
                const successMsg = document.createElement('div');
                successMsg.className = 'comment-success';
                successMsg.style.cssText = 'background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin: 15px 0;';
                successMsg.textContent = 'Your comment is awaiting moderation.';
                commentForm.parentNode.insertBefore(successMsg, commentForm);
                
                setTimeout(() => {
                    successMsg.remove();
                }, 5000);
            })
            .catch(error => {
                console.error('Error:', error);
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.value = originalText;
                }
                alert('There was an error submitting your comment. Please try again.');
            });
        });
    }

    // AJAX Reply Links
    document.addEventListener('click', function(e) {
        if (e.target.closest('.comment-reply-link')) {
            e.preventDefault();
            const replyLink = e.target.closest('.comment-reply-link');
            const commentId = replyLink.getAttribute('data-commentid');
            const respondId = replyLink.getAttribute('data-respond-id');
            
            // Scroll to comment form
            const commentForm = document.getElementById('commentform');
            if (commentForm) {
                commentForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Set parent comment ID if reply form exists
                const commentParent = document.getElementById('comment_parent');
                if (commentParent) {
                    commentParent.value = commentId;
                }
                
                // Focus on comment textarea
                const commentTextarea = document.getElementById('comment');
                if (commentTextarea) {
                    setTimeout(() => {
                        commentTextarea.focus();
                    }, 300);
                }
            }
        }
    });
});

// WhatsApp Floating Action Button Toggle
document.addEventListener('DOMContentLoaded', function() {
    const whatsappContainer = document.querySelector('.whatsapp-floating-container');
    const whatsappMainBtn = document.querySelector('.whatsapp-main-btn');
    
    if (!whatsappContainer || !whatsappMainBtn) return;
    
    // Toggle active state on main button click
    whatsappMainBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        whatsappContainer.classList.toggle('active');
        const isActive = whatsappContainer.classList.contains('active');
        whatsappMainBtn.setAttribute('aria-expanded', isActive);
    });
    
    // Close when clicking outside
    document.addEventListener('click', function(e) {
        if (!whatsappContainer.contains(e.target)) {
            whatsappContainer.classList.remove('active');
            whatsappMainBtn.setAttribute('aria-expanded', 'false');
        }
    });
    
    // Close when clicking on action buttons (they handle their own navigation)
    const actionButtons = whatsappContainer.querySelectorAll('.whatsapp-action-btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Small delay to allow navigation, then close
            setTimeout(() => {
                whatsappContainer.classList.remove('active');
                whatsappMainBtn.setAttribute('aria-expanded', 'false');
            }, 300);
        });
    });
});