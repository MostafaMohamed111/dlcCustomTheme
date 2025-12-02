<?php
if (dlc_is_arabic_page()) {
    include get_template_directory() . '/includes/news-pages/news-ar.php';
} else {
    include get_template_directory() . '/includes/news-pages/news-en.php';
}