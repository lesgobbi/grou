<div class="row">
    <div class="col-xs-12">
        <h3>Atualizar</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li class="active">Atualizar</li>
</ol>

<?php
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_GET, 'featured', FILTER_DEFAULT);
$delGb = filter_input(INPUT_GET, 'gbdel', FILTER_VALIDATE_INT);
$multidel = filter_input(INPUT_GET, 'muldel', FILTER_VALIDATE_BOOLEAN);

require('../_models/AdminPost.class.php');

if ($action == 'true'):
    $postUpdate = new AdminPost;
    $postUpdate->ExeFeatured($postid, 1);
    Notification("O Post foi atualizado <strong>Em Destaque</strong>, favor fazer upload da imagem em destaque", ACCEPT);
endif;

if ($multidel):
    Notification("Imagens removidas com sucesso!", ACCEPT);
endif;

if (isset($post) && isset($post['SendPostForm'])):
    unset($post['SendPostForm']);

    $cadastra = new AdminPost;
    $cadastra->ExeUpdate($postid, $post);

    Notification($cadastra->getError()[0], $cadastra->getError()[1]);
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

$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
if ($checkCreate && empty($cadastra)):
    Notification("O post <b>{$post['post_title']}</b> foi cadastrado com sucesso no sistema!", ACCEPT);
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

<div class="row m-b-40">
    <?php if ($postid != 20): ?>
        <div class="col-xs-12 col-xl-6">
            <?php if ($postid != 5 && $postid != 1 && $postid != 3): ?>
                <div class="row">
                    <div class="col-xs-12 col-xl-12">

                        <div class="upload-container">
                            <div class="actions">
                                <a class="btn btn-primary m-r-10 m-b-10 file-btn m-t-20" id="img-cover">
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
                                echo '<img src="../tim.php?src=/uploads/' . $post['post_cover'] . '&w=260&h=260" class="img-cropped" id="imgcover"/>';
                            endif;
                            ?>
                        </fieldset>
                    </div>
                </div>
            <?php endif; ?>

            <form name="form-cad" method="post" action="?exe=posts/update&postid=<?= $postid; ?>">
                <input type="hidden" name="post_date" value="<?= date('d/m/Y H:i:s'); ?>" />
                <input type="hidden" name="post_cover" id="post_cover" value="<?php if (isset($post['post_cover'])) echo $post['post_cover']; ?>"/>
                <input type="hidden" name="post_category" value="1"/>
                <div class="row">
                    <div class="col-xs-12 col-xl-12">
                        <div class="form-group floating-labels">
                            <label for="post_title">Título</label>
                            <input id="post_title" autocomplete="off" type="text" name="post_title" value="<?php if (isset($post['post_title'])) echo $post['post_title']; ?>" required>
                            <p class="error-block"></p>
                        </div>
                    </div>
                    
                    <?php if ($postid != 4): ?>
                    <div class="col-xs-12 col-xl-12">
                        <fieldset class="form-group m-b-20">
                            <label for="post_content">Conteúdo</label>
                            <textarea name="post_content" id="post_content" class="form-control" rows="4"><?php if (isset($post['post_content'])) echo $post['post_content']; ?></textarea>
                        </fieldset>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="<?= ($postid != 13 ? 'Atualizar Post' : 'Atualizar Menu'); ?>" name="SendPostForm"/>
                    <?php if ($postid != 1 && $postid != 3 && $postid != 13 && $postid != 4): ?>
                        <a href="?exe=posts/gallery&postid=<?= $postid ?>" class="btn btn-primary m-r-10 m-b-10">Adicionar imagens a galeria</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <?php
    $Gallery = new Read;
    $Gallery->ExeRead("posts_gallery", "WHERE post_id = :post ORDER BY gallery_order ASC", "post={$postid}");
    
    if ($postid == 20):
        echo '<a href="?exe=posts/gallery&postid=' . $postid . '" class="btn btn-primary m-r-10 m-b-10">Adicionar ' . ($postid != 20 ? 'imagens /vídeos' : 'logos') . '</a>';
    endif;
    
    if ($Gallery->getResult()):
        if ($postid != 20):
            echo '<div class="col-xs-12 col-xl-6"><h4 class="m-b-20">Galeria de Imagens/Vídeos</h4>';
            echo '<div class="fotorama" data-loop="true" data-width="100%" data-ratio="800/600">';
            foreach ($Gallery->getResult() as $gallery):
                extract($gallery);
                if (strpos($gallery_image, '?v=') === false && strpos($gallery_image, 'vimeo.com') === false):
                    echo "<img src='".HOME."/uploads/{$gallery_image}' data-caption=\"{$gallery_caption}\"/>";
                else:
                    echo "<a href=\"{$gallery_image}\" data-caption=\"{$gallery_caption}\"></a>";
                endif;
            endforeach;
            echo '</div>';
        endif;

        echo '<h5 class="m-b-20 m-t-20">Organizar</h5>';
        echo '<h6 class="m-b-20 m-t-20">Para adicionar uma lagenda, passe o mouse sobre a imagem e insira o texto na lacuna</h6>';

        echo '<div id="board" class="m-t-20">';
        foreach ($Gallery->getResult() as $gb):
            if (strpos($gb['gallery_image'], '?v=') === false && strpos($gb['gallery_image'], 'vimeo.com') === false):
                echo "<span class=\"gallery-item\" data-id=\"{$gb['gallery_id']}\" data-parent=\"{$gb['post_id']}\" data-position=\"{$gb['gallery_order']}\">";
                echo Check::Image(HOME.'/uploads/' . $gb['gallery_image'], '', 150, 150, 'w-150 m-b-20 m-r-20 img-rounded');
                echo '<form class="form-caption" data-id="' . $gb['gallery_id'] . '"><input type="text" value="' . $gb['gallery_caption'] . '" placeholder="'.($postid == 20 ? 'cole aqui URL!' : 'Insira uma legenda!').'"/></form>';
                echo '<a class="gallery-btn-delete fa fa-trash" title="Deletar" data-toggle="tooltip" data-placement="top" href="painel.php?exe=posts/update&postid=' . $postid . '&gbdel=' . $gb['gallery_id'] . '"></a>';
                echo '</span>';
            else:
                if (strpos($gb['gallery_image'], '?v=') !== false):
                    $url = explode('?v=', $gb['gallery_image']);
                    echo "<span class=\"gallery-item\" data-id=\"{$gb['gallery_id']}\" data-parent=\"{$gb['post_id']}\" data-position=\"{$gb['gallery_order']}\">";
                    echo '<div class="w-150 m-b-20 m-r-20 img-rounded video-item" style="background-image: url(http://img.youtube.com/vi/' . $url[1] . '/sddefault.jpg)">'
                    . '<i class="fa fa-2x fa-youtube-play"></i></div>';
                    echo '<form class="form-caption" data-id="' . $gb['gallery_id'] . '"><input type="text" value="' . $gb['gallery_caption'] . '" placeholder="Insira uma legenda!"/></form>';
                    echo '<a class="gallery-btn-delete fa fa-trash" title="Deletar" data-toggle="tooltip" data-placement="top" href="painel.php?exe=posts/update&postid=' . $postid . '&gbdel=' . $gb['gallery_id'] . '"></a>';
                    echo '</span>';
                elseif (strpos($gb['gallery_image'], 'vimeo.com') !== false):
                    $id = explode('https://vimeo.com/', $gb['gallery_image']);
                    echo "<span class=\"gallery-item\" data-id=\"{$gb['gallery_id']}\" data-parent=\"{$gb['post_id']}\" data-position=\"{$gb['gallery_order']}\">";
                    echo '<div class="w-150 m-b-20 m-r-20 img-rounded video-item" style="background-image: url(' . Check::getVimeoThumb($id[1]) . ')">'
                    . '<i class="fa fa-2x fa-vimeo-square"></i></div>';
                    echo '<form class="form-caption" data-id="' . $gb['gallery_id'] . '"><input type="text" value="' . $gb['gallery_caption'] . '" placeholder="Insira uma legenda!"/></form>';
                    echo '<a class="gallery-btn-delete fa fa-trash" title="Deletar" data-toggle="tooltip" data-placement="top" href="painel.php?exe=posts/update&postid=' . $postid . '&gbdel=' . $gb['gallery_id'] . '"></a>';
                    echo '</span>';
                endif;

            endif;

        endforeach;
        echo '</div>';
        echo '<hr style="width: 100%;">';
        echo '<form method="post">'
        . '<input type="hidden" id="remove" name="remove_itens"/><span id="selectall" class="btn btn-danger m-r-10 m-b-10">selecionar todas</span>'
        . '<span style="display:none" id="clearall" class="btn btn-default m-r-10 m-b-10">limpar seleção</span>'
        . '<button style="display:none" id="removebutton" class="btn btn-danger m-r-10 m-b-10" value="excluir selecionadas" name="delImagesGallery">'
        . '<i class="btn-icon fa fa-trash"></i>excluir selecionadas</button></form>';
        echo '</div>';
    endif;
    ?>
</div>

<link rel="stylesheet" href="bower_components/croppie/croppie.css" />
<script src="bower_components/croppie/croppie.min.js"></script>
<script src="bower_components/croppie/upload.js"></script>

<?php include('includes/editor.php'); ?>

<link rel="stylesheet" href="<?= CDN; ?>/bower_components/dragula.js/dist/dragula.css" />
<script src="<?= CDN; ?>/bower_components/dragula.js/dist/dragula.js"></script>

<link rel="stylesheet" href="<?= CDN; ?>/bower_components/fotorama/fotorama.css" />
<script src="<?= CDN; ?>/bower_components/fotorama/fotorama.js"></script>