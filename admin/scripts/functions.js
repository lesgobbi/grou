/**
 * @author Radiati Comunicação
 */
function detectIE() {
    /**
     * detect IE
     * returns version of IE or false, if browser is not Internet Explorer
     */
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
        // Edge (IE 12+) => return version number
        return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}

function toggleSearch() {
    var navbarDrawer = $('.navbar-drawer');
    navbarDrawer.toggleClass('active');
}

function toggleSearchInput() {
    $('.navbar-search').toggleClass('navbar-search-hidden');
}

function toggleRightSidebar() {
    $('.right-sidebar-outer').toggleClass('show-from-right');
}

function toggleLayout() {

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

    var layout = config.layout;

    if (layout === 'default-sidebar') {
        $('body').attr('data-layout', 'collapsed-sidebar');
        config.layout = 'collapsed-sidebar';
        $.localStorage.set('config', config);
    } else if (layout === 'collapsed-sidebar') {
        $('body').attr('data-layout', 'default-sidebar');
        config.layout = 'default-sidebar';
        $.localStorage.set('config', config);
    } else {
        $('body').toggleClass('layout-collapsed');
    }
}

function toggleFullscreenMode() {
    $(document).fullScreen(true);
}

function toggleSection(id) {
    $('.section-' + id).toggleClass('active');
    $('.fa-caret-down.icon-' + id).toggleClass('fa-rotate-180');
}

function toggleSidebar() {
    $('body').toggleClass('layout-collapsed');
}

function setLayout(layout) {

    var config = $.localStorage.get('config');
    config.layout = layout;

    console.log('new config', config);
    $.removeAllStorages();
    $.localStorage.set('config', config);

    $('body').removeClass('layout-collapsed');
    $('body').attr('data-layout', layout);
}

//http://www.sitepoint.com/javascript-generate-lighter-darker-color/
function colorLuminance(hex, lum) {

    // validate hex string
    hex = String(hex).replace(/[^0-9a-f]/gi, '');
    if (hex.length < 6) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
    lum = lum || 0;

    // convert to decimal and change luminosity
    var rgb = "#",
        c, i;
    for (i = 0; i < 3; i++) {
        c = parseInt(hex.substr(i * 2, 2), 16);
        c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
        rgb += ("00" + c).substr(c.length);
    }

    return rgb;
}

function lighten(col, amt) {
    amt = Math.abs(amt);
    amt = amt / 100;
    return colorLuminance(col, amt);
}

function darken(col, amt) {
    amt = Math.abs(amt);
    amt = (amt / 100) * -1;
    return colorLuminance(col, amt);
}

function updateCaption(table, entity, id, caption) {
    $.post("../_ajax/caption.php", {
        table: table,
        entity: entity,
        id: id,
        caption: caption
    }).done(function(data) {
        if (data === 'ok') {
            $.notify("Legenda atualizada.", {
                className: 'success',
                globalPosition: 'top right',
                autoHideDelay: 10000
            });
        } else {
            $.notify("Ocorreu um erro! Legenda não atualizada.", {
                className: 'error',
                globalPosition: 'top right',
                autoHideDelay: 10000
            });
        }
    });
}

function toggleItemGallery(item, itensContainer) {
    var id = parseInt($(item).attr('data-id'));
    var atual = JSON.parse("[" + $(itensContainer).val() + "]");
    var index = $.inArray(id, atual);

    if (index > -1) {
        atual.splice(index, 1);
        $(item).removeClass('remove');
    } else {
        atual.push(id);
        $(item).addClass('remove');
    }

    atual.sort();

    if (atual.length !== 0) {
        $('#clearall').show();
        $('#removebutton').show();
    } else {
        $('#clearall').hide();
        $('#removebutton').hide();
    }

    $(itensContainer).val(atual);
}

function selectAllItensGallery(self, against, entity, itensContainer) {
    var atual = [];
    $(entity).each(function() {
        var item = parseInt($(this).attr('data-id'));
        atual.push(item);
        $(this).addClass('remove');
        $(itensContainer).val(atual);
    })

    if (atual.length !== 0) {
        $('#clearall').show();
        $('#removebutton').show();
    } else {
        $('#clearall').hide();
        $('#removebutton').hide();
    }

    $(self).hide();
    $(against).show();
}

function unSelectAllItensGallery(self, against, entity, itensContainer) {
    $(itensContainer).val('');
    $(entity).removeClass('remove');
    $('#removebutton').hide();
    $(self).hide();
    $(against).show();
}

function updateImg() {
    $.post("../_ajax/update-full-image.php", {
        table: 'posts_gallery',
        entity: 'gallery',
        id: $('#img_id').val(),
        caption: $('#post_title').val(),
        ref: $('#post-select').val()
    }).done(function(data) {
        if (data === 'ok') {
            getNewGallery();
        } else {
            $.notify("Ocorreu um erro! Imagem não atualizada.", {
                className: 'error',
                globalPosition: 'top right',
                autoHideDelay: 10000
            });
        }
    });
}

function updateCat() {
    $.post("../_ajax/update-cat.php", {
        id: $('#img_id').val(),
        category: $('#categoria-select').val()
    }).done(function(data) {
        if (data === '') {
            getNewCats();
        } else {
            console.log(data);
            $.notify("Ocorreu um erro! Imagem não atualizada.", {
                className: 'error',
                globalPosition: 'top right',
                autoHideDelay: 10000
            });
        }
    });
}

function getNewGallery() {
    $.get('../_ajax/new-gallery.php', function(data) {
        galeria = $.parseJSON(data);
    });
}

function getNewCats() {
    $.get('../_ajax/new-cats.php', function(data) {
        allCats = $.parseJSON(data);
    });
}