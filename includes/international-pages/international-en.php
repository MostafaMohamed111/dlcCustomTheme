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
            <a href="<?php echo home_url('/contact-us/'); ?>" class="btn hero-btn-international contact-us-international" >Contact Us</a>
        </div>

    </div>


</div>



<div class="page-content">
<div class="services-landing companies-services-page">
    <div class="header">
        <h2 class="services-title">Our International Services<li class="fa-solid fa-globe ps-2"></li></h2>
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
                // Check if this is the parent or a child of the parent category
                if ($queried_category->term_id == $parent_category->term_id) {
                    // Parent category archive → treat as "All International Services"
                    $current_category = 0;
                } elseif ($queried_category->parent == $parent_category->term_id) {
                    // Direct child of parent → specific sub-category filter
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
            
            // Get current page number for pagination
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            
            // Setup query arguments with pagination enabled
            $query_args = array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => DLC_POSTS_PER_PAGE,
                'paged'          => $paged,
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
                        // Default label represents the parent international services group
                        $current_category_name = 'International Services';
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
                                // Get post count for all international services (parent + children)
                                $all_services_query = new WP_Query(array(
                                    'category__in'   => $all_category_ids,
                                    'posts_per_page' => -1,
                                    'post_status'    => 'publish',
                                ));
                                $all_services_count = $all_services_query->found_posts;
                                wp_reset_postdata();
                                ?>
                                <a href="<?php echo get_category_link($parent_category->term_id); ?>" 
                                   class="category-link <?php echo $current_category == 0 ? 'active' : ''; ?>"
                                   data-category-id="0"
                                   data-parent-category-id="<?php echo $parent_category->term_id; ?>">
                                    <span class="category-name">International Services</span>
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
                        ?>
                        </div>
                        
                        <?php
                        // Add pagination
                        $total_pages = $services_query->max_num_pages;
                        if ($total_pages > 1) :
                            // Build base URL for pagination
                            $base_url = '';
                            if ($current_category > 0) {
                                $base_url = get_category_link($current_category);
                            } else {
                                $base_url = get_category_link($parent_category->term_id);
                            }
                            
                            get_template_part('includes/pagination', null, array(
                                'paged' => $paged,
                                'total_pages' => $total_pages,
                                'base_url' => trailingslashit($base_url),
                                'anchor_id' => '#services-title',
                                'page_text' => 'Page %s of %s',
                                'category_id' => $current_category,
                                'parent_category_id' => $parent_category->term_id
                            ));
                        endif;
                        
                        wp_reset_postdata();
                        ?>
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
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <h3 class="why-choose-us-card-title">Accurate Legal Procedures</h3>
                <p class="why-choose-us-card-description">
                    We ensure precision and accuracy in every legal procedure, following strict compliance with Saudi Arabian law and international standards to protect your interests.
                </p>
            </div>
            
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <h3 class="why-choose-us-card-title">Consistent Follow-Up on All Cases</h3>
                <p class="why-choose-us-card-description">
                    Our dedicated team provides continuous monitoring and regular updates on your case, ensuring you stay informed at every stage of the legal process.
                </p>
            </div>
            
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="why-choose-us-card-title">Strict Confidentiality of Client Information</h3>
                <p class="why-choose-us-card-description">
                    We maintain the highest standards of confidentiality and data protection, ensuring all your sensitive information remains secure and private.
                </p>
            </div>
            
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <h3 class="why-choose-us-card-title">Extensive Experience with International Matters</h3>
                <p class="why-choose-us-card-description">
                    With deep knowledge of both local and international legal frameworks, we expertly handle cross-border transactions and complex international legal matters.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="faq-container">
        <h2 class="faq-title">FAQ – Frequently Asked Questions</h2>
        <p class="faq-subtitle">Find answers to common questions about our international legal services</p>
        
        <ul class="faq-list">
            <li class="faq-item">
                <div class="faq-question" role="button" aria-expanded="false">
                    <span class="faq-question-text">How can international clients start legal procedures in Saudi Arabia?</span>
                    <span class="faq-question-icon">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">By submitting the required documents for review, upon which we handle the full legal process with the competent authority.</p>
                </div>
            </li>
            
            <li class="faq-item">
                <div class="faq-question" role="button" aria-expanded="false">
                    <span class="faq-question-text">Can services be completed remotely?</span>
                    <span class="faq-question-icon">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Yes, most services can be conducted remotely unless specific procedures require in-person presence by law.</p>
                </div>
            </li>
            
            <li class="faq-item">
                <div class="faq-question" role="button" aria-expanded="false">
                    <span class="faq-question-text">What documents are required for foreign investment licensing?</span>
                    <span class="faq-question-icon">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Requirements vary by activity but usually include the foreign commercial registration, financial statements, and ownership details.</p>
                </div>
            </li>
            
            <li class="faq-item">
                <div class="faq-question" role="button" aria-expanded="false">
                    <span class="faq-question-text">How long does trademark registration take in Saudi Arabia?</span>
                    <span class="faq-question-icon">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Typically 4–8 months depending on the examination and publication stages.</p>
                </div>
            </li>
            
            <li class="faq-item">
                <div class="faq-question" role="button" aria-expanded="false">
                    <span class="faq-question-text">Is international patent protection available?</span>
                    <span class="faq-question-icon">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Local filing is handled in Saudi Arabia, while international protection can be guided through relevant global treaties and mechanisms.</p>
                </div>
            </li>
        </ul>
    </div>
</section>

<!-- About Dag Law Firm Section -->
<section class="about-dag-section">
    <div class="about-dag-container">
        <h2 class="about-dag-title">About Dag Law Firm</h2>
        <div class="about-dag-content">
            <p class="about-dag-text">
                Dag Law Firm, led by Attorney Mohammed Dagistani, offers over 80 legal services across commercial, industrial, agricultural, and financial sectors — supported by extensive experience in Saudi law and regulatory practices.
            </p>
        </div>
        <div class="about-dag-cta">
            <a href="<?php echo esc_url(dlc_get_about_us_page_url('en')); ?>" class="about-dag-btn">
                Learn More About Us
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

</div>
















<?php get_footer(); ?>