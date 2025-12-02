<?php 
if (dlc_is_arabic_page()) {
    include get_template_directory() . '/privacy-pages/privacy-ar.php';
} else {
    include get_template_directory() . '/privacy-pages/privacy-en.php';
}
?>