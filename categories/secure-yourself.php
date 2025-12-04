<?php
if(dlc_is_arabic_page()) {
    include get_template_directory() . '/includes/secure-pages/secure-ar.php';
} else {
    include get_template_directory() . '/includes/secure-pages/secure-en.php';
}