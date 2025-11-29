
<?php
/**
 * Archive Template
 * Routes to appropriate template based on archive type
 */

// Get the current queried object
$queried_object = get_queried_object();

// Check if it's a tag, date, author, or other non-category archive
if (is_tag() || is_date() || is_author() || !is_category()) {
    // Use generic archive template for tags, dates, authors, etc.
    get_template_part('includes/generic-archive');
    return;
}

// It's a category archive - determine which specific template to use
$is_arabic_page = false;
$slug = $queried_object->slug ?? '';

// Check if it's Arabic (slug contains '-ar')
if (strpos($slug, '-ar') !== false) {
    $is_arabic_page = true;
}

// Route to specific category templates
if (strpos($slug, 'news') !== false) {
    // News category
    get_template_part('includes/' . ($is_arabic_page ? 'arabic-news' : 'english-news'));
} elseif (strpos($slug, 'companies-services') !== false) {
    // Companies services category
    get_template_part('includes/' . ($is_arabic_page ? 'arabic-companies-services' : 'companies-services'));
} elseif (strpos($slug, 'individual-services') !== false) {
    // Individual services category
    get_template_part('includes/' . ($is_arabic_page ? 'arabic-individual-services' : 'individual-services'));
} elseif (strpos($slug, 'home-international') !== false) {
    // Home international category
    get_template_part('includes/' . ($is_arabic_page ? 'home-international-ar' : 'home-international'));
} elseif (strpos($slug, 'blog') !== false || $queried_object->parent != 0) {
    // Blog category or child category - use blog template
    get_template_part('includes/' . ($is_arabic_page ? 'arabic-blog' : 'english-blog'));
} else {
    // Unknown category - use generic archive
    get_template_part('includes/generic-archive');
}
?>
