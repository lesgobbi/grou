/**
 * @author Radiati Comunicação
 */
(function() {
    'use strict';

    $(function() {

        var config = $.localStorage.get('config');
        $('body').attr('data-palette', config.theme);

        var bg = '<div class="fullsize fullsize-medium"></div>';
        $('.fullsize').remove();
        $('body').prepend(bg);

        var email = $('#email');
        email.floatingLabels({
            errorBlock: 'Por favor informe seu e-mail',
            isEmailValid: 'Por favor informe um e-mail válido'
        });
    });

})();
