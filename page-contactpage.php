<?php
/*
Template Name: お問い合わせ
*/
get_header();
?>

<main id="contact">
    <section class="contact-header">
        <h1 class="main__ttl">お問い合わせ</h1>
    </section>

    <div class="contact-container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
    
    <div class="recaptcha-info">
        This site is protected by reCAPTCHA and the Google
        <a href="https://policies.google.com/privacy">Privacy Policy</a> and
        <a href="https://policies.google.com/terms">Terms of Service</a> apply.
    </div>
</main>

<?php get_footer(); ?>
