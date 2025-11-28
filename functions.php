<?php

// Constants
define('DLC_POSTS_PER_PAGE', 6);
define('DLC_EXCERPT_LENGTH_SERVICE', 120);
define('DLC_EXCERPT_LENGTH_POST', 150);

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

/**
 * Register Booking Request custom post type for storing booking form submissions
 */
function dlc_register_booking_request_cpt() {
    $labels = array(
        'name'               => __('Bookings', 'dlc'),
        'singular_name'      => __('Booking', 'dlc'),
        'menu_name'          => __('Bookings', 'dlc'),
        'add_new'            => __('Add Booking', 'dlc'),
        'add_new_item'       => __('Add New Booking', 'dlc'),
        'edit_item'          => __('Edit Booking', 'dlc'),
        'new_item'           => __('New Booking', 'dlc'),
        'view_item'          => __('View Booking', 'dlc'),
        'search_items'       => __('Search Bookings', 'dlc'),
        'not_found'          => __('No bookings found', 'dlc'),
        'not_found_in_trash' => __('No bookings found in Trash', 'dlc'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array('title'),
        'capability_type'    => 'post',
        'map_meta_cap'       => true,
    );

    register_post_type('booking_request', $args);
}
add_action('init', 'dlc_register_booking_request_cpt');

/**
 * Customize admin columns for booking requests
 */
function dlc_booking_request_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $label) {
        $new_columns[$key] = $label;

        if ($key === 'title') {
            $new_columns['booking_service_type'] = __('Service Type', 'dlc');
            $new_columns['booking_service'] = __('Service', 'dlc');
            $new_columns['booking_email'] = __('Email', 'dlc');
        }
    }

    if (!isset($new_columns['date'])) {
        $new_columns['date'] = __('Date', 'dlc');
    }

    return $new_columns;
}
add_filter('manage_booking_request_posts_columns', 'dlc_booking_request_columns');

function dlc_booking_request_column_content($column, $post_id) {
    switch ($column) {
        case 'booking_service_type':
            $service_type = get_post_meta($post_id, '_service_type', true);
            $type_labels = array(
                'companies' => __('Companies', 'dlc'),
                'individual' => __('Individuals', 'dlc'),
                'international' => __('International', 'dlc')
            );
            $label = isset($type_labels[$service_type]) ? $type_labels[$service_type] : ucfirst($service_type);
            echo '<span class="booking-type-badge booking-type-' . esc_attr($service_type) . '">' . esc_html($label) . '</span>';
            break;
        case 'booking_service':
            $service_title = get_post_meta($post_id, '_service_title', true);
            echo esc_html($service_title ? $service_title : __('N/A', 'dlc'));
            break;
        case 'booking_email':
            $email = get_post_meta($post_id, '_email', true);
            if ($email) {
                printf(
                    '<a href="mailto:%1$s">%1$s</a>',
                    esc_html($email)
                );
            } else {
                echo __('N/A', 'dlc');
            }
            break;
    }
}
add_action('manage_booking_request_posts_custom_column', 'dlc_booking_request_column_content', 10, 2);

/**
 * Add service type filter dropdown to booking requests admin
 */
function dlc_booking_request_filters() {
    global $typenow;
    
    if ($typenow === 'booking_request') {
        $current_type = isset($_GET['service_type']) ? sanitize_text_field($_GET['service_type']) : '';
        ?>
        <select name="service_type">
            <option value=""><?php _e('All Service Types', 'dlc'); ?></option>
            <option value="companies" <?php selected($current_type, 'companies'); ?>><?php _e('Companies', 'dlc'); ?></option>
            <option value="individual" <?php selected($current_type, 'individual'); ?>><?php _e('Individuals', 'dlc'); ?></option>
            <option value="international" <?php selected($current_type, 'international'); ?>><?php _e('International', 'dlc'); ?></option>
        </select>
        <?php
    }
}
add_action('restrict_manage_posts', 'dlc_booking_request_filters');

/**
 * Filter booking requests by service type
 */
function dlc_booking_request_filter_query($query) {
    global $pagenow, $typenow;
    
    if ($pagenow === 'edit.php' && $typenow === 'booking_request' && isset($_GET['service_type']) && $_GET['service_type'] !== '') {
        $service_type = sanitize_text_field($_GET['service_type']);
        $query->set('meta_query', array(
            array(
                'key' => '_service_type',
                'value' => $service_type,
                'compare' => '='
            )
        ));
    }
}
add_filter('parse_query', 'dlc_booking_request_filter_query');

/**
 * Make service type column sortable
 */
function dlc_booking_request_sortable_columns($columns) {
    $columns['booking_service_type'] = 'service_type';
    return $columns;
}
add_filter('manage_edit-booking_request_sortable_columns', 'dlc_booking_request_sortable_columns');

/**
 * Handle sorting by service type
 */
function dlc_booking_request_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    if ($query->get('post_type') !== 'booking_request') {
        return;
    }
    
    if ($query->get('orderby') === 'service_type') {
        $query->set('meta_key', '_service_type');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'dlc_booking_request_orderby');

/**
 * Add custom CSS for booking type badges in admin
 */
function dlc_booking_admin_styles() {
    global $typenow;
    if ($typenow === 'booking_request') {
        ?>
        <style>
            .booking-type-badge {
                display: inline-block;
                padding: 4px 10px;
                border-radius: 3px;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
            }
            .booking-type-companies {
                background: #e3f2fd;
                color: #1976d2;
            }
            .booking-type-individual {
                background: #f3e5f5;
                color: #7b1fa2;
            }
            .booking-type-international {
                background: #e8f5e9;
                color: #388e3c;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'dlc_booking_admin_styles');

/**
 * Add meta box to display booking details
 */
function dlc_add_booking_details_meta_box() {
    add_meta_box(
        'booking_details',
        __('Booking Details', 'dlc'),
        'dlc_render_booking_details_meta_box',
        'booking_request',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'dlc_add_booking_details_meta_box');

function dlc_render_booking_details_meta_box($post) {
    $service_type = get_post_meta($post->ID, '_service_type', true);
    $service_title = get_post_meta($post->ID, '_service_title', true);
    $name = get_post_meta($post->ID, '_name', true);
    $phone = get_post_meta($post->ID, '_phone', true);
    $email = get_post_meta($post->ID, '_email', true);
    $city = get_post_meta($post->ID, '_city', true);
    $case_brief = get_post_meta($post->ID, '_case_brief', true);
    $has_documents = get_post_meta($post->ID, '_has_documents', true);
    $previous_lawyer = get_post_meta($post->ID, '_previous_lawyer', true);
    $meeting_type = get_post_meta($post->ID, '_meeting_type', true);
    $submitted_date = get_post_meta($post->ID, '_submitted_date', true);
    ?>
    <style>
        .booking-details-table { width: 100%; border-collapse: collapse; }
        .booking-details-table th { text-align: left; padding: 10px; background: #f0f0f1; font-weight: 600; width: 200px; }
        .booking-details-table td { padding: 10px; border-bottom: 1px solid #ddd; }
        .booking-details-section { margin-bottom: 20px; }
        .booking-details-section h3 { margin: 0 0 10px 0; padding: 10px; background: #2271b1; color: white; }
        .case-brief-content { background: #f9f9f9; padding: 15px; border-radius: 4px; white-space: pre-wrap; }
    </style>
    
    <div class="booking-details-section">
        <h3><?php _e('Client Information', 'dlc'); ?></h3>
        <table class="booking-details-table">
            <tr>
                <th><?php _e('Name:', 'dlc'); ?></th>
                <td><?php echo esc_html($name); ?></td>
            </tr>
            <tr>
                <th><?php _e('Email:', 'dlc'); ?></th>
                <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
            </tr>
            <tr>
                <th><?php _e('Phone:', 'dlc'); ?></th>
                <td><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></td>
            </tr>
            <tr>
                <th><?php _e('City:', 'dlc'); ?></th>
                <td><?php echo esc_html($city ? $city : __('Not specified', 'dlc')); ?></td>
            </tr>
        </table>
    </div>
    
    <div class="booking-details-section">
        <h3><?php _e('Service Information', 'dlc'); ?></h3>
        <table class="booking-details-table">
            <tr>
                <th><?php _e('Service Type:', 'dlc'); ?></th>
                <td><?php echo esc_html(ucfirst($service_type)); ?> Services</td>
            </tr>
            <tr>
                <th><?php _e('Service:', 'dlc'); ?></th>
                <td><?php echo esc_html($service_title); ?></td>
            </tr>
            <tr>
                <th><?php _e('Meeting Type:', 'dlc'); ?></th>
                <td><?php echo esc_html(ucfirst($meeting_type)); ?></td>
            </tr>
        </table>
    </div>
    
    <div class="booking-details-section">
        <h3><?php _e('Case Details', 'dlc'); ?></h3>
        <table class="booking-details-table">
            <tr>
                <th><?php _e('Has Documents:', 'dlc'); ?></th>
                <td><?php echo esc_html(ucfirst($has_documents)); ?></td>
            </tr>
            <tr>
                <th><?php _e('Previous Lawyer:', 'dlc'); ?></th>
                <td><?php echo esc_html(ucfirst($previous_lawyer)); ?></td>
            </tr>
            <tr>
                <th><?php _e('Case Brief:', 'dlc'); ?></th>
                <td><div class="case-brief-content"><?php echo esc_html($case_brief); ?></div></td>
            </tr>
        </table>
    </div>
    
    <div class="booking-details-section">
        <h3><?php _e('Submission Information', 'dlc'); ?></h3>
        <table class="booking-details-table">
            <tr>
                <th><?php _e('Submitted Date:', 'dlc'); ?></th>
                <td><?php echo esc_html($submitted_date ? date('F j, Y g:i a', strtotime($submitted_date)) : $post->post_date); ?></td>
            </tr>
        </table>
    </div>
    <?php
}

// Helper: Truncate excerpt to specified length
function dlc_truncate_excerpt($excerpt, $length) {
    if (strlen($excerpt) <= $length) {
        return $excerpt;
    }
    $truncated = substr($excerpt, 0, $length);
    $truncated = substr($truncated, 0, strrpos($truncated, ' '));
    return $truncated . '...';
}

// Helper: Get category with children IDs
function dlc_get_category_tree_ids($category_slug) {
    $category = get_category_by_slug($category_slug);
    if (!$category) {
        return array();
    }
    
    $category_ids = array($category->term_id);
    $children = get_term_children($category->term_id, 'category');
    if (!is_wp_error($children)) {
        $category_ids = array_merge($category_ids, $children);
    }
    
    return $category_ids;
}

// Show Blog category posts on main archive/blog page and set posts per page
function show_blog_category_posts($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Set posts per page for all archive pages
        if (is_archive() || is_category() || is_tag()) {
            $query->set('posts_per_page', DLC_POSTS_PER_PAGE);
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

// Block access to child category URLs
add_action('template_redirect', function() {
    if (is_category()) {
        $category = get_queried_object();
        
        // Check if this category has a parent
        if ($category && $category->parent != 0) {
            // This is a child category - redirect to 404
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
            nocache_headers();
        }
    }
});

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
    $base_slug_map = array(
        'individual' => 'individual-services',
        'home-international' => 'home-international',
        'international' => 'home-international',
        'companies' => 'companies-services'
    );
    
    $base_slug = $base_slug_map[$service_type] ?? 'companies-services';
    $slug = ($language === 'ar') ? $base_slug . '-ar' : $base_slug;
    return dlc_get_category_tree_ids($slug);
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

// Shorthand wrappers for service post navigation
function dlc_get_previous_service_post($language = 'en') {
    return dlc_get_adjacent_service_post('previous', $language);
}

function dlc_get_next_service_post($language = 'en') {
    return dlc_get_adjacent_service_post('next', $language);
}

// Shorthand wrappers for blog/news post navigation
function get_previous_post_by_language_and_category($language = 'en') {
    return dlc_get_adjacent_post_by_language_and_category('previous', $language);
}

function get_next_post_by_language_and_category($language = 'en') {
    return dlc_get_adjacent_post_by_language_and_category('next', $language);
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
add_action('wp_ajax_get_service_type', 'get_service_type');
add_action('wp_ajax_nopriv_get_service_type', 'get_service_type');

function get_service_type() {
    $service_id = intval($_POST['service_id']);
    
    if (!$service_id) {
        wp_send_json_error('Invalid service ID.');
    }
    
    // Get post categories including parents
    $categories = get_the_category($service_id);
    $service_type = '';
    
    foreach ($categories as $category) {
        // Check current category and all parent categories
        $cat_to_check = $category;
        
        while ($cat_to_check) {
            $slug = $cat_to_check->slug;
            
            // Check which service type this belongs to
            if (strpos($slug, 'companies-services') !== false) {
                $service_type = 'companies';
                break 2; // Break both loops
            } elseif (strpos($slug, 'individual-services') !== false) {
                $service_type = 'individual';
                break 2;
            } elseif (strpos($slug, 'home-international') !== false) {
                $service_type = 'international';
                break 2;
            }
            
            // Check parent category
            if ($cat_to_check->parent) {
                $cat_to_check = get_category($cat_to_check->parent);
            } else {
                break;
            }
        }
    }
    
    if ($service_type) {
        wp_send_json_success(array('service_type' => $service_type));
    } else {
        wp_send_json_error('Could not determine service type.');
    }
}

add_action('wp_ajax_get_booking_services', 'get_booking_services');
add_action('wp_ajax_nopriv_get_booking_services', 'get_booking_services');

function get_booking_services() {
    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'booking_form_nonce')) {
        wp_send_json_error('Security check failed.');
    }

    $service_type = sanitize_text_field($_POST['service_type']);
    $language = isset($_POST['language']) ? sanitize_text_field($_POST['language']) : 'en';
    
    // Map service type to category slug based on language
    $category_slug = '';
    $suffix = ($language === 'ar') ? '-ar' : '';
    
    switch ($service_type) {
        case 'companies':
            $category_slug = 'companies-services' . $suffix;
            break;
        case 'individual':
            $category_slug = 'individual-services' . $suffix;
            break;
        case 'international':
            $category_slug = 'home-international' . $suffix;
            break;
        default:
            wp_send_json_error('Invalid service type.');
            return;
    }

    // Get category tree
    $category_ids = dlc_get_category_tree_ids($category_slug);
    
    if (empty($category_ids)) {
        wp_send_json_error('Category not found.');
        return;
    }

    // Get all posts from these categories with language filter
    $query_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'category__in' => $category_ids,
        'meta_query' => array(
            array(
                'key' => '_post_language',
                'value' => $language,
                'compare' => '='
            )
        )
    );

    $services_query = new WP_Query($query_args);
    $services = array();

    if ($services_query->have_posts()) {
        while ($services_query->have_posts()) {
            $services_query->the_post();
            $services[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'slug' => get_post_field('post_name', get_the_ID())
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
    $service_slug = isset($_POST['service_slug']) ? sanitize_text_field($_POST['service_slug']) : '';
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

    // Get service slug if not provided
    if (empty($service_slug)) {
        $service_slug = get_post_field('post_name', $service_id);
    }
    
    // Remove -ar suffix from slug if present for consistent naming
    $base_slug = str_replace('-ar', '', $service_slug);
    
    // Create service name from slug (capitalize and replace hyphens with spaces)
    $service_name = ucwords(str_replace('-', ' ', $base_slug));
    
    // Get actual service title for email
    $service_display_title = get_the_title($service_id);
    if (empty($service_display_title)) {
        $service_display_title = $service_name;
    }

    // Create booking post in admin dashboard with slug-based service name
    $booking_post_id = wp_insert_post(array(
        'post_type'   => 'booking_request',
        'post_title'  => sprintf('%s – %s', $name, $service_name),
        'post_status' => 'publish',
    ));

    if (!is_wp_error($booking_post_id) && $booking_post_id) {
        // Save all booking data as post meta
        update_post_meta($booking_post_id, '_service_type', $service_type);
        update_post_meta($booking_post_id, '_service_id', $service_id);
        update_post_meta($booking_post_id, '_service_slug', $base_slug);
        update_post_meta($booking_post_id, '_service_title', $service_name);
        update_post_meta($booking_post_id, '_name', $name);
        update_post_meta($booking_post_id, '_phone', $phone);
        update_post_meta($booking_post_id, '_email', $email);
        update_post_meta($booking_post_id, '_city', $city);
        update_post_meta($booking_post_id, '_case_brief', $case_brief);
        update_post_meta($booking_post_id, '_has_documents', $has_documents);
        update_post_meta($booking_post_id, '_previous_lawyer', $previous_lawyer);
        update_post_meta($booking_post_id, '_meeting_type', $meeting_type);
        update_post_meta($booking_post_id, '_submitted_via', 'booking_form');
        update_post_meta($booking_post_id, '_submitted_date', current_time('mysql'));
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
    $posts_per_page = DLC_POSTS_PER_PAGE;
    $is_services_page = $parent_category_id > 0;

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
                            <?php echo esc_html(dlc_truncate_excerpt(get_the_excerpt(), DLC_EXCERPT_LENGTH_SERVICE)); ?>
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
                                <?php echo dlc_truncate_excerpt(get_the_excerpt(), DLC_EXCERPT_LENGTH_POST); ?>
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
