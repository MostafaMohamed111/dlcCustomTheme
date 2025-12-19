/**
 * Browser Translation Detector
 * Detects when the page has been translated by the browser and redirects to the appropriate Polylang language
 */
(function() {
    'use strict';

    // Don't run if lang_override is set
    if (window.location.search.indexOf('lang_override=1') !== -1) {
        return;
    }

    // Don't run if Polylang URLs aren't available
    if (typeof polylangUrls === 'undefined') {
        return;
    }

    /**
     * Detect if page has been translated by browser
     * Checks for translation indicators added by Chrome, Firefox, Edge, etc.
     */
    function detectBrowserTranslation() {
        var html = document.documentElement;
        var body = document.body;
        
        // Chrome/Edge translation detection
        if (html.classList.contains('translated-ltr') || 
            html.classList.contains('translated-rtl') ||
            html.hasAttribute('translate')) {
            return getTranslatedLanguage();
        }
        
        // Check for Google Translate elements
        var gtElements = document.querySelectorAll('.goog-te-banner-frame, .skiptranslate, font[class^="goog-"]');
        if (gtElements.length > 0) {
            return getTranslatedLanguage();
        }
        
        // Check for translation meta tags
        var translatedMeta = document.querySelector('meta[name="google"][content="notranslate"]');
        if (translatedMeta && html.lang !== document.documentElement.getAttribute('lang')) {
            return getTranslatedLanguage();
        }
        
        return null;
    }

    /**
     * Try to determine the target translation language
     */
    function getTranslatedLanguage() {
        var html = document.documentElement;
        
        // Check html lang attribute (browsers often update this)
        var htmlLang = html.getAttribute('lang') || html.lang;
        if (htmlLang) {
            var langCode = htmlLang.split('-')[0].toLowerCase();
            
            // If translated to Arabic and we have an Arabic URL, redirect
            if (langCode === 'ar' && polylangUrls.ar) {
                return 'ar';
            }
            // If translated to English and we have an English URL, redirect
            if (langCode === 'en' && polylangUrls.en) {
                return 'en';
            }
        }
        
        // Check text direction as fallback (some browsers change only dir, not lang)
        var textDirection = html.getAttribute('dir') || html.dir;
        if (textDirection === 'rtl' && polylangUrls.ar) {
            return 'ar';
        }
        if (textDirection === 'ltr' && polylangUrls.en) {
            return 'en';
        }
        
        // Check browser language as final fallback
        var browserLang = (navigator.language || navigator.userLanguage || '').split('-')[0].toLowerCase();
        if (browserLang === 'ar' && polylangUrls.ar) {
            return 'ar';
        }
        
        return null;
    }

    /**
     * Redirect to the appropriate Polylang language URL
     */
    function redirectToPolylangUrl(targetLang) {
        if (!targetLang || !polylangUrls[targetLang]) {
            return;
        }
        
        // Skip if already on the target URL (avoid redundant reload)
        var currentUrl = window.location.href.split('?')[0].split('#')[0]; // Remove query/hash
        var targetUrl = polylangUrls[targetLang].split('?')[0].split('#')[0];
        if (currentUrl === targetUrl) {
            return;
        }
        
        // Set cookie to remember language preference (matching PHP format)
        var expires = new Date();
        expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000)); // 1 year
        var cookieStr = 'pll_language=' + targetLang + 
                        '; expires=' + expires.toUTCString() + 
                        '; path=/' +
                        '; SameSite=Lax';
        
        // Add domain if available from Polylang config
        if (typeof polylangConfig !== 'undefined' && polylangConfig.cookieDomain) {
            cookieStr += '; domain=' + polylangConfig.cookieDomain;
        }
        
        document.cookie = cookieStr;
        
        // Redirect to the Polylang URL
        window.location.href = polylangUrls[targetLang];
    }

    /**
     * Main detection logic
     * Runs after DOM is loaded and checks periodically for translation changes
     */
    function init() {
        // Initial check
        var translatedLang = detectBrowserTranslation();
        if (translatedLang) {
            redirectToPolylangUrl(translatedLang);
            return;
        }
        
        // Monitor for translation changes (browser translation can happen after page load)
        var checkCount = 0;
        var maxChecks = 10; // Check up to 10 times (5 seconds)
        
        var translationCheck = setInterval(function() {
            checkCount++;
            
            var detectedLang = detectBrowserTranslation();
            if (detectedLang) {
                clearInterval(translationCheck);
                redirectToPolylangUrl(detectedLang);
            }
            
            // Stop checking after max attempts
            if (checkCount >= maxChecks) {
                clearInterval(translationCheck);
            }
        }, 500); // Check every 500ms
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
