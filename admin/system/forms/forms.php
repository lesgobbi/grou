<div class="row">
    <div class="col-xs-12">
        <h3>Formulários</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li class="active">Formulários</li>
</ol>

<?php
$action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
if ($action):
    require ('../_models/AdminForm.class.php');

    $formAction = filter_input(INPUT_GET, 'form', FILTER_VALIDATE_INT);
    $formUpdate = new AdminForm;

    switch ($action):

        case 'delete':
            $formUpdate->ExeDelete($formAction);
            Notification($formUpdate->getError()[0], $formUpdate->getError()[1]);
            break;

        default :
            Notification("Ação não foi identificada pelo sistema, favor utilize os botões!", ALERT);
    endswitch;
endif;

$readForms = new Read;
$readForms->ExeRead("forms", "ORDER BY form_nome ASC");
?>

<div class="row m-b-20">
    <div class="col-xs-12">
        <table class="table table-hover table-striped" id="itens-table">
            <thead>
                <tr>
                    <th data-sortable="true" data-sorted="true">Nome</th>
                    <th width="60" data-sortable="false">Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($readForms->getResult()):
                    foreach ($readForms->getResult() as $form):
                        ?>
                        <tr>
                            <td style="vertical-align: middle;"><?= $form['form_nome']; ?></td>
                            <td>
                                <a href="painel.php?exe=forms/update&formid=<?= $form['form_id']; ?>" class="btn btn-primary btn-circle m-r-5" title="Editar" data-toggle="tooltip" data-placement="top" style="height: 14px; "><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>

                        <?php
                    endforeach;
                else:
                    Notification("Desculpe, ainda não existem formulários cadastrados!", INFOR);
                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>