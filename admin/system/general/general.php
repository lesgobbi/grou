<style>
    .logo-opt {
        float: left;
        background: url(../images/logo_type.png);
        cursor: pointer;
        margin-right: 8px;
        border: 0;
        text-indent: -9999px;
        margin-bottom: 15px
    }

    .logo-opt.active {
        pointer-events: none
    }

    .logo-opt.opt1 {
        width: 66px;
        height: 66px
    }

    .logo-opt.opt1.active {
        background-position: 0 -68px
    }

    .logo-opt.opt2 {
        width: 128px;
        height: 66px;
        background-position: -68px 0
    }

    .logo-opt.opt2.active {
        background-position: -68px -68px
    }

    .logo-opt.opt3 {
        width: 190px;
        height: 66px;
        margin-right: 0;
        background-position: -198px 0
    }

    .logo-opt.opt3.active {
        background-position: -198px -68px
    }
</style>

<div class="row">
    <div class="col-xs-12">
        <h3>Configurações gerais</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li>Configurações Gerais</li>
</ol>

<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$atualizado = filter_input(INPUT_GET, 'atualizado', FILTER_VALIDATE_BOOLEAN);

if (!empty($ClienteData['SendPostForm'])):
    
    unset($ClienteData['SendPostForm']);

    require('../_models/AdminGeneral.class.php');

    $atualiza = new AdminGeneral;
    $atualiza->ExeUpdate($ClienteData);

    if ($atualiza->getResult()):
        header('Location: painel.php?exe=general/general&atualizado=true');
    else:
        Notification($atualiza->getError()[0], $atualiza->getError()[1]);
    endif;

else:
    $read = new Read;
    $read->ExeRead("general", "WHERE id = :id", "id=1");
    if (!$read->getResult()):
        header('Location: painel.php?exe=general/general');
    else:
        $ClienteData = $read->getResult()[0];
    endif;
endif;

if ($atualizado):
    Notification("Configurações atualizadas com sucesso!", ACCEPT);
endif;
?>

<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <form name="form" method="post" action="?exe=general/general">

            <input type="hidden" name="logo" id="logo" value="<?php if (!empty($ClienteData['logo'])) echo $ClienteData['logo']; ?>"/>
            <div class="row">
                <h5 class="m-l-15 m-b-20">Configurações do site</h5>
                <div class="col-xs-12 col-xl-6">
                    <div class="form-group floating-labels">
                        <label for="title">Título (título do seu site)</label>
                        <input id="title" autocomplete="off" type="text" name="title" value="<?php if (!empty($ClienteData['title'])) echo $ClienteData['title']; ?>" required>
                        <p class="error-block"></p>
                    </div>
                </div>
                <div class="col-xs-12 col-xl-6">
                    <div class="form-group floating-labels">
                        <label for="analytics">ID do Google Analytics</label>
                        <input id="analytics" autocomplete="off" type="text" name="analytics" value="<?php if (!empty($ClienteData['analytics'])) echo $ClienteData['analytics']; ?>" required>
                        <p class="error-block"></p>
                    </div>
                </div>

<!--                <div class="col-xs-12 col-xl-6">
                    <label for="color">Transição do Banner (home)</label><br>
                    <label class="c-input c-radio">
                        <input id="radio1" name="banner_tipo" type="radio" value="0" <?= $ClienteData['banner_tipo'] ? '' : 'checked'; ?>>
                        <span class="c-indicator c-indicator-success"></span>
                        <span class="c-input-text">Slide</span> 
                    </label>
                    <label class="c-input c-radio">
                        <input id="radio2" name="banner_tipo" type="radio" value="1" <?= $ClienteData['banner_tipo'] ? 'checked' : ''; ?>>
                        <span class="c-indicator c-indicator-warning"></span>
                        <span class="c-input-text">Fade</span> 
                    </label>
                </div>-->
            </div>
            <div class="row">
                <div class="col-xs-12 col-xl-12">
                    <div class="form-group floating-labels">
                        <label for="description">Descrição do site (até 156 caracteres)</label>
                        <input id="description" autocomplete="off" type="text" name="description" value="<?php if (!empty($ClienteData['description'])) echo $ClienteData['description']; ?>" required>
                        <p class="error-block"></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <h5 class="m-l-15 m-b-20">Informações de contato</h5>
                <div class="col-xs-12 col-xl-12">
                    <div class="form-group floating-labels">
                        <label for="end">Endereço</label>
                        <input id="end" type="text" name="end" value="<?php if (!empty($ClienteData['end'])) echo $ClienteData['end']; ?>" />
                        <p class="error-block"></p>
                        <input type="hidden" name="lat" id="lat" value="<?php if (!empty($ClienteData['lat'])) echo $ClienteData['lat']; ?>"/>
                        <input type="hidden" name="lng" id="lng" value="<?php if (!empty($ClienteData['lng'])) echo $ClienteData['lng']; ?>"/>
                    </div>
                </div>
                
                <div class="col-xs-12 col-xl-12">
                    <div class="form-group floating-labels">
                        <label for="tel">Telefone</label>
                        <input id="tel" autocomplete="off" type="text" name="tel" value="<?php if (!empty($ClienteData['tel'])) echo $ClienteData['tel']; ?>" required>
                        <p class="error-block"></p>
                    </div>
                </div>
                
                <div class="col-xs-12 col-xl-12">
                    <div class="form-group floating-labels">
                        <label for="email">E-mail</label>
                        <input id="email" autocomplete="off" type="text" name="email" value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>">
                        <p class="error-block"></p>
                    </div>
                </div>
                
            </div>

            <div class="row">
                <h5 class="m-l-15 m-b-20">Redes Sociais</h5>
                <div class="col-xs-12 col-xl-12">
                    <?php $okLbl = '<span class="label label-rounded label-primary label-xs lbl-indication">OK</span>'; ?>
                    <div class="m-b-20 social-media">
                        <a class="btn btn-facebook btn-social m-r-10" data-id="social_fb" title="Facebook">
                            <i class="fa fa-facebook fa-2x"></i> 
                            <?php if (!empty($ClienteData['social_fb'])) echo $okLbl; ?>
                        </a>
                        <a class="btn btn-twitter btn-social m-r-10" data-id="social_tt" title="Twitter">
                            <i class="fa fa-twitter fa-2x"></i> 
                            <?php if (!empty($ClienteData['social_tt'])) echo $okLbl; ?>
                        </a>
                        <a class="btn btn-youtube btn-social m-r-10" data-id="social_yt" title="Youtube">
                            <i class="fa fa-youtube-play fa-2x"></i> 
                            <?php if (!empty($ClienteData['social_yt'])) echo $okLbl; ?>
                        </a>
                        <a class="btn btn-instagram btn-social m-r-10" data-id="social_ig" title="Instagram">
                            <i class="fa fa-instagram fa-2x"></i> 
                            <?php if (!empty($ClienteData['social_ig'])) echo $okLbl; ?>
                        </a>
                        <a class="btn btn-linkedin btn-social m-r-10" data-id="social_li" title="LinkedIn">
                            <i class="fa fa-linkedin fa-2x"></i> 
                            <?php if (!empty($ClienteData['social_li'])) echo $okLbl; ?>
                        </a>
                        <a class="btn btn-pinterest btn-social m-r-10" data-id="social_pr" title="Pinterest">
                            <i class="fa fa-pinterest-p fa-2x"></i> 
                            <?php if (!empty($ClienteData['social_pr'])) echo $okLbl; ?>
                        </a>
                        </a>
                        <a class="btn btn-google btn-social m-r-10" data-id="social_gp" title="Google Plus">
                            <i class="fa fa-google-plus fa-2x"></i> 
                            <?php if (!empty($ClienteData['social_gp'])) echo $okLbl; ?>
                        </a>
                        <a class="btn btn-xing btn-social m-r-10" data-id="social_gp" title="Xing">
                            <i class="fa fa-xing fa-2x"></i> 
                            <?php if (!empty($ClienteData['social_xi'])) echo $okLbl; ?>
                        </a>
                    </div>

                    <div class="form-group floating-labels social_fb">
                        <label for="social_fb">Url completa do Facebook (https://www.facebook.com/sua-pagina-ou-usuario)</label>
                        <input id="social_fb" autocomplete="off" type="text" name="social_fb" value="<?php if (!empty($ClienteData['social_fb'])) echo $ClienteData['social_fb']; ?>">
                        <p class="error-block"></p>
                    </div>

                    <div class="form-group floating-labels social_tt">
                        <label for="social_tt">Url completa do Twitter (https://twitter.com/sua-pagina-ou-usuario)</label>
                        <input id="social_tt" autocomplete="off" type="text" name="social_tt" value="<?php if (!empty($ClienteData['social_tt'])) echo $ClienteData['social_tt']; ?>">
                        <p class="error-block"></p>
                    </div>

                    <div class="form-group floating-labels social_yt">
                        <label for="social_yt">Url completa do You Tube (https://www.youtube.com/channel/id-do-seu-canal)</label>
                        <input id="social_yt" autocomplete="off" type="text" name="social_yt" value="<?php if (!empty($ClienteData['social_yt'])) echo $ClienteData['social_yt']; ?>">
                        <p class="error-block"></p>
                    </div>

                    <div class="form-group floating-labels social_ig">
                        <label for="social_ig">Url completa do Instagram (https://www.instagram.com/seu-nome-de-usuario)</label>
                        <input id="social_ig" autocomplete="off" type="text" name="social_ig" value="<?php if (!empty($ClienteData['social_ig'])) echo $ClienteData['social_ig']; ?>">
                        <p class="error-block"></p>
                    </div>

                    <div class="form-group floating-labels social_li">
                        <label for="social_li">Url completa do Linkedin (https://www.linkedin.com/in/id-da-sua-pagina)</label>
                        <input id="social_li" autocomplete="off" type="text" name="social_li" value="<?php if (!empty($ClienteData['social_li'])) echo $ClienteData['social_li']; ?>">
                        <p class="error-block"></p>
                    </div>

                    <div class="form-group floating-labels social_pr">
                        <label for="social_pr">Url completa do Pinterest (https://www.pinterest.com/seu-complemento)</label>
                        <input id="social_pr" autocomplete="off" type="text" name="social_pr" value="<?php if (!empty($ClienteData['social_pr'])) echo $ClienteData['social_pr']; ?>">
                        <p class="error-block"></p>
                    </div>

                    <div class="form-group floating-labels social_gp">
                        <label for="social_gp">Url completa do Google Plus (https://plus.google.com/seu-id)</label>
                        <input id="social_gp" autocomplete="off" type="text" name="social_gp" value="<?php if (!empty($ClienteData['social_gp'])) echo $ClienteData['social_gp']; ?>">
                        <p class="error-block"></p>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" name="SendPostForm" value="Salvar"/>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="bower_components/croppie/croppie.css" />
<script src="bower_components/croppie/croppie.min.js"></script>
<script src="bower_components/croppie/upload.js"></script>

<link rel="stylesheet" href="<?= CDN; ?>/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" />
<script src="<?= CDN; ?>/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>

<?php include('includes/editor.php'); ?>

<script>
    (function () {
        'use strict';

        $(function () {
            $('#img-cover').on('click', function () {
                $('#upload-crop').croppie('destroy');
                upload(354, 133 , '#logo');
            });
        });
    })();
</script>
