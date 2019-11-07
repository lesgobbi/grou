<li><a href="<?= HOME; ?>/sobre/">Sobre</a></li>
<li><a href="http://groucorretora.com.br/blog/" target="_blank">Blog</a></li>
<?php
$readMenu = new Read;
$readMenu->FullRead("SELECT post_title, post_name, post_category from posts WHERE post_category = 2 ORDER BY post_title ASC");
if($readMenu->getRowCount()):
    $menus = $readMenu->getResult();
?>
    <li class="dropdown">
        <a href="#">Para Você</a>
        <ul>
            <?php foreach($menus as $menu): ?>
                <li><a href="<?= HOME; ?>/<?= $menu['post_name'];?>/"><?= $menu['post_title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </li>
<?php endif;
$readMenu = new Read;
$readMenu->FullRead("SELECT post_title, post_name, post_category from posts WHERE post_category = 3 ORDER BY post_title ASC");
if($readMenu->getRowCount()):
    $menus = $readMenu->getResult();
    ?>
    <li class="dropdown">
        <a href="#">Para sua Empresa</a>
        <ul>
            <?php foreach($menus as $menu): ?>
                <li><a href="<?= HOME; ?>/<?= $menu['post_name'];?>/"><?= $menu['post_title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </li>
<?php endif; ?>
<li><a class="contato" href="#">Contato</a></li>
<li>
    <a class="social" target="_blank" href="<?= $social_fb; ?>"><img src="<?= HOME; ?>/assets/img/fb.png" /></a>
    <a class="social" target="_blank" href="<?= $social_ig; ?>"><img src="<?= HOME; ?>/assets/img/it.png" /></a>
    <a class="social" target="_blank" href="<?= $social_li; ?>"><img src="<?= HOME; ?>/assets/img/li.png" /></a>
</li>
