/**
 * Scroll Animation Script - Triggers animations when elements come into view
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Create an Intersection Observer
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1 // Trigger when 10% of element is visible
    };

    const observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Add animate class when element comes into view
                entry.target.classList.add('animate');
                
                // Optional: Stop observing after animation triggers (animation happens once)
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Select all elements to animate
    const animatedElements = document.querySelectorAll(
        '.section-header, .about-text, .about-image, .stat-item, .parallax-divider, .service-card'
    );

    // Observe each element
    animatedElements.forEach(element => {
        observer.observe(element);
    });

});
