<?php
/**
 * Generic Archive Template (Arabic)
 * Handles tags, dates, authors, and other archives
 * Language-agnostic - shows all posts with the specified tag/date/author
 */

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<main class="main">
    <!-- Archive Header Section -->
    <div class="archive-header-section">
        <!-- Header Actions -->
        <div class="archive-header-actions">
            <!-- Home Button -->
            <a href="<?php echo esc_url(home_url()); ?>" class="archive-home-btn" title="الذهاب إلى الصفحة الرئيسية">
                <i class="fa-solid fa-house"></i>
                <span>الرئيسية</span>
            </a>
            <!-- Language Switcher -->
            <div class="archive-language-switcher">
                <?php
                $switcher = dlc_get_polylang_switcher();
                if ($switcher) :
                    // Determine target language and labels
                    $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'ar';
                    $target_lang = ($current_lang === 'ar') ? 'en' : 'ar';
                    $label = ($target_lang === 'ar') ? 'العربية' : 'English';
                    $title = ($target_lang === 'ar') ? 'التبديل إلى العربية' : 'التبديل إلى الإنجليزية';
                ?>
                <a href="<?php echo esc_url($switcher['url']); ?>" class="archive-language-switch-btn" title="<?php echo esc_attr($title); ?>">
                    <i class="fa-solid fa-globe"></i>
                    <span><?php echo esc_html($label); ?></span>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
        // Get current language using Polylang
        $current_lang = 'ar';
        if (function_exists('pll_current_language')) {
            $current_lang = pll_current_language();
        }
        
        // Determine archive type and set appropriate content
        $archive_type = '';
        $archive_title = '';
        $archive_subtitle = '';
        $badge_icon = '';
        $badge_text = '';
        $queried_object = get_queried_object();
        
        if (is_category()) {
            $category = $queried_object;
            $archive_type = 'category';
            $badge_icon = 'fa-folder-open';
            $badge_text = 'أرشيف الفئة';
            $archive_title = single_cat_title('', false);
            $archive_subtitle = category_description() ?: 'استكشف المنشورات في "' . $archive_title . '"';
            $post_count = $category->count;
        } elseif (is_tag()) {
            $tag = $queried_object;
            $archive_type = 'tag';
            $badge_icon = 'fa-tag';
            $badge_text = 'أرشيف الوسم';
            $archive_title = single_tag_title('', false);
            $archive_subtitle = 'استكشف المحتوى المميز بـ "' . $archive_title . '"';
            $post_count = $tag->count;
        } elseif (is_date()) {
            $archive_type = 'date';
            $badge_icon = 'fa-calendar-days';
            $badge_text = 'أرشيف التاريخ';
            if (is_year()) {
                $archive_title = get_the_date('Y');
                $archive_subtitle = 'المنشورات المنشورة في ' . $archive_title;
            } elseif (is_month()) {
                $archive_title = get_the_date('F Y');
                $archive_subtitle = 'المنشورات المنشورة في ' . $archive_title;
            } elseif (is_day()) {
                $archive_title = get_the_date('F j, Y');
                $archive_subtitle = 'المنشورات المنشورة في ' . $archive_title;
            }
        } elseif (is_author()) {
            $author = $queried_object;
            $archive_type = 'author';
            $badge_icon = 'fa-user-pen';
            $badge_text = 'أرشيف المؤلف';
            $archive_title = get_the_author();
            $archive_subtitle = 'المقالات المكتوبة بواسطة ' . $archive_title;
            $post_count = count_user_posts($author->ID);
        } else {
            $archive_type = 'general';
            $badge_icon = 'fa-folder-open';
            $badge_text = 'أرشيف';
            $archive_title = 'أرشيف';
            $archive_subtitle = 'تصفح مجموعتنا من المنشورات';
        }
        ?>
        
        <div class="archive-hero">
            <div class="archive-hero-content">
                <div class="archive-type-badge">
                    <i class="fa-solid <?php echo esc_attr($badge_icon); ?>"></i>
                    <span><?php echo esc_html($badge_text); ?></span>
                </div>
                
                <h1 id="category-title" class="archive-main-title"><?php echo esc_html($archive_title); ?></h1>
                
                <p class="archive-subtitle"><?php echo esc_html($archive_subtitle); ?></p>
                
                <?php if (is_category() && category_description()) : ?>
                    <div class="archive-description">
                        <?php echo wpautop(category_description()); ?>
                    </div>
                <?php endif; ?>
                
                <?php
                // Setup query with Polylang language filter
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 9,
                    'paged' => $paged,
                    'post_status' => 'publish'
                );
                
                // Add Polylang language filter
                if (function_exists('pll_current_language')) {
                    $args['lang'] = $current_lang;
                }
                
                // Add archive-specific filters
                if (is_category()) {
                    $args['cat'] = get_queried_object_id();
                } elseif (is_tag()) {
                    $args['tag_id'] = get_queried_object_id();
                } elseif (is_date()) {
                    $args['year'] = get_query_var('year');
                    $args['monthnum'] = get_query_var('monthnum');
                    $args['day'] = get_query_var('day');
                } elseif (is_author()) {
                    $args['author'] = get_queried_object_id();
                }
                
                $filtered_query = new WP_Query($args);
                $total_posts = $filtered_query->found_posts;
                ?>
                
                <div class="archive-meta-info">
                    <div class="archive-meta-item">
                        <i class="fa-solid fa-file-lines"></i>
                        <strong><?php echo $total_posts; ?></strong>
                        <span><?php echo ($total_posts == 1 ? 'منشور واحد' : 'منشورات'); ?></span>
                    </div>
                    
                    <?php if (is_author() && isset($post_count)) : ?>
                        <div class="archive-meta-item">
                            <i class="fa-solid fa-newspaper"></i>
                            <strong><?php echo $post_count; ?></strong>
                            <span><?php echo ($post_count == 1 ? 'مقال واحد' : 'مقالات'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Navigation Bar -->
    <?php
    // Only show navigation for category archives with subcategories
    if (is_category()) :
        // Get current language
        $current_lang = 'ar';
        if (function_exists('pll_current_language')) {
            $current_lang = pll_current_language();
        }
        
        // Get categories for navigation
        $nav_categories = array();
        $current_category_id = 0;
        $parent_category_id = 0;
        
        $current_category = get_queried_object();
        $current_category_id = $current_category->term_id;
        
        // Get parent category
        if ($current_category->parent > 0) {
            $parent_category = get_category($current_category->parent);
            $parent_category_id = $parent_category->term_id;
            
            // Get all siblings (children of parent)
            $nav_categories = get_categories(array(
                'parent' => $parent_category_id,
                'hide_empty' => true,
                'orderby' => 'name',
                'order' => 'ASC'
            ));
        } else {
            // This is a parent category, get its children
            $parent_category_id = $current_category_id;
            $nav_categories = get_categories(array(
                'parent' => $current_category_id,
                'hide_empty' => true,
                'orderby' => 'name',
                'order' => 'ASC'
            ));
        }
        
        // Filter by language
        if (function_exists('pll_get_term_language')) {
            $filtered_cats = array();
            foreach ($nav_categories as $cat) {
                $cat_lang = pll_get_term_language($cat->term_id);
                if ($cat_lang === $current_lang) {
                    $filtered_cats[] = $cat;
                }
            }
            $nav_categories = $filtered_cats;
        }
        
        // Show navigation only if we have subcategories or if we're showing parent category link
        $show_parent_link = ($parent_category_id > 0 && $parent_category_id != $current_category_id);
        $has_categories = !empty($nav_categories);
        
        // Only show navigation if we have at least one subcategory to navigate between
        if ($has_categories || $show_parent_link) :
    ?>
    <div class="archive-category-nav">
        <div class="archive-category-nav-container">
            <nav class="archive-category-nav-list" id="archive-category-nav">
                <?php if (is_category() && $parent_category_id > 0) : 
                    $parent_category = get_category($parent_category_id);
                    $is_parent_active = ($current_category_id == $parent_category_id);
                ?>
                    <a href="<?php echo esc_url(get_category_link($parent_category_id)); ?>" 
                       class="archive-category-nav-item <?php echo $is_parent_active ? 'active' : ''; ?>"
                       data-category-id="<?php echo $parent_category_id; ?>"
                       data-parent-category-id="0">
                        <span><?php echo esc_html($parent_category->name); ?></span>
                    </a>
                <?php endif; ?>
                
                <?php foreach ($nav_categories as $nav_cat) : 
                    $is_active = ($current_category_id == $nav_cat->term_id);
                ?>
                    <a href="<?php echo esc_url(get_category_link($nav_cat->term_id)); ?>" 
                       class="archive-category-nav-item <?php echo $is_active ? 'active' : ''; ?>"
                       data-category-id="<?php echo $nav_cat->term_id; ?>"
                       data-parent-category-id="<?php echo $parent_category_id; ?>">
                        <span><?php echo esc_html($nav_cat->name); ?></span>
                        <span class="archive-category-count"><?php echo $nav_cat->count; ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($filtered_query->have_posts()) : ?>
        <div class="archive-posts-container">
            <div class="posts-container" id="posts-container">
                <div class="posts-grid" id="posts-grid">
                    <?php
                    while ($filtered_query->have_posts()) : $filtered_query->the_post();
                        get_template_part('includes/post-card', null, array('read_more_text' => 'اقرأ المزيد'));
                    endwhile;
                    ?>
                </div>
                
                    <?php
                    // Build base URL based on archive type
                    if (is_category()) {
                        $base_url = get_category_link(get_queried_object_id());
                    } elseif (is_tag()) {
                        $base_url = get_tag_link(get_queried_object_id());
                    } elseif (is_date()) {
                        $base_url = get_pagenum_link(1);
                        $base_url = preg_replace('/page\/\d+\//', '', $base_url);
                    } elseif (is_author()) {
                        $base_url = get_author_posts_url(get_the_author_meta('ID'));
                    } else {
                        $base_url = get_pagenum_link(1);
                    }
                    
                    get_template_part('includes/pagination', null, array(
                        'paged' => $paged,
                        'total_pages' => $filtered_query->max_num_pages,
                        'base_url' => trailingslashit($base_url),
                        'anchor_id' => '#category-title',
                        'page_text' => 'صفحة %s من %s'
                    ));
                    
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="archive-posts-container">
            <div class="no-posts">
                <i class="fa-solid fa-file-circle-question"></i>
                <h3>لا توجد منشورات</h3>
                <p>لا توجد منشورات في هذه الفئة حتى الآن.</p>
            </div>
        </div>
    <?php 
    endif;
    wp_reset_postdata();
    ?>
</main>

<?php get_footer('ar'); ?>
</html>

