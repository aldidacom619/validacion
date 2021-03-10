
<script type="text/javascript" src="<?php echo  base_url() ?>jsd/inmuebles.js"></script>

<ul class="nav nav-tabs">
    <li class="active"><a href="<?php echo base_url()?>index.php/inmuebles/validar/<?php echo $identidad;?>" >Inmuebles</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculos/validarveh/<?php echo $identidad;?>"  >Vehículos</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinaria/validarmaq/<?php echo $identidad;?>" >Maquinaria y Equipos</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinariapesada/validar/<?php echo $identidad;?>">Maquinaria Pesada Móvil</a></li>
    <li ><a href="<?php echo base_url()?>index.php/inmueblesalquiler/validar/<?php echo $identidad;?>">Inmuebles Alquiler</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculosalquiler/validar/<?php echo $identidad;?>">Vehículos Alquiler</a></li>
</ul>

<!--
ESTILO PARA LA VISTA MUEBLES PARA SU VALIDACION
/*autor:Wilmer Villca*/ 
-->

<ul class="nav nav-tabs">
    <li <? if($aux == 1){echo "class='active'"; }?>><a href="<?php echo base_url()?>index.php/inmuebles/validar/<?php echo $identidad;?>" >Lista de Inmuebles a Validar</a></li>
    <li <? if($aux == 2){echo "class='active'"; }?>><a href="<?php echo base_url()?>index.php/inmuebles/validados/<?php echo $identidad;?>">Lista de Inmuebles Validados</a></li>
    <li <? if($aux == 3){echo "class='active'"; }?>><a href="<?php echo base_url()?>index.php/inmuebles/totalbienes/<?php echo $identidad;?>">Lista total de Inmuebles</a></li>
</ul>

<div class="row">
  <div class="paneles">

    <!-- LABEL --> 
    <h3 class="label label-info" style="font-size: 1.15em; display: block;"><?= $title?>

    </h3>
                <?php //if($aux ==3){
                echo "<button type='button' class='btn btn-info active' style='background-color: #fff;padding: 15px 15px;'></button><label>&nbsp Sin validar &nbsp</label>";
                echo "<button type'button' class='btn btn-info active' style='background-color: #fea6a0;padding: 15px 15px;''></button><label>&nbsp Validado pendiente &nbsp</label>";
                echo "<button type'button' class='btn btn-info active' style='background-color: #d5f8b5;padding: 15px 15px;''></button><label>&nbsp Validado &nbsp</label>";
                echo "<button type'button' class='btn btn-info active' style='background-color: #f0f194;padding: 15px 15px;''></button><label>&nbsp Validado Automático &nbsp</label>";
                //}
                ?>
                
    <div class="tabla">
      <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead class="thead">
          <th width="20">Opciones</th>
          <th width="20">Id Bien</th>
          
          <th width="20">Denominación Inmueble</th>
          <th width="20">Terreno o Edificación</th>
          <th width="20">Dirección</th>
          <th width="20">Sup. Terreno</th>
          <th width="20">Sup. Construida</th>
          <th width="20">Departamento</th>
          <th width="20">Documentos</th>
          <th width="20">Estado</th>
          <!--<th width="20">Validacion 2017</th>-->
        </thead> 
        <tbody>

          <? $cont = 1;
           // var_dump($filas)
          ?>
          <? foreach($filas as $fila):?>
          <tr class="odd gradeX" <?php 
                                  if ($fila->idestadovalidacion==5) echo "style='background-color:#fea6a0;'";
                                  if ($fila->idestadovalidacion==3)
                                  {
                                    if ($fila->idtipovalidacion==2) 
                                           echo "style='background-color:#f0f194;'";
                                        else
                                          echo "style='background-color:#d5f8b5;'";
                                  } 
                                      
                                                                     
                                  ?>
          >
            <td width="20"> 
              <button name='btnValidarInmueble' class='btn btn-primary anchoBotones' 
              onclick='abrirDialogValidacion(<?= $fila->id?>)'>Validar  Doc..</button>
            
             
              <?php if($fila->documentos == '') {
              ?>
              <button name='btnSinDocumentacion' class='btn btn-danger anchoBotones'
              onclick='validarSinDocumentacion(<?= $fila->id?>,1)'>Sin Doc</button>
              <?php
              } ?>
            </td>
            <td width="20"><?= $fila->idbien?></td>
           
            <td width="20"><?= $fila->denominacion?></td>
            <td width="20"><?= $fila->tipobien?></td>
            <td width="20"><?= $fila->direccion?></td>
            <td width="20"><?= $fila->superficieterreno?></td>
            <td width="20"><?= $fila->superficieconstruida?></td>
            <td width="20"><?= $fila->departamento?></td>
            <td width="20"><?= $fila->documentos?></td>
            <td width="20"><? if($fila->idsituacion == 1)
            {
              echo "ACTIVO";
            }
            if($fila->idsituacion == 2)
            {
              echo "BAJA";
            }
            if($fila->idsituacion == 3)
            {
              echo "CEDIDO EN COMODATO";
            }
            if($fila->idsituacion == 4)
            {
              echo "ELIMINADO";
            }
            if($fila->idsituacion == 5)
            {
              echo "TRANSFERENCIA DEFINITIVA";
            }
            ?></td>
            <!--
             <td>
              <?php 
              //if($fila->validado==3){
                //echo "VALIDADO";
              //}else{
                //echo "SIN VALIDAR";
              //}
                
              ?>
            </td>
          -->
          </tr>
          <?endforeach?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reporte Individual</h4>
      </div>
        <div class="modal-body" id="infopersona"> 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id = "largemodal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sistema de Validación Documental de la DEJURBE</h4>
      </div>
        <div class="modal-body" id="infopersona">


             <div class="row">
                <div class="col-xs-12">
                    <span class="help-block">Información General</span>
                    <input type="text" id="txtMensajeCabeceraIn" name="txtMensajeCabeceraIn" class="input form-control input-sm">
                </div>
              </div>
              <div class="row">
                <div class="col-xs-8">
                    <span class="help-block" id="nombreEntidad1"><strong>Entidad: <?php echo  devol_entidad_nombre($identidad)?></strong></span>
                </div>
                <div class="col-xs-4">
                    <span class="help-block" id="estadoBien1"><strong> </strong></span>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-8">
                <legend>Documentos presentados por la entidad</legend>
                    
                </div>

                <div class="col-xs-4">
                
                     <?php
                      if (estadoentidad($identidad) == 1)
                       {?>
                     <button name='btnAdicionDocumentoValidarInmueble' class='btn btn-success anchoBotones'          onclick='adicionarDocDialogValidacion(1)'>+ Documento</button>
                       <?php
                       } 
                    ?>
                     
                </div>
            </div>

          <table id="tablaDocumentacionInmueble" class="table table-striped table-bordered" cellspacing="0" width="100%">
          </table>


         <form id="formularioValidacionInmueble">
          <input type="hidden" id="txtIdDocumento" name="txtIdDocumento">
          <input type="hidden" id="txtTipoDocumento" name="txtTipoDocumento">
          <input type="hidden" id="txtIdValidacion" name="txtIdValidacion">
          <input type="hidden" id="txtIdBienInmueble" name="txtIdBienInmueble">
          <input type="hidden" id="txtIdB" name="txtIdB">
          <input type="hidden" id="accion" name="accion">
          <input type="hidden" id="txtListaObservaciones" name="txtListaObservaciones">
          <div id="divCondicionesValidacion" class="row" style="display: none;">
                  <div class="col-xs-4">
                    <span class="help-block">Adjunta?</span>
                    <select id="cbAdjuntaInmueble" class="form-control input-sm" name="cbAdjuntaInmueble">
                        <option value="-1">Seleccione opción</option>
                        <option value="t">Si</option>
                        <option value="f">No</option>
                    </select>
                  </div>
                  <div class="col-xs-4">
                      <span class="help-block">Corresponde al Bien?</span>
                      <select id="cbCorrespondeInmueble" class="form-control input-sm" name="cbCorrespondeInmueble">
                            <option value="-1">Seleccione opción</option>
                            <option value="0">Si</option>
                            <option value="1">No</option>
                        </select>
                  </div>
                  <div class="col-xs-4">
                    <span class="help-block">Legible?</span>
                    <select id="cbLegibleInmueble" class="form-control input-sm" name="cbLegibleInmueble">
                        <option value="-1">Seleccione opción</option>
                        <option value="t">Si</option>
                        <option value="f">No</option>
                    </select>
                  </div>
                  
          </div>
          <div id="divDatosValidacionDocProvisional" class="row" style="display: none;">
                <div class="col-xs-4">
                      <div class="row">
                        <div class="col-xs-12">
                            <span class="help-block">Nro Documento</span>
                            <input type="text" value=""  id="txtNroDocumentoInmuebleProv" class="input form-control input-sm" name="txtNroDocumentoInmuebleProv" readonly="true" tabindex="-1">
                        </div>
                      </div>
                  </div>
                  <div class="col-xs-4">
                      <div class="row">
                         <span class="help-block">Opcion Validación</span>
                          <select id="cbNroDocumentoOpcionProv" class="form-control input-sm" name="cbNroDocumentoOpcionProv" position="1">
                           
                          </select>
                      </div>
                  </div>
                  <div class="col-xs-4">
                      <div class="row">
                        <div class="col-xs-12">
                            <!--<span class="help-block">Nro Documento observado</span>-->
                            <input type="hidden" value=""  id="txtNroDocumentoInmuebleObservadoProv" class="input form-control input-sm" name="txtNroDocumentoInmuebleObservadoProv" readonly="true" position="2">
                        </div>
                      </div>
                  </div>

          </div>

          <div id="divDatosValidacion" class="row" style="display: none;">
                  <div class="col-xs-4">
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Nro Documento</span>
                              <input type="text" value=""  id="txtNroDocumentoInmueble" class="input form-control input-sm" name="txtNroDocumentoInmueble" readonly="true" tabindex="-1">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Superficie</span>
                              <input type="text" value=""  id="txtSuperficieInmueble" class="input form-control input-sm" name="txtSuperficieInmueble" readonly="true" tabindex="-1">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Dirección Ubicación</span>
                              <input type="text" value=""  id="txtDireccionInmueble" class="input form-control input-sm" name="txtDireccionInmueble" readonly="true" tabindex="-1">
                          </div>
                      </div>
                      <!--2018
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Catastro</span>
                              <input type="text" value=""  id="txtCatastroInmueble" class="input form-control input-sm" name="txtCatastroInmueble" readonly="true" tabindex="-1">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Denominación</span>
                              <input type="text" value=""  id="txtDenominacionInmueble" class="input form-control input-sm" name="txtDenominacionInmueble" readonly="true" tabindex="-1">
                          </div>
                      </div>
                       -->
                  </div>
                 <div class="col-xs-4">
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Opcion Validación</span>
                              <select id="cbNroDocumentoOpcion" class="form-control input-sm" name="cbNroDocumentoOpcion" position="1">
                                
                              </select>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Opcion Validación</span>
                              <select id="cbSuperficieOpcion" class="form-control input-sm" name="cbSuperficieOpcion" position="3">
                               
                              </select>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Opcion Validación</span>
                              <select id="cbDireccionOpcion" class="form-control input-sm" name="cbDireccionOpcion" position="5">
                                
                              </select>
                          </div>
                      </div>
                      <!--2018
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Opcion Validación</span>
                              <select id="cbCatastroOpcion" class="form-control input-sm" name="cbCatastroOpcion" position="7">
                                
                              </select>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Opcion Validación</span>
                              <select id="cbDenominacionOpcion" class="form-control input-sm" name="cbDenominacionOpcion" position="9">
                               
                              </select>
                          </div>
                      </div>
                      -->

                  </div>
                  <div class="col-xs-4">


                      <div class="row">
                          <div class="col-xs-12" >

                              <!--<span class="help-block">Nro Documento observado</span>-->
                              <input type="hidden" value=""  id="txtNroDocumentoInmuebleObservado" class="input form-control input-sm" name="txtNroDocumentoInmuebleObservado" readonly="true" position="2">
                          
                          </div>
                      </div> 
                      <div class="row">
                          <div class="col-xs-12">
                              <!--<span class="help-block">Superficie observada</span>-->
                              <input type="hidden" value=""  id="txtSuperficieInmuebleObservado" class="input form-control input-sm" name="txtSuperficieInmuebleObservado" readonly="true" position="4">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <!--<span class="help-block">Dirección Ubicación observada</span>-->
                              <input type="hidden" value=""  id="txtDireccionInmuebleObservado" class="input form-control input-sm" name="txtDireccionInmuebleObservado" readonly="true" position="6">
                          </div>
                      </div>
                      <!--
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Catastro observado</span>
                              <input type="text" value=""  id="txtCatastroInmuebleObservado" class="input form-control input-sm" name="txtCatastroInmuebleObservado" readonly="true" position="8">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Denominación observado</span>
                              <input type="text" value=""  id="txtDenominacionInmuebleObservado" class="input form-control input-sm" name="txtDenominacionInmuebleObservado" readonly="true" position="10">
                          </div>
                      </div>
                      -->
                  </div>
          </div>
          <div id="divObservacionesInmueble" style="display: none;">
            <div class="row">
                <div class="col-xs-12">
                    <span class="help-block">Posibles observaciones</span>
                    <select id="cbObservacionesInmuebles" class="form-control input-sm selectpicker" multiple="multiple" name="cbObservacionesInmuebles" style='width:300px'>


                    </select>
                </div>
                <div class="col-xs-12">
                    <span class="help-block">Otras observaciones</span>
                    <textarea id="txtObservacionesInmuebles" class="form-control" rows="3" name="txtObservacionesInmuebles"></textarea>
                </div>
            </div>
           </div>
          </form>
      </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <?php
            if (estadoentidad($identidad) == 1)
             {?>
                <button id="btnGuardarValidacionInmueble" type="button" class="btn btn-primary" disabled="disabled">Guardar</button>   
             <?php
             } 
          ?>
          
      </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
 




<script type="text/javascript">
  $(document).ready(function(){
       var enlace = "<?php echo  base_url() ?>";
      baseurl(enlace);
      cargacorrespondencia();
        //cargaTablaInmuebles();
          // pestanaValidados();
          comboMultiSelect();
           //marcarFilaTablaDocumentacion();
           verificarSeleccion();
           eventosCombosValidacion();
           //comboMultiSelect();
           botonesDialogoValidacion();

        $("#divAnadirDocumentoValidar").on('hidden.bs.modal', function () {
            //alert('asdfgadsf');
            $("body").addClass("modal-open");
          });
        $("#divAnadirPersonasDoc").on('hidden.bs.modal', function () {
            //alert('asdfgadsf');
            $("body").addClass("modal-open");
          });
    });
  //$(document).on('ready', iniciarFuncion);


</script>
