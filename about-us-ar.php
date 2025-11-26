
<?php
/*  
* Template Name: About Us Page - Arabic
*/

$company_pdf      = get_field('company_pdf');
$company_pdf_url  = '';

if (is_array($company_pdf) && isset($company_pdf['url'])) {
    $company_pdf_url = $company_pdf['url'];
} elseif (is_string($company_pdf)) {
    $company_pdf_url = $company_pdf;
}

get_header('ar'); ?>


<div class="hero">
        <div class="hero-body ">
            <div class="hero-background-image">

            </div>
            <div class="row   hero-row">
                <div class="col-xl-5 col-md-6 col-sm-8    hero-content">
                    <h1 class="hero-title">شركة داغ <br><span>للمحاماة والاستشارات القانونية</span> </h1>
                    <p class="lead hero-subtitle">مملوكة للمحامي محمد داغستاني ويقع مقرها الرئيسي في الرياض، المملكة العربية السعودية.</p>
                    <div class="hero-actions">
                        <a href="#about-dag" class="btn hero-btn learn-more-btn">اتعرف أكثر</a>
                        <?php if (!empty($company_pdf_url)) : ?>
                            <a href="<?php echo esc_url($company_pdf_url); ?>" class="btn hero-btn download-btn" target="_blank" rel="noopener">
                                تحميل PDF<span class=" fa-solid fa-download ps-2 "></span>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="col-xl-5 col-md-6   hero-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mrDag.webp" alt="Mr. Dag" class="ceo-image">

                </div>
            </div>
        </div>
</div>




<section class="about-section">
    <div class="container">
        <div class="about-dag" id="about-dag">
            <h2>عن داغ</h2>
            <p class="lead">
                شركة داغ للمحاماة والاستشارات القانونية، مملوكة للمحامي محمد داغستاني ويقع مقرها الرئيسي في الرياض، المملكة العربية السعودية، وتختص في تقديم أكثر من 80 خدمة قانونية متخصصة للأفراد والشركات في مختلف المجالات القانونية.
            </p>

            <div class="paragraph">
                <p>
                    مع خبرته الواسعة في المهنة القانونية، تخصص <span class="highlight">السيد محمد داغستاني</span> في عدة قطاعات تجارية، بما في ذلك <span class="highlight">القطاع التجاري</span>، و<span class="highlight">القطاعات الصناعية والزراعية</span>، و<span class="highlight">هيئة السوق المالية</span>.   
                </p>

                <p>
                    <span class="highlight">شركة داغ للمحاماة</span> تقدم خدماتها لجميع المؤسسات والأفراد في جميع المدن في <span class="highlight">المملكة العربية السعودية</span>، و<span class="highlight">منطقة الخليج</span>, ودول أخرى تمارس أنشطة تجارية داخل <span class="highlight">المملكة</span> ونظامها القانوني.
                </p>

                <p>
                    نحن مجهزون للتعامل مع جميع أنواع القضايا، بفضل فريقنا القانوني المتنوع وذو الخبرة العالية، الذي يواكب أحدث التطورات القانونية والتغييرات التنظيمية.
                </p>


                <p>
                    يؤمن المستشار <span class="highlight">محمد داغستاني</span> إيمانًا راسخًا بأن تعزيز الوعي القانوني داخل المؤسسات هو إجراء وقائي حاسم ضد النزاعات. لذلك، تعطي <span class="highlight">شركة داغ</span> أولوية لتعزيز المعرفة القانونية لعملائها. من خلال خبرته الواسعة وفريقه المتخصص، يضمن أن تتلقى الشركات الدعم القانوني اللازم لتعمل بسلاسة وتحمي نفسها من المخاطر القانونية المحتملة.
                </p>


            </div>
            

        </div>

    </div>



</section>

<section class="about-mr-dag-section">
    <div class="container">
        <div class="row about-mr-dag-row">
            <div class="content col-lg-7">
                <h2 class="founder-title">
                    عن المؤسس – المستشار محمد داغستاني
                </h2>

                <p>
                    في عالم الأعمال المتطور باستمرار، لم يعد وجود شريك قانوني موثوق به رفاهية بل ضرورة لضمان الحماية القانونية والامتثال التنظيمي. ومن هذا المنطلق، أسس المستشار <span class="highlight">محمد داغستاني</span> <span class="highlight">شركة داغ</span> في <span class="highlight">2000</span>، بهدف واضح: تقديم حلول قانونية شاملة تدعم كل من الشركات والأفراد مع حماية حقوقهم بأعلى معايير المهنية.
                </p>
                <p>
                    مع أكثر من عقدين من الخبرة، حصل المستشار <span class="highlight">محمد داغستاني</span> على العديد من الشهادات المتخصصة في القانون والاستشارات القانونية، مما يجعله واحدًا من أبرز الخبراء في المجال. لقد مكنته رؤيته الاستراتيجية ونهجه القانوني المبتكر من بناء فريق إدارة متميز قادر على تقديم دعم قانوني متكامل للعملاء، سواء في القطاعات التجارية أو ضمن تنظيمات <span class="highlight">هيئة السوق المالية</span>.

                </p>
            </div>
            <div class="image-container col-lg-5">
                <div class="geometric-background-pattern">
                    <div class="mr-dag-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mrDag.webp" alt="Mr. Dagestani">
                    </div>
                </div>

        </div>
    </div>




</section>
















<section class="mission-section">
    <div class="container">
        <h2 class="mission-title">مهمتنا</h2>
        <div class="mission-grid">
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>
                <p class="mission-text">تنفيذ التحول الرقمي بما يتماشى مع رؤية المملكة العربية السعودية 2030.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <p class="mission-text">استخدام كل معارفنا القانونية وأدواتنا لتحقيق العدالة واستعادة الحقوق.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <p class="mission-text">أن نصبح الشريك القانوني الموثوق به لعملائنا، مع السعي الدائم لتقديم أفضل الخدمات لهم.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <p class="mission-text">حماية المصالح القانونية لعملائنا والحفاظ عليها.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-gavel"></i>
                </div>
                <p class="mission-text">ضمان الحفاظ على الحقوق واستعادتها لأصحابها الشرعيين مع اغتنام الفرص بكفاءة.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-file-contract"></i>
                </div>
                <p class="mission-text">توثيق حقوق عملائنا قانونيًا وفقًا للقوانين المحلية والتطبيقية.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <p class="mission-text">حماية عملائنا من العقوبات والنزاعات القانونية.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <p class="mission-text">تعزيز الوعي القانوني بين عملائنا لمساعدتهم على تجنب التحديات القانونية.</p>
            </div>
        </div>
    </div>
</section>

<section class="values-section">
    <div class="container">
        <h2 class="values-title">قيمنا</h2>
        <div class="values-carousel-wrapper">
            <button class="carousel-btn carousel-btn-prev" id="carouselPrev">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="values-carousel" id="valuesCarousel">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h3 class="value-title">الاحترافية والتميز</h3>
                    <p class="value-description">ضمان مستوى عالٍ من الجودة والخبرة في جميع خدماتنا القانونية، وتقديم نتائج استثنائية لعملائنا.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3 class="value-title">الشفافية والالتزام</h3>
                    <p class="value-description">الحفاظ على التواصل المفتوح والالتزام الثابت بنجاح عملائنا وحمايتهم القانونية.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="value-title">عملائنا</h3>
                    <p class="value-description">وضع عملائنا في قلب كل ما نقوم به، مع إعطاء الأولوية لاحتياجاتهم وبناء علاقات دائمة.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <h3 class="value-title">السرية والخصوصية</h3>
                    <p class="value-description">حماية مصالح عملائنا بأقصى درجات الالتزام، وضمان السرية التامة وحماية الخصوصية.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3 class="value-title">متاحون للدعم</h3>
                    <p class="value-description">دائمًا متاحون لدعم عملائنا كلما احتاجوا إلى خدماتنا، مع تقديم المساعدة في الوقت المناسب وبموثوقية.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="value-title">التطوير المستمر</h3>
                    <p class="value-description">التطوير المستمر ومواكبة التحديثات القانونية في المملكة العربية السعودية لخدمة عملائنا بشكل أفضل.</p>
                </div>
            </div>
            <button class="carousel-btn carousel-btn-next" id="carouselNext">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
            <div class="carousel-indicators">
                <span class="indicator active" data-slide="0"></span>
                <span class="indicator" data-slide="1"></span>
                <span class="indicator" data-slide="2"></span>
                <span class="indicator" data-slide="3"></span>
                <span class="indicator" data-slide="4"></span>
                <span class="indicator" data-slide="5"></span>
            </div>
        </div>
    </div>
</section>

<section class="vision-section">
    <div class="container">
        <div class="vision-content">
            <h2 class="vision-title">رؤيتنا</h2>
            <p class="vision-text">
                ترك بصمتنا الفريدة في المجال القانوني في المملكة العربية السعودية وأن نصبح من أبرز الكيانات القانونية التي يلجأ إليها الجميع بثقة في مهنيتنا وخبرتنا والتزامنا برؤية السعودية 2030.
            </p>
        </div>
    </div>
</section>

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
            منذ تأسيس مكتب داق للمحاماة، كان تقديم المشورة القانونية ورضا العملاء وتلبية احتياجاتهم بوصلة لنا وهدفنا الدائم. من خلال عملنا، سررنا بأن نكون شركاء ناجحين لمجموعة من المؤسسات والمنظمات المرموقة، وتعبيرهم عن رضاهم بهذه الشراكة المتميزة هو ما نملكه.
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







<?php get_footer('ar'); ?>