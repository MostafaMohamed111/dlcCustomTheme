<?php
// Check the current post's language from post metadata
$post_language = get_post_meta(get_the_ID(), '_post_language', true);

// Determine if this is an Arabic post
$is_arabic_post = ($post_language === 'ar');

// Load the appropriate single post template based on post language
if ($is_arabic_post) {
    get_template_part('includes/arabic-single');
} else {
    get_template_part('includes/english-single');
}