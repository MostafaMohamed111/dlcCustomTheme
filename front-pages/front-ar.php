<?php

get_header('ar');

$cases_count = (int) get_field('cases');
$contracts_count = (int) get_field('contracts');
$clients_count = (int) get_field('clients');
?>
<main>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-background" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/Riydah.jpg');"></div>
        <div class="hero-content">
            <h1 class="hero-company">شركة داغ</h1>
            <h2 class="hero-title">للمحاماة و الاستشارات القانونية</h2>
            <p class="hero-subtitle">منصة قانونية رقمية للحلول الدقيقة</p>
            <div class="hero-buttons">
                <a href="<?php echo esc_url(dlc_get_booking_page_url('ar')); ?>" class="btn-primary">احجز الآن</a>
                <a href="<?php echo esc_url(dlc_get_about_us_page_url('ar')); ?>" class="btn-secondary">تعرف أكثر</a>
            </div>
        </div>
    </section>
    

  
    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header">
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
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Justice.webp" alt="Blindfolded statue of justice holding scales" class="about-img" loading="lazy">
                </div>
            </div>
        </div>
    </section>


    <!-- Parallax Divider -->
    <section class="parallax-divider" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/Services.jpg');">
        <div class="parallax-overlay"></div>
    </section>

    <!-- Services Section -->
<section id="services" class="services-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">خدماتنا</h2>
                <p class="section-subtitle"></p>
            </div>
            <div class="row services-grid justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-12 px-4 service-card">
                    <div class="card-content">

                        <div class="service-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>طلب استشارة</h3>
                        <p>احصل على نصائح قانونية من فريقنا المتمرس من المحامين. حدد موعدًا للاستشارة لمناقشة مسائل قانونية.</p>
                        <a href="<?php echo esc_url(dlc_get_booking_page_url('ar')); ?>" class="service-btn">اعرف أكثر</a>
           
                    </div>
                         </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12 px-4 service-card">
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3>حاسبة نهاية الخدمة</h3>
                    <p>استخدم حاسبتنا المتقدمة لتحديد مكافأة نهاية الخدمة الخاصة بك وفقًا لقانون العمل السعودي.</p>
                    <a href="<?php echo esc_url(dlc_get_services_page_url('ar')); ?>" class="service-btn">اعرف أكثر</a>
        
                    </div>    
                </div>
                
            <div class="col-lg-4 col-md-6 col-sm-12 px-4 service-card">
                    
                
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3>حاسبة الميراث</h3>
                    <p>احسب حصص الميراث وفقًا للشريعة الإسلامية واللوائح السعودية باستخدام أداتنا المتخصصة.</p>
                    <a href="<?php echo esc_url(dlc_get_services_page_url('ar')); ?>" class="service-btn">اعرف أكثر</a>
                </div>
            </div>
        </div>
    </div>
</section>



</main>
<?php
    get_footer('ar');
?>