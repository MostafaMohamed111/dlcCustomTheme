<?php
/**
 * Clients Carousel Template Part
 * Displays client logos in a carousel
 * Uses same CSS/JS as certificates section
 * Can be called anywhere using: get_template_part('includes/clients');
 */

$clients = get_option('dlc_clients', []);

if (empty($clients)) {
    return; // Don't display if no clients
}

// Backward compatibility: convert old format to new format
if (isset($clients[0]) && is_string($clients[0])) {
    $clients = array_map(function($url) {
        return array('image' => $url, 'link' => '');
    }, $clients);
}

// Get current language for text
$current_lang = 'en';
if (function_exists('pll_current_language')) {
    $current_lang = pll_current_language();
}

$title = ($current_lang === 'ar') ? 'عملائنا' : 'Our Clients';
$subtitle = ($current_lang === 'ar') 
    ? 'نفخر بخدمة العملاء التالين والشراكة معهم:' 
    : 'Proud to serve and partner with the following clients:';
?>

<section class="certificates-section">
    <div class="certificates-header">
        <h2 class="certificates-title"><?php echo esc_html($title); ?></h2>
        <p class="certificates-subtitle"><?php echo esc_html($subtitle); ?></p>
    </div>
    
    <div class="certificates-carousel-wrapper" data-total-items="<?php echo count($clients); ?>">
        <button class="certificates-carousel-prev" aria-label="<?php echo ($current_lang === 'ar') ? 'السابق' : 'Previous'; ?>">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        
        <div class="certificates-carousel-container">
            <div class="certificates-carousel-track">
                <?php foreach ($clients as $index => $client) : 
                    $image_url = is_array($client) ? $client['image'] : $client;
                    $link_url = is_array($client) && isset($client['link']) && !empty($client['link']) ? $client['link'] : '';
                ?>
                    <div class="certificate-item">
                        <?php if (!empty($link_url)) : ?>
                            <a href="<?php echo esc_url($link_url); ?>" target="_blank" rel="noopener noreferrer" class="certificate-link">
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     alt="<?php echo esc_attr(($current_lang === 'ar') ? 'عميل' : 'Client'); ?> <?php echo $index + 1; ?>" 
                                     class="certificate-logo"
                                     loading="lazy">
                            </a>
                        <?php else : ?>
                            <img src="<?php echo esc_url($image_url); ?>" 
                                 alt="<?php echo esc_attr(($current_lang === 'ar') ? 'عميل' : 'Client'); ?> <?php echo $index + 1; ?>" 
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
