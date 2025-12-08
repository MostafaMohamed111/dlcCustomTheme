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
            <p class='service-head lead'>في شركة داغ للمحاماة والاستشارات القانونية، ندرك أن احتياجات العملاء القانونية تختلف باختلاف طبيعة نشاطهم،
 ولهذا صُمِّمت خدماتنا لتغطي نطاقًا واسعًا من الحلول القانونية للأفراد والشركات،
 وفقًا للأنظمة السعودية واللوائح التنظيمية المعمول بها.
</p>                
                <p class='service-head lead'>
                    تقدّم الشركة أكثر من 80 خدمة قانونية متخصصة يشرف عليها فريق من المستشارين والمحامين ذوي الخبرة،
 بهدف تمكين العملاء من إدارة أعمالهم والتزاماتهم القانونية بوضوح وأمان.

                </p>
            </div>
            <div class="services-grid">
                <div class="service-card companies">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/companies-services-ar.webp" alt="Corporate Law">
                    <h2 class="text-center">خدمات الشركات </h2>
                    <p>نوفّر للشركات والمؤسسات حلولًا قانونية شاملة تدعم استمرارية الأعمال وتحميها من المخاطر النظامية.
</p>
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
                    <a class="service-btn btn" href="<?php echo esc_url($companies_ar_url); ?>"> استعرض خدمات الشركات</a>
                </div>
                <div class="service-card individuals">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/individual-services-ar.webp" alt="Individual Law">
                    <h2 class="text-center">خدمات الأفراد</h2>
                    <p>تهدف خدماتنا للأفراد إلى توفير الحماية القانونية وضمان الحقوق في مختلف الجوانب الشخصية والمالية.</p>
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
                    <a class="service-btn btn" href="<?php echo esc_url($individual_ar_url); ?>">استعرض خدمات الأفراد </a>
                </div>
            </div>
        </div>


        </div>
    </div>

    
        <!-- قسم التزامنا -->
        <div class="row commitment-section animate">
            <div class="col-lg-12">
                <h2 class="section-title text-center">رسالتنا في تقديم الخدمات
 <i class="fa-solid fa-certificate"></i></h2>
                <p class="commitment-text">
                في شركة داغ للمحاماة والاستشارات القانونية،
 نلتزم بتقديم خدمات قانونية دقيقة تراعي مصلحة العميل، وتعتمد على مهنية عالية وفهم متعمق للأنظمة السعودية،
 مع الحرص على تحقيق أعلى درجات الشفافية وحفظ السرية.

            </p>
            </div>
        </div>

        <!-- قسم الأسئلة الشائعة -->
        <section class="faq-section">
            <div class="faq-container">
                <h2 class="faq-title">الأسئلة الشائعة – خدماتنا القانونية</h2>
                <p class="faq-subtitle">ابحث عن إجابات للأسئلة الشائعة حول خدماتنا القانونية</p>
                
                <ul class="faq-list">
                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">ما أنواع الخدمات القانونية التي تقدمها شركة داغ للمحاماة؟</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">تقدّم شركة داغ مجموعة متكاملة من الخدمات القانونية للأفراد والشركات، تشمل الاستشارات القانونية، الترافع أمام المحاكم، صياغة العقود، التحكيم التجاري، تأسيس الشركات، حماية الملكية الفكرية، وإدارة التركات.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">هل يمكن الحصول على استشارة قانونية عن بُعد؟</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">نعم، تتيح شركة داغ إمكانية تقديم الاستشارات القانونية عبر الوسائل الرقمية المعتمدة، بما يضمن الخصوصية وسرعة التواصل، سواء داخل المملكة أو خارجها.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">هل تقدم الشركة خدمات التحكيم التجاري؟</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">نعم، تقدم الشركة خدمات التحكيم سواء بتمثيل العملاء كمحامين في دعاوى التحكيم أو بتولي مهمة المحكم المعتمد في المنازعات التجارية.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">هل يمكن للشركات الأجنبية الاستفادة من خدمات شركة داغ؟</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">بالتأكيد، لدى الشركة خبرة في تأسيس الشركات الأجنبية وتقديم الدعم القانوني لها وفق الأنظمة السعودية، بما في ذلك تراخيص الاستثمار وتنظيم العلاقات القانونية داخل المملكة.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">ما مدى سرية المعلومات التي يشاركها العميل؟</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">تلتزم شركة داغ بسياسة صارمة لحماية سرية بيانات العملاء، وتُعامل جميع المعلومات والمستندات بسرية تامة وفق أحكام النظام السعودي وأخلاقيات مهنة المحاماة.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">هل تشمل الخدمات القانونية صياغة العقود ومراجعتها؟</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">نعم، تمتلك شركة داغ فريقًا متخصصًا في إعداد العقود ومراجعتها لضمان توافقها مع الأنظمة السعودية وحماية مصالح الأطراف المتعاقدة.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">كيف يمكنني بدء التعامل مع الشركة؟</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">يمكنك التواصل عبر الموقع الإلكتروني أو الاتصال المباشر على الرقم الرسمي، لتحديد موعد استشارة قانونية أولية يتم خلالها تحديد نوع الخدمة القانونية المناسبة لك.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>            

<?php get_footer('ar'); ?>
