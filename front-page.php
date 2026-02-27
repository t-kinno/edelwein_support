<?php get_header(); ?>

<?php
// footer_companyから共通情報を取得（トップページ用）
$top_info = [
    'postcode' => '',
    'address'  => '',
];

// デフォルトの店舗情報を取得（edelwein-supportまたは最初の1件）
$args_info = [
    'post_type'      => 'footer_company',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'ASC'
];
$query_info = new WP_Query($args_info);
if ($query_info->have_posts()) {
    $query_info->the_post();
    $top_info['postcode'] = get_field('postcode');
    $top_info['address']  = get_field('address');
    wp_reset_postdata();
}
?>

<main class="page">
    <section class="morino-kuni">
        <div class="morino-kuni-content">
            <div class="morino-kuni-title">
                <h1>EDEL WEIN support</h1>
            </div>

            <div class="morino-kuni-link">
                <a href="<?php echo esc_url(home_url('/glasspage/top')); ?>">ガラス体験工房 森のくに</a>
                <!-- <a href="<?php echo esc_url(home_url('/restaurantpage/top')); ?>">レストラン ベルンドルフ</a> -->
                <a href="<?php echo esc_url(home_url('/hotel')); ?>">ホテル ベルンドルフ</a>
            </div>
        </div>
    </section>

    <p class="morino-kuni-address">
        所在地：<?php if ($top_info['postcode']) : ?>〒<?php echo esc_html($top_info['postcode']); ?>　 <?php endif; ?><?php echo esc_html($top_info['address']); ?>
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
                    $sub_args = [
                        'post_type'      => 'post',
                        'posts_per_page' => 4,
                    ];
                    $sub_query = new WP_Query($sub_args);

                    if ($sub_query->have_posts()):
                        while ($sub_query->have_posts()):
                            $sub_query->the_post();
                    ?>
                            <?php
                            $categories = get_the_category();
                            $category_slug = !empty($categories) ? $categories[0]->slug : '';
                            $footer_colors = [
                                'edelwein-support' => '#b8a36c7c',
                                'glass' => '#C4F6FA',
                                'hotel' => '#fff71b7a',
                                'restaurant' => '#c12b7179',
                                'others' => '#1a535c7c',
                            ];
                            $footer_color = isset($footer_colors[$category_slug]) ? $footer_colors[$category_slug] : '#333333';
                            ?>
                            <a href="<?php the_permalink(); ?>" class="news-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium'); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/top/noimage.png" alt="No Image">
                                <?php endif; ?>

                                <div class="news-card-content">
                                    <h3><?php the_title(); ?></h3>
                                    <p>
                                        <?php
                                        if (! empty($categories)) {
                                            echo esc_html($categories[0]->name);
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="news-card-footer" style="background-color: <?php echo esc_attr($footer_color); ?>;"></div>
                            </a>
                        <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                        ?>
                        <p>現在、最新情報はありません。</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <div id="grape">
        <img class="grape__img grape__img--fruit" src="<?php echo get_template_directory_uri(); ?>/assets/img/index/grapes.png" alt="">
    </div>

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
        <h2 class="section-title">目的で探す</h2>

        <div class="purpose">
            <div class="purpose__contents">

                <div class="purpose__item purpose__item--glass">
                    <a class="purpose__link" href="<?php echo esc_url(home_url('/glasspage/top')); ?>">
                        <img class="purpose__image_glass" src="<?php echo get_template_directory_uri(); ?>/assets/img/index/creation.png" alt="創作体験">
                    </a>
                    <a class="purpose__label" href="<?php echo esc_url(home_url('/glasspage/top')); ?>">ガラス体験工房 森のくに</a>
                </div>
                <div class="purpose__item purpose__item--restaurant">
                    <a class="purpose__link" style="pointer-events: none;" href="<?php echo esc_url(home_url('/restaurantpage/top')); ?>">
                        <img class="purpose__image_restaurant" src="<?php echo get_template_directory_uri(); ?>/assets/img/index/meal.png" alt="レストラン">
                    </a>
                    <a class="purpose__label" style="pointer-events: none;" href="<?php echo esc_url(home_url('/restaurantpage/top')); ?>">レストラン ベルンドルフ</a>
                </div>

                <div class="purpose__item purpose__item--hotel">
                    <a class="purpose__link" href="<?php echo esc_url(home_url('/hotel')); ?>">
                        <img class="purpose__image purpose_image_hotel" src="<?php echo get_template_directory_uri(); ?>/assets/img/index/stay.png" alt="ホテル">
                    </a>
                    <a class="purpose__label" href="<?php echo esc_url(home_url('/hotel')); ?>">ホテル ベルンドルフ</a>
                </div>

            </div>
        </div>
    </section>

    <section class="frame-group">
        <div class="frame frame--bottom-left">
            <div class="frame__line frame__line--1"></div>
            <div class="frame__line frame__line--2"></div>
        </div>

        <div class="frame frame--bottom-right">
            <div class="frame__line frame__line--3"></div>
            <div class="frame__line frame__line--4"></div>
        </div>
    </section>

    <section class="insta-section">
        <div class="insta-wrapper">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </section>


    <div class="grape">
        <img class="grape__img grape__img--fruit" src="<?php echo get_template_directory_uri(); ?>/assets/img/index/grapes.png" alt="">
        <img class="grape__img grape__img--leaf" src="<?php echo get_template_directory_uri(); ?>/assets/img/index/grapeLeaves.png" alt="">
    </div>

</main>


<?php get_footer(); ?>
