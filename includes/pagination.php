<?php
/**
 * Reusable pagination component
 * 
 * @param array $args {
 *     Optional. Array of arguments.
 *     @type int    $paged Current page number.
 *     @type int    $total_pages Total number of pages.
 *     @type string $base_url Base URL for pagination.
 *     @type string $anchor_id Anchor ID to scroll to. Default '#services-title'.
 *     @type string $page_text Text for "Page X of Y". Default 'Page %s of %s'.
 * }
 */

$args = wp_parse_args($args ?? array(), array(
    'paged' => 1,
    'total_pages' => 1,
    'base_url' => '',
    'anchor_id' => '#services-title',
    'page_text' => 'Page %s of %s',
    'category_id' => 0,
    'parent_category_id' => 0
));

$paged = $args['paged'];
$total_pages = $args['total_pages'];
$base_url = trailingslashit($args['base_url']);
$anchor = $args['anchor_id'];
$category_id = isset($args['category_id']) ? intval($args['category_id']) : 0;
$parent_category_id = isset($args['parent_category_id']) ? intval($args['parent_category_id']) : 0;

if ($total_pages <= 1) {
    return;
}

$prev_page = ($paged > 1) ? $paged - 1 : 0;
$next_page = ($paged < $total_pages) ? $paged + 1 : 0;

// Build pagination URLs
$prev_url = ($prev_page > 1) ? $base_url . 'page/' . $prev_page . '/' . $anchor : $base_url . $anchor;
$next_url = $base_url . 'page/' . $next_page . '/' . $anchor;
?>

<div class="pagination-wrapper" 
     data-category-id="<?php echo esc_attr($category_id); ?>"
     data-parent-category-id="<?php echo esc_attr($parent_category_id); ?>"
     data-base-url="<?php echo esc_attr($base_url); ?>"
     data-anchor-id="<?php echo esc_attr($anchor); ?>">
    <div class="pagination-simple">
        <?php if ($prev_page > 0) : ?>
            <div class="pagination-arrow pagination-prev">
                <a href="<?php echo esc_url($prev_url); ?>" 
                   class="pagination-link" 
                   data-page="<?php echo esc_attr($prev_page); ?>">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </div>
        <?php else : ?>
            <div class="pagination-arrow pagination-prev disabled">
                <span><i class="fa-solid fa-chevron-left"></i></span>
            </div>
        <?php endif; ?>
        
        <div class="pagination-info">
            <span class="page-numbers"><?php echo sprintf(esc_html($args['page_text']), esc_html($paged), esc_html($total_pages)); ?></span>
        </div>
        
        <?php if ($next_page > 0) : ?>
            <div class="pagination-arrow pagination-next">
                <a href="<?php echo esc_url($next_url); ?>" 
                   class="pagination-link" 
                   data-page="<?php echo esc_attr($next_page); ?>">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        <?php else : ?>
            <div class="pagination-arrow pagination-next disabled">
                <span><i class="fa-solid fa-chevron-right"></i></span>
            </div>
        <?php endif; ?>
    </div>
</div>
