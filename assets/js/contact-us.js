document.querySelector('#contact-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('action', 'submit_contact_form');
    formData.append('security', document.querySelector('#contact_form_nonce_field').value);

    const statusBox = document.querySelector('#form-status-message');

    fetch(ajax_object.ajaxurl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {
            statusBox.className = "success-message";
            statusBox.innerHTML = data.data;
            statusBox.style.display = "block";

            // Auto-hide
            setTimeout(() => statusBox.style.display = "none", 5000);

            this.reset();

        } else {
            statusBox.className = "error-message";
            statusBox.innerHTML = data.data;
            statusBox.style.display = "block";

            // Auto-hide
            setTimeout(() => statusBox.style.display = "none", 7000);
        }

    })
    .catch(error => {
        statusBox.className = "error-message";
        statusBox.innerHTML = "Unexpected error. Please try again.";
        statusBox.style.display = "block";

        setTimeout(() => statusBox.style.display = "none", 7000);

        console.error(error);
    });
});
