<?php


function enqueue_theme_css() {
    // Detect if current page is Arabic (do this first to determine which Bootstrap to load)
    $is_arabic_page = false;
    
    // Check if it's an Arabic template (most reliable for separate pages)
    // This works for pages using templates like 'fornt-page-ar.php'
    if (function_exists('get_page_template_slug')) {
        $template = get_page_template_slug();
        if ($template) {
            // Check for '-ar.php' or '-ar' pattern (more specific than just 'ar')
            if (strpos($template, '-ar.php') !== false || 
                strpos($template, '-ar') !== false || 
                preg_match('/-ar\.php$/', $template)) {
                $is_arabic_page = true;
            }
        }
    }
    
    // Check if current template file is an Arabic version
    // This catches cases where template file name contains '-ar' pattern
    $template_file = get_page_template();
    if ($template_file && is_string($template_file)) {
        $template_basename = basename($template_file);
        // More specific check: look for '-ar' pattern in filename
        if (strpos($template_basename, '-ar') !== false || 
            preg_match('/-ar\.php$/', $template_basename)) {
            $is_arabic_page = true;
        }
    }
    
    // Check for Arabic single posts (individual post language metadata)
    if (is_single() && get_post_type() == 'post') {
        $post_language = get_post_meta(get_the_ID(), '_post_language', true);
        if ($post_language === 'ar') {
            $is_arabic_page = true;
        }
    }
    
    // Check for Arabic archive pages (category slug contains '-ar')
    if (is_archive()) {
        $queried_object = get_queried_object();
        if (isset($queried_object->slug) && strpos($queried_object->slug, '-ar') !== false) {
            $is_arabic_page = true;
        }
    }
    
    // Backup check: if RTL is enabled in WordPress
    if (is_rtl()) {
        $is_arabic_page = true;
    }

    // Conditionally load Bootstrap CSS - RTL for Arabic, regular for English
    if ($is_arabic_page) {
        // Load Bootstrap RTL for Arabic pages
        wp_register_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.rtl.min.css', array(), '4.5.2', 'all' );
    } else {
        // Load regular Bootstrap for English pages
        wp_register_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '4.5.2', 'all' );
    }
    wp_enqueue_style( 'bootstrap' );

    // Font Awesome CSS
    wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/webfonts/all.min.css', array(), '6.0.0', 'all' );
    wp_enqueue_style( 'font-awesome' );
    
    // Enqueue main CSS (base styles for all pages)
    wp_register_style('main', get_template_directory_uri() . '/assets/en/main.css', array(), false, 'all');
    wp_enqueue_style('main');

    // Enqueue main RTL overrides for Arabic pages (header, footer, navigation)
    if ( $is_arabic_page ) {
        wp_register_style('main-ar', get_template_directory_uri() . '/assets/ar/main-ar.css', array('main'), '1.0.1', 'all');
        wp_enqueue_style('main-ar');
    }

    // Enqueue front-page specific CSS
    // Check Arabic first to avoid loading English CSS on Arabic front page
    if ( is_page_template('fornt-page-ar.php') ) {
        // Arabic front page
        wp_register_style('front-page', get_template_directory_uri() . '/assets/en/front-page.css', array('main'), '1.0.0', 'all');
        wp_enqueue_style('front-page');
        wp_register_style('front-page-rtl', get_template_directory_uri() . '/assets/ar/front-page-rtl.css', array('front-page'), '1.0.1', 'all');
        wp_enqueue_style('front-page-rtl');
    } elseif ( is_front_page() ) {
        // English front page (only if not Arabic)
        wp_register_style('front-page', get_template_directory_uri() . '/assets/en/front-page.css', array('main'), '1.0.0', 'all');
        wp_enqueue_style('front-page');
    }

    else if( is_page_template('services.php' ) || is_page_template('services-ar.php' )  ) {
        // Services page
        wp_register_style('services-page', get_template_directory_uri() . '/assets/en/services.css', array('main'), '1.0.0', 'all');
        wp_enqueue_style('services-page');
    }



    else if( is_page_template('secure-yourself.php' ) || is_page_template('secure-yourself-ar.php' )  ) {
        // Secure Yourself page
        wp_register_style('secure-yourself-page', get_template_directory_uri() . '/assets/en/secure-yourself.css', array('main'), '1.0.0', 'all');
        wp_enqueue_style('secure-yourself-page');
    }
    


    else if(is_page_template('contact-us.php') || is_page_template('contact-us-ar.php') ) {
        // Contact Us page
        wp_register_style('contact-us-page', get_template_directory_uri() . '/assets/en/contact-us.css', array('main'), '1.0.0', 'all');
        wp_enqueue_style('contact-us-page');
    }

    else if(is_page_template('about-us.php') || is_page_template('about-us-ar.php') ) {
        // About Us page
        wp_register_style('about-us-page', get_template_directory_uri() . '/assets/en/about-us.css', array('main'), '1.0.0', 'all');
        wp_enqueue_style('about-us-page');
    }
    else if(is_page_template('privacy-policy.php') || is_page_template('privacy-policy-ar.php')) {
        // Privacy Policy page
        wp_register_style('privacy-policy-page', get_template_directory_uri() . '/assets/en/privacy-policy.css', array('main'), '1.0.0', 'all');
        wp_enqueue_style('privacy-policy-page');
    }
    // Fallback: Check by page slug or template slug
    else if(is_page()) {
        $template_slug = get_page_template_slug();
        $page_slug = get_post_field('post_name', get_the_ID());
        $template_file = get_page_template();
        
        if(($template_slug && (strpos($template_slug, 'privacy-policy') !== false)) ||
           ($template_file && (strpos(basename($template_file), 'privacy-policy') !== false)) ||
           ($page_slug && (strpos($page_slug, 'privacy') !== false || strpos($page_slug, 'privacy-policy') !== false))) {
            wp_register_style('privacy-policy-page', get_template_directory_uri() . '/assets/en/privacy-policy.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('privacy-policy-page');
        }
    }


    else if (is_archive()) {
        // Check category type
        $is_news_category = false;
        $is_companies_services = false;
        $is_individual_services = false;
        $is_home_international = false;
        $queried_object = get_queried_object();
        $term_id = isset($queried_object->term_id) ? $queried_object->term_id : 0;
        $companies_parent = get_category_by_slug('companies-services');
        $individual_parent = get_category_by_slug('individual-services');
        $home_international_parent = get_category_by_slug('home-international');
        
        if (isset($queried_object->slug)) {
            $slug = $queried_object->slug;
            
            if (strpos($slug, 'news') !== false) {
                $is_news_category = true;
            } elseif (strpos($slug, 'companies-services') !== false) {
                $is_companies_services = true;
            } elseif (strpos($slug, 'individual-services') !== false) {
                $is_individual_services = true;
            } elseif (strpos($slug, 'home-international') !== false) {
                $is_home_international = true;
            }
        }
        
        // Include child categories
        if (!$is_companies_services && $companies_parent && $term_id) {
            if ($term_id === $companies_parent->term_id || cat_is_ancestor_of($companies_parent->term_id, $term_id)) {
                $is_companies_services = true;
            }
        }
        if (!$is_individual_services && $individual_parent && $term_id) {
            if ($term_id === $individual_parent->term_id || cat_is_ancestor_of($individual_parent->term_id, $term_id)) {
                $is_individual_services = true;
            }
        }
        if (!$is_home_international && $home_international_parent && $term_id) {
            if ($term_id === $home_international_parent->term_id || cat_is_ancestor_of($home_international_parent->term_id, $term_id)) {
                $is_home_international = true;
            }
        }
        
        if ($is_news_category) {
            // News archive page
            wp_register_style('news-page', get_template_directory_uri() . '/assets/en/news.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('news-page');
        } elseif ($is_companies_services || $is_individual_services || $is_home_international) {
            // Services archives (companies, individual, or home international)
            wp_register_style('services-page', get_template_directory_uri() . '/assets/en/companies-individual-services.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('services-page');
            
            // Load additional home-international.css for home-international category
            if ($is_home_international) {
                wp_register_style('home-international-page', get_template_directory_uri() . '/assets/en/home-international.css', array('services-page'), '1.0.0', 'all');
                wp_enqueue_style('home-international-page');
            }
        } else {
            // Blog archive page
            wp_register_style('archive-page', get_template_directory_uri() . '/assets/en/archive.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('archive-page');
        }
    }

    else if (is_single() && get_post_type() == 'post') {
        // Single post page
        wp_register_style('single-page', get_template_directory_uri() . '/assets/en/single.css', array('main'), '1.0.0', 'all');
        wp_enqueue_style('single-page');
    }


   
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_css' );



function enqueue_theme_scripts() {
    wp_enqueue_script( 'jquery' );

    wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '4.5.2', true );
    wp_enqueue_script( 'bootstrap-js' );

    // Main theme script - mobile menu and general functionality (load on all pages)
    wp_register_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
    wp_enqueue_script( 'main-js' );

    // Scroll animations script - load for front pages and services pages
        wp_register_script( 'scroll-animations', get_template_directory_uri() . '/assets/js/scroll-animations.js', array(), '1.0.0', true );
        wp_enqueue_script( 'scroll-animations' );
    
}

add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts' );



// Enable Menu Support
add_theme_support( 'menus' );


// Register Menus
function theme_register_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __('Primary Menu'),
            'primary-ar-menu' => __('Primary Arabic Menu'),
            'footer-menu' => __('Footer Menu'),
            'footer-ar-menu' => __('Footer Arabic Menu'),
        )
    );
}

add_action('init', 'theme_register_menus');

// Keep correct menu item active based on category (Blog or News)
function keep_correct_menu_active($classes, $item) {
    // Check if we're on a category/archive/post page
    if (is_category() || is_archive() || (is_single() && get_post_type() == 'post')) {
        $queried_object = get_queried_object();
        $is_news_category = false;
        $is_blog_category = false;
        $is_companies_services = false;
        $is_individual_services = false;
        $is_home_international = false;
        $is_services_category = false;
        
        // Determine if we're viewing news or blog
        if (is_category() && isset($queried_object->slug)) {
            $slug = $queried_object->slug;
            $term_id = isset($queried_object->term_id) ? $queried_object->term_id : 0;
            $companies_parent = get_category_by_slug('companies-services');
            $individual_parent = get_category_by_slug('individual-services');
            $home_international_parent = get_category_by_slug('home-international');
            
            // First, check for special service categories (exclude from blog/news)
            if (strpos($slug, 'companies-services') !== false ||
                ($companies_parent && $term_id && cat_is_ancestor_of($companies_parent->term_id, $term_id))) {
                $is_companies_services = true;
            } elseif (strpos($slug, 'individual-services') !== false ||
                ($individual_parent && $term_id && cat_is_ancestor_of($individual_parent->term_id, $term_id))) {
                $is_individual_services = true;
            } elseif (strpos($slug, 'home-international') !== false ||
                ($home_international_parent && $term_id && cat_is_ancestor_of($home_international_parent->term_id, $term_id))) {
                $is_home_international = true;
            }
            // Check if it's a news category (news or news-ar)
            elseif ($slug === 'news' || $slug === 'news-ar' || strpos($slug, 'news') !== false) {
                $is_news_category = true;
            } else {
                // Check if it's a blog category or child of blog
                $blog_category = get_category_by_slug('blog');
                $blog_ar_category = get_category_by_slug('blog-ar');
                
                // Check if current category is blog, blog-ar, or a child of blog
                if ($slug === 'blog' || $slug === 'blog-ar' || 
                    ($blog_category && cat_is_ancestor_of($blog_category->term_id, $queried_object->term_id)) ||
                    ($blog_ar_category && cat_is_ancestor_of($blog_ar_category->term_id, $queried_object->term_id))) {
                    $is_blog_category = true;
                }
            }
        } elseif (is_archive() && !is_category()) {
            // On main archive page - check if it's blog archive
            // But exclude if it's companies-services, individual-services, or home-international
            $queried_object = get_queried_object();
            if (isset($queried_object->slug)) {
                $slug = $queried_object->slug;
                if (strpos($slug, 'companies-services') === false && 
                    strpos($slug, 'individual-services') === false &&
                    strpos($slug, 'home-international') === false) {
                    $is_blog_category = true;
                }
            } else {
                $is_blog_category = true;
            }
        } elseif (is_single() && get_post_type() == 'post') {
            // On single post - check post categories
            $post_categories = get_the_category();
            $companies_parent = get_category_by_slug('companies-services');
            $individual_parent = get_category_by_slug('individual-services');
            $home_international_parent = get_category_by_slug('home-international');
            foreach ($post_categories as $cat) {
                // Check for special service categories first
                if (strpos($cat->slug, 'companies-services') !== false ||
                    ($companies_parent && cat_is_ancestor_of($companies_parent->term_id, $cat->term_id))) {
                    $is_companies_services = true;
                    break;
                } elseif (strpos($cat->slug, 'individual-services') !== false ||
                    ($individual_parent && cat_is_ancestor_of($individual_parent->term_id, $cat->term_id))) {
                    $is_individual_services = true;
                    break;
                } elseif (strpos($cat->slug, 'home-international') !== false ||
                    ($home_international_parent && cat_is_ancestor_of($home_international_parent->term_id, $cat->term_id))) {
                    $is_home_international = true;
                    break;
                } elseif ($cat->slug === 'news' || $cat->slug === 'news-ar' || strpos($cat->slug, 'news') !== false) {
                    $is_news_category = true;
                    break;
                } elseif ($cat->slug === 'blog' || $cat->slug === 'blog-ar') {
                    $is_blog_category = true;
                    break;
                } else {
                    // Check if it's a child of blog category
                    $blog_category = get_category_by_slug('blog');
                    $blog_ar_category = get_category_by_slug('blog-ar');
                    if (($blog_category && cat_is_ancestor_of($blog_category->term_id, $cat->term_id)) ||
                        ($blog_ar_category && cat_is_ancestor_of($blog_ar_category->term_id, $cat->term_id))) {
                        $is_blog_category = true;
                        break;
                    }
                }
            }
        }
        
        // Determine if current context is services (companies, individual, or home-international)
        if ($is_companies_services || $is_individual_services || $is_home_international) {
            $is_services_category = true;
        }
        
        // Get menu item URL
        $menu_url = $item->url;
        
        // Check if this menu item is for Blog
        $blog_category = get_category_by_slug('blog');
        $blog_ar_category = get_category_by_slug('blog-ar');
        $is_blog_menu_item = false;
        $is_news_menu_item = false;
        $is_services_menu_item = false;
        
        if ($blog_category) {
            $blog_url = get_category_link($blog_category->term_id);
            // More specific check - must match exact blog category URL or /category/blog (not just /blog)
            if (strpos($menu_url, $blog_url) !== false || 
                strpos($menu_url, '/category/blog') !== false) {
                // Exclude companies-services, individual-services, and home-international from blog menu
                if (strpos($menu_url, 'companies-services') === false && 
                    strpos($menu_url, 'individual-services') === false &&
                    strpos($menu_url, 'home-international') === false) {
                    $is_blog_menu_item = true;
                }
            }
        }
        
        if ($blog_ar_category) {
            $blog_ar_url = get_category_link($blog_ar_category->term_id);
            if (strpos($menu_url, $blog_ar_url) !== false || 
                strpos($menu_url, '/category/blog-ar') !== false) {
                // Exclude companies-services, individual-services, and home-international from blog menu
                if (strpos($menu_url, 'companies-services') === false && 
                    strpos($menu_url, 'individual-services') === false &&
                    strpos($menu_url, 'home-international') === false) {
                    $is_blog_menu_item = true;
                }
            }
        }
        
        // Check if this menu item is for News
        $news_category = get_category_by_slug('news');
        $news_ar_category = get_category_by_slug('news-ar');
        
        if ($news_category) {
            $news_url = get_category_link($news_category->term_id);
            if (strpos($menu_url, $news_url) !== false || 
                strpos($menu_url, '/category/news') !== false) {
                $is_news_menu_item = true;
            }
        }
        
        if ($news_ar_category) {
            $news_ar_url = get_category_link($news_ar_category->term_id);
            if (strpos($menu_url, $news_ar_url) !== false || 
                strpos($menu_url, '/category/news-ar') !== false) {
                $is_news_menu_item = true;
            }
        }
        
        // Check if this menu item is for Services (companies, individual, or home-international)
        $service_categories = array(
            get_category_by_slug('companies-services'),
            get_category_by_slug('companies-services-ar'),
            get_category_by_slug('individual-services'),
            get_category_by_slug('individual-services-ar'),
            get_category_by_slug('home-international'),
            get_category_by_slug('home-international-ar')
        );
        
        foreach ($service_categories as $service_cat) {
            if ($service_cat) {
                $service_url = get_category_link($service_cat->term_id);
                if (strpos($menu_url, $service_url) !== false ||
                    strpos($menu_url, '/category/' . $service_cat->slug) !== false) {
                    $is_services_menu_item = true;
                    break;
                }
            }
        }
        
        // Also check for services page URLs
        if (!$is_services_menu_item) {
            if (strpos($menu_url, '/services') !== false || strpos($menu_url, '-services') !== false) {
                $is_services_menu_item = true;
            }
        }
        
        // Remove existing active classes first
        $classes = array_diff($classes, array('current-menu-item', 'current_page_item', 'current_page_parent', 'current_page_ancestor'));
        
        // Only add active class if the menu item type matches the current page type
        // Services should highlight their own menu item
        if ($is_services_category && $is_services_menu_item) {
            $classes[] = 'current-menu-item';
        } elseif ($is_news_category && $is_news_menu_item) {
            $classes[] = 'current-menu-item';
        } elseif ($is_blog_category && $is_blog_menu_item) {
            $classes[] = 'current-menu-item';
        } elseif (!$is_news_category && !$is_blog_category && !$is_services_category && $is_blog_menu_item) {
            // Default to blog if we can't determine (for archive pages)
            $classes[] = 'current-menu-item';
        }
    }
    
    return $classes;
}
add_filter('nav_menu_css_class', 'keep_correct_menu_active', 10, 2);

// Show Blog category posts on main archive/blog page and set posts per page
function show_blog_category_posts($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Set posts per page to 6 for all archive pages (categories, tags, blog)
        if (is_archive() || is_category() || is_tag()) {
            $query->set('posts_per_page', 6);
        }
        
        // If on archive page (blog home) and not viewing a specific category
        if (is_archive() && !is_category() && !is_tag() && !is_author()) {
            $blog_category = get_category_by_slug('blog');
            if (!$blog_category) {
                $blog_category = get_term_by('name', 'Blog', 'category');
            }
            
            // If Blog category exists, show only its posts
            if ($blog_category) {
                $query->set('cat', $blog_category->term_id);
            }
        }
    }
}
add_action('pre_get_posts', 'show_blog_category_posts');





function add_language_metabox() {
    add_meta_box(
        'post_language_box',
        'Post Language',
        'render_language_metabox',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_language_metabox');

function render_language_metabox($post) {
    $value = get_post_meta($post->ID, '_post_language', true);
    ?>
    <label for="post_language">Language:</label>
    <select name="post_language" id="post_language" style="width:100%;">
        <option value="en" <?php selected($value, 'en'); ?>>English</option>
        <option value="ar" <?php selected($value, 'ar'); ?>>Arabic</option>
    </select>
    <?php
}

function save_language_metabox($post_id) {
    if (isset($_POST['post_language'])) {
        update_post_meta($post_id, '_post_language', sanitize_text_field($_POST['post_language']));
    }
}
add_action('save_post', 'save_language_metabox');

// Generic helper function to detect if a post is in a news category
function dlc_is_news_post($post_id = null) {
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }
    
    $post_categories = get_the_category($post_id);
    foreach ($post_categories as $cat) {
        if ($cat->slug === 'news' || $cat->slug === 'news-ar' || strpos($cat->slug, 'news') !== false) {
            return true;
        }
    }
    return false;
}

// Generic helper function to get category IDs for a category type (news or blog)
// Returns array of category IDs including children for blog categories
function dlc_get_category_ids_by_type($category_type = 'blog', $include_children = true) {
    $category_ids = array();
    
    if ($category_type === 'news') {
        $news_category = get_category_by_slug('news');
        $news_ar_category = get_category_by_slug('news-ar');
        if ($news_category) $category_ids[] = $news_category->term_id;
        if ($news_ar_category) $category_ids[] = $news_ar_category->term_id;
    } else {
        // Blog category
        $blog_category = get_category_by_slug('blog');
        $blog_ar_category = get_category_by_slug('blog-ar');
        if ($blog_category) $category_ids[] = $blog_category->term_id;
        if ($blog_ar_category) $category_ids[] = $blog_ar_category->term_id;
        
        // Get all children of blog categories if requested
        if ($include_children) {
            if ($blog_category) {
                $blog_children = get_term_children($blog_category->term_id, 'category');
                if (!is_wp_error($blog_children)) {
                    $category_ids = array_merge($category_ids, $blog_children);
                }
            }
            if ($blog_ar_category) {
                $blog_ar_children = get_term_children($blog_ar_category->term_id, 'category');
                if (!is_wp_error($blog_ar_children)) {
                    $category_ids = array_merge($category_ids, $blog_ar_children);
                }
            }
        }
    }
    
    return array_unique($category_ids);
}

// Helper to determine service type (companies, individual, or home-international) for a given post
function dlc_get_service_type($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    if (!$post_id) {
        return null;
    }

    $categories = get_the_category($post_id);
    if (empty($categories)) {
        return null;
    }

    $companies_parent = get_category_by_slug('companies-services');
    $companies_ar_parent = get_category_by_slug('companies-services-ar');
    $individual_parent = get_category_by_slug('individual-services');
    $individual_ar_parent = get_category_by_slug('individual-services-ar');
    $home_international_parent = get_category_by_slug('home-international');
    $home_international_ar_parent = get_category_by_slug('home-international-ar');

    foreach ($categories as $cat) {
        if (strpos($cat->slug, 'companies-services') !== false ||
            ($companies_parent && cat_is_ancestor_of($companies_parent->term_id, $cat->term_id)) ||
            ($companies_ar_parent && cat_is_ancestor_of($companies_ar_parent->term_id, $cat->term_id))) {
            return 'companies';
        }

        if (strpos($cat->slug, 'individual-services') !== false ||
            ($individual_parent && cat_is_ancestor_of($individual_parent->term_id, $cat->term_id)) ||
            ($individual_ar_parent && cat_is_ancestor_of($individual_ar_parent->term_id, $cat->term_id))) {
            return 'individual';
        }

        if (strpos($cat->slug, 'home-international') !== false ||
            ($home_international_parent && cat_is_ancestor_of($home_international_parent->term_id, $cat->term_id)) ||
            ($home_international_ar_parent && cat_is_ancestor_of($home_international_ar_parent->term_id, $cat->term_id))) {
            return 'home-international';
        }
    }

    return null;
}

// Helper to get all category IDs for a given service type and language
function dlc_get_service_category_ids($service_type = 'companies', $language = 'en') {
    $category_ids = array();
    
    if ($service_type === 'individual') {
        $base_slug = 'individual-services';
    } elseif ($service_type === 'home-international') {
        $base_slug = 'home-international';
    } else {
        $base_slug = 'companies-services';
    }
    
    $slug = ($language === 'ar') ? $base_slug . '-ar' : $base_slug;
    
    $parent_category = get_category_by_slug($slug);

    if ($parent_category) {
        $category_ids[] = $parent_category->term_id;
        $children = get_term_children($parent_category->term_id, 'category');
        if (!is_wp_error($children)) {
            $category_ids = array_merge($category_ids, $children);
        }
    }

    return array_unique(array_filter($category_ids));
}

// Helper to get the archive URL for services (companies, individual, or home-international) based on post language
function dlc_get_service_archive_url($post_id = null) {
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }
    
    $service_type = dlc_get_service_type($post_id);
    if (!$service_type) {
        return home_url('/');
    }
    
    // Get post language
    $language = get_post_meta($post_id, '_post_language', true) ?: 'en';
    
    if ($service_type === 'individual') {
        $base_slug = 'individual-services';
    } elseif ($service_type === 'home-international') {
        $base_slug = 'home-international';
    } else {
        $base_slug = 'companies-services';
    }
    
    $slug = ($language === 'ar') ? $base_slug . '-ar' : $base_slug;
    $category = get_category_by_slug($slug);

    if ($category) {
        return get_category_link($category->term_id);
    }

    // Fallback to English version if Arabic not found
    $fallback_category = get_category_by_slug($base_slug);
    if ($fallback_category) {
        return get_category_link($fallback_category->term_id);
    }

    return home_url('/');
}

// Helper to get adjacent service posts within the same service type and language
function dlc_get_adjacent_service_post($direction = 'next', $language = 'en') {
    global $post;
    if (!$post) {
        return null;
    }

    $service_type = dlc_get_service_type($post->ID);
    if (!$service_type) {
        return null;
    }

    $category_ids = dlc_get_service_category_ids($service_type, $language);
    if (empty($category_ids)) {
        return null;
    }

    $direction = strtolower($direction);
    $is_next = ($direction === 'next');

    $date_query_key = $is_next ? 'after' : 'before';
    $order = $is_next ? 'ASC' : 'DESC';

    $query_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => $order,
        'date_query' => array(
            array(
                $date_query_key => $post->post_date,
                'inclusive' => false,
            ),
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $category_ids,
                'operator' => 'IN',
            ),
        ),
        'meta_query' => array(
            array(
                'key' => '_post_language',
                'value' => $language,
                'compare' => '=',
            ),
        ),
        'post__not_in' => array($post->ID),
    );

    $query = new WP_Query($query_args);
    if ($query->have_posts()) {
        $adjacent_post = $query->posts[0];
        wp_reset_postdata();
        return $adjacent_post;
    }

    wp_reset_postdata();
    return null;
}

function dlc_get_previous_service_post($language = 'en') {
    return dlc_get_adjacent_service_post('previous', $language);
}

function dlc_get_next_service_post($language = 'en') {
    return dlc_get_adjacent_service_post('next', $language);
}

// Helper to get contact URL for services CTA based on language
function dlc_get_service_contact_url($language = 'en') {
    $language = ($language === 'ar') ? 'ar' : 'en';
    $primary_slug = ($language === 'ar') ? 'contact-ar' : 'contact';
    $fallback_slug = ($language === 'ar') ? 'contact' : 'contact-ar';
    
    // Try to find the page by slug
    $contact_page = get_page_by_path($primary_slug);
    if ($contact_page) {
        return get_permalink($contact_page);
    }
    
    // Fallback to alternate slug
    $contact_page = get_page_by_path($fallback_slug);
    if ($contact_page) {
        return get_permalink($contact_page);
    }
    
    // Final fallback to manual URL
    $fallback_path = ($language === 'ar') ? '/contact-ar/' : '/contact/';
    return home_url($fallback_path);
}

// Generic helper function to get the archive URL for a post based on its category type and language
function dlc_get_post_archive_url($post_id = null, $language = null) {
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }
    
    if (!$language) {
        $language = get_post_meta($post_id, '_post_language', true) ?: 'en';
    }
    
    $is_news = dlc_is_news_post($post_id);
    
    if ($is_news) {
        // Get news category based on language
        if ($language === 'ar') {
            $category = get_category_by_slug('news-ar');
        } else {
            $category = get_category_by_slug('news');
        }
    } else {
        // Get blog category based on language
        if ($language === 'ar') {
            $category = get_category_by_slug('blog-ar');
            if (!$category) {
                $category = get_term_by('name', 'المدونه', 'category');
            }
        } else {
            $category = get_category_by_slug('blog');
            if (!$category) {
                $category = get_term_by('name', 'Blog', 'category');
            }
        }
    }
    
    if ($category) {
        return get_category_link($category->term_id);
    }
    
    // Fallback
    return get_permalink(get_option('page_for_posts')) ?: home_url();
}

// Generic helper function to get adjacent post filtered by language and category type
function dlc_get_adjacent_post_by_language_and_category($direction = 'next', $language = 'en') {
    global $post;
    if (!$post) return null;
    
    $current_post_date = $post->post_date;
    $is_news_post = dlc_is_news_post($post->ID);
    $category_type = $is_news_post ? 'news' : 'blog';
    $category_ids = dlc_get_category_ids_by_type($category_type, !$is_news_post);
    
    $date_query_key = ($direction === 'next') ? 'after' : 'before';
    $date_query = array(
        array(
            $date_query_key => $current_post_date,
        ),
    );
    
    $query_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => ($direction === 'next') ? 'ASC' : 'DESC',
        'date_query' => $date_query,
        'meta_query' => array(
            array(
                'key' => '_post_language',
                'value' => $language,
                'compare' => '='
            )
        ),
        'post__not_in' => array($post->ID)
    );
    
    if (!empty($category_ids)) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $category_ids,
                'operator' => 'IN'
            )
        );
    }
    
    $query = new WP_Query($query_args);
    return $query->have_posts() ? $query->posts[0] : null;
}

// Helper function to get previous post filtered by language and category type (news/blog)
function get_previous_post_by_language_and_category($language = 'en') {
    return dlc_get_adjacent_post_by_language_and_category('previous', $language);
}

// Helper function to get next post filtered by language and category type (news/blog)
function get_next_post_by_language_and_category($language = 'en') {
    return dlc_get_adjacent_post_by_language_and_category('next', $language);
}

// Enable post thumbnails and HTML5 comment support
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Custom comment callback to remove "says" text
function dlc_custom_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body">
            <div class="comment-meta">
                <?php echo get_avatar($comment, 48, '', '', array('class' => 'comment-avatar')); ?>
                <div class="comment-author-meta">
                    <span class="comment-author">
                        <span class="fn"><?php comment_author(); ?></span>
                    </span>
                    <span class="comment-metadata">
                        <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                            <time datetime="<?php comment_time('c'); ?>">
                                <?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?>
                            </time>
                        </a>
                    </span>
                </div>
            </div>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
            <?php if ($args['max_depth'] != 1 && comments_open()) : ?>
                <div class="reply">
                    <?php comment_reply_link(array_merge($args, array(
                        'reply_text' => __('Reply', 'dlc'),
                        'depth' => $depth,
                        'max_depth' => $args['max_depth']
                    ))); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php
}
