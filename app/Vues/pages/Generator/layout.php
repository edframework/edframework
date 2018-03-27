<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Générateur de Controller, de Modeles, de pages pour le framework ED">
    <meta name="author" content="Edogawa Cédric">
    <link rel="icon" href="<?=RES?>/images/logo.png">

    <title>Ed Framework Generator </title>

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="<?=RES?>/assets/css/bootstrap.min.css">

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="<?=RES?>/assets/css/bootstrap-extend.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=RES?>/assets/css/font-awesome.min.css">

    <?php
    if (isset($includes['css'])){
        foreach ($includes['css'] as $include) {
            echo "<link rel=\"stylesheet\" href=\"".RES."/assets/css/{$include}\">";
        }
    }
    ?>

    
    <link rel="stylesheet" href="<?=RES?>/assets/css/jquery.toast.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?=RES?>/assets/css/master_style.css">

    <link rel="stylesheet" href="<?=RES?>/assets/css/_all-skins.css">

    <!-- jQuery 3 -->
    <script src="<?=RES?>/assets/js/jquery.min.js"></script>

    <!-- popper -->
    <script src="<?=RES?>/assets/js/popper.min.js"></script>

    <!-- Bootstrap 4.0-->
    <script src="<?=RES?>/assets/js/bootstrap.min.js"></script>

    <?php
    if (isset($includes['js'])){
        foreach ($includes['js'] as $include) {
            echo "<script src=\"".RES."/assets/js/{$include}\"></script>";
        }
    }
    ?>

    <!-- SlimScroll -->
    <script src="<?=RES?>/assets/js/jquery.slimscroll.min.js"></script>

    <!-- FastClick -->
    <script src="<?=RES?>/assets/js/fastclick.js"></script>

    <script src="<?=RES?>/assets/js/jquery.toast.js"></script>


    <!-- minimal_admin App -->
    <script src="<?=RES?>/assets/js/template.js"></script>

    <!-- minimal_admin for demo purposes -->
    <script src="<?=RES?>/assets/js/demo.js"></script>
    <script src="<?=RES?>/assets/js/controls.js"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="/Generator" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="../../images/minimal.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Ed</b>Framework</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <?php foreach ($menu as $m) : ?>
                    <li class="treeview">
                    <a href="<?=$m['lien']?>">
                        <i class="<?=$m['icon']?>"></i>
                        <span><?=$m['nom']?></span>
                        <?php if (isset($m['sous-menu'])) : ?>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        <?php endif; ?>
                    </a>
                        <?php if (isset($m['sous-menu'])) : ?>
                            <?php if (count($m['sous-menu']) != 0) : ?>
                                <ul class="treeview-menu">
                                <?php foreach ($m['sous-menu'] as $sm) : ?>
                                    <li><a href="<?=$sm['lien']?>"><?=$sm['nom']?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        <?php endif; ?>
                </li>
                <?php endforeach; ?>

            </ul>
        </section>
        <!-- /.sidebar -->
        <div class="sidebar-footer">
            <!-- item-->
            <a href="<?=WROOT?>Generator/help" class="link" data-toggle="tooltip" title="" data-original-title="Aide"><i class="fa fa-cog fa-spin"></i></a>
            <!-- item-->
            <a href="<?=WROOT?>Generator/sendMail" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="fa fa-envelope"></i></a>
            <!-- item-->
            <a href="<?=WROOT?>Generator/removeGen" class="link" data-toggle="tooltip" title="" data-original-title="Supprimer le générateur"><i class="fa fa-power-off"></i></a>
        </div>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?=$content;?>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>Copyright &copy; <?=date('Y')?>. All Rights Reserved.
    </footer>


    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


</body>

</html>
