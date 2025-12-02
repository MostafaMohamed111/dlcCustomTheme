<?php 
if (dlc_is_arabic_page()) {
    include get_template_directory() . '/includes/international-pages/international-ar.php';
} else {
    include get_template_directory() . '/includes/international-pages/international-en.php';
}