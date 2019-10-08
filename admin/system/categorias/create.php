<div class="row">
    <div class="col-xs-12">
        <h3>Cadastrar Categoria</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=categorias/categorias">Categorias</a> 
    </li>
    <li class="active">Nova Categoria</li>
</ol>

<?php
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if (!empty($data['SendPostForm'])):
        unset($data['SendPostForm']);

        require('../_models/AdminCategory.class.php');
        $cadastra = new AdminCategory;
        $cadastra->ExeCreate($data);

        if (!$cadastra->getResult()):
            Notification($cadastra->getError()[0], $cadastra->getError()[1]);
        else:
            header('Location: painel.php?exe=categorias/update&create=true&catid=' . $cadastra->getResult());
        endif;
    endif;
?>

<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <form name="form" method="post">
            <input type="hidden" name="category_date" value="<?= date('d/m/Y H:i:s'); ?>" />
            <div class="row">
                <div class="col-xs-12 col-xl-12">
                    <div class="form-group floating-labels">
                        <label for="category_name">Título</label>
                        <input id="category_name" autocomplete="off" type="text" name="category_title" value="<?php if (!empty($ClienteData['category_title'])) echo $ClienteData['category_title']; ?>" required>
                        <p class="error-block"></p>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Cadastrar Categoria" name="SendPostForm"/>
            </div>
        </form>
    </div>
</div>