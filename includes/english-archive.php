<?php get_header(); ?>



<div class="main">

    


    <div class="container blog">
        <div class="main-header row gx-5">
            <div class="main-header-content col-lg-7 col-md-12">
               <h1 class="main-header-title">Dag Law Firm Legal Consultations<br> Blog
                
               </h1>
                <p class="main-header-subtitle">Welcome to our blog where we share the latest news and insights Welcome to our blog where we share the latest news and insights Welcome to our blog where we share the latest news and insights Welcome to our blog where we share the latest news and insights.</p>
                <p class="main-header-subtitle">Welcome to our blog where we share the latest news and insights Welcome to our blog where we share the latest news and insights Welcome to our blog where we share the latest news and insights Welcome to our blog where we share the latest news and insights.</p>

                
           </div>
           <div class="main-header-image col-lg-5 col-md-12">
                <div class="image-container">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/write-2.jpg" alt="Blog Header Image" class="blog-header-img">
                </div>
               

            </div>
        </div>
        <div class="archive-header">
            <h1 class="category-title">
                <?php 
                if (is_category()) {
                    single_cat_title(); // Display current category name
                } elseif (is_tag()) {
                    single_tag_title(); // Display current tag name
                } elseif (is_archive()) {
                    post_type_archive_title(); // Display archive title
                }
                ?>
            </h1>
            <?php if ( category_description() ) : ?>
                <div class="archive-description">
                    <?php echo category_description(); ?>
                </div>
            <?php endif; ?>
        </div>
            
        <div class="blog-content">
            <aside class="blog-sidebar">
                <div class="sidebar-widget categories-widget">
                    <h3 class="widget-title">
                        <i class="fa-solid fa-folder-open"></i>
                        Categories
                    </h3>
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
                            <a href="<?php echo $blog_url; ?>" class="category-link <?php echo $is_blog_active ? 'active' : ''; ?>">
                                <span class="category-name">All Posts</span>
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
                                <a href="<?php echo get_category_link($category->term_id); ?>" class="category-link <?php echo $is_active ? 'active' : ''; ?>">
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

            <main class="posts-container">
                <?php if ( have_posts() ) : ?>
                    <div class="posts-grid">
                        <?php
                        while ( have_posts() ) : the_post();
                            ?>
                            <article class="post-card">
                                <?php if ( has_post_thumbnail() ) : ?>
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
                                            if ( ! empty( $categories ) ) {
                                                echo esc_html( $categories[0]->name );
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
                                        <?php 
                                        $excerpt = get_the_excerpt();
                                        $excerpt_length = 150;
                                        if (strlen($excerpt) > $excerpt_length) {
                                            $excerpt = substr($excerpt, 0, $excerpt_length);
                                            $excerpt = substr($excerpt, 0, strrpos($excerpt, ' ')) . '...';
                                        }
                                        echo $excerpt;
                                        ?>
                                    </div>
                                    
                                    <div class="post-footer">
                                        <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                            Read More
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                        <div class="post-meta-footer">
                                            <?php
                                            $categories = get_the_category();
                                            if ( ! empty( $categories ) ) {
                                                $category_count = count($categories);
                                                ?>
                                                <div class="post-categories">
                                                    <?php if ( $category_count == 1 ) : ?>
                                                        <!-- Single category - show as badge -->
                                                        <a href="<?php echo get_category_link($categories[0]->term_id); ?>" class="post-category-link">
                                                            <i class="fa-solid fa-folder"></i>
                                                            <?php echo esc_html( $categories[0]->name ); ?>
                                                        </a>
                                                    <?php else : ?>
                                                        <!-- Multiple categories - show dropdown only -->
                                                        <div class="categories-dropdown">
                                                            <button class="categories-dropdown-toggle" type="button">
                                                                <i class="fa-solid fa-folder"></i>
                                                                <span class="dropdown-text">Categories</span>
                                                                <i class="fa-solid fa-chevron-down"></i>
                                                            </button>
                                                            <div class="categories-dropdown-menu">
                                                                <?php foreach($categories as $category) : ?>
                                                                    <a href="<?php echo get_category_link($category->term_id); ?>" class="dropdown-category-link">
                                                                        <i class="fa-solid fa-folder"></i>
                                                                        <?php echo esc_html( $category->name ); ?>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php
                                            }
                                            
                                            $tags = get_the_tags();
                                            if ( ! empty( $tags ) ) {
                                                ?>
                                                <div class="post-tags">
                                                    <?php foreach($tags as $tag) : ?>
                                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="post-tag-link">
                                                            <i class="fa-solid fa-hashtag"></i>
                                                            <?php echo esc_html( $tag->name ); ?>
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
                            <?php
                        endwhile;
                        ?>
                    </div>
                    
                    <div class="pagination-wrapper">
                        <?php
                        $prev_link = get_previous_posts_link('<i class="fa-solid fa-chevron-left"></i>');
                        $next_link = get_next_posts_link('<i class="fa-solid fa-chevron-right"></i>');
                        
                        if ($prev_link || $next_link) :
                            ?>
                            <div class="pagination-simple">
                                <?php if ($prev_link) : ?>
                                    <div class="pagination-arrow pagination-prev">
                                        <?php echo $prev_link; ?>
                                    </div>
                                <?php else : ?>
                                    <div class="pagination-arrow pagination-prev disabled">
                                        <span><i class="fa-solid fa-chevron-left"></i></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($next_link) : ?>
                                    <div class="pagination-arrow pagination-next">
                                        <?php echo $next_link; ?>
                                    </div>
                                <?php else : ?>
                                    <div class="pagination-arrow pagination-next disabled">
                                        <span><i class="fa-solid fa-chevron-right"></i></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                        endif;
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
