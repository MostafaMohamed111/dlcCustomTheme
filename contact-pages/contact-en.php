<?php

    get_header();
?>



<div class="container">
    <section class="contact-us">
        <div class="contact-us-content">
            <h1>Contact Us</h1>
            <p class="lead" >At Dag Legal Firm, we're always ready to assist you with professional legal support in all matters related to consultations, contract drafting and commercial disputes</p>
            <p class="lead" >Your message is the first step toward the right legal solution for your needs.</p>

        </div>

        <div class="contact-us-body row d-flex gx-5 justify-content-space-between">
            <form id="contact-form" class="contact-us-form col-lg-6 col-md-12">
                <h2 class="contact-form-title">Contact Form</h2>
                <p class="contact-form-description">Please fill out the form below, and one of our legal advisors will get back to you promptly to discuss your request and provide the appropriate assistance.</p>
                <div id="form-status-message"></div>

                <div class=" name mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                </div>

                <div class="phone mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Your Phone Number" required>
                </div>

                <div class=" email mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" >
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

                 <a class="quick-link calendar" href="<?php echo esc_url(dlc_get_booking_page_url('en')); ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span>Book a Consultation</span>
                </a>
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

    </section>

</div>

<!-- Success Modal -->
<div id="contact-success-modal" class="contact-modal" style="display: none;">
    <div class="contact-modal-overlay"></div>
    <div class="contact-modal-content">
        <div class="contact-modal-header">
            <h2 class="contact-modal-title">Your Request Has Been Sent Successfully <i class="fa-regular fa-circle-check success text-success"></i></h2>
            <button class="contact-modal-close" aria-label="Close modal">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        <div class="contact-modal-body">
            <p class="contact-modal-message">
                Thank you for contacting Dag Legal Firm.<
            </p>
            <p class="contact-modal-message">
                Your message has been successfully received, and one of our legal consultants will reach out to you shortly to review your inquiry and provide suitable legal assistance.
            </p>
            <p class="contact-modal-message">
                We truly appreciate your interest and look forward to serving you soon.
            </p>
            <p class="contact-modal-message">
                Stay connected with us through our official channels for the latest updates and legal insights.
            </p>
        </div>
        <div class="contact-modal-footer">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="contact-modal-link">
                <i class="fa-solid fa-home"></i>
                Back to Home Page
            </a>
            <a href="<?php echo esc_url(dlc_get_services_page_url('en')); ?>" class="contact-modal-link">
                <i class="fa-solid fa-briefcase"></i>
                Explore Our Services
            </a>
        </div>
    </div>
</div>








<?php
    get_footer();
?>