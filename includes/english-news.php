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
                    get_template_part('includes/news-card', null, array(
                        'badge_text' => 'News',
                        'button_text' => 'Read More'
                    ));
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