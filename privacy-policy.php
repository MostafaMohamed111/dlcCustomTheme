<?php
/*
 * Template Name: Privacy Policy
 */

get_header(); ?>

<main class="privacy-policy-page">
    <div class="privacy-policy-hero">
        <div class="container">
            <div class="privacy-policy-header">
                <h1 class="privacy-policy-title"><?php the_title(); ?></h1>
                <?php
                while ( have_posts() ) :
                    the_post();
                    $last_updated = get_the_modified_date('F j, Y');
                    ?>
                    <p class="privacy-policy-meta">
                        <i class="fa-solid fa-calendar-alt"></i>
                        Last Updated: <time datetime="<?php echo get_the_modified_date('c'); ?>"><?php echo esc_html($last_updated); ?></time>
                    </p>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="privacy-policy-content-wrapper">
        <div class="container">
            <div class="privacy-policy-container">
                <?php
                // Start the Loop.
                while ( have_posts() ) :
                    the_post();
                    ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('privacy-policy-article'); ?>>
                        <div class="privacy-policy-content">
                            <?php the_content(); ?>
                        </div>
                        
                        <footer class="privacy-policy-footer">
                            <div class="privacy-policy-contact">
                                <h3>Questions About Our Privacy Policy?</h3>
                                <p>If you have any questions about this Privacy Policy, please contact us:</p>
                                <div class="contact-info">
                                    <p><i class="fa-solid fa-envelope"></i> <a href="mailto:info@daglaw.com">info@daglaw.com</a></p>
                                    <p><i class="fa-solid fa-phone"></i> <a href="tel:+966XXXXXXXXX">+966 XXXXXXXXX</a></p>
                                </div>
                            </div>
                        </footer>
                    </article>
                    
                <?php endwhile; // End of the loop. ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>