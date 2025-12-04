<?php

$company_pdf      = get_field('company_pdf');
$company_pdf_url  = '';

if (is_array($company_pdf) && isset($company_pdf['url'])) {
    $company_pdf_url = $company_pdf['url'];
} elseif (is_string($company_pdf)) {
    $company_pdf_url = $company_pdf;
}

get_header(); ?>

<div class="hero">
        <div class="hero-body ">
            <div class="hero-background-image">

            </div>
            <div class="row   hero-row">
                <div class="col-xl-5 col-md-6 col-sm-8    hero-content">
                    <h1 class="hero-title">Dag <br><span> Law Firm & Consultation </span> </h1>
                    <p class="lead hero-subtitle">owned by Attorney Mohammed Dagestani and headquartered in Riyadh, Saudi Arabia.</p>
                    <div class="hero-actions">
                        <a href="#about-dag" class="btn hero-btn learn-more-btn">Learn More</a>
                        <?php if (!empty($company_pdf_url)) : ?>
                            <a href="<?php echo esc_url($company_pdf_url); ?>" class="btn hero-btn download-btn" target="_blank" rel="noopener">
                                Download PDF<span class=" fa-solid fa-download ps-2 "></span>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="col-xl-5 col-md-6   hero-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mrDag.webp" alt="Mr. Dag" class="ceo-image">

                </div>
            </div>
        </div>
</div>




<section class="about-section">
    <div class="container">
        <div class="about-dag" id="about-dag">
            <h2>About Dag</h2>
            <p class="lead">
                Dag Law Firm for Legal Consultancy, owned by Attorney Mohammed Dagestani and headquartered in Riyadh, Saudi Arabia, specializes in providing over 80 specialized legal services to individuals and businesses across various legal fields.
            </p>

            <div class="paragraph">
                <p>
                    With his extensive experience in the legal profession, <span class="highlight">Mr. Mohammed Daghistani</span> has specialized in multiple business sectors, including the <span class="highlight">commercial sector</span>, the <span class="highlight">industrial and agricultural sectors</span>, and the <span class="highlight">Capital Market Authority</span>.   
                </p>

                <p>
                    <span class="highlight">Dag Law Firm</span> offers its services to all establishments and individuals across all cities in <span class="highlight">Saudi Arabia</span>, the <span class="highlight">Gulf region</span>, and other countries engaged in commercial activities within the <span class="highlight">Kingdom</span> and its legal system.
                </p>

                <p>
                    We are equipped to handle all types of cases, thanks to our diverse and highly experienced legal team, which stays up to date with the latest legal developments and regulatory changes.
                </p>


                <p>
                    Consultant <span class="highlight">Mohammed Daghistani</span> firmly believes that fostering legal awareness within institutions is a crucial preventive measure against disputes. Therefore, <span class="highlight">DLC</span> prioritizes enhancing its clients' legal knowledge. Through his extensive expertise and specialized team, he ensures that businesses receive the necessary legal support to operate smoothly and protect themselves from potential legal risks.
                </p>


            </div>
            

        </div>

    </div>



</section>

<section class="about-mr-dag-section">
    <div class="container">
        <div class="row about-mr-dag-row">
            <div class="content col-lg-7">
                <h2 class="founder-title">
                    About the Founder – Consultant Mohammed Daghistani
                </h2>

                <p>
                    In the ever-evolving business world, having a reliable legal partner is no longer a luxury but a necessity to ensure legal protection and regulatory compliance. With this vision in mind, Consultant <span class="highlight">Mohammed Daghistani</span> founded <span class="highlight">DLC</span> in <span class="highlight">2000</span>, with a clear goal: to provide comprehensive legal solutions that support both businesses and individuals while safeguarding their rights with the highest professional standards.
                </p>
                <p>
                    With over two decades of experience, Consultant <span class="highlight">Mohammed Daghistani</span> has earned numerous specialized certifications in law and legal consultancy, making him one of the leading experts in the field. His strategic vision and innovative legal approach have enabled him to build a distinguished management team capable of delivering integrated legal support to clients, whether in business sectors or within the regulations of the <span class="highlight">Capital Market Authority</span>.

                </p>
            </div>
            <div class="image-container col-lg-5">
                <div class="geometric-background-pattern">
                    <div class="mr-dag-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mrDag.webp" alt="Mr. Dagestani">
                    </div>
                </div>

        </div>
    </div>




</section>
















<section class="mission-section">
    <div class="container">
        <h2 class="mission-title">Our Mission</h2>
        <div class="mission-grid">
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>
                <p class="mission-text">Implementing digital transformation in alignment with Saudi Arabia's Vision 2030.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <p class="mission-text">Utilizing all our legal knowledge and tools to achieve justice and restore rights.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <p class="mission-text">Becoming the trusted legal partner for our clients, always striving to provide them with the best services.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <p class="mission-text">Protecting and safeguarding our clients' legal interests.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-gavel"></i>
                </div>
                <p class="mission-text">Ensuring the preservation and restoration of rights to their rightful owners while efficiently seizing opportunities.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-file-contract"></i>
                </div>
                <p class="mission-text">Legally documenting our clients' rights in accordance with local and applicable laws.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <p class="mission-text">Shielding our clients from penalties and legal disputes.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <p class="mission-text">Enhancing legal awareness among our clients to help them avoid legal challenges.</p>
            </div>
        </div>
    </div>
</section>

<section class="values-section">
    <div class="container">
        <h2 class="values-title">Our Values</h2>
        <div class="values-carousel-wrapper">
            <button class="carousel-btn carousel-btn-prev" id="carouselPrev">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="values-carousel" id="valuesCarousel">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h3 class="value-title">Professionalism and Excellence</h3>
                    <p class="value-description">Ensuring a high level of quality and expertise in all our legal services, delivering exceptional results for our clients.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3 class="value-title">Transparency and Commitment</h3>
                    <p class="value-description">Maintaining open communication and unwavering dedication to our clients' success and legal protection.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="value-title">Our Clients</h3>
                    <p class="value-description">Placing our clients at the heart of everything we do, prioritizing their needs and building lasting relationships.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <h3 class="value-title">Confidentiality and Privacy</h3>
                    <p class="value-description">Safeguarding our clients' interests with utmost dedication, ensuring complete confidentiality and privacy protection.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3 class="value-title">Available to Support</h3>
                    <p class="value-description">Always available to support our clients whenever they need our services, providing timely and reliable assistance.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="value-title">Continuous Development</h3>
                    <p class="value-description">Continuously developing and staying up to date with legal updates in Saudi Arabia to serve our clients better.</p>
                </div>
            </div>
            <button class="carousel-btn carousel-btn-next" id="carouselNext">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
            <div class="carousel-indicators">
                <span class="indicator active" data-slide="0"></span>
                <span class="indicator" data-slide="1"></span>
                <span class="indicator" data-slide="2"></span>
                <span class="indicator" data-slide="3"></span>
                <span class="indicator" data-slide="4"></span>
                <span class="indicator" data-slide="5"></span>
            </div>
        </div>
    </div>
</section>



<section class="vision-section">
    <div class="container">
        <div class="vision-content">
            <h2 class="vision-title">Our Vision</h2>
            <p class="vision-text">
                Leaving our unique mark in the legal field in Saudi Arabia and becoming one of the most prominent legal entities that everyone turns to with confidence in our professionalism, expertise, and commitment to Saudi Vision 2030.
            </p>
        </div>
    </div>
</section>


<?php
$cases_count = (int) get_field('cases');
$contracts_count = (int) get_field('contracts');
$clients_count = (int) get_field('clients');
$intellectual_properties_count = (int) get_field('intellectual_properties');
?>
<section class="achievements-section">
    <div class="container">
        <h2 class="achievements-title">Achievements</h2>
        <p class="achievements-intro">
            Since the inception of Dag Law Firm, providing legal advice, client satisfaction, and meeting their needs has been our compass and our constant goal. Through our work, we have been pleased to be successful partners for a group of prestigious institutions and organizations, and their expression of satisfaction with this distinguished partnership is what we have.
        </p>
        
        <div class="achievements-grid">
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($cases_count); ?>"><?php echo esc_html($cases_count); ?></div>
                <div class="achievement-label">Cases</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($contracts_count); ?>"><?php echo esc_html($contracts_count); ?></div>
                <div class="achievement-label">Contracts</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($clients_count); ?>"><?php echo esc_html($clients_count); ?></div>
                <div class="achievement-label">Clients</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-number" data-target="<?php echo esc_attr($intellectual_properties_count); ?>"><?php echo esc_html($intellectual_properties_count); ?></div>
                <div class="achievement-label">Intellectual Properties</div>
            </div>
        </div>
        
        <p class="achievements-conclusion">
            We are proud of what we have accomplished since the beginning of our journey.
        </p>
    </div>
</section>

<?php get_footer(); ?>

