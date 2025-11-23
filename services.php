<?php 
/*  
Template Name: Services Page
*/


 get_header(); ?>


    <div class="hero">
        <div class="hero-background"></div>
        <div class="hero-content">
            <h1 class="hero-company">What We <span>Offer</span></h1>
            <h2 class="hero-title">Comprehensive Legal Solutions</h2>
            <p class="hero-subtitle">Explore our range of legal services designed to meet your needs.</p>
        </div>
    </div>


    <div class="container">
        <div class="row services   ">
            <div class="col-lg-12 text-center">
                
                <p class= "services-head lead ">At Dag Law Firm & Consultation, we offer a wide range of legal services tailored to both corporate clients and individuals. Our experienced team is dedicated to providing accurate and effective legal solutions.</p>
            </div>
            <div class="companies col-lg-6 col-md-12">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/companies.png" alt="Corporate Law">
                <h2 class = "text-center">Corporate Law</h2>
                <p>Our corporate law services include company formation, mergers and acquisitions, compliance, and corporate governance. We help businesses navigate complex legal landscapes to ensure smooth operations.</p>
                <?php
                $companies_category = get_category_by_slug('companies-services');
                $companies_url = $companies_category ? get_category_link($companies_category->term_id) : '#';
                ?>
                <a class="service-btn btn" href="<?php echo $companies_url; ?>">Get Started</a>

            </div>
            <div class="individuals col-lg-6 col-md-12">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/individuals.webp" alt="Individual Law">
                <h2 class = "text-center">Individual Law</h2>
                <p>Our individual law services include family law, estate planning, personal injury, and criminal defense. We provide personalized legal support to help individuals navigate their unique legal challenges.</p>
                <?php
                $individual_category = get_category_by_slug('individual-services');
                $individual_url = $individual_category ? get_category_link($individual_category->term_id) : '#';
                ?>
                <a class="service-btn btn" href="<?php echo $individual_url; ?>" >Get Started</a>

            </div>
        </div>            

        </div>
    </div>
    
<?php get_footer(); ?>






