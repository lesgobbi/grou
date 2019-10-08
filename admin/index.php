<?php

ob_start();
session_start();
require('../_app/Config.inc.php');

$login = new Login(1);
if ($login->CheckLogin()):
    header('Location: painel.php');
else:
    header('Location: login.php');
endif;
?>