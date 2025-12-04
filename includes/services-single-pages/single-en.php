<?php get_header(); ?>

<div class="main">
    <div class="container single-post-container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                    <!-- Post Header -->
                    <header class="post-header">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-featured-image">
                                <?php the_post_thumbnail(
                                    'full',
                                    array(
                                        'class' => 'featured-img',
                                        'sizes' => '(max-width: 1024px) 100vw, 1024px'
                                    )
                                ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-header-content">
                            <div class="post-meta-top">
                                <span class="post-date">
                                    <i class="fa-solid fa-calendar"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                                <span class="post-author">
                                    <i class="fa-solid fa-user"></i>
                                    <?php the_author(); ?>
                                </span>
                                <span class="post-reading-time">
                                    <i class="fa-solid fa-clock"></i>
                                    <?php echo ceil(str_word_count(get_the_content()) / 200); ?> min read
                                </span>
                            </div>
                            
                            <h1 class="post-title-single"><?php the_title(); ?></h1>
                        </div>
                    </header>
                    
                    <!-- Post Content -->
                    <div class="post-content-single">
                        <?php the_content(); ?>
                    </div>


                    <!-- Post Footer -->
                    <footer class="post-footer-single">
                        <div class="service-cta">
                            <?php 
                            // Get booking page URL using Polylang
                            $booking_url = dlc_get_booking_page_url('en');
                            $booking_url = add_query_arg('service', get_the_ID(), $booking_url);
                            ?>
                            <a href="<?php echo esc_url($booking_url); ?>" class="service-cta-btn get-started-service-btn">
                                Book this Service
                                <i class="fa-solid fa-briefcase"></i>
                            </a>
                        </div>
                        <div class="post-navigation-inline">
                            <?php
                            // Get previous/next services filtered by language and service type
                            $prev_post = dlc_get_previous_service_post('en');
                            $next_post = dlc_get_next_service_post('en');
                            ?>
                            <?php if ( $prev_post ) : ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-arrow nav-prev" title="<?php echo esc_attr(get_the_title($prev_post->ID)); ?>">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </a>
                            <?php else : ?>
                                <span class="nav-arrow nav-prev disabled">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </span>
                            <?php endif; ?>
                            
                            <?php if ( $next_post ) : ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-arrow nav-next" title="<?php echo esc_attr(get_the_title($next_post->ID)); ?>">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            <?php else : ?>
                                <span class="nav-arrow nav-next disabled">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    </footer>
                </article>
                
                <!-- Related Posts -->
                <?php
                $post_tags = wp_get_post_tags(get_the_ID(), array('fields' => 'ids'));
                if ( ! empty( $post_tags ) ) {
                    // Get some tags (not all) - take first 3 tags
                    $tags_to_match = array_slice($post_tags, 0, 3);
                    
                    $related_query = new WP_Query(array(
                        'tag__in' => $tags_to_match,
                        'post__not_in' => array(get_the_ID()),
                        'posts_per_page' => 3,
                        'orderby' => 'rand',
                        'meta_query' => array(
                            array(
                                'key' => '_post_language',
                                'value' => 'en',
                                'compare' => '='
                            )
                        )
                    ));
                    
                    if ( $related_query->have_posts() ) :
                        ?>
                        <section class="related-posts">
                            <h3 class="related-posts-title">
                                <i class="fa-solid fa-book-open"></i>
                                Related Services
                            </h3>
                            <div class="related-posts-grid">
                                <?php
                                while ( $related_query->have_posts() ) : $related_query->the_post();
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="related-post-card">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <div class="related-post-thumbnail">
                                                <?php the_post_thumbnail('medium', array('class' => 'related-post-image')); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="related-post-content">
                                            <h4 class="related-post-title"><?php the_title(); ?></h4>
                                            <div class="related-post-meta">
                                                <span class="related-post-date">
                                                    <i class="fa-solid fa-calendar"></i>
                                                    <?php echo get_the_date(); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                endwhile;
                                ?>
                            </div>
                        </section>
                        <?php
                        wp_reset_postdata();
                    endif;
                }
                ?>
                
                <?php
            endwhile;
        endif;
        ?>
        
        <div class="back-to-posts">
            <?php 
            // Get the correct archive URL based on service type
            $back_url = dlc_get_service_archive_url(get_the_ID());
            ?>
            <a href="<?php echo esc_url($back_url); ?>" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Services
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>

