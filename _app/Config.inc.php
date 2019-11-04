<?php
date_default_timezone_set("America/Sao_Paulo");
// CONFIGRAÇÕES DO BANCO ####################

//define('HOST', 'localhost');
//define('USER', 'root');
//define('PASS', 'root');
//define('DBSA', 'grou');

define('HOST', '108.167.188.182');
define('USER', 'focoi382_grou');
define('PASS', 'Si=MTa;m]![^');
define('DBSA', 'focoi382_grou');

// CONFIGRAÇÕES DE EMAIL ####################
define('MAILUSER', 'contato@jeanreis.com');
define('MAILPASS', 'Ampd7188');
define('MAILPORT', '465');
define('MAILHOST', 'br166.hostgator.com.br');

// DEFINE IDENTIDADE DO SITE ################
define('CLIENT_NAME', 'Grou');
define('UPLOAD_ROOT', $_SERVER['DOCUMENT_ROOT'].'/grou');
//define('UPLOAD_ROOT', $_SERVER['DOCUMENT_ROOT'].'/clientes/grou');
//define('UPLOAD_ROOT', $_SERVER['DOCUMENT_ROOT']);

// DEFINE O TIPO DE NAVEGAÇÃO DO SITE ################
// define('NAVIGATION', 'S');
define('NAVIGATION', 'M');
// DEFINE A BASE DO SITE ####################
//define('HOME', 'http://focoimg.com.br/clientes/grou');
define('HOME', 'http://localhost:8888/grou');

define('CDN', 'https://lesgobbi.github.io/cdn');

define('INCLUDE_PATH', HOME);
define('REQUIRE_PATH', 'pages');

// AUTO LOAD DE CLASSES ####################
function __autoload($Class) {

    $cDir = ['Conn', 'Helpers', 'Models'];
    $iDir = null;

    foreach ($cDir as $dirName):
        
        if (!$iDir && file_exists(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php') && !is_dir(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php')):
            include_once (__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php');
            $iDir = true;
        endif;
    endforeach;

    if (!$iDir):
        trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}

// TRATAMENTO DE ERROS #####################
//CSS constantes :: Mensagens de Erro
define('PRIMARY', 'alert-primary');
define('DEFAULT', 'alert-default');
define('ACCEPT', 'alert-success');
define('INFOR', 'alert-info');
define('ALERT', 'alert-warning');
define('ERROR', 'alert-danger');

//Erro :: Exibe erros lançados :: Front
function Notification($ErrMsg, $ErrNo, $ErrDie = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? INFOR : ($ErrNo == E_USER_WARNING ? ALERT : ($ErrNo == E_USER_ERROR ? ERROR : $ErrNo)));
    echo '<div class="alert ' . $CssClass . ' animated fadeIn" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                <span class="sr-only">Fechar</span>
            </button>' . $ErrMsg .
    '</div>';

    if ($ErrDie):
        die;
    endif;
}

//PHPErro :: personaliza o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? INFOR : ($ErrNo == E_USER_WARNING ? ALERT : ($ErrNo == E_USER_ERROR ? ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">";
    echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_close\"></span></p>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPErro');
