<?php
ob_start();
session_start();
require('../_app/Config.inc.php');
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Administração - Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="favicon.ico">
        <!-- global stylesheets -->
        <link rel="stylesheet" href="<?= CDN; ?>/styles/bootstrap.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?= CDN; ?>/styles/cache/main.css" />
        <style>[data-layout="default-sidebar"] .main { padding-left: 30px; padding-top: 0;}</style>
    </head>
    <body data-layout="empty-view">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 main" id="main">
                    <div class="login-page text-center">
                        <h1>
                            Administração Login
                        </h1>
                        <h4>
                            Por favor informe e-mail e senha para logar
                        </h4>
                        
                        <div class="row">
                            <div class="col-xs-offset-2 col-xs-8 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4">
                                
                                <?php
                                    $login = new Login(1);
                                    
                                    if ($login->CheckLogin()):
                                        header('Location: painel.php');
                                    endif;

                                    $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                                    if (!empty($dataLogin['AdminLogin'])):

                                        $login->ExeLogin($dataLogin);
                                        if (!$login->getResult()):
                                            Notification($login->getError()[0], $login->getError()[1]);
                                        else:
                                            header('Location: painel.php');
                                        endif;

                                    endif;

                                    $get = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
                                    if (!empty($get)):
                                        if ($get == 'restrito'):
                                            Notification('<strong>Acesso negado. </strong> Favor efetue login para acessar o painel!', ALERT);
                                        elseif ($get == 'logoff'):
                                            Notification('<strong>Sucesso ao deslogar: </strong> Sua sessão foi finalizada.', ACCEPT);
                                        elseif ($get == 'recovery'):
                                            Notification('<strong>Senha alterada com sucesso! </strong>Efetue seu acesso com a nova senha.', ACCEPT);
                                        endif;
                                    endif;
                                ?>
                                
                                <form name="form" novalidate class="form" method="post">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group floating-labels user-lbl">
                                                <label for="user">Nome ou Email</label>
                                                <input id="email" autocomplete="off" type="email" name="user" value="<?= isset($_POST['user']) ? $_POST['user'] : ''; ?>">
                                                <p class="error-block"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-b-40">
                                        <div class="col-xs-12">
                                            <div class="form-group floating-labels">
                                                <label for="pass">Senha</label>
                                                <input id="password" autocomplete="off" type="password" name="pass">
                                                <p class="error-block"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row buttons">
                                        <div class="col-xs-12 col-md-12">
                                            <input type="submit" name="AdminLogin" class="btn btn-lg btn-info btn-block m-b-20" value="Login">
                                        </div>
                                    </div>
                                </form>
                                <p class="m-b-20">Esqueceu sua senha? <a class="link" href="forgot-password.php">Clique aqui para recuperar o acesso!</a></p>
                            </div>
                        </div>
                        <p class="copyright text-sm">Copyright &copy; <?= date('Y'); ?> Radiati Comunicação. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- global scripts -->
        <script src="<?= CDN; ?>/bower_components/jquery/dist/jquery.js"></script>
        <script src="<?= CDN; ?>/bower_components/tether/dist/js/tether.js"></script>
        <script src="<?= CDN; ?>/bower_components/bootstrap/dist/js/bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.0.0/lodash.min.js"></script>
        <script src="<?= CDN; ?>/bower_components/jquery-storage-api/jquery.storageapi.min.js"></script>
        <script src="<?= CDN; ?>/scripts/components/floating-labels.js"></script>
        <script src="scripts/functions.js"></script>
        <script src="scripts/colors.js"></script>
        <script src="scripts/main.js"></script>
        <script src="scripts/login.js"></script>
    </body>
</html>
