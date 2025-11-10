
        <?php wp_footer(); ?>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/DLC_logo.webp" alt="Dag Law Firm Logo" class="logo-img">
                        <span class="logo-text mx-4">شركة داغ
                            للمحاماة و الاستشارات القانونية</span>
                    </div>
                    <p>تقديم خدمات قانونية استثنائية في الرياض، المملكة العربية السعودية منذ عام 2009.</p>
                </div>
                <div class="footer-section">
                    <h4>روابط سريعة</h4>
                    <?php if(has_nav_menu('footer-menu')): 
                            
                                wp_nav_menu( 
                                    array(
                                        'theme_location' => 'primary-ar-menu',
                                        'container' => 'div',
                                        'container_class' => 'footer-menu',
                                        'fallback_cb' => false,
                                    ) 
                                );
                            endif;
                            ?>
                </div>
                <div class="footer-section">
                    <h4>الخدمات</h4>
                    <ul>
                        <li><a href="#services">الاستشارات القانونية</a></li>
                        <li><a href="#services">حاسبة نهاية الخدمة</a></li>
                        <li><a href="#services">حاسبة الميراث</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>تابعنا</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 شركة داغ للمحاماة و الاستشارات القانونية. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    </body>
</html>