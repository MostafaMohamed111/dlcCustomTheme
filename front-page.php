<?php

get_header();

?>
<main>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-background" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/Riydah.jpg');"></div>
        <div class="hero-content">
            <h1 class="hero-company">Dag</h1>
            <h2 class="hero-title">Law Firm & Legal Consultations</h2>
            <p class="hero-subtitle">A Digital Legal Platform For Accurate Solutions</p>
            <div class="hero-buttons">
                <button class="btn-primary">Get Started</button>
                <button class="btn-secondary">Learn More</button>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Who We Are</h2>
                <p class="section-subtitle"></p>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <h3>Excellence in Legal Services</h3>
                    <p>Dag Law Firm & Consultation is a leading legal practice based in Riyadh, Saudi Arabia. We provide comprehensive legal services and consultations to individuals and businesses across the Kingdom.</p>
                    <p>Our team of experienced lawyers and legal consultants is dedicated to delivering accurate, timely, and effective legal solutions tailored to your specific needs.</p>
                    <div class="about-stats">
                        <div class="stat-item">
                            <h4>500+</h4>
                            <p>Cases Resolved</p>
                        </div>
                        <div class="stat-item">
                            <h4>15+</h4>
                            <p>Years Experience</p>
                        </div>
                        <div class="stat-item">
                            <h4>50+</h4>
                            <p>Expert Lawyers</p>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Justice.webp" alt="Justice" class="about-img">
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
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Request a Consultation</h3>
                    <p>Get expert legal advice from our experienced team of lawyers. Schedule a consultation to discuss your legal matters.</p>
                    <button class="service-btn">Learn More</button>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3>Calculate End of Service Gratuity</h3>
                    <p>Use our advanced calculator to determine your end of service gratuity according to Saudi labor law.</p>
                    <button class="service-btn">Calculate Now</button>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3>Calculate Your Inheritance</h3>
                    <p>Calculate inheritance shares according to Islamic Sharia law and Saudi regulations with our specialized tool.</p>
                    <button class="service-btn">Calculate Now</button>
                </div>
            </div>
        </div>
    </section>



</main>
<?php
    get_footer();
?>
