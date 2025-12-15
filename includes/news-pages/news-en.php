<?php get_header(); ?>


<div class="news-hero"> 
    <div class="hero-content">
        <h4>Stay Tuned</h4>
        <h1>Latest <span>News</span> From DAG Law Firm </h1>
        <p class="lead">At DAG Law Firm, we keep you informed about the latest legal news and events in Saudi Arabia and beyond.
 Through this section, you can stay updated on new laws and regulations, professional activities, legal achievements, and insights</p>
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

<div class="news">
    <div class="header">
        <h2 id="news-title" class="news-title">Recent News<li class="fa-regular fa-newspaper ps-2"></li></h2>
        <p class="news-subtitle lead">Stay informed with the latest legal updates, analytical articles, and expert reports that help you understand recent regulatory changes in the Kingdom and make sound legal decisions with confidence.
</p>
    </div>
    
    <div id="news-container">
        <div class="news-grid">
            <?php
            // Use the main WordPress query for proper pagination
            global $wp_query;
            
            if (have_posts()) :
                while (have_posts()) : the_post();
                    get_template_part('includes/news-card', null, array(
                        'badge_text' => 'News',
                        'button_text' => 'Read More'
                    ));
                endwhile;
                ?>
        </div>
        
        <?php
        // Get current category for pagination
        $news_category = get_queried_object();
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        
        // Pagination
        get_template_part('includes/pagination', null, array(
            'paged' => $paged,
            'total_pages' => $wp_query->max_num_pages,
            'base_url' => get_category_link($news_category->term_id),
            'anchor_id' => '#news-title',
            'page_text' => 'Page %s of %s',
            'category_id' => $news_category->term_id,
            'parent_category_id' => 0
        ));
        else :
            ?>
        </div>
        <div class="no-news">
            <i class="fa-solid fa-newspaper"></i>
            <h3>No news posts found</h3>
            <p>There are no news articles available at the moment.</p>
        </div>
        <?php
        endif;
        ?>
    </div>
</div>
</section>










<?php get_footer(); ?>