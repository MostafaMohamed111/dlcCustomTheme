<?php
if(dlc_is_arabic_page()) {
    include get_template_directory() . '/general-pages/page-ar.php';
} else {
    include get_template_directory() . '/general-pages/page-en.php';
}