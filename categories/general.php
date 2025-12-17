<?php
// Simple logic: Tags = English, Arabic categories = Arabic
$is_arabic = false;

// All tags go to English
if (is_tag()) {
    $is_arabic = false;
}
// For categories, check if it's Arabic
elseif (is_category()) {
    if (function_exists('pll_get_term_language')) {
        $queried_object = get_queried_object();
        if ($queried_object && isset($queried_object->term_id)) {
            $term_lang = pll_get_term_language($queried_object->term_id);
            $is_arabic = ($term_lang === 'ar');
        }
    }
}
// For other archives (date, author), check page language
else {
    $is_arabic = dlc_is_arabic_page();
}

// Load appropriate template
if ($is_arabic) {
    include get_template_directory() . '/includes/general-categories-pages/general-ar.php';
} else {
    include get_template_directory() . '/includes/general-categories-pages/general-en.php';
}