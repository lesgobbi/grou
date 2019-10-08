/* global age */

/**
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
(function () {
    'use strict';

    $(function () {

        window.scrollTo(0, 0);

        if ($('.post_content').length) {
            $('.post_content').froalaEditor({
                language: 'pt_br',
                toolbarButtons: ['bold', 'italic', 'undo', 'redo', 'selectAll', 'clearFormatting', 'insertLink'],
                heightMin: 120,
                heightMax: 200,
                fontSizeDefaultSelection: 12,
                enter: $.FroalaEditor.ENTER_BR
            });
        }

    });
})();
