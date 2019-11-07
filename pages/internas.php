<?php
$readPag = $read;
if($area != 'sobre'):
    $readPag->ExeRead('posts', "WHERE post_name = :name", "name={$area}");
else:
    $readPag->ExeRead('posts', "WHERE post_id = 3");
endif;
$page = $readPag->getRowCount() ? $readPag->getResult()[0] : '';
$postid = $page['post_id'];
?>

<div class="ct-header">
    <?php
    $readHome = $read;
    $readHome->FullRead("SELECT post_chamada, post_cover from posts WHERE post_id = 1");
    $home = $readHome->getResult()[0];
    $bg = $page['post_cover'] ? $page['post_cover'] : $home['post_cover'];
    $chamada =  $page['post_chamada'] ? $page['post_chamada'] : $home['post_chamada'];
    ?>
    <div class="background" style="background-image: url(<?= HOME.'/tim.php?src='.HOME.'/uploads/'.$bg.'&w=1920&h=945'; ?>);"></div>

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
        <?= $chamada; ?>
    </section>

</div>

<section class="container internas">
    <h1><?= $page['post_title']; ?></h1>
    <div class="content fr-element fr-view"><?= $page['post_content']; ?></div>
</section>

<?php
$readFaq = $read;
$readFaq->ExeRead('bullets', "WHERE post_id = :post ORDER BY bullet_order ASC", "post={$postid}");
if(!$readFaq->getRowCount()):
    $readFaq->ExeRead('bullets', "WHERE post_id = 1 ORDER BY bullet_order ASC");
endif;
$faq = $readFaq->getResult();
$c = 0;
?>

<section class="container-fluid pq">
    <div class="container">
        <h2>Dúvidas Frequentes</h2>

        <div class="items_container">
            <ul class="accordion">
                <?php foreach($faq as $f): $c++; ?>
                    <li>
                        <input type="checkbox" checked="">
                        <i></i>
                        <div class="ct_title">
                            <h3 data-number="<?= $c; ?>."><?= $f['bullet_title']; ?></h3>
                        </div>
                        <div class="ct_text"><?= $f['bullet_content']; ?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

</section>

<?php
$readForm = new Read;
$readForm->ExeRead('forms', "WHERE form_post = :postid", "postid={$postid}");
if($readForm->getRowCount()):
?>
    <div class="container form-container">
        <h2>Cote on-line</h2>
        <input id="formid" type="hidden" value="<?= $readForm->getResult()[0]['form_id']; ?>"/>
        <form class="send-form">
            <?php
            $objects = unserialize($readForm->getResult()[0]['form_json']);

            foreach ($objects as $form):
                $validate = $form->validate == '1' ? 'required' : false;

                echo '<div class="field-container">';
                switch ($form->type[0]):
                    case 'text':
                        echo "<input type=\"text\" placeholder=\"{$form->name}\" name=\"".Check::Name($form->name)."\" {$validate} >";
                        break;
                    case 'email':
                        echo "<input type=\"email\" placeholder=\"{$form->name}\" name=\"".Check::Name($form->name)."\" {$validate} >";
                        break;
                    case 'tel':
                        echo "<input type=\"tel\" placeholder=\"{$form->name}\" name=\"".Check::Name($form->name)."\" {$validate} >";
                        break;
                    case 'url':
                        echo "<input type=\"url\" placeholder=\"{$form->name}\" name=\"".Check::Name($form->name)."\" {$validate} >";
                        break;
                    case 'textarea':
                        echo "<textarea {$validate} placeholder=\"{$form->name}\" name=\"".Check::Name($form->name)."\" ></textarea>";
                        break;
                    case 'radio':
                        echo '<span class="title-field">'.$form->name.'</span>';

                        foreach($form->options as $options):
                            echo '<label class="radio-field">';
                                echo '<input type="radio" name="'.Check::Name($form->name).'" value="'.$options->option.'"/>';
                                echo '<span>'.$options->option.'</span>';
                            echo '</label>';
                        endforeach;

                        break;
                endswitch;
                echo '</div>';
            endforeach;
            ?>

            <label for="submit">
                <input id="submit" type="submit" name="sendForm" value="enviar" style="display: none;"/>
                Enviar<i class="fa fa-paper-plane" aria-hidden="true"></i>
            </label>

        </form>
    </div>
<?php endif; ?>

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