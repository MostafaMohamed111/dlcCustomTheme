<?php
/*
    Template Name: Booking Page
*/
if(dlc_is_arabic_page()) {
    include get_template_directory() . '/booking-pages/booking-ar.php';
} else {
    include get_template_directory() . '/booking-pages/booking-en.php';
}
?>