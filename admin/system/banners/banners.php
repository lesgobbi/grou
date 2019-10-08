<div class="row">
    <div class="col-xs-12">
        <h3>Banners</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li class="active">Banners</li>
</ol>

<?php
$create = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
$atualizado = filter_input(INPUT_GET, 'atualizado', FILTER_VALIDATE_BOOLEAN);

$w = 1000;
$h = 573;

if ($atualizado):
    Notification("Banner atualizado com sucesso!", ACCEPT);
endif;

if ($create):
    Notification("Banner criado com sucesso!", ACCEPT);
endif;

$delBanner = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
if ($delBanner):
    require ('../_models/AdminBanner.class.php');
    $deletar = new AdminBanner;
    $deletar->ExeDelete($delBanner);

    Notification($deletar->getError()[0], $deletar->getError()[1]);
endif;
?>

<a href="painel.php?exe=banners/create" class="btn btn-primary m-r-10 m-b-10">Cadastrar Novo Banner</a>
<a href="painel.php?exe=banners/banners" class="btn btn-default m-r-10 m-b-10">Mostrar ordem atualizada</a>

<div class="row m-b-20">
    <div class="col-xs-12">
        <div class="fotorama" data-loop="true">
            <?php
            $read = new Read;
            $read->ExeRead("banners", "ORDER BY banner_order ASC");
            if ($read->getResult()):
                foreach ($read->getResult() as $banner):
                    extract($banner);
                    $target = $banner_target == 1 ? 'target="_blank"' : '';
                    $link = $banner_link ? $banner_link : '#';
                    echo "<div data-img=\"../tim.php?src=/uploads/{$banner_url}&w={$w}&h={$h}\" data-caption=\"{$banner_title}\">"
                    . "<span class=\"ft-ct-buttons\">"
                    . "<a href=\"painel.php?exe=banners/update&bannerid={$banner_id}\" class=\"ft-edit btn btn-primary btn-circle m-r-5\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar\"><i class=\"fa fa-edit\"></i></a>"
                    . "<a href=\"painel.php?exe=banners/banners&delete={$banner_id}\" class=\"ft-delete btn btn-danger btn-circle m-r-5\" title=\"Remover\" data-toggle=\"tooltip\" data-placement=\"top\"><i class=\"fa fa-trash\"></i></a>"
                    . "</span>"
                    . "</div>";
                endforeach;
            endif;
            ?>
        </div>

        <div class="col-xs-12 col-xl-12 m-t-20"><h4 class="m-b-20">Arraste e solte cada linha para posição desejada</h4>
            <div id="board">
                <?php
                $Banners = new Read;
                $Banners->ExeRead("banners", "ORDER BY banner_order ASC");
                if ($Banners->getResult()):
                    foreach ($Banners->getResult() as $banner):
                        echo "<span class=\"gallery-item\" data-id=\"{$banner['banner_id']}\" data-position=\"{$banner['banner_order']}\">";
                        echo Check::Image(HOME . '/uploads/' . $banner['banner_url'], '', 150, 150, 'w-150 m-b-20 m-r-20 img-rounded');
                        echo '</span>';
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
</div> 
</div>
</div>

<link rel="stylesheet" href="<?= CDN; ?>/bower_components/fotorama/fotorama.css" />
<script src="<?= CDN; ?>/bower_components/fotorama/fotorama.js"></script>

<link rel="stylesheet" href="<?= CDN; ?>/bower_components/dragula.js/dist/dragula.css" />
<script src="<?= CDN; ?>/bower_components/dragula.js/dist/dragula.js"></script>