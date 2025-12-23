<?php
get_header();

// Get statistics with ACF or fallback to defaults
$cases_count = 0;
$contracts_count = 0;
$clients_count = 0;

if (function_exists('get_field')) {
    $cases_count = (int) get_field('cases');
    $contracts_count = (int) get_field('contracts');
    $clients_count = (int) get_field('clients');
}
?>
<main>

    <!-- Hero Section -->
    <section class="hero">
        <?php $dlc_hero_dims = function_exists('dlc_get_theme_image_dimensions') ? dlc_get_theme_image_dimensions('assets/images/Dag-team.webp') : null; ?>
        <div class="hero-background" aria-hidden="true">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Dag-team.webp"
                 alt=""
                 fetchpriority="high"
                 loading="eager"
                 decoding="async"        >
        </div>
        <div class="hero-content">
            <h1 class="hero-company">Dag 
            <span> Law Firm & Legal Consultations</span></h1>
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
            <div class="section-header no-bg">
                <h2 class="section-title"> About DAG Law Firm</h2>
                <p class="section-subtitle">A Saudi law firm led by Attorney Mohammed Dagistani, based in Riyadh.
 We provide professional legal services in corporate law, endowments, capital markets, and the industrial sector — with a commitment to integrity and precision.
</p>
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
                    <?php $dlc_justice_dims = function_exists('dlc_get_theme_image_dimensions') ? dlc_get_theme_image_dimensions('assets/images/Justice.webp') : null; ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Justice.webp"
                         alt="Blindfolded statue of justice holding scales"
                         class="about-img"
                         loading="lazy"
                         <?php if ($dlc_justice_dims) : ?>
                             width="<?php echo esc_attr($dlc_justice_dims['width']); ?>"
                             height="<?php echo esc_attr($dlc_justice_dims['height']); ?>"
                         <?php endif; ?>
                         decoding="async">
                </div>
            </div>
        </div>
    </section>

    <!-- Parallax Divider -->
    <section class="parallax-divider" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/Riydah.webp');">
        <div class="parallax-overlay"></div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Start Your Legal Services Easily</h2>
                <p class="section-subtitle">We provide smart tools that help you access tailored legal solutions efficiently, under the supervision of licensed lawyers in each field.</p>
            </div>
            <div class="row services-grid justify-content-center ">
                <div class="col-lg-4 col-md-6 col-sm-12  service-card">
                    <div class="card-content">
                        <div class="service-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h3>Labor Calculator</h3>
                        <p> A precise digital tool that helps businesses calculate employee entitlements under Saudi Labor Law.</p>
                        <a href="<?php echo home_url('/services'); ?>" class="service-btn">Learn More</a>
           
                    </div>
                </div>
            
                <div class="col-lg-4 col-md-6 col-sm-12  service-card">
                    <div class="card-content">
                        <div class="service-icon">  
                            <i class="fas fa-comments"></i>
                        </div>
                            <h3>Request a Legal Consultation</h3>
                            <p> Speak directly with a licensed lawyer to evaluate your legal situation and determine the best course of action.</p>
                            <a href="<?php echo home_url('/booking'); ?>" class="service-btn">Learn More</a>  
                    </div>
                    
                </div>
                
                
                
                <div class="col-lg-4 col-md-6 col-sm-12  service-card">
                    <div class="card-content">
                        <div class="service-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h3>Inheritance Calculator</h3>
                        <p> An online service that calculates inheritance shares in accordance with Sharia and Saudi regulations.</p>
                    <a href="<?php echo home_url('/services'); ?>" class="service-btn">Learn More</a>
                </div>
            </div>
        </div>
    </section>


    
    <!-- Accreditations Section -->
    <section id="accreditations" class="accreditations-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Officially Accredited</h2>
                <p class="section-subtitle">DAG Law Firm is proud to be a registered and licensed legal entity recognized by multiple Saudi legal and governmental authorities.</p>
            </div>
        </div>
    </section>

    <!-- Legal Services Section -->
    <section id="legal-services" class="legal-services-section">
        <div class="container">
            <div class="section-header no-bg">
                <h2 class="section-title">Legal Services for Individuals and Companies</h2>
                <p class="section-subtitle">We offer over 80 specialized legal services across commercial, financial, and social sectors, with close and professional case follow-up.</p>
            </div>
            <div class="legal-services-grid">
                <div class="legal-service-card">
                    <div class="legal-card-content">
                        <div class="legal-service-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3>Services for Individuals</h3>
                        <p>Comprehensive legal assistance covering family cases, real estate matters, and personal documentation.</p>
                        <a href="<?php echo esc_url(home_url('/category/individual-services')); ?>" class="legal-service-link">Explore Services <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="legal-service-card">
                    <div class="legal-card-content">
                        <div class="legal-service-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>Services for Companies</h3>
                        <p>From company formation to commercial contract drafting and corporate governance — we help ensure your business complies with Saudi regulations.</p>
                        <a href="<?php echo esc_url(home_url('/category/companies-services')); ?>" class="legal-service-link">Explore Services <i class="fas fa-arrow-right"></i></a>
                    </div>
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

