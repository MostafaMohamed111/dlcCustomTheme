<?php
if(dlc_is_arabic_page()) {
    include get_template_directory() . '/team-pages/team-ar.php';
} else {
    include get_template_directory() . '/team-pages/team-en.php';
}