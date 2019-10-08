<div class="row">
    <div class="col-xs-12">
        <h3>Categorias</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li class="active">Categorias</li>
</ol>

<a href="painel.php?exe=categorias/create" class="btn btn-primary m-r-10 m-b-10">Cadastrar Nova Categoria</a>

<?php
$empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
if ($empty):
    Notification("Você tentou editar uma categoria que não existe no sistema!", INFOR);
endif;

$delCat = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
if ($delCat):
    require ('../_models/AdminCategory.class.php');
    $deletar = new AdminCategory;
    $deletar->ExeDelete($delCat);

    Notification($deletar->getError()[0], $deletar->getError()[1]);
endif;
?>

<div class="row m-b-20">
    <div class="col-xs-12">
        <table class="table table-hover table-striped sortable-theme-bootstrap" id="itens-table" data-sortable>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data de Cadastro</th>
                    <th width="100" data-sortable="false">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $read = new Read;
                $read->ExeRead("categories", "ORDER BY category_title ASC");
                if ($read->getResult()):
                    foreach ($read->getResult() as $category):
                        extract($category);
                        if (!$category_parent):
                            ?>
                            <tr>
                                <td class="color-primary"><?= $category_title; ?></td>
                                <td><span class="clip-text clip-text-table-desc"><?= $category_content; ?></span></td>
                                <td><?= date('d/m/Y', strtotime($category_date)); ?></td>
                                <td style="min-width: 100px;">
                                    <a href="painel.php?exe=categorias/update&catid=<?= $category_id; ?>" class="btn btn-primary btn-circle m-r-5" title="Editar" data-toggle="tooltip" data-placement="top" style="box-sizing: border-box;"><i class="fa fa-edit"></i></a>
                                    <a href="painel.php?exe=categorias/categorias&delete=<?= $category_id; ?>" class="btn btn-danger btn-circle m-r-5" title="Remover" data-toggle="tooltip" data-placement="top" style="box-sizing: border-box;"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                            foreach ($read->getResult() as $subcategory):
                                if ($category_id == $subcategory['category_parent']):
                                    ?>
                                    <tr>
                                        <td style="font-weight: normal;">
                                            <label class="color-primary" style="margin-bottom: 0;">
                                                <?= $category_title; ?>
                                                <i class="fa fa-caret-right color-primary"></i>
                                            </label>
                                            <span style="font-weight: bold;"><?= $subcategory['category_title']; ?></span>
                                        </td>
                                        <td><span class="clip-text clip-text-table-desc"><?= $subcategory['category_content']; ?></span></td>
                                        <td><?= date('d/m/Y', strtotime($subcategory['category_date'])); ?></td>
                                        <td style="min-width: 100px;">
                                            <a href="painel.php?exe=categorias/update&catid=<?= $subcategory['category_id']; ?>" class="btn btn-primary btn-circle m-r-5" title="Editar" data-toggle="tooltip" data-placement="top" style="box-sizing: border-box;"><i class="fa fa-edit"></i></a>
                                            <a href="painel.php?exe=categorias/categorias&delete=<?= $subcategory['category_id']; ?>" class="btn btn-danger btn-circle m-r-5" title="Remover" data-toggle="tooltip" data-placement="top" style="box-sizing: border-box;"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                    endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>

<link rel="stylesheet" href="<?= CDN; ?>/bower_components/dragula.js/dist/dragula.css" />
<script src="<?= CDN; ?>/bower_components/dragula.js/dist/dragula.js"></script>

<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
