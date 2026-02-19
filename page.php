<?php get_header(); ?>
<main>
    <?php
    if (have_posts()) :

        while (have_posts()) :

            the_post();
    ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div>
                    <h1><?php the_title(); ?></h1>

                    <?php if (has_post_thumbnail()): ?>
                        <div class="content-EyeCatch">

                            <?php the_post_thumbnail('page_eyecatch'); ?>
                        </div>
                    <?php endif; ?>
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
    <?php get_sidebar(); ?>
</main>
<?php get_footer(); ?>