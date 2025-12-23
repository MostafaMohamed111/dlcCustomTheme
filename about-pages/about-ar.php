
<?php
$company_pdf      = function_exists('get_field') ? get_field('company_pdf') : '';
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
                        <a href="#about-dag" class="btn hero-btn learn-more-btn">اعرف أكثر</a>
                        <?php if (!empty($company_pdf_url)) : ?>
                            <a href="<?php echo esc_url($company_pdf_url); ?>" class="btn hero-btn download-btn" target="_blank" rel="noopener">
                                تحميل PDF<span class=" fa-solid fa-download ps-2 "></span>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="col-xl-5 col-md-6   hero-image">
                    <?php $dlc_mrdag_dims = function_exists('dlc_get_theme_image_dimensions') ? dlc_get_theme_image_dimensions('assets/images/mrDag.webp') : null; ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mrDag.webp"
                         alt="Mr. Dag"
                         class="ceo-image"
                       
                         decoding="async"
                         loading="lazy">

                </div>
            </div>
        </div>
</div>




<section class="about-section">
    <div class="container">
        <div class="about-dag" id="about-dag">
            <h2>عن داغ</h2>
         

            <div class="paragraph">

               <p >
                شركة داغ للمحاماة والاستشارات القانونية، مملوكة للمحامي محمد داغستاني ويقع مقرها الرئيسي في الرياض، المملكة العربية السعودية، وتختص في تقديم أكثر من 80 خدمة قانونية متخصصة للأفراد والشركات في مختلف المجالات القانونية.
                </p>
                <p>
                    شركة داغ للمحاماة والاستشارات القانونية، المملوكة للمحامي محمد داغستاني، ومقرها الرياض – المملكة العربية السعودية،
                    تُعد من مكاتب المحاماة المرخصة المتخصصة في تقديم الخدمات والاستشارات القانونية للأفراد والشركات داخل المملكة.
                    يرتكز عمل الشركة على أسس مهنية تضمن الدقة، الالتزام، والامتثال التام للأنظمة السعودية.
                </p>

                <p>
                    شركة داغ للمحاماة تقدم خدماتها لجميع المؤسسات والأفراد في جميع المدن في المملكة العربية السعودية، ومنطقة الخليج، ودول أخرى تمارس أنشطة تجارية داخل المملكة ونظامها القانوني.
                </p>

                <p>
                    نحن مجهزون للتعامل مع جميع أنواع القضايا، بفضل فريقنا القانوني المتنوع وذو الخبرة العالية، الذي يواكب أحدث التطورات القانونية والتغييرات التنظيمية.
                </p>


                <p>
                    يؤمن المستشار محمد داغستاني إيمانًا راسخًا بأن تعزيز الوعي القانوني داخل المؤسسات هو إجراء وقائي حاسم ضد النزاعات. لذلك، تعطي شركة داغ أولوية لتعزيز المعرفة القانونية لعملائها. من خلال خبرته الواسعة وفريقه المتخصص، يضمن أن تتلقى الشركات الدعم القانوني اللازم لتعمل بسلاسة وتحمي نفسها من المخاطر القانونية المحتملة.
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
أسس الأستاذ محمد داغستاني شركة داغ للمحاماة عام 2000 برؤية تركز على بناء ممارسة قانونية قائمة على المهنية والانضباط.
 خلال مسيرته، اكتسب خبرة واسعة في القطاعات التجارية والصناعية والزراعية،
 كما قدّم خدمات استشارية لعدد من الجهات المرتبطة بـ هيئة السوق المالية.
 ساهمت خبراته في تعزيز موقع الشركة كمكتب قانوني معتمد تتعامل معه شركات وجهات متعددة داخل المملكة وخارجها                </p>
                <p>
                    مع أكثر من عقدين من الخبرة، حصل المستشار محمد داغستاني على العديد من الشهادات المتخصصة في القانون والاستشارات القانونية، مما يجعله واحدًا من أبرز الخبراء في المجال. لقد مكنته رؤيته الاستراتيجية ونهجه القانوني المبتكر من بناء فريق إدارة متميز قادر على تقديم دعم قانوني متكامل للعملاء، سواء في القطاعات التجارية أو ضمن تنظيمات هيئة السوق المالية.

                </p>
            </div>
            <div class="image-container col-lg-5">
                <div class="geometric-background-pattern">
                    <div class="mr-dag-image">
                        <?php $dlc_mrdag_dims = function_exists('dlc_get_theme_image_dimensions') ? dlc_get_theme_image_dimensions('assets/images/mrDag.webp') : null; ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mrDag.webp"
                             alt="Mr. Dagestani"
                         
                             decoding="async"
                             loading="lazy">
                    </div>
                </div>

        </div>
    </div>




</section>

<!-- Who We Are Section -->
<section class="who-we-are-section">
    <div class="container">
        <div class="who-we-are-content">
            <div class="who-we-are-header">
                <h2 class="who-we-are-title">من نحن</h2>
                <div class="title-underline"></div>
            </div>
            <p class="who-we-are-text">
تُقدّم شركة داغ للمحاماة والاستشارات القانونية خدمات نظامية شاملة يقودها المحامي محمد داغستاني بخبرة تمتد لأكثر من عشرين عامًا في مجالات المحاماة والاستشارات القانونية.
 يشمل نطاق خدمات الشركة أكثر من 80 خدمة قانونية تغطي الاستشارات، التمثيل القضائي، التحكيم، صياغة العقود، والترافع أمام الجهات القضائية بمختلف درجاتها.
            </p>
        </div>
    </div>
</section>

<!-- CTA to Our Team Section -->
<section class="team-cta-section">
    <div class="container">
        <div class="team-cta-wrapper">
            <div class="team-cta-content">
                <div class="team-cta-icon">
                    <i class="fa-solid fa-users-line"></i>
                </div>
                <h2 class="team-cta-title">تعرف على فريقنا القانوني الخبير</h2>
                <p class="team-cta-description">
                    اكتشف المحترفين المتفانين وراء مكتب داغ للمحاماة. محامونا ومستشارونا ذوو الخبرة مستعدون لتزويدك بخدمات قانونية استثنائية.
                </p>
                <a href="<?php echo esc_url(get_post_type_archive_link('team')); ?>" class="team-cta-button">
                    <span>اعرض فريقنا</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="team-cta-visual">
                <div class="team-cta-decoration"></div>
            </div>
        </div>
    </div>
</section>

<section class="mission-section">
    <div class="container">
        <h2 class="mission-title">رسالتنا</h2>
        <p class="mission-description">
            تسعى الشركة إلى تقديم حلول قانونية دقيقة وفعالة تستند إلى فهم معمّق للأنظمة السعودية ومتابعة مستمرة للتحديثات التنظيمية، بما يمكّن العملاء من ممارسة أعمالهم بثقة، ويضمن حماية مصالحهم وتحقيق الامتثال القانوني الكامل.
        </p>
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
العمل على أن تكون شركة داغ للمحاماة والاستشارات القانونية جهة قانونية معتمدة وموثوقة في المملكة،
 وأن تواصل تطوير خدماتها بما يواكب التحول الرقمي في قطاع المحاماة، انسجامًا مع مستهدفات رؤية المملكة 2030.
            </p>
        </div>
    </div>
</section>

<?php
$cases_count = 0;
$contracts_count = 0;
$clients_count = 0;
$intellectual_properties_count = 0;

if (function_exists('get_field')) {
    $cases_count = (int) get_field('cases');
    $contracts_count = (int) get_field('contracts');
    $clients_count = (int) get_field('clients');
    $intellectual_properties_count = (int) get_field('intellectual_properties');
}
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

<!-- Our Objectives Section -->
<section class="objectives-section">
    <div class="container">
        <h2 class="objectives-title">مهامنا</h2>
        <div class="objectives-list">
            <div class="objective-item">
                <div class="objective-icon">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>
                <p class="objective-text">دعم التحول الرقمي في الخدمات القانونية وفق رؤية السعودية 2030.</p>
            </div>
            <div class="objective-item">
                <div class="objective-icon">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <p class="objective-text">تمكين الأفراد والشركات من فهم حقوقهم والتزاماتهم القانونية.</p>
            </div>
            <div class="objective-item">
                <div class="objective-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <p class="objective-text">حماية المصالح القانونية للعملاء وتقليل المخاطر والنزاعات.</p>
            </div>
            <div class="objective-item">
                <div class="objective-icon">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <p class="objective-text">توثيق الحقوق والمعاملات بما يتفق مع الأنظمة المحلية.</p>
            </div>
            <div class="objective-item">
                <div class="objective-icon">
                    <i class="fa-solid fa-hands-helping"></i>
                </div>
                <p class="objective-text">تقديم خدمات استشارية متكاملة تحقق الكفاءة ودقة التنفيذ.</p>
            </div>
        </div>
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

<?php get_footer('ar'); ?>