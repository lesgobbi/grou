<div class="row">
    <div class="col-xs-12">
        <h3>Atualizar Post</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=home">Dashboard</a></li>
    <li><a href="?exe=posts/posts">Posts</a></li>
    <li class="active">Atualizar Post</li>
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
    <div class="col-xs-12 col-xl-6">
        <div class="row">
            <div class="col-xs-12 col-xl-12">
                <h4 class="m-b-15">Compartilhar</h4>
                <div class="addthis_sharing_toolbox" data-url="http://radiati.com.br" data-title="Radiati Comunicação"></div>

                <div class="upload-container">
                    <div class="actions">
                        <a class="btn btn-primary m-r-10 m-b-10 file-btn m-t-20" id="img-cover">
                            <span>Upload Imagem de capa</span>
                            <input type="file" id="upload" value="Choose a file" accept="image/*" />
                        </a>
                        <?php if ($post['post_featured'] == 1): ?>
                            <a class="btn btn-primary m-r-10 m-b-10 file-btn m-t-20" id="img-featured">
                                <span>Upload imagem em destaque</span>
                                <input type="file" id="upload-featured" value="Choose a file" accept="image/*" />
                            </a>
                        <?php endif; ?>
                    </div>
                    <div id="upload-crop"></div>
                    <button class="upload-result btn btn-primary m-r-10 m-b-10">Pronto</button>
                </div>

                <fieldset class="form-group m-b-20 croppie-ct">
                    <label style="display: block;">Imagem de Capa</label>
                    <?php
                    if (isset($post['post_cover']) && $post['post_cover'] != ''):
                        echo '<img src="../tim.php?src=../uploads/'.$post['post_cover'].'&w=990&h=250" class="img-cropped" id="imgcover"/>';
                    endif;
                    ?>
                </fieldset>

                <?php if ($post['post_featured'] == 1): ?>
                    <fieldset class="form-group m-b-20 croppie-ct-featured">
                        <label style="display: block;">Imagem em destaque</label>
                        <?php
                        if (isset($post['post_cover_featured']) && $post['post_cover_featured'] != ''):
                            echo '<img src="../tim.php?src=../uploads/'.$post['post_cover_featured'].'&w=400&h=300" class="img-cropped" id="imgfeatured"/>';
                        endif;
                        ?>
                    </fieldset>
                <?php endif; ?>
            </div>
        </div>

        <form name="form-cad" method="post" action="?exe=posts/update&postid=<?= $postid; ?>">
            <input type="hidden" name="post_date" value="<?= date('d/m/Y H:i:s'); ?>" />
            <input type="hidden" name="post_cover" id="post_cover" value="<?php if (isset($post['post_cover'])) echo $post['post_cover']; ?>"/>
            <input type="hidden" name="post_cover_featured" id="post_cover_featured" value="<?php if (isset($post['post_cover_featured'])) echo $post['post_cover_featured']; ?>"/>
            <input type="hidden" name="post_featured" value="<?php if (isset($post['post_featured'])) echo $post['post_featured']; ?>"/>
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
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Atualizar Post" name="SendPostForm"/>
                <a href="?exe=posts/gallery&postid=<?= $postid ?>" class="btn btn-primary m-r-10 m-b-10">Adicionar imagens ou vídeos a galeria</a>
            </div>
        </form>
    </div>

    <?php
    $Gallery = new Read;
    $Gallery->ExeRead("posts_gallery", "WHERE post_id = :post ORDER BY gallery_order ASC", "post={$postid}");
    if ($Gallery->getResult()):
        echo '<div class="col-xs-12 col-xl-6"><h4 class="m-b-20">Galeria de Imagens/Vídeos</h4>';
        echo '<div class="fotorama" data-loop="true" data-width="100%" data-ratio="800/600">';
        foreach ($Gallery->getResult() as $gallery):
            extract($gallery);
            if (strpos($gallery_image, '?v=') === false):
                echo "<img src=\"../uploads/{$gallery_image}\" data-caption=\"{$gallery_caption}\"/>";
            else:
                echo "<a href=\"{$gallery_image}\" data-caption=\"{$gallery_caption}\"></a>";
            endif;
        endforeach;
        echo '</div>';

        echo '<h5 class="m-b-20 m-t-20">Organizar</h5>';

        echo '<div id="board" class="m-t-20">';
        foreach ($Gallery->getResult() as $gb):
            if (strpos($gb['gallery_image'], 'youtube.com') === false && strpos($gb['gallery_image'], 'vimeo.com') === false):
                echo "<span class=\"gallery-item\" data-id=\"{$gb['gallery_id']}\" data-parent=\"{$gb['post_id']}\" data-position=\"{$gb['gallery_order']}\">";
                echo Check::Image('../uploads/' . $gb['gallery_image'], '', 150, 150, 'w-150 m-b-20 m-r-20 img-rounded');
                echo '<form class="form-caption" data-id="' . $gb['gallery_id'] . '"><input type="text" value="' . $gb['gallery_caption'] . '" placeholder="Insira uma legenda!"/></form>';
                echo '<a class="gallery-btn-delete fa fa-trash" title="Deletar" data-toggle="tooltip" data-placement="top" href="painel.php?exe=posts/update&postid=' . $postid . '&gbdel=' . $gb['gallery_id'] . '"></a>';
                echo '</span>';
            elseif(strpos($gb['gallery_image'], 'youtube.com')):
                $url = explode('?v=', $gb['gallery_image']);
                echo "<span class=\"gallery-item\" data-id=\"{$gb['gallery_id']}\" data-parent=\"{$gb['post_id']}\" data-position=\"{$gb['gallery_order']}\">";
                echo '<div class="w-150 m-b-20 m-r-20 img-rounded video-item" style="background-image: url(http://img.youtube.com/vi/' . $url[1] . '/sddefault.jpg)">'
                . '<i class="fa fa-2x fa-youtube-play"></i></div>';
                echo '<form class="form-caption" data-id="' . $gb['gallery_id'] . '"><input type="text" value="' . $gb['gallery_caption'] . '" placeholder="Insira uma legenda!"/></form>';
                echo '<a class="gallery-btn-delete fa fa-trash" title="Deletar" data-toggle="tooltip" data-placement="top" href="painel.php?exe=posts/update&postid=' . $postid . '&gbdel=' . $gb['gallery_id'] . '"></a>';
                echo '</span>';
            elseif(strpos($gb['gallery_image'], 'vimeo.com')):
                $url = explode('/', $gb['gallery_image']);
                $url = end($url);
                $data = file_get_contents("http://vimeo.com/api/v2/video/{$url}.json");
                $img = json_decode($data);
                echo "<span class=\"gallery-item\" data-id=\"{$gb['gallery_id']}\" data-parent=\"{$gb['post_id']}\" data-position=\"{$gb['gallery_order']}\">";
                echo '<div class="w-150 m-b-20 m-r-20 img-rounded video-item" style="background-image: url('.$img[0]->thumbnail_medium.')">'
                . '<i class="fa fa-2x fa-vimeo"></i></div>';
                echo '<form class="form-caption" data-id="' . $gb['gallery_id'] . '"><input type="text" value="' . $gb['gallery_caption'] . '" placeholder="Insira uma legenda!"/></form>';
                echo '<a class="gallery-btn-delete fa fa-trash" title="Deletar" data-toggle="tooltip" data-placement="top" href="painel.php?exe=posts/update&postid=' . $postid . '&gbdel=' . $gb['gallery_id'] . '"></a>';
                echo '</span>';
            endif;

        endforeach;
        echo '</div>';
        echo '<hr style="width: 100%;">';
        echo '<form method="post"><a href="?exe=posts/gallery&postid=' . $postid . '" class="btn btn-primary m-r-10 m-b-10">Adicionar imagens/vídeos</a>'
                . '<input type="hidden" id="remove" name="remove_itens"/><span id="selectall" class="btn btn-danger m-r-10 m-b-10">selecionar todas</span>'
                . '<span style="display:none" id="clearall" class="btn btn-default m-r-10 m-b-10">limpar seleção</span>'
                . '<button style="display:none" id="removebutton" class="btn btn-danger m-r-10 m-b-10" value="excluir selecionadas" name="delImagesGallery">'
                . '<i class="btn-icon fa fa-trash"></i>excluir selecionadas</button></form>';
        echo '</div>';
    endif;
    ?>
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

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5730e572ad8d631d"></script>

<link rel="stylesheet" href="bower_components/croppie/croppie.css" />
<script src="bower_components/croppie/croppie.min.js"></script>
<script src="bower_components/croppie/upload.js"></script>

<link rel="stylesheet" href="bower_components/dragula.js/dist/dragula.css" />
<script src="bower_components/dragula.js/dist/dragula.js"></script>

<link rel="stylesheet" href="bower_components/fotorama/fotorama.css" />
<script src="bower_components/fotorama/fotorama.js"></script>