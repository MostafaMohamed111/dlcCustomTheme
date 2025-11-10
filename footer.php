
        <?php wp_footer(); ?>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/DLC_logo.webp" alt="Dag Law Firm Logo" class="logo-img">
                        <span class="logo-text mx-4">Dag Law Firm</span>
                    </div>
                    <p>Providing exceptional legal services in Riyadh, Saudi Arabia since 2009.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                        <?php if(has_nav_menu('footer-menu')): 
                            
                                wp_nav_menu( 
                                    array(
                                        'theme_location' => 'footer-menu',
                                        'container' => 'div',
                                        'container_class' => 'footer-menu',
                                        'fallback_cb' => false,
                                    ) 
                                );
                            endif;
                            ?>
                </div>
                <div class="footer-section">
                    <h4>Services</h4>
                    <ul>
                        <li><a href="#services">Legal Consultation</a></li>
                        <li><a href="#services">End of Service Calculator</a></li>
                        <li><a href="#services">Inheritance Calculator</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Dag Law Firm & Consultation. All rights reserved.</p>
            </div>
        </div>
    </footer>

    </body>
</html>