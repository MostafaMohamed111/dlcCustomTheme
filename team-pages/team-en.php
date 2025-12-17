<?php
get_header();
?>

<main class="team-archive-wrapper">
    <header class="page-header">
        <h1>Our Team – DAG Law Firm</h1>
        <p class="page-subtitle">Professional Legal Experts Serving International and Local Clients</p>
        <div class="team-intro">
            <p>At DAG Law Firm, our team consists of highly qualified legal professionals with extensive experience in Saudi law, international business, intellectual property, investment, and corporate legal services.</p>
            <p>Our goal is to provide accurate, reliable, and professional legal guidance to both local and international clients, ensuring compliance with Saudi regulations and best legal practices.</p>
        </div>
    </header>

    <section class="team-section-title">
        <h2>Meet Our Team</h2>
    </section>

    <?php if ( have_posts() ) : 
        $post_count = $wp_query->found_posts;
        $show_carousel = ($post_count > 3);
    ?>
        <section class="team-carousel-wrapper<?php echo !$show_carousel ? ' no-carousel' : ''; ?>">
            <?php if ($show_carousel) : ?>
            <button class="team-carousel-prev" aria-label="Previous team member">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <?php endif; ?>
            
            <div class="team-carousel-container">
                <div class="team-carousel-track">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article class="team-card">
                            <a href="<?php the_permalink(); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="team-card-image">
                                        <?php the_post_thumbnail('medium', array('class' => 'team-card-img')); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="team-card-body">
                                    <h2 class="team-card-name"><?php the_title(); ?></h2>

                                    <?php 
                                    // Display Objective ACF field (full text, no excerpt)
                                    $objective = function_exists('get_field') ? get_field('objective') : '';
                                    if ( !empty($objective) ) : ?>
                                        <p class="team-card-objective"><?php echo esc_html($objective); ?></p>
                                    <?php endif; ?>

                                    <?php 
                                    // Try ACF position field first, fallback to excerpt
                                    $position = function_exists('get_field') ? get_field('position') : '';
                                    if ( empty($position) && has_excerpt() ) {
                                        $position = get_the_excerpt();
                                    }
                                    if ( !empty($position) ) : ?>
                                        <p class="team-card-position"><?php echo esc_html($position); ?></p>
                                    <?php endif; ?>

                                    <span class="team-card-link">Read more →</span>

                                    <?php 
                                    // Display LinkedIn if URL exists
                                    $linkedin = function_exists('get_field') ? get_field('linkedin') : '';
                                    if ( !empty($linkedin) ) : ?>
                                        <div class="team-card-linkedin">
                                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="team-linkedin-link">
                                                <span><i class="fa-brands fa-linkedin-in"></i></i></span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <?php if ($show_carousel) : ?>
            <button class="team-carousel-next" aria-label="Next team member">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
            
            <div class="team-carousel-indicators"></div>
            <?php endif; ?>
        </section>
    <?php else : ?>
        <div class="no-team-members">
            <p>No team members found.</p>
        </div>
    <?php endif; ?>

    <!-- Why Choose Our Team Section -->
    <section class="team-why-choose">
        <h2>Why Choose Our Team?</h2>
        <div class="why-choose-grid">
            <div class="why-choose-item">
                <div class="why-choose-icon">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <h3>Expertise Across Legal Fields</h3>
                <p>Our team covers over 80 legal services, from corporate law to intellectual property and investment.</p>
            </div>
            <div class="why-choose-item">
                <div class="why-choose-icon">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <h3>Professional Experience</h3>
                <p>Each member brings extensive experience in Saudi law and international business.</p>
            </div>
            <div class="why-choose-item">
                <div class="why-choose-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3>Client-Focused Approach</h3>
                <p>We provide tailored solutions while maintaining confidentiality and compliance.</p>
            </div>
            <div class="why-choose-item">
                <div class="why-choose-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <h3>Continuous Legal Development</h3>
                <p>Our team stays updated on the latest regulations and legal frameworks in Saudi Arabia.</p>
            </div>
        </div>
    </section>

    <!-- Achievements Section -->
    <section class="team-achievements">
        <h2>Achievements & Recognition</h2>
        <div class="achievements-list">
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <p>Successfully assisted hundreds of clients, including multinational corporations and foreign investors</p>
            </div>
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fa-solid fa-gavel"></i>
                </div>
                <p>Managed complex litigation, regulatory filings, and corporate transactions</p>
            </div>
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fa-solid fa-star"></i>
                </div>
                <p>Recognized for professionalism, reliability, and practical legal guidance</p>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
