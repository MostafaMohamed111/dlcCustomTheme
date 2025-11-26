<?php get_header('ar'); 
?>


<div class="hero-international">
    <div class="hero-content-international">
        <h1 class="hero-company-international">شركة داج للمحاماة والاستشارات القانونية</h1>
        <h2 class="hero-title-international">شريكك القانوني الموثوق <br><span>للأعمال</span> عالمياً</h2>
        <p class="hero-subtitle-international lead">حلول قانونية متخصصة تلبي احتياجاتك.
        </p>

        <div class="actions-international">
            <button class="btn hero-btn-international get-appointment-international">احجز موعد</button>
            <button class="btn hero-btn-international contact-us-international" >اتصل بنا</button>
        </div>

    </div>


</div>



<div class="services-landing companies-services-page">
    <div class="header">
        <h2 class="services-title">الخدمات الدولية<li class="fa-solid fa-globe ps-2"></li></h2>
        <p class="services-subtitle lead">اكتشف خدماتنا القانونية الحصرية المصممة للعملاء الدوليين. نحن نقدم حلولاً خبيرة لمساعدة الشركات على التنقل في اللوائح السعودية بثقة وسهولة.</p>
    </div>

    <div class="container">
        <?php
        // Get the home-international-ar category
        $parent_category = get_category_by_slug('home-international-ar');
        
        if ($parent_category) {
            // Get all child categories
            $child_categories = get_categories(array(
                'parent' => $parent_category->term_id,
                'hide_empty' => true,
                'orderby' => 'name',
                'order' => 'ASC'
            ));
            
            // Get current category filter from URL
            $current_category = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
            
            // Get all category IDs for home-international-ar and its children (for "All Services" count)
            $all_category_ids = array($parent_category->term_id);
            $all_children = get_term_children($parent_category->term_id, 'category');
            if (!is_wp_error($all_children)) {
                $all_category_ids = array_merge($all_category_ids, $all_children);
            }
            
            // Setup query arguments
            $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
            $posts_per_page = 6; // 3 columns × 2 rows
            
            $query_args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
                'meta_query' => array(
                    array(
                        'key' => '_post_language',
                        'value' => 'ar',
                        'compare' => '='
                    )
                )
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
                // Get all posts from home-international-ar and its children
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
                        $current_category_name = 'جميع الخدمات';
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
                                // Get post count for "All Services" (all Arabic posts in home-international-ar and children)
                                $all_services_query = new WP_Query(array(
                                    'category__in' => $all_category_ids,
                                    'posts_per_page' => -1,
                                    'post_status' => 'publish',
                                    'meta_query' => array(
                                        array(
                                            'key' => '_post_language',
                                            'value' => 'ar',
                                            'compare' => '='
                                        )
                                    )
                                ));
                                $all_services_count = $all_services_query->found_posts;
                                wp_reset_postdata();
                                ?>
                                <a href="<?php echo get_category_link($parent_category->term_id); ?>" 
                                   class="category-link <?php echo $current_category == 0 ? 'active' : ''; ?>"
                                   data-category-id="0"
                                   data-parent-category-id="<?php echo $parent_category->term_id; ?>">
                                    <span class="category-name">جميع الخدمات</span>
                                    <span class="category-count"><?php echo $all_services_count; ?></span>
                                </a>
                            </li>
                            <?php foreach ($child_categories as $child_cat) : 
                                $is_active = ($current_category == $child_cat->term_id);
                                ?>
                                <li>
                                    <a href="<?php echo add_query_arg('cat', $child_cat->term_id, get_category_link($parent_category->term_id)); ?>" 
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
                        ?>
                        <article class="service-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="service-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail(
                                            'large',
                                            array(
                                                'class' => 'service-image',
                                                'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 33vw, 400px'
                                            )
                                        ); ?>
                                    </a>
                                    <div class="service-category-badge">
                                        <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            echo esc_html($categories[0]->name);
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="service-content">
                                <h3 class="service-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="service-excerpt">
                                    <?php
                                    $excerpt = get_the_excerpt();
                                    $excerpt_length = 120;
                                    if (strlen($excerpt) > $excerpt_length) {
                                        $excerpt = substr($excerpt, 0, $excerpt_length);
                                        $excerpt = substr($excerpt, 0, strrpos($excerpt, ' ')) . '...';
                                    }
                                    echo esc_html($excerpt);
                                    ?>
                                </div>
                                
                                <div class="service-footer">
                                    <a href="<?php the_permalink(); ?>" class="get-started-service-btn">
                                        اقرأ المزيد
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                        </div>
                        
                        <?php
                        // Pagination
                        $total_pages = $services_query->max_num_pages;
                        if ($total_pages > 1) :
                            ?>
                            <div class="pagination-wrapper">
                                <?php
                                // Get pagination links
                                $base_url = $current_category > 0 
                                    ? add_query_arg('cat', $current_category, get_category_link($parent_category->term_id))
                                    : get_category_link($parent_category->term_id);
                                
                                $prev_page = ($paged > 1) ? $paged - 1 : 0;
                                $next_page = ($paged < $total_pages) ? $paged + 1 : 0;
                                ?>
                                <div class="pagination-simple">
                                    <?php if ($prev_page > 0) : ?>
                                        <div class="pagination-arrow pagination-prev">
                                            <a href="<?php echo esc_url(add_query_arg('paged', $prev_page, $base_url)); ?>">
                                                <i class="fa-solid fa-chevron-left"></i>
                                            </a>
                                        </div>
                                    <?php else : ?>
                                        <div class="pagination-arrow pagination-prev disabled">
                                            <span><i class="fa-solid fa-chevron-left"></i></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($next_page > 0) : ?>
                                        <div class="pagination-arrow pagination-next">
                                            <a href="<?php echo esc_url(add_query_arg('paged', $next_page, $base_url)); ?>">
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </a>
                                        </div>
                                    <?php else : ?>
                                        <div class="pagination-arrow pagination-next disabled">
                                            <span><i class="fa-solid fa-chevron-right"></i></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                        endif;
                    else :
                        ?>
                        <div class="no-services">
                            <i class="fa-solid fa-briefcase"></i>
                            <h3>لا توجد خدمات</h3>
                            <p>لا توجد خدمات متاحة في هذه الفئة في الوقت الحالي.</p>
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
                <h3>الفئة غير موجودة</h3>
                <p>فئة الخدمات الدولية غير موجودة. يرجى إنشاء فئة بالاسم "home-international-ar".</p>
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
        <h2 class="achievements-title">الإنجازات</h2>
        <p class="achievements-intro">
            منذ تأسيس مكتب داغ للمحاماة، كان تقديم المشورة القانونية ورضا العملاء وتلبية احتياجاتهم بوصلة لنا وهدفنا الدائم. من خلال عملنا، سررنا بأن نكون شركاء ناجحين لمجموعة من المؤسسات والمنظمات المرموقة، وتعبيرهم عن رضاهم بهذه الشراكة المتميزة هو ما نملكه.
        </p>
        
        <div class="achievements-grid">
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($cases_count); ?>"><?php echo esc_html($cases_count); ?></div>
                <div class="achievement-label">القضايا</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($contracts_count); ?>"><?php echo esc_html($contracts_count); ?></div>
                <div class="achievement-label">العقود</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($clients_count); ?>"><?php echo esc_html($clients_count); ?></div>
                <div class="achievement-label">العملاء</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($intellectual_properties_count); ?>"><?php echo esc_html($intellectual_properties_count); ?></div>
                <div class="achievement-label">الملكية الفكرية</div>
            </div>
        </div>
        
        <p class="achievements-conclusion">
            نحن فخورون بما أنجزناه منذ بداية رحلتنا.
        </p>
    </div>
</section>
















<section class="why-choose-us">
    <div class="container">
        <h2 class="why-choose-us-title">لماذا تختارنا</h2>
        <p class="why-choose-us-intro">
            نجمع بين الخبرة القانونية العميقة والالتزام بالتميز، مما يضمن أن عملك يتلقى خدمات قانونية عالية الجودة مصممة خصيصاً لاحتياجاتك وأهدافك الفريدة.
        </p>
        
        <div class="why-choose-us-grid">
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-gavel"></i>
                </div>
                <h3 class="why-choose-us-card-title">فريق قانوني خبير</h3>
                <p class="why-choose-us-card-description">
                    محامونا ذوو الخبرة متخصصون في القانون السعودي واللوائح التجارية الدولية، مما يوفر لك إرشاداً قانونياً شاملاً.
                </p>
            </div>
            
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <h3 class="why-choose-us-card-title">شراكة موثوقة</h3>
                <p class="why-choose-us-card-description">
                    نبني علاقات طويلة الأمد مع عملائنا، نفهم احتياجات أعمالهم ونقدم حلولاً قانونية مخصصة.
                </p>
            </div>
            
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <h3 class="why-choose-us-card-title">خبرة دولية</h3>
                <p class="why-choose-us-card-description">
                    مع معرفة عميقة بالإطارات القانونية المحلية والدولية، نساعد الشركات على التنقل في اللوائح المعقدة عبر الحدود.
                </p>
            </div>
            
            <div class="why-choose-us-card">
                <div class="why-choose-us-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h3 class="why-choose-us-card-title">حلول في الوقت المناسب</h3>
                <p class="why-choose-us-card-description">
                    نفهم أهمية الوقت في الأعمال. يقدم فريقنا خدمات قانونية فعالة وسريعة الاستجابة عندما تحتاجها أكثر.
                </p>
            </div>
        </div>
    </div>
</section>


<?php get_footer('ar'); ?>