(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.querySelector('#contact-form');
        if (!contactForm) return;

        const statusBox = document.querySelector('#form-status-message');
        const successModal = document.querySelector('#contact-success-modal');
        const modalClose = document.querySelector('.contact-modal-close');
        const modalOverlay = document.querySelector('.contact-modal-overlay');

        // Close modal function
        function closeModal() {
            if (successModal) {
                successModal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }

        // Open modal function
        function openModal() {
            if (successModal) {
                successModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        }

        // Close modal event listeners
        if (modalClose) {
            modalClose.addEventListener('click', closeModal);
        }

        if (modalOverlay) {
            modalOverlay.addEventListener('click', closeModal);
        }

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && successModal && successModal.style.display === 'block') {
                closeModal();
            }
        });

        // Form submission
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('action', 'submit_contact_form');
            formData.append('security', document.querySelector('#contact_form_nonce_field').value);

            fetch(ajax_object.ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success modal
                    openModal();
                    
                    // Reset form
                    this.reset();

                } else {
                    // Show error message inline
                    if (statusBox) {
                        statusBox.className = "error-message";
                        statusBox.innerHTML = data.data;
                        statusBox.style.display = "block";

                        // Auto-hide
                        setTimeout(() => {
                            statusBox.style.display = "none";
                        }, 7000);
                    }
                }
            })
            .catch(error => {
                // Show error message inline
                if (statusBox) {
                    statusBox.className = "error-message";
                    statusBox.innerHTML = "Unexpected error. Please try again.";
                    statusBox.style.display = "block";

                    setTimeout(() => {
                        statusBox.style.display = "none";
                    }, 7000);
                }

                console.error(error);
            });
        });
    });
})();
