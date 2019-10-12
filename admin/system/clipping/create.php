<div class="row">
    <div class="col-xs-12">
        <h3>Cadastrar Clipping</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=clipping/clipping">Clippings</a></li>
    <li class="active">Novo Clipping</li>
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
        header('Location: painel.php?exe=clipping/update&create=true&postid=' . $cadastra->getResult());
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
                            <a class="btn btn-primary m-r-10 m-b-10 file-btn" id="img-cover" data-width="600" data-height="375">
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
            <input type="hidden" name="post_category" value="4"/>
            <div class="row">
                <div class="col-xs-12 col-xl-12">
                    <div class="form-group floating-labels">
                        <label for="post_title">Título</label>
                        <input id="post_title" autocomplete="off" type="text" name="post_title" value="<?php if (isset($post['post_title'])) echo $post['post_title']; ?>" required>
                        <p class="error-block"></p>
                    </div>
                </div>

                <div class="col-xs-12 col-xl-12">
                    <div class="form-group floating-labels">
                        <label for="post_url">URL imagem</label>
                        <input id="post_url" autocomplete="off" type="text" name="post_cover_featured" value="<?php if (isset($post['post_cover_featured'])) echo $post['post_cover_featured']; ?>">
                        <p class="error-block"></p>
                    </div>
                </div>

                <div class="col-xs-12 col-xl-12">
                    <div class="form-group floating-labels">
                        <label for="post_url">Link</label>
                        <input id="post_url" autocomplete="off" type="text" name="post_link" value="<?php if (isset($post['post_link'])) echo $post['post_link']; ?>">
                        <p class="error-block"></p>
                    </div>
                </div>

                <div class="col-xs-12 col-xl-12">
                    <fieldset class="form-group m-b-20">
                        <label for="post_content">Conteúdo</label>
                        <textarea name="post_content" id="post_content" class="form-control" rows="4"><?php if (isset($post['post_content'])) echo $post['post_content']; ?></textarea>
                    </fieldset>
                </div>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Cadastrar Clipping" name="SendPostForm"/>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="bower_components/croppie/croppie.css" />
<script src="bower_components/croppie/croppie.min.js"></script>
<script src="bower_components/croppie/upload.js"></script>

<?php include('includes/editor.php'); ?>