<?php
/**
 * Generic Archive Template
 * Handles tags, dates, authors, and other archives
 * Language-agnostic - shows all posts with the specified tag/date/author
 */

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
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
            <?php
            // Determine archive type and set appropriate content
            $archive_type = '';
            $archive_title = '';
            $archive_subtitle = '';
            $badge_icon = '';
            $badge_text = '';
            
            if (is_tag()) {
                $tag = get_queried_object();
                $archive_type = 'tag';
                $badge_icon = 'fa-tag';
                $badge_text = 'Tag Archive';
                $archive_title = single_tag_title('', false);
                $archive_subtitle = 'Exploring content tagged with "' . $archive_title . '"';
                $post_count = $tag->count;
            } elseif (is_date()) {
                $archive_type = 'date';
                $badge_icon = 'fa-calendar-days';
                $badge_text = 'Date Archive';
                if (is_year()) {
                    $archive_title = get_the_date('Y');
                    $archive_subtitle = 'Posts published in ' . $archive_title;
                } elseif (is_month()) {
                    $archive_title = get_the_date('F Y');
                    $archive_subtitle = 'Posts published in ' . $archive_title;
                } elseif (is_day()) {
                    $archive_title = get_the_date('F j, Y');
                    $archive_subtitle = 'Posts published on ' . $archive_title;
                }
            } elseif (is_author()) {
                $author = get_queried_object();
                $archive_type = 'author';
                $badge_icon = 'fa-user-pen';
                $badge_text = 'Author Archive';
                $archive_title = get_the_author();
                $archive_subtitle = 'Articles written by ' . $archive_title;
                $post_count = count_user_posts($author->ID);
            } else {
                $archive_type = 'general';
                $badge_icon = 'fa-folder-open';
                $badge_text = 'Archive';
                $archive_title = 'Archive';
                $archive_subtitle = 'Browse our collection of posts';
            }
            ?>
            
            <div class="archive-hero">
                <div class="archive-hero-content">
                    <div class="archive-type-badge">
                        <i class="fa-solid <?php echo $badge_icon; ?>"></i>
                        <span><?php echo $badge_text; ?></span>
                    </div>
                    
                    <h1 class="archive-main-title"><?php echo $archive_title; ?></h1>
                    
                    <p class="archive-subtitle"><?php echo $archive_subtitle; ?></p>
                    
                    <?php if (term_description()) : ?>
                        <div class="archive-description">
                            <?php echo term_description(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php
                    // Setup query
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 9,
                        'paged' => $paged,
                    );
                    
                    if (is_tag()) {
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
                            <span><?php echo ($total_posts == 1 ? 'Post Found' : 'Posts Found'); ?></span>
                        </div>
                        
                        <?php if (is_author()) : ?>
                            <div class="archive-meta-item">
                                <i class="fa-solid fa-newspaper"></i>
                                <strong><?php echo $post_count; ?></strong>
                                <span><?php echo ($post_count == 1 ? 'Total Article' : 'Total Articles'); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($filtered_query->have_posts()) : ?>
            <div class="archive-posts-container">
                <div class="archive-posts-grid">
                    <?php
                    while ($filtered_query->have_posts()) : $filtered_query->the_post();
                        // Determine which card type to use based on post categories
                        $categories = get_the_category();
                        $is_news = false;
                        $is_service = false;
                        
                        if ($categories) {
                            foreach ($categories as $category) {
                                if (strpos($category->slug, 'news') !== false) {
                                    $is_news = true;
                                    break;
                                }
                                if (strpos($category->slug, 'services') !== false || 
                                    strpos($category->slug, 'home-international') !== false) {
                                    $is_service = true;
                                    break;
                                }
                            }
                        }
                        ?>
                        
                        <!-- Custom archive card -->
                        <article class="archive-post-card">
                            <div class="archive-post-thumbnail">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('large', array('class' => 'archive-post-image', 'alt' => get_the_title())); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <span class="archive-post-type-badge">
                                    <?php 
                                    if ($is_news) {
                                        echo 'News';
                                    } elseif ($is_service) {
                                        echo 'Services';
                                    } else {
                                        echo 'Blog';
                                    }
                                    ?>
                                </span>
                            </div>
                            
                            <div class="archive-post-content">
                                <div class="archive-post-meta">
                                    <span>
                                        <i class="fa-regular fa-calendar"></i>
                                        <?php echo get_the_date('M j, Y'); ?>
                                    </span>
                                    <span>
                                        <i class="fa-regular fa-user"></i>
                                        <?php the_author(); ?>
                                    </span>
                                </div>
                                
                                <h2 class="archive-post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <div class="archive-post-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>
                                
                                <div class="archive-post-footer">
                                    <a href="<?php the_permalink(); ?>" class="archive-read-more">
                                        Read More
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                        
                    <?php endwhile; ?>
                </div>
            </div>
            
            <div class="archive-pagination">
                <?php
                // Build base URL based on archive type
                if (is_tag()) {
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
                    'anchor_id' => '',
                    'page_text' => 'Page %s of %s'
                ));
                
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <div class="archive-no-posts">
                <i class="fa-solid fa-inbox"></i>
                <h3>No posts found</h3>
                <p>No posts were found in this archive.</p>
            </div>
        <?php 
        endif;
        wp_reset_postdata();
        ?>
</main>

<?php 
get_footer();
?>
</body>
</html>