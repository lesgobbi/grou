<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Croppie</title>
        <link rel="Stylesheet" type="text/css" href="croppie.css" />
    </head>

    <body>

        <div class="upload-container">

            <div class="actions">
                <a class="btn file-btn">
                    <span>Imagem</span>
                    <input type="file" id="upload" value="Choose a file" accept="image/*" />
                </a>
            </div>
            <div id="upload-crop"></div>

            <button class="upload-result">Pronto</button>

        </div>

        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

        <script src="croppie.min.js"></script>
        <script src="upload.js"></script>
        <script>
            upload(400, 300);
        </script>
    </body>

</html>