/**
 * Google Tag Manager Event Tracking
 * Handles all dataLayer events for GTM integration
 * Language-agnostic tracking for both Arabic and English pages
 */

(function() {
    'use strict';

    // Ensure dataLayer exists
    window.dataLayer = window.dataLayer || [];

    /**
     * Push event to dataLayer
     * @param {string} eventName - The event name to track
     * @param {object} eventData - Additional event data (optional)
     */
    function pushToDataLayer(eventName, eventData = {}) {
        window.dataLayer.push({
            'event': eventName,
            ...eventData
        });
        
        // Debug log (can be removed in production)
        console.log('GTM Event:', eventName, eventData);
    }

    /**
     * Track WhatsApp clicks
     * Tracks any link containing 'wa.me' or 'api.whatsapp.com'
     */
    function trackWhatsAppClicks() {
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            
            if (!link) return;
            
            const href = link.getAttribute('href') || '';
            
            // Check if it's a WhatsApp link
            if (href.includes('wa.me') || href.includes('api.whatsapp.com')) {
                pushToDataLayer('whatsapp_click', {
                    'link_url': href,
                    'link_text': link.textContent.trim(),
                    'link_classes': link.className
                });
            }
        });
    }

    /**
     * Track phone call clicks
     * Tracks any link starting with 'tel:'
     */
    function trackPhoneClicks() {
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            
            if (!link) return;
            
            const href = link.getAttribute('href') || '';
            
            // Check if it's a phone link
            if (href.startsWith('tel:')) {
                const phoneNumber = href.replace('tel:', '');
                
                pushToDataLayer('phone_call', {
                    'phone_number': phoneNumber,
                    'link_text': link.textContent.trim(),
                    'link_classes': link.className
                });
            }
        });
    }

    /**
     * Initialize all tracking
     */
    function initTracking() {
        trackWhatsAppClicks();
        trackPhoneClicks();
        
        // Make pushToDataLayer available globally for form tracking
        window.dlcPushToDataLayer = pushToDataLayer;
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTracking);
    } else {
        initTracking();
    }

})();
