<?php
/**
 * Archive Template Router
 * Routes category archives to appropriate templates based on category type
 */

$category_type = dlc_get_category_type_slug();

// Route to appropriate template based on category type slug
switch ($category_type) {
    case 'news':
        get_template_part('categories/news');
        break;
        
    case 'secure-yourself':
        get_template_part('categories/secure-yourself');
        break;

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
    default:
        get_template_part('categories/general');
}


?>
