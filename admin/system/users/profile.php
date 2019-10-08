<?php
extract($_SESSION['userlogin-' . CLIENT_NAME]);
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$userId = $_SESSION['userlogin-' . CLIENT_NAME]['user_id'];

if ($ClienteData && $ClienteData['SendPostForm']):
    
    unset($ClienteData['SendPostForm']);
    extract($ClienteData);
    
    require('../_models/AdminUser.class.php');
    $cadastra = new AdminUser;
    $cadastra->ExeUpdate($userId, $ClienteData);

    if ($cadastra->getResult()):
        Notification("<strong>Seus dados foram atualizados com sucesso!</strong> O sistema será atualizado no seu próximo login.", ACCEPT);
    else:
        Notification($cadastra->getError()[0], $cadastra->getError()[1]);
    endif;
else:
    extract($_SESSION['userlogin-' . CLIENT_NAME]);
endif;
?>

<div class="row">
    <div class="col-xs-12">
        <h3>Olá <?= $user_name; ?></h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=users/users">Usuários</a> 
    </li>
    <li class="active">Meus Dados</li>
</ol>

<div class="row m-b-20">
    <div class="col-xs-12 col-xl-6">
        <h4>atualize meus dados</h4>
    </div>
</div>

<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <form name="form" method="post">
            <div class="row">
                <div class="col-xs-12 col-xl-6">
                    <div class="form-group floating-labels">
                        <label for="firstname">Nome</label>
                        <input id="firstname" autocomplete="off" type="text" name="user_name" value="<?= $user_name; ?>">
                        <p class="error-block"></p>
                    </div>
                </div>
                <div class="col-xs-12 col-xl-6">
                    <div class="form-group floating-labels">
                        <label for="email">Email</label>
                        <input id="email" autocomplete="off" type="email" name="user_email" value="<?= $user_email; ?>">
                        <p class="error-block"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-xl-6">
                    <div class="form-group floating-labels">
                        <label for="password">Senha</label>
                        <input id="password" autocomplete="off" type="password" name="user_password">
                        <p class="error-block"></p>
                    </div>
                </div>
                <div class="col-xs-12 col-xl-6">
                    <div class="form-group floating-labels">
                        <label for="confirm-password">Confirmar Senha</label>
                        <input id="confirm-password" autocomplete="off" type="password">
                        <p class="error-block"></p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" name="SendPostForm" value="Atualizar Perfil"/>
            </div>
        </form>
    </div>
</div>

<?php

