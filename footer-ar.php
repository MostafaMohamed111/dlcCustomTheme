
<footer class="site-footer">
    <div class="container">
        <div class="row footer-top  gy-4">
            <div class="col-md-3 footer-brand text-center ">
                <a href="<?php echo home_url(); ?>" class="footer-logo d-inline-flex align-items-center gap-2">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/DLC_logo.webp" alt="Dag Law Firm And Consultation Logo">
                    <span class="fw-semibold">شركة داغ للمحاماة والاستشارات القانونية</span>
                </a>
                <p class="footer-tagline mb-0">الخبرة القانونية بلمسة إنسانية.</p>
            </div>
            <div class="col-md-6 footer-nav text-center">
                <?php
                    if ( has_nav_menu( 'primary-menu' ) ) {
                        wp_nav_menu(
                            array(
                                'theme_location' => 'primary-ar-menu',
                                'container'      => 'nav',
                                'container_class'=> 'footer-menu',
                                'menu_class'     => 'list-unstyled d-flex flex-wrap justify-content-center gap-3 mb-0',
                                'depth'          => 1,
                            )
                        );
                    }
                ?>
            </div>
            <div class="col-md-3 footer-actions text-center ">
                <h6 class="footer-action-title mb-2">انضم إلى مجتمعنا</h6>
                <div class="footer-buttons ">
                    <button class="btn nav-btn get-in-touch me-2">تواصل معنا</button>
                    <button class="btn nav-btn sign-in footer-sign-in" type="button">تسجيل الدخول</button>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="row footer-bottom gy-3 align-items-center">
            <div class="col-12 text-center">
                <small class="footer-copy">&copy; <?php echo date('Y'); ?>   القانون والاستشارات. جميع الحقوق محفوظة شركة داغ للمحاماة والاستشارات القانونية</small>
            </div>
            <div class="col-12 d-flex justify-content-center align-items-center gap-3">
                <button type="button" class="footer-to-top-icon" aria-label="Back to top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">
                    <i class="fas fa-arrow-up"></i>
                </button>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>


</body>
</html>