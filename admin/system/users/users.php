<div class="row">
    <div class="col-xs-12">
        <h3>Usuários</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li class="active">Usuários</li>
</ol>

<a href="painel.php?exe=users/create" class="btn btn-primary m-r-10 m-b-10">Cadastrar Novo Usuário</a>

<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
if ($delete):
    require('../_models/AdminUser.class.php');
    $delUser = new AdminUser;
    $delUser->ExeDelete($delete);
    Notification($delUser->getError()[0], $delUser->getError()[1]);
endif;
?>

<div class="row m-b-20">
    <div class="col-xs-12">
        <table class="table table-hover table-striped sortable-theme-bootstrap" id="itens-table" data-sortable>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data de Cadastro</th>
                    <th>Nível</th>
                    <th width="80" data-sortable="false">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $read = new Read;
                $read->ExeRead("users", "WHERE user_id != -1 AND user_id != 1 ORDER BY user_level DESC, user_name ASC");
                if ($read->getResult()):
                    foreach ($read->getResult() as $user):
                        extract($user);
                        $user_lastupdate = ($user_lastupdate ? date('d/m/Y H:i', strtotime($user_lastupdate)) . ' hs' : '-');
                        $nivel = ['', 'Parceiro', '', 'Admin'];
                        ?>
                        <tr>
                            <th><?= $user_name; ?></th>
                            <td><?= $user_email; ?></td>
                            <td><?= date('d/m/Y', strtotime($user_registration)); ?></td>
                            <td>
                                <span class="m-r-10 label <?= $nivel[$user_level] == 'Parceiros' ? 'label-primary' : 'label-success'; ?> label-lg"><?= $nivel[$user_level]; ?></span>
                            </td>
                            <td style="min-width: 75px;">
                                <a href="painel.php?exe=users/update&userid=<?= $user_id; ?>" class="btn btn-primary btn-circle m-r-5" title="Editar" data-toggle="tooltip" data-placement="top" style="height: 13px;"><i class="fa fa-edit"></i></a>
                                <a href="painel.php?exe=users/users&delete=<?= $user_id; ?>" class="btn btn-danger btn-circle m-r-5" title="Remover" data-toggle="tooltip" data-placement="top" style="height: 13px;"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>