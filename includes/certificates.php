<?php
/**
 * Certificates Carousel Template Part
 * Displays certificates logos in a carousel
 * Can be called anywhere using: get_template_part('includes/certificates');
 */

$certificates = get_option('dlc_certificates', []);

if (empty($certificates)) {
    return; // Don't display if no certificates
}

// Backward compatibility: convert old format to new format
if (isset($certificates[0]) && is_string($certificates[0])) {
    $certificates = array_map(function($url) {
        return array('image' => $url, 'link' => '');
    }, $certificates);
}

// Get current language for text
$current_lang = 'en';
if (function_exists('pll_current_language')) {
    $current_lang = pll_current_language();
}

$title = ($current_lang === 'ar') ? 'الشهادات' : 'Certificates';
$subtitle = ($current_lang === 'ar') 
    ? 'نحن مسجلون ومعتمدون من قبل السلطات التالية:' 
    : 'We are registered and accredited by the following authorities:';
?>

<section class="certificates-section">
    <div class="certificates-header">
        <h2 class="certificates-title"><?php echo esc_html($title); ?></h2>
        <p class="certificates-subtitle"><?php echo esc_html($subtitle); ?></p>
    </div>
    
    <div class="certificates-carousel-wrapper" data-total-items="<?php echo count($certificates); ?>">
        <button class="certificates-carousel-prev" aria-label="<?php echo ($current_lang === 'ar') ? 'السابق' : 'Previous'; ?>">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        
        <div class="certificates-carousel-container">
            <div class="certificates-carousel-track">
                <?php foreach ($certificates as $index => $cert) : 
                    $image_url = is_array($cert) ? $cert['image'] : $cert;
                    $link_url = is_array($cert) && isset($cert['link']) && !empty($cert['link']) ? $cert['link'] : '';
                ?>
                    <div class="certificate-item">
                        <?php if (!empty($link_url)) : ?>
                            <a href="<?php echo esc_url($link_url); ?>" target="_blank" rel="noopener noreferrer" class="certificate-link">
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     alt="<?php echo esc_attr(($current_lang === 'ar') ? 'شهادة' : 'Certificate'); ?> <?php echo $index + 1; ?>" 
                                     class="certificate-logo"
                                     loading="lazy">
                            </a>
                        <?php else : ?>
                            <img src="<?php echo esc_url($image_url); ?>" 
                                 alt="<?php echo esc_attr(($current_lang === 'ar') ? 'شهادة' : 'Certificate'); ?> <?php echo $index + 1; ?>" 
                                 class="certificate-logo"
                                 loading="lazy">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <button class="certificates-carousel-next" aria-label="<?php echo ($current_lang === 'ar') ? 'التالي' : 'Next'; ?>">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
        
        <div class="certificates-carousel-indicators"></div>
    </div>
</section>

