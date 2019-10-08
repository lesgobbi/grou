/**
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
(function () {
    'use strict';

    $(function () {

        $('#img-cover').on('click', function () {
            $('#upload-crop').croppie('destroy');
            upload(1920, 1100, '#banner_url');
        });

        if ($('#board').length) {
            var drake = dragula([document.getElementById('board')]);

            drake.on('dragend', function (el) {
                $.post("../_ajax/order.php", {
                    table: 'banners',
                    entity: 'banner',
                    id: $(el).attr('data-id'),
                    atual: $(el).attr('data-position'),
                    new : $(el).index() + 1
                }).done(function (data) {
                    if (data === 'ok') {
                        $('span', '#board').each(function () {
                            $(this).attr('data-position', $(this).index() + 1);
                        });
                        $.notify("Posição atualizada.", {
                            className: 'success',
                            globalPosition: 'top right',
                            autoHideDelay: 10000
                        });
                    } else {
                        $.notify("Occoreu um erro! Posição não atualizada.", {
                            className: 'error',
                            globalPosition: 'top right',
                            autoHideDelay: 10000
                        });
                    }
                });
            });
        }

        if ($('.banner_subtitle').length) {
            $('.banner_subtitle').froalaEditor({
                language: 'pt_br',
                toolbarButtons: ['bold', 'italic', 'undo', 'redo', 'selectAll', 'clearFormatting', 'insertLink'],
                heightMin: 68,
                heightMax: 68,
                fontSizeDefaultSelection: 12,
                enter: $.FroalaEditor.ENTER_BR
            });
        }

        var title = $('#banner_title');
        title.floatingLabels();

        var link = $('#banner_link');
        link.floatingLabels();

        if ($('#itens-table').length) {
            $('#itens-table').DataTable({
                language: {
                    paginate: {
                        first: 'Primeira',
                        previous: 'Anterior',
                        next: 'Próxima',
                        last: 'Ultima'
                    },
                    "decimal": "",
                    "emptyTable": "Sem dados disponíveis",
                    "info": "Mostrando de _START_ to _END_ até _TOTAL_",
                    "infoEmpty": "Mostrando 0 de 0 a 0",
                    "infoFiltered": "(filtrando _MAX_ de itens)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ itens na lista",
                    "loadingRecords": "Carregando...",
                    "processing": "Processando...",
                    "search": "Buscar:",
                    "zeroRecords": "Nenhum resultado encontrado",
                    "aria": {
                        "sortAscending": ": ordem crescente",
                        "sortDescending": ": ordem decrescente"
                    }
                }
            });
        }

    });
})();
