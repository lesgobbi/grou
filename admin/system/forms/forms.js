/**
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */

var FieldsModel = function(fields) {
    var self = this;
    self.fields = ko.observableArray(ko.utils.arrayMap(fields, function(field) {
        return {
            name: ko.observable(field.name),
            type: ko.observableArray(field.type),
            validate: ko.observable(field.validate),
            radioName: ko.observable(field.radioName),
            options: ko.observableArray(field.options),
            optionsView: ko.observable(field.optionsView),
            change: ko.observable(false)
        };
    }));

    self.addField = function() {
        self.fields.push({
            name: ko.observable(""),
            type: ko.observableArray(["text"]),
            validate: ko.observable('0'),
            radioName: ko.observable('radio' + Math.floor((Math.random() * 1000) + 1)),
            options: ko.observableArray(),
            optionsView: ko.observable(false),
            change: ko.observable(false)
        });
    };

    self.removeField = function(field) {
        if (self.fields().length > 1) {
            self.fields.remove(field);
        } else {
            $.notify("Você deve manter pelo menos um campo.", {
                className: 'warn',
                globalPosition: 'top right',
                autoHideDelay: 5000
            });
        }
    };

    self.addOption = function(field) {
        field.options.push({
            option: ko.observable("")
        });
    };

    self.removeOption = function(option) {
        $.each(self.fields(), function() {
            this.options.remove(option)
        })
    };

    self.toggleViewCombo = function() {
        var $this = $(event.target);
        if ($this.val() === 'combo' || $this.val() === 'check' || $this.val() === 'radio') {
            this.optionsView(true)
        } else {
            this.optionsView(false)
        }
    };

    self.changes = function() {
        $.each(self.fields(), function() {
            this.change(true);
        });
    }

    self.savedJson = ko.pureComputed(function() {
        return JSON.stringify(ko.toJS(self.fields), null, 2)
    });
};

(function() {
    'use strict';

    $(function() {

        var email_contato = $('#email_contato');
        email_contato.floatingLabels({
            errorBlock: 'Por favor insira um email',
            isEmailValid: 'Por favor insira um email válido'
        });

        var form_nome = $('#form_nome');
        form_nome.floatingLabels({
            errorBlock: 'Por favor insira o nome do formulário'
        });

        $('form').submit(function() {
            if ($('.has-error', $(this)).length) {
                $('input[type="submit"]', $(this)).addClass('disabled');
                return false;
            } else {
                $('input[type="submit"]', $(this)).removeClass('disabled');
                return true;
            }
        });

        $('.btn-primary').on('click', function() {
            $(this).closest('form').submit();
        })

        if ($('form').length) {
            ko.applyBindings(new FieldsModel(initialData));
        }

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