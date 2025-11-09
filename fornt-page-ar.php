<?php
/*
Template Name: Front Page Arabic


*/
get_header('ar');

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
                <button class="btn-primary">ابدأ الآن</button>
                <button class="btn-secondary">تعرف أكثر</button>
            </div>
        </div>
    </section>
    

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">من نحن</h2>
                <p class="section-subtitle"></p>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <h3>التميز في الخدمات القانونية</h3>
                    <p>شركة داغ للمحاماة و الاستشارات القانونية هي مؤسسة قانونية رائدة مقرها الرياض، المملكة العربية السعودية. نحن نقدم خدمات قانونية شاملة واستشارات للأفراد والشركات في جميع أنحاء المملكة.</p>
                    <p>فريقنا من المحامين والاستشاريين القانونيين ذوي الخبرة ملتزم بتقديم حلول قانونية دقيقة وفي الوقت المناسب وفعالة تلبي احتياجاتك الخاصة.</p>
                    <div class="about-stats">
                        <div class="stat-item">
                            <h4>500+</h4>
                            <p>القضايا المحلولة</p>
                        </div>
                        <div class="stat-item">
                            <h4>15+</h4>
                            <p>سنوات الخبرة</p>
                        </div>
                        <div class="stat-item">
                            <h4>50+</h4>
                            <p>محامون خبراء</p>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Justice.webp" alt="Justice" class="about-img">
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
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>طلب استشارة</h3>
                    <p>احصل على نصائح قانونية من فريقنا المتمرس من المحامين. حدد موعدًا للاستشارة لمناقشة مسائل قانونية.</p>
                    <button class="service-btn">تعرف أكثر</button>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3>حاسبة نهاية الخدمة</h3>
                    <p>استخدم حاسبتنا المتقدمة لتحديد مكافأة نهاية الخدمة الخاصة بك وفقًا لقانون العمل السعودي.</p>
                    <button class="service-btn">احسب الآن</button>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3>حاسبة الميراث</h3>
                    <p>احسب حصص الميراث وفقًا للشريعة الإسلامية واللوائح السعودية باستخدام أداتنا المتخصصة.</p>
                    <button class="service-btn">احسب الآن</button>
                </div>
            </div>
        </div>
    </section>



</main>
<?php
    get_footer('ar');
?>