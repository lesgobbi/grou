<div class="sidebar-placeholder"></div>
<div class="sidebar-outer-wrapper">
    <div class="sidebar-inner-wrapper">
        <div class="sidebar-1">
            <div class="sidebar-nav">
                <div class="sidebar-section">
                    <div class="section-title hidden">Navegação</div>
                    <ul class="l1 list-unstyled section-content">
                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=general/general">
                                <i class="zmdi zmdi-settings md-icon pull-left"></i>
                                <span class="title">Configurações Gerais</span> 
                            </a>
                        </li>

                        <li>
                            <?php $item = 'paginas'; ?>
                            <a class="sideline" data-id="<?=$item;?>" data-click="toggle-section">
                                <i class="pull-right fa fa-caret-down icon-<?=$item;?>"></i> 
                                <i class="fa md-icon fa-image pull-left"></i>
                                <span class="title">Páginas</span>
                            </a>
                            <ul class="list-unstyled section-<?=$item;?> l2">
                                <li>
                                    <a class="sideline" href="?exe=posts/posts">
                                        <span class="title">Listar Páginas</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=posts/create">
                                        <span class="title">Nova Página</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=posts/update&postid=1">
                                <i class="fa fa-briefcase md-icon pull-left"></i>
                                <span class="title">Padrão & FAQ</span>
                            </a>
                        </li>

                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=posts/update&postid=3">
                                <i class="fa fa-briefcase md-icon pull-left"></i>
                                <span class="title">Sobre</span>
                            </a>
                        </li>

                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=posts/update&postid=2">
                                <i class="fa fa-briefcase md-icon pull-left"></i>
                                <span class="title">Dica do especialista</span>
                            </a>
                        </li>

                        <li>
                            <?php $item = 'users'; ?>
                            <a class="sideline" data-id="<?=$item;?>" data-click="toggle-section">
                                <i class="pull-right fa fa-caret-down icon-<?=$item;?>"></i> 
                                <i class="zmdi zmdi-accounts md-icon pull-left"></i> 
                                <span class="title">Usuários</span> 
                            </a>
                            <ul class="list-unstyled section-<?=$item;?> l2">
                                <li>
                                    <a class="sideline" href="?exe=users/users">
                                        <span class="title">Listar Usuários</span> 
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=users/create">
                                        <span class="title">Novo Usuário</span> 
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>