$(document).ready(function() {
    AOS.init();

    var top = $('.parallax').offset().top;
    var scroll = $(window).scrollTop();
    var height = $('.parallax').height();
    $('.parallax').css('background-position', '0px -' + ((height + top - scroll) / 5) + 'px');

    $('.contato').on('click', function(){
        $('html, body').animate({
            scrollTop: $('footer').offset().top
        }, 1000);
    });

    if (30 >= scroll) {
        $('header').removeClass('scrolled');
    } else {
        $('header').addClass('scrolled');
    }
});

$(window).scroll(function() {
    var top = $('.parallax').offset().top;
    var scroll = $(window).scrollTop();
    var height = $('.parallax').height();
    $('.parallax').css('background-position', '0px -' + ((height + top - scroll) / 5) + 'px');

    if (30 >= scroll) {
        $('header').removeClass('scrolled');
    } else {
        $('header').addClass('scrolled');
    }
});