<div class="row">
    <div class="col-xs-12">
        <h3>Adicinar Logos (seguradoras)</h3>
    </div>
</div>

<?php $postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT); ?>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=posts/update&postid=<?= $postid; ?>">Logos</a></li>
    <li class="active">Adicionar</li>
</ol>

<div class="row m-b-20">
    <div class="col-xs-12 col-xl-6">
        <h4 class="m-b-20">Adicionar Imagens</h4>
        <form action="<?= HOME ?>/_ajax/up.php?postid=<?= $postid ?>" class="dropzone" enctype="multipart/form-data" method="post" id="dropzonegallery" data-id="<?= $postid; ?>"></form>
    </div>
</div>

<a href="?exe=posts/update&postid=<?= $postid; ?>" class="btn btn-default m-r-10 m-b-10">Voltar</a>

<link rel="stylesheet" href="http://focoimg.com.br/src/bower_components/sweetalert2/dist/sweetalert2.css" />
<script src="<?= CDN; ?>/bower_components/sweetalert2/dist/sweetalert2.min.js"></script>

<script src="<?= CDN; ?>/scripts/components/dropzone.js"></script>
<link rel="stylesheet" href="<?= CDN; ?>/styles/components/dropzone.css"></script>