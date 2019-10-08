/**
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
(function () {
    'use strict';

    $(function () {

        var firstName = $('#firstname');
        firstName.floatingLabels({
            errorBlock: 'Por favor insira seu nome'
        });

        var email = $('#email');
        email.floatingLabels({
            errorBlock: 'Por favor insira seu email',
            isEmailValid: 'Por favor insira um email válido'
        });

        var password = $('#password');
        password.floatingLabels({
            errorBlock: 'Por favor insira uma senha válida (com pelo menos 4 caracteres)',
            minLength: 4
        });

        var confirmPassword = $('#confirm-password');
        confirmPassword.floatingLabels({
            errorBlock: 'Repita sua senha corretamente',
            minLength: 4,
            isFieldEqualTo: $('#password')
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

        if($('#itens-table').length){
            $('#itens-table').DataTable({
                language: {
                    paginate: {
                        first: 'Primeira',
                        previous: 'Anterior',
                        next: 'Próxima',
                        last: 'Ultima'
                    },
                    "decimal":        "",
                    "emptyTable":     "Sem dados disponíveis",
                    "info":           "Mostrando de _START_ to _END_ até _TOTAL_",
                    "infoEmpty":      "Mostrando 0 de 0 a 0",
                    "infoFiltered":   "(filtered from _MAX_ total entries)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Mostrar _MENU_ itens na lista",
                    "loadingRecords": "Carregando...",
                    "processing":     "Processando...",
                    "search":         "Buscar:",
                    "zeroRecords":    "Nenhum resultado encontrado",
                    "aria": {
                        "sortAscending":  ": ordem crescente",
                        "sortDescending": ": ordem decrescente"
                    }
                }
            });
        }

    });
})();
