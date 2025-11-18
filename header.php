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
                        $arabic_url = home_url('/front-page-ar/');
                        
                        // Check if we're on a news category or news post
                        $is_news_page = false;
                        if (is_category()) {
                            $queried_object = get_queried_object();
                            if (isset($queried_object->slug) && ($queried_object->slug === 'news' || strpos($queried_object->slug, 'news') !== false)) {
                                $is_news_page = true;
                            }
                        } elseif (is_single() && get_post_type() == 'post') {
                            $post_categories = get_the_category();
                            foreach ($post_categories as $cat) {
                                if ($cat->slug === 'news' || strpos($cat->slug, 'news') !== false) {
                                    $is_news_page = true;
                                    break;
                                }
                            }
                        } elseif (is_archive() || is_tag()) {
                            $queried_object = get_queried_object();
                            if (isset($queried_object->slug) && strpos($queried_object->slug, 'news') !== false) {
                                $is_news_page = true;
                            }
                        }
                        
                        // Check if we're on a services category
                        $is_services_page = false;
                        $service_type = null;
                        if (is_category() || is_archive()) {
                            $queried_object = get_queried_object();
                            if (isset($queried_object->slug)) {
                                $slug = $queried_object->slug;
                                if (strpos($slug, 'companies-services') !== false && strpos($slug, '-ar') === false) {
                                    $is_services_page = true;
                                    $service_type = 'companies';
                                } elseif (strpos($slug, 'individual-services') !== false && strpos($slug, '-ar') === false) {
                                    $is_services_page = true;
                                    $service_type = 'individual';
                                }
                            }
                        } elseif (is_single() && get_post_type() == 'post') {
                            $post_categories = get_the_category();
                            foreach ($post_categories as $cat) {
                                if (strpos($cat->slug, 'companies-services') !== false && strpos($cat->slug, '-ar') === false) {
                                    $is_services_page = true;
                                    $service_type = 'companies';
                                    break;
                                } elseif (strpos($cat->slug, 'individual-services') !== false && strpos($cat->slug, '-ar') === false) {
                                    $is_services_page = true;
                                    $service_type = 'individual';
                                    break;
                                }
                            }
                        }
                        
                        if ($is_news_page) {
                            // Switch to Arabic news category
                            $news_ar_category = get_category_by_slug('news-ar');
                            if ($news_ar_category) {
                                $arabic_url = get_category_link($news_ar_category->term_id);
                            }
                        }
                        elseif ($is_services_page && $service_type) {
                            // Switch to Arabic services category
                            $slug = ($service_type === 'individual') ? 'individual-services-ar' : 'companies-services-ar';
                            $service_ar_category = get_category_by_slug($slug);
                            if ($service_ar_category) {
                                $arabic_url = get_category_link($service_ar_category->term_id);
                            }
                        }
                        // If on a blog post, switch to Arabic blog archive
                        elseif (is_single() && get_post_type() == 'post') {
                            $blog_ar_category = get_category_by_slug('blog-ar');
                            if ($blog_ar_category) {
                                $arabic_url = get_category_link($blog_ar_category->term_id);
                            }
                        }
                        // If on blog archive/category, switch to Arabic blog archive
                        elseif (is_archive() || is_category() || is_tag()) {
                            $blog_ar_category = get_category_by_slug('blog-ar');
                            if ($blog_ar_category) {
                                $arabic_url = get_category_link($blog_ar_category->term_id);
                            }
                        }
                        // If on a page, use slug-based approach
                        elseif (is_page()) {
                        $current_slug = get_post_field('post_name', get_the_ID());
                        $arabic_slug = $current_slug . '-ar';
                        $arabic_page = get_page_by_path($arabic_slug);
                            if ($arabic_page) {
                                $arabic_url = get_permalink($arabic_page);
                            }
                        }
                        ?>
                        <a href="<?php echo esc_url($arabic_url); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arabic-language-changer.svg" alt="Language Icon" class="language-icon">
                        </a>
                    </div>
                </div>

                <div class="col-3 nav-right">
                    <button class="btn nav-btn btn-define">Define Presence <span class="fa-regular fa-flag mx-2"> </span></button>
                    <div class="sign-in-dropdown ms-2">
                        <button class="btn nav-btn sign-in sign-in-toggle" type="button">
                            Sign In
                            <i class="fa-solid fa-chevron-down ms-1 dropdown-chevron"></i>
                        </button>
                        <div class="sign-in-menu">
                            <a href="#" class="sign-in-option">
                                <i class="fa-solid fa-user-tie"></i>
                                Employee
                            </a>
                            <a href="#" class="sign-in-option">
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
                            <?php
                            $arabic_url = home_url('/front-page-ar/');
                            
                            // Check if we're on a news category or news post
                            $is_news_page = false;
                            if (is_category()) {
                                $queried_object = get_queried_object();
                                if (isset($queried_object->slug) && ($queried_object->slug === 'news' || strpos($queried_object->slug, 'news') !== false)) {
                                    $is_news_page = true;
                                }
                            } elseif (is_single() && get_post_type() == 'post') {
                                $post_categories = get_the_category();
                                foreach ($post_categories as $cat) {
                                    if ($cat->slug === 'news' || strpos($cat->slug, 'news') !== false) {
                                        $is_news_page = true;
                                        break;
                                    }
                                }
                            } elseif (is_archive() || is_tag()) {
                                $queried_object = get_queried_object();
                                if (isset($queried_object->slug) && strpos($queried_object->slug, 'news') !== false) {
                                    $is_news_page = true;
                                }
                            }
                            
                            // Check if we're on a services category
                            $is_services_page = false;
                            $service_type = null;
                            if (is_category() || is_archive()) {
                                $queried_object = get_queried_object();
                                if (isset($queried_object->slug)) {
                                    $slug = $queried_object->slug;
                                    if (strpos($slug, 'companies-services') !== false && strpos($slug, '-ar') === false) {
                                        $is_services_page = true;
                                        $service_type = 'companies';
                                    } elseif (strpos($slug, 'individual-services') !== false && strpos($slug, '-ar') === false) {
                                        $is_services_page = true;
                                        $service_type = 'individual';
                                    }
                                }
                            } elseif (is_single() && get_post_type() == 'post') {
                                $post_categories = get_the_category();
                                foreach ($post_categories as $cat) {
                                    if (strpos($cat->slug, 'companies-services') !== false && strpos($cat->slug, '-ar') === false) {
                                        $is_services_page = true;
                                        $service_type = 'companies';
                                        break;
                                    } elseif (strpos($cat->slug, 'individual-services') !== false && strpos($cat->slug, '-ar') === false) {
                                        $is_services_page = true;
                                        $service_type = 'individual';
                                        break;
                                    }
                                }
                            }
                            
                            if ($is_news_page) {
                                // Switch to Arabic news category
                                $news_ar_category = get_category_by_slug('news-ar');
                                if ($news_ar_category) {
                                    $arabic_url = get_category_link($news_ar_category->term_id);
                                }
                            }
                            elseif ($is_services_page && $service_type) {
                                // Switch to Arabic services category
                                $slug = ($service_type === 'individual') ? 'individual-services-ar' : 'companies-services-ar';
                                $service_ar_category = get_category_by_slug($slug);
                                if ($service_ar_category) {
                                    $arabic_url = get_category_link($service_ar_category->term_id);
                                }
                            }
                            // If on a blog post, switch to Arabic blog archive
                            elseif (is_single() && get_post_type() == 'post') {
                                $blog_ar_category = get_category_by_slug('blog-ar');
                                if ($blog_ar_category) {
                                    $arabic_url = get_category_link($blog_ar_category->term_id);
                                }
                            }
                            // If on blog archive/category, switch to Arabic blog archive
                            elseif (is_archive() || is_category() || is_tag()) {
                                $blog_ar_category = get_category_by_slug('blog-ar');
                                if ($blog_ar_category) {
                                    $arabic_url = get_category_link($blog_ar_category->term_id);
                                }
                            }
                            // If on a page, use slug-based approach
                            elseif (is_page()) {
                            $current_slug = get_post_field('post_name', get_the_ID());
                            $arabic_slug = $current_slug . '-ar';
                            $arabic_page = get_page_by_path($arabic_slug);
                                if ($arabic_page) {
                                    $arabic_url = get_permalink($arabic_page);
                                }
                            }
                            ?>
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
                        <div class="mobile-actions text-center">
                            <button class="btn nav-btn btn-define mx-4  ">Define Presence <span class="fa-regular fa-flag mx-2"> </span></button>
                            <div class="sign-in-dropdown mx-4">
                                <button class="btn nav-btn sign-in sign-in-toggle px-5" type="button">
                                    Sign In
                                    <i class="fa-solid fa-chevron-down ms-1 dropdown-chevron"></i>
                                </button>
                                <div class="sign-in-menu">
                                    <a href="#" class="sign-in-option">
                                        <i class="fa-solid fa-user-tie"></i>
                                        Employee
                                    </a>
                                    <a href="#" class="sign-in-option">
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
