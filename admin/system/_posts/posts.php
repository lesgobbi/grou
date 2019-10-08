<?php
$level = filter_input(INPUT_GET, 'level', FILTER_VALIDATE_INT);
$nivel = ['', 'Diamante', 'Platinum', 'Ouro'];
?>

<div class="row">
    <div class="col-xs-12">
        <h3>Ofertas</h3>
    </div>
</div>

<a href="painel.php?exe=posts/create" class="btn btn-primary m-r-10 m-b-10">Cadastrar Novo Post</a>

<?php
$empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
if ($empty):
    Notification("Oppsss: Você tentou editar um post que não existe no sistema!", INFOR);
endif;

$action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
if ($action):
    require ('../_models/AdminPost.class.php');

    $postAction = filter_input(INPUT_GET, 'post', FILTER_VALIDATE_INT);
    $postUpdate = new AdminPost;

    switch ($action):
        case 'active':
            $postUpdate->ExeStatus($postAction, 1);
            Notification("O status do post foi atualizado para <b>ativo</b>. Post publicado!", ACCEPT);
            break;

        case 'inative':
            $postUpdate->ExeStatus($postAction, 0);
            Notification("O status do post foi atualizado para <b>inativo</b>. O post agora é um rascunho!", ALERT);
            break;
        
        case 'nonfeatured':
            $postUpdate->ExeFeatured($postAction, 0);
            Notification("O Post foi atualizado.", ALERT);
            break;

        case 'delete':
            $postUpdate->ExeDelete($postAction);
            Notification($postUpdate->getError()[0], $postUpdate->getError()[1]);
            break;

        default :
            Notification("Ação não foi identificada pelo sistema, favor utilize os botões!", ALERT);
    endswitch;
endif;

$readPosts = new Read;
$readPosts->ExeRead("posts", "ORDER BY post_date DESC");
?>

<div class="row m-b-20">
    <div class="col-xs-12">
        <table class="table table-hover table-striped sortable-theme-bootstrap" id="itens-table" data-sortable>
            <thead>
                <tr>
                    <th width="50" data-sortable="false" data-sorted="false" id="unsort"></th>
                    <th width="14%" data-sortable="true" data-sorted="true">Título</th>
                    <th>Conteúdo</th>
                    <th width="150">Data de Cadastro</th>
                    <th width="40">Destaque</th>
                    <th width="40">Ativo</th>
                    <th width="80" data-sortable="false">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                if ($readPosts->getResult()):
                    foreach ($readPosts->getResult() as $post):
                        extract($post);
                        $status = (!$post_status ? 'style="background: #fffed8"' : '');
                        ?>
                            <tr>
                                <td class="rounded-img"><span style="display: none;"><?= Check::Words($post_title, 10) ?></span><?= Check::Image('../uploads/' . $post_cover, $post_title, 70, 70); ?></td>
                                <td style="vertical-align: middle;"><?= Check::Words($post_title, 10) ?></td>
                                <td style="vertical-align: middle;"><?= Check::Words(strip_tags($post_content), 40); ?></td>
                                <td style="vertical-align: middle;"><?= date('d/m/Y H:i', strtotime($post_date)); ?>Hs</td>
                                <td style="vertical-align: middle;">
                                    <div class="animated-switch">
                                        <span style="display: none;"><?php if ($post_featured) echo 'a' ?></span>
                                        <input data-id="<?= $post_id; ?>" class="switch" id="featured-<?= $post_name;?>" type="checkbox" <?php if ($post_featured) echo 'checked' ?>>
                                        <label for="featured-<?= $post_name;?>" class="label-success"></label>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="animated-switch">
                                        <span style="display: none;"><?php if ($post_status) echo 'a' ?></span>
                                        <input data-id="<?= $post_id; ?>" class="switch" id="switch-<?= $post_name;?>" type="checkbox" <?php if ($post_status) echo 'checked' ?>>
                                        <label for="switch-<?= $post_name;?>" class="label-success"></label>
                                    </div>
                                </td>
                                <td style="vertical-align: middle; min-width: 80px;">
                                    <!--<a class="act_view" target="_blank" href="../artigo/<?= $post_name; ?>" title="Ver no site">Ver no site</a>-->
                                    <a href="painel.php?exe=posts/update&postid=<?= $post_id; ?>" class="btn btn-primary btn-circle m-r-5" title="Editar" data-toggle="tooltip" data-placement="top" style="height: 13px;"><i class="fa fa-edit"></i></a>
                                    <a href="painel.php?exe=posts/posts&post=<?= $post_id; ?>&action=delete" class="btn btn-danger btn-circle m-r-5" title="Remover" data-toggle="tooltip" data-placement="top" style="height: 13px;"><i class="fa fa-trash"></i></a>
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
    </div>
</div>

<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>