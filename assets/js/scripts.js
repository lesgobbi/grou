$(document).ready(function() {
    var top = $('.parallax').offset().top;
    var scroll = $(window).scrollTop();
    var height = $('.parallax').height();
    $('.parallax').css('background-position', '0px -' + ((height + top - scroll) / 5) + 'px');
});

$(window).scroll(function() {
    var top = $('.parallax').offset().top;
    var scroll = $(window).scrollTop();
    var height = $('.parallax').height();
    $('.parallax').css('background-position', '0px -' + ((height + top - scroll) / 5) + 'px');
});