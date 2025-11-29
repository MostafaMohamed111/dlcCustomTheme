<?php get_header('ar'); ?>


<div class="news-hero"> 
    <div class="hero-content">
        <h4>آخر الأخبار</h4>
        <h1>أخبار <span>داج</span></h1>
        <p class="lead">ابقَ على اطلاع بآخر الأخبار والمقالات من مكتب داج للمحاماة والاستشارات.</p>
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
        <h2 id="news-title" class="news-title">اخر الأخبار<li class="fa-regular fa-newspaper ps-2"></li></h2>
        <p class="news-subtitle lead">اكتشف أحدث رؤانا وتحديثاتنا في الشؤون القانونية.</p>
    </div>
        
    <div class="news-grid">
        <?php
        // Get the 'news-ar' category (Arabic news)
        $news_category = get_category_by_slug('news-ar');
        
        if ($news_category) {
            // Setup pagination
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            
            // Query posts from the news-ar category, filtered by Arabic language
            $news_query = new WP_Query(array(
                'category_name' => 'news-ar',
                'posts_per_page' => 6, // 6 posts per page
                'paged' => $paged,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'meta_query' => array(
                    array(
                        'key' => '_post_language',
                        'value' => 'ar',
                        'compare' => '='
                    )
                )
            ));
            
            if ($news_query->have_posts()) :
                while ($news_query->have_posts()) : $news_query->the_post();
                    get_template_part('includes/news-card', null, array(
                        'badge_text' => 'أخبار',
                        'button_text' => 'اقرأ المزيد'
                    ));
                endwhile;
                wp_reset_postdata();
                ?>
                </div>
                
                <?php
                // Pagination
                get_template_part('includes/pagination', null, array(
                    'paged' => $paged,
                    'total_pages' => $news_query->max_num_pages,
                    'base_url' => get_category_link($news_category->term_id),
                    'anchor_id' => '#news-title',
                    'page_text' => 'صفحة %s من %s'
                ));
            else :
                ?>
                </div>
                <div class="no-news">
                    <i class="fa-solid fa-newspaper"></i>
                    <h3>لا توجد مقالات إخبارية</h3>
                    <p>لا توجد مقالات إخبارية متاحة في الوقت الحالي.</p>
                </div>
                <?php
            endif;
        } else {
            ?>
            </div>
            <div class="no-news">
                <i class="fa-solid fa-newspaper"></i>
                <h3>فئة الأخبار غير موجودة</h3>
                <p>فئة الأخبار غير موجودة. يرجى إنشاء فئة بالاسم "news-ar".</p>
            </div>
            <?php
        }
        ?>
</div>
</section>









<?php get_footer('ar'); ?>