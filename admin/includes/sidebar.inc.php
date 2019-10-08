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
                            <?php $item = 'banners'; ?>
                            <a class="sideline" data-id="<?=$item;?>" data-click="toggle-section">
                                <i class="pull-right fa fa-caret-down icon-<?=$item;?>"></i> 
                                <i class="fa md-icon fa-image pull-left"></i>
                                <span class="title">Banners</span> 
                            </a>
                            <ul class="list-unstyled section-<?=$item;?> l2">
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/<?=$item;?>">
                                        <span class="title">Listar Banners</span> 
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/create">
                                        <span class="title">Novo Banner</span> 
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=nosso-time/update">
                                <i class="fa fa-briefcase md-icon pull-left"></i>
                                <span class="title">Nosso Time</span> 
                            </a>
                        </li>
                        
                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=destaque/update">
                                <i class="fa fa-align-center md-icon pull-left"></i>
                                <span class="title">Destaque</span> 
                            </a>
                        </li>

                        <li>
                            <?php $item = 'arquitetos'; ?>
                            <a class="sideline" data-id="<?=$item;?>" data-click="toggle-section">
                                <i class="pull-right fa fa-caret-down icon-<?=$item;?>"></i> 
                                <i class="fa md-icon fa-users pull-left"></i>
                                <span class="title">Arquitetos</span> 
                            </a>
                            <ul class="list-unstyled section-<?=$item;?> l2">
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/<?=$item;?>">
                                        <span class="title">Listar Arquitetos</span> 
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/update-featured">
                                        <span class="title">Editar Principal</span> 
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/create">
                                        <span class="title">Novo Arquiteto</span> 
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/update-text">
                                        <span class="title">Editar Texto</span> 
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=porque-madeira/update">
                                <i class="fa fa-question-circle md-icon pull-left"></i>
                                <span class="title">Por que madeira</span>
                            </a>
                        </li>

                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=porque-vinilicos/update">
                                <i class="fa fa-question-circle md-icon pull-left"></i>
                                <span class="title">Por que vinílicos</span>
                            </a>
                        </li>

                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=destaque-2/update">
                                <i class="fa fa-align-center md-icon pull-left"></i>
                                <span class="title">Destaque 2</span>
                            </a>
                        </li>

                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=forms/update&formid=2">
                                <i class="fa fa-paper-plane md-icon pull-left"></i>
                                <span class="title">Formulário de contato</span> 
                            </a>
                        </li>

                        <li>
                            <?php $item = 'noticias'; ?>
                            <a class="sideline" data-id="<?=$item;?>" data-click="toggle-section">
                                <i class="pull-right fa fa-caret-down icon-<?=$item;?>"></i> 
                                <i class="fa md-icon fa-file-text-o pull-left"></i>
                                <span class="title">Notícias</span> 
                            </a>
                            <ul class="list-unstyled section-<?=$item;?> l2">
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/<?=$item;?>">
                                        <span class="title">Listar Notícias</span> 
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/create">
                                        <span class="title">Nova Notícia</span> 
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <?php $item = 'nossas-marcas'; ?>
                            <a class="sideline" data-id="<?=$item;?>" data-click="toggle-section">
                                <i class="pull-right fa fa-caret-down icon-<?=$item;?>"></i> 
                                <i class="fa md-icon fa-handshake-o pull-left"></i>
                                <span class="title">Nossas Marcas</span> 
                            </a>
                            <ul class="list-unstyled section-<?=$item;?> l2">
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/<?=$item;?>">
                                        <span class="title">Listar Marcas</span> 
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/create">
                                        <span class="title">Nova Marca</span> 
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <?php $item = 'categorias'; ?>
                            <a class="sideline" data-id="<?=$item;?>" data-click="toggle-section">
                                <i class="pull-right fa fa-caret-down icon-<?=$item;?>"></i> 
                                <i class="fa md-icon fa-navicon pull-left"></i>
                                <span class="title">Categorias</span> 
                            </a>
                            <ul class="list-unstyled section-<?=$item;?> l2">
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/<?=$item;?>">
                                        <span class="title">Listar Categorias</span> 
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/create">
                                        <span class="title">Nova Categoria</span> 
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sideline" href="<?= HOME; ?>/admin/painel.php?exe=referencias/update">
                                <i class="fa fa-square md-icon pull-left"></i>
                                <span class="title">Referências</span> 
                            </a>
                        </li>

                        <li>
                            <?php $item = 'produto'; ?>
                            <a class="sideline" data-id="<?=$item;?>" data-click="toggle-section">
                                <i class="pull-right fa fa-caret-down icon-<?=$item;?>"></i> 
                                <i class="fa md-icon fa-picture-o pull-left"></i>
                                <span class="title">Galeria de Produtos</span> 
                            </a>
                            <ul class="list-unstyled section-<?=$item;?> l2">
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/update">
                                        <span class="title">Galeria</span> 
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=<?=$item;?>/text">
                                        <span class="title">Texto</span> 
                                    </a>
                                </li>
                            </ul>
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

                        <li>
                            <?php $item = 'area-restrita'; ?>
                            <a class="sideline" data-id="<?=$item;?>" data-click="toggle-section">
                                <i class="pull-right fa fa-caret-down icon-<?=$item;?>"></i> 
                                <i class="fa fa-sign-in md-icon pull-left"></i> 
                                <span class="title">Área Restrita</span> 
                            </a>
                            <ul class="list-unstyled section-<?=$item;?> l2">
                                <li>
                                    <a class="sideline" href="?exe=<?= $item; ?>/<?= $item; ?>">
                                        <span class="title">Listar Posts</span> 
                                    </a>
                                </li>
                                <li>
                                    <a class="sideline" href="?exe=<?= $item; ?>/create">
                                        <span class="title">Novo Post</span> 
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