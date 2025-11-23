
<?php
// Get the current queried object (category, tag, etc.)
$queried_object = get_queried_object();

// Determine language and category type
$is_arabic_page = false;
$is_news_category = false;
$is_companies_services = false;
$is_individual_services = false;
$is_home_international = false;

// Check if it's a category
if (isset($queried_object->slug)) {
    $slug = $queried_object->slug;
    
    // Check if it's Arabic (slug contains '-ar')
    if (strpos($slug, '-ar') !== false) {
        $is_arabic_page = true;
    }
    
    // Check if it's a news category (slug contains 'news')
    if (strpos($slug, 'news') !== false) {
        $is_news_category = true;
    }
    
    // Check if it's companies services category
    if (strpos($slug, 'companies-services') !== false) {
        $is_companies_services = true;
    }
    
    // Check if it's individual services category
    if (strpos($slug, 'individual-services') !== false) {
        $is_individual_services = true;
    }
    
    // Check if it's home international category
    if (strpos($slug, 'home-international') !== false) {
        $is_home_international = true;
    }
}

// Load the appropriate template based on category type and language
if ($is_news_category) {
    // News category
    if ($is_arabic_page) {
        get_template_part('includes/arabic-news');
    } else {
        get_template_part('includes/english-news');
    }
} elseif ($is_companies_services) {
    // Companies services category
    if ($is_arabic_page) {
        get_template_part('includes/arabic-companies-services');
    } else {
        get_template_part('includes/companies-services');
    }
} elseif ($is_individual_services) {
    // Individual services category
    if ($is_arabic_page) {
        get_template_part('includes/arabic-individual-services');
    } else {
        get_template_part('includes/individual-services');
    }
} elseif ($is_home_international) {
    // Home international category
    if ($is_arabic_page) {
        get_template_part('includes/home-international-ar');
    } else {
        get_template_part('includes/home-international');
    }
} else {
    // Blog category (default)
    if ($is_arabic_page) {
        get_template_part('includes/arabic-archive');
    } else {
        get_template_part('includes/english-archive');
    }
}
?>
