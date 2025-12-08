<?php get_header(); ?>



<div class="main">

    


    <div class="container blog">
        <div class="main-header row gx-5">
            <div class="main-header-content col-lg-7 col-md-12">
               <h1 class="main-header-title">Dag Law Firm Legal Consultations<br> Blog
                
               </h1>
                <p class="main-header-subtitle">Welcome to our blog, where we provide expert legal insights, updates, and practical guidance tailored to the evolving legal landscape in the Kingdom of Saudi Arabia. Our team of experienced attorneys is dedicated to simplifying complex laws and delivering clear explanations that help individuals and businesses stay informed and empowered.</p>
                <p class="main-header-subtitle">Here, you’ll find articles covering the latest legal developments, regulatory changes, and strategic advice across various practice areas—from corporate and commercial law to litigation, contracts, and dispute resolution. Whether you are a client, a professional, or simply interested in Saudi law, our blog is your trusted source for reliable, up-to-date legal knowledge.</p>

                
           </div>
           <div class="main-header-image col-lg-5 col-md-12">
                <div class="image-container">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/SecureYourself.webp" alt="Blog Header Image" class="blog-header-img">
                </div>
               

            </div>
        </div>
        <div class="archive-header">
            <h2 id="category-title" class="category-title">
                <?php 
                if (is_category()) {
                    single_cat_title(); // Display current category name
                } elseif (is_tag()) {
                    single_tag_title(); // Display current tag name
                } elseif (is_archive()) {
                    post_type_archive_title(); // Display archive title
                }
                ?>
            </h2>
            <?php if ( category_description() ) : ?>
                <div class="archive-description">
                    <?php echo category_description(); ?>
                </div>
            <?php endif; ?>
        </div>
            
        <div class="blog-content">
            <aside class="blog-sidebar">
                <div class="sidebar-widget categories-widget">
                    <?php
                    // Determine current category name for display
                    // Default label represents the main blog
                    $current_category_name = 'Blog';
                    if (is_category()) {
                        $current_category = get_queried_object();
                        if ($current_category) {
                            $current_category_name = $current_category->name;
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
                            // Get the Blog parent category
                            $blog_category = get_category_by_slug('blog');
                            if (!$blog_category) {
                                // Try to find category with name "Blog"
                                $blog_category = get_term_by('name', 'Blog', 'category');
                            }
                            
                            if ($blog_category) {
                                $blog_url = get_category_link($blog_category->term_id);
                                $is_blog_active = is_category($blog_category->term_id) || (is_archive() && !is_category());
                                // Get actual post count for Blog category (including child categories)
                                $blog_query = new WP_Query(array(
                                    'cat' => $blog_category->term_id,
                                    'posts_per_page' => -1,
                                    'post_status' => 'publish'
                                ));
                                $blog_count = $blog_query->found_posts;
                                wp_reset_postdata();
                            } else {
                                // Fallback to posts page
                                $blog_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url();
                                $is_blog_active = is_home() || (is_archive() && !is_category() && !is_tag());
                                $blog_count = wp_count_posts()->publish;
                            }
                            ?>
                            <a href="<?php echo esc_url($blog_url . '#category-title'); ?>" 
                               class="category-link <?php echo $is_blog_active ? 'active' : ''; ?>"
                               data-category-id="<?php echo $blog_category ? $blog_category->term_id : 0; ?>">
                                <span class="category-name">Blog</span>
                                <span class="category-count"><?php echo $blog_count; ?></span>
                            </a>
                        </li>
                        <?php
                        // Get only English categories (children of 'blog' category)
                        if ($blog_category) {
                            $all_categories = get_categories(array(
                                'child_of' => $blog_category->term_id,
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => true
                            ));
                        } else {
                            // Fallback: get all categories except those with '-ar' in slug
                        $all_categories = get_categories(array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => true
                        ));
                        }
                        
                        foreach($all_categories as $category) {
                            // Skip categories with '-ar' in slug (Arabic categories)
                            if (strpos($category->slug, '-ar') !== false) {
                                continue;
                            }
                            
                            // Skip the Blog parent category
                            if ($blog_category && $category->term_id == $blog_category->term_id) {
                                continue;
                            }
                            
                            $is_active = is_category($category->term_id);
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($category->term_id) . '#category-title'); ?>" 
                                   class="category-link <?php echo $is_active ? 'active' : ''; ?>"
                                   data-category-id="<?php echo $category->term_id; ?>">
                                    <span class="category-name"><?php echo $category->name; ?></span>
                                    <span class="category-count"><?php echo $category->count; ?></span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </aside>

            <main class="posts-container" id="posts-container">
                <?php if ( have_posts() ) : ?>
                    <div class="posts-grid" id="posts-grid">
                        <?php
                        while ( have_posts() ) : the_post();
                            get_template_part('includes/post-card', null, array('read_more_text' => 'Read More'));
                        endwhile;
                        ?>
                    </div>
                <?php else : ?>
                    <div class="no-posts">
                        <i class="fa-solid fa-file-circle-question"></i>
                        <h3>No posts found</h3>
                        <p>There are no posts in this category yet.</p>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</div>

<?php get_footer(); ?>
