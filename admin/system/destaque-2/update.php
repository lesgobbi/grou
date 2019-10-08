<div class="row">
    <div class="col-xs-12">
        <h3>Atualizar Destaque 2<small> abaixo de projetos</small></h3>
    </div>
</div>

<?php
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$postid = 4;

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
        <form name="form-cad" method="post" action="?exe=destaque-2/update">
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