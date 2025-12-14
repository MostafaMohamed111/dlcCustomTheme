<?php
/**
 * Archive Template Router
 * Routes category archives and custom post type archives to appropriate templates
 */

// Check if this is a custom post type archive
$post_type = get_post_type();
if (is_post_type_archive()) {
    $post_type = get_query_var('post_type');
}

$category_type = null;

// For custom post type archives, use the post type as category type
if ($post_type && $post_type !== 'post') {
    $category_type = $post_type;
} else {
    // For standard post archives, detect category type
    $category_type = dlc_get_category_type_slug();
}

// Route to appropriate template based on category type slug
switch ($category_type) {
    case 'news':
        get_template_part('categories/news');
        break;
        
    // case 'secure-yourself':
    //     get_template_part('categories/secure-yourself');
    //     break;

    case 'companies-services':
        get_template_part('categories/companies-services');
        break;
    
    case 'individual-services':
        get_template_part('categories/individual-services');
        break;
    
    case 'home-international':
        get_template_part('categories/international-services');
        break;
    
    case 'blog':
        get_template_part('categories/blog');
        break;
    
    case 'team':
        get_template_part('categories/team');
        break;
    
    default:
        get_template_part('categories/general');
}

?>
