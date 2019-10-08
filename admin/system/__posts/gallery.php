<div class="row">
    <div class="col-xs-12">
        <h3>Adicinar Imagens (galeria)</h3>
    </div>
</div>

<?php $postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT); ?>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=posts/posts">Posts</a></li>
    <li><a href="?exe=posts/update&postid=<?= $postid; ?>">Post</a></li>
    <li class="active">Galeria</li>
</ol>

<div class="row m-b-20">
    <div class="col-xs-12 col-xl-6">
        <h4 class="m-b-20">Adicionar Imagens</h4>
        <form action="<?= HOME ?>/_ajax/up.php?postid=<?= $postid ?>" class="dropzone" enctype="multipart/form-data" method="post" id="dropzonegallery" data-id="<?= $postid; ?>"></form>
    </div>
    <?php if($postid != 20): ?>
    <div class="col-xs-12 col-xl-6">
        <h4 class="m-b-20 m-t-40">Adicionar Vídeos</h4>

        <form id="form-video">
            <div class="row">
                <div class="col-xs-12 col-xl-12">
                    <h6 style="line-height: 1.3;">insira urls completas do <strong>youtube</strong>, por exemplo:<br><strong>https://www.youtube.com/watch?v=ID-DO-VIDEO</strong></h6>
                    <div class="form-group floating-labels">
                        <label for="post_videos">URL do vídeo</label>
                        <input id="post_videos" autocomplete="off" type="text" name="post_videos">
                        <p class="error-block"></p>
                    </div>
                    <div class="form-group">
                        <a id="video-add" data-post="<?= $postid; ?>" class="btn btn-primary m-r-10 m-b-10">Adicionar Vídeo</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>
</div>

<a href="?exe=posts/update&postid=<?= $postid; ?>" class="btn btn-default m-r-10 m-b-10">Voltar</a>

<link rel="stylesheet" href="<?= CDN; ?>/bower_components/sweetalert2/dist/sweetalert2.css" />
<script src="<?= CDN; ?>/bower_components/sweetalert2/dist/sweetalert2.min.js"></script>

<script src="<?= CDN; ?>/scripts/components/dropzone.js"></script>
<link rel="stylesheet" href="<?= CDN; ?>/styles/components/dropzone.css"></script>