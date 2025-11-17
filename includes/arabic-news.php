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
        <h2 class="news-title">اخر الأخبار<li class="fa-regular fa-newspaper ps-2"></li></h2>
        <p class="news-subtitle lead">اكتشف أحدث رؤانا وتحديثاتنا في الشؤون القانونية.</p>
    </div>
        
    <div class="news-grid">
        <?php
        // Get the 'news-ar' category (Arabic news)
        $news_category = get_category_by_slug('news-ar');
        
        if ($news_category) {
            // Query posts from the news-ar category, filtered by Arabic language
            $news_query = new WP_Query(array(
                'category_name' => 'news-ar',
                'posts_per_page' => -1, // Get all news posts
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
                                    أخبار
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
                                    اقرأ المزيد
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
                    <h3>لا توجد مقالات إخبارية</h3>
                    <p>لا توجد مقالات إخبارية متاحة في الوقت الحالي.</p>
                </div>
                <?php
            endif;
        } else {
            ?>
            <div class="no-news">
                <i class="fa-solid fa-newspaper"></i>
                <h3>فئة الأخبار غير موجودة</h3>
                <p>فئة الأخبار غير موجودة. يرجى إنشاء فئة بالاسم "news-ar".</p>
            </div>
            <?php
        }
        ?>
    </div>
</div>
</section>









<?php get_footer('ar'); ?>