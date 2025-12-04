<?php 
/*
    Template Name: Services Page
*/
if(dlc_is_arabic_page()) {
    include get_template_directory() . '/services-pages/services-ar.php';
} else {
    include get_template_directory() . '/services-pages/services-en.php';
}
?>