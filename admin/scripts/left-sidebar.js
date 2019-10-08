/**
 * @author Radiati Comunicação
 */
(function() {
    'use strict';

    $(function() {

        $('.sidebar-1 [data-click]').on('click', function(e) {
            var action = $(this).data('click');
            var id = $(this).data('id');
            if (action === 'toggle-section') {
                e.preventDefault();
                toggleSection(id);
                return false;
            }
        });

        var id = false;
        var url = window.location.href;

        $('.l2 a').each(function(v, k) {
            var item = $(this);
            var href = item.attr('href');
            if (href && url.indexOf(href) > -1) {
                item.addClass('sideline-active');
            }
        });

        $('li a').each(function(v, k) {
            var item = $(this);
            var href = item.attr('href');
            if (href && url.indexOf(href) > -1) {
                item.addClass('sideline-active');
            }
        });

        if (url.match(/exe=users/gi)) {
            id = 'users';
            toggleSection(id);
            return false;
        } else if (url.match(/exe=arquitetos/gi)) {
            id = 'arquitetos';
            toggleSection(id);
            return false;
        } else if (url.match(/exe=banners/gi)) {
            id = 'banners';
            toggleSection(id);
            return false;
        } else if (url.match(/exe=noticias/gi)) {
            id = 'noticias';
            toggleSection(id);
            return false;
        } else if (url.match(/exe=nossas-marcas/gi)) {
            id = 'nossas-marcas';
            toggleSection(id);
            return false;
        } else if (url.match(/exe=categorias/gi)) {
            id = 'categorias';
            toggleSection(id);
            return false;
        } else if (url.match(/exe=produto/gi)) {
            id = 'produto';
            toggleSection(id);
            return false;
        } else if (url.match(/exe=referencias/gi)) {
            id = 'referencias';
            toggleSection(id);
            return false;
        } else if (url.match(/exe=area-restrita/gi)) {
            id = 'area-restrita';
            toggleSection(id);
            return false;
        }

    });

})();