<?php

    get_header('ar');     
?>

 <div class="hero">
        <div class="hero-background"></div>
        <div class="hero-content">
            <h1 class="hero-company" ><span>خدماتنا</span></h1>
            <h2 class="hero-title">حلول قانونية شاملة</h2>
            <p class="hero-subtitle">استكشف مجموعة خدماتنا القانونية المصممة لتلبية احتياجاتك.</p>
        </div>
    </div>


    <div class="container">
        <div class="row services   ">
            <div class="col-lg-12 text-center">
                
                <p class= "services-head lead ">في مكتب داغ للمحاماة والاستشارات، نقدم مجموعة واسعة من الخدمات القانونية المصممة لكل من العملاء الشركات والأفراد. فريقنا ذو الخبرة ملتزم بتقديم حلول قانونية دقيقة وفعالة.</p>
            </div>
            <div class="companies col-lg-6 col-md-12">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/companies.png" alt="Corporate Law">
                <h2 class="text-center">القانون التجاري</h2>
                <p>تشمل خدماتنا في القانون التجاري تأسيس الشركات، الاندماجات والاستحواذات، الامتثال، وحوكمة الشركات. نساعد الشركات على التنقل في البيئات القانونية المعقدة لضمان سير العمليات بسلاسة.</p>
                <?php
                // Get companies-services category using Polylang
                $companies_en_category = get_category_by_slug('companies-services');
                if (!$companies_en_category) {
                    $companies_en_category = get_term_by('name', 'Companies Services', 'category');
                }
                
                $companies_ar_category = null;
                if ($companies_en_category && function_exists('pll_get_term')) {
                    $companies_ar_id = pll_get_term($companies_en_category->term_id, 'ar');
                    if ($companies_ar_id) {
                        $companies_ar_category = get_category($companies_ar_id);
                    }
                }
                
                // Fallback: try to get by Arabic name if Polylang translation not found
                if (!$companies_ar_category) {
                    $companies_ar_category = get_term_by('name', 'خدمات الشركات', 'category');
                }
                
                $companies_ar_url = $companies_ar_category ? get_category_link($companies_ar_category->term_id) : '#';
                ?>
                <a href="<?php echo esc_url($companies_ar_url); ?>" class="btn service-btn">اقرأ المزيد</a>

            </div>
            <div class="individuals col-lg-6 col-md-12">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/individuals.webp" alt="Individual Law">
                <h2 class="text-center">القانون الفردي</h2>
                <p>تشمل خدماتنا في القانون الفردي قانون الأسرة، تخطيط العقارات، الإصابات الشخصية، والدفاع الجنائي. نحن نقدم دعمًا قانونيًا مخصصًا لمساعدة الأفراد على التنقل في تحدياتهم القانونية الفريدة.</p>
                <?php
                // Get individual-services category using Polylang
                $individual_en_category = get_category_by_slug('individual-services');
                if (!$individual_en_category) {
                    $individual_en_category = get_term_by('name', 'Individual Services', 'category');
                }
                
                $individual_ar_category = null;
                if ($individual_en_category && function_exists('pll_get_term')) {
                    $individual_ar_id = pll_get_term($individual_en_category->term_id, 'ar');
                    if ($individual_ar_id) {
                        $individual_ar_category = get_category($individual_ar_id);
                    }
                }
                
                // Fallback: try to get by Arabic name if Polylang translation not found
                if (!$individual_ar_category) {
                    $individual_ar_category = get_term_by('name', 'خدمات الأفراد', 'category');
                }
                
                $individual_ar_url = $individual_ar_category ? get_category_link($individual_ar_category->term_id) : '#';
                ?>
                <a href="<?php echo esc_url($individual_ar_url); ?>" class="btn service-btn">اقرأ المزيد</a>

            </div>
        </div>            

        </div>
    </div>










<?php get_footer('ar'); ?>
