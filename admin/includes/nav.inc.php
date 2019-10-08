<?php
$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);

if (!$login->CheckLogin()):
    unset($_SESSION['userlogin-' . CLIENT_NAME]);
    header('Location: login.php?exe=restrito');
else:
    $userlogin = $_SESSION['userlogin-' . CLIENT_NAME];
endif;

if ($logoff):
    unset($_SESSION['userlogin-' . CLIENT_NAME]);
    header('Location: login.php?exe=logoff');
endif;
?>
<nav class="navbar navbar-fixed-top navbar-1">
    <ul class="nav navbar-nav pull-left toggle-layout">
        <li class="nav-item">
            <a class="nav-link" data-click="toggle-layout">
                <i class="zmdi zmdi-menu"></i> 
            </a>
        </li>
    </ul>
    <ul class="nav navbar-nav pull-left toggle-fullscreen-mode">
        <li class="nav-item">
            <a class="nav-link" data-click="toggle-fullscreen-mode">
                <i class="zmdi zmdi-fullscreen"></i> 
            </a>
        </li>
    </ul>
<!--    <ul class="nav navbar-nav pull-left toggle-search">
        <li class="nav-item">
            <a class="nav-link" data-click="toggle-search">
                <i class="zmdi zmdi-search"></i> 
            </a>
        </li>
    </ul>
    <div class="navbar-drawer pull-left hidden-lg-down">
        <form class="form-inline navbar-form ">
            <input class="form-control" type="text" placeholder="Search">
        </form>
    </div>-->
    
    <ul class="nav navbar-nav pull-right">
        <li class="nav-item">
            <a class="nav-link" href="?exe=users/profile">
                <i class="zmdi zmdi-account"></i> 
                <span class="title"><?= $userlogin['user_name']; ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="?logoff=true" class="nav-link">
                <i class="zmdi zmdi-sign-in md-icon pull-left"></i> 
                <span class="title">Deslogar</span>
            </a>
        </li>
    </ul>

</nav>