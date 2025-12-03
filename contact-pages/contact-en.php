<?php

    get_header();
?>



<div class="container">
    <section class="contact-us">
        <div class="contact-us-content">
            <h1>Contact Us</h1>
            <p class="lead" >If you have any questions or need further information, please feel free to reach out to us through the following contact details:</p>
        </div>

        <div class="contact-us-body row d-flex gx-5 justify-content-space-between">
            <form id="contact-form" class="contact-us-form col-lg-6 col-md-12">
                <div id="form-status-message"></div>

                <div class=" name mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                </div>
                <div class=" email mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                </div> 
                <div class=" message mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                </div>
                <?php wp_nonce_field( 'contact_form_nonce', 'contact_form_nonce_field' ); ?>

                <button type="submit" class="btn">Submit</button>

            </form>

            <div class="form-image col-lg-6 col-md-12 ">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services.jpg" alt="Contact Us">
            </div>
        </div>
            
       
    </section>        



    <section class="company-info " >
        
        <h2 class="text-center">Contact Details</h2>

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
                    <h3>Office Location</h3>
                    <?php
                    $location_url = get_field('location');
                    if (!$location_url) {
                        $location_url = 'https://maps.google.com/?q=Riyadh';
                    }
                    ?>
                    <a class="contact-action" href="<?php echo esc_url($location_url); ?>" target="_blank" rel="noopener">Open in Google Maps</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>Phone</h3>
                    <p><?php echo $phone ? esc_html($phone) : '+966 12 345 6789'; ?></p>
                    <?php if ($phone) : ?>
                        <a class="contact-action" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">Call Now</a>
                    <?php else : ?>
                        <a class="contact-action" href="tel:+966123456789">Call Now</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p><?php echo $mail ? esc_html($mail) : 'info@legalconsulting.com'; ?></p>
                    <?php if ($mail) : ?>
                        <a class="contact-action" href="mailto:<?php echo esc_attr($mail); ?>">Send Email</a>
                    <?php else : ?>
                        <a class="contact-action" href="mailto:info@legalconsulting.com">Send Email</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Working Hours</h3>
                    <p><?php echo $working_hours ? esc_html($working_hours) : 'Sun–Thu: 9:00 – 18:00'; ?></p>
                    <?php if ($closed) : ?>
                        <span class="contact-action muted"><?php echo esc_html($closed); ?></span>
                    <?php else : ?>
                        <span class="contact-action muted">Fri–Sat: Closed</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="contact-quick row gx-3 gy-3 my-5 align-items-stretch">
            <div class="col-md-6 col-sm-12">
                <a class="quick-link whatsapp" href="https://wa.me/966123456789" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i>
                    <span>Chat on WhatsApp</span>
                </a>
            </div>
            <div class="col-md-6 col-sm-12">
                <a class="quick-link calendar" href="<?php echo esc_url(dlc_get_booking_page_url('en')); ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span>Book a Consultation</span>
                </a>
            </div>
        </div>


    </section>


</div>








<?php
    get_footer();
?>