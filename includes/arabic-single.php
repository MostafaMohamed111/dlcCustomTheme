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
                                            <a href="<?php echo get_category_link($category->term_id); ?>" class="category-badge-single">
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

                    <?php if ( comments_open() || get_comments_number() ) : ?>
                        <section class="post-comments" id="comments">
                            <h3 class="comments-title">
                                <i class="fa-solid fa-comment"></i>
                                التعليقات
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
                                        عرض جميع التعليقات (<?php echo $total_comments; ?>)
                                    </button>
                                    <button class="hide-comments-btn" data-post-id="<?php echo get_the_ID(); ?>" style="display: none;">
                                        إخفاء التعليقات
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
                                <p class="no-comments">كن أول من يضيف تعليقاً.</p>
                            <?php endif; ?>

                            <?php
                            $commenter = wp_get_current_commenter();
                            $req       = get_option( 'require_name_email' );
                            $aria_req  = $req ? ' aria-required="true"' : '';
                            $required  = $req ? ' *' : '';

                            $fields = array(
                                'author' => '<div class="comment-form-field half">
                                                <label for="author">الاسم' . $required . '</label>
                                                <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ?? '' ) . '"' . $aria_req . '>
                                            </div>',
                                'email'  => '<div class="comment-form-field half">
                                                <label for="email">البريد الإلكتروني' . $required . '</label>
                                                <input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ?? '' ) . '"' . $aria_req . '>
                                            </div>',
                            );
                            $fields = apply_filters( 'comment_form_default_fields', $fields );

                            comment_form( array(
                                'title_reply'          => '',
                                'label_submit'         => 'تعليق',
                                'class_form'           => 'comment-form-styled',
                                'class_submit'         => 'comment-submit-btn',
                                'comment_notes_before' => '',
                                'comment_notes_after'  => '',
                                'logged_in_as'         => '',
                                'fields'               => $fields,
                                'comment_field'        => '<div class="comment-form-field">
                                                                <label for="comment">أضف تعليقك *</label>
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
                        <div class="post-navigation-inline">
                            <?php
                            // Get previous/next posts filtered by Arabic language and category type (news/blog)
                            $prev_post = get_previous_post_by_language_and_category('ar');
                            $next_post = get_next_post_by_language_and_category('ar');
                            ?>
                            <?php if ( $next_post ) : ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-arrow nav-next" title="<?php echo esc_attr(get_the_title($next_post->ID)); ?>">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            <?php else : ?>
                                <span class="nav-arrow nav-next disabled">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </span>
                            <?php endif; ?>
                            
                            <?php if ( $prev_post ) : ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-arrow nav-prev" title="<?php echo esc_attr(get_the_title($prev_post->ID)); ?>">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </a>
                            <?php else : ?>
                                <span class="nav-arrow nav-prev disabled">
                                    <i class="fa-solid fa-chevron-left"></i>
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
                                'value' => 'ar',
                                'compare' => '='
                            )
                        )
                    ));
                    
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
            // Get Arabic blog category (blog-ar)
            $blog_category = get_category_by_slug('blog-ar');
            if (!$blog_category) {
                // Fallback: try to find by name
                $blog_category = get_term_by('name', 'المدونه', 'category');
            }
            $back_url = $blog_category ? get_category_link($blog_category->term_id) : (get_permalink(get_option('page_for_posts')) ?: home_url());
            ?>
            <a href="<?php echo $back_url; ?>" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                العودة إلى جميع المنشورات
            </a>
        </div>
    </div>
</div>
<?php get_footer('ar'); ?>