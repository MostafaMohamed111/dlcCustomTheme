<?php
/**
 * Reusable news card component
 * 
 * @param array $args {
 *     Optional. Array of arguments.
 *     @type string $badge_text     Badge text. Default 'News'.
 *     @type string $button_text    Button text. Default 'Read More'.
 *     @type int    $excerpt_length Excerpt length. Default 120.
 * }
 */

$args = wp_parse_args($args ?? array(), array(
    'badge_text' => 'News',
    'button_text' => 'Read More',
    'excerpt_length' => 120
));
?>

<article class="news-card">
    <?php if (has_post_thumbnail()) : ?>
        <div class="news-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(
                    'large',
                    array(
                        'class' => 'news-image',
                        'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw'
                    )
                ); ?>
            </a>
            <div class="news-category-badge">
                <?php echo esc_html($args['badge_text']); ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="news-content">
        <div class="news-meta">
            <span class="news-date">
                <i class="fa-solid fa-calendar"></i>
                <?php echo get_the_date(); ?>
            </span>
      
        </div>
        
        <h3 class="news-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="news-excerpt">
            <?php echo esc_html(dlc_truncate_excerpt(get_the_excerpt(), $args['excerpt_length'])); ?>
        </div>
        
        <div class="news-footer">
            <a href="<?php the_permalink(); ?>" class="read-more-news-btn">
                <?php echo esc_html($args['button_text']); ?>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</article>
