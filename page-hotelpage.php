<?php
/*
Template Name: Hotel Top Page
*/
get_header();

// ▼ 1. 店舗情報（footer_company）から共通情報を取得
$hotel_info = [
    'checkin'       => '',
    'checkout'      => '',
    'bath_hours'    => '', // businesshoursフィールドを使用
    'tel'           => '',
    'curfew'        => '', // ※footer_companyに「curfew」フィールドを追加してください
];

$args_info = [
    'post_type'      => 'footer_company',
    'tax_query'      => [
        [
            'taxonomy' => 'company_category',
            'field'    => 'slug',
            'terms'    => 'hotel',
        ],
    ],
    'posts_per_page' => 1,
];
$query_info = new WP_Query($args_info);
if ($query_info->have_posts()) {
    $query_info->the_post();
    $hotel_info['checkin']    = get_field('checkin');
    $hotel_info['checkout']   = get_field('checkout');
    $hotel_info['bath_hours'] = get_field('businesshours');
    $hotel_info['tel']        = get_field('tel');
    $hotel_info['curfew']     = get_field('curfew');
    wp_reset_postdata();
}
?>

<main id="hotel">
    <section class="morino-kuni">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel/hotelHeaderBackground.png" class="morino-kuni-bg" alt="ホテル背景" />

        <div class="morino-kuni-content">
            <div class="morino-kuni-title">
                <p>ホテル ベルンドルフ</p>
            </div>
            <div class="morino-kuni-sub">
                <h1>癒しと安らぎの楽園</h1>
            </div>
        </div>
    </section>

    <p class="morino-kuni-address">
        チェックイン：<?php echo esc_html($hotel_info['checkin']); ?>　チェックアウト：<?php echo esc_html($hotel_info['checkout']); ?>　ホテル玄関門限：<?php echo esc_html($hotel_info['curfew']); ?><br />
        ぶどうの湯 営業時間：<?php echo esc_html($hotel_info['bath_hours']); ?><br />
        TEL：<a href="tel:<?php echo esc_attr(str_replace('-', '', $hotel_info['tel'])); ?>"><?php echo esc_html($hotel_info['tel']); ?></a>　岩手県花巻市大迫町 11-34-6
    </p>

    <div class="section-line" aria-hidden="true"></div>

    <section class="news-wrapper">
        <div class="news-box">
            <div class="news-left">
                <h2 class="news-title">最新情報</h2>
                <a href="<?php echo esc_url(home_url('/news')); ?>" class="news-btn">一覧を見る ></a>
            </div>

            <div class="news-right">
                <div class="news-list">
                    <?php
                    $news_args = [
                        'post_type'      => 'post',
                        'posts_per_page' => 4,
                        'category_name'  => 'hotel',
                        'orderby'        => 'date',
                        'order'          => 'DESC'
                    ];
                    $news_query = new WP_Query($news_args);
                    if ($news_query->have_posts()) :
                        while ($news_query->have_posts()) : $news_query->the_post();
                            $categories = get_the_category();
                            $category_slug = !empty($categories) ? $categories[0]->slug : '';
                            $footer_colors = ['hotel' => '#fff71b7a'];
                            $footer_color = isset($footer_colors[$category_slug]) ? $footer_colors[$category_slug] : '#fff71b7a';
                    ?>
                            <a href="<?php the_permalink(); ?>" class="news-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium'); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/top/noimage.png" alt="No Image">
                                <?php endif; ?>
                                <div class="news-card-content">
                                    <h3><?php the_title(); ?></h3>
                                    <p>ホテル ベルンドルフ</p>
                                </div>
                                <div class="news-card-footer" style="background-color: <?php echo esc_attr($footer_color); ?>;"></div>
                            </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </section>

    <section class="intro-section">
        <div class="intro-wrapper">
            <div class="intro-left">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel/hotelExterior.png" class="intro-img" alt="ホテル外観" />
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel/hotelTopTtl.png" class="mobile-only-ttl" alt="Hotel Top Title">
                <div class="intro-paragraph">
                    <?php echo wp_kses_post(get_field('top_intro_text')); ?>
                </div>
            </div>
            <div class="right-copy-wrapper">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel/bucket.png" class="glass-ball" alt="" />
                <div class="intro__lead-bg"></div>
                <p class="intro__lead">心も体も癒される<br>観光　ビジネス<br>レジャーの楽園</p>
            </div>
        </div>
    </section>

    <section class="banner">
        <a href="#large_bath" class="banner__link">
            <picture>
                <source media="(max-width: 768px)" srcset="<?php echo get_template_directory_uri(); ?>/assets/img/hotel/budounoyuBanner.png">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel/budonoyuBannerBackground.png" alt="ぶどうの湯バナー背景" class="banner__img">
            </picture>
            <span class="banner__txt">大浴場ぶどうの湯はこちら</span>
        </a>
    </section>

    <section class="menu">
        <h2 class="menu__ttl">メニュー</h2>
        <?php
        $args_plan = [
            'post_type'      => 'hotel_plan',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC'
        ];
        $query_plan = new WP_Query($args_plan);

        if ($query_plan->have_posts()) :
            while ($query_plan->have_posts()) : $query_plan->the_post();

                // 画像取得（10個のフィールドから有効なものを配列化）
                $images = [];
                for ($i = 1; $i <= 10; $i++) {
                    $img = get_field('room_image_' . $i);
                    if ($img) $images[] = $img;
                }

                $price_top = get_field('price_top');
                $anchor_id = get_field('anchor_id');
                $detail_link = home_url('/hotel_detail') . '/#' . esc_attr($anchor_id);
        ?>
                <article class="menu__rooms">
                    <div class="room__ttl">
                        <h3 class="room__ttl-text"><?php the_title(); ?></h3>
                    </div>
                    <div class="room__imgs">
                        <?php if (!empty($images)) : ?>
                            <?php if (isset($images[0])) : ?>
                                <img src="<?php echo esc_url($images[0]['url']); ?>" alt="<?php echo esc_attr($images[0]['alt']); ?>" class="room__img1">
                            <?php endif; ?>

                            <div class="room__img-small">
                                <?php if (isset($images[1])) : ?>
                                    <img src="<?php echo esc_url($images[1]['url']); ?>" alt="<?php echo esc_attr($images[1]['alt']); ?>" class="room__img2">
                                <?php endif; ?>
                                <?php if (isset($images[2])) : ?>
                                    <img src="<?php echo esc_url($images[2]['url']); ?>" alt="<?php echo esc_attr($images[2]['alt']); ?>" class="room__img3">
                                <?php endif; ?>

                                <div class="room__info">
                                    <p class="room__price"><?php echo esc_html($price_top); ?></p>
                                    <a href="<?php echo esc_url($detail_link); ?>" class="room__detail--link">詳細はこちら　＞</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>

        <aside>
            <h2 class="hidden">ご利用案内</h2>
            <div class="menu__guide">
                <div class="guide__content">
                    <div class="guide__left">
                        <?php echo wp_kses_post(get_field('guide_meal_text')); ?>
                    </div>
                    <div class="guide__right">
                        <div class="guide__list">
                            <?php echo wp_kses_post(get_field('guide_cancel_text')); ?>
                        </div>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel/bed.png" alt="ベッド" class="guide__deco">
                    </div>
                </div>
            </div>
        </aside>
    </section>

    <section class="amenities">
        <h2 class="amenities__ttl">アメニティ</h2>
        <div class="amenities__gallery">
            <?php
            // 最初の3枚のみ表示
            $amenity_images = [];
            for ($i = 1; $i <= 10; $i++) {
                $am_img = get_field('amenity_image_' . $i);
                if ($am_img) {
                    // ACF画像フィールドが配列形式の場合
                    if (is_array($am_img)) {
                        $amenity_images[] = $am_img;
                    }
                    // ACF画像フィールドがID形式の場合
                    elseif (is_numeric($am_img)) {
                        $img_array = wp_get_attachment_image_src($am_img, 'full');
                        if ($img_array) {
                            $amenity_images[] = [
                                'url' => $img_array[0],
                                'alt' => get_post_meta($am_img, '_wp_attachment_image_alt', true) ?: ''
                            ];
                        }
                    }
                    // ACF画像フィールドがURL文字列の場合
                    elseif (is_string($am_img)) {
                        $amenity_images[] = [
                            'url' => $am_img,
                            'alt' => ''
                        ];
                    }
                    if (count($amenity_images) >= 3) break; // 3枚で終了
                }
            }
            if (!empty($amenity_images)) :
                foreach ($amenity_images as $am_img) :
            ?>
                    <div><img src="<?php echo esc_url($am_img['url']); ?>" alt="<?php echo esc_attr($am_img['alt'] ?? ''); ?>"></div>
            <?php
                endforeach;
            endif;
            ?>
        </div>

        <table class="amenities__table">
            <caption hidden>アメニティ一覧</caption>
            <tr>
                <th class="amenities__th">シングルルーム・ツインルーム備品</th>
                <td class="amenities__td">
                    <?php echo wp_kses_post(get_field('amenity_general_list')); ?>
                </td>
            </tr>
            <tr>
                <th class="amenities__th">コテージ備品</th>
                <td class="amenities__td">
                    <?php echo wp_kses_post(get_field('amenity_cottage_list')); ?>
                </td>
            </tr>
            <tr>
                <th class="amenities__th">ペットアメニティ（洋室コテージ専用）</th>
                <td class="amenities__td">
                    <?php echo wp_kses_post(get_field('amenity_pet_list')); ?>
                </td>
            </tr>
        </table>
    </section>

    <section id="large_bath">
        <h2 class="large_bath__ttl">大浴場</h2>
        <div class="budonoyu__ttl">
            <h3 class="budonoyu__ttl--text">ぶどうの湯</h3>
        </div>
        <div class="budonoyu__wrapper">
            <?php
            // 大浴場画像（bath_image_1 〜 3）
            $bath_img1 = get_field('bath_image_1');
            $bath_img2 = get_field('bath_image_2');
            $bath_img3 = get_field('bath_image_3');
            ?>

            <?php if ($bath_img1): ?>
                <img src="<?php echo esc_url($bath_img1['url']); ?>" alt="大浴場1" class="budonoyu__img1">
            <?php endif; ?>

            <aside class="budonoyu__right">
                <div class="budonoyu_desc">
                    <?php echo wp_kses_post(get_field('bath_description')); ?>
                </div>

                <?php if ($bath_img2): ?>
                    <img src="<?php echo esc_url($bath_img2['url']); ?>" alt="大浴場2" class="budonoyu__img2">
                <?php endif; ?>

                <?php if ($bath_img3): ?>
                    <img src="<?php echo esc_url($bath_img3['url']); ?>" alt="大浴場3" class="budonoyu__img3">
                <?php endif; ?>
            </aside>
        </div>
    </section>
</main>

<?php get_footer(); ?>
