$(document).ready(function() {
    AOS.init();

    if ($('.parallax').length) {
        var top = $('.parallax').offset().top;
        var height = $('.parallax').height();
        $('.parallax').css('background-position', '0px -' + ((height + top - scroll) / 5) + 'px');
    }

    $('.contato').on('click', function() {
        $('html, body').animate({
            scrollTop: $('footer').offset().top
        }, 1000);
    });

    menuScroll($(window).scrollTop());

    var maskBehavior = function(val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {
        onKeyPress: function(val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
        }
    };

    $('.telefone').mask(maskBehavior, options);

    var file = $('#file-contact').val();
    $('#form-contato').validate({
        submitHandler: function(form) {
            var dados = $(form).serialize();
            $('.loader').addClass('visible');
            $.ajax({
                type: "POST",
                url: file + "/email/email.php",
                data: dados,
                success: function(data) {
                    alert(data);
                    $('.loader').removeClass('visible');
                    $('#form-contato')[0].reset();
                }
            });
            return false;
        }
    });

    var formid = $('#formid').val();
    $('.send-form').validate({
        submitHandler: function(form) {
            var dados = $(form).serialize();
            $('.loader').addClass('visible');
            $.ajax({
                type: "POST",
                url: file + "/email/email.php?formid="+formid,
                data: dados,
                success: function(data) {
                    alert(data);
                    $('.loader').removeClass('visible');
                    $('.send-form')[0].reset();
                }
            });
            return false;
        }
    });

    $('.hamburguer').on('click', function(){
        $('menu').toggleClass('visible')
    })

    $('menu li a.contato').on('click', function () {
        $('menu').removeClass('visible')
    });
});

$(window).scroll(function() {
    if ($('.parallax').length) {
        var top = $('.parallax').offset().top;
        var height = $('.parallax').height();
        $('.parallax').css('background-position', '0px -' + ((height + top - scroll) / 5) + 'px');
    }

    menuScroll($(window).scrollTop());
});

function menuScroll(scroll){
    var wh = $(window).height() - ($('header').outerHeight() + $('menu ul').outerHeight() - 16);

    if (30 >= scroll) {
        $('header').removeClass('scrolled');
    } else {
        $('header').addClass('scrolled');

        if(scroll >= wh){
            $('header').addClass('alt');
        }else{
            $('header').removeClass('alt');
        }
    }
}