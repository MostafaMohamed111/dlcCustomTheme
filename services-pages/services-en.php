<?php 


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
                
                <p class= "services-head lead ">At Dag Law Firm, we understand that every client’s legal needs are unique.
                    Our services are designed to provide comprehensive legal solutions for both individuals and businesses, in full compliance with Saudi laws and regulatory frameworks.
                </p>

                <p class= "services-head lead ">
                    With over 80 specialized legal services, our experienced team of lawyers and consultants helps clients manage their legal obligations and business operations with clarity, confidence, and compliance.
                </p>


            </div>
            <div class="services-grid">
                <div class="service-card companies">
                    <?php $dlc_companies_img_dims = function_exists('dlc_get_theme_image_dimensions') ? dlc_get_theme_image_dimensions('assets/images/companies.png') : null; ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/companies.png"
                         alt="Corporate Law"
                         <?php if ($dlc_companies_img_dims) : ?>
                             width="<?php echo esc_attr($dlc_companies_img_dims['width']); ?>"
                             height="<?php echo esc_attr($dlc_companies_img_dims['height']); ?>"
                         <?php endif; ?>
                         decoding="async"
                         loading="lazy">
                    <h2 class="text-center">Corporate Legal Services</h2>
                    <p>
                        We provide companies and institutions with comprehensive legal support that promotes business continuity and minimizes regulatory and operational risks.
                    </p>
                    <?php
                    $companies_category = get_category_by_slug('companies-services');
                    $companies_url = $companies_category ? get_category_link($companies_category->term_id) : '#';
                    ?>
                    <a class="service-btn btn" href="<?php echo $companies_url; ?>">Explore Corporate Legal Services</a>
                </div>
                <div class="service-card individuals">
                    <?php $dlc_individuals_img_dims = function_exists('dlc_get_theme_image_dimensions') ? dlc_get_theme_image_dimensions('assets/images/individuals.webp') : null; ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/individuals.webp"
                         alt="Individual Law"
                         <?php if ($dlc_individuals_img_dims) : ?>
                             width="<?php echo esc_attr($dlc_individuals_img_dims['width']); ?>"
                             height="<?php echo esc_attr($dlc_individuals_img_dims['height']); ?>"
                         <?php endif; ?>
                         decoding="async"
                         loading="lazy">
                    <h2 class="text-center">Explore Individual Services</h2>
                    <p>
                        Our individual services are tailored to protect your personal and financial rights across various legal aspects.
                    </p>
                    <?php
                    $individual_category = get_category_by_slug('individual-services');
                    $individual_url = $individual_category ? get_category_link($individual_category->term_id) : '#';
                    ?>
                    <a class="service-btn btn" href="<?php echo $individual_url; ?>">Explore Individual Services</a>
                </div>
            </div>
        </div>


        </div>
    </div>


            <!-- Our Commitment Section -->
        <div class="row commitment-section animate">
            <div class="col-lg-12">
                <h2 class="section-title text-center">Our Commitment <i class="fa-solid fa-certificate"></i></h2>
                <p class="commitment-text">
                    At Dag Law Firm, we are dedicated to delivering precise, reliable, and transparent legal services.
                    We focus on protecting client interests while maintaining the highest standards of professionalism, confidentiality, and compliance with Saudi law.
                </p>
            </div>
        </div>

        <!-- FAQ Section -->
        <section class="faq-section">
            <div class="faq-container">
                <h2 class="faq-title">Frequently Asked Questions – Our Legal Services</h2>
                <p class="faq-subtitle">Find answers to common questions about our legal services</p>
                
                <ul class="faq-list">
                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">What types of legal services does Dag Law Firm provide?</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">Dag offers a full range of legal services for individuals and businesses, including legal consultations, litigation, contract drafting and review, commercial arbitration, company formation, intellectual property protection, and estate management.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">Can I request a legal consultation remotely?</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">Yes. Dag Law Firm provides secure digital consultations for clients inside and outside Saudi Arabia, ensuring privacy and efficient communication.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">Do you offer commercial arbitration services?</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">Yes. Our firm represents clients in arbitration cases and also serves as certified arbitrators in commercial disputes.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">Can foreign companies benefit from your services?</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">Absolutely. Dag Law Firm assists foreign investors in establishing businesses in Saudi Arabia, obtaining licenses, and managing legal compliance for their local operations.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">How does the firm handle client confidentiality?</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">We maintain a strict confidentiality policy, ensuring all client data and documents are handled securely and in accordance with Saudi law and legal ethics.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">Do you draft and review contracts?</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">Yes. Our team specializes in drafting and reviewing all types of contracts to ensure compliance with Saudi regulations and protect your legal interests.</p>
                        </div>
                    </li>

                    <li class="faq-item">
                        <div class="faq-question" role="button" aria-expanded="false">
                            <span class="faq-question-text">How can I start working with Dag Law Firm?</span>
                            <span class="faq-question-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-answer-text">You can contact us via our website or call our official number to schedule an initial consultation and determine the most suitable legal service for your needs.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>            

    
<?php get_footer(); ?>






