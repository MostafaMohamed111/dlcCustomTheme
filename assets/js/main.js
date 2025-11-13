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