<?php
function edelwein_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('page_eyecatch', 1100, 610, true);
    register_nav_menu('main-menu', 'メインメニュー');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'edelwein_theme_setup');


function edelwein_enqueue_scripts()
{
    // リセットCSS
    wp_enqueue_style(
        'destyle',
        'https://cdn.jsdelivr.net/npm/destyle.css@4.0.1/destyle.min.css',
        [],
        null
    );

    // Slick CSS (CDN)
    wp_enqueue_style(
        'slick-css',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
        [],
        '1.8.1'
    );
    wp_enqueue_style(
        'slick-theme-css',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css',
        [],
        '1.8.1'
    );

    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Jacques+Francois&family=Sawarabi+Mincho&display=swap',
        [],
        null
    );

    // メインスタイルシート
    wp_enqueue_style(
        'main-style',
        get_template_directory_uri() . '/assets/css/style.css',
        ['destyle', 'slick-css'],
        filemtime(get_template_directory() . '/assets/css/style.css')
    );


    // jQuery (WordPress同梱)
    wp_enqueue_script('jquery');

    // Slick JS (CDN) - jQueryに依存
    wp_enqueue_script(
        'slick-js',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
        ['jquery'],
        '1.8.1',
        true // フッターで読み込み
    );

    // メインJS (script.js) - Slick JSに依存
    wp_enqueue_script(
        'main-script',
        get_template_directory_uri() . '/assets/js/script.js',
        ['jquery', 'slick-js'],
        filemtime(get_template_directory() . '/assets/js/script.js'),
        true // フッターで読み込み
    );
}
add_action('wp_enqueue_scripts', 'edelwein_enqueue_scripts');


// ▼ 全ページのフッター手前に「トップへ戻るボタン」を自動挿入
function add_back_to_top_button()
{
    // 画像パスを取得
    $img_src = get_template_directory_uri() . '/assets/img/to-btn.png';
?>
    <a href="#" id="back-to-top" class="back-to-top">
        <img src="<?php echo esc_url($img_src); ?>" alt="ページ上部へ戻る">
    </a>
<?php
}
add_action('wp_footer', 'add_back_to_top_button');


add_filter('use_block_editor_for_post',function($use_block_editor,$post){
	if($post->post_type==='page'){
		if(in_array($post->post_name,['groupmenu','hotel','hotel_detail'])){ //ページスラッグが「about」または「company」ならコンテンツエディターを非表示
			remove_post_type_support('page','editor');
			return false;
		}
	}
	return $use_block_editor;
},10,2);