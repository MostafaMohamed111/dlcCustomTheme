<?php
/**
 * Single Post Template Router
 * Routes single posts to appropriate templates based on category type and language
 */

$post_id = get_the_ID();
$post_categories = wp_get_post_categories($post_id);

// Detect post language using Polylang
$is_arabic_post = false;
if (function_exists('pll_get_post_language')) {
    $post_language = pll_get_post_language($post_id);
$is_arabic_post = ($post_language === 'ar');
} else {
    $is_arabic_post = dlc_is_arabic_page();
}

$lang_suffix = $is_arabic_post ? 'ar' : 'en';

// Detect post category type using generic function
$category_type = null;
foreach ($post_categories as $cat_id) {
    $category_type = dlc_get_category_type_slug($cat_id);
    if ($category_type) {
        break;
    }
}

// Route to appropriate template based on category type slug
switch ($category_type) {
    case 'news':
        get_template_part('includes/news-single-pages/single-' . $lang_suffix);
        break;
    
    case 'companies-services':
    case 'individual-services':
    case 'home-international':
        get_template_part('includes/services-single-pages/single-' . $lang_suffix);
        break;
    
    case 'blog':
        get_template_part('includes/blog-single-pages/single-' . $lang_suffix);
        break;

    default:
        get_template_part('includes/general-single-pages/single-' . $lang_suffix);
        break;
}