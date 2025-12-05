<?php
get_header();
?>

<main class="team-archive-wrapper">
    <header class="page-header">
        <h1>فريق العمل – داغ للمحاماة والاستشارات القانونية</h1>
        <p class="page-subtitle">خبراء قانونيون متخصصون يخدمون العملاء المحليين والدوليين</p>
        <div class="team-intro">
            <p>يتكون فريق داغ للمحاماة من محامين ومستشارين قانونيين مؤهلين، يتمتعون بخبرة واسعة في القانون السعودي، القانون التجاري، الملكية الفكرية، الاستثمار، والخدمات القانونية للشركات.</p>
            <p>يهدف الفريق إلى تقديم استشارات قانونية دقيقة وموثوقة للعملاء المحليين والدوليين، مع ضمان الالتزام بالأنظمة السعودية وأفضل الممارسات القانونية.</p>
        </div>
    </header>

    <section class="team-section-title">
        <h2>تعرف على فريقنا</h2>
    </section>

    <?php if ( have_posts() ) : 
        $post_count = $wp_query->found_posts;
        $show_carousel = ($post_count > 3);
    ?>
        <section class="team-carousel-wrapper<?php echo !$show_carousel ? ' no-carousel' : ''; ?>">
            <?php if ($show_carousel) : ?>
            <button class="team-carousel-prev" aria-label="عضو الفريق السابق">
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
                                    $objective = get_field('objective');
                                    if ( !empty($objective) ) : ?>
                                        <p class="team-card-objective"><?php echo esc_html($objective); ?></p>
                                    <?php endif; ?>

                                    <?php 
                                    // Try ACF position field first, fallback to excerpt
                                    $position = get_field('position');
                                    if ( empty($position) && has_excerpt() ) {
                                        $position = get_the_excerpt();
                                    }
                                    if ( !empty($position) ) : ?>
                                        <p class="team-card-position"><?php echo esc_html($position); ?></p>
                                    <?php endif; ?>

                                    <span class="team-card-link">← اقرأ المزيد</span>

                                    <?php 
                                    // Display LinkedIn if URL exists
                                    $linkedin = get_field('linkedin');
                                    if ( !empty($linkedin) ) : ?>
                                        <div class="team-card-linkedin">
                                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="team-linkedin-link">
                                                <span><i class="fa-brands fa-linkedin-in"></i></span>
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
            <button class="team-carousel-next" aria-label="عضو الفريق التالي">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
            
            <div class="team-carousel-indicators"></div>
            <?php endif; ?>
        </section>
    <?php else : ?>
        <div class="no-team-members">
            <p>لم يتم العثور على أعضاء الفريق.</p>
        </div>
    <?php endif; ?>

    <!-- Why Choose Our Team Section -->
    <section class="team-why-choose">
        <h2>لماذا تختار فريقنا؟</h2>
        <div class="why-choose-grid">
            <div class="why-choose-item">
                <div class="why-choose-icon">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <h3>خبرة في مختلف المجالات القانونية</h3>
                <p>يشمل فريقنا أكثر من 80 خدمة قانونية متخصصة، من القانون التجاري إلى الملكية الفكرية والاستثمار.</p>
            </div>
            <div class="why-choose-item">
                <div class="why-choose-icon">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <h3>خبرة عملية متقدمة</h3>
                <p>كل عضو بالفريق يمتلك خبرة واسعة في القانون السعودي والأعمال الدولية.</p>
            </div>
            <div class="why-choose-item">
                <div class="why-choose-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3>نهج يركز على العميل</h3>
                <p>تقديم حلول قانونية مخصصة مع الحفاظ على السرية والامتثال للنظام.</p>
            </div>
            <div class="why-choose-item">
                <div class="why-choose-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <h3>تطوير قانوني مستمر</h3>
                <p>متابعة أحدث اللوائح والتعديلات القانونية في المملكة.</p>
            </div>
        </div>
    </section>

    <!-- Achievements Section -->
    <section class="team-achievements">
        <h2>إنجازات الفريق</h2>
        <div class="achievements-list">
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <p>تقديم الدعم القانوني لمئات العملاء، بما في ذلك الشركات متعددة الجنسيات والمستثمرين الدوليين</p>
            </div>
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fa-solid fa-gavel"></i>
                </div>
                <p>إدارة القضايا المعقدة، الملفات التنظيمية، والمعاملات التجارية بنجاح</p>
            </div>
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fa-solid fa-star"></i>
                </div>
                <p>التقدير المهني بسبب الاحترافية والدقة في تقديم الاستشارات القانونية العملية</p>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
