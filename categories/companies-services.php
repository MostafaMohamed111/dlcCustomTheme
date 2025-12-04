<?php 
if(dlc_is_arabic_page()) {
    include get_template_directory() . '/includes/companies-pages/companies-ar.php';
} else {
    include get_template_directory() . '/includes/companies-pages/companies-en.php';
}