<?php
/**
 * Generic Page Template – English
 * Used via page.php for all standard English pages.
 */

get_header();
?>

<main class="generic-page">
    <header class="page-hero">
        <div class="container">
            <div class="page-hero-inner">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php
                    // Store current post ID for later sections
                    $current_page_id = get_the_ID();
                    ?>
                <?php endwhile; rewind_posts(); endif; ?>
            </div>
        </div>
    </header>

    <section class="page-body">
        <div class="container">
            <article id="post-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="page-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="page-content">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            the_content();
                        endwhile;
                    endif;
                    ?>
                </div>
            </article>
        </div>
    </section>
</main>

<?php get_footer(); ?>


