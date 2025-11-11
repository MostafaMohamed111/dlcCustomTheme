<?php
/*
Template Name: Contact Us
*/
    get_header();
?>



<div class="container">
    <section class="contact-us">
        <div class="contact-us-content">
            <h1>Contact Us</h1>
            <p class="lead" >If you have any questions or need further information, please feel free to reach out to us through the following contact details:</p>
        </div>

        <div class="contact-us-body row d-flex gx-5 justify-content-space-between">
            <form id="contact-form" class="contact-us-form col-lg-6 col-md-12" action="#" method="get">
                <div class=" name mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Your Name">
                </div>
                <div class=" email mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Your Email">
                </div> 
                <div class=" message mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" rows="5" placeholder="Your Message"></textarea>
                </div>
            
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
            <div class=" col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Office Location</h3>
                    <p>123 Legal St., Riyadh, Saudi Arabia</p>
                    <a class="contact-action" href="https://maps.google.com/?q=Riyadh" target="_blank" rel="noopener">Open in Google Maps</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>Phone</h3>
                    <p>+966 12 345 6789</p>
                    <a class="contact-action" href="tel:+966123456789">Call Now</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>info@legalconsulting.com</p>
                    <a class="contact-action" href="mailto:info@legalconsulting.com">Send Email</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Working Hours</h3>
                    <p>Sun–Thu: 9:00 – 18:00</p>
                    <span class="contact-action muted">Fri–Sat: Closed</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="contact-quick row gx-3 gy-3 my-5 align-items-stretch">
            <div class="col-md-4 col-sm-12">
                <a class="quick-link whatsapp" href="https://wa.me/966123456789" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i>
                    <span>Chat on WhatsApp</span>
                </a>
            </div>
            <div class="col-md-4 col-sm-12">
                <a class="quick-link directions" href="https://maps.google.com/?q=Riyadh" target="_blank" rel="noopener">
                    <i class="fas fa-route"></i>
                    <span>Get Directions</span>
                </a>
            </div>
            <div class="col-md-4 col-sm-12">
                <a class="quick-link calendar" href="#contact-form">
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