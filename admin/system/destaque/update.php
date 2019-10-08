<div class="row">
    <div class="col-xs-12">
        <h3>Atualizar Destaque</h3>
    </div>
</div>

<?php
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$postid = 2;

require('../_models/AdminPost.class.php');

if (isset($post) && isset($post['SendPostForm'])):
    unset($post['SendPostForm']);

    $cadastra = new AdminPost;
    $cadastra->ExeUpdate($postid, $post);

    Notification($cadastra->getError()[0], $cadastra->getError()[1]);
endif;

$read = new Read;
$read->ExeRead("posts", "WHERE post_id = :id", "id={$postid}");
if (!$read->getResult()):
    header('Location: painel.php?exe=posts/index&empty=true');
else:
    $post = $read->getResult()[0];
    $post['post_date'] = date('d/m/Y H:i:s', strtotime($post['post_date']));
endif;
?>

<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <div class="row">
            <div class="col-xs-12 col-xl-12">
                <div class="upload-container">
                    <div class="actions">
                        <a class="btn btn-primary m-r-10 m-b-10 file-btn m-t-20" id="img-cover">
                            <span>Upload Imagem de Fundo</span>
                            <input type="file" id="upload" value="Choose a file" accept="image/*" />
                        </a>
                    </div>
                    <div id="upload-crop"></div>
                    <button class="upload-result btn btn-primary m-r-10 m-b-10">Pronto</button>
                </div>

                <fieldset class="form-group m-b-20 croppie-ct">
                    <label style="display: block;">Imagem de Fundo</label>
                    <?php
                    if (isset($post['post_cover']) && $post['post_cover'] != ''):
                        echo '<img src="../tim.php?src=/uploads/' . $post['post_cover'] . '&w=520&h=520" class="img-cropped" id="imgcover"/>';
                    endif;
                    ?>
                </fieldset>
            </div>
        </div>

        <form name="form-cad" method="post" action="?exe=destaque/update">
            <input type="hidden" name="post_date" value="<?= date('d/m/Y H:i:s'); ?>" />
            <input type="hidden" name="post_cover" id="post_cover" value="<?php if (isset($post['post_cover'])) echo $post['post_cover']; ?>"/>
            <input type="hidden" name="post_category" value="999"/>
            <input type="hidden" name="post_title" value="<?= $post['post_title']; ?>"/>
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
                        <label>Texto Destaque</label>
                        <textarea id="post_content" name="post_content" class="post_content" rows="4"><?php if (isset($post['post_content'])) echo $post['post_content']; ?></textarea>
                    </fieldset>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Atualizar" name="SendPostForm"/>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="bower_components/croppie/croppie.css" />
<script src="bower_components/croppie/croppie.min.js"></script>
<script src="bower_components/croppie/upload.js"></script>

<?php include('includes/editor.php'); ?>