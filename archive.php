<!-- 固定ページ -->
<?php get_header(); ?>

<main id="archive">
    <div class="title">
        お知らせ一覧
    </div>

    <div class="filter">
        <button type="submit" name="all" class="is-on">すべて</button>
        <button type="submit" name="restaurant">レストラン ベルンドルフ</button>
        <button type="submit" name="glass">ガラス体験工房 森のくに</button>
        <button type="submit" name="jotel">ホテル ベルンドルフ</button>
        <button type="submit" name="support">エーデルワインサポート</button>
    </div>
    <h1>
        <?php
        // 月別アーカイブかどうかを判定する
        if (is_month()) {
            // echo get_the_date('Y年m月のアーカイブ');
        } else {
            // カテゴリ-タグのアーカイブタイトルを表示する
            // single_term_title();
        }

        ?>
    </h1>
    <div class="article-boxs">
        <?php
        // 記事が存在するかどうかチェック
        if (have_posts()) :
            // メインループ（記事を取り出すための処理）
            while (have_posts()):
                // 記事の情報を取得する（タイトルや内容などを取り出す）
                the_post();
        ?>
                <article>
                    <div class="under-color">
                        <div class="article-box">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/restaurant/restaurant.png" alt="画像" class="article-img">
                            <h2 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="article-info">
                                <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="article-time"><?php echo get_the_date('Y-m-d'); ?></time>
                                <p class="category"><?php the_category(' '); ?></p>
                            </div>

                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <hr>
    <hr>


    <!-- ページネーション -->
    <div class="pagination">
        <a href="#">&laquo;</a>
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">&raquo;</a>
    </div>
</main>

<?php get_footer(); ?>