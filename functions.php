
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