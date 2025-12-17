/**
 * Booking Form JavaScript
 */

(function($) {
    'use strict';

    let currentPhase = 1;
    let serviceType = '';
    let services = [];
    let preselectedServiceId = null;

    // Initialize
    $(document).ready(function() {
        // Check if service ID is in URL
        const urlParams = new URLSearchParams(window.location.search);
        preselectedServiceId = urlParams.get('service');
        
        // If service is preselected, auto-load and bypass service type selection
        if (preselectedServiceId) {
            // Hide service selection immediately and keep it hidden
            $('#service-type-selection').removeClass('active').hide();
            $('#booking-form-container').addClass('active');
            detectAndLoadServiceType(preselectedServiceId);
        }
        
        // Service type selection
        $('.service-type-btn').on('click', function() {
            serviceType = $(this).data('type');
            $('#service_type').val(serviceType);
            
            // Hide service selection, show form
            $('#service-type-selection').removeClass('active');
            $('#booking-form-container').addClass('active');
            
            // Load services for selected type
            loadServices(serviceType);
        });

        // Form submission
        $('#booking-form').on('submit', function(e) {
            e.preventDefault();
            submitBookingForm();
        });

        // Real-time validation
        $('#booking-form input, #booking-form select, #booking-form textarea').on('blur', function() {
            validateField($(this));
        });

        // Clear radio button errors on change
        $('#booking-form input[type="radio"]').on('change', function() {
            const formGroup = $(this).closest('.form-group');
            formGroup.removeClass('error');
            formGroup.find('.form-error').remove();
            
            // Update radio label styling
            const name = $(this).attr('name');
            $(`.radio-label input[name="${name}"]`).closest('.radio-label').removeClass('checked');
            $(this).closest('.radio-label').addClass('checked');
        });
    });

    /**
     * Detect service type from preselected service and auto-load form
     */
    function detectAndLoadServiceType(serviceId) {
        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_service_type',
                service_id: serviceId
            },
            success: function(response) {
                if (response.success && response.data.service_type) {
                    serviceType = response.data.service_type;
                    $('#service_type').val(serviceType);
                    
                    // Load services for the detected type
                    loadServices(serviceType);
                } else {
                    // If detection fails, keep form visible but show error in service dropdown
                    // Don't show service selection if we came from a service link
                    if (preselectedServiceId) {
                        const serviceSelect = $('#service');
                        const language = typeof bookingLanguage !== 'undefined' ? bookingLanguage : 'en';
                        const errorText = language === 'ar' ? 'خطأ في تحميل الخدمة' : 'Error loading service';
                        serviceSelect.html(`<option value="">${errorText}</option>`);
                    } else {
                        // Only show service selection if we didn't come from a service link
                    $('#booking-form-container').removeClass('active');
                        $('#service-type-selection').addClass('active').show();
                    }
                }
            },
            error: function() {
                // On error, keep form visible but show error if we came from service link
                if (preselectedServiceId) {
                    const serviceSelect = $('#service');
                    const language = typeof bookingLanguage !== 'undefined' ? bookingLanguage : 'en';
                    const errorText = language === 'ar' ? 'خطأ في تحميل الخدمة' : 'Error loading service';
                    serviceSelect.html(`<option value="">${errorText}</option>`);
                } else {
                    // Only show service selection if we didn't come from a service link
                $('#booking-form-container').removeClass('active');
                    $('#service-type-selection').addClass('active').show();
                }
            }
        });
    }

    /**
     * Load services based on service type
     */
    function loadServices(type) {
        const serviceSelect = $('#service');
        const language = typeof bookingLanguage !== 'undefined' ? bookingLanguage : 'en';
        const loadingText = language === 'ar' ? 'جاري تحميل الخدمات...' : 'Loading services...';
        const selectText = language === 'ar' ? 'اختر خدمة' : 'Select a service';
        const noServicesText = language === 'ar' ? 'لا توجد خدمات متاحة' : 'No services available';
        const errorText = language === 'ar' ? 'خطأ في تحميل الخدمات. يرجى تحديث الصفحة.' : 'Error loading services. Please refresh the page.';
        
        serviceSelect.html(`<option value="">${loadingText}</option>`);
        serviceSelect.prop('disabled', true);

        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_booking_services',
                service_type: type,
                language: language,
                security: $('#booking-form input[name="security"]').val()
            },
            success: function(response) {
                serviceSelect.prop('disabled', false);
                
                if (response.success && response.data && response.data.length > 0) {
                    serviceSelect.html(`<option value=\"\">${selectText}</option>`);
                    $.each(response.data, function(index, service) {
                        serviceSelect.append(
                            $('<option></option>')
                                .attr('value', service.id)
                                .attr('data-slug', service.slug)
                                .text(service.title)
                        );
                    });
                    services = response.data;
                    
                    // Auto-select preselected service if exists
                    if (preselectedServiceId) {
                        serviceSelect.val(preselectedServiceId);
                        preselectedServiceId = null; // Clear after use
                    }
                } else {
                    serviceSelect.html(`<option value=\"\">${noServicesText}</option>`);
                }
            },
            error: function() {
                serviceSelect.prop('disabled', false);
                serviceSelect.html(`<option value="">${errorText}</option>`);
            }
        });
    }

    /**
     * Navigate to next phase
     */
    window.nextPhase = function() {
        const currentPhaseElement = $(`.form-phase[data-phase="${currentPhase}"]`);
        
        // Validate current phase
        if (!validatePhase(currentPhase)) {
            return;
        }

        // Hide current phase
        currentPhaseElement.removeClass('active');
        
        // Update progress steps
        $(`.step-item[data-step="${currentPhase}"]`).removeClass('active');
        
        // Move to next phase
        currentPhase++;
        $(`.form-phase[data-phase="${currentPhase}"]`).addClass('active');
        $(`.step-item[data-step="${currentPhase}"]`).addClass('active');
        
        // Scroll to top of form
        $('.form-sector').animate({
            scrollTop: 0
        }, 300);
    };

    /**
     * Navigate to previous phase
     */
    window.prevPhase = function() {
        if (currentPhase <= 1) return;

        // Hide current phase
        $(`.form-phase[data-phase="${currentPhase}"]`).removeClass('active');
        
        // Update progress steps
        $(`.step-item[data-step="${currentPhase}"]`).removeClass('active');
        
        // Move to previous phase
        currentPhase--;
        $(`.form-phase[data-phase="${currentPhase}"]`).addClass('active');
        $(`.step-item[data-step="${currentPhase}"]`).addClass('active');
        
        // Scroll to top of form
        $('.form-sector').animate({
            scrollTop: 0
        }, 300);
    };

    /**
     * Go back to service type selection
     */
    window.goBackToServiceSelection = function() {
        // Hide form container
        $('#booking-form-container').removeClass('active');
        
        // Show service type selection
        $('#service-type-selection').addClass('active');
        
        // Reset form phase to 1
        currentPhase = 1;
        $('.form-phase').removeClass('active');
        $('.form-phase[data-phase="1"]').addClass('active');
        
        // Reset progress steps
        $('.step-item').removeClass('active');
        $('.step-item[data-step="1"]').addClass('active');
        
        // Scroll to top
        $('.form-sector').animate({
            scrollTop: 0
        }, 300);
    };

    /**
     * Validate a specific phase
     */
    function validatePhase(phase) {
        const phaseElement = $(`.form-phase[data-phase="${phase}"]`);
        let isValid = true;

        // Get all required fields in this phase
        phaseElement.find('input[required], select[required], textarea[required]').each(function() {
            const field = $(this);
            if (!validateField(field)) {
                isValid = false;
            }
        });

        // Check radio buttons
        phaseElement.find('input[type="radio"][required]').each(function() {
            const name = $(this).attr('name');
            if (!$(`input[name="${name}"]:checked`).length) {
                const group = $(this).closest('.form-group');
                group.addClass('error');
                if (!group.find('.form-error').length) {
                    group.append('<span class="form-error">This field is required</span>');
                }
                isValid = false;
            }
        });

        return isValid;
    }

    /**
     * Validate a single field
     */
    function validateField(field) {
        const formGroup = field.closest('.form-group');
        formGroup.removeClass('error');
        formGroup.find('.form-error').remove();

        let isValid = true;
        const value = field.val().trim();

        // Check if required
        if (field.prop('required') && !value) {
            isValid = false;
        }

        // Email validation
        if (field.attr('type') === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                formGroup.append('<span class="form-error">Please enter a valid email address</span>');
            }
        }

        // Phone validation (basic)
        if (field.attr('type') === 'tel' && value) {
            const phoneRegex = /^[0-9\s\-\+\(\)]+$/;
            if (!phoneRegex.test(value) || value.length < 8) {
                isValid = false;
                formGroup.append('<span class="form-error">Please enter a valid phone number</span>');
            }
        }

        if (!isValid) {
            formGroup.addClass('error');
            if (!formGroup.find('.form-error').length) {
                formGroup.append('<span class="form-error">This field is required</span>');
            }
        }

        return isValid;
    }

    /**
     * Submit booking form
     */
    function submitBookingForm() {
        // Validate all phases
        if (!validatePhase(1) || !validatePhase(2) || !validatePhase(3)) {
            // Go back to first invalid phase
            for (let i = 1; i <= 3; i++) {
                if (!validatePhase(i)) {
                    // Show phase
                    $('.form-phase').removeClass('active');
                    $(`.form-phase[data-phase="${i}"]`).addClass('active');
                    
                    // Update progress
                    $('.step-item').removeClass('active');
                    $(`.step-item[data-step="${i}"]`).addClass('active');
                    currentPhase = i;
                    
                    // Scroll to top
                    $('.form-sector').animate({
                        scrollTop: 0
                    }, 300);
                    break;
                }
            }
            return;
        }

        // Disable submit button
        const submitBtn = $('.btn-submit');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('Submitting...');
        $('#booking-form-container').addClass('loading');

        // Get form data
        const serviceSelect = $('#service');
        const selectedOption = serviceSelect.find('option:selected');
        const serviceSlug = selectedOption.attr('data-slug') || '';
        
        const formData = {
            action: 'submit_booking_form',
            security: $('#booking-form input[name="security"]').val(),
            service_type: $('#service_type').val(),
            name: $('#name').val(),
            phone: $('#phone').val(),
            email: $('#email').val(),
            city: $('#city').val(),
            service: serviceSelect.val(),
            service_slug: serviceSlug,
            case_brief: $('#case_brief').val(),
            has_documents: $('input[name="has_documents"]:checked').val(),
            previous_lawyer: $('input[name="previous_lawyer"]:checked').val(),
            meeting_type: $('input[name="meeting_type"]:checked').val()
        };

        // Submit via AJAX
        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Track successful booking submission in GTM
                    if (window.dlcPushToDataLayer) {
                        window.dlcPushToDataLayer('booking_form_submit', {
                            'form_type': 'booking',
                            'service_type': formData.service_type
                        });
                    }
                    
                    // Show success message
                    $('#booking-form-container').removeClass('active');
                    $('#success-message').addClass('active');
                    
                    // Scroll to top
                    $('.form-sector').animate({
                        scrollTop: 0
                    }, 300);
                } else {
                    // Show error
                    alert(response.data || 'An error occurred. Please try again.');
                    submitBtn.prop('disabled', false).html(originalText);
                    $('#booking-form-container').removeClass('loading');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
                submitBtn.prop('disabled', false).html(originalText);
                $('#booking-form-container').removeClass('loading');
            }
        });
    }

})(jQuery);

