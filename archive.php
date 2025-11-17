
<?php
// Determine if this is an Arabic archive page by checking the category slug
$is_arabic_page = false;

// Get the current queried object (category, tag, etc.)
$queried_object = get_queried_object();

// Check if it's a category and if the slug contains '-ar'
if (isset($queried_object->slug)) {
    if (strpos($queried_object->slug, '-ar') !== false) {
        $is_arabic_page = true;
    }
}

// Load the appropriate archive template
if ($is_arabic_page) {
    get_template_part('includes/arabic-archive');
} else {
    get_template_part('includes/english-archive');
}
?>
