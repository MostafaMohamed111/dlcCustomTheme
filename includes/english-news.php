<?php get_header(); ?>


<div class="news-hero"> 
    <div class="hero-content">
        <h4>latest News</h4>
        <h1>Dag's <span>News</span></h1>
        <p class="lead">Stay updated with the latest news and articles from Dag Law Firm & Consultation.</p>
    </div>
    <div class="row hero-pics">
        <div class="first-pic col-lg-4">

        </div>
        <div class="second-pic col-lg-4">

        </div>
        <div class="third-pic col-lg-4">
            
        </div>

    </div>
    
</div>

<section>

<div class="news ">
    <div class="header">
        <h2 class="news-title">Recent News<li class="fa-regular fa-newspaper ps-2"></li></h2>
        <p class="news-subtitle lead">Explore our latest insights and updates on legal matters.</p>
    </div>
        
    <div class="news-grid">
        <?php
        // Get the 'news' category
        $news_category = get_category_by_slug('news');
        
        if ($news_category) {
            // Query posts from the news category
            $news_query = new WP_Query(array(
                'category_name' => 'news',
                'posts_per_page' => -1, // Get all news posts
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($news_query->have_posts()) :
                while ($news_query->have_posts()) : $news_query->the_post();
                    ?>
                    <article class="news-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="news-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail(
                                        'large',
                                        array(
                                            'class' => 'news-image',
                                            'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw'
                                        )
                                    ); ?>
                                </a>
                                <div class="news-category-badge">
                                    News
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="news-content">
                            <div class="news-meta">
                                <span class="news-date">
                                    <i class="fa-solid fa-calendar"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                                <span class="news-author">
                                    <i class="fa-solid fa-user"></i>
                                    <?php the_author(); ?>
                                </span>
                            </div>
                            
                            <h3 class="news-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="news-excerpt">
                                <?php
                                $excerpt = get_the_excerpt();
                                $excerpt_length = 120;
                                if (strlen($excerpt) > $excerpt_length) {
                                    $excerpt = substr($excerpt, 0, $excerpt_length);
                                    $excerpt = substr($excerpt, 0, strrpos($excerpt, ' ')) . '...';
                                }
                                echo $excerpt;
                                ?>
                            </div>
                            
                            <div class="news-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more-news-btn">
                                    Read More
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <div class="no-news">
                    <i class="fa-solid fa-newspaper"></i>
                    <h3>No news posts found</h3>
                    <p>There are no news articles available at the moment.</p>
                </div>
                <?php
            endif;
        } else {
            ?>
            <div class="no-news">
                <i class="fa-solid fa-newspaper"></i>
                <h3>News category not found</h3>
                <p>The news category does not exist. Please create a category with the slug "news".</p>
            </div>
            <?php
        }
        ?>
    </div>
</div>
</section>










<?php get_footer(); ?>