<div class="row">
    <div class="col-xs-12">
        <h3>Cadastrar Banner</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=banners/banners">Banners</a> 
    </li>
    <li class="active">Cadastrar Banner</li>
</ol>

<?php

$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);

    require('../_models/AdminBanner.class.php');
    $cadastra = new AdminBanner;
    $cadastra->ExeCreate($ClienteData);

    if ($cadastra->getResult()):
        header("Location: painel.php?exe=banners/banners&create=true");
    else:
        Notification($cadastra->getError()[0], $cadastra->getError()[1]);
    endif;
endif;
?>

<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <div class="row">
            <div class="col-xs-12 col-xl-12">
                <fieldset class="form-group m-b-20 croppie-ct">
                    <label>Banner</label>

                    <div class="upload-container">
                        <div class="actions">
                            <a class="btn btn-primary m-r-10 m-b-10 file-btn" id="img-cover">
                                <span>Upload</span>
                                <input type="file" id="upload" value="Choose a file" accept="image/*" />
                            </a>
                        </div>
                        <div id="upload-crop"></div>
                        <button class="upload-result btn btn-primary m-r-10 m-b-10">Pronto</button>
                    </div>
                    
                </fieldset>
            </div>
        </div>
        
        <form name="form" method="post">
            <input type="hidden" name="banner_url" id="banner_url"/>
            <div class="row">
                <div class="col-xs-12 col-xl-12">
                    <div class="form-group floating-labels">
                        <label for="banner_title">Título</label>
                        <input id="banner_title" autocomplete="off" type="text" name="banner_title" value="<?php if (!empty($ClienteData['banner_title'])) echo $ClienteData['banner_title']; ?>">
                        <p class="error-block"></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-xl-12">
                    <fieldset class="form-group m-b-20">
                        <label>Subtítulo</label>
                        <textarea id="banner_subtitle" name="banner_subtitle" class="banner_subtitle" rows="4"><?php if (isset($ClienteData['banner_subtitle'])) echo $ClienteData['banner_subtitle']; ?></textarea>
                    </fieldset>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-xl-6">
                    <div class="form-group floating-labels">
                        <label for="banner_link">Link</label>
                        <input id="banner_link" autocomplete="off" type="text" name="banner_link" value="<?php if (!empty($ClienteData['banner_link'])) echo $ClienteData['banner_link']; ?>">
                        <p class="error-block"></p>
                    </div>
                </div>
                <div class="col-xs-12 col-xl-6">
                    <label for="banner_target">Abrir em: </label>
                    <fieldset class="form-group">
                        <label class="c-input c-radio">
                            <input id="radio0" name = "banner_target" type="radio" value="0" checked>
                            <span class="c-indicator c-indicator-success"></span>
                            Mesma Janela
                        </label>
                        <label class="c-input c-radio">
                            <input id="radio1" name = "banner_target" type="radio" value="1">
                            <span class="c-indicator c-indicator-success"></span>
                            Nova Janela
                        </label>
                    </fieldset>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" name="SendPostForm" value="Cadastrar Banner"/>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="bower_components/croppie/croppie.css" />
<script src="bower_components/croppie/croppie.min.js"></script>
<script src="bower_components/croppie/upload.js"></script>

<?php include('includes/editor.php'); ?>