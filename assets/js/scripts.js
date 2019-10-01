$(window).load(function() {
    $('.parallax').each(function() {
        var item = $(this).height();
        var top = $(this).offset().top;
        $('img', $(this)).css('transform', 'translate3d(0, ' + ($(window).scrollTop() - top - item) * 0.3 + 'px, 0)');
    });
});

$(window).scroll(function() {
    var scroll = $(window).scrollTop();

    $('.parallax').each(function() {
        var item = $(this).height();
        var top = $(this).offset().top;
        $('img', $(this)).css('transform', 'translate3d(0, ' + (scroll - top - item) * 0.3 + 'px, 0)');
    });

});