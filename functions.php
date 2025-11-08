
<?php


function enqueue_theme_css() {
    // bootstrap CSS
    wp_register_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '4.5.2', 'all' );
    wp_enqueue_style( 'bootstrap' );

    // Font Awesome CSS
    wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/webfonts/all.min.css', array(), '6.0.0', 'all' );
    wp_enqueue_style( 'font-awesome' );

    function is_arabic() {
        $locale = get_locale();
        return strpos( $locale, 'ar' ) === 0;
    }
    // main CSS

    $is_arabic_page = is_rtl() || (function_exists('get_page_template_slug') && strpos(get_page_template_slug(), 'ar') !== false);
    
    // Enqueue appropriate main CSS based on language
    if ($is_arabic_page) {
        wp_register_style('main-ar', get_template_directory_uri() . '/assets/ar/main.css', array(), false, 'all');
        wp_enqueue_style('main-ar');
    } else {
        wp_register_style('main', get_template_directory_uri() . '/assets/en/main.css', array(), false, 'all');
        wp_enqueue_style('main');

        if ( is_front_page() ) {
            wp_register_style('front-page', get_template_directory_uri() . '/assets/en/front-page.css', array(), false, 'all');
            wp_enqueue_style('front-page');
        }
    }
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_css' );



function enqueue_theme_scripts() {
    wp_enqueue_script( 'jquery' );

    wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '4.5.2', true );
    wp_enqueue_script( 'bootstrap-js' );

    // Scroll animations script
    if ( is_front_page() ) {
        wp_register_script( 'scroll-animations', get_template_directory_uri() . '/assets/js/scroll-animations.js', array(), '1.0.0', true );
        wp_enqueue_script( 'scroll-animations' );
    }

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