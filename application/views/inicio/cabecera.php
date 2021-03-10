<!DOCTYPE html>
<html>
<head>

	<title><?= $title ?></title>
	<link rel="stylesheet" href="<?php echo  base_url() ?>tables/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="<?php echo  base_url() ?>tables/bower_components/bootstrap/dist/css/datepicker.css">
  
	<link rel="stylesheet" href="<?php echo  base_url() ?>tables/bower_components/metisMenu/dist/metisMenu.min.css">
<link rel="stylesheet" href="<?php echo  base_url() ?>tables/css/estilos.css">
	<script src="<?php echo  base_url () ?>jsd/jquery.js"></script>
	<link rel="stylesheet" href="<?php echo  base_url() ?>tables/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?php echo  base_url() ?>tables/bower_components/datatables-responsive/css/dataTables.responsive.css">
  <link rel="stylesheet" href="<?php echo  base_url() ?>tables/css/bootstrap-multiselect.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>tables/bower_components/font-awesome/css/font-awesome.min.css"/>

  <script src="<?php echo  base_url () ?>jsd/jquery.js"></script>
  <link href="<?php echo  base_url() ?>tables/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="<?php echo  base_url() ?>tables/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets/js/plugins/notifications/sweet_alert.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo  base_url() ?>jsd/principal.js"></script><!--2019 hist-->
</head>
<body>
<!--  delete class container -->
<div class="container" style="width: 100%;">

   <div id="cabecera">
        <div class="row" style="background-color: #EEEEEE;">
          <div style="width: 100%;" class="navbar navbar-inverse">
          <div class="avatar">
            <img src="<?php echo base_url(); ?>/tables/icons/checked_user.png" width="40px" />
          </div>
          <div class="name">
            <span class="user-name"><?php echo $nombre_completo; ?></span>
          </div>
          <div class="cerrar">
            <div class="close_session">
              <img src="<?php echo base_url(); ?>/tables/icons/exit_to_app.png" width="25px" />
              <a href="<?php echo base_url()?>index.php/usuarios/salir" role="button">Cerrar sesión</a>
            </div>
          </div>
        </div>
          <div class="col-lg-7">
           <p class="tituloNombre" id="nombreEntidad"> <span><?php echo devol_entidad_nombre($identidad);  ?> </span></p>
          </div>

          <!--  delete class col-xs-12 -->
            <div class="navegacion">                               
              <a  class="boton-nav" href="<?php echo base_url()?>index.php/inicio" style="color: white;"  role="button"> 
							  <img   src="<?php echo base_url(); ?>/tables/icons/list-ul.png" width="25px"/>
							  <span style="color: white;">✓&nbsp;</span>
							  Lista de Entidades Asignadas
						  </a>                  
                      
            <a  class="boton-nav"style="color: white;" href="<?php echo base_url()?>index.php/reportes" role="button">
						  <img src="<?php echo base_url(); ?>/tables/icons/document.png" width="25px"/>
						  <span style="color: white;">✓&nbsp;</span>Reportes
					  </a>
            <a  class="boton-nav"style="color: white;" href="<?php echo base_url()?>index.php/inicio/buscar" role="button">
              <img src="<?php echo base_url(); ?>/tables/icons/preview_search_find_locate_1551.png" width="25px"/>
              <span style="color: white;">✓&nbsp;</span>Buscar
            </a>
            <!--2019 hist-->
            <a href="#" class="boton-nav" style="color: white;" role="button" data-toggle="modal" onclick='abrirDialoghistorial(<?php echo $this->session->userdata('idfuncionario');?>)'><img src="<?php echo base_url(); ?>/tables/icons/reloj3.png" width="25px"/>
            </span> Historial</a>
            <!--2019 hist-->                    
                    <?php if($_SESSION['administrador']== 't'){?>
                        
                            <a  class="admin " class=" boton-nav" style="color: white;" href="<?php echo base_url()?>index.php/administrador" role="button">
							  <img src="<?php echo base_url(); ?>/tables/icons/ic_report.png" width="25px"/>Administrar
							</a>
                        
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
 <div class="row">
		<div class="col-md-12" >
<!--2019 hist-->
<div id = "largemodalhistorial" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-full" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title label label-info">ENTIDADES VALIDADAS POR: <?php echo $this->session->userdata('nombre_completo');?> </h4>
      </div>
        <div class="modal-body">

                    <table style="font-size: 11px;" with="100%" id="HistorialTable1" class="table datatable-basic table-striped table-hover table-bordered" >
                          <thead>
                              <tr>
                                  <td>NRO</td>
                                  <td style="width:700px;">ENTIDAD</td>
                              </tr>
                            </thead>
                          <tbody>                    
                          </tbody>                
                      </table>
        
      </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          
      </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function(){
       var enlace = "<?php echo  base_url() ?>";
      baseurl(enlace);
      
    });
  
</script>