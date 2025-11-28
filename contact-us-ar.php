<?php
/* Template Name: Contact Us Arabic
*/
    get_header('ar');
?>


<div class="container">
    <section class="contact-us">
        <div class="contact-us-content">
            <h1>اتصل بنا</h1>
            <p class="lead" >إذا كان لديك أي أسئلة أو تحتاج إلى مزيد من المعلومات، فلا تتردد في التواصل معنا من خلال تفاصيل الاتصال التالية:</p>
        </div>

        <div class="contact-us-body row d-flex gx-5 justify-content-space-between">
            <form id="contact-form" class="contact-us-form col-lg-6 col-md-12">
                <div id="form-status-message"></div>

                <div class=" name mb-3">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="اسمك" required>
                </div>
                <div class=" email mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control arabic-email" id="email" name="email" placeholder="بريدك الإلكتروني  " required>
                </div> 
                <div class=" message mb-3">
                    <label for="message" class="form-label">الرسالة</label>
                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="رسالتك" required></textarea>
                </div>
                <?php wp_nonce_field( 'contact_form_nonce', 'contact_form_nonce_field' ); ?>

                <button type="submit" class="btn">إرسال</button>
            </form>

            <div class="form-image col-lg-6 col-md-12 ">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services.jpg" alt="Contact Us">
            </div>
        </div>
            
       
    </section>        



    <section class="company-info " >
        
        <h2 class="text-center">تفاصيل الاتصال</h2>

        <!-- Contact Cards -->
        <div class="contact-cards row gx-4 gy-4">
            <?php
            $phone = get_field('phone');
            $mail = get_field('mail');
            $working_hours = get_field('working_hours');
            $closed = get_field('closed');
            ?>
            <div class=" col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>موقع المكتب</h3>
                    <?php
                    $location_url = get_field('location');
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
                    <p><?php echo $phone ? esc_html($phone) : '+966 12 345 6789'; ?></p>
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

        <!-- Quick Actions -->
        <div class="contact-quick row gx-3 gy-3 my-5 align-items-stretch">
            <div class="col-md-6 col-sm-12">
                <a class="quick-link whatsapp" href="https://wa.me/966123456789" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i>
                    <span>الدردشة على واتساب</span>
                </a>
            </div>
            <div class="col-md-6 col-sm-12">
                <a class="quick-link calendar" href="<?php echo home_url('/booking/'); ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span>حجز استشارة</span>
                </a>
            </div>
        </div>


    </section>


</div>





<?php
    get_footer('ar');
?>