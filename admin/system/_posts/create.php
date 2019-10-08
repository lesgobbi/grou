<div class="row">
    <div class="col-xs-12">
        <h3>Cadastrar Post</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=home">Dashboard</a></li>
    <li><a href="?exe=posts/posts">Posts</a></li>
    <li class="active">Novo Post</li>
</ol>

<?php
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (isset($post) && $post['SendPostForm']):
    $post['post_status'] = '1';
    unset($post['SendPostForm']);
    require('../_models/AdminPost.class.php');
    require('../_models/AdminCategory.class.php');
    $Category = new AdminCategory;
    
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
                                $readSes = new Read;
                                $readSes->ExeRead("categories", "WHERE category_parent IS NULL ORDER BY category_title ASC");
                                if ($readSes->getRowCount() >= 1):
                                    foreach ($readSes->getResult() as $ses):
                                        $readCat = new Read;
                                        $readCat->ExeRead("categories", "WHERE category_parent = :parent ORDER BY category_title ASC", "parent={$ses['category_id']}");

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
                                    endforeach;
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="bower_components/editor/css/froala_editor.css">
<link rel="stylesheet" href="bower_components/editor/css/froala_style.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/code_view.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/colors.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/emoticons.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/image_manager.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/image.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/line_breaker.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/table.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/char_counter.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/video.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/fullscreen.css">
<link rel="stylesheet" href="bower_components/editor/css/plugins/file.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/at.js/1.4.0/css/jquery.atwho.min.css">

<script src="bower_components/editor/js/froala_editor.min.js" ></script>
<script src="bower_components/editor/js/plugins/align.min.js"></script>
<script src="bower_components/editor/js/plugins/code_beautifier.min.js"></script>
<script src="bower_components/editor/js/plugins/code_view.min.js"></script>
<script src="bower_components/editor/js/plugins/colors.min.js"></script>
<script src="bower_components/editor/js/plugins/draggable.min.js"></script>
<script src="bower_components/editor/js/plugins/emoticons.min.js"></script>
<script src="bower_components/editor/js/plugins/font_size.min.js"></script>
<script src="bower_components/editor/js/plugins/font_family.min.js"></script>
<script src="bower_components/editor/js/plugins/image.min.js"></script>
<script src="bower_components/editor/js/plugins/file.min.js"></script>
<script src="bower_components/editor/js/plugins/image_manager.min.js"></script>
<script src="bower_components/editor/js/plugins/line_breaker.min.js"></script>
<script src="bower_components/editor/js/plugins/link.min.js"></script>
<script src="bower_components/editor/js/plugins/lists.min.js"></script>
<script src="bower_components/editor/js/plugins/paragraph_format.min.js"></script>
<script src="bower_components/editor/js/plugins/paragraph_style.min.js"></script>
<script src="bower_components/editor/js/plugins/video.min.js"></script>
<script src="bower_components/editor/js/plugins/table.min.js"></script>
<script src="bower_components/editor/js/plugins/url.min.js"></script>
<script src="bower_components/editor/js/plugins/entities.min.js"></script>
<script src="bower_components/editor/js/plugins/char_counter.min.js"></script>
<script src="bower_components/editor/js/plugins/inline_style.min.js"></script>
<script src="bower_components/editor/js/plugins/save.min.js"></script>
<script src="bower_components/editor/js/plugins/fullscreen.min.js"></script>
<script src="bower_components/editor/js/plugins/quote.min.js"></script>
<script src="bower_components/editor/js/languages/pt_br.js"></script>

<link rel="stylesheet" href="bower_components/croppie/croppie.css" />
<script src="bower_components/croppie/croppie.min.js"></script>
<script src="bower_components/croppie/upload.js"></script>