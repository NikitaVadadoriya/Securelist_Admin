<?php
$user_type = str_replace(' ', '', $this->utype);
$home_url = $this->home_url;
$m_manage_users = array('Manage Supervisor'=>'manage_supervisor','Manage Team Leader'=>'manage_tl','Manage Social Entrepreneur'=>'manage_se' );
$s_manage_users = array('Manage Team Leader'=>'manage_tl','Manage Social Entrepreneur'=>'manage_se' );
$tl_manage_users = array('Manage Social Entrepreneur'=>'manage_se' );

$url = isset($_GET['url']) ? $_GET['url'] : 'index';

$url = rtrim($url, '/');

$url = explode('/', $url);
?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=URL?>Manager/index" class="brand-link">
        <img src="<?=URL?>public/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text"><?=$this->utype?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=URL?>public/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=$this->user_name?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?=URL?><?=$user_type?>/<?=$home_url?>"
                        class="nav-link <?php echo $url[1] == $home_url ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">

                    <a href="<?=URL?><?=$user_type?>/manage_device"
                        class="nav-link <?php echo $url[1] == 'manage_device' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-mobile-alt"></i>
                        <p>
                            Manage Device
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Manage Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">

                        <?php
                            switch ($user_type) {
                                case 'Manager':
                                    foreach ($m_manage_users as $key => $value) {

                                        ?>
                        <li class="nav-item">
                            <a href="<?=URL?><?=$user_type?>/<?=$value?>"
                                class="nav-link <?php echo $url[1] == $value ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    <?=$key?>
                                </p>
                            </a>
                        </li>
                        <?php
                                    }
                                    break;

                                case 'Supervisor':
                                    foreach ($s_manage_users as $key => $value) {

                                        ?>
                        <li class="nav-item">
                            <a href="<?=URL?><?=$user_type?>/<?=$value?>"
                                class="nav-link <?php echo $url[1] == $value ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    <?=$key?>
                                </p>
                            </a>
                        </li>
                        <?php
                                    }
                                    break;
                                case 'TeamLeader':
                                    foreach ($tl_manage_users as $key => $value) {

                                        ?>
                        <li class="nav-item">
                            <a href="<?=URL?><?=$user_type?>/<?=$value?>"
                                class="nav-link <?php echo $url[1] == $value ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    <?=$key?>
                                </p>
                            </a>
                        </li>
                        <?php
                                    }
                                    break;
                            }
?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?=URL?>logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
