<?php
$company_pdf      = function_exists('get_field') ? get_field('company_pdf') : '';
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
                    <?php $dlc_mrdag_dims = function_exists('dlc_get_theme_image_dimensions') ? dlc_get_theme_image_dimensions('assets/images/mrDag.webp') : null; ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mrDag.webp"
                         alt="Mr. Dag"
                         class="ceo-image"
                   
                         decoding="async"
                         loading="lazy">

                </div>
            </div>
        </div>
</div>




<section class="about-section">
    <div class="container">
        <div class="about-dag" id="about-dag">
            <h2>About Dag</h2>


            <div class="paragraph">

                <p >
                    Learn more about Dag Legal Firm, founded by attorney Mohammed Dagistani in Riyadh, Saudi Arabia. A trusted Saudi law firm offering over 80 legal and consultancy services for individuals and companies with professional excellence and deep legal expertise.
                </p>

                <p>Dag Legal Firm, founded by attorney Mohammed Dagistani and based in Riyadh, Saudi Arabia, is a licensed law firm specializing in providing comprehensive legal and consultancy services for individuals and businesses across the Kingdom.
                    The firm’s foundation is built on professional integrity, accuracy, and strict compliance with Saudi legal systems and regulations.
                </p>
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
Founded in 2000, Dag Legal Firm reflects the vision of Mohammed Dagistani, who aimed to establish a practice built on professionalism, consistency, and trust.
 Throughout his career, he has gained extensive experience across commercial, industrial, and agricultural sectors, and provided advisory services to entities connected with the Capital Market Authority.
 His expertise has positioned Dag Legal Firm as a recognized and reliable legal partner for numerous local and international clients.
                </p>
                <p>
                    With over two decades of experience, Consultant Mohammed Daghistani has earned numerous specialized certifications in law and legal consultancy, making him one of the leading experts in the field. His strategic vision and innovative legal approach have enabled him to build a distinguished management team capable of delivering integrated legal support to clients, whether in business sectors or within the regulations of the Capital Market Authority</span>.

                </p>
            </div>
            <div class="image-container col-lg-5">
                <div class="geometric-background-pattern">
                    <div class="mr-dag-image">
                        <?php $dlc_mrdag_dims = function_exists('dlc_get_theme_image_dimensions') ? dlc_get_theme_image_dimensions('assets/images/mrDag.webp') : null; ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mrDag.webp"
                             alt="Mr. Dagestani"
                      
                             decoding="async"
                             loading="lazy">
                    </div>
                </div>

        </div>
    </div>


</section>

<!-- Who We Are Section -->
<section class="who-we-are-section">
    <div class="container">
        <div class="who-we-are-content">
            <div class="who-we-are-header">
                <h2 class="who-we-are-title">Who We Are</h2>
                <div class="title-underline"></div>
            </div>
            <p class="who-we-are-text">
                Dag Legal Firm delivers full-spectrum legal services led by Attorney Mohammed Dagistani, who brings over 20 years of professional experience in legal consultation, litigation, arbitration, and contract drafting. Our firm offers more than 80 specialized legal services tailored to meet the diverse needs of clients, ensuring clarity, compliance, and effective legal solutions.
            </p>
        </div>
    </div>
</section>

<!-- CTA to Our Team Section -->
<section class="team-cta-section">
    <div class="container">
        <div class="team-cta-wrapper">
            <div class="team-cta-content">
                <div class="team-cta-icon">
                    <i class="fa-solid fa-users-line"></i>
                </div>
                <h2 class="team-cta-title">Meet Our Expert Legal Team</h2>
                <p class="team-cta-description">
                    Discover the dedicated professionals behind DAG Law Firm. Our experienced lawyers and consultants are ready to provide you with exceptional legal services.
                </p>
                <a href="<?php echo esc_url(get_post_type_archive_link('team')); ?>" class="team-cta-button">
                    <span>View Our Team</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            <div class="team-cta-visual">
                <div class="team-cta-decoration"></div>
            </div>
        </div>
    </div>
</section>

<section class="mission-section">
    <div class="container">
        <h2 class="mission-title">Our Mission</h2>
        <p class="mission-description">
            To provide precise, efficient, and transparent legal solutions rooted in a deep understanding of Saudi laws and ongoing regulatory updates — enabling our clients to operate confidently and remain fully compliant with national legislation.
        </p>
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
To be recognized as a trusted and leading Saudi law firm, advancing the practice of law through digital transformation in line with Saudi Vision 2030 and setting new standards in professional legal service delivery.
            </p>
        </div>
    </div>
</section>


<?php
$cases_count = 0;
$contracts_count = 0;
$clients_count = 0;
$intellectual_properties_count = 0;

if (function_exists('get_field')) {
    $cases_count = (int) get_field('cases');
    $contracts_count = (int) get_field('contracts');
    $clients_count = (int) get_field('clients');
    $intellectual_properties_count = (int) get_field('intellectual_properties');
}
?>
<section class="achievements-section">
    <div class="container">
        <h2 class="achievements-title">Achievements</h2>
        <p class="achievements-intro">
Since its establishment, Dag Legal Firm has built a strong professional track record based on quality, trust, and performance.
 The firm has successfully represented hundreds of clients across Saudi Arabia and the Gulf, providing exceptional services in contract drafting, litigation, and intellectual property protection.
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

<!-- Our Objectives Section -->
<section class="objectives-section">
    <div class="container">
        <h2 class="objectives-title">Our Objectives</h2>
        <div class="objectives-list">
            <div class="objective-item">
                <div class="objective-icon">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>
                <p class="objective-text">Supporting digital transformation in the legal sector under Saudi Vision 2030.</p>
            </div>
            <div class="objective-item">
                <div class="objective-icon">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <p class="objective-text">Empowering individuals and businesses to understand their legal rights and obligations.</p>
            </div>
            <div class="objective-item">
                <div class="objective-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <p class="objective-text">Protecting clients' interests and minimizing risks and disputes.</p>
            </div>
            <div class="objective-item">
                <div class="objective-icon">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <p class="objective-text">Documenting and securing rights in full compliance with local laws.</p>
            </div>
            <div class="objective-item">
                <div class="objective-icon">
                    <i class="fa-solid fa-hands-helping"></i>
                </div>
                <p class="objective-text">Providing integrated legal advisory services with precision and reliability.</p>
            </div>
        </div>
    </div>
</section>


<!-- Book Consultation Section -->
<section class="consultation-cta-section">
    <div class="container">
        <div class="consultation-cta-wrapper">
            <div class="consultation-cta-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <h2 class="consultation-cta-title">Book a Legal Consultation</h2>
            <p class="consultation-cta-description">
                Dag Legal Firm offers flexible consultation options, ensuring clients receive timely and tailored legal assistance based on their needs.
            </p>
            <a href="<?php echo esc_url(home_url('/booking')); ?>" class="consultation-cta-button">
                <span>Request Legal Consultation</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>

