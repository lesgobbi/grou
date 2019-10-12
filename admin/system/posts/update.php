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

elseif (isset($post) && isset($post['sendRemoveImg'])):
    unset($post['sendRemoveImg']);

    $cadastra = new AdminPost;
    $cadastra->ExeRemoveImg($postid);

    if ($cadastra->getResult()):
        header('Location: painel.php?exe=posts/update&postid=' . $postid);
    endif;

elseif (isset($post) && isset($post['delImagesGallery'])):

    $itens = explode(',', $post['remove_itens']);
    require_once('../_models/AdminPost.class.php');
    $delItens = new AdminPost;
    foreach ($itens as $remover):
        $delItens->gbRemove($remover);
    endforeach;
    header('Location: painel.php?exe=posts/update&postid=' . $postid . '&muldel=true');
else:
    $read = new Read;
    $read->ExeRead("posts", "WHERE post_id = :id", "id={$postid}");
    if (!$read->getResult()):
        header('Location: painel.php?exe=posts/index&empty=true');
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

<?php if($post['post_category'] != 1): ?>
    <ol class="breadcrumb icon-home icon-angle-right">
        <li><a href="?exe=posts/posts">Páginas</a></li>
        <li class="active">Atualizar Página</li>
    </ol>
<?php endif; ?>

<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <div class="row">
            <?php if($post['post_category'] != 1): ?>
            <div class="col-xs-12 col-xl-12">
                <div class="form-group switches">
                    <ul class="list-group">
                        <li class="list-group-item">Destaque na home?
                            <div class="animated-switch pull-right">
                                <span style="display: none;"><?php if ($post['post_featured']) echo 'a' ?></span>
                                <input data-id="<?= $postid; ?>" class="switch" id="featured-1" type="checkbox" <?php if ($post['post_featured']) echo 'checked' ?>>
                                <label for="featured-1" class="label-success"></label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <div class="col-xs-12 col-xl-12">
                <!--
                <h4 class="m-b-15">Compartilhar</h4>
                <div class="addthis_sharing_toolbox" data-url="http://radiati.com.br" data-title="Radiati Comunicação"></div>
                -->

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

        <form name="form-cad" method="post" action="?exe=posts/update&postid=<?= $postid; ?>">
            <input type="hidden" name="post_date" value="<?= date('d/m/Y H:i:s'); ?>" />
            <input type="hidden" name="post_cover" id="post_cover" value="<?php if (isset($post['post_cover'])) echo $post['post_cover']; ?>"/>
            <input type="hidden" name="post_featured" value="<?php if (isset($post['post_featured'])) echo $post['post_featured']; ?>"/>
            <div class="row">
                <div class="col-xs-12 col-xl-12">
                    <fieldset class="form-group m-b-20">
                        <label for="post_chamada">Chamada</label>
                        <textarea name="post_chamada" class="post_txt" class="form-control" rows="4"><?php if (isset($post['post_chamada'])) echo $post['post_chamada']; ?></textarea>
                    </fieldset>

                    <?php if($postid != 1): ?>
                    <div class="form-group floating-labels">
                        <label for="post_title">Título</label>
                        <input id="post_title" autocomplete="off" type="text" name="post_title" value="<?php if (isset($post['post_title'])) echo $post['post_title']; ?>" required>
                        <p class="error-block"></p>
                    </div>
                    <?php else: ?>
                        <input type="hidden" name="post_title" value="nada"/>
                    <?php endif; ?>

                    <?php if($post['post_category'] == 1): ?>
                        <input type="hidden" name="post_category" value="1"/>
                    <?php endif; ?>
                </div>


                <div class="col-xs-12 col-xl-12">
                    <?php if($postid != 1): ?>
                        <fieldset class="form-group m-b-20">
                            <label for="post_content">Conteúdo</label>
                            <textarea name="post_content" id="post_content" class="form-control" rows="4"><?php if (isset($post['post_content'])) echo $post['post_content']; ?></textarea>
                        </fieldset>
                    <?php endif; ?>

                    <?php if($post['post_category'] != 1): ?>
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
                    <?php endif; ?>
                </div>

            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Salvar" name="SendPostForm"/>
                <?php if($post['post_category'] != 1):
                    $readForm = new Read;
                    $readForm->ExeRead("forms", "WHERE form_post = :post", "post={$postid}");
                    if(!$readForm->getRowCount()):
                ?>
                        <a class="btn btn-primary m-b-10 pull-right" href="?exe=forms/create&postid=<?= $postid; ?>">Criar Formulário</a>
                <?php else: ?>
                        <a class="btn btn-primary m-b-10 pull-right" href="?exe=forms/update&formid=<?= $readForm->getResult()[0]['form_id']; ?>&postid=<?= $postid; ?>">Editar Formulário</a>
                <?php endif; endif; ?>
            </div>
        </form>
    </div>
    <?php if($post['post_category'] != 1 || $post['post_id'] == 1): ?>
    <div class="col-xs-12 col-xl-6">
        <a class="btn btn-primary m-r-10 m-b-10 m-t-20" data-toggle="modal" data-target="#myModal">Cadastrar Nova Resposta</a>
        <?php
            $readBullets = new Read;
            $readBullets->ExeRead('bullets', "WHERE post_id = :postid", "postid={$postid}");
            if($readBullets->getRowCount()):
        ?>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th data-sortable="true" data-sorted="true">Pergunta</th>
                    <th>Resposta</th>
                    <th width="100" data-sortable="false">Ações</th>
                </tr>
            </thead>
            <tbody id="board">
                <?php
                if ($readBullets->getResult()):
                    foreach ($readBullets->getResult() as $bullet):
                        extract($bullet);
                        ?>
                        <tr data-id="<?= $bullet_id; ?>" data-position="<?= $bullet_order; ?>" data-parent="<?= $postid; ?>">
                            <td style="vertical-align: middle;"><?= Check::Words($bullet_title, 10) ?></td>
                            <td style="vertical-align: middle;"><?= Check::Words(strip_tags($bullet_content), 40); ?></td>
                            <td style="vertical-align: middle; min-width: 80px;">
                                <a onClick="openEdit(<?= $bullet_id; ?>)" class="btn btn-primary btn-circle m-r-5" title="Editar" data-toggle="tooltip" data-placement="top" style="height: 28px;"><i class="fa fa-edit"></i></a>
                                <a href="painel.php?exe=posts/update&postid=<?= $postid ?>&bullet=<?= $bullet_id; ?>" class="btn btn-danger btn-circle m-r-5" title="Remover" data-toggle="tooltip" data-placement="top" style="height: 28px;"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>

                        <?php
                    endforeach;
                else:
                    Notification("Desculpe, ainda não existem posts cadastrados!", INFOR);
                endif;
                ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <?php endif;?>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Nova Pergunta</h4>
            </div>
            <div class="modal-body">
                <div class="row m-b-40">
                    <div class="col-xs-12 col-xl-12">
                        <form name="form-cad" method="post">
                            <input type="hidden" name="post_id" value="<?= $postid; ?>"/>
                            <div class="row">
                                <div class="col-xs-12 col-xl-12">
                                    <div class="form-group floating-labels">
                                        <label for="bullet_title">Pergunta</label>
                                        <input autocomplete="off" class="bullet_title" type="text" name="bullet_title" value="" required>
                                        <p class="error-block"></p>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-xl-12">
                                    <fieldset class="form-group m-b-20">
                                        <label>Resposta</label>
                                        <textarea name="bullet_content" class="post_txt" class="form-control" rows="4"></textarea>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Cadastrar" name="SendPostFormNew"/>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>

    </div>
</div>

<div id="modalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Atualizar Pergunta</h4>
            </div>
            <div class="modal-body">
                <div class="row m-b-40">
                    <div class="col-xs-12 col-xl-12">
                        <form name="form-cad" method="post">
                            <input type="hidden" id="bulletid" name="bullet_id"/>
                            <div class="row">
                                <div class="col-xs-12 col-xl-12">
                                    <div class="form-group floating-labels">
                                        <label for="bullet_title">Pergunta</label>
                                        <input id="bullet_title" autocomplete="off" type="text" name="bullet_title" value="" required>
                                        <p class="error-block"></p>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-xl-12">
                                    <fieldset class="form-group m-b-20">
                                        <label>Resposta</label>
                                        <textarea id="bullet_content" name="bullet_content" class="post_txt" class="form-control" rows="4"></textarea>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Atualizar" name="SendPostFormAlt"/>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>

    </div>
</div>

<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5730e572ad8d631d"></script>-->

<link rel="stylesheet" href="bower_components/croppie/croppie.css" />
<script src="bower_components/croppie/croppie.min.js"></script>
<script src="bower_components/croppie/upload.js"></script>

<?php include('includes/editor.php'); ?>

<?php if($post['post_category'] != 1): ?>

<link rel="stylesheet" href="<?= CDN; ?>/bower_components/dragula.js/dist/dragula.css" />
<script src="<?= CDN; ?>/bower_components/dragula.js/dist/dragula.js"></script>

<script>
    var bullets = <?= json_encode($readBullets->getResult()); ?>

    function openEdit(id) {
        $.each(bullets, function (i) {
            if (bullets[i].bullet_id == id) {
                $('#bulletid', $('#modalEdit')).val(id);
                $('#bullet_title', $('#modalEdit')).val(bullets[i].bullet_title);
                $('#bullet_content', $('#modalEdit')).froalaEditor('html.set', bullets[i].bullet_content);
            }
        });
        $('#modalEdit').modal('show');
    }
</script>
<?php endif; ?>
