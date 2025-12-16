
<?php get_template_part('includes/map-section'); ?>
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
                    $menu_location = dlc_get_menu_location('footer');
                    if ( has_nav_menu( $menu_location ) ) {
                        wp_nav_menu(
                            array(
                                'theme_location' => $menu_location,
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
                    <a href="<?php echo esc_url(dlc_get_booking_page_url('ar')); ?>" class="btn nav-btn get-in-touch me-2">احجز الآن</a>
                    <div class="sign-in-dropdown">
                        <button class="btn nav-btn sign-in sign-in-toggle footer-sign-in" type="button">
                            تسجيل الدخول
                            <i class="fa-solid fa-chevron-down ms-1 dropdown-chevron"></i>
                        </button>
                        <div class="sign-in-menu">
                            <a href="https://portals.dlc.com.sa/admin/authentication" class="sign-in-option">
                                <i class="fa-solid fa-user-tie"></i>
                                موظف
                            </a>
                            <a href="https://portals.dlc.com.sa/authentication/login" class="sign-in-option">
                                <i class="fa-solid fa-user"></i>
                                عميل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="row footer-bottom gy-3 align-items-center">
            <div class="col-12 text-center">
                <small class="footer-copy">   جميع الحقوق محفوظة شركة داغ للمحاماة والاستشارات القانونية &copy; <?php echo date('Y'); ?>    </small>
                <div class="footer-developer-credit">
                    <small>Website developed by <a href="https://mostafa-elbebany.netlify.app/" target="_blank" rel="noopener noreferrer">Elbebany</a></small>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center align-items-center gap-3">
                <button type="button" class="footer-to-top-icon" aria-label="Back to top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">
                    <i class="fas fa-arrow-up"></i>
                </button>
            </div>
        </div>
    </div>
</footer>
<?php 
get_template_part('includes/whatsapp-floating-action');
wp_footer(); ?>


</body>
</html>