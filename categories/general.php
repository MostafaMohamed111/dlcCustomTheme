<?php
if(dlc_is_arabic_page()) {
    include get_template_directory() . '/includes/general-categories-pages/general-ar.php';
} else {
    include get_template_directory() . '/includes/general-categories-pages/general-en.php';
}