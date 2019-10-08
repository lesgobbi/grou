/**
 * @author Radiati Comunicação
 */
(function () {
    'use strict';

    $(function () {

        var config = $.localStorage.get('config');
        if (!config) {
            var config = {
                name: 'Radiati',
                theme: 'palette-8',
                palette: getPalette('palette-8'),
                layout: 'default-sidebar',
                colors: getColors()
            }
        }

        $('body').attr('data-layout', config.layout);
        $('body').attr('data-palette', config.theme);

        //$.removeAllStorages();
        if ($.localStorage.isEmpty('config') || !($.localStorage.get('config'))) {
            $.removeAllStorages();
            $.localStorage.set('config', config);
        }

        var isIE = detectIE();
        if (isIE) {
            $('body').addClass('ie-' + isIE);
        }

        $('[data-toggle="tooltip"]').tooltip();

        if ($('.chosen-select').length) {
            $('.chosen-select').chosen({width: "100%"});
        }

    });
})();