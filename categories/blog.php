<?php
if (dlc_is_arabic_page()) {
    include get_template_directory() . '/includes/blog-pages/blog-ar.php';
} else {
    include get_template_directory() . '/includes/blog-pages/blog-en.php';
}
?>


