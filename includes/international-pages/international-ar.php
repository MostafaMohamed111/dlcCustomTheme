<?php get_header('ar'); 
?>


<div class="hero-international">
    <div class="hero-content-international">
        <h1 class="hero-company-international">شركة داج للمحاماة والاستشارات القانونية</h1>
        <h2 class="hero-title-international">شريكك القانوني الموثوق <br><span>للأعمال</span> عالمياً</h2>
        <p class="hero-subtitle-international lead">حلول قانونية متخصصة تلبي احتياجاتك.
        </p>

        <div class="actions-international">
            <a href="<?php echo home_url('/booking/'); ?>" class="btn hero-btn-international get-appointment-international">احجز موعد</a>
            <a href="<?php echo home_url('/contact-us-ar/'); ?>" class="btn hero-btn-international contact-us-international" >اتصل بنا</a>
        </div>

    </div>


</div>


<div class="page-content">
    <div class="services-landing companies-services-page">
        <div class="header">
            <h2 class="services-title">الخدمات الدولية<li class="fa-solid fa-globe ps-2"></li></h2>
            <?php
            // Get current language using Polylang
            $current_lang = 'ar';
            if (function_exists('pll_current_language')) {
                $current_lang = pll_current_language();
            }
            
            // Get the home-international category for default description
            $display_category = null;
            if (isset($_GET['cat']) && $_GET['cat'] > 0) {
                // Show selected category description
                $display_category = get_category(intval($_GET['cat']));
            } else {
                // Get parent category using Polylang
                $international_en = get_category_by_slug('home-international');
                if (!$international_en) {
                    $international_en = get_term_by('name', 'Home International', 'category');
                }
                
                if ($international_en && function_exists('pll_get_term')) {
                    $international_ar_id = pll_get_term($international_en->term_id, 'ar');
                    if ($international_ar_id) {
                        $display_category = get_category($international_ar_id);
                    }
                }
                
                // Fallback
                if (!$display_category) {
                    $display_category = $international_en;
                }
            }
            
            if ($display_category && !empty($display_category->description)) {
                echo '<div class="archive-description services-subtitle lead">' . wpautop($display_category->description) . '</div>';
            } else {
                // Fallback if no description is set
                echo '<p class="services-subtitle lead">اكتشف خدماتنا القانونية الحصرية المصممة للعملاء الدوليين. نحن نقدم حلولاً خبيرة لمساعدة الشركات على التنقل في اللوائح السعودية بثقة وسهولة.</p>';
            }
            ?>
        </div>

        <div class="container">
            <?php
            // Get current language using Polylang
            $current_lang = 'ar';
            if (function_exists('pll_current_language')) {
                $current_lang = pll_current_language();
            }
            
            // Get the home-international category using Polylang
            $parent_category = null;
            if (function_exists('pll_get_term')) {
                $international_en = get_category_by_slug('home-international');
                if (!$international_en) {
                    $international_en = get_term_by('name', 'Home International', 'category');
                }
                
                if ($international_en) {
                    if ($current_lang === 'ar') {
                        $international_ar_id = pll_get_term($international_en->term_id, 'ar');
                        if ($international_ar_id) {
                            $parent_category = get_category($international_ar_id);
                        }
                    } else {
                        $parent_category = $international_en;
                    }
                }
            }
            
            // Fallback: try to get by slug/name if Polylang translation not found
            if (!$parent_category) {
                if ($current_lang === 'ar') {
            $parent_category = get_category_by_slug('home-international-ar');
                    if (!$parent_category) {
                        $parent_category = get_term_by('name', 'الخدمات الدولية', 'category');
                    }
                } else {
                    $parent_category = get_category_by_slug('home-international');
                    if (!$parent_category) {
                        $parent_category = get_term_by('name', 'Home International', 'category');
                    }
                }
            }
            
            if ($parent_category) {
                // Get all child categories
                $all_child_categories = get_categories(array(
                    'parent' => $parent_category->term_id,
                    'hide_empty' => true,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ));
                
                // Filter child categories by current language using Polylang
                $child_categories = array();
                foreach ($all_child_categories as $cat) {
                    if (function_exists('pll_get_term_language')) {
                        $cat_lang = pll_get_term_language($cat->term_id);
                        if ($cat_lang === $current_lang) {
                            $child_categories[] = $cat;
                        }
                    } else {
                        // Fallback: include all if Polylang not available
                        $child_categories[] = $cat;
                    }
                }
                
            // Get current category filter from URL or queried object
            $current_category = 0;
            if (is_category()) {
                $queried_category = get_queried_object();
                // Check if this is a child of the parent category
                if ($queried_category->parent == $parent_category->term_id || $queried_category->term_id == $parent_category->term_id) {
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
                
                // Setup query arguments
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $posts_per_page = 6; // 3 columns × 2 rows
                
                $query_args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => $posts_per_page,
                    'paged' => $paged,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                
                // Add Polylang language filter if available
                if (function_exists('pll_current_language')) {
                    $query_args['lang'] = $current_lang;
                }
                
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
                                    // Get post count for "All Services" (all posts in home-international and children, filtered by language)
                                    $all_services_query_args = array(
                                        'category__in' => $all_category_ids,
                                        'posts_per_page' => -1,
                                        'post_status' => 'publish'
                                    );
                                    
                                    // Add Polylang language filter if available
                                    if (function_exists('pll_current_language')) {
                                        $all_services_query_args['lang'] = $current_lang;
                                    }
                                    
                                    $all_services_query = new WP_Query($all_services_query_args);
                                    $all_services_count = $all_services_query->found_posts;
                                    wp_reset_postdata();
                                    ?>
                                    <a href="<?php echo esc_url(get_category_link($parent_category->term_id) . '#services-title'); ?>" 
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
                                'button_text' => 'اقرأ المزيد',
                                'excerpt_length' => 120
                            ));
                            endwhile;
                            wp_reset_postdata();
                            ?>
                            </div>
                            
                            <?php
                            // Pagination
                            $base_url = $current_category > 0 
                            ? get_category_link($current_category)
                                : get_category_link($parent_category->term_id);
                            
                            get_template_part('includes/pagination', null, array(
                                'paged' => $paged,
                                'total_pages' => $services_query->max_num_pages,
                                'base_url' => $base_url,
                                'anchor_id' => '#services-title',
                                'page_text' => 'صفحة %s من %s'
                            ));
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
                    <p>فئة الخدمات الدولية غير موجودة. يرجى إنشاء فئة الخدمات الدولية.</p>
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
    
        <div class="why-choose-us-header">
            <h2 class="why-choose-us-title">لماذا تختارنا</h2>
            <p class="why-choose-us-intro">
                نجمع بين الخبرة القانونية العميقة والالتزام بالتميز، مما يضمن أن عملك يتلقى خدمات قانونية عالية الجودة مصممة خصيصاً لاحتياجاتك وأهدافك الفريدة.
            </p>
        </div>
        <div class="container">
        
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

</div>



<?php get_footer('ar'); ?>