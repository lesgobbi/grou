<div class="row">
    <div class="col-xs-12">
        <h3>Atualizar Categoria</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=categorias/categorias">Categorias</a></li>
    <li class="active">Atualizar Categoria</li>
</ol>

<?php
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$catid = filter_input(INPUT_GET, 'catid', FILTER_VALIDATE_INT);

$children = false;

if (!empty($data['SendPostForm'])):
    unset($data['SendPostForm']);

    require('../_models/AdminCategory.class.php');
    $cadastra = new AdminCategory;
    $cadastra->ExeUpdate($catid, $data);

    Notification($cadastra->getError()[0], $cadastra->getError()[1]);
else:
    $read = new Read;
    $read->ExeRead("categories", "WHERE category_id = :id", "id={$catid}");
    if (!$read->getResult()):
        header('Location: painel.php?exe=categorias/index&empty=true');
    else:
        $data = $read->getResult()[0];
    endif;
endif;

$readAll = new Read;
$readAll->ExeRead("categories", "WHERE category_parent = :category_parent", "category_parent={$catid}");
if ($readAll->getResult()):
    $children = true;
endif;

$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
?>

<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <form name="form" method="post">
            <input type="hidden" name="category_date" value="<?= date('d/m/Y H:i:s'); ?>" />
            <div class="row">
                <div class="col-xs-12 col-xl-12">
                    <div class="form-group floating-labels">
                        <label for="category_name">Título</label>
                        <input id="category_name" autocomplete="off" type="text" name="category_title" value="<?php if (isset($data)) echo $data['category_title']; ?>">
                        <p class="error-block"></p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Atualizar Categoria" name="SendPostForm"/>
            </div>
        </form>
    </div>
    
</div>
