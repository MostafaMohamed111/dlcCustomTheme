
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

    else if (is_archive()) {
        // Archive page
        wp_register_style('archive-page', get_template_directory_uri() . '/assets/en/archive.css', array('main'), '1.0.0', 'all');
        wp_enqueue_style('archive-page');
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

// Keep Blog menu item active on category pages
function keep_blog_menu_active($classes, $item) {
    // Check if we're on a blog/category page
    if (is_category() || is_archive() || (is_single() && get_post_type() == 'post')) {
        // Get the Blog category
        $blog_category = get_category_by_slug('blog');
        if (!$blog_category) {
            $blog_category = get_term_by('name', 'Blog', 'category');
        }
        
        // Check if this menu item links to the blog category or posts page
        if ($blog_category) {
            $blog_url = get_category_link($blog_category->term_id);
        } else {
            $blog_url = get_permalink(get_option('page_for_posts')) ?: home_url();
        }
        
        // If this menu item URL matches blog URL, add active class
        if (strpos($item->url, $blog_url) !== false || 
            (is_category() && strpos($item->url, '/category/') !== false) ||
            (is_archive() && strpos($item->url, '/blog') !== false)) {
            $classes[] = 'current-menu-item';
        }
    }
    
    return $classes;
}
add_filter('nav_menu_css_class', 'keep_blog_menu_active', 10, 2);

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

// Helper function to get previous post filtered by language
function get_previous_post_by_language($in_same_term = false, $excluded_terms = '', $taxonomy = 'category', $language = 'en') {
    global $post;
    $current_post_date = $post->post_date;
    
    $query_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'date_query' => array(
            array(
                'before' => $current_post_date,
            ),
        ),
        'meta_query' => array(
            array(
                'key' => '_post_language',
                'value' => $language,
                'compare' => '='
            )
        ),
        'post__not_in' => array($post->ID)
    );
    
    if ($in_same_term && $taxonomy) {
        $terms = wp_get_post_terms($post->ID, $taxonomy, array('fields' => 'ids'));
        if (!empty($terms)) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $terms
                )
            );
        }
    }
    
    $query = new WP_Query($query_args);
    return $query->have_posts() ? $query->posts[0] : null;
}

// Helper function to get next post filtered by language
function get_next_post_by_language($in_same_term = false, $excluded_terms = '', $taxonomy = 'category', $language = 'en') {
    global $post;
    $current_post_date = $post->post_date;
    
    $query_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'ASC',
        'date_query' => array(
            array(
                'after' => $current_post_date,
            ),
        ),
        'meta_query' => array(
            array(
                'key' => '_post_language',
                'value' => $language,
                'compare' => '='
            )
        ),
        'post__not_in' => array($post->ID)
    );
    
    if ($in_same_term && $taxonomy) {
        $terms = wp_get_post_terms($post->ID, $taxonomy, array('fields' => 'ids'));
        if (!empty($terms)) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $terms
                )
            );
        }
    }
    
    $query = new WP_Query($query_args);
    return $query->have_posts() ? $query->posts[0] : null;
}
