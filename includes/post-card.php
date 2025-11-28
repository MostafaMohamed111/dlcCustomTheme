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
                        'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 80vw, 900px'
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
                if (!empty($categories)) {
                    $category_count = count($categories);
                    ?>
                    <div class="post-categories">
                        <?php if ($category_count == 1) : ?>
                            <a href="<?php echo get_category_link($categories[0]->term_id); ?>" class="post-category-link">
                                <i class="fa-solid fa-folder"></i>
                                <?php echo esc_html($categories[0]->name); ?>
                            </a>
                        <?php else : ?>
                            <div class="categories-dropdown">
                                <button class="categories-dropdown-toggle" type="button">
                                    <i class="fa-solid fa-folder"></i>
                                    <span class="dropdown-text"><?php echo dlc_is_arabic_page() ? 'التصنيفات' : 'Categories'; ?></span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="categories-dropdown-menu">
                                    <?php foreach($categories as $category) : ?>
                                        <a href="<?php echo get_category_link($category->term_id); ?>" class="dropdown-category-link">
                                            <i class="fa-solid fa-folder"></i>
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                }
                
                $tags = get_the_tags();
                if (!empty($tags)) {
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
