/* global age */

/**
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
(function () {
    'use strict';

    $(function () {

        window.scrollTo(0, 0);

        $('#img-cover').on('click', function () {
            $('#upload-crop').croppie('destroy');
            upload(850, 1272, '#post_cover');
        });

        var firstName = $('#post_title');
        firstName.floatingLabels({
            errorBlock: 'Por favor insira o nome do post'
        });
        
        var postMenu = $('#post_menu');
        postMenu.floatingLabels({
            errorBlock: 'Por favor insira o nome do menu'
        });

        var post_videos = $('#post_videos');
        post_videos.floatingLabels({
            errorBlock: 'Por favor insira a url completa do vídeo do youtube'
        });

        $('.form-cad').submit(function () {
            if ($('.has-error', $(this)).length) {
                return false;
            } else {
                return true;
            }
        });

        $('.form-cad').validator({
            focus: false,
            feedback: {
                success: 'fa fa-ok',
                error: 'fa fa-remove'
            }
        })

        $('.form-cad').validator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                console.log('error');
                $('#bootstrap-validator-form-success').addClass('hidden')
            } else {
                console.log('success');
                $('#bootstrap-validator-form-success').removeClass('hidden');
            }
        });

        if ($('#post_content').length) {
            var colors = [
                '#000000', '#444444', '#666666', '#999999', '#cccccc', '#eeeeee', '#f3f3f3', '#ffffff',
                '#ff0000', '#ff9900', '#ffff00', '#00ff00', '#00ffff', '#0000ff', '#9900ff', '#ff00ff',
                '#f4cccc', '#fce5cd', '#fff2cc', '#d9ead3', '#d0e0e3', '#cfe2f3', '#d9d2e9', '#ead1dc',
                '#ea9999', '#f9cb9c', '#ffe599', '#b6d7a8', '#a2c4c9', '#9fc5e8', '#b4a7d6', '#d5a6bd',
                '#e06666', '#f6b26b', '#ffd966', '#93c47d', '#76a5af', '#6fa8dc', '#8e7cc3', '#c27ba0',
                '#cc0000', '#e69138', '#f1c232', '#6aa84f', '#45818e', '#3d85c6', '#674ea7', '#a64d79',
                '#990000', '#b45f06', '#bf9000', '#38761d', '#134f5c', '#0b5394', '#351c75', '#741b47',
                '#660000', '#783f04', '#7f6000', '#274e13', '#0c343d', '#073763', '#20124d', '#4c1130'
            ];
            $('#post_content').froalaEditor({
                language: 'pt_br',
                fileUploadURL: 'scripts/editor/upload_file.php',
                imageUploadURL: 'scripts/editor/upload_image.php',
                toolbarButtons: ['bold', 'italic', 'underline', 'color', '|', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '-', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '|', 'insertHR', 'undo', 'redo', 'selectAll', 'clearFormatting'],
                colorsStep: 8,
                colorsText: colors,
                colorsBackground: colors,
                tableColors: colors,
                tableColorsStep: 8,
                heightMin: 200,
                heightMax: 460,
                fontSize: [10, 12, 14, 16, 18, 20, 22, 24, 28, 30, 34, 40],
                fontSizeDefaultSelection: 16,
                fontSizeSelection: true,
                enter: $.FroalaEditor.ENTER_BR
            });
        }
        
        if ($('#board').length) {
            var drake = dragula([document.getElementById('board')]);

            drake.on('dragend', function (el) {
                $.post("../_ajax/order.php", {
                    table: 'posts_gallery',
                    entity: 'gallery',
                    parent_name: 'post_id',
                    id: $(el).attr('data-id'),
                    parent: $(el).attr('data-parent'),
                    atual: $(el).attr('data-position'),
                    new : $(el).index() + 1
                }).done(function (data) {
//                    alert(data);
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
        
        if ($('#dropzonegallery').length) {
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("#dropzonegallery");
            myDropzone.on("queuecomplete", function () {
                var id = $('#dropzonegallery').attr('data-id');
                window.location.href = '?exe=posts/update&postid=' + id;
            });
        }

        if ($('.gallery-item').length) {
            $('.gallery-item').on('click', function () {
                toggleItemGallery(this, '#remove');
            });

            $('#selectall').on('click', function () {
                selectAllItensGallery(this, '#clearall', '.gallery-item', '#remove');
            });

            $('#clearall').on('click', function () {
                unSelectAllItensGallery(this, '#selectall', '.gallery-item', '#remove');
            });
        }

        if ($('.form-caption').length) {
            $('.form-caption input').on('blur', function () {
                updateCaption('posts_gallery', 'gallery', $(this).parent('form').attr('data-id'), $(this).val());
            });

            $('.form-caption input').on('focus', function (event) {
                event.stopPropagation();
            });

            $('.form-caption input').on('click', function (event) {
                event.stopPropagation();
            });
        }

        $('.gallery-btn-delete').on('click', function (event) {
            event.stopPropagation();
        });

        $('#video-add').on('click', function () {
            var post_video = $('#post_videos').val();
            var post_id = $(this).attr('data-post');
            if (post_video === '') {
                $.notify("Insira uma URL de vídeo válida", {
                    className: 'warn',
                    globalPosition: 'top right',
                    autoHideDelay: 10000
                });
            } else {
                $.post("../_ajax/up.php", {
                    post_video: post_video,
                    post_id: post_id
                }).done(function (data) {
                    if (data === 'ok') {
                        $('#post_videos').val('');
                        swal({
                            title: 'Vídeo adicionado com sucesso',
                            html: 'Você já pode adicionar um novo vídeo'
                        }, function () {
                            $('#post_videos').trigger('focus');
                        });
                    } else {
                        swal({
                            title: 'Occoreu um erro!',
                            html: 'Vídeo não adicionado.'
                        }, function () {
                            $('#post_videos').trigger('focus');
                        });
                    }
                });
            }
        });

    });
})();
