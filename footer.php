<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <footer class="footer">
        <p class="footer_title">EDEL WEIN support</p>

        <?php

        // 1. URL判定用の「スラッグリスト」を作成

        $check_slugs = array();

        if (is_front_page()) {
            $check_slugs[] = 'front';
        } elseif (is_home() || (is_archive() && get_post_type() === 'post')) {
            $check_slugs[] = 'news';
        } elseif (is_singular('hotel_detail')) {
            $check_slugs[] = 'hotel'; // ホテル詳細CPTならホテル扱い
        } else {
            // 固定ページやその他の場合
            global $post;
            if (isset($post->ID)) {
                // 自分自身のスラッグ
                $check_slugs[] = get_post_field('post_name', $post->ID);

                // 親ページ（先祖）のスラッグを全て取得して追加
                $ancestors = get_post_ancestors($post->ID);
                if ($ancestors) {
                    foreach ($ancestors as $ancestor_id) {
                        $check_slugs[] = get_post_field('post_name', $ancestor_id);
                    }
                }
            }
            // 投稿タイプアーカイブの場合なども考慮して投稿タイプ名も追加
            $check_slugs[] = get_query_var('post_type');
        }

        // 2. 表示モードの決定
        // 初期設定（デフォルト：本部・会社概要）
        $target_term = 'edelwein-support';
        $view_mode   = 'default';
        $link_url    = home_url('/company/top');
        $btn_text    = '会社概要はこちら';

        // リスト内に特定のキーワードが含まれているかチェック（優先順位順）

        // --- ガラス体験工房 (/glasspage/ を含む場合) ---
        if (in_array('glasspage', $check_slugs, true)) {
            $target_term = 'glass';
            $view_mode   = 'glass';
            $link_url    = home_url('/glasspage');
            $btn_text    = '詳細はこちら';

            // --- レストラン (/restaurantpage/ 等を含む場合) ---
        } elseif (count(array_intersect(['restaurantpage', 'banquet_plan', 'groupmenu'], $check_slugs)) > 0) {
            $target_term = 'restaurant';
            $view_mode   = 'restaurant';
            $link_url    = home_url('/restaurantpage');
            $btn_text    = '詳細はこちら';

            // --- ホテル (// 等を含む場合) ---
        } elseif (in_array('hotel', $check_slugs, true) || is_singular('hotel_detail')) {
            $target_term = 'hotel';
            $view_mode   = 'hotel';
            $link_url    = home_url('/hotel');
            $btn_text    = '詳細はこちら';
        }

        ?>

        <section class="footer_company">
            <?php
            // カスタム投稿「店舗情報」を取得
            $args_main = array(
                'post_type'      => 'footer_company',
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'company_category',
                        'field'    => 'slug',
                        'terms'    => $target_term, // 上記で決定したスラッグで絞り込み
                    ),
                ),
                'posts_per_page' => 1,
            );
            $query_main = new WP_Query($args_main);

            if ($query_main->have_posts()):
                while ($query_main->have_posts()): $query_main->the_post();

                    // 画像・共通フィールド取得
                    $img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    if (!$img_url) {
                        $img_url = get_template_directory_uri() . '/assets/img/footer/edel-wein-support.png';
                    }
                    $store_name = get_field('store_name');
                    $tel        = get_field('tel');
                    $fax        = get_field('fax');
                    $postcode   = get_field('postcode');
                    $address    = get_field('address');

                    // 個別フィールド取得
                    $businesshours  = get_field('businesshours');
                    $regulerholiday = get_field('regulerholiday');
                    $note_glass     = get_field('note');
                    $checkin        = get_field('checkin');
                    $checkout       = get_field('checkout');
            ?>

                    <p class="footer_company_title">◆<?php echo esc_html($store_name); ?></p>
                    <div class="footer_company_content">
                        <div class="footer_company_content_imgdiv">
                            <img class="footer_company_content_imgdiv_img" src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>">
                        </div>

                        <div class="footer_company_content_textdiv">
                            <div class="footer_company_content_textdiv-flex">
                                <div>
                                    <p>TEL</p>
                                    <p>FAX</p>
                                    <p>所在地</p>
                                    <p>&nbsp;</p> <?php if ($view_mode !== 'default'): ?>
                                        <?php if ($view_mode !== 'hotel'): ?>
                                            <p style="height: 1em;"></p>
                                            <p>営業時間</p>
                                            <p>定休日</p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <p><?php echo esc_html($tel); ?></p>
                                    <p><?php echo esc_html($fax); ?></p>
                                    <p>〒<?php echo esc_html($postcode); ?></p>
                                    <p><?php echo esc_html($address); ?></p>

                                    <?php if ($view_mode === 'glass' || $view_mode === 'restaurant'): ?>
                                        <p style="height: 1em;"></p>
                                        <p><?php echo esc_html($businesshours); ?></p>
                                        <p><?php echo esc_html($regulerholiday); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if ($view_mode === 'glass'): ?>
                                <?php if ($note_glass): ?>
                                    <p style="color: red; margin-top: 10px;"><?php echo esc_html($note_glass); ?></p>
                                <?php else: ?>
                                    <p style="color: red; margin-top: 10px;">※体験予約はお電話までお願い致します。</p>
                                <?php endif; ?>

                            <?php elseif ($view_mode === 'hotel'): ?>
                                <div style="margin-top: 15px;">
                                    <p>日帰り入浴施設「ぶどうの湯」</p>
                                    <p>営業時間　<?php echo esc_html($businesshours); ?></p>
                                    <p>チェックイン <?php echo esc_html($checkin); ?></p>
                                    <p>チェックアウト <?php echo esc_html($checkout); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if ($target_term === "edelwein-support"): ?>
                            <a class="footer_company_content_textdiv_button" href="<?php echo esc_url($link_url); ?>">
                                <div>
                                    会社概要へ
                                    <img class="footer_company_content_textdiv_button_img" src="<?php echo get_template_directory_uri(); ?>/assets/img/footer/link_arrow.png" alt="">
                                </div>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php
                endwhile;
                wp_reset_postdata();
            else:
                ?>
                <p style="text-align:center; padding:20px;">
                    店舗情報が見つかりません。<br>
                    管理画面の「店舗情報」にて、カテゴリー「<?php echo esc_html($target_term); ?>」の記事が公開されているか確認してください。
                </p>
            <?php endif; ?>
        </section>

        <section class="footer_map">
            <div class="footer_map_mapdiv">
                <div class="footer_map_mapdiv_text">
                    <img class="footer_map_mapdiv_text_icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/footer/map-icon.png" alt="">
                    <p class="footer_map_mapdiv_text_p">
                        <span class="footer_map_mapdiv_text_span">MAP</span><br>
                        アクセスマップ
                    </p>
                </div>
                <div class="footer_map_mapdiv_map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3079.7866590650383!2d141.27937507437557!3d39.47414811247057!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5f858b7c69cd6787%3A0xdd8938fcb82adc2!2z44Ks44Op44K55L2T6aiT5bel5oi_IOajruOBruOBj-OBqw!5e0!3m2!1sja!2sjp!4v1764309442262!5m2!1sja!2sjp" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <p class="footer_map_text">
                バス停「大迫地域診療センター」／岩手県交通から徒歩約9分<br>
                JR新花巻駅から車で約23分／遠野方面から車で約25分
            </p>
        </section>

        <section class="footer_contact">
            <p class="footer_contact_title">CONTACT</p>
            <div class="footer_contact_content">

                <?php
                // 表示するカテゴリーの順番
                $contact_slugs = ['glass', 'restaurant', 'hotel'];

                foreach ($contact_slugs as $c_slug):
                    $args_contact = array(
                        'post_type'      => 'footer_company',
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'company_category',
                                'field'    => 'slug',
                                'terms'    => $c_slug,
                            ),
                        ),
                        'posts_per_page' => 1,
                    );
                    $query_contact = new WP_Query($args_contact);

                    if ($query_contact->have_posts()):
                        while ($query_contact->have_posts()): $query_contact->the_post();
                            // 値の取得
                            $store_name_c   = get_field('store_name');
                            $tel_c          = get_field('tel');
                            $businesshours_c = get_field('businesshours');

                            // リンク先の決定
                            $contact_link = home_url('/');
                            if ($c_slug === 'glass') $contact_link = home_url('/glasspage/top');
                            if ($c_slug === 'restaurant') $contact_link = home_url('/restaurantpage/top');
                            if ($c_slug === 'hotel') $contact_link = home_url('/hotel');

                            // ホテル専用項目
                            $checkin_c  = get_field('checkin');
                            $checkout_c = get_field('checkout');
                ?>
                            <div class="footer_contact_content_company">
                                <p class="footer_contact_content_company_title">
                                    <?php echo ($c_slug === 'hotel') ? 'ホテル ベルンドルフ' : esc_html($store_name_c); ?>
                                </p>

                                <div class="footer_contact_content_company_detail">
                                    <div>
                                        <p>TEL</p>
                                        <p>営業時間</p>
                                    </div>
                                    <div>
                                        <p><?php echo esc_html($tel_c); ?></p>
                                        <p><?php echo esc_html($businesshours_c); ?></p>

                                        <?php if ($c_slug === 'hotel'): ?>
                                            <div style="margin-top: 5px; font-size: 0.9em;">
                                                <p>チェックイン <?php echo esc_html($checkin_c); ?></p>
                                                <p>チェックアウト <?php echo esc_html($checkout_c); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if ($c_slug === 'glass'): ?>
                                    <p style="font-size: 0.8rem; margin-top: 5px;" class="footer_contact_content_company_glassnote">※体験予約はお電話にてお願い致します。</p>
                                <?php endif; ?>
                                
                                <!-- レストランの場合のみ詳細リンクを表示しない（非表示処理） -->
                                <?php if ($c_slug === 'restaurant'): ?>
                                <?php else: ?>
                                    <a class="footer_contact_content_company_button" href="<?php echo esc_url($contact_link); ?>">詳細はこちら</a>
                                <?php endif; ?>
                                
                            </div>
                <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                endforeach;
                ?>

                <div class="footer_contact_content_company">
                    <p class="footer_contact_content_company_title">ワインシャトー大迫店</p>
                    <div class="footer_contact_content_company_detail">
                        <div>
                            <p>TEL</p>
                            <p>営業時間</p>
                        </div>
                        <div>
                            <p>0198-48-3200</p>
                            <p>9:00～16:30</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- <nav class="footer_nav">
            <ul>
                <li><a href="<?php echo esc_url(home_url('/glasspage/top')); ?>">ガラス体験工房 森のくに</a></li>
                <li><a href="<?php echo esc_url(home_url('/restaurantpage/top')); ?>">レストラン ベルンドルフ</a></li>
                <li><a href="<?php echo esc_url(home_url('/hotel')); ?>">ホテル ベルンドルフ</a></li>
                <li><a href="<?php echo esc_url(home_url('/news')); ?>">お知らせ</a></li>
                <li><a href="<?php echo esc_url(home_url('/company/top')); ?>">会社概要</a></li>
                <li><a href="<?php echo esc_url(home_url('/contactpage')); ?>">お問い合わせ</a></li>
            </ul>
        </nav> -->
        <?php
            wp_nav_menu(
                [
                    'theme_location' => 'footer-menu',
                    'container_class' => 'footer_nav',
                ]
            );
        ?>

        <section class="footer_copyright">
            <p>© EDEL WEIN support. All Rights reserved.</p>
        </section>

        <div id="page_top" class="back-to-top">
            <a href="#">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/footer/pagetop.png" alt="PAGE TOP">
            </a>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>

</html>
