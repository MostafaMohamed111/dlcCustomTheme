<?php get_header(); 
?>


<div class="hero-international">
    <div class="hero-content-international">
        <h1 class="hero-company-international">Dag Law firm & Legal Consultation</h1>
        <h2 class="hero-title-international">Your Trusted Legal <br><span>Partner</span> for<br> Businesses <br> Worldwide</h2>
        <p class="hero-subtitle-international lead">Expert Legal Solutions Tailored to Your Needs.
        </p>

        <div class="actions-international">
            <a href="<?php echo home_url('/booking/'); ?>" class="btn hero-btn-international get-appointment-international">Get Appointment</a>
            <a href="<?php echo home_url('/contact/'); ?>" class="btn hero-btn-international contact-us-international" >Contact Us</a>
        </div>

    </div>


</div>


<div class="page-content">
<div class="services-landing companies-services-page">
    <div class="header">
        <h2 class="services-title">International Services<li class="fa-solid fa-globe ps-2"></li></h2>
        <?php
        // Get the home-international category for default description
        $display_category = null;
        if (isset($_GET['cat']) && $_GET['cat'] > 0) {
            // Show selected category description
            $display_category = get_category(intval($_GET['cat']));
        } else {
            // Show parent category description
            $display_category = get_category_by_slug('home-international');
        }
        
        if ($display_category && !empty($display_category->description)) {
            echo '<div class="archive-description services-subtitle lead">' . wpautop($display_category->description) . '</div>';
        } else {
            // Fallback if no description is set
            echo '<p class="services-subtitle lead">Discover our exclusive legal services tailored for international clients. We provide expert solutions to help businesses navigate Saudi regulations with confidence and ease.</p>';
        }
        ?>
    </div>

    <div class="container">
        <?php
        // Get the home-international category
        $parent_category = get_category_by_slug('home-international');
        
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
            
            // Get all category IDs for home-international and its children (for "All Services" count)
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
                // Get all posts from home-international and its children
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
                                // Get post count for "All Services" (all posts in home-international and children)
                                $all_services_query = new WP_Query(array(
                                    'category__in' => $all_category_ids,
                                    'posts_per_page' => -1,
                                    'post_status' => 'publish'
                                ));
                                $all_services_count = $all_services_query->found_posts;
                                wp_reset_postdata();
                                ?>
                                <a href="<?php echo get_category_link($parent_category->term_id); ?>" 
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
                        get_template_part('includes/service-card', null, array(
                            'button_text' => 'Read More',
                            'excerpt_length' => 120
                        ));
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
                            'page_text' => 'Page %s of %s'
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
                <p>The home-international category does not exist. Please create a category with the slug "home-international".</p>
            </div>
            <?php
        }
        ?>
    </div>
</div>



<?php
$cases_count = (int) get_field('cases');
$contracts_count = (int) get_field('contracts');
$clients_count = (int) get_field('clients');
$intellectual_properties_count = (int) get_field('intellectual_properties');
?>
<section class="achievements-section">
    <div class="container">
        <h2 class="achievements-title">Achievements</h2>
        <p class="achievements-intro">
            Since the inception of Dag Law Firm, providing legal advice, client satisfaction, and meeting their needs has been our compass and our constant goal. Through our work, we have been pleased to be successful partners for a group of prestigious institutions and organizations, and their expression of satisfaction with this distinguished partnership is what we have.
        </p>
        
        <div class="achievements-grid">
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($cases_count); ?>"><?php echo esc_html($cases_count); ?></div>
                <div class="achievement-label">Cases</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($contracts_count); ?>"><?php echo esc_html($contracts_count); ?></div>
                <div class="achievement-label">Contracts</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($clients_count); ?>"><?php echo esc_html($clients_count); ?></div>
                <div class="achievement-label">Clients</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($intellectual_properties_count); ?>"><?php echo esc_html($intellectual_properties_count); ?></div>
                <div class="achievement-label">Intellectual Properties</div>
            </div>
        </div>
        
        <p class="achievements-conclusion">
            We are proud of what we have accomplished since the beginning of our journey.
        </p>
    </div>
</section>




<section class="why-choose-us">
    <div class="why-choose-us-header">
        <h2 class="why-choose-us-title">Why Choose Us</h2>
        <p class="why-choose-us-intro">
            We combine deep legal expertise with a commitment to excellence, ensuring that your business receives the highest quality legal services tailored to your unique needs and goals.
        </p>
        </div>

    <div class="container">
        
        <div class="why-choose-us-grid">
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-gavel"></i>
                </div>
                <h3 class="why-choose-us-card-title">Expert Legal Team</h3>
                <p class="why-choose-us-card-description">
                    Our experienced attorneys specialize in Saudi Arabian law and international business regulations, providing you with comprehensive legal guidance.
                </p>
            </div>
            
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <h3 class="why-choose-us-card-title">Trusted Partnership</h3>
                <p class="why-choose-us-card-description">
                    We build long-term relationships with our clients, understanding their business needs and providing personalized legal solutions.
                </p>
            </div>
            
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <h3 class="why-choose-us-card-title">International Expertise</h3>
                <p class="why-choose-us-card-description">
                    With deep knowledge of both local and international legal frameworks, we help businesses navigate complex cross-border regulations.
                </p>
            </div>
            
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h3 class="why-choose-us-card-title">Timely Solutions</h3>
                <p class="why-choose-us-card-description">
                    We understand the importance of time in business. Our team delivers efficient, responsive legal services when you need them most.
                </p>
            </div>
        </div>
    </div>
</section>


</div>
















<?php get_footer(); ?>