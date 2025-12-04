<?php
// Get WhatsApp URL and Phone from ACF fields
// For ACF Free: Use a dedicated settings page ID (update this with your page ID)
$settings_page_id = 539; // Settings page ID

// Try settings page first, then current page/post, then options (if Pro)
$whatsapp = '';
$phone = '';

if ($settings_page_id > 0) {
    // Get fields from settings page (field names: whatsapp_link and phone_number)
    $whatsapp = get_field('whatsapp_link', $settings_page_id);
    $phone = get_field('phone_number', $settings_page_id);
}

// Fallback to current page/post
if (!$whatsapp) {
    $whatsapp = get_field('whatsapp_link');
    if (!$whatsapp) {
        $whatsapp = get_field('whatsapp'); // Legacy fallback
    }
}
if (!$phone) {
    $phone = get_field('phone_number');
    if (!$phone) {
        $phone = get_field('phone'); // Legacy fallback
    }
}

// Fallback to options (only works with ACF Pro)
if (!$whatsapp && function_exists('get_field')) {
    $whatsapp = get_field('whatsapp', 'option');
}
if (!$phone && function_exists('get_field')) {
    $phone = get_field('phone', 'option');
}

// Default values - update these with your actual numbers
if (!$whatsapp) {
    $whatsapp = 'https://wa.me/966570277277'; // Default WhatsApp - UPDATE THIS
}
if (!$phone) {
    $phone = '+966570277277'; // Default phone - UPDATE THIS
}

// Clean phone number for tel: link (remove all non-numeric except +)
$phone_clean = preg_replace('/[^0-9+]/', '', $phone);
?>

<div class="whatsapp-floating-container">
    <!-- WhatsApp Chat Button -->
    <a href="<?php echo esc_url($whatsapp); ?>" 
       target="_blank" 
       rel="noopener noreferrer" 
       class="whatsapp-action-btn whatsapp-chat-btn"
       aria-label="<?php echo esc_attr(__('Chat on WhatsApp', 'dlc')); ?>"
       data-tooltip="<?php echo esc_attr(__('Chat on WhatsApp', 'dlc')); ?>">
        <i class="fab fa-whatsapp"></i>
    </a>
    
    <!-- Phone Call Button -->
    <a href="tel:<?php echo esc_attr($phone_clean); ?>" 
       class="whatsapp-action-btn whatsapp-call-btn"
       aria-label="<?php echo esc_attr(__('Call us', 'dlc')); ?>"
       data-tooltip="<?php echo esc_attr(__('Call us', 'dlc')); ?>">
        <i class="fas fa-phone-alt"></i>
    </a>
    
    <!-- Main WhatsApp Button (Trigger) -->
    <button type="button" 
            class="whatsapp-floating-action whatsapp-main-btn"
            aria-label="<?php echo esc_attr(__('Contact options', 'dlc')); ?>"
            aria-expanded="false">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-close-icon">
            <i class="fas fa-times"></i>
        </span>
    </button>
</div>