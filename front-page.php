<?php 
if (dlc_is_arabic_page()) {
    include get_template_directory() . '/front-pages/front-ar.php';
} else {
    include get_template_directory() . '/front-pages/front-en.php';
}
?>