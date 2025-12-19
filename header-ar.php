<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body>
<?php 
// GTM noscript - right after body tag
if (function_exists('dlc_gtm_body')) {
    dlc_gtm_body();
}
?>
<?php
// Precompute theme image dimensions to add explicit width/height (reduces CLS)
$dlc_logo_dims = function_exists('dlc_get_theme_image_dimensions')
    ? dlc_get_theme_image_dimensions('assets/images/DLC_logo.webp')
    : null;
?>

    <nav class="top-nav">
        <div class= "container-fluid site-nav">
            <div class="row nav-body">
                <div class="col-1 ms-3 logo-container">
                   <div class="logo">
                        <a href="<?php echo home_url(); ?>">
                            <img src= "<?php echo get_template_directory_uri(); ?>/assets/images/DLC_logo.webp"
                                 alt="Dag Law Firm And Consultation Logo"
                                 <?php if ($dlc_logo_dims) : ?>
                                     width="<?php echo esc_attr($dlc_logo_dims['width']); ?>"
                                     height="<?php echo esc_attr($dlc_logo_dims['height']); ?>"
                                 <?php endif; ?>
                                 decoding="async">
                        </a>
                   </div>         

                </div>

                <div class="col-6 nav-center">
                    <?php
                        $menu_location = dlc_get_menu_location('primary');
                        // Check if menu location exists and has a menu assigned
                        if ( has_nav_menu( $menu_location ) ) {
                            wp_nav_menu( 
                                array(
                                    'theme_location' => $menu_location,
                                    'container' => 'div',
                                    'container_class' => 'main-menu',
                                    'fallback_cb' => false,
                                ) 
                            );
                        } else {
                            // Fallback: Show a message or create a simple menu structure
                            echo '<div class="main-menu"><ul><li><a href="#">Menu not assigned</a></li></ul></div>';
                        }
                    ?>
                </div>
                <div class="col-1">
                    <div class="language-changer language-changer-desktop">
                        <?php
                        $switcher = dlc_get_polylang_switcher();
                        if ($switcher) :
                        ?>
                        <a href="<?php echo esc_url($switcher['url']); ?>" aria-label="تغيير اللغة">
                            <img src="<?php echo esc_url($switcher['icon']); ?>" alt="Language Icon" class="language-icon" width="28" height="28" decoding="async">
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-3 nav-right">
                    <?php
                    // Check if we're on international category page or single post in international category
                    $is_international = false;
                    if (is_category() || is_archive()) {
                        $queried_object = get_queried_object();
                        $is_international = dlc_is_home_international_category($queried_object->term_id ?? 0);
                    } elseif (is_single()) {
                        // Check if current post belongs to international category
                        $post_categories = wp_get_post_categories(get_the_ID());
                        foreach ($post_categories as $cat_id) {
                            if (dlc_is_home_international_category($cat_id)) {
                                $is_international = true;
                                break;
                            }
                        }
                    }
                    
                    // Get URLs
                    $international_url = '#';
                    $local_url = home_url();
                    
                    if ($is_international) {
                        // On international page - show Local button
                        if (function_exists('pll_home_url')) {
                            $local_url = pll_home_url('ar');
                        }
                        $button_text = 'محلي';
                        $button_url = $local_url;
                        $button_icon = 'fa-regular fa-flag';
                    } else {
                        // Not on international page - show International button
                        // Get Arabic international category using Polylang
                        if (function_exists('pll_get_term')) {
                            $international_en = get_category_by_slug('home-international');
                            if ($international_en) {
                                $international_ar_id = pll_get_term($international_en->term_id, 'ar');
                                if ($international_ar_id) {
                                    $international_url = get_category_link($international_ar_id);
                                }
                            }
                        }
                        // Fallback: try to get by slug/name if Polylang not available
                        if ($international_url === '#') {
                            $home_international_category = get_category_by_slug('home-international-ar');
                            if (!$home_international_category) {
                                $home_international_category = get_term_by('name', 'الخدمات الدولية', 'category');
                            }
                            $international_url = $home_international_category ? get_category_link($home_international_category->term_id) : '#';
                        }
                        $button_text = 'دولي';
                        $button_url = $international_url;
                        $button_icon = 'fa-solid fa-globe';
                    }
                    ?>
                    <a href="<?php echo esc_url($button_url); ?>" class="btn nav-btn btn-define">
                        <?php echo esc_html($button_text); ?>
                        <span class="<?php echo esc_attr($button_icon); ?> mx-2"></span>
                    </a>
                    <div class="sign-in-dropdown ms-2">
                        <button class="btn nav-btn sign-in sign-in-toggle" type="button" aria-label="فتح قائمة تسجيل الدخول">
                            تسجيل الدخول
                            <i class="fa-solid fa-chevron-down ms-1 dropdown-chevron"></i>
                        </button>
                        <div class="sign-in-menu">
                            <a href="https://portals.dlc.com.sa/admin/authentication" class="sign-in-option">
                                <i class="fa-solid fa-user-tie"></i>
                                موظف
                            </a>
                            <a href="https://portals.dlc.com.sa/authentication/login" class="sign-in-option">
                                <i class="fa-solid fa-user"></i>
                                عميل
                            </a>
                        </div>
                    </div>
                </div>
                <div class="toggle-container col-1 ms-auto me-3">
                    <button type="button"
                            onclick="toggleMobileNav()"
                            class="mobile-toggle fs-1 fa-solid fa-bars"
                            aria-label="فتح القائمة"></button>
                </div>
            </div>
        </div>


        <div class="mobile-nav">
            <div class="container-fluid mobile-nav-body">
                <div class="row justify-content-end close-button">
                    <button type="button"
                            onclick="closeMobileNav()"
                            class="mobile-nav-close fa fa-solid fa-xmark fs-2 pt-4 px-5"
                            aria-label="إغلاق القائمة"></button>
                </div>
                    <div class="row justify-content-between align-items-center mt-3 mb-4">
                        <div class="mobile-logo-container">
    
                            <div class="logo mobile-logo">
                                <a href="<?php echo home_url(); ?>">
                                    <img src= "<?php echo get_template_directory_uri(); ?>/assets/images/DLC_logo.webp"
                                         alt="Dag Law Firm And Consultation Logo"
                                         <?php if ($dlc_logo_dims) : ?>
                                             width="<?php echo esc_attr($dlc_logo_dims['width']); ?>"
                                             height="<?php echo esc_attr($dlc_logo_dims['height']); ?>"
                                         <?php endif; ?>
                                         decoding="async">
                                </a>                        
                            </div>
                        </div>
                        <div class="language-changer mobile-language-changer">
                            <?php
                            $switcher = dlc_get_polylang_switcher();
                            if ($switcher) :
                            ?>
                            <a href="<?php echo esc_url($switcher['url']); ?>" aria-label="تغيير اللغة">
                                <img src="<?php echo esc_url($switcher['icon']); ?>" alt="Language Icon" class="language-icon" width="28" height="28" decoding="async">
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <h2 class="mobile-nav-title text-center">شركة داج للمحاماة والاستشارات القانونية</h2>

                    <div class="row">
                        <div class="mobile-menu">
                            <?php
                                $menu_location = dlc_get_menu_location('primary');
                                // Check if menu location exists and has a menu assigned
                                if ( has_nav_menu( $menu_location ) ) {
                                    wp_nav_menu( 
                                        array(
                                            'theme_location' => $menu_location,
                                            'container' => 'div',
                                            'container_class' => 'main-menu',
                                            'fallback_cb' => false,
                                        ) 
                                    );
                                } else {
                                    // Fallback: Show a message or create a simple menu structure
                                    echo '<div class="main-menu"><ul><li><a href="#">Menu not assigned</a></li></ul></div>';
                                }
                            ?>
                        </div>
                    </div>


                    <div class="row align-items-center mobile-nav-bottom"  >
                        <div class="mobile-actions text-center">
                            <?php
                            // Check if we're on international category page or single post in international category
                            $is_international = false;
                            if (is_category() || is_archive()) {
                                $queried_object = get_queried_object();
                                $is_international = dlc_is_home_international_category($queried_object->term_id ?? 0);
                            } elseif (is_single()) {
                                // Check if current post belongs to international category
                                $post_categories = wp_get_post_categories(get_the_ID());
                                foreach ($post_categories as $cat_id) {
                                    if (dlc_is_home_international_category($cat_id)) {
                                        $is_international = true;
                                        break;
                                    }
                                }
                            }
                            
                            // Get URLs
                            $international_url = '#';
                            $local_url = home_url();
                            
                            if ($is_international) {
                                // On international page - show Local button
                                if (function_exists('pll_home_url')) {
                                    $local_url = pll_home_url('ar');
                                }
                                $button_text = 'محلي';
                                $button_url = $local_url;
                                $button_icon = 'fa-regular fa-flag';
                            } else {
                                // Not on international page - show International button
                                // Get Arabic international category using Polylang
                                if (function_exists('pll_get_term')) {
                                    $international_en = get_category_by_slug('home-international');
                                    if ($international_en) {
                                        $international_ar_id = pll_get_term($international_en->term_id, 'ar');
                                        if ($international_ar_id) {
                                            $international_url = get_category_link($international_ar_id);
                                        }
                                    }
                                }
                                // Fallback: try to get by slug/name if Polylang not available
                                if ($international_url === '#') {
                                    $home_international_category = get_category_by_slug('home-international-ar');
                                    if (!$home_international_category) {
                                        $home_international_category = get_term_by('name', 'الخدمات الدولية', 'category');
                                    }
                                    $international_url = $home_international_category ? get_category_link($home_international_category->term_id) : '#';
                                }
                                $button_text = 'دولي';
                                $button_url = $international_url;
                                $button_icon = 'fa-solid fa-globe';
                            }
                            ?>
                            <a href="<?php echo esc_url($button_url); ?>" class="btn nav-btn btn-define">
                                <?php echo esc_html($button_text); ?>
                                <span class="<?php echo esc_attr($button_icon); ?> mx-2"></span>
                            </a>
                            <div class="sign-in-dropdown">
                                <button class="btn nav-btn sign-in sign-in-toggle px-5" type="button">
                                    تسجيل الدخول
                                    <i class="fa-solid fa-chevron-down ms-1 dropdown-chevron"></i>
                                </button>
                                <div class="sign-in-menu">
                                    <a href="https://portals.dlc.com.sa/admin/authentication" class="sign-in-option">
                                        <i class="fa-solid fa-user-tie"></i>
                                        موظف
                                    </a>
                                    <a href="https://portals.dlc.com.sa/authentication/login" class="sign-in-option">
                                        <i class="fa-solid fa-user"></i>
                                        عميل
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                    
            </div>
        </div>


            
      

    </nav>
