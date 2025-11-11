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
            <form id="contact-form" class="contact-us-form col-lg-6 col-md-12" action="#" method="get">
                <div class=" name mb-3">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" class="form-control" id="name" placeholder="اسمك">
                </div>
                <div class=" email mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control" id="email" placeholder="بريدك الإلكتروني">
                </div> 
                <div class=" message mb-3">
                    <label for="message" class="form-label">الرسالة</label>
                    <textarea class="form-control" id="message" rows="5" placeholder="رسالتك"></textarea>
                </div>
            
                <button type="submit" class="btn">إرسال</button>

            </form>

            <div class="form-image col-lg-6 col-md-12 ">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services.jpg" alt="اتصل بنا">
            </div>
        </div>
            
       
    </section>        



    <section class="company-info " >
        
        <h2 class="text-center">تفاصيل الاتصال</h2>

        <!-- Contact Cards -->
        <div class="contact-cards row gx-4 gy-4">
            <div class=" col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>موقع المكتب</h3>
                    <p>123 شارع القانون، الرياض، المملكة العربية السعودية</p>
                    <a class="contact-action" href="https://maps.google.com/?q=Riyadh" target="_blank" rel="noopener">فتح في خرائط جوجل</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>الهاتف</h3>
                    <p>+966 12 345 6789</p>
                    <a class="contact-action" href="tel:+966123456789">Call Now</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>البريد الإلكتروني  </h3>
                    <p>info@legalconsulting.com</p>
                    <a class="contact-action" href="mailto:info@legalconsulting.com">إرسال بريد إلكتروني</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>ساعات العمل</h3>
                    <p>الأحد–الخميس: 9:00 – 18:00</p>
                    <span class="contact-action muted">الجمعة–السبت: مغلق</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="contact-quick row gx-3 gy-3 my-5 align-items-stretch">
            <div class="col-md-4 col-sm-12">
                <a class="quick-link whatsapp" href="https://wa.me/966123456789" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i>
                    <span>الدردشة على واتساب</span>
                </a>
            </div>
            <div class="col-md-4 col-sm-12">
                <a class="quick-link directions" href="https://maps.google.com/?q=Riyadh" target="_blank" rel="noopener">
                    <i class="fas fa-route"></i>
                    <span>الحصول على الاتجاهات</span>
                </a>
            </div>
            <div class="col-md-4 col-sm-12">
                <a class="quick-link calendar" href="#contact-form">
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