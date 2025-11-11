<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body>

    <Nav>
        <div class= "container ">
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <img src= "<?php echo get_template_directory_uri(); ?>/assets/images/DLC_logo.webp" alt="Dag Law Firm And Consultation Logo">
                </a>
            </div>

            <button class="mobile-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="nav-right">
                <?php
                    wp_nav_menu( 
                        array(
                            'theme_location' => 'primary-ar-menu',
                            'container' => 'div',
                            'container_class' => 'main-menu',
                            'fallback_cb' => false,
                        ) 
                    );
                ?>
                <button class="btn-define">تغير التواجد</button>
            </div>
            



            </div>
    </Nav>      