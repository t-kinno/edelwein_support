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
    <header class="header">
        <h1><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/edelwein.svg" alt="<?php bloginfo('name'); ?>"></a></h1>
        <nav class="nav">
            <a href="<?php echo esc_url(home_url('/glasspage/top')); ?>">ガラス体験工房<br>森のくに</a>
            <a href="<?php echo esc_url(home_url('/restaurantpage/top')); ?>">レストラン<br>ベルンドルフ</a>
            <a href="<?php echo esc_url(home_url('/hotel')); ?>">ホテル<br>ベルンドルフ</a>
            <a href="<?php echo esc_url(home_url('/news')); ?>">お知らせ</a>
            <a href="<?php echo esc_url(home_url('/contactpage')); ?>">お問い合わせ</a>
        </nav>

        <!-- スマホ用ハンバーガーメニュー -->
        <div class="hamburger" id="hamburger">
            <button class="hamburger__button" type="button" aria-label="メニュー">
                <span class="hamburger__line hamburger__line--top"></span>
                <span class="hamburger__line hamburger__line--middle"></span>
                <span class="hamburger__line hamburger__line--bottom"></span>
            </button>

            <nav class="hamburger__menu">
                <div class="hamburger__header">
                    <span class="hamburger__title">Menu</span>
                </div>

                <ul class="hamburger__list">
                    <li class="hamburger__item">
                        <a class="hamburger__link" href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
                    </li>
                    <li class="hamburger__item">
                        <a class="hamburger__link" href="<?php echo esc_url(home_url('/glasspage/top')); ?>">ガラス体験工房 森のくに</a>
                    </li>
                    <li class="hamburger__item">
                        <a class="hamburger__link" href="<?php echo esc_url(home_url('/restaurantpage/top')); ?>">レストラン ベルンドルフ</a>
                    </li>
                    <li class="hamburger__item">
                        <a class="hamburger__link" href="<?php echo esc_url(home_url('/hotel')); ?>">ホテル ベルンドルフ</a>
                    </li>
                    <li class="hamburger__item">
                        <a class="hamburger__link" href="<?php echo esc_url(home_url('/news')); ?>">お知らせ</a>
                    </li>
                    <li class="hamburger__item">
                        <a class="hamburger__link" href="<?php echo esc_url(home_url('/company/top')); ?>">会社概要</a>
                    </li>
                    <li class="hamburger__item">
                        <a class="hamburger__link" href="<?php echo esc_url(home_url('/contactpage')); ?>">お問い合わせ</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>