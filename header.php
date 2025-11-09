<!DOCTYPE html>
<html lang="en" dir="ltr">
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

            <div class="nav-right">
                <?php
                    // Check if menu location exists and has a menu assigned
                    if ( has_nav_menu( 'primary-menu' ) ) {
                        wp_nav_menu( 
                            array(
                                'theme_location' => 'primary-menu',
                                'container' => 'div',
                                'container_class' => 'main-menu',
                                'fallback_cb' => false,
                            ) 
                        );
                    } else {
                        // Fallback: Show a message or create a simple menu structure
                        echo '<div class="main-menu"><ul><li><a href="#">Menu not assigned</a></li></ul></div>';
                    }
                ?>
                <button class="btn-define">Define Presence</button>
            </div>
            



            </div>
    </Nav>      