<?php


get_header(); ?>

<div class="hero">
    <div class="hero-background">
        <div class="hero-content ">
            <h1 class="hero-company">Dag <span>Provides</span></h1>
            <h2 class="hero-title">Variaty Of Legal Solutions And<br/> Security Consultation</h2>
            <p class="hero-subtitle lead">Learn how to safeguard your rights with our expert legal guidance.</p>
        </div>
    </div>
    
</div>


<div class="wrapper">
        <div class="secure-yourself-content header">
            <h2 class="title lead ">Our Professional Lawyers Suggest</h2>
            <?php
            // Get category description from WordPress
            $display_category = null;
            if (is_category()) {
                $display_category = get_queried_object();
            } else {
                // Get secure-yourself parent category
                $display_category = get_category_by_slug('secure-yourself');
                if (!$display_category) {
                    $display_category = get_term_by('name', 'Secure Yourself', 'category');
                }
            }
            
            if ($display_category && !empty($display_category->description)) {
                echo '<p class="subtitle lead ">' . wpautop($display_category->description) . '</p>';
            } else {
                // Fallback if no description is set
                echo '<p class="subtitle lead text-center">In today\'s complex legal landscape, understanding how to protect your rights is more important than ever. At Dag Law Firm & Consultation, our team of experienced lawyers is dedicated to providing you with the knowledge and tools you need to secure yourself legally.</p>';
            }
            ?>
        </div>
<div class="container overflow-hidden">
    <section class="secure-yourself">

     <?php
 // Only show navigation for category archives with subcategories
    if (is_category()) :
        // Get current language
        $current_lang = 'en';
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

    <?php
    // Get posts from secure-yourself category
    $current_lang = 'en';
    if (function_exists('pll_current_language')) {
        $current_lang = pll_current_language();
    }
    
    // Get secure-yourself category
    $secure_category = get_category_by_slug('secure-yourself');
    if (!$secure_category) {
        $secure_category = get_term_by('name', 'Secure Yourself', 'category');
    }
    
    // Get category ID (use current category if on category archive, otherwise use parent)
    $category_id = 0;
    $parent_category_id = 0;
    
    if (is_category()) {
        $queried_category = get_queried_object();
        $category_id = $queried_category->term_id;
        
        // Check if this category belongs to secure-yourself
        $top_slug = dlc_get_category_type_slug($category_id);
        if ($top_slug === 'secure-yourself') {
            // Get parent if this is a child
            if ($queried_category->parent > 0) {
                $parent_category_id = $queried_category->parent;
            } else {
                $parent_category_id = $category_id;
            }
        } else {
            // Not a secure-yourself category, don't show posts
            $category_id = 0;
        }
    } else {
        // Not on category archive, use parent category
        if ($secure_category) {
            $parent_category_id = $secure_category->term_id;
        }
    }
    
    // Setup query
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $posts_per_page = DLC_POSTS_PER_PAGE;
    
    $query_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    // Add Polylang language filter
    if (function_exists('pll_current_language')) {
        $query_args['lang'] = $current_lang;
    }
    
    // Filter by category
    if ($category_id > 0) {
        // Get category and its children
        $category_ids = array($category_id);
        $children = get_term_children($category_id, 'category');
        if (!is_wp_error($children)) {
            $category_ids = array_merge($category_ids, $children);
        }
        $query_args['category__in'] = $category_ids;
    } elseif ($parent_category_id > 0) {
        // Get all posts from secure-yourself and its children
        $all_category_ids = array($parent_category_id);
        $all_children = get_term_children($parent_category_id, 'category');
        if (!is_wp_error($all_children)) {
            $all_category_ids = array_merge($all_category_ids, $all_children);
        }
        $query_args['category__in'] = $all_category_ids;
    } else {
        // No category found, don't query
        $query_args = null;
    }
    
    if ($query_args) {
        $posts_query = new WP_Query($query_args);
        
        if ($posts_query->have_posts()) :
            ?>
            <main class="services-main" id="services-main">
                <div class="services-grid" id="services-grid">
                    <?php
                    while ($posts_query->have_posts()) : $posts_query->the_post();
                        get_template_part('includes/service-card', null, array(
                            'button_text' => 'Read More',
                            'current_category_id' => $category_id > 0 ? $category_id : $parent_category_id
                        ));
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
                
                <?php
                // Pagination
                $total_pages = $posts_query->max_num_pages;
                if ($total_pages > 1) :
                    // Build base URL
                    $base_url = '';
                    if ($category_id > 0) {
                        $base_url = get_category_link($category_id);
                    } elseif ($parent_category_id > 0) {
                        $base_url = get_category_link($parent_category_id);
                    } else {
                        $base_url = home_url();
                    }
                    
                    get_template_part('includes/pagination', null, array(
                        'paged' => $paged,
                        'total_pages' => $total_pages,
                        'base_url' => trailingslashit($base_url),
                        'anchor_id' => '#services-title',
                        'page_text' => 'Page %s of %s',
                        'category_id' => $category_id,
                        'parent_category_id' => $parent_category_id
                    ));
                endif;
                ?>
            </main>
            <?php
        else :
            ?>
            <main class="services-main" id="services-main">
                <div class="no-services">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h3>No services found</h3>
                    <p>There are no services available in this category at the moment.</p>
                </div>
            </main>
            <?php
        endif;
    }
    ?>

    </section>



</div>
</div>


<?php get_footer(); ?>