<div class="ct-header">
    <?php
        $readHome = $read;
        $readHome->ExeRead('posts', "WHERE post_id = 1");
        $home = $readHome->getResult()[0];
    ?>
    <div class="background" style="background-image: url(<?= HOME.'/tim.php?src='.HOME.'/uploads/'.$home['post_cover'].'&w=1920&h=945'; ?>);"></div>

    <header>
        <div class="container">
            <a href="<?= HOME; ?>" class="logo"><img src="<?= HOME; ?>/assets/img/logo.png" /></a>

            <div class="hamburguer">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            
            <menu><?php include('includes/menu.php');?></menu>            
        </div>
    </header>

    <section class="container">
        <?= $home['post_chamada']; ?>
    </section>

</div>

<section class="container ct-parallax">
    <div class="col-6">
        <div class="parallax">
            <img src="assets/img/logo-img.svg">
        </div>
    </div>

    <div class="col-6 conheca">
        <?php
        $readSobre = $read;
        $readSobre->ExeRead('posts', "WHERE post_id = 3");
        $sobre = $readSobre->getResult()[0];
        ?>

        <h3><?= $sobre['post_title'];?></h3>

        <p>
            <?= Check::Words($sobre['post_content'], 52);?>
        </p>

        <a href="<?= HOME; ?>/sobre">Saiba mais</a>
    </div>
</section>

<section class="container-fluid ct-bullets">
    <div class="container">
        <span class="col-4" data-aos="fade-right" data-aos-anchor-placement="top" data-aos-duration="850">Vida<br>Empresarial</span>
        <span class="col-4" data-aos="fade-top" data-aos-anchor-placement="top" data-aos-duration="850">Seguro<br>Saúde</span>
        <span class="col-4" data-aos="fade-left" data-aos-anchor-placement="top" data-aos-duration="850">Consórcio<br>Imobiliário</span>
    </div>
</section>

<?php
$readDestaques = $read;
$readDestaques->ExeRead('posts', "WHERE (post_category = 2 OR post_category = 3) AND post_featured = 1 ORDER BY post_date DESC LIMIT 4");
if($readDestaques->getRowCount()):
    $destaques = $readDestaques->getResult();
?>
    <section class="container solucoes">
        <h2>Soluções para todas as necessidades<br>(sua e da sua empresa).</h2>

        <div class="container-fluid">
            <?php foreach($destaques as $destaque): ?>
                <div class="col">
                    <span><?= $destaque['post_title']; ?></span>
                    <p><?= Check::Words($destaque['post_content'], 35); ?></p>
                    <a href="<?= HOME; ?>/<?= $destaque['post_name']; ?>">Saiba mais</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php
$readClipping = $read;
$readClipping->ExeRead('posts', "WHERE post_category = 4 ORDER BY post_id DESC");
if($readClipping->getRowCount()):
$clippings = $readClipping->getResult();
?>
<section class="container por-dentro">
    <h2>Fique por dentro</h2>

    <div class="container-fluid">
        <?php
            foreach($clippings as $clipping):
        ?>
            <div class="item col-4">
                <?php
                    if($clipping['post_cover']):
                        $bg = HOME.'/tim.php?src=uploads/'.$clipping['post_cover'].'&w=600;';
                    else:
                        $bg = $clipping['post_cover_featured'];
                    endif;
                ?>

                <div class="cover" style="background-image: url(<?= $bg; ?>);"></div>

                <div class="content">
                    <h4><?= $clipping['post_title']; ?></h4>
                    <p><?= Check::Words($clipping['post_content'], 34) ?></p>
                    <a target="_blank" href="<?= $clipping['post_link']; ?>">SAIBA MAIS</a>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>
<?php endif; ?>

<section class="container-fluid especialista">
    <div class="container">
        <?php
        $readEspecialista = $read;
        $readEspecialista->ExeRead('posts', "WHERE post_id = 2");
        $especialista = $readEspecialista->getResult()[0];
        ?>

        <img class="col-4" src="<?= HOME.'/tim.php?src='.HOME.'/uploads/'.$especialista['post_cover'].'&w=600&h=600'; ?>" data-aos="fade-right" data-aos-anchor-placement="top" data-aos-duration="850" />
        <div class="col">
            <h3><?= $especialista['post_chamada'];?>: <?= $especialista['post_title'];?></h3>
            <p><?= $especialista['post_content'];?></p>
        </div>
    </div>
</section>

<section class="galler">
    <div class="fotorama-container">
        <h4>As melhores seguradoras do mercado</h4>

        <div class="fotorama" data-width="100%" data-height="100" data-nav="false">
            <?php
                $l = 0;
                foreach($logos as $logo):
                    $l = $l == 3 ? 0 : $l;
                    echo !$l ? '<div class="logos-container">' : '';
                    echo '<img src="'.HOME.'/tim.php?src='.HOME.'/uploads/'.$logo['gallery_image'].'&w=460&h=200"/>';
                    echo $l == 2 ? '</div>' : '';
                    $l++;
                endforeach;
                echo $l < 2 ? '</div>' : '';
            ?>
        </div>

    </div>
</section>