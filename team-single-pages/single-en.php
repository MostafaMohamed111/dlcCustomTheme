<?php
get_header();
?>

<div class="main">
    <div class="container team-single-container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
        ?>
            <article class="team-member">
                <header class="team-header">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="team-photo">
                            <?php the_post_thumbnail('large', array('class' => 'team-photo-img')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="team-main-info">
                        <h1 class="team-name"><?php the_title(); ?></h1>
                        <?php 
                        // Try ACF position field first, fallback to excerpt
                        $position = get_field('position');
                        if ( empty($position) && has_excerpt() ) {
                            $position = get_the_excerpt();
                        }
                        if ( !empty($position) ) : ?>
                            <p class="team-position"><?php echo esc_html($position); ?></p>
                        <?php endif; ?>
                    </div>
                </header>

                <section class="team-bio">
                    <?php the_content(); ?>
                </section>

                <?php 
                // Display Objective ACF field
                $objective = get_field('objective');
                if ( !empty($objective) ) : ?>
                    <section class="team-objective">
                        <h2 class="team-section-title">
                            <i class="fa-solid fa-bullseye"></i>
                            Objective
                        </h2>
                        <div class="team-section-content">
                            <?php echo wpautop(esc_html($objective)); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <?php 
                // Display Experience ACF field
                $experience = get_field('experience');
                if ( !empty($experience) ) : ?>
                    <section class="team-experience">
                        <h2 class="team-section-title">
                            <i class="fa-solid fa-briefcase"></i>
                            Experience
                        </h2>
                        <div class="team-section-content">
                            <?php echo wpautop(esc_html($experience)); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <?php 
                // Display Education ACF field
                $education = get_field('education');
                if ( !empty($education) ) : ?>
                    <section class="team-education">
                        <h2 class="team-section-title">
                            <i class="fa-solid fa-graduation-cap"></i>
                            Education
                        </h2>
                        <div class="team-section-content">
                            <?php echo wpautop(esc_html($education)); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <?php 
                // Display LinkedIn ACF field
                $linkedin = get_field('linkedin');
                if ( !empty($linkedin) ) : ?>
                    <section class="team-linkedin">
                        <h2 class="team-section-title">
                            <i class="fa-brands fa-linkedin"></i>
                            LinkedIn
                        </h2>
                        <div class="team-section-content">
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="team-linkedin-profile-link">
                                <i class="fa-brands fa-linkedin"></i>
                                View LinkedIn Profile
                            </a>
                        </div>
                    </section>
                <?php endif; ?>
            </article>

            <div class="back-to-team">
                <?php 
                // Get team archive URL
                $team_archive_url = get_post_type_archive_link('team');
                ?>
                <a href="<?php echo esc_url($team_archive_url); ?>" class="back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Team
                </a>
            </div>

        <?php
            endwhile;
        endif;
        ?>
    </div>
</div>

<?php
get_footer();
