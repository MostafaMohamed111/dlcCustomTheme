<?php
// Check the current post's language from post metadata
$post_language = get_post_meta(get_the_ID(), '_post_language', true);

// Determine if this is an Arabic post
$is_arabic_post = ($post_language === 'ar');

// Check if this post belongs to companies-services or individual-services categories (English or Arabic)
$is_service_post = false;
$post_categories = get_the_category();

foreach ($post_categories as $category) {
    $slug = $category->slug;
    // Check if the category is companies-services, companies-services-ar, individual-services, individual-services-ar, or their children
    if (strpos($slug, 'companies-services') !== false || 
        strpos($slug, 'individual-services') !== false) {
        $is_service_post = true;
        break;
    }
    
    // Also check if it's a child of companies-services, companies-services-ar, individual-services, or individual-services-ar
    $companies_cat = get_category_by_slug('companies-services');
    $companies_ar_cat = get_category_by_slug('companies-services-ar');
    $individual_cat = get_category_by_slug('individual-services');
    $individual_ar_cat = get_category_by_slug('individual-services-ar');
    
    if (($companies_cat && cat_is_ancestor_of($companies_cat->term_id, $category->term_id)) ||
        ($companies_ar_cat && cat_is_ancestor_of($companies_ar_cat->term_id, $category->term_id)) ||
        ($individual_cat && cat_is_ancestor_of($individual_cat->term_id, $category->term_id)) ||
        ($individual_ar_cat && cat_is_ancestor_of($individual_ar_cat->term_id, $category->term_id))) {
        $is_service_post = true;
        break;
    }
}

// Load the appropriate single post template based on category and language
if ($is_service_post) {
    // Service post
    if ($is_arabic_post) {
        get_template_part('includes/arabic-service-single');
    } else {
        get_template_part('includes/english-service-single');
    }
} else {
    // Regular blog/news post
    if ($is_arabic_post) {
        get_template_part('includes/arabic-single');
    } else {
        get_template_part('includes/english-single');
    }
}