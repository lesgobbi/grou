/**
 * @author Radiati Comunicação
 */
(function() {
    'use strict';

    $(function() {

        var config = $.localStorage.get('config');
        //$('body').attr('data-layout', config.layout);
        $('body').attr('data-palette', config.theme);

        var bg = '<div class="fullsize fullsize-medium"></div>';
        $('.fullsize').remove();
        $('body').prepend(bg);

        var email = $('.login-page #email');
        email.floatingLabels({
            errorBlock: 'Por favor informe seu nome ou e-mail',
        });

        var password = $('.login-page #password');
        password.floatingLabels({
            errorBlock: 'Por favor informe sua senha',
            minLength: 3
        });
    });

})();
