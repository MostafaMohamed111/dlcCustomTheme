/**
 * International Page JavaScript
 * Handles interactive elements like FAQ accordion
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const faqItems = document.querySelectorAll('.faq-item');
        
        if (faqItems.length === 0) return;

        faqItems.forEach(function(item) {
            const question = item.querySelector('.faq-question');
            
            if (!question) return;

            question.addEventListener('click', function() {
                // Toggle active class on clicked item
                const isActive = item.classList.contains('active');
                
                // Close all other items (optional: remove if you want multiple open)
                faqItems.forEach(function(otherItem) {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });
                
                // Toggle current item
                if (isActive) {
                    item.classList.remove('active');
                } else {
                    item.classList.add('active');
                }
            });
        });

        // Optional: Keyboard navigation support
        faqItems.forEach(function(item) {
            const question = item.querySelector('.faq-question');
            
            if (!question) return;

            question.setAttribute('tabindex', '0');
            question.setAttribute('role', 'button');
            question.setAttribute('aria-expanded', 'false');
            
            question.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    question.click();
                }
            });
        });

        // Update aria-expanded when items are toggled
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const item = mutation.target;
                    const question = item.querySelector('.faq-question');
                    if (question) {
                        const isActive = item.classList.contains('active');
                        question.setAttribute('aria-expanded', isActive ? 'true' : 'false');
                    }
                }
            });
        });

        faqItems.forEach(function(item) {
            observer.observe(item, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    });

})();

