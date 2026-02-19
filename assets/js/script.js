// --- Slick Slider (jQuery) ---
jQuery(function ($) {
    // アメニティギャラリー初期化関数
    function initAmenityGallery() {
        var $amenityGallery = $('.amenities__gallery');
        if ($amenityGallery.length && !$amenityGallery.hasClass('slick-initialized')) {
            var $slides = $amenityGallery.children('div');
            if ($slides.length > 0) {
                $amenityGallery.slick({
                    arrows: true,
                    dots: true,
                    infinite: true,
                    autoplay: false,
                    adaptiveHeight: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>'
                });
            }
        }
    }

    $(document).ready(function () {
        // 1. ホテル詳細ページの客室ギャラリー
        if ($('.room__gallery').length) {
            $('.room__gallery').slick({
                arrows: true,
                dots: true,
                infinite: true,
                autoplay: false,
                adaptiveHeight: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                nextArrow: '<button type="button" class="slick-next">Next</button>'
            });
        }

        // 2. アメニティギャラリー初期化
        initAmenityGallery();
    });

    $(window).on('load', function () {
        initAmenityGallery();
    });
});

// --- トップへ戻るボタン ---
document.addEventListener('DOMContentLoaded', function () {
    const backToTopBtn = document.getElementById('back-to-top');
    if (backToTopBtn) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('is-visible');
            } else {
                backToTopBtn.classList.remove('is-visible');
            }
        });
        backToTopBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});

// --- ハンバーガーメニュー ---
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger');
    const hamburgerButton = document.querySelector('.hamburger__button');
    const hamburgerMenu = document.querySelector('.hamburger__menu');
    const hamburgerArrow = document.querySelector('.hamburger__arrow');

    // ボタンが存在する場合のみ実行（エラー防止）
    if (hamburgerButton) {
        // 開閉の切り替え関数
        function toggleMenu() {
            // 要素が存在するか確認してからクラスを切り替え
            if(hamburger) hamburger.classList.toggle('is-active');
            if(hamburgerButton) hamburgerButton.classList.toggle('is-active');
            if(hamburgerMenu) hamburgerMenu.classList.toggle('is-active');
        }

        // ハンバーガーボタンクリック時
        hamburgerButton.addEventListener('click', toggleMenu);

        // メニュー内の「→（閉じる）」ボタンクリック時
        if(hamburgerArrow) {
            hamburgerArrow.addEventListener('click', toggleMenu);
        }
    }
});
