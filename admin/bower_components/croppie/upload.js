function upload(w, h, dest, logo) {
    var $uploadCrop;
    var $ext;

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var str = e.target.result;
                var n = str.indexOf("jpeg");
                $ext = n >= 0 ? 'jpeg' : 'png';

                $uploadCrop.croppie('bind', {
                    url: e.target.result
                });
                $('.upload-container').addClass('ready');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            alert("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    if (logo) {
        $uploadCrop = $('#upload-crop').croppie({
            viewport: {
                width: w,
                height: h,
                type: 'square'
            },
            boundary: {
                width: w + w / 1.5,
                height: h + w / 1.5
            },
            enforceBoundary: false
        });
    } else {
        $uploadCrop = $('#upload-crop').croppie({
            viewport: {
                width: w,
                height: h,
                type: 'square'
            },
            boundary: {
                width: w + w / 1.5,
                height: h + w / 1.5
            }
        });
    }


    var featured = false;
    $('#upload').on('change', function() {
        featured = false;
        readFile(this);
        $('#upload-crop').show('slow', function() {
            var width = $('#upload-crop').width();
            var ctWidth = $('.cr-boundary').width();
            var zoom = width / ctWidth;
            $('.cr-boundary').css('zoom', zoom);
        });
        $('.upload-result').show();
    });

    $('#upload-featured').on('change', function() {
        featured = true;
        readFile(this);
        $('#upload-crop').show('slow');
        $('.upload-result').show();
    });

    var lock = false;
    $('.upload-result').on('click', function() {
        $('#upload-crop').hide('slow');
        $('.upload-result').hide('slow');
        $('.upload-container').append('<div class="ellipsis-loader" aria-role="alert" aria-label="Carregando, aguarde por favor"><div class="ellipsis-loader__dot"></div><div class="ellipsis-loader__dot"></div><div class="ellipsis-loader__dot"></div><div class="ellipsis-loader__dot"></div></div>');
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'original',
            format: $ext
        }).then(function(resp) {
            if (!lock) {
                $.post('bower_components/croppie/movefile.php', {
                    file: resp
                }).done(function(data) {
                    $('.ellipsis-loader', '.upload-container').remove();
                    if (!featured) {
                        $('.img-cropped#imgcover').remove();
                        $('.croppie-ct').append('<img class="img-cropped" id="imgcover" src="../tim.php?src=/uploads/' + data + '&w=' + w + '&h=' + h + '" />');
                        $(dest).val(data);
                    } else {
                        $('.img-cropped#imgfeatured').remove();
                        $('.croppie-ct-featured').append('<img class="img-cropped" id="imgfeatured" src="../tim.php?src=/uploads/' + data + '&w=' + w + '&h=' + h + '"/>');
                        $(dest).val(data);
                    }
                    $uploadCrop.croppie('destroy');
                    lock = true;
                    //                console.log(data);
                });
            }
        });
    });
}