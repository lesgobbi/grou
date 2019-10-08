<?php
ob_start();
session_start();
require('../_app/Config.inc.php');

$login = new Login(1);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);

$readTags = new Read;
$readTags->ExeRead('general');
$tags = $readTags->getResult()[0];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Administração - <?= $tags['title']; ?></title>
        <meta name="description" content="<?= $tags['description']; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="googlebot" content="noindex" />
        <meta name="robots" content="nofollow,noindex"/>
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="<?= CDN; ?>/styles/bootstrap.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900,900italic" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/1.0.0/css/flag-icon.min.css"/>
        <link rel="stylesheet" href="<?= CDN; ?>/styles/cache/main.css" />
        <link rel="stylesheet" href="<?= CDN; ?>/bower_components/chosen/chosen.css"/>
        
        <script src="<?= CDN; ?>/bower_components/jquery/dist/jquery.js"></script>
        <script src="<?= CDN; ?>/bower_components/tether/dist/js/tether.js"></script>
        <script src="<?= CDN; ?>/bower_components/bootstrap/dist/js/bootstrap.js"></script>
        <script src="<?= CDN; ?>/bower_components/bootstrap-validator/dist/validator.min.js"></script>
        <script src="<?= CDN; ?>/bower_components/PACE/pace.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.0.0/lodash.min.js"></script>
        <script src="<?= CDN; ?>/scripts/components/jquery-fullscreen/jquery.fullscreen-min.js"></script>
        <script src="<?= CDN; ?>/bower_components/jquery-storage-api/jquery.storageapi.min.js"></script>
        <script src="<?= CDN; ?>/bower_components/chosen/chosen.jquery.min.js"></script>
        <script src="<?= CDN; ?>/bower_components/notifyjs/dist/notify.js"></script>
        
        <script src="<?= CDN; ?>/scripts/components/floating-labels.js"></script>
        <script src="scripts/colors.js"></script>
        <script src="scripts/left-sidebar.js"></script>
        <script src="scripts/navbar.js"></script>
        <script src="scripts/main.js"></script>
        <script src="scripts/functions.js"></script>
        <style>[data-layout="default-sidebar"] .main {padding-top: 80px; padding-left: 250px; padding-right: 30px;}</style>
        
        <?php
        if (!empty($getexe)):
            $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . strip_tags(trim($getexe) . '.php');
        else:
            $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'home.php';
        endif;

        $js = explode('/', $getexe);
        $includejs = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . strip_tags(trim($js[0]) . DIRECTORY_SEPARATOR . strip_tags(trim($js[0])) . '.js');
        if (file_exists($includejs)):
            echo '<script src="system/' . strip_tags(trim($js[0])) . '/' . strip_tags(trim($js[0])) . '.js' . '"></script>';
        endif;
        ?>
    </head>
    <body data-layout="default-sidebar" data-palette="palette-8">
        <?php include('includes/nav.inc.php'); ?>
        <div class="container-fluid">
            <div class="row">
                <?php include('includes/sidebar.inc.php'); ?>
                <div class="col-xs-12 main" id="main">
                    <div class="row m-b-20">
                        <div class="col-xs-12">
                        <?php
                            if (file_exists($includepatch)):
                                require_once($includepatch);
                            else:
                                Notification("<strong>Erro ao incluir tela:</strong> Erro ao incluir o controller /{$getexe}.php!", ERROR);
                            endif;
                        ?>
                        </div>
                    </div>

                    <div class="footer">
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="http://www.radiati.com.br" target="_blank">© <?= date('Y'); ?>. Radiati Comunicação.</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <link rel="stylesheet" href="styles/custom.css"/>

        <script>
            (function() {
                'use strict';

                $(function() {
                    $('a[data-original-title="Remover"]').on('click', function(){
                        var self = $(this);
                        $('#confirm').modal({
                            backdrop: 'static',
                            keyboard: false
                        }).one('click', '#delete-true', function(e) {
                            window.location.href = self.attr('href');
                        });
                        return false;
                    });
                });
            })();
        </script>

        <div id="confirm" class="modal fade" role="dialog">
            <div class="modal-dialog">        
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tem certeza que deseja excluir o item selecionado?</h4>
                    </div>
                    
                    <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete-true">Sim</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">Não</button>
                </div>
                </div>

            </div>
        </div>

        <div id="print">
            <img src="<?= HOME; ?>/assets/img/logo.png" style="width: 200px;"/><br><br>
            <div class="content"></div>
        </div>

        <style>
            @media screen{
                #print {
                    display: none;
                }
            }
        </style>
    </body>        
</html>
<?php
ob_end_flush();