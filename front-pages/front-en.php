<?php


get_header();
$cases_count = (int) get_field('cases');
$contracts_count = (int) get_field('contracts');
$clients_count = (int) get_field('clients');
?>
<main>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-background" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/Riydah.jpg');"></div>
        <div class="hero-content">
            <h1 class="hero-company">Dag</h1>
            <h2 class="hero-title">Law Firm & Legal Consultations</h2>
            <p class="hero-subtitle">A Digital Legal Platform For Accurate Solutions</p>
            <div class="hero-buttons" aria-label="Primary actions">
                <a href="<?php echo esc_url(home_url('/booking')); ?>" class="btn-primary">Book Now <i class="fas fa-calendar-check"></i> </a>
                <a href="<?php echo home_url('/about-us'); ?>" class="btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Who We Are</h2>
                <p class="section-subtitle">A Riyadh-based legal collective delivering measurable impact across the Kingdom.</p>
            </div>
            <div class="row about-content align-items-center overflow-hidden ">
                <div class="col-lg-6 col-md-12  about-text">
                    <h3>Excellence in Legal Services</h3>
                    <p>Dag Law Firm & Consultation is a leading legal practice based in Riyadh, Saudi Arabia. We provide comprehensive legal services and consultations to individuals and businesses across the Kingdom.</p>
                    <p>Our team of experienced lawyers and legal consultants is dedicated to delivering accurate, timely, and effective legal solutions tailored to your specific needs.</p>
                  <div class="row about-stats">
                        <div class="col-md-3 col-sm-6 col-12 stat-item">
                        <div class="static-item-inner">
                            <h4 data-target="<?php echo esc_attr($cases_count); ?>"><?php echo esc_html($cases_count); ?></h4>
                            <p>Cases Resolved</p>    

                        </div>    
                        
                        </div>
                        <div class="col-md-3 col-sm-6 col-12 stat-item">
                        <div class="static-item-inner">    
                            <h4 data-target="<?php echo esc_attr($contracts_count); ?>"><?php echo esc_html($contracts_count); ?></h4>
                            <p>Contracts Drafted</p>
                        </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12 stat-item">
                        <div class="static-item-inner">
                            <h4 data-target="<?php echo esc_attr($clients_count); ?>"><?php echo esc_html($clients_count); ?></h4>
                            <p>Clients Advised</p>
                        </div>    
                       
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 about-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Justice.webp" alt="Blindfolded statue of justice holding scales" class="about-img" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Parallax Divider -->
    <section class="parallax-divider" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/Services.jpg');">
        <div class="parallax-overlay"></div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our Services</h2>
                <p class="section-subtitle"></p>
            </div>
            <div class="row services-grid justify-content-center ">
                <div class="col-lg-4 col-md-6 col-sm-12  service-card">
                    <div class="card-content">
                        <div class="service-icon">  
                            <i class="fas fa-comments"></i>
                        </div>
                            <h3>Request a Consultation</h3>
                            <p>Get expert legal advice from our experienced team of lawyers. Schedule a consultation to discuss your legal matters.</p>
                            <a href="<?php echo home_url('/booking'); ?>" class="service-btn">Learn More</a>  
                    </div>
                    
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12  service-card">
                    <div class="card-content">
                        <div class="service-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h3>Calculate End of Service Gratuity</h3>
                        <p>Calculate your end of service gratuity according to Saudi labor law using our advanced calculator with Dag.</p>
                        <a href="<?php echo home_url('/services'); ?>" class="service-btn">Learn More</a>
           
                    </div>
                         </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12  service-card">
                    <div class="card-content">
                        <div class="service-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h3>Calculate Your Inheritance</h3>
                        <p>Calculate inheritance shares according to Islamic Sharia law and Saudi regulations with our specialized tool.</p>
                    <a href="<?php echo home_url('/services'); ?>" class="service-btn">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Certificates Section -->
    <?php get_template_part('includes/certificates'); ?>
    <?php get_template_part('includes/clients'); ?>

</main>
<?php
    get_footer();
?>

