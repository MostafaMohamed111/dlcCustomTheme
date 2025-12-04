<?php

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body>







<div class="box">
    <div class="container">
    <section class="error-page">
        <div class="error-content">
            <div class="error-animation">
                <div class="error-number">
                    <span class="digit">4</span>
                    <span class="digit-middle">0</span>
                    <span class="digit">4</span>
                </div>
            </div>
            
            <h1>Oops! Page Not Found</h1>
            <p class="error-message">The page you're looking for seems to have wandered off. Don't worry, we'll help you find your way back.</p>
            
            <div class="error-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
                    <i class="fas fa-home"></i>
                    Go to Homepage
                </a>
                <a href="javascript:history.back()" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Go Back
                </a>
            </div>
         
            
            <div class="helpful-links">
                <h3>Popular Pages:</h3>
                <div class="links-grid">
                    <a href="<?php echo esc_url(home_url('/services')); ?>" class="link-card">
                        <i class="fas fa-briefcase"></i>
                        <span>Services</span>
                    </a>
                    <a href="<?php echo esc_url(home_url('/about-us')); ?>" class="link-card">
                        <i class="fas fa-info-circle"></i>
                        <span>About Us</span>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="link-card">
                        <i class="fas fa-envelope"></i>
                        <span>Contact</span>
                    </a>
                    <?php
                    $blog_category = get_category_by_slug('blog');
                    if ($blog_category) {
                        $blog_url = get_category_link($blog_category->term_id);
                        echo '<a href="' . esc_url($blog_url) . '" class="link-card">';
                        echo '<i class="fas fa-blog"></i>';
                        echo '<span>Blog</span>';
                        echo '</a>';
                    }
                    
                    $news_category = get_category_by_slug('news');
                    if ($news_category) {
                        $news_url = get_category_link($news_category->term_id);
                        echo '<a href="' . esc_url($news_url) . '" class="link-card">';
                        echo '<i class="fas fa-newspaper"></i>';
                        echo '<span>News</span>';
                        echo '</a>';
                    }
                    ?>
                    <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="link-card">
                        <i class="fas fa-shield-alt"></i>
                        <span>Privacy Policy</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
</div>




<?php wp_footer(); ?>

</body>
</html>