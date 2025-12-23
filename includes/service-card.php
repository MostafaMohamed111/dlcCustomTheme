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
    'excerpt_length' => DLC_EXCERPT_LENGTH_SERVICE,
    'current_category_id' => 0  // Pass the contextual category ID for badge display
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
                // Display contextual category badge based on current filter/page
                $badge_category = null;
                
                // If a current category is specified (from filtration), use it
                if (!empty($args['current_category_id'])) {
                    $badge_category = get_category($args['current_category_id']);
                    // Verify this post actually has this category
                    if ($badge_category && !has_category($badge_category->term_id)) {
                        $badge_category = null;
                    }
                }
                
                // Fallback to first category if no contextual category
                if (!$badge_category) {
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        $badge_category = $categories[0];
                    }
                }
                
                // Display the badge
                if ($badge_category) {
                    echo esc_html($badge_category->name);
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
