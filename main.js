// jsを記述する際はここに記載していく

$(function() {
    $('html,body').animate({ scrollTop: 0 }, '1');
});

$(".photo1").slick({
	dots: true,
	infinite: true,
	slidesToShow: 2,
	slidesToScroll: 2,
	autoplay: true,
	autoplaySpeed: 1000,
});

jQuery(function($) {
    const targets = $('.card1');
    if(!targets.length) return;

    $(window).scroll(function () {
        const slideBorder = $(this).scrollTop() + ($(this).outerHeight() * 0.7);
        targets.each(function() {
            if(slideBorder > $(this).offset().top) {
                $(this).addClass('js_active');
            }
        });
    });
});

jQuery(function($) {
    const targets = $('.card2');
    if(!targets.length) return;

    $(window).scroll(function () {
        const slideBorder = $(this).scrollTop() + ($(this).outerHeight() * 0.7);
        targets.each(function() {
            if(slideBorder > $(this).offset().top) {
                $(this).addClass('js_active');
            }
        });
    });
});

jQuery(function($) {
    const targets = $('.card3');
    if(!targets.length) return;

    $(window).scroll(function () {
        const slideBorder = $(this).scrollTop() + ($(this).outerHeight() * 0.7);
        targets.each(function() {
            if(slideBorder > $(this).offset().top) {
                $(this).addClass('js_active');
            }
        });
    });
});

// ページをスクロール
$('#nav a[href*="#"]').click(function () {//全てのページ内リンクに適用させたい場合はa[href*="#"]のみでもOK
	var elmHash = $(this).attr('href'); //ページ内リンクのHTMLタグhrefから、リンクされているエリアidの値を取得
	var pos = $(elmHash).offset().top;	//idの上部の距離を取得
	$('body,html').animate({scrollTop: pos}, 500); //取得した位置にスクロール。500の数値が大きくなるほどゆっくりスクロール
	return false;
});

// Contactの制御
const form = document.getElementById("form");

form.addEventListener("input", update);
form.addEventListener("change", update);

function update() {
  form.checkValidity();
}



