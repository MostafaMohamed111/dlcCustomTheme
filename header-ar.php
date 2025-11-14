<!DOCTYPE html>
<html lang="ar" dir="rtl">
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
                                    'theme_location' => 'primary-ar-menu',
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
                        // Get current page slug
                        $current_slug = get_post_field('post_name', get_the_ID());
                        // Add -ar to the slug
                        $english = str_replace('-ar', '', $current_slug);
                        // Get the Arabic page by slug
                       
                        $english_page = get_page_by_path($english);
                        // Get permalink or fallback to home
                        $arabic_url = $english_page ? get_permalink($english_page) : home_url('');
                        ?>
                        <a href="<?php echo $arabic_url; ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/english-language-changer.svg" alt="Language Icon" class="language-icon">
                        </a>
                    </div>
                </div>

                <div class="col-3 nav-right">
                    <button class="btn nav-btn btn-define">Define Presence <span class="fa-regular fa-flag mx-2"> </span></button>
                    <button class="btn nav-btn sign-in ms-2">Sign In<span class="fas fa-sign-in-alt px-2"></span></button>
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
                            <?php
                            // Get current page slug
                            $current_slug = get_post_field('post_name', get_the_ID());
                            // Add -ar to the slug
                            $english = str_replace('-ar', '', $current_slug);
                           
                            // Get the Arabic page by slug
                            $english_page = get_page_by_path($english);
                            // Get permalink or fallback to home
                            
                            $english_url = $english_page ? get_permalink($english_page) : home_url('');
                            ?>
                            <a href="<?php echo $english_url; ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/english-language-changer.svg" alt="Language Icon" class="language-icon">
                            </a>
                        </div>
                    </div>
                    <h2 class="mobile-nav-title text-center">شركة داج للمحاماة والاستشارات القانونية</h2>

                    <div class="row">
                        <div class="mobile-menu">
                            <?php
                                // Check if menu location exists and has a menu assigned
                                if ( has_nav_menu( 'primary-menu' ) ) {
                                    wp_nav_menu( 
                                        array(
                                            'theme_location' => 'primary-ar-menu',
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
                            <button class="btn nav-btn btn-define mx-4  ">تحديد التواجد<span class="fa-regular fa-flag mx-2"> </span></button>
                            <button class="btn nav-btn sign-in mx-4 px-5 ">تسجيل الدخول<span class="fas fa-sign-in-alt px-2"></span></button>
                        </div>
                    </div>

                </div>

                    
            </div>
        </div>


            
      

    </nav>
