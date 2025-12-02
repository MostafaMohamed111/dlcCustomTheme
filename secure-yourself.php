<?php
/*
    Template Name: Secure Yourself
*/

if(dlc_is_arabic_page()) {
    include get_template_directory() . '/secure-pages/secure-ar.php';
} else {
    include get_template_directory() . '/secure-pages/secure-en.php';
}
?>