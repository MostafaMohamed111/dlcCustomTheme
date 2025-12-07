<?php get_header(); ?>

<div class="hero">
    <div class="layout">

    </div>
    <div class="content">
        <h4>Legal Services for Businesses
</h4>
        <h1><span>Dag</span> Corporate Legal Services</h1>
        <p class="lead">DAG Law Firm provides integrated legal solutions to support businesses at every stage — from company formation and regulatory compliance to contract management and dispute resolution.
</p>
    </div>
</div>

<div class="page-content">

    <div class="services-landing companies-services-page">
        <div class="header">
            <h2 id="services-title" class="services-title">Companies Services<li class="fa-solid fa-building ps-2"></li></h2>
            <?php
            // Get the companies-services category for default description
            $display_category = null;
            if (isset($_GET['cat']) && $_GET['cat'] > 0) {
                // Show selected category description
                $display_category = get_category(intval($_GET['cat']));
            } else {
                // Show parent category description
                $display_category = get_category_by_slug('companies-services');
            }
            
            if ($display_category && !empty($display_category->description)) {
                echo '<div class="archive-description services-subtitle lead">' . wpautop($display_category->description) . '</div>';
            } else {
                // Fallback if no description is set
                echo '<p class="services-subtitle lead">Explore our specialized legal services designed for companies and corporate clients.</p>';
            }
            ?>
        </div>

        <div class="container">
            <?php
            // Get the companies-services category
            $parent_category = get_category_by_slug('companies-services');
            
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
                    // Parent category archive → treat as "All Company Services"
                    if ($queried_category->term_id == $parent_category->term_id) {
                        $current_category = 0;
                    } elseif ($queried_category->parent == $parent_category->term_id) {
                        // Direct child of parent → specific sub-category
                        $current_category = $queried_category->term_id;
                    }
                } else {
                    $current_category = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
                }
                
                // Get all category IDs for companies-services and its children (for total count)
                $all_category_ids = array($parent_category->term_id);
                $all_children = get_term_children($parent_category->term_id, 'category');
                if (!is_wp_error($all_children)) {
                    $all_category_ids = array_merge($all_category_ids, $all_children);
                }
                
                // Setup query arguments (load all matching services, no pagination)
                $query_args = array(
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
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
                    // Get all posts from companies-services and its children
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
                            // Default label represents the parent companies services group
                            $current_category_name = 'Companies Services';
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
                                    // Get post count for all company services (parent + children)
                                    $all_services_query = new WP_Query(array(
                                        'category__in'   => $all_category_ids,
                                        'posts_per_page' => -1,
                                        'post_status'    => 'publish',
                                    ));
                                    $all_services_count = $all_services_query->found_posts;
                                    wp_reset_postdata();
                                    ?>
                                    <a href="<?php echo esc_url(get_category_link($parent_category->term_id) . '#services-title'); ?>" 
                                    class="category-link <?php echo $current_category == 0 ? 'active' : ''; ?>"
                                    data-category-id="0"
                                    data-parent-category-id="<?php echo $parent_category->term_id; ?>">
                                        <span class="category-name">Companies Services</span>
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
                    <p>The companies-services category does not exist. Please create a category with the slug "companies-services".</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="faq-container">
            <h2 class="faq-title">   FAQs – Corporate Legal Services</h2>
            <p class="faq-subtitle">Find answers to common questions about our corporate legal services</p>
            
            <ul class="faq-list">
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">Does DAG assist with setting up foreign companies in Saudi Arabia?</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">Yes, we handle the establishment of foreign entities and coordinate with the relevant Saudi authorities to issue licenses.</p>
                    </div>
                </li>
                
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">Can you draft international commercial contracts?</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">Yes, our team can draft contracts under Saudi law or international conventions, depending on the nature of your business.</p>
                    </div>
                </li>
                
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">How does DAG help reduce legal risks?</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">We regularly review internal policies, contracts, and provide compliance reports tailored to your company's operations.</p>
                    </div>
                </li>
                
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">Can you represent companies in arbitration cases?</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">Yes, our lawyers have extensive experience in local and international arbitration proceedings.</p>
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