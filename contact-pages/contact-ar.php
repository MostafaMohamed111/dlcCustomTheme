<?php

    get_header('ar');
?>


<div class="container">
    <section class="contact-us">
        <div class="contact-us-content">
            <h1>اتصل بنا</h1>
            <p class="lead">نحن في شركة داغ للمحاماة والاستشارات القانونية نسعد بخدمتك في كل ما يتعلق بالاستشارات القانونية، إعداد العقود، القضايا التجارية، والتحكيم.
                 تواصلك معنا هو الخطوة الأولى نحو الحل القانوني المناسب لك.
            </p>
        </div>

        <div class="contact-us-body row d-flex gx-5 justify-content-space-between">
            <form id="contact-form" class="contact-us-form col-lg-6 col-md-12">
                <h2 class="contact-form-title">نموذج الاتصال</h2>
                <p class="contact-form-description">يرجى ملء النموذج أدناه، وسيتواصل معك أحد مستشارينا القانونيين في أقرب وقت لمناقشة طلبك وتقديم المساعدة المناسبة.</p>
                <div id="form-status-message"></div>

                <div class=" name mb-3">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="اسمك" required>
                </div>
                <div class="phone mb-3">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <input type="tel" class="form-control arabic-phone" id="phone" name="phone" placeholder="رقم هاتفك" required>
                </div>
                <div class=" email mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control arabic-email" id="email" name="email" placeholder="بريدك الإلكتروني  " >
                </div> 
                <div class=" message mb-3">
                    <label for="message" class="form-label">الرسالة</label>
                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="رسالتك" required></textarea>
                </div>
                <?php wp_nonce_field( 'contact_form_nonce', 'contact_form_nonce_field' ); ?>

                <button type="submit" class="btn">إرسال</button>
            </form>

            <div class="form-image col-lg-6 col-md-12 ">
                <?php $dlc_contact_img_dims = function_exists('dlc_get_theme_image_dimensions') ? dlc_get_theme_image_dimensions('assets/images/services.jpg') : null; ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services.jpg"
                     alt="Contact Us"
                     <?php if ($dlc_contact_img_dims) : ?>
                         width="<?php echo esc_attr($dlc_contact_img_dims['width']); ?>"
                         height="<?php echo esc_attr($dlc_contact_img_dims['height']); ?>"
                     <?php endif; ?>
                     decoding="async"
                     loading="lazy">
                   <a class="quick-link calendar" href="<?php echo esc_url(dlc_get_booking_page_url('ar')); ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span>حجز استشارة</span>
                </a>
            </div>
        </div>
            
       
    </section>        



    <section class="company-info " >
        
        <h2 class="text-center">تفاصيل الاتصال</h2>

        <!-- Contact Cards -->
        <div class="contact-cards row gx-4 gy-4">
            <?php
            $phone = function_exists('get_field') ? get_field('phone') : '';
            $mail = function_exists('get_field') ? get_field('mail') : '';
            $working_hours = function_exists('get_field') ? get_field('working_hours') : '';
            $closed = function_exists('get_field') ? get_field('closed') : '';
            ?>
            <div class=" col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>موقع المكتب</h3>
                    <?php
                    $location_url = function_exists('get_field') ? get_field('location') : '';
                    if (!$location_url) {
                        $location_url = 'https://maps.google.com/?q=Riyadh';
                    }
                    ?>
                    <a class="contact-action" href="<?php echo esc_url($location_url); ?>" target="_blank" rel="noopener">فتح في خرائط جوجل</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>الهاتف</h3>
                    <p class = 'arabic-phone'><?php echo $phone ? esc_html($phone) : '+966 12 345 6789'; ?></p>
                    <?php if ($phone) : ?>
                        <a class="contact-action" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">اتصل الآن</a>
                    <?php else : ?>
                        <a class="contact-action" href="tel:+966123456789">اتصل الآن</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>البريد الإلكتروني  </h3>
                    <p><?php echo $mail ? esc_html($mail) : 'info@legalconsulting.com'; ?></p>
                    <?php if ($mail) : ?>
                        <a class="contact-action" href="mailto:<?php echo esc_attr($mail); ?>">إرسال بريد إلكتروني</a>
                    <?php else : ?>
                        <a class="contact-action" href="mailto:info@legalconsulting.com">إرسال بريد إلكتروني</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>ساعات العمل</h3>
                    <p><?php echo $working_hours ? esc_html($working_hours) : 'الأحد–الخميس: 9:00 – 18:00'; ?></p>
                    <?php if ($closed) : ?>
                        <span class="contact-action muted"><?php echo esc_html($closed); ?></span>
                    <?php else : ?>
                        <span class="contact-action muted">الجمعة–السبت: مغلق</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    

    </section>

</div>

<!-- Success Modal -->
<div id="contact-success-modal" class="contact-modal" style="display: none;">
    <div class="contact-modal-overlay"></div>
    <div class="contact-modal-content">
        <div class="contact-modal-header">
            <h2 class="contact-modal-title">تم إرسال طلبك بنجاح <i class="fa-regular fa-circle-check success text-success"></i></h2>
            <button class="contact-modal-close" aria-label="إغلاق النافذة">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        <div class="contact-modal-body">
            <p class="contact-modal-message">
شكرًا لتواصلك مع شركة داغ للمحاماة والاستشارات القانونية.            </p>
            <p class="contact-modal-message">
 تم استلام رسالتك بنجاح، وسيتواصل معك أحد مستشارينا القانونيين في أقرب وقت ممكن لمراجعة طلبك وتقديم المساعدة المناسبة.
            </p>
            <p class="contact-modal-message">
                نحن نقدر اهتمامك حقاً ونتطلع إلى خدمتك قريباً.
            </p>
            <p class="contact-modal-message">
يمكنك أيضًا متابعتنا على قنواتنا الرسمية لمعرفة آخر الأخبار والخدمات القانونية.
            </p>
        </div>
        <div class="contact-modal-footer">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="contact-modal-link">
                <i class="fa-solid fa-home"></i>
                العودة إلى الصفحة الرئيسية
            </a>
            <a href="<?php echo esc_url(dlc_get_services_page_url('ar')); ?>" class="contact-modal-link">
                <i class="fa-solid fa-briefcase"></i>
                استكشف خدماتنا
            </a>
        </div>
    </div>
</div>





<?php
    get_footer('ar');
?>