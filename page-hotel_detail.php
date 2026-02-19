<?php
/*
Template Name: Hotel Detail Page
*/
get_header();

// 店舗情報（footer_company）から共通情報を取得（Aside用）
$hotel_info = [
    'checkin'    => '',
    'checkout'   => '',
];
$args_info = [
    'post_type'      => 'footer_company',
    'tax_query'      => [['taxonomy' => 'company_category', 'field' => 'slug', 'terms' => 'hotel']],
    'posts_per_page' => 1,
];
$query_info = new WP_Query($args_info);
if ($query_info->have_posts()) {
    $query_info->the_post();
    $hotel_info['checkin']  = get_field('checkin');
    $hotel_info['checkout'] = get_field('checkout');
    wp_reset_postdata();
}
?>

<main id="hotel_detail">
    <h1 class="hotel_detail__ttl">ホテル室内詳細</h1>
    <a href="<?php echo esc_url(home_url('/hotel')); ?>" class="hotel_detail_ttl--text">＜ ホテル ベルンドルフ トップへ</a>

    <div class="room_detail">
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
                $anchor_id    = get_field('anchor_id');
                $price_detail = get_field('price_detail');
                $amenity_list = get_field('room_amenity_list');
                $amenity_note = get_field('room_amenity_note');
                $is_cottage   = get_field('is_cottage');
                $pet_amenity  = get_field('pet_amenity_list');

                // 画像取得（10個のフィールドから有効なものを配列化）
                $images = [];
                for ($i = 1; $i <= 10; $i++) {
                    $img = get_field('room_image_' . $i);
                    if ($img) $images[] = $img;
                }
        ?>
                <article class="room_detail__card" id="<?php echo esc_attr($anchor_id); ?>">
                    <h2 class="card__ttl"><?php the_title(); ?></h2>

                    <div class="room__gallery">
                        <?php if (!empty($images)) : foreach ($images as $img) : ?>
                                <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
                        <?php endforeach;
                        endif; ?>
                    </div>

                    <table class="card__table">
                        <tr>
                            <th class="table__th">料金</th>
                            <td class="table__td">
                                <?php echo wp_kses_post($price_detail); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="table__th"><?php echo $is_cottage ? 'コテージ備品' : 'アメニティ'; ?></th>
                            <td class="table__td">
                                <div class="ul_grid">
                                    <?php echo wp_kses_post($amenity_list); ?>
                                </div>
                                <?php if ($amenity_note): ?>
                                    <p><?php echo nl2br(esc_html($amenity_note)); ?></p>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php if ($pet_amenity): ?>
                            <tr>
                                <th class="table__th">ペットアメニティ</th>
                                <td class="table__td">
                                    <div class="ul_grid">
                                        <?php echo wp_kses_post($pet_amenity); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </article>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

    <aside class="aside">
        <h2 class="aside__ttl">共通</h2>
        <table class="card__table">
            <caption class="hidden">宿泊に関する共通案内</caption>
            <tr>
                <th class="table__th">チェックイン<br>チェックアウト</th>
                <td class="table__td">
                    <dl>
                        <dt>チェックイン</dt>
                        <dd><?php echo esc_html($hotel_info['checkin']); ?></dd>
                        <dt>チェックアウト</dt>
                        <dd><?php echo esc_html($hotel_info['checkout']); ?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <th class="table__th">その他</th>
                <td class="table__td">
                    <?php echo wp_kses_post(get_field('common_other_info')); ?>
                </td>
            </tr>
        </table>
    </aside>
</main>

<?php get_footer(); ?>