
<?php if( have_posts() ) : ?>
    <?php while( have_posts() ) : the_post(); ?>
        <div class="post-item mb-5">
            <h2 class="post-title"><?php the_title(); ?></h2>
            <div class="post-content">
                <?php the_content(); ?>
            </div>
        </div>
    <?php endwhile; ?>
<?php else : ?>
    <p><?php esc_html_e( 'No posts found.', 'dlcCustomTheme' ); ?></p>
<?php endif; ?>