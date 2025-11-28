<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body>

    <nav class="top-nav">
        <div class= "container-fluid site-nav">
            <div class="row nav-body">
                <div class="col-1 ms-3 logo-container">
                   <div class="logo">
                        <a href="<?php echo home_url(); ?>">
                            <img src= "<?php echo get_template_directory_uri(); ?>/assets/images/DLC_logo.webp" alt="Dag Law Firm And Consultation Logo">
                        </a>
                   </div>         

                </div>

                <div class="col-6 nav-center">
                    <?php
                        // Check if menu location exists and has a menu assigned
                        if ( has_nav_menu( 'primary-menu' ) ) {
                            wp_nav_menu( 
                                array(
                                    'theme_location' => 'primary-menu',
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
                        // Special case: home page goes to front-page-ar
                        if (is_front_page() || is_home()) {
                            $arabic_url = home_url('/front-page-ar/');
                        } else {
                            $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                            $arabic_url = preg_replace('#/$#', '-ar/', $current_url);
                            if ($arabic_url === $current_url) {
                                $arabic_url = $current_url . '-ar';
                            }
                        }
                        ?>
                        <a href="<?php echo esc_url($arabic_url); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arabic-language-changer.svg" alt="Language Icon" class="language-icon">
                        </a>
                    </div>
                </div>

                <div class="col-3 nav-right">
                    <button class="btn nav-btn btn-define" id="definePresenceBtn" type="button">Define Presence <span class="fa-regular fa-flag mx-2"> </span></button>
                    <div class="sign-in-dropdown ms-2">
                        <button class="btn nav-btn sign-in sign-in-toggle" type="button">
                            Sign In
                            <i class="fa-solid fa-chevron-down ms-1 dropdown-chevron"></i>
                        </button>
                        <div class="sign-in-menu">
                            <a href="https://portals.dlc.com.sa/admin/authentication" class="sign-in-option">
                                <i class="fa-solid fa-user-tie"></i>
                                Employee
                            </a>
                            <a href="https://portals.dlc.com.sa/authentication/login" class="sign-in-option">
                                <i class="fa-solid fa-user"></i>
                                Customer
                            </a>
                        </div>
                    </div>
                </div>
                <div class="toggle-container col-1 ms-auto me-3">
                    <li onclick="toggleMobileNav()" class="mobile-toggle fs-1 fa solid fa-bars"></li>
                </div>
            </div>
        </div>


        <div class="mobile-nav">
            <div class="container-fluid mobile-nav-body">
                <div class="row justify-content-end close-button">
                    <span onclick="closeMobileNav()" class="fa fa-solid fa-xmark fs-2 pt-4 px-5"></span>
                </div>
                    <div class="row justify-content-between align-items-center mt-3 mb-4">
                        <div class="mobile-logo-container">
    
                            <div class="logo mobile-logo">
                                <a href="<?php echo home_url(); ?>">
                                    <img src= "<?php echo get_template_directory_uri(); ?>/assets/images/DLC_logo.webp" alt="Dag Law Firm And Consultation Logo">
                                </a>                        
                            </div>
                        </div>
                        <div class="language-changer mobile-language-changer">
                            <a href="<?php echo esc_url($arabic_url); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arabic-language-changer.svg" alt="Language Icon" class="language-icon">
                            </a>
                        </div>
                    </div>
                    <h2 class="mobile-nav-title text-center">Dag Law Firm</h2>

                    <div class="row">
                        <div class="mobile-menu">
                            <?php
                                // Check if menu location exists and has a menu assigned
                                if ( has_nav_menu( 'primary-menu' ) ) {
                                    wp_nav_menu( 
                                        array(
                                            'theme_location' => 'primary-menu',
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
                        <div class="mobile-actions text-center d-flex align-items-center justify-content-center">
                            <button class="btn nav-btn btn-define mx-4" id="definePresenceBtnMobile" type="button">Define Presence <span class="fa-regular fa-flag mx-2"> </span></button>
                            <div class="sign-in-dropdown mx-4">
                                <button class="btn nav-btn sign-in sign-in-toggle px-5" type="button">
                                    Sign In
                                    <i class="fa-solid fa-chevron-down ms-1 dropdown-chevron"></i>
                                </button>
                                <div class="sign-in-menu">
                                    <a href="https://portals.dlc.com.sa/admin/authentication" class="sign-in-option">
                                        <i class="fa-solid fa-user-tie"></i>
                                        Employee
                                    </a>
                                    <a href="https://portals.dlc.com.sa/authentication/login" class="sign-in-option">
                                        <i class="fa-solid fa-user"></i>
                                        Customer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                    
            </div>
        </div>


            
      

    </nav>

    <!-- Define Presence Modal -->
    <div id="definePresenceModal" class="define-presence-modal">
        <div class="define-presence-modal-content">
            <div class="define-presence-modal-header">
                <h3>Define Your Presence</h3>
                <span class="define-presence-close" id="definePresenceClose">&times;</span>
            </div>
            <div class="define-presence-modal-body">
                <?php
                // Get URLs
                $home_international_category = get_category_by_slug('home-international');
                $international_url = $home_international_category ? get_category_link($home_international_category->term_id) : '#';
                
                // Get Arabic front page URL
                $arabic_front_page = get_page_by_path('front-page-ar');
                $local_url = $arabic_front_page ? get_permalink($arabic_front_page) : home_url('/front-page-ar/');
                ?>
                <div class="define-presence-options">
                    <a href="<?php echo esc_url($international_url); ?>" class="define-presence-option">
                        <div class="option-icon">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <div class="option-content">
                            <h4>International</h4>
                            <p>Access our international services</p>
                        </div>
                    </a>
                    <a href="<?php echo esc_url($local_url); ?>" class="define-presence-option">
                        <div class="option-icon">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div class="option-content">
                            <h4>Local</h4>
                            <p>Access our local services</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
