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
                            
                            <?php
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) :
                                ?>
                                    <div class="post-categories-single">
                                        <span class="taxonomy-label">
                                            <i class="fa-solid fa-folder"></i>
                                            Categories:
                                        </span>
                                        <?php foreach($categories as $category) : ?>
                                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-badge-single">
                                                <?php echo esc_html( $category->name ); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                            <?php endif; ?>
                            
                            <?php
                            $tags = get_the_tags();
                            if ( ! empty( $tags ) ) :
                                ?>
                                <div class="post-tags-single-header">
                                    <span class="tags-label">
                                        <i class="fa-solid fa-hashtag"></i>
                                        Tags:
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
                    </header>
                    
                    <!-- Post Content -->
                    <div class="post-content-single">
                        <?php the_content(); ?>
                    </div>

                    <!-- Book Now CTA -->
                    <div class="post-cta-section">
                        <?php 
                        // Get booking page URL using Polylang
                        $booking_url = dlc_get_booking_page_url('en');
                        ?>
                        <a href="<?php echo esc_url($booking_url); ?>" class="book-now-cta-btn">
                            <i class="fa-solid fa-calendar-check"></i>
                            Book A Consultation
                        </a>
                    </div>
                                  
                <!-- Related Posts -->
                <?php
                $post_tags = wp_get_post_tags(get_the_ID(), array('fields' => 'ids'));
                if ( ! empty( $post_tags ) ) {
                    // Get some tags (not all) - take first 3 tags
                    $tags_to_match = array_slice($post_tags, 0, 3);
                    
                    // Get current language using Polylang
                    $current_lang = 'en';
                    if (function_exists('pll_get_post_language')) {
                        $current_lang = pll_get_post_language(get_the_ID()) ?: 'en';
                    }
                    
                    $related_query_args = array(
                        'tag__in' => $tags_to_match,
                        'post__not_in' => array(get_the_ID()),
                        'posts_per_page' => 3,
                        'orderby' => 'rand'
                    );
                    
                    // Add Polylang language filter if available
                    if (function_exists('pll_get_post_language')) {
                        $related_query_args['lang'] = $current_lang;
                    }
                    
                    $related_query = new WP_Query($related_query_args);
                    
                    if ( $related_query->have_posts() ) :
                        ?>
                        <section class="related-posts">
                            <h3 class="related-posts-title">
                                <i class="fa-solid fa-book-open"></i>
                                Related Posts
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
                    // Comments are enabled for blog posts
                    if (comments_open() || get_comments_number()) : ?>
                        <section class="post-comments" id="comments">
                            <h3 class="comments-title">
                                <i class="fa-solid fa-comment"></i>
                                Comments
                            </h3>

                            <?php
                            $approved_comments = get_comments( array(
                                'post_id' => get_the_ID(),
                                'status'  => 'approve',
                                'orderby' => 'comment_date_gmt',
                                'order'   => 'ASC',
                            ) );
                            ?>
                            
                            <?php if ( ! empty( $approved_comments ) ) : ?>
                                <?php 
                                $total_comments = count($approved_comments);
                                $initial_display = 3;
                                $show_more_button = $total_comments > $initial_display;
                                $comments_to_show = $show_more_button ? array_slice($approved_comments, 0, $initial_display) : $approved_comments;
                                ?>
                                <ol class="comment-list" data-total="<?php echo $total_comments; ?>" data-shown="<?php echo count($comments_to_show); ?>">
                                    <?php wp_list_comments( array(
                                        'avatar_size' => 48,
                                        'style'       => 'ol',
                                        'short_ping'  => true,
                                        'max_depth'   => 3,
                                        'callback'    => 'dlc_custom_comment_callback',
                                    ), $comments_to_show ); ?>
                                </ol>
                                <?php if ( $show_more_button ) : ?>
                                    <button class="view-all-comments-btn" data-post-id="<?php echo get_the_ID(); ?>">
                                        View All Comments (<?php echo $total_comments; ?>)
                                    </button>
                                    <button class="hide-comments-btn" data-post-id="<?php echo get_the_ID(); ?>" style="display: none;">
                                        Hide Comments
                                    </button>
                                    <ol class="comment-list comment-list-hidden" style="display: none;">
                                        <?php wp_list_comments( array(
                                            'avatar_size' => 48,
                                            'style'       => 'ol',
                                            'short_ping'  => true,
                                            'max_depth'   => 3,
                                            'callback'    => 'dlc_custom_comment_callback',
                                        ), array_slice($approved_comments, $initial_display) ); ?>
                                    </ol>
                                <?php endif; ?>
                            <?php else : ?>
                                <p class="no-comments">Be the first to share your thoughts.</p>
                            <?php endif; ?>

                            <?php
                            $commenter = wp_get_current_commenter();
                            $req       = get_option( 'require_name_email' );
                            $aria_req  = $req ? ' aria-required="true"' : '';
                            $required  = $req ? ' *' : '';

                            $fields = array(
                                'author' => '<div class="comment-form-field half">
                                                <label for="author">Name' . $required . '</label>
                                                <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ?? '' ) . '"' . $aria_req . '>
                                            </div>',
                                'email'  => '<div class="comment-form-field half">
                                                <label for="email">Email' . $required . '</label>
                                                <input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ?? '' ) . '"' . $aria_req . '>
                                            </div>',
                            );
                            $fields = apply_filters( 'comment_form_default_fields', $fields );

                            comment_form( array(
                                'title_reply'          => '',
                                'label_submit'         => __('Comment', 'dlc'),
                                'class_form'           => 'comment-form-styled',
                                'class_submit'         => 'comment-submit-btn',
                                'comment_notes_before' => '',
                                'comment_notes_after'  => '',
                                'logged_in_as'         => '',
                                'fields'               => $fields,
                                'comment_field'        => '<div class="comment-form-field">
                                                                <label for="comment">Comment *</label>
                                                                <textarea id="comment" name="comment" rows="5" required></textarea>
                                                            </div>',
                                'id_form'              => 'commentform',
                                'id_submit'            => 'submit',
                            ) );
                            ?>
                        </section>
                    <?php endif; ?>
                    
                    <!-- Post Footer -->
                    <footer class="post-footer-single">
                        <div class="post-share">
                            <span class="share-label">Share:</span>
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
                        <div class="post-navigation-inline">
                            <?php
                            // Get current language using Polylang
                            $current_lang = 'en';
                            if (function_exists('pll_get_post_language')) {
                                $current_lang = pll_get_post_language(get_the_ID()) ?: 'en';
                            }
                            
                            // Get previous/next posts filtered by current language and blog category
                            $prev_post = get_previous_post_by_language_and_category($current_lang);
                            $next_post = get_next_post_by_language_and_category($current_lang);
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
  
                
                <?php
            endwhile;
        endif;
        ?>
        
        <div class="back-to-posts">
            <?php 
            // Get current language using Polylang
            $current_lang = 'en';
            if (function_exists('pll_get_post_language')) {
                $current_lang = pll_get_post_language(get_the_ID()) ?: 'en';
            }
            
            // Get the blog archive URL for current language
            $back_url = dlc_get_post_archive_url(get_the_ID(), $current_lang);
            ?>
            <a href="<?php echo esc_url($back_url); ?>" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back to All Posts
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>

