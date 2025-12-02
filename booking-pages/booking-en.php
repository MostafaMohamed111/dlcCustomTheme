<?php 

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body>

<div class="row page">
    <div class="image-sector col-lg-6">
        <?php
        // Get ACF fields
        $phone = get_field('phone');
        $facebook = get_field('facebook');
        $instagram = get_field('instagram');
        $linkedin = get_field('linkedin');
        $twitter = get_field('twitter');
        $snapchat = get_field('snapchat');
        $whatsapp = get_field('whatsapp');
        ?>
        
        <div class="logo">
            <a href="<?php echo esc_url(home_url()); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/booking-logo.png" alt="Dag Law Firm Logo">
            </a>
        </div>

        <div class="gif">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/booking.gif" alt="Booking Illustration">
        </div>

        <div class="phone">
            <h2>Call Us Now</h2>
            <div class="phone-number">
                <?php if ($phone) : 
                    $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
                ?>
                    <a href="tel:<?php echo esc_attr($phone_clean); ?>">
                        <i class="fas fa-phone-alt"></i><?php echo esc_html($phone); ?>
                    </a>
                <?php else : ?>
                    <a href="tel:+966570277277">
                        <i class="fas fa-phone-alt"></i>0570 277 277
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="social-media">
            <h3>Social Media Platform</h3>
            <div class="social-icons">
                <?php if ($facebook) : ?>
                    <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                <?php endif; ?>
                
                <?php if ($instagram) : ?>
                    <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" class="social-icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                <?php endif; ?>
                
                <?php if ($linkedin) : ?>
                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                <?php endif; ?>
                
                <?php if ($twitter) : ?>
                    <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener" class="social-icon">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                <?php endif; ?>
                
                <?php if ($snapchat) : ?>
                    <a href="<?php echo esc_url($snapchat); ?>" target="_blank" rel="noopener" class="social-icon">
                        <i class="fab fa-snapchat"></i>
                    </a>
                <?php endif; ?>
                
                <?php if ($whatsapp) : ?>
                    <a href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener" class="social-icon">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="form-sector col-lg-6">
        <!-- Language Switcher -->
        <div class="booking-language-switcher">
            <?php
            $switcher = dlc_get_polylang_switcher();
            if ($switcher) :
                // Determine target language and labels
                $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'en';
                $target_lang = ($current_lang === 'ar') ? 'en' : 'ar';
                $label = ($target_lang === 'ar') ? 'العربية' : 'English';
                $title = ($target_lang === 'ar') ? 'Switch to Arabic' : 'Switch to English';
            ?>
            <a href="<?php echo esc_url($switcher['url']); ?>" class="language-switch-btn" title="<?php echo esc_attr($title); ?>">
                <i class="fa-solid fa-globe"></i>
                <span><?php echo esc_html($label); ?></span>
            </a>
            <?php endif; ?>
        </div>
        
        <!-- Service Type Selection -->
        <div id="service-type-selection" class="booking-step active">
            <h1>What are you looking for?</h1>
            <div class="service-type-options">
                <button type="button" class="service-type-btn" data-type="companies">
                    <i class="fa-solid fa-building"></i>
                    <span>Companies Services</span>
                </button>
                <button type="button" class="service-type-btn" data-type="individual">
                    <i class="fa-solid fa-user"></i>
                    <span>Individual Services</span>
                </button>
                <button type="button" class="service-type-btn" data-type="international">
                    <i class="fa-solid fa-globe"></i>
                    <span>International Services</span>
                </button>
            </div>
        </div>

        <!-- Booking Form -->
        <div id="booking-form-container" class="booking-step">
            <div class="form-header">
                <h1>Consultation Booking Information</h1>
            </div>

            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step-item active" data-step="1">
                    <div class="step-number">1</div>
                    <div class="step-label">Personal info</div>
                </div>
                <div class="step-item" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-label">Consultation info</div>
                </div>
                <div class="step-item" data-step="3">
                    <div class="step-number">3</div>
                    <div class="step-label">Submit</div>
                </div>
            </div>

            <form id="booking-form" method="POST">
                <input type="hidden" name="service_type" id="service_type" value="">
                <input type="hidden" name="security" value="<?php echo wp_create_nonce('booking_form_nonce'); ?>">

                <!-- Phase 1: Personal Info -->
                <div class="form-phase active" data-phase="1">
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" placeholder="Phone Number" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" placeholder="City" value="Riyadh">
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-prev" onclick="goBackToServiceSelection()">Previous</button>
                        <button type="button" class="btn btn-next" onclick="nextPhase()">Next</button>
                    </div>
                </div>

                <!-- Phase 2: Consultation Info -->
                <div class="form-phase" data-phase="2">
                    <div class="form-group">
                        <label for="service">Service *</label>
                        <select id="service" name="service" required>
                            <option value="">Select a service</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="case_brief">Brief about your case *</label>
                        <textarea id="case_brief" name="case_brief" rows="5" placeholder="Please provide a brief description of your case" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Do you have documents to support the issue? *</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="has_documents" value="yes" required>
                                <span>Yes</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="has_documents" value="no" required>
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Have you ever dealt with a lawyer before in the same case? *</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="previous_lawyer" value="yes" required>
                                <span>Yes</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="previous_lawyer" value="no" required>
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-prev" onclick="prevPhase()">Previous</button>
                        <button type="button" class="btn btn-next" onclick="nextPhase()">Next</button>
                    </div>
                </div>

                <!-- Phase 3: Venue -->
                <div class="form-phase" data-phase="3">
                    <div class="form-group">
                        <label>Select meeting type *</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="meeting_type" value="online" required>
                                <span>Online</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="meeting_type" value="offline" required>
                                <span>Offline</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-note">
                        <i class="fa-solid fa-info-circle"></i>
                        <p>Note: You will receive an email with the closest available booking time as soon as we review your request.</p>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-prev" onclick="prevPhase()">Previous</button>
                        <button type="submit" class="btn btn-submit">Submit Your Booking</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Success Message -->
        <div id="success-message" class="booking-step">
            <div class="success-content">
                <i class="fa-solid fa-check-circle"></i>
                <h2>Thanks for submission</h2>
                <p>We will be contacting you as soon as possible.</p>
                <p class="success-note">You can confirm the reservation by contacting us on WhatsApp or calling us directly through our number.</p>
                <a href="<?php echo home_url(); ?>" class="btn btn-home">Go to Home Page</a>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>