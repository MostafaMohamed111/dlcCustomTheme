<?php get_header('ar'); ?>




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
                                    <?php echo ceil(str_word_count(get_the_content()) / 200); ?> دقيقة قراءة
                                </span>
                            </div>
                            
                            <h1 class="post-title-single"><?php the_title(); ?></h1>
                            
                            <?php
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) :
                                ?>
                                    <div class="post-categories-single">
                                        <span class="taxonomy-label">
                                            <i class="fa-solid fa-folder"></i>
                                            التصنيفات:
                                        </span>
                                        <?php foreach($categories as $category) : ?>
                                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-badge-single">
                                                <?php echo esc_html( $category->name ); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                            <?php endif; ?>
                        </div>
                    </header>
                    
                    <!-- Post Content -->
                    <div class="post-content-single">
                        <?php the_content(); ?>
                        
                        <?php
                        $tags = get_the_tags();
                        if ( ! empty( $tags ) ) :
                            ?>
                            <div class="post-tags-inline">
                                <span class="tags-label">
                                    <i class="fa-solid fa-hashtag"></i>
                                    الوسوم:
                                </span>
                                <div class="tags-list-inline">
                                    <?php foreach($tags as $tag) : ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="tag-link-inline">
                                            <?php echo esc_html( $tag->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

               

                    <!-- Post Footer -->
                    <footer class="post-footer-single">
                        <div class="post-share">
                            <span class="share-label">مشاركة:</span>
                            <div class="share-buttons">
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn share-twitter">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-btn share-facebook">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn share-linkedin">
                                    <i class="fa-brands fa-linkedin"></i>
                                </a>
                                <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>" class="share-btn share-email">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </footer>
                </article>
                
                <!-- Related Posts -->
                <?php
                $post_tags = wp_get_post_tags(get_the_ID(), array('fields' => 'ids'));
                if ( ! empty( $post_tags ) ) {
                    // Get some tags (not all) - take first 3 tags
                    $tags_to_match = array_slice($post_tags, 0, 3);
                    
                    $related_args = array(
                        'tag__in' => $tags_to_match,
                        'post__not_in' => array(get_the_ID()),
                        'posts_per_page' => 3,
                        'orderby' => 'rand'
                    );
                    
                    // Add Polylang language filter
                    if (function_exists('pll_current_language')) {
                        $related_args['lang'] = pll_current_language();
                    }
                    
                    $related_query = new WP_Query($related_args);
                    
                    if ( $related_query->have_posts() ) :
                        ?>
                        <section class="related-posts">
                            <h3 class="related-posts-title">
                                <i class="fa-solid fa-book-open"></i>
                                منشورات ذات صلة
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
            $back_url = wp_validate_redirect(wp_get_referer(), home_url('/'));
            ?>
            <a href="<?php echo esc_url($back_url); ?>" class="back-btn" onclick="if (window.history.length > 1) { history.back(); } else { window.location.href = this.href; } return false;">
                <i class="fa-solid fa-arrow-left"></i>
                العودة
            </a>
        </div>
    </div>
</div>


<?php get_footer('ar'); ?>