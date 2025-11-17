
<?php
// Get the current queried object (category, tag, etc.)
$queried_object = get_queried_object();

// Determine language and category type
$is_arabic_page = false;
$is_news_category = false;

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
}

// Load the appropriate template based on category type and language
if ($is_news_category) {
    // News category
    if ($is_arabic_page) {
        get_template_part('includes/arabic-news');
    } else {
        get_template_part('includes/english-news');
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
