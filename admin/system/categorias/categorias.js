/**
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
(function () {
    'use strict';

    $(function () {

        var firstName = $('#category_name');
        firstName.floatingLabels({
            errorBlock: 'Por favor insira o nome da categoria'
        });

        $('form').submit(function () {
            if ($('.has-error', $(this)).length) {
                return false;
            } else {
                return true;
            }
        });

        $('form').validator({
            focus: false,
            feedback: {
                success: 'fa fa-ok',
                error: 'fa fa-remove'
            }
        })

        $('form').validator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                console.log('error');
                $('#bootstrap-validator-form-success').addClass('hidden')
            } else {
                console.log('success');
                $('#bootstrap-validator-form-success').removeClass('hidden');
            }
        });

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