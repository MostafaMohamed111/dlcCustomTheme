/**
 * AJAX Comment Submission Handler
 * Bypasses wp-comments-post.php to avoid GoDaddy firewall blocking
 */

jQuery(document).ready(function($) {
    // Handle comment form submission via AJAX
    // Use .off() first to prevent duplicate event handlers
    $('.ajax-comment-form').off('submit').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $form.find('.comment-submit-btn');
        const originalBtnText = $submitBtn.text();
        
        // Prevent double submission
        if ($submitBtn.prop('disabled')) {
            return false;
        }
        
        // Disable submit button and show loading
        $submitBtn.prop('disabled', true).text('Submitting...');
        
        // Remove any previous messages
        $('.comment-form-message').remove();
        
        // Get form data
        const formData = {
            action: 'submit_comment',
            comment_post_ID: $form.find('#comment_post_ID').val(),
            comment_parent: $form.find('#comment_parent').val() || 0,
            author: $form.find('#author').val(),
            email: $form.find('#email').val(),
            comment: $form.find('#comment').val(),
            comment_nonce: $form.find('[name="comment_nonce"]').val()
        };
        
        // Submit via AJAX
        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: formData,
            success: function(response) {
                // Remove any existing messages first
                $('.comment-form-message').remove();
                
                if (response.success) {
                    // Show success message
                    const messageClass = response.data.approved ? 'success' : 'info';
                    const messageHtml = '<div class="comment-form-message ' + messageClass + '">' + 
                                      '<i class="fa-solid fa-' + (response.data.approved ? 'check-circle' : 'clock') + '"></i> ' + 
                                      response.data.message + '</div>';
                    $form.prepend(messageHtml);
                    
                    // Clear form
                    $form.find('#comment').val('');
                    
                    // Reload page if approved to show new comment
                    if (response.data.approved) {
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        // Re-enable button for pending comments (no reload)
                        setTimeout(function() {
                            $submitBtn.prop('disabled', false).text(originalBtnText);
                        }, 2000);
                    }
                } else {
                    // Show error message
                    const errorHtml = '<div class="comment-form-message error">' + 
                                    '<i class="fa-solid fa-exclamation-circle"></i> ' + 
                                    (response.data.message || 'An error occurred. Please try again.') + '</div>';
                    $form.prepend(errorHtml);
                    
                    // Re-enable submit button
                    $submitBtn.prop('disabled', false).text(originalBtnText);
                }
            },
            error: function() {
                // Remove any existing messages first
                $('.comment-form-message').remove();
                
                const errorHtml = '<div class="comment-form-message error">' + 
                                '<i class="fa-solid fa-exclamation-circle"></i> ' + 
                                'Network error. Please check your connection and try again.</div>';
                $form.prepend(errorHtml);
                
                // Re-enable submit button
                $submitBtn.prop('disabled', false).text(originalBtnText);
            }
        });
        
        return false;
    });
});
