<?php get_header('ar'); ?>

<div class="hero">
    <div class="layout">

    </div>
    <div class="content">
        <h4>افضل <span>اختيار</span></h4>
        <h1>خدماتنا القانونية<span> للشركات</span>  
</h1>
        <p class="lead">تقدّم شركة داغ للمحاماة والاستشارات القانونية حلولًا متكاملة لدعم المنشآت التجارية في جميع مراحلها — من التأسيس إلى التوسع، ومن التنظيم الداخلي إلى إدارة المخاطر القانونية</p>
    </div>
</div>


<div class="page-content">
    <div class="services-landing companies-services-page">
        <div class="header">
            <h2 id="services-title" class="services-title">خدمات الشركات<li class="fa-solid fa-building ps-2"></li></h2>
            <?php
            // Get current language using Polylang
            $current_lang = 'ar';
            if (function_exists('pll_current_language')) {
                $current_lang = pll_current_language();
            }
            
            // Get the companies-services category for default description
            $display_category = null;
            if (isset($_GET['cat']) && $_GET['cat'] > 0) {
                // Show selected category description
                $display_category = get_category(intval($_GET['cat']));
            } else {
                // Get parent category using Polylang
                $companies_en = get_category_by_slug('companies-services');
                if (!$companies_en) {
                    $companies_en = get_term_by('name', 'Companies Services', 'category');
                }
                
                if ($companies_en && function_exists('pll_get_term')) {
                    $companies_ar_id = pll_get_term($companies_en->term_id, 'ar');
                    if ($companies_ar_id) {
                        $display_category = get_category($companies_ar_id);
                    }
                }
                
                // Fallback
                if (!$display_category) {
                    $display_category = $companies_en;
                }
            }
            
            if ($display_category && !empty($display_category->description)) {
                echo '<div class="archive-description services-subtitle lead">' . wpautop($display_category->description) . '</div>';
            } else {
                // Fallback if no description is set
                echo '<p class="services-subtitle lead">استكشف خدماتنا القانونية المتخصصة المصممة للشركات والعملاء المؤسسيين.</p>';
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
            
            // Get the companies-services category using Polylang
            $parent_category = null;
            if (function_exists('pll_get_term')) {
                $companies_en = get_category_by_slug('companies-services');
                if (!$companies_en) {
                    $companies_en = get_term_by('name', 'Companies Services', 'category');
                }
                
                if ($companies_en) {
                    if ($current_lang === 'ar') {
                        $companies_ar_id = pll_get_term($companies_en->term_id, 'ar');
                        if ($companies_ar_id) {
                            $parent_category = get_category($companies_ar_id);
                        }
                    } else {
                        $parent_category = $companies_en;
                    }
                }
            }
            
            // Fallback: try to get by slug/name if Polylang translation not found
            if (!$parent_category) {
                if ($current_lang === 'ar') {
                    $parent_category = get_category_by_slug('companies-services-ar');
                    if (!$parent_category) {
                        $parent_category = get_term_by('name', 'خدمات الشركات', 'category');
                    }
                } else {
                    $parent_category = get_category_by_slug('companies-services');
                    if (!$parent_category) {
                        $parent_category = get_term_by('name', 'Companies Services', 'category');
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
                    // Parent category archive → treat as "All Company Services"
                    if ($queried_category->term_id == $parent_category->term_id) {
                        $current_category = 0;
                    } elseif ($queried_category->parent == $parent_category->term_id) {
                        // Direct child of parent → specific sub-category
                        $current_category = $queried_category->term_id;
                    }
                } else {
                    $current_category = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
                }
                
                // Get all category IDs for companies-services-ar and its children (for "All Services" count)
                $all_category_ids = array($parent_category->term_id);
                $all_children = get_term_children($parent_category->term_id, 'category');
                if (!is_wp_error($all_children)) {
                    $all_category_ids = array_merge($all_category_ids, $all_children);
                }
                
                // Get current page number for pagination
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                
                // Setup query arguments with pagination enabled
                $query_args = array(
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' => DLC_POSTS_PER_PAGE,
                    'paged'          => $paged,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
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
                    // Get all posts from companies-services-ar and its children
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
                            // Default label represents the parent companies services group
                            $current_category_name = 'خدمات الشركات';
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
                                    // Get post count for all company services (parent + children, filtered by language)
                                    $all_services_query_args = array(
                                        'category__in'   => $all_category_ids,
                                        'posts_per_page' => -1,
                                        'post_status'    => 'publish',
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
                                        <span class="category-name">خدمات الشركات</span>
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
                            get_template_part('includes/service-card', null, array('button_text' => 'اقرأ المزيد'));
                        endwhile;
                            ?>
                            </div>
                            
                            <?php
                            // Add pagination
                            $total_pages = $services_query->max_num_pages;
                            if ($total_pages > 1) :
                                // Build base URL for pagination
                                $base_url = '';
                                if ($current_category > 0) {
                                    $base_url = get_category_link($current_category);
                                } else {
                                    $base_url = get_category_link($parent_category->term_id);
                                }
                                
                                get_template_part('includes/pagination', null, array(
                                    'paged' => $paged,
                                    'total_pages' => $total_pages,
                                    'base_url' => trailingslashit($base_url),
                                    'anchor_id' => '#services-title',
                                    'page_text' => 'صفحة %s من %s',
                                    'category_id' => $current_category,
                                    'parent_category_id' => $parent_category->term_id
                                ));
                            endif;
                            
                            wp_reset_postdata();
                            ?>
                        <?php
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
                    <p>فئة خدمات الشركات غير موجودة. يرجى إنشاء فئة خدمات الشركات.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="faq-container">
            <h2 class="faq-title"> الأسئلة الشائعة – خدمات الشركات</h2>
            <p class="faq-subtitle">اطّلع على إجابات الأسئلة الشائعة حول خدماتنا القانونية للشركات</p>
            
            <ul class="faq-list">
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">هل تقدم شركة داغ خدمات تأسيس الشركات الأجنبية داخل السعودية؟</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">نعم، نقدم خدمات تأسيس الشركات الأجنبية وإصدار التراخيص بالتنسيق مع الجهات المختصة.</p>
                    </div>
                </li>
                
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">هل تشمل خدماتكم صياغة العقود التجارية الدولية؟</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">نعم، يمكننا صياغة العقود وفق القوانين المحلية أو الاتفاقيات الدولية حسب النشاط التجاري.</p>
                    </div>
                </li>
                
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">كيف تساعد الشركة في تقليل المخاطر القانونية؟</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">من خلال مراجعة الأنظمة الداخلية والعقود وتقديم تقارير امتثال دورية.</p>
                    </div>
                </li>
                
                <li class="faq-item">
                    <div class="faq-question" role="button" aria-expanded="false">
                        <span class="faq-question-text">هل يمكن تمثيل الشركة في قضايا التحكيم التجاري؟</span>
                        <span class="faq-question-icon">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <p class="faq-answer-text">نعم، لدينا محامون مختصون بالتحكيم وذوو خبرة في تمثيل الشركات محليًا ودوليًا.</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

<!-- Book Consultation Section -->
<section class="consultation-cta-section">
    <div class="container">
        <div class="consultation-cta-wrapper">
            <div class="consultation-cta-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <h2 class="consultation-cta-title">احجز استشارتك القانونية</h2>
            <p class="consultation-cta-description">
                تتيح شركة داغ للمحاماة والاستشارات القانونية حجز الاستشارات القانونية عبر قنوات متعددة، وذلك لتقديم الدعم النظامي في الوقت المناسب وبما يتوافق مع طبيعة كل حالة.
            </p>
            <a href="<?php echo esc_url(dlc_get_booking_page_url('ar')); ?>" class="consultation-cta-button">
                <span>طلب استشارة قانونية</span>
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>

</div>










<?php get_footer('ar'); ?>