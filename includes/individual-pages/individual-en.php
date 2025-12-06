<?php get_header(); ?>

<div class="hero individuals-hero">
    <div class="layout">

    </div>
    <div class="content">
        <h4>We Got Your Back </h4>
        <h1><span>Dag</span> Individual Legal Services</h1>
        <p class="lead">DAG Law Firm offers a comprehensive range of legal services tailored to meet the needs of individuals across various legal matters — ensuring rights protection and fair outcomes in accordance with Saudi laws and regulations.
</p>
    </div>
</div>



<div class="page-content">
    

    <div class="services-landing individual-services-page">
        <div class="header">
            <h2 id="services-title" class="services-title">Individuals Services<li class="fa-solid fa-user ps-2"></li></h2>
            <?php
            // Get the individual-services category for default description
            $display_category = null;
            if (isset($_GET['cat']) && $_GET['cat'] > 0) {
                // Show selected category description
                $display_category = get_category(intval($_GET['cat']));
            } else {
                // Show parent category description
                $display_category = get_category_by_slug('individual-services');
            }
            
            if ($display_category && !empty($display_category->description)) {
                echo '<div class="archive-description services-subtitle lead">' . wpautop($display_category->description) . '</div>';
            } else {
                // Fallback if no description is set
                echo '<p class="services-subtitle lead">Explore our specialized legal services designed for individuals and families.</p>';
            }
            ?>
        </div>

        <div class="container">
            <?php
            // Get the individual-services category
            $parent_category = get_category_by_slug('individual-services');
            
            if ($parent_category) {
                // Get all child categories
                $child_categories = get_categories(array(
                    'parent' => $parent_category->term_id,
                    'hide_empty' => true,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ));
                
                // Get current category filter from URL or queried object
                $current_category = 0;
                if (is_category()) {
                    $queried_category = get_queried_object();
                    // Check if this is a child of the parent category
                    if ($queried_category->parent == $parent_category->term_id || $queried_category->term_id == $parent_category->term_id) {
                        $current_category = $queried_category->term_id;
                    }
                } else {
                $current_category = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
                }
                
                // Get all category IDs for individual-services and its children (for "All Services" count)
                $all_category_ids = array($parent_category->term_id);
                $all_children = get_term_children($parent_category->term_id, 'category');
                if (!is_wp_error($all_children)) {
                    $all_category_ids = array_merge($all_category_ids, $all_children);
                }
                
                // Setup query arguments
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $posts_per_page = 6; // 3 columns × 2 rows
                
                $query_args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => $posts_per_page,
                    'paged' => $paged,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                
                // Filter by category
                if ($current_category > 0) {
                    // Get specific child category and its children
                    $selected_category = get_category($current_category);
                    if ($selected_category) {
                        $category_ids = array($selected_category->term_id);
                        $children = get_term_children($selected_category->term_id, 'category');
                        if (!is_wp_error($children)) {
                            $category_ids = array_merge($category_ids, $children);
                        }
                        $query_args['category__in'] = $category_ids;
                    }
                } else {
                    // Get all posts from individual-services and its children
                    $query_args['category__in'] = $all_category_ids;
                }
                
                // Create custom query
                $services_query = new WP_Query($query_args);
                ?>
                
                <div class="services-content">
                    <!-- Sidebar Navigation -->
                    <aside class="services-sidebar">
                        <div class="sidebar-widget categories-widget">
                            <?php
                            // Determine current category name for display
                            $current_category_name = 'All Services';
                            if ($current_category > 0) {
                                $selected_category = get_category($current_category);
                                if ($selected_category) {
                                    $current_category_name = $selected_category->name;
                                }
                            }
                            ?>
                            <button class="categories-toggle-btn" type="button">
                                <span class="toggle-content">
                                    <i class="fa-solid fa-folder-open"></i>
                                    <span class="toggle-text"><?php echo esc_html($current_category_name); ?></span>
                                </span>
                                <i class="fa-solid fa-chevron-down toggle-icon"></i>
                            </button>
                            <ul class="categories-list">
                                <li>
                                    <?php
                                    // Get post count for "All Services" (all posts in individual-services and children)
                                    $all_services_query = new WP_Query(array(
                                        'category__in' => $all_category_ids,
                                        'posts_per_page' => -1,
                                        'post_status' => 'publish'
                                    ));
                                    $all_services_count = $all_services_query->found_posts;
                                    wp_reset_postdata();
                                    ?>
                                    <a href="<?php echo esc_url(get_category_link($parent_category->term_id) . '#services-title'); ?>" 
                                    class="category-link <?php echo $current_category == 0 ? 'active' : ''; ?>"
                                    data-category-id="0"
                                    data-parent-category-id="<?php echo $parent_category->term_id; ?>">
                                        <span class="category-name">All Services</span>
                                        <span class="category-count"><?php echo $all_services_count; ?></span>
                                    </a>
                                </li>
                                <?php foreach ($child_categories as $child_cat) : 
                                    $is_active = ($current_category == $child_cat->term_id);
                                    ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_category_link($child_cat->term_id) . '#services-title'); ?>" 
                                        class="category-link <?php echo $is_active ? 'active' : ''; ?>"
                                        data-category-id="<?php echo $child_cat->term_id; ?>"
                                        data-parent-category-id="<?php echo $parent_category->term_id; ?>">
                                            <span class="category-name"><?php echo esc_html($child_cat->name); ?></span>
                                            <span class="category-count"><?php echo $child_cat->count; ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </aside>
                    
                    <!-- Services Grid -->
                    <main class="services-main" id="services-main">
                        <?php if ($services_query->have_posts()) : ?>
                            <div class="services-grid" id="services-grid">
                        <?php
                        while ($services_query->have_posts()) : $services_query->the_post();
                            get_template_part('includes/service-card', null, array('button_text' => 'Read More'));
                        endwhile;
                            wp_reset_postdata();
                            ?>
                            </div>
                            
                            <?php
                            // Pagination
                            $base_url = $current_category > 0 
                                ? get_category_link($current_category)
                                : get_category_link($parent_category->term_id);
                            
                            get_template_part('includes/pagination', null, array(
                                'paged' => $paged,
                                'total_pages' => $services_query->max_num_pages,
                                'base_url' => $base_url,
                                'anchor_id' => '#services-title',
                                'page_text' => 'Page %s of %s',
                                'category_id' => $current_category,
                                'parent_category_id' => $parent_category->term_id
                            ));
                        else :
                            ?>
                            <div class="no-services">
                                <i class="fa-solid fa-briefcase"></i>
                                <h3>No services found</h3>
                                <p>There are no services available in this category at the moment.</p>
                            </div>
                            <?php
                        endif;
                        ?>
                    </main>
                </div>
                <?php
            } else {
                ?>
                <div class="no-services">
                    <i class="fa-solid fa-briefcase"></i>
                    <h3>Category not found</h3>
                    <p>The individual-services category does not exist. Please create a category with the slug "individual-services".</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="faq-container">
            <h2 class="faq-title">FAQs – Individual Legal Services</h2>
            <p class="faq-subtitle">Find answers to common questions about our individual legal services</p>
            
            <ul class="faq-list">
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">Can DAG represent clients in family law cases?</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">Yes, our lawyers handle family law matters before Saudi personal status courts in full compliance with local regulations.</p>
                    </div>
                </li>
                
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">Do you review personal contracts before signing?</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">Yes, we provide detailed contract reviews and highlight potential legal risks before signing.</p>
                    </div>
                </li>
                
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">How long does the inheritance settlement process usually take?</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">It varies depending on the size of the estate and number of heirs, but our team manages the process from documentation to final distribution.</p>
                    </div>
                </li>
                
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">Do your services include individual labor disputes?</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">Yes, our individual legal services cover employment-related cases, including termination and unpaid entitlements.</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

  
<!-- Book Consultation Section -->
<section class="consultation-cta-section">
    <div class="container">
        <div class="consultation-cta-wrapper">
            <div class="consultation-cta-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <h2 class="consultation-cta-title">Book a Legal Consultation</h2>
            <p class="consultation-cta-description">
                Dag Legal Firm offers flexible consultation options, ensuring clients receive timely and tailored legal assistance based on their needs.
            </p>
            <a href="<?php echo esc_url(home_url('/booking')); ?>" class="consultation-cta-button">
                <span>Request Legal Consultation</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

</div>











<?php get_footer(); ?>