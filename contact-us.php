<?php 
/*
    Template Name: Contact Us
*/
if(dlc_is_arabic_page()) {
    include get_template_directory() . '/contact-pages/contact-ar.php';
} else {
    include get_template_directory() . '/contact-pages/contact-en.php';
}
?>