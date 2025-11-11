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

