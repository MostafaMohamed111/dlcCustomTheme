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

    else if (is_archive()) {
        // Check if it's a news category
        $is_news_category = false;
        $queried_object = get_queried_object();
        if (isset($queried_object->slug) && strpos($queried_object->slug, 'news') !== false) {
            $is_news_category = true;
        }
        
        if ($is_news_category) {
            // News archive page
            wp_register_style('news-page', get_template_directory_uri() . '/assets/en/news.css', array('main'), '1.0.0', 'all');
            wp_enqueue_style('news-page');
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
        
        // Determine if we're viewing news or blog
        if (is_category() && isset($queried_object->slug)) {
            $slug = $queried_object->slug;
            // Check if it's a news category (news or news-ar)
            if ($slug === 'news' || $slug === 'news-ar' || strpos($slug, 'news') !== false) {
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
            $is_blog_category = true;
        } elseif (is_single() && get_post_type() == 'post') {
            // On single post - check post categories
            $post_categories = get_the_category();
            foreach ($post_categories as $cat) {
                if ($cat->slug === 'news' || $cat->slug === 'news-ar' || strpos($cat->slug, 'news') !== false) {
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
        
        // Get menu item URL
        $menu_url = $item->url;
        
        // Check if this menu item is for Blog
        $blog_category = get_category_by_slug('blog');
        $blog_ar_category = get_category_by_slug('blog-ar');
        $is_blog_menu_item = false;
        $is_news_menu_item = false;
        
        if ($blog_category) {
            $blog_url = get_category_link($blog_category->term_id);
            if (strpos($menu_url, $blog_url) !== false || 
                strpos($menu_url, '/category/blog') !== false ||
                strpos($menu_url, '/blog') !== false) {
                $is_blog_menu_item = true;
            }
        }
        
        if ($blog_ar_category) {
            $blog_ar_url = get_category_link($blog_ar_category->term_id);
            if (strpos($menu_url, $blog_ar_url) !== false || 
                strpos($menu_url, '/category/blog-ar') !== false) {
                $is_blog_menu_item = true;
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
        
        // Remove existing active classes first
        $classes = array_diff($classes, array('current-menu-item', 'current_page_item', 'current_page_parent', 'current_page_ancestor'));
        
        // Only add active class if the menu item type matches the current page type
        if ($is_news_category && $is_news_menu_item) {
            $classes[] = 'current-menu-item';
        } elseif ($is_blog_category && $is_blog_menu_item) {
            $classes[] = 'current-menu-item';
        } elseif (!$is_news_category && !$is_blog_category && $is_blog_menu_item) {
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

// Helper function to get previous post filtered by language and category type (news/blog)
function get_previous_post_by_language_and_category($language = 'en') {
    global $post;
    $current_post_date = $post->post_date;
    
    // Determine if current post is news or blog
    $post_categories = get_the_category($post->ID);
    $is_news_post = false;
    $category_ids = array();
    
    foreach ($post_categories as $cat) {
        $category_ids[] = $cat->term_id;
        // Check if it's a news category
        if ($cat->slug === 'news' || $cat->slug === 'news-ar' || strpos($cat->slug, 'news') !== false) {
            $is_news_post = true;
            break;
        }
    }
    
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
    
    // Filter by category type
    if ($is_news_post) {
        // Only get news posts
        $news_category = get_category_by_slug('news');
        $news_ar_category = get_category_by_slug('news-ar');
        $news_cat_ids = array();
        if ($news_category) $news_cat_ids[] = $news_category->term_id;
        if ($news_ar_category) $news_cat_ids[] = $news_ar_category->term_id;
        
        if (!empty($news_cat_ids)) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $news_cat_ids,
                    'operator' => 'IN'
                )
            );
        }
    } else {
        // Only get blog posts (blog, blog-ar, and their children)
        $blog_category = get_category_by_slug('blog');
        $blog_ar_category = get_category_by_slug('blog-ar');
        $blog_cat_ids = array();
        if ($blog_category) $blog_cat_ids[] = $blog_category->term_id;
        if ($blog_ar_category) $blog_cat_ids[] = $blog_ar_category->term_id;
        
        // Get all children of blog categories
        if ($blog_category) {
            $blog_children = get_term_children($blog_category->term_id, 'category');
            if (!is_wp_error($blog_children)) {
                $blog_cat_ids = array_merge($blog_cat_ids, $blog_children);
            }
        }
        if ($blog_ar_category) {
            $blog_ar_children = get_term_children($blog_ar_category->term_id, 'category');
            if (!is_wp_error($blog_ar_children)) {
                $blog_cat_ids = array_merge($blog_cat_ids, $blog_ar_children);
            }
        }
        
        if (!empty($blog_cat_ids)) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $blog_cat_ids,
                    'operator' => 'IN'
                )
            );
        }
    }
    
    $query = new WP_Query($query_args);
    return $query->have_posts() ? $query->posts[0] : null;
}

// Helper function to get next post filtered by language and category type (news/blog)
function get_next_post_by_language_and_category($language = 'en') {
    global $post;
    $current_post_date = $post->post_date;
    
    // Determine if current post is news or blog
    $post_categories = get_the_category($post->ID);
    $is_news_post = false;
    $category_ids = array();
    
    foreach ($post_categories as $cat) {
        $category_ids[] = $cat->term_id;
        // Check if it's a news category
        if ($cat->slug === 'news' || $cat->slug === 'news-ar' || strpos($cat->slug, 'news') !== false) {
            $is_news_post = true;
            break;
        }
    }
    
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
    
    // Filter by category type
    if ($is_news_post) {
        // Only get news posts
        $news_category = get_category_by_slug('news');
        $news_ar_category = get_category_by_slug('news-ar');
        $news_cat_ids = array();
        if ($news_category) $news_cat_ids[] = $news_category->term_id;
        if ($news_ar_category) $news_cat_ids[] = $news_ar_category->term_id;
        
        if (!empty($news_cat_ids)) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $news_cat_ids,
                    'operator' => 'IN'
                )
            );
        }
    } else {
        // Only get blog posts (blog, blog-ar, and their children)
        $blog_category = get_category_by_slug('blog');
        $blog_ar_category = get_category_by_slug('blog-ar');
        $blog_cat_ids = array();
        if ($blog_category) $blog_cat_ids[] = $blog_category->term_id;
        if ($blog_ar_category) $blog_cat_ids[] = $blog_ar_category->term_id;
        
        // Get all children of blog categories
        if ($blog_category) {
            $blog_children = get_term_children($blog_category->term_id, 'category');
            if (!is_wp_error($blog_children)) {
                $blog_cat_ids = array_merge($blog_cat_ids, $blog_children);
            }
        }
        if ($blog_ar_category) {
            $blog_ar_children = get_term_children($blog_ar_category->term_id, 'category');
            if (!is_wp_error($blog_ar_children)) {
                $blog_cat_ids = array_merge($blog_cat_ids, $blog_ar_children);
            }
        }
        
        if (!empty($blog_cat_ids)) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $blog_cat_ids,
                    'operator' => 'IN'
                )
            );
        }
    }
    
    $query = new WP_Query($query_args);
    return $query->have_posts() ? $query->posts[0] : null;
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
