<?php
get_header('ar');

// Get statistics with ACF or fallback to defaults
$cases_count = 0;
$contracts_count = 0;
$clients_count = 0;

if (function_exists('get_field')) {
    $cases_count = (int) get_field('cases');
    $contracts_count = (int) get_field('contracts');
    $clients_count = (int) get_field('clients');
}
?>
<main>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-background" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/Dag-team.webp');"></div>
        <div class="hero-content">
            <h1 class="hero-company"> شركة داغ للمحاماة والاستشارات القانونية بالرياض</h1>
            <h2 class="hero-title"></h2>
            <p class="hero-subtitle"> منصة قانونية رقمية تقدّم حلولًا دقيقة واحترافية للأفراد والشركات في المملكة العربية السعودية.    </p>
            <div class="hero-buttons">
                <a href="<?php echo esc_url(dlc_get_booking_page_url('ar')); ?>" class="btn-primary">احجز الآن</a>
                <a href="<?php echo esc_url(dlc_get_about_us_page_url('ar')); ?>" class="btn-secondary">اعرف أكثر</a>
            </div>
        </div>
    </section>
    

  
    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header no-bg">
                <h2 class="section-title">من نحن</h2>
                <p class="section-subtitle">مجموعة قانونية مقرها الرياض تقدم تأثيرًا ملموسًا في جميع أنحاء المملكة.</p>
            </div>
            <div class="row about-content align-items-center overflow-hidden ">
                <div class="col-lg-6 col-md-12  about-text">
                    <h3>التميز في الخدمات القانونية</h3>
                    <p>شركة داغ للمحاماة و الاستشارات القانونية هي مؤسسة قانونية رائدة مقرها الرياض، المملكة العربية السعودية. نحن نقدم خدمات قانونية شاملة واستشارات للأفراد والشركات في جميع أنحاء المملكة</p>
                    <p>فريقنا من المحامين والاستشاريين القانونيين ذوي الخبرة ملتزم بتقديم حلول قانونية دقيقة وفي الوقت المناسب وفعالة مصممة خصيصًا لتلبية احتياجاتك الخاصة.</p>
                  <div class="row about-stats">
                        <div class="col-md-3 col-sm-6 col-12 stat-item">
                        <div class="static-item-inner">
                            <h4 data-target="<?php echo esc_attr($cases_count); ?>"><?php echo esc_html($cases_count); ?></h4>
                            <p>القضايا </p>    

                        </div>    
                        
                        </div>
                        <div class="col-md-3 col-sm-6 col-12 stat-item">
                        <div class="static-item-inner">    
                            <h4 data-target="<?php echo esc_attr($contracts_count); ?>"><?php echo esc_html($contracts_count); ?></h4>
                            <p>العقود</p>
                        </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12 stat-item">
                        <div class="static-item-inner">
                            <h4 data-target="<?php echo esc_attr($clients_count); ?>"><?php echo esc_html($clients_count); ?></h4>
                            <p>العملاء</p>
                        </div>    
                       
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 about-image">
                    <?php $dlc_justice_dims = function_exists('dlc_get_theme_image_dimensions') ? dlc_get_theme_image_dimensions('assets/images/Justice.webp') : null; ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Justice.webp"
                         alt="Blindfolded statue of justice holding scales"
                         class="about-img"
                         loading="lazy"
                         <?php if ($dlc_justice_dims) : ?>
                             width="<?php echo esc_attr($dlc_justice_dims['width']); ?>"
                             height="<?php echo esc_attr($dlc_justice_dims['height']); ?>"
                         <?php endif; ?>
                         decoding="async">
                </div>
            </div>
        </div>
    </section>


    <!-- Parallax Divider -->
    <section class="parallax-divider" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/Riydah.jpg');">
        <div class="parallax-overlay"></div>
    </section>

    <!-- Services Section -->
<section id="services" class="services-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">ابدأ خدماتك القانونية بسهولة
</h2>
                <p class="section-subtitle"> نوفر أدوات ذكية تساعدك على الوصول لحلولك القانونية بسرعة، بإشراف محامين متخصصين في كل مجال.
</p>
            </div>
            <div class="row services-grid justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-12 px-4 service-card">
                    <div class="card-content">

                        <div class="service-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3> طلب استشارة قانونية</h3>
                        <p> استشر محاميًا مرخّصًا لتقييم وضعك القانوني وتحديد أنسب الحلول.</p>
                        <a href="<?php echo esc_url(dlc_get_booking_page_url('ar')); ?>" class="service-btn">اعرف أكثر</a>
           
                    </div>
                         </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12 px-4 service-card">
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3>  حاسبة العمالة</h3>
                    <p>أداة دقيقة تساعد المنشآت في حساب مستحقات العمال وفق نظام العمل السعودي.
                    </p>
                    <a href="<?php echo esc_url(dlc_get_services_page_url('ar')); ?>" class="service-btn">اعرف أكثر</a>
        
                    </div>    
                </div>
                
            <div class="col-lg-4 col-md-6 col-sm-12 px-4 service-card">
                    
                
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3> احسب ميراثك</h3>
                    <p> خدمة إلكترونية تساعدك لحساب أنصبة الورثة بطريقة شرعية ونظامية.</p>
                    <a href="<?php echo esc_url(dlc_get_services_page_url('ar')); ?>" class="service-btn">اعرف أكثر</a>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Accreditations Section -->
    <section id="accreditations" class="accreditations-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"> معتمدون من الجهات الرسمية
</h2>
                <p class="section-subtitle"> نفتخر بأننا شركة محاماة مسجّلة ومعتمدة لدى عدد من الهيئات والجهات القانونية في المملكة العربية السعودية، ونلتزم بتقديم خدمات قانونية عالية المستوى مدعومة بخبرة فريق متخصص، ورؤية واضحة تضمن لعملائنا أعلى درجات الكفاءة والدقة والموثوقية..</p>
            </div>
        </div>
    </section>

    <!-- Legal Services Section -->
    <section id="legal-services" class="legal-services-section">
        <div class="container">
            <div class="section-header no-bg">
                <h2 class="section-title">خدمات قانونية للأفراد والشركات</h2>
                <p class="section-subtitle"> نقدّم أكثر من 80 خدمة قانونية متخصصة تشمل مختلف القطاعات التجارية والمالية والاجتماعية، مع متابعة دقيقة لكل حالة.</p>
            </div>
            <div class="legal-services-grid">
                <div class="legal-service-card">
                    <div class="legal-card-content">
                        <div class="legal-service-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3>خدمات الأفراد</h3>
                        <p>نقدّم حلولًا قانونية متكاملة للأفراد تشمل القضايا الأسرية، العقارية، والإقرارات الرسمية.
</p>
                        <?php
                        // Get individual-services Arabic category
                        $individual_ar_category = get_category_by_slug('individual-services-ar');
                        if (!$individual_ar_category) {
                            $individual_en_category = get_category_by_slug('individual-services');
                            if (!$individual_en_category) {
                                $individual_en_category = get_term_by('name', 'Individual Services', 'category');
                            }
                            if ($individual_en_category && function_exists('pll_get_term')) {
                                $individual_ar_id = pll_get_term($individual_en_category->term_id, 'ar');
                                if ($individual_ar_id) {
                                    $individual_ar_category = get_category($individual_ar_id);
                                }
                            }
                        }
                        if (!$individual_ar_category) {
                            $individual_ar_category = get_term_by('name', 'خدمات الأفراد', 'category');
                        }
                        $individual_ar_url = $individual_ar_category ? get_category_link($individual_ar_category->term_id) : home_url('/category/individual-services');
                        ?>
                        <a href="<?php echo esc_url($individual_ar_url); ?>" class="legal-service-link">استكشف الخدمات <i class="fas fa-arrow-left"></i></a>
                    </div>
                </div>
                <div class="legal-service-card">
                    <div class="legal-card-content">
                        <div class="legal-service-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>خدمات الشركات</h3>
                    <p>من تأسيس الكيانات إلى صياغة العقود التجارية وحوكمة الشركات — نقدم استشارات تضمن التزام شركتك بالقوانين السعودية.</p>
                        <?php
                        // Get companies-services Arabic category
                        $companies_ar_category = get_category_by_slug('companies-services-ar');
                        if (!$companies_ar_category) {
                            $companies_en_category = get_category_by_slug('companies-services');
                            if (!$companies_en_category) {
                                $companies_en_category = get_term_by('name', 'Companies Services', 'category');
                            }
                            if ($companies_en_category && function_exists('pll_get_term')) {
                                $companies_ar_id = pll_get_term($companies_en_category->term_id, 'ar');
                                if ($companies_ar_id) {
                                    $companies_ar_category = get_category($companies_ar_id);
                                }
                            }
                        }
                        if (!$companies_ar_category) {
                            $companies_ar_category = get_term_by('name', 'خدمات الشركات', 'category');
                        }
                        $companies_ar_url = $companies_ar_category ? get_category_link($companies_ar_category->term_id) : home_url('/category/companies-services');
                        ?>
                        <a href="<?php echo esc_url($companies_ar_url); ?>" class="legal-service-link">استكشف الخدمات <i class="fas fa-arrow-left"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Certificates Section -->
    <?php get_template_part('includes/certificates'); ?>
    <?php get_template_part('includes/clients'); ?>



</main>
<?php
    get_footer('ar');
?>