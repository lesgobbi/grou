/**
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
(function () {
    'use strict';

    $(function () {

        var keywords = $('#keywords');
        keywords.floatingLabels({
            errorBlock: 'Por favor palavras chave (relacioadas a busca)'
        });

        var description = $('#description');
        description.floatingLabels({
            errorBlock: 'Por favor insira a descrição do seu site'
        });

        var email_contato = $('#email_contato');
        email_contato.floatingLabels({
            errorBlock: 'Por favor insira um email',
            isEmailValid: 'Por favor insira um email válido'
        });

        var tel = $('#tel');
        tel.floatingLabels();
        
        var title = $('#title');
        title.floatingLabels();

        var analytics = $('#analytics');
        analytics.floatingLabels({
            errorBlock: 'Por favor insira o seu id do google analytics'
        });

        var end = $('#end');
        end.floatingLabels({
            errorBlock: 'Insira seu endereço, exemplo: Av. Paulista, 100 - São Paulo'
        });
        
        var color = $('#color');
        color.floatingLabels({
            errorBlock: 'Insira a Cor do Template'
        });

        var social_fb = $('#social_fb');
        social_fb.floatingLabels();

        var social_tt = $('#social_tt');
        social_tt.floatingLabels();

        var social_yt = $('#social_yt');
        social_yt.floatingLabels();

        var social_ig = $('#social_ig');
        social_ig.floatingLabels();

        var social_li = $('#social_li');
        social_li.floatingLabels();

        var social_pr = $('#social_pr');
        social_pr.floatingLabels();

        var social_gp = $('#social_gp');
        social_gp.floatingLabels();

        $('.btn', '.social-media').on('click', function () {
            $('.btn', '.social-media').addClass('disabled');
            $(this).removeClass('disabled');
            var item = '.' + $(this).attr('data-id');
            $('.floating-labels[class*=social_]').hide();
            $(item).show();
        });

        $('form').submit(function () {
            if ($('.has-error', $(this)).length) {
                $('input[type="submit"]', $(this)).addClass('disabled');
                return false;
            } else {
                $('input[type="submit"]', $(this)).removeClass('disabled');
                return true;
            }
        });

        if ($('.post_content').length) {
            $('.post_content').froalaEditor({
                language: 'pt_br',
                toolbarButtons: ['bold', 'italic', 'undo', 'redo', 'selectAll', 'clearFormatting', 'insertLink'],
                heightMin: 50,
                heightMax: 200,
                fontSizeDefaultSelection: 12,
                enter: $.FroalaEditor.ENTER_BR
            });
        }

//        https://maps.googleapis.com/maps/api/geocode/json?address=Rua+Alfredo+Moreira+Pinto,+361+-+Vila+Curuca,+S%C3%A3o+Paulo&key=AIzaSyA3Zx3jQUscuIh77m-0xmAneFX3qCu6IN4
//        https://maps.googleapis.com/maps/api/geocode/json?address=ENDERECO&key=AIzaSyA3Zx3jQUscuIh77m-0xmAneFX3qCu6IN4

        $('#end').on('blur', function () {
            $.get("https://maps.googleapis.com/maps/api/geocode/json", {
                address: $('#end').val(),
                key: 'AIzaSyA3Zx3jQUscuIh77m-0xmAneFX3qCu6IN4',
                language: 'pt-BR'
            }).done(function (data) {
                if (data.status === "OK") {
                    $('#end').val(data.results[0].formatted_address);
                    $('#lat').val(data.results[0].geometry.location.lat);
                    $('#lng').val(data.results[0].geometry.location.lng);
                }
            });
        })
        
        $('.color').colorpicker();
    });
})();
