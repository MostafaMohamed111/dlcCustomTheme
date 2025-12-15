<?php get_header('ar'); ?>


<div class="news-hero"> 
    <div class="hero-content">
        <h4>ابقَ على اطلاع</h4>
        <h1>آخر <span>الأخبار</span>  من شركة داغ للمحاماة</h1>
        <p class="lead">نشارككم في شركة داغ للمحاماة والاستشارات القانونية أحدث الأخبار والفعاليات القانونية في المملكة العربية السعودية وخارجها.
 من خلال هذا القسم، يمكنكم متابعة المستجدات المتعلقة بالقوانين والتشريعات الجديدة، والاطلاع على مشاركاتنا المهنية، وإنجازاتنا القانونية</p>
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
        <h2 id="news-title" class="news-title">اخر الأخبار<li class="fa-regular fa-newspaper ps-2"></li></h2>
        <p class="news-subtitle lead">ابقوا على اطلاع دائم على آخر المستجدات القانونية، والمقالات والتقارير التحليلية التي تساعدكم على فهم التطورات النظامية في المملكة، وتعزز قدرتكم على اتخاذ القرارات القانونية السليمة.
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
                        'badge_text' => 'أخبار',
                        'button_text' => 'اقرأ المزيد'
                    ));
                endwhile;
                ?>
        </div>
        
        <?php
        // Get current category for pagination
        $news_category = get_queried_object();
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        
        get_template_part('includes/pagination', null, array(
            'paged' => $paged,
            'total_pages' => $wp_query->max_num_pages,
            'base_url' => get_category_link($news_category->term_id),
            'anchor_id' => '#news-title',
            'page_text' => 'صفحة %s من %s',
            'category_id' => $news_category->term_id,
            'parent_category_id' => 0
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
        ?>
    </div>
</div>
</section>









<?php get_footer('ar'); ?>