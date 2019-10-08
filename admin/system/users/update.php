<div class="row">
    <div class="col-xs-12">
        <h3>Atualizar Usuário</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=users/users">Usuários</a> 
    </li>
    <li class="active">Atualizar Usuário</li>
</ol>

<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$userId = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);

if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);

    require('../_models/AdminUser.class.php');
    $cadastra = new AdminUser;
    $cadastra->ExeUpdate($userId, $ClienteData);

    Notification($cadastra->getError()[0], $cadastra->getError()[1]);
else:
    $ReadUser = new Read;
    $ReadUser->ExeRead("users", "WHERE user_id = :userid", "userid={$userId}");
    if ($ReadUser->getResult()):
        $ClienteData = $ReadUser->getResult()[0];
        unset($ClienteData['user_password']);
    endif;
endif;

$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
if ($checkCreate && empty($cadastra)):
    Notification("O usuário <b>{$ClienteData['user_name']}</b> foi cadastrado com sucesso no sistema!", ACCEPT);
endif;
?>

<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <form name="form" method="post">
            <div class="row">
                <div class="col-xs-12 col-xl-6">
                    <div class="form-group floating-labels">
                        <label for="firstname">Nome</label>
                        <input id="firstname" autocomplete="off" type="text" name="user_name" value="<?php if (!empty($ClienteData['user_name'])) echo $ClienteData['user_name']; ?>">
                        <p class="error-block"></p>
                    </div>
                </div>
                <div class="col-xs-12 col-xl-6">
                    <div class="form-group floating-labels">
                        <label for="email">Email</label>
                        <input id="email" autocomplete="off" type="email" name="user_email" value="<?php if (!empty($ClienteData['user_email'])) echo $ClienteData['user_email']; ?>">
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
            
            <div class="row">
                <div class="col-xs-12 col-xl-6">
                    <label for="user_level">Selecione o nível de usuário</label>
                    <fieldset class="form-group">
                        <label class="c-input c-radio">
                            <input id="radio1" name = "user_level" type="radio" value="1" <?php if (isset($ClienteData['user_level']) && $ClienteData['user_level'] == 1) echo 'checked="check"';  ?> required>
                            <span class="c-indicator c-indicator-success"></span>
                            Parceiro
                        </label>
                        <label class="c-input c-radio">
                            <input id="radio1" name = "user_level" type="radio" value="3" <?php if (isset($ClienteData['user_level']) && $ClienteData['user_level'] == 3) echo 'checked="check"'; ?> required>
                            <span class="c-indicator c-indicator-success"></span>
                            Admin
                        </label>
                    </fieldset>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" name="SendPostForm" value="Atualizar Usuário"/>
            </div>
        </form>
    </div>
</div>