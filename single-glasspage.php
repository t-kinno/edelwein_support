<?php
get_header();

// footer_companyから共通情報を取得
$glass_info = [
    'businesshours' => '',
    'regulerholiday' => '',
    'tel' => '',
    'postcode' => '',
    'address' => '',
];

$args_info = [
    'post_type'      => 'footer_company',
    'tax_query'      => [
        [
            'taxonomy' => 'company_category',
            'field'    => 'slug',
            'terms'    => 'glass',
        ],
    ],
    'posts_per_page' => 1,
];
$query_info = new WP_Query($args_info);
if ($query_info->have_posts()) {
    $query_info->the_post();
    $glass_info['businesshours'] = get_field('businesshours');
    $glass_info['regulerholiday'] = get_field('regulerholiday');
    $glass_info['tel']            = get_field('tel');
    $glass_info['postcode']       = get_field('postcode');
    $glass_info['address']        = get_field('address');
    wp_reset_postdata();
}
?>

<main id="glass">

    <section class="morino-kuni">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/glass/TOP.png" class="morino-kuni-bg" alt="トップ背景">
        <div class="morino-kuni-content">
            <div class="morino-kuni-title">
                <p>ガラス体験工房 森のくに</p>
            </div>
            <div class="morino-kuni-sub">
                <h1>自分で創るきらめく思い出<br>体験してみませんか</h1>
            </div>
        </div>
    </section>

    <p class="morino-kuni-address">
        営業時間：<?php echo esc_html($glass_info['businesshours']); ?>　 定休日：<?php echo esc_html($glass_info['regulerholiday']); ?><br />
        TEL：<a href="tel:<?php echo esc_attr(str_replace('-', '', $glass_info['tel'])); ?>"><?php echo esc_html($glass_info['tel']); ?></a>　 <?php echo esc_html($glass_info['address']); ?>
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
                        'category_name'  => 'glass',
                        'orderby'        => 'date',
                        'order'          => 'DESC'
                    ];
                    $news_query = new WP_Query($news_args);

                    if ($news_query->have_posts()):
                        while ($news_query->have_posts()):
                            $news_query->the_post();
                            $categories = get_the_category();
                            $category_slug = !empty($categories) ? $categories[0]->slug : '';
                            $footer_colors = [
                                'edelwein-support' => '#b8a36c7c',
                                'glass'            => '#C4F6FA',
                                'hotel'            => '#fff71b7a',
                                'restaurant'       => '#c12b7179',
                                'others'           => '#1a535c7c',
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
                                        <?php if (! empty($categories)) echo esc_html($categories[0]->name); ?>
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

    <section class="intro-section">
        <div class="intro-wrapper">
            <div class="intro-left">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/glass/glassWorkshopScene.png" class="intro-img" alt="工房の様子">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/glass/glassTopTtl.png" class="mobile-only-ttl" alt="Glass Top Title">
                <div class="intro-paragraph">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            the_content();
                        endwhile;
                    endif;
                    ?>
                </div>
            </div>
            <div class="right-copy-wrapper">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/glass/marbles3.png" class="glass-ball" alt="">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/glass/character.png" class="copy-text" alt="">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/glass/triangle.png" class="copy-triangle" alt="">
            </div>
        </div>
    </section>

    <a href="https://morinokuni.base.shop/" target="_blank">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/glass/shopping.png" class="shop-banner" alt="ショッピング">
    </a>

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

    <?php
    // ▼ スタイルのリスト定義（投稿順にこれを割り当てます）
    // [見出しクラス, 枠線クラス]
    $style_list = [
        ['blown',                'blownglass'],   // 1番目: 青
        ['sandblast',            'sandblasting'], // 2番目: オレンジ
        ['glass-fusing-heading', 'fusing'],       // 3番目: 緑
        ['tombo-heading',        'tombodama'],    // 4番目: 紫
    ];
    $style_count = count($style_list);
    ?>

    <section class="search-section">
        <h2 class="section-title">体験メニュー</h2>
    </section>

    <?php
    $args_exp = array(
        'post_type'      => 'glass_menu',
        'tax_query'      => array(
            array(
                'taxonomy' => 'glass_category',
                'field'    => 'slug',
                'terms'    => 'experience', // 体験メニュー
            ),
        ),
        'posts_per_page' => -1,
        'orderby'        => 'menu_order', // 管理画面の並び順
        'order'          => 'ASC'
    );
    $query_exp = new WP_Query($args_exp);

    if ($query_exp->have_posts()):
        $i = 0; // カウンター初期化
        while ($query_exp->have_posts()): $query_exp->the_post();

            // カウンターを使ってスタイルを取得（4で割った余りを使うことでループさせる）
            $current_style = $style_list[$i % $style_count];
            $header_class  = $current_style[0];
            $section_class = $current_style[1];
    ?>
            <section class="heading <?php echo esc_attr($header_class); ?>">
                <div class="title-block">
                    <h3 class="title-main"><?php the_title(); ?></h3>
                    <div class="arrow-line">
                        <div class="diamond"></div>
                        <div class="line"></div>
                    </div>
                </div>
            </section>

            <section>
                <div class="<?php echo esc_attr($section_class); ?>">
                    <div class="glass-menu-body">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>

    <?php
            $i++; // カウンターを進める
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

    <section>
        <div class="reservation-notice-wrapper">
            <div class="reservation-content">
                <?php
                $args_notice = array(
                    'post_type'      => 'glass_menu',
                    'name'           => 'reservation-info',
                    'posts_per_page' => 1
                );
                $query_notice = new WP_Query($args_notice);

                if ($query_notice->have_posts()) :
                    while ($query_notice->have_posts()) : $query_notice->the_post();
                        the_content();
                    endwhile;
                    wp_reset_postdata();
                else:
                ?>
                    <p>現在、注意事項はありません。</p>
                <?php endif; ?>
            </div>

            <img class="info-deco-image1" src="<?php echo get_template_directory_uri(); ?>/assets/img/glass/marble2.png" alt="">
        </div>
    </section>

    <section class="search-section">
        <h2 class="section-title">受注生産</h2>
    </section>

    <?php
    $args_order = array(
        'post_type'      => 'glass_menu',
        'tax_query'      => array(
            array(
                'taxonomy' => 'glass_category',
                'field'    => 'slug',
                'terms'    => 'order', // 受注生産
            ),
        ),
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );
    $query_order = new WP_Query($args_order);

    if ($query_order->have_posts()):
        $i = 0; // カウンターリセット（受注生産も1色目からスタート）
        while ($query_order->have_posts()): $query_order->the_post();

            // スタイル割り当てロジック
            $current_style = $style_list[$i % $style_count];
            $header_class  = $current_style[0];
            $section_class = $current_style[1];
    ?>
            <section class="heading <?php echo esc_attr($header_class); ?>">
                <div class="title-block">
                    <h3 class="title-main"><?php the_title(); ?></h3>
                    <div class="arrow-line">
                        <div class="diamond"></div>
                        <div class="line"></div>
                    </div>
                </div>
            </section>

            <section>
                <div class="<?php echo esc_attr($section_class); ?>">
                    <div class="glass-menu-body">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>

    <?php
            $i++;
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

    <img class="info-deco-image2" src="<?php echo get_template_directory_uri(); ?>/assets/img/glass/marbles.png" alt="">

</main>

<?php get_footer(); ?>
