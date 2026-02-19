<?php get_header(); ?>
<main>
    <article>
        <h1>404 Not Found</h1>
        <p>ページが見つかりません。お探しのページは移動、もしくは削除された可能性があります。</p>
        <p><a href="<?php echo esc_url(home_url()); ?>">トップページ</a>よりお探し下さい。</p>
    </article>
</main>
<?php get_footer(); ?>