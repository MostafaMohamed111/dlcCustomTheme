<?php
/**
 * Reusable post card component
 * 
 * @param array $args {
 *     Optional. Array of arguments.
 *     @type string $read_more_text Text for read more button. Default 'Read More'.
 *     @type int    $excerpt_length  Excerpt length. Default 150.
 * }
 */

$args = wp_parse_args($args ?? array(), array(
    'read_more_text' => 'Read More',
    'excerpt_length' => DLC_EXCERPT_LENGTH_POST
));
?>

<article class="post-card">
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(
                    'large',
                    array(
                        'class' => 'post-image',
                        'loading' => 'lazy',
                        'sizes' => '(max-width: 768px) 100vw, 900px',
                        'srcset' => wp_get_attachment_image_srcset(get_post_thumbnail_id(), 'large')
                    )
                ); ?>
            </a>
            <div class="post-category-badge">
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo esc_html($categories[0]->name);
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="post-content">
        <div class="post-meta">
            <span class="post-date">
                <i class="fa-solid fa-calendar"></i>
                <?php echo get_the_date(); ?>
            </span>
            <span class="post-author">
                <i class="fa-solid fa-user"></i>
                <?php the_author(); ?>
            </span>
        </div>
        
        <h3 class="post-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="post-excerpt">
            <?php echo esc_html(dlc_truncate_excerpt(get_the_excerpt(), $args['excerpt_length'])); ?>
        </div>
        
        <div class="post-footer">
            <a href="<?php the_permalink(); ?>" class="read-more-btn">
                <?php echo esc_html($args['read_more_text']); ?>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
            <div class="post-meta-footer">
                <?php
                $categories = get_the_category();
                
                $tags = get_the_tags();
                if (!empty($tags)) {
                    // Limit to first 2 tags
                    $tags = array_slice($tags, 0, 2);
                    ?>
                    <div class="post-tags">
                        <?php foreach($tags as $tag) : ?>
                            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="post-tag-link">
                                <i class="fa-solid fa-hashtag"></i>
                                <?php echo esc_html($tag->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</article>
