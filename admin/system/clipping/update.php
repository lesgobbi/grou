<div class="row">
    <div class="col-xs-12">
        <h3>Atualizar</h3>
    </div>
</div>

<?php
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_GET, 'featured', FILTER_DEFAULT);
$delGb = filter_input(INPUT_GET, 'gbdel', FILTER_VALIDATE_INT);
$multidel = filter_input(INPUT_GET, 'muldel', FILTER_VALIDATE_BOOLEAN);
$bulletId = filter_input(INPUT_GET, 'bullet', FILTER_VALIDATE_INT);
$form = filter_input(INPUT_GET, 'form', FILTER_VALIDATE_BOOLEAN);
$aform = filter_input(INPUT_GET, 'aform', FILTER_VALIDATE_BOOLEAN);

require('../_models/AdminBullets.class.php');
require('../_models/AdminPost.class.php');

if (isset($bulletId)):
    $bulletDelete = new AdminBullets;
    $bulletDelete->ExeDelete($bulletId);
    Notification($bulletDelete->getError()[0], $bulletDelete->getError()[1]);
endif;

if (isset($post) && isset($post['SendPostFormNew'])):

    unset($post['SendPostFormNew']);

    $cadastra = new AdminBullets;
    $cadastra->ExeCreate($post);

    header('Location: painel.php?exe=posts/update&postid=' . $postid);
elseif (isset($post) && isset($post['SendPostFormAlt'])):

    unset($post['SendPostFormAlt']);

    $bullet = $post['bullet_id'];
    unset($post['SendPostFormAlt']);
    unset($post['bullet_id']);

    $update = new AdminBullets;

    $update->ExeUpdate($bullet, $post);
    Notification($update->getError()[0], $update->getError()[1]);
endif;

if ($action == 'true'):
    $postUpdate = new AdminPost;
    $postUpdate->ExeFeatured($postid, 1);
    Notification("O Página foi colocada em <strong>Destaque na home</strong>", ACCEPT);
endif;

if ($action == 'false'):
    $postUpdate = new AdminPost;
    $postUpdate->ExeFeatured($postid, 0);
    Notification("O Página foi tirada de destaque na home</strong>", ACCEPT);
endif;

if ($multidel):
    Notification("Imagens removidas com sucesso!", ACCEPT);
endif;

if ($form):
    Notification("Formulário cadastrado com sucesso!", ACCEPT);
endif;

if ($aform):
    Notification("Formulário atualizado com sucesso! Para alterá-lo clique no botão <strong>Editar Formulário</strong>", ACCEPT);
endif;

$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
if ($checkCreate && empty($cadastra)):
    Notification("O post <b>{$post['post_title']}</b> foi cadastrado com sucesso no sistema!", ACCEPT);
endif;

if (isset($post) && isset($post['SendPostForm'])):
    unset($post['SendPostForm']);

    $cadastra = new AdminPost;
    $cadastra->ExeUpdate($postid, $post);

    Notification($cadastra->getError()[0], $cadastra->getError()[1]);
else:
    $read = new Read;
    $read->ExeRead("posts", "WHERE post_id = :id", "id={$postid}");
    if (!$read->getResult()):
        header('Location: painel.php?exe=clipping/index&empty=true');
    else:
        $post = $read->getResult()[0];

        $post['post_date'] = date('d/m/Y H:i:s', strtotime($post['post_date']));
    endif;
endif;

if ($delGb):
    require_once('../_models/AdminPost.class.php');
    $DelGallery = new AdminPost;
    $DelGallery->gbRemove($delGb);
    if ($DelGallery->getResult()):
        Notification($DelGallery->getError()[0], $DelGallery->getError()[1]);
    endif;
endif;
?>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=clipping/clipping">Clippings</a></li>
    <li class="active">Atualizar Clipping</li>
</ol>

<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <div class="row">
            <div class="col-xs-12 col-xl-12">
                <div class="upload-container">
                    <div class="actions">
                        <a class="btn btn-primary m-r-10 m-b-10 file-btn m-t-20" id="img-cover" data-width="<?= $postid == '2' ? '600' : '1920'; ?>" data-height="<?= $postid == '2' ? '600' : '945'; ?>">
                            <span>Upload Imagem de capa</span>
                            <input type="file" id="upload" value="Choose a file" accept="image/*" />
                        </a>
                    </div>
                    <div id="upload-crop"></div>
                    <button class="upload-result btn btn-primary m-r-10 m-b-10">Pronto</button>
                </div>

                <fieldset class="form-group m-b-20 croppie-ct">
                    <label style="display: block;">Imagem de Capa</label>
                    <?php
                    if (isset($post['post_cover']) && $post['post_cover'] != ''):
                        echo '<img src="../tim.php?src=uploads/' . $post['post_cover'] . '&w=805&h398" class="img-cropped" id="imgcover" style="max-width: 100%;"/>';
                    endif;
                    ?>

                    <?php if($postid != 1): ?>
                        <?php if (isset($post['post_cover']) && $post['post_cover'] != ''): ?>
                            <form method="post" action="?exe=posts/update&postid=<?= $postid; ?>">
                                <input type="submit" class="btn btn-danger m-r-10 m-b-10 file-btn m-t-20" value="Remover Imagem" name="sendRemoveImg"/>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </fieldset>
            </div>
        </div>

        <form name="form-cad" method="post" action="?exe=clipping/update&postid=<?= $postid; ?>">
            <input type="hidden" name="post_date" value="<?= date('d/m/Y H:i:s'); ?>" />
            <input type="hidden" name="post_cover" id="post_cover" value="<?php if (isset($post['post_cover'])) echo $post['post_cover']; ?>"/>
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
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Salvar" name="SendPostForm"/>
            </div>
        </form>
    </div>
</div>

<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5730e572ad8d631d"></script>-->

<link rel="stylesheet" href="bower_components/croppie/croppie.css" />
<script src="bower_components/croppie/croppie.min.js"></script>
<script src="bower_components/croppie/upload.js"></script>

<?php include('includes/editor.php'); ?>
