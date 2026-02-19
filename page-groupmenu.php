<?php get_header(); ?>
<main id="groupmenu">
    <section class="frame-group">
        <div class="frame frame--top-left">
            <div class="frame__line frame__line--1"></div>
            <div class="frame__line frame__line--2"></div>
        </div>

        <div class="frame frame--top-right">
            <div class="frame__line frame__line--3"></div>
            <div class="frame__line frame__line--4"></div>
        </div>
    </section>

    <section class="search-section">
        <h2 class="section-title">団体様ご予約ランチメニュー</h2>
    </section>
    <a href="<?php echo home_url('/restaurantpage/top'); ?>" id="restaurant-top-link">＜ レストラン ベルンドルフ トップへ</a>

    <section class="menu-wrapper">
        <div class="menu-contents">
            <div class="right-gold-line"></div>
            <div id="frame-line-1"></div>
            <div id="frame-line-2"></div>

            <div class="menu-row">
                <?php
                // CPT「group_menu_item」を取得
                $args = array(
                    'post_type'      => 'group_menu_item', // スラッグ
                    'posts_per_page' => -1,                // 全件
                    'orderby'        => 'menu_order',      // 「属性」の順序を使用
                    'order'          => 'ASC'              // 小さい順 (1 -> 2 -> 3)
                );
                $the_query = new WP_Query($args);

                if ($the_query->have_posts()):
                    while ($the_query->have_posts()): $the_query->the_post();

                        // ■標準機能から取得
                        $title = get_the_title(); // タイトル
                        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // アイキャッチ画像

                        // ■ACFから取得
                        $price = get_field('menu_price');
                        $sub_note = get_field('menu_sub_note');
                        $desc = get_field('menu_desc');
                ?>
                        <div class="menu-item">
                            <div class="menu-title-row">
                                <p class="menu-title"><?php echo esc_html($title); ?></p>

                                <?php if ($price): ?>
                                    <p class="price"><?php echo esc_html($price); ?></p>
                                <?php endif; ?>

                                <?php if ($sub_note): ?>
                                    <p class="title-note"><?php echo esc_html($sub_note); ?></p>
                                <?php endif; ?>
                            </div>

                            <p class="menu-desc">
                                <?php echo nl2br(esc_html($desc)); ?>
                            </p>

                            <?php if ($img_url): ?>
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>">
                            <?php else: ?>
                            <?php endif; ?>
                        </div>

                    <?php
                    endwhile;
                    wp_reset_postdata(); // ★重要：ここで投稿データをリセットして固定ページに戻す
                else:
                    ?>
                    <p class="no-menu" style="width:100%; text-align:center;">現在メニューの準備中です。</p>
                <?php endif; ?>
            </div>

            <?php if (get_field('menu_box_footer_text')): ?>
                <p class="menu-note">
                    <?php echo nl2br(esc_html(get_field('menu_box_footer_text'))); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>

    <section>
        <div class="menu-notice">
            <?php
            $notice = get_field('reservation_notice');
            if ($notice):
                echo $notice;

            endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>