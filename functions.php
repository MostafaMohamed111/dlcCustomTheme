<?php

// Helper: Detect if current page is Arabic
function dlc_is_arabic_page() {
    static $is_arabic_page = null;
    
    if ($is_arabic_page !== null) {
        return $is_arabic_page;
    }
    
    $is_arabic_page = false;
    
    // Check template slug pattern
    if (function_exists('get_page_template_slug')) {
        $template = get_page_template_slug();
        if ($template && preg_match('/-ar(\.php)?$/', $template)) {
            $is_arabic_page = true;
            return $is_arabic_page;
        }
    }
    
    // Check template file basename
    $template_file = get_page_template();
    if ($template_file && is_string($template_file)) {
        if (preg_match('/-ar\.php$/', basename($template_file))) {
            $is_arabic_page = true;
            return $is_arabic_page;
        }
    }
    
    // Check post language meta
    if (is_single() && get_post_type() == 'post') {
        $post_language = get_post_meta(get_the_ID(), '_post_language', true);
        if ($post_language === 'ar') {
            $is_arabic_page = true;
            return $is_arabic_page;
        }
    }
    
    // Check archive category slug
    if (is_archive()) {
        $queried_object = get_queried_object();
        if (isset($queried_object->slug) && strpos($queried_object->slug, '-ar') !== false) {
            $is_arabic_page = true;
            return $is_arabic_page;
        }
    }
    
    // Check RTL setting
    if (is_rtl()) {
        $is_arabic_page = true;
    }
    
    return $is_arabic_page;
}

// Helper: Detect service category type
function dlc_get_archive_service_type() {
    if (!is_archive()) {
        return null;
    }
    
    $queried_object = get_queried_object();
    if (!isset($queried_object->slug)) {
        return null;
    }
    
    $slug = $queried_object->slug;
    $term_id = isset($queried_object->term_id) ? $queried_object->term_id : 0;
    
    $service_types = array(
        'companies-services' => array('slug' => 'companies-services', 'type' => 'companies'),
        'individual-services' => array('slug' => 'individual-services', 'type' => 'individual'),
        'home-international' => array('slug' => 'home-international', 'type' => 'international')
    );
    
    foreach ($service_types as $config) {
        if (strpos($slug, $config['slug']) !== false) {
            return $config['type'];
        }
        
        if ($term_id) {
            $parent = get_category_by_slug($config['slug']);
            if ($parent && ($term_id === $parent->term_id || cat_is_ancestor_of($parent->term_id, $term_id))) {
                return $config['type'];
            }
        }
    }
    
    return null;
}

function enqueue_theme_css() {
    $is_arabic_page = dlc_is_arabic_page();

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

    // Enqueue page-specific CSS
    switch (true) {
        case is_front_page():
        case is_page_template('front-page-ar.php'):
            wp_register_style('front-page', get_template_directory_uri() . '/assets/en/front-page.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('front-page');
            break;
            
        case is_page_template('services.php'):
        case is_page_template('services-ar.php'):
            wp_register_style('services-page', get_template_directory_uri() . '/assets/en/services.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('services-page');
            break;
            
        case is_page_template('secure-yourself.php'):
        case is_page_template('secure-yourself-ar.php'):
            wp_register_style('secure-yourself-page', get_template_directory_uri() . '/assets/en/secure-yourself.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('secure-yourself-page');
            break;
            
        case is_page_template('contact-us.php'):
        case is_page_template('contact-us-ar.php'):
            wp_register_style('contact-us-page', get_template_directory_uri() . '/assets/en/contact-us.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('contact-us-page');
            break;
            
        case is_page_template('about-us.php'):
        case is_page_template('about-us-ar.php'):
            wp_register_style('about-us-page', get_template_directory_uri() . '/assets/en/about-us.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('about-us-page');
            break;
            
        case is_page_template('privacy-policy.php'):
        case is_page_template('privacy-policy-ar.php'):
        case is_page(get_option('wp_page_for_privacy_policy')):
            wp_register_style('privacy-policy-page', get_template_directory_uri() . '/assets/en/privacy-policy.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('privacy-policy-page');
            break;

        case is_page_template('booking.php'):
        case is_page_template('booking-ar.php'):
            wp_register_style('booking-page', get_template_directory_uri() . '/assets/en/booking.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('booking-page');
            break;
            
        case is_404():
            wp_register_style('error-page', get_template_directory_uri() . '/assets/en/error.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('error-page');
            break;
    }

    if (is_archive()) {
        $service_type = dlc_get_archive_service_type();
        $queried_object = get_queried_object();
        $is_news = isset($queried_object->slug) && strpos($queried_object->slug, 'news') !== false;
        
        if ($is_news) {
            wp_register_style('news-page', get_template_directory_uri() . '/assets/en/news.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('news-page');
        } elseif ($service_type) {
            wp_register_style('services-page', get_template_directory_uri() . '/assets/en/companies-individual-services.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('services-page');
            
            if ($service_type === 'international') {
                wp_register_style('home-international-page', get_template_directory_uri() . '/assets/en/home-international.css', array('services-page'), '1.0.0', 'all');
                wp_enqueue_style('home-international-page');
            }
        } else {
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



// Helper: Localize AJAX script
function dlc_localize_ajax_script($handle, $nonce_action = null) {
    $data = array('ajaxurl' => admin_url('admin-ajax.php'));
    if ($nonce_action) {
        $data['nonce'] = wp_create_nonce($nonce_action);
    }
    wp_localize_script($handle, 'ajax_object', $data);
}

function enqueue_theme_scripts() {
    wp_enqueue_script( 'jquery' );

    wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '4.5.2', true );
    wp_enqueue_script( 'bootstrap-js' );

    wp_register_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
    wp_enqueue_script( 'main-js' );

    wp_register_script( 'scroll-animations', get_template_directory_uri() . '/assets/js/scroll-animations.js', array(), '1.0.0', true );
    wp_enqueue_script( 'scroll-animations' );

    if ( is_page_template('contact-us.php') || is_page_template('contact-us-ar.php') ) {
        wp_register_script( 'contact-us', get_template_directory_uri() . '/assets/js/contact-us.js', array(), '1.0.0', true );
        wp_enqueue_script( 'contact-us' );
        dlc_localize_ajax_script('contact-us');
    }

    if ( is_page_template('booking.php') || is_page_template('booking-ar.php') ) {
        wp_register_script( 'booking', get_template_directory_uri() . '/assets/js/booking.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'booking' );
        dlc_localize_ajax_script('booking');
    }

    if ( is_archive() || is_category() || is_tag() ) {
        wp_register_script( 'archive-ajax', get_template_directory_uri() . '/assets/js/archive.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'archive-ajax' );
        dlc_localize_ajax_script('archive-ajax', 'archive_ajax_nonce');
    }
}

add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts' );



// Theme setup
function dlc_theme_setup() {
    // Enable features
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register menus
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu'),
        'primary-ar-menu' => __('Primary Arabic Menu'),
        'footer-menu' => __('Footer Menu'),
        'footer-ar-menu' => __('Footer Arabic Menu'),
    ));
}
add_action('after_setup_theme', 'dlc_theme_setup');

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

add_action('wp_ajax_submit_contact_form', 'handle_contact_form_submission');
add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form_submission');

function handle_contact_form_submission() {

    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'contact_form_nonce')) {
        wp_send_json_error('Security check failed.');
    }

    // Sanitize
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error('Please fill all fields.');
    }

    if (!is_email($email)) {
        wp_send_json_error('Invalid email address.');
    }

    // Prepare email
    $to = get_option('admin_email');
    $subject = "New Contact Form Submission from $name";
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        "Reply-To: $name <$email>"
    ];

    $body = "
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
    ";

    // Send
    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success('Thank you! Your message has been sent.');
    } else {
        wp_send_json_error('Email sending failed. Please try again later.');
    }
}

// Booking form AJAX handlers
add_action('wp_ajax_get_booking_services', 'get_booking_services');
add_action('wp_ajax_nopriv_get_booking_services', 'get_booking_services');

function get_booking_services() {
    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'booking_form_nonce')) {
        wp_send_json_error('Security check failed.');
    }

    $service_type = sanitize_text_field($_POST['service_type']);
    
    // Map service type to category slug
    $category_slug = '';
    switch ($service_type) {
        case 'companies':
            $category_slug = 'companies-services';
            break;
        case 'individual':
            $category_slug = 'individual-services';
            break;
        case 'international':
            $category_slug = 'home-international';
            break;
        default:
            wp_send_json_error('Invalid service type.');
            return;
    }

    // Get parent category
    $parent_category = get_category_by_slug($category_slug);
    
    if (!$parent_category) {
        wp_send_json_error('Category not found.');
        return;
    }

    // Get all category IDs (parent + children)
    $category_ids = array($parent_category->term_id);
    $children = get_term_children($parent_category->term_id, 'category');
    if (!is_wp_error($children)) {
        $category_ids = array_merge($category_ids, $children);
    }

    // Get all posts from these categories
    $query_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'category__in' => $category_ids
    );

    $services_query = new WP_Query($query_args);
    $services = array();

    if ($services_query->have_posts()) {
        while ($services_query->have_posts()) {
            $services_query->the_post();
            $services[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title()
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success($services);
}

add_action('wp_ajax_submit_booking_form', 'handle_booking_form_submission');
add_action('wp_ajax_nopriv_submit_booking_form', 'handle_booking_form_submission');

function handle_booking_form_submission() {
    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'booking_form_nonce')) {
        wp_send_json_error('Security check failed.');
    }

    // Sanitize and validate all fields
    $service_type = sanitize_text_field($_POST['service_type']);
    $name = sanitize_text_field($_POST['name']);
    $phone = sanitize_text_field($_POST['phone']);
    $email = sanitize_email($_POST['email']);
    $city = sanitize_text_field($_POST['city']);
    $service_id = intval($_POST['service']);
    $case_brief = sanitize_textarea_field($_POST['case_brief']);
    $has_documents = sanitize_text_field($_POST['has_documents']);
    $previous_lawyer = sanitize_text_field($_POST['previous_lawyer']);
    $meeting_type = sanitize_text_field($_POST['meeting_type']);

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($service_id) || empty($case_brief) || 
        empty($has_documents) || empty($previous_lawyer) || empty($meeting_type)) {
        wp_send_json_error('Please fill all required fields.');
    }

    if (!is_email($email)) {
        wp_send_json_error('Invalid email address.');
    }

    // Get service title
    $service_title = get_the_title($service_id);
    if (empty($service_title)) {
        $service_title = 'Unknown Service';
    }

    // Prepare email
    $to = get_option('admin_email');
    $subject = "New Consultation Booking Request from $name";
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        "Reply-To: $name <$email>"
    );

    $body = "
        <h2>New Consultation Booking Request</h2>
        <h3>Service Type: " . ucfirst($service_type) . " Services</h3>
        <h3>Personal Information</h3>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>City:</strong> $city</p>
        
        <h3>Consultation Information</h3>
        <p><strong>Service:</strong> $service_title</p>
        <p><strong>Case Brief:</strong><br>" . nl2br($case_brief) . "</p>
        <p><strong>Has Documents:</strong> " . ucfirst($has_documents) . "</p>
        <p><strong>Previous Lawyer:</strong> " . ucfirst($previous_lawyer) . "</p>
        
        <h3>Meeting Details</h3>
        <p><strong>Meeting Type:</strong> " . ucfirst($meeting_type) . "</p>
        
        <hr>
        <p><em>This booking was submitted through the website booking form.</em></p>
    ";

    // Send email
    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success('Booking submitted successfully.');
    } else {
        wp_send_json_error('Failed to submit booking. Please try again later.');
    }
}

// Archive AJAX handler
add_action('wp_ajax_load_archive_posts', 'load_archive_posts_ajax');
add_action('wp_ajax_nopriv_load_archive_posts', 'load_archive_posts_ajax');

function load_archive_posts_ajax() {
    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'archive_ajax_nonce')) {
        wp_send_json_error('Security check failed.');
    }

    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $parent_category_id = isset($_POST['parent_category_id']) ? intval($_POST['parent_category_id']) : 0;
    $paged = isset($_POST['paged']) ? max(1, intval($_POST['paged'])) : 1;
    $posts_per_page = 6; // Match the default posts per page
    $is_services_page = $parent_category_id > 0; // Services pages have parent_category_id

    // Setup query arguments
    $query_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    if ($is_services_page) {
        // Services page logic
        $parent_category = get_category($parent_category_id);
        if (!$parent_category) {
            wp_send_json_error('Parent category not found.');
            return;
        }

        // Check if this is an Arabic category (slug ends with '-ar')
        $is_arabic_category = (strpos($parent_category->slug, '-ar') !== false);
        
        // Add language filter for Arabic categories
        if ($is_arabic_category) {
            $query_args['meta_query'] = array(
                array(
                    'key' => '_post_language',
                    'value' => 'ar',
                    'compare' => '='
                )
            );
        }

        // Get all category IDs (parent + children)
        $all_category_ids = array($parent_category->term_id);
        $all_children = get_term_children($parent_category->term_id, 'category');
        if (!is_wp_error($all_children)) {
            $all_category_ids = array_merge($all_category_ids, $all_children);
        }

        if ($category_id > 0) {
            // Get specific child category and its children
            $selected_category = get_category($category_id);
            if ($selected_category) {
                $category_ids = array($selected_category->term_id);
                $children = get_term_children($selected_category->term_id, 'category');
                if (!is_wp_error($children)) {
                    $category_ids = array_merge($category_ids, $children);
                }
                $query_args['category__in'] = $category_ids;
                $category_title = $selected_category->name;
            } else {
                wp_send_json_error('Category not found.');
                return;
            }
        } else {
            // All services - get all posts from parent category and children
            $query_args['category__in'] = $all_category_ids;
            $category_title = $is_arabic_category ? 'جميع الخدمات' : 'All Services';
        }
    } else {
        // Blog archive page logic
        // Get the Blog parent category
        $blog_category = get_category_by_slug('blog');
        if (!$blog_category) {
            $blog_category = get_term_by('name', 'Blog', 'category');
        }

        if ($category_id > 0) {
            // Get specific category
            $category = get_category($category_id);
            if ($category) {
                $query_args['cat'] = $category_id;
                $category_title = $category->name;
            } else {
                wp_send_json_error('Category not found.');
                return;
            }
        } else {
            // All posts - get all posts from blog category and children
            if ($blog_category) {
                $category_ids = array($blog_category->term_id);
                $children = get_term_children($blog_category->term_id, 'category');
                if (!is_wp_error($children)) {
                    $category_ids = array_merge($category_ids, $children);
                }
                $query_args['category__in'] = $category_ids;
            }
            $category_title = 'All Posts';
        }
    }

    // Create custom query
    $archive_query = new WP_Query($query_args);

    // Buffer output for posts/services HTML
    ob_start();
    
    if ($archive_query->have_posts()) :
        // Determine if this is a services page or blog page
        if ($is_services_page) :
            ?>
            <div class="services-grid">
            <?php
            while ($archive_query->have_posts()) : $archive_query->the_post();
                ?>
                <article class="service-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="service-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail(
                                    'large',
                                    array(
                                        'class' => 'service-image',
                                        'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 33vw, 400px'
                                    )
                                ); ?>
                            </a>
                            <div class="service-category-badge">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    echo esc_html($categories[0]->name);
                                }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="service-content">
                        <h3 class="service-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        
                        <div class="service-excerpt">
                            <?php
                            $excerpt = get_the_excerpt();
                            $excerpt_length = 120;
                            if (strlen($excerpt) > $excerpt_length) {
                                $excerpt = substr($excerpt, 0, $excerpt_length);
                                $excerpt = substr($excerpt, 0, strrpos($excerpt, ' ')) . '...';
                            }
                            echo esc_html($excerpt);
                            ?>
                        </div>
                        
                        <div class="service-footer">
                            <a href="<?php the_permalink(); ?>" class="get-started-service-btn">
                                Get Started
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
                <?php
            endwhile;
            ?>
        </div>
        
        <?php
        // Pagination
        $total_pages = $archive_query->max_num_pages;
        if ($total_pages > 1) :
            ?>
            <div class="pagination-wrapper">
                <?php
                $prev_link = get_previous_posts_link('<i class="fa-solid fa-chevron-left"></i>', $archive_query->max_num_pages);
                $next_link = get_next_posts_link('<i class="fa-solid fa-chevron-right"></i>', $archive_query->max_num_pages);
                
                if ($prev_link || $next_link) :
                    ?>
                    <div class="pagination-simple">
                        <?php if ($prev_link) : ?>
                            <div class="pagination-arrow pagination-prev">
                                <?php echo $prev_link; ?>
                            </div>
                        <?php else : ?>
                            <div class="pagination-arrow pagination-prev disabled">
                                <span><i class="fa-solid fa-chevron-left"></i></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($next_link) : ?>
                            <div class="pagination-arrow pagination-next">
                                <?php echo $next_link; ?>
                            </div>
                        <?php else : ?>
                            <div class="pagination-arrow pagination-next disabled">
                                <span><i class="fa-solid fa-chevron-right"></i></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                endif;
                ?>
            </div>
            <?php
        endif;
        
        wp_reset_postdata();
        else :
            // Blog posts structure
            ?>
            <div class="posts-grid">
                <?php
                while ($archive_query->have_posts()) : $archive_query->the_post();
                    ?>
                    <article class="post-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail(
                                        'large',
                                        array(
                                            'class' => 'post-image',
                                            'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 80vw, 900px'
                                        )
                                    ); ?>
                                </a>
                                <div class="post-category-badge">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo esc_html($categories[0]->name);
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <div class="post-meta">
                                <span class="post-date">
                                    <i class="fa-solid fa-calendar"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                                <span class="post-author">
                                    <i class="fa-solid fa-user"></i>
                                    <?php the_author(); ?>
                                </span>
                            </div>
                            
                            <h3 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="post-excerpt">
                                <?php 
                                $excerpt = get_the_excerpt();
                                $excerpt_length = 150;
                                if (strlen($excerpt) > $excerpt_length) {
                                    $excerpt = substr($excerpt, 0, $excerpt_length);
                                    $excerpt = substr($excerpt, 0, strrpos($excerpt, ' ')) . '...';
                                }
                                echo $excerpt;
                                ?>
                            </div>
                            
                            <div class="post-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                    Read More
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                                <div class="post-meta-footer">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        $category_count = count($categories);
                                        ?>
                                        <div class="post-categories">
                                            <?php if ($category_count == 1) : ?>
                                                <a href="<?php echo get_category_link($categories[0]->term_id); ?>" class="post-category-link">
                                                    <i class="fa-solid fa-folder"></i>
                                                    <?php echo esc_html($categories[0]->name); ?>
                                                </a>
                                            <?php else : ?>
                                                <div class="categories-dropdown">
                                                    <button class="categories-dropdown-toggle" type="button">
                                                        <i class="fa-solid fa-folder"></i>
                                                        <span class="dropdown-text">Categories</span>
                                                        <i class="fa-solid fa-chevron-down"></i>
                                                    </button>
                                                    <div class="categories-dropdown-menu">
                                                        <?php foreach($categories as $category) : ?>
                                                            <a href="<?php echo get_category_link($category->term_id); ?>" class="dropdown-category-link">
                                                                <i class="fa-solid fa-folder"></i>
                                                                <?php echo esc_html($category->name); ?>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php
                                    }
                                    
                                    $tags = get_the_tags();
                                    if (!empty($tags)) {
                                        ?>
                                        <div class="post-tags">
                                            <?php foreach($tags as $tag) : ?>
                                                <a href="<?php echo get_tag_link($tag->term_id); ?>" class="post-tag-link">
                                                    <i class="fa-solid fa-hashtag"></i>
                                                    <?php echo esc_html($tag->name); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>
            
            <?php
            // Pagination
            $total_pages = $archive_query->max_num_pages;
            if ($total_pages > 1) :
                ?>
                <div class="pagination-wrapper">
                    <?php
                    $prev_link = get_previous_posts_link('<i class="fa-solid fa-chevron-left"></i>', $archive_query->max_num_pages);
                    $next_link = get_next_posts_link('<i class="fa-solid fa-chevron-right"></i>', $archive_query->max_num_pages);
                    
                    if ($prev_link || $next_link) :
                        ?>
                        <div class="pagination-simple">
                            <?php if ($prev_link) : ?>
                                <div class="pagination-arrow pagination-prev">
                                    <?php echo $prev_link; ?>
                                </div>
                            <?php else : ?>
                                <div class="pagination-arrow pagination-prev disabled">
                                    <span><i class="fa-solid fa-chevron-left"></i></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($next_link) : ?>
                                <div class="pagination-arrow pagination-next">
                                    <?php echo $next_link; ?>
                                </div>
                            <?php else : ?>
                                <div class="pagination-arrow pagination-next disabled">
                                    <span><i class="fa-solid fa-chevron-right"></i></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
                <?php
            endif;
            
            wp_reset_postdata();
        endif;
    else :
        ?>
        <div class="no-posts">
            <i class="fa-solid fa-file-circle-question"></i>
            <h3><?php echo $is_services_page ? 'No services found' : 'No posts found'; ?></h3>
            <p><?php echo $is_services_page ? 'There are no services available in this category at the moment.' : 'There are no posts in this category yet.'; ?></p>
        </div>
        <?php
    endif;
    
    $posts_html = ob_get_clean();
    
    // Get pagination HTML separately if needed
    ob_start();
    // Pagination is already included in posts_html above
    $pagination_html = ob_get_clean();
    
    wp_send_json_success(array(
        'posts_html' => $posts_html,
        'pagination_html' => $pagination_html,
        'category_title' => $category_title
    ));
}
