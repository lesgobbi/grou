<div class="row">
    <div class="col-xs-12">
        <h3>Cadastrar Página</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=posts/posts">Páginas</a></li>
    <li class="active">Nova Página</li>
</ol>

<?php
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (isset($post) && $post['SendPostForm']):
    $post['post_status'] = '1';
    unset($post['SendPostForm']);
    require('../_models/AdminPost.class.php');
    
    $cadastra = new AdminPost;
    $cadastra->ExeCreate($post);

    if ($cadastra->getResult()):
        header('Location: painel.php?exe=posts/update&create=true&postid=' . $cadastra->getResult());
    else:
        Notification($cadastra->getError()[0], $cadastra->getError()[1]);
    endif;
endif;
?>

<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <div class="row">

            <div class="col-xs-12 col-xl-12">
                <fieldset class="form-group m-b-20 croppie-ct">
                    <label>Imagem de Capa</label>

                    <div class="upload-container">
                        <div class="actions">
                            <a class="btn btn-primary m-r-10 m-b-10 file-btn" id="img-cover">
                                <span>Upload</span>
                                <input type="file" id="upload" value="Choose a file" accept="image/*" />
                            </a>
                        </div>
                        <div id="upload-crop"></div>
                        <button class="upload-result btn btn-primary m-r-10 m-b-10">Pronto</button>
                    </div>
                    
                </fieldset>
            </div>
        </div>

        <form name="form-cad" method="post">
            <input type="hidden" name="post_date" value="<?= date('d/m/Y H:i:s'); ?>" />
            <input type="hidden" name="post_cover" id="post_cover"/>
            <div class="row">                
                <div class="col-xs-12 col-xl-12">
                    <fieldset class="form-group m-b-20">
                        <label for="post_chamada">Chamada</label>
                        <textarea name="post_chamada" class="post_chamada" class="form-control" rows="4"><?php if (isset($post['post_chamada'])) echo $post['post_chamada']; ?></textarea>
                    </fieldset>

                    <div class="form-group floating-labels">
                        <label for="post_title">Título</label>
                        <input id="post_title" autocomplete="off" type="text" name="post_title" value="<?php if (isset($post['post_title'])) echo $post['post_title']; ?>" required>
                        <p class="error-block"></p>
                    </div>
                </div>
                                
                <div class="col-xs-12 col-xl-12">
                    <fieldset class="form-group m-b-20">
                        <label for="post_content">Conteúdo</label>
                        <textarea name="post_content" id="post_content" class="form-control" rows="4"><?php if (isset($post['post_content'])) echo $post['post_content']; ?></textarea>
                    </fieldset>

                    <fieldset class="form-group">
                        <label>Categoria</label>
                        <select class="chosen-select" name="post_category" data-placeholder="Selecione a Categoria..." required>
                            <option></option>
                            <?php
                                $readCat = new Read;
                                $readCat->ExeRead("categories", "ORDER BY category_title ASC");
                                if ($readCat->getRowCount() >= 1):
                                    echo "<optgroup label='{$ses['category_title']}'>";
                                        foreach ($readCat->getResult() as $cat):
                                            echo "<option ";
                                            if (isset($post['post_category']) && $post['post_category'] == $cat['category_id']):
                                                echo "selected=\"selected\" ";
                                            endif;
                                            echo "value=\"{$cat['category_id']}\">{$cat['category_title']} </option>";
                                        endforeach;
                                    echo "</optgroup>";
                                endif;
                        ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </fieldset>
                </div>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Cadastrar Post" name="SendPostForm"/>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="bower_components/croppie/croppie.css" />
<script src="bower_components/croppie/croppie.min.js"></script>
<script src="bower_components/croppie/upload.js"></script>

<?php include('includes/editor.php'); ?>