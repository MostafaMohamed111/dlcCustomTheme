<?php
/**
 * Reusable service card component
 * 
 * @param array $args {
 *     Optional. Array of arguments.
 *     @type string $button_text Button text. Default 'Read More'.
 *     @type int    $excerpt_length Excerpt length. Default 120.
 * }
 */

$args = wp_parse_args($args ?? array(), array(
    'button_text' => 'Read More',
    'excerpt_length' => DLC_EXCERPT_LENGTH_SERVICE
));
?>

<article class="service-card">
    <?php if (has_post_thumbnail()) : ?>
        <div class="service-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(
                    'large',
                    array(
                        'class' => 'service-image',
                        'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 33vw, 400px'
                    )
                ); ?>
            </a>
            <div class="service-category-badge">
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo esc_html($categories[0]->name);
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="service-content">
        <h3 class="service-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="service-excerpt">
            <?php echo esc_html(dlc_truncate_excerpt(get_the_excerpt(), $args['excerpt_length'])); ?>
        </div>
        
        <div class="service-footer">
            <a href="<?php the_permalink(); ?>" class="get-started-service-btn">
                <?php echo esc_html($args['button_text']); ?>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</article>
