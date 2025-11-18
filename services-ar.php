<?php
/* 

Template Name: Services Arabic
*/
    get_header('ar');     
?>

 <div class="hero">
        <div class="hero-background"></div>
        <div class="hero-content">
            <h1 class="hero-company">خدماتنا</h1>
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
                $companies_ar_category = get_category_by_slug('companies-services-ar');
                $companies_ar_url = $companies_ar_category ? get_category_link($companies_ar_category->term_id) : '#';
                ?>
                <a href="<?php echo $companies_ar_url; ?>" class="btn service-btn">ابدأ الآن</a>

            </div>
            <div class="individuals col-lg-6 col-md-12">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/individuals.webp" alt="Individual Law">
                <h2 class="text-center">القانون الفردي</h2>
                <p>تشمل خدماتنا في القانون الفردي قانون الأسرة، تخطيط العقارات، الإصابات الشخصية، والدفاع الجنائي. نحن نقدم دعمًا قانونيًا مخصصًا لمساعدة الأفراد على التنقل في تحدياتهم القانونية الفريدة.</p>
                <?php
                $individual_ar_category = get_category_by_slug('individual-services-ar');
                $individual_ar_url = $individual_ar_category ? get_category_link($individual_ar_category->term_id) : '#';
                ?>
                <a href="<?php echo $individual_ar_url; ?>" class="btn service-btn">ابدأ الآن</a>

            </div>
        </div>            

        </div>
    </div>










<?php get_footer('ar'); ?>
