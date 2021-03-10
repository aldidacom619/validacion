<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="SENAPE">

        <title>Validacion - SENAPE</title>
        <!-- baseUrl -->
    <input type="hidden" name="baseUrl" value="<?= base_url() ?>" id="baseUrl">
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/jquery-ui/css/jquery-ui.css">

    <!-- MetisMenu CSS -->
    <link href="<?= base_url() ?>assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
 
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?= base_url() ?>assets/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= base_url() ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="<?= base_url() ?>assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?= base_url() ?>assets/vendor/jquery/jquery1.12.js"></script>
    <script src="<?= base_url() ?>assets/vendor/jquery-ui/js/jquery-ui.js"></script>

</head>
<body>
<!-- librerias chart-->
<script src="<?= base_url() ?>assets/code/highcharts.js"></script>
<script src="<?= base_url() ?>assets/code/modules/exporting.js"></script>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">VALIDACION DOCUMENTAL - ADMIN </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a  class="menu" class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?= $usuario ?>
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
<!--                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Mi Perfil</a>
                        </li>-->
                        <li><a  class="menu"  href="<?= base_url() ?>inicio" target="black"><i class="fa fa-gear fa-fw"></i> Validador</a>
                        </li>
                        <li class="divider"></li>
                        <li><a  class="menu" href="<?= base_url() ?>usuarios/salir"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!--                        <li class="sidebar-search">
                                                    <div class="input-group custom-search-form">
                                                        <input type="text" class="form-control" placeholder="Buscar...">
                                                        <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                    </div>
                                                     /input-group
                                                </li>-->
                        <li>
                            <a  class="menu" href="<?= base_url() ?>administrador"><i class="fa fa-home fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a  class="menu" href="<?= base_url() ?>adminvalidadores/validadores"><i class="fa fa-users"></i> Validadores</a>
                        </li>
                        <li>
                            <a class="menu" href="<?= base_url() ?>adminreportes"><i class="fa fa-print"></i> Reportes</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div> 
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">




