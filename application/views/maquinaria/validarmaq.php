<script type="text/javascript" src="<?php echo  base_url() ?>jsd/maquinaria.js"></script>
<br>
<ul class="nav nav-tabs">

    <li ><a href="<?php echo base_url()?>index.php/inmuebles/validar/<?php echo $identidad;?>" >Inmuebles</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculos/validarveh/<?php echo $identidad;?>"  >Vehículos</a></li>
    <li class="active"><a href="<?php echo base_url()?>index.php/maquinaria/validarmaq/<?php echo $identidad;?>"  >Maquinaria y Equipos</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinariapesada/validar/<?php echo $identidad;?>"  >Maquinaria Pesada Móvil</a></li>
    <li ><a href="<?php echo base_url()?>index.php/inmueblesalquiler/validar/<?php echo $identidad;?>"  >Inmuebles Alquiler</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculosalquiler/validar/<?php echo $identidad;?>"  >Vehículos Alquiler</a></li>
</ul>


<ul class="nav nav-tabs">
   <li <? if($aux == 1){echo "class='active'"; }?>><a href="<?php echo base_url()?>index.php/maquinaria/validarmaq/<?php echo $identidad;?>" >Lista de Maquinaria a Validar</a></li>
    <li <? if($aux == 2){echo "class='active'"; }?> ><a href="<?php echo base_url()?>index.php/maquinaria/validadosmaq/<?php echo $identidad;?>"  >Lista de Maquinaria Validados</a></li>
    <li <? if($aux == 3){echo "class='active'"; }?> ><a href="<?php echo base_url()?>index.php/maquinaria/totalmaq/<?php echo $identidad;?>"  >Lista total de Maquinaria</a></li>
</ul>


<div class="row">
        <div class="col-lg-12"> 

          <h3 class="label label-info" style="font-size: 1.15em; display: block;"><?= $title?></h3>

               <?php //if($aux ==3){
                echo "<button type='button' class='btn btn-info active' style='background-color: #fff;padding: 15px 15px;'></button><label>&nbsp Sin validar &nbsp</label>";
                echo "<button type'button' class='btn btn-info active' style='background-color: #fea6a0;padding: 15px 15px;''></button><label>&nbsp Validado pendiente &nbsp</label>";
                echo "<button type'button' class='btn btn-info active' style='background-color: #d5f8b5;padding: 15px 15px;''></button><label>&nbsp Validado &nbsp</label>";
                echo "<button type'button' class='btn btn-info active' style='background-color: #f0f194;padding: 15px 15px;''></button><label>&nbsp Validado Automático &nbsp</label>";
                //}
                ?>

                      <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                   <thead>

                                    <th width="20">Opciones</th>
                                    <th width="20">IdBien</th>
                                    <th width="20">Descripción</th>
                                    <th width="20">Tipo Bien</th>
                                    <th width="20">Marca</th>
                                    <th width="20">Modelo</th>
                                    <th width="20">Nro. Serie</th>
                                    <th width="20">Documentos</th>
                                    <th width="10">Estado</th>


                   </thead> 
                  <tbody>
                   <? $cont = 1?>
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

<button name='btnValidarInmueble' class='btn btn-primary anchoBotones' onclick='abrirDialogValidacion(<?= $fila->id?>)'>Validar  Doc.</button>


                                                <?php if($fila->documentos == ''){
                                                    ?>
                                                    <button name='btnSinDocumentacion' class='btn btn-danger anchoBotones' onclick='validarSinDocumentacion(<?= $fila->id?>,4)'>Sin Doc</button>
                                                    <?php
                                                     } ?>
                                            </td>
                                           <td width="20"><?= $fila->idbien?></td>
                                            <td width="20"><?= $fila->descripcion?></td>
                                            <td width="20"><?= $fila->tipobien?></td>
                                            <td width="20"><?= $fila->marca?></td>
                                            <td width="20"><?= $fila->modelo?></td>
                                            <td width="20"><?= $fila->nroserie ?></td>
                                            <td width="20"><?= $fila->documentos?></td>
                                            <td width="10"><? if($fila->idsituacion == 1)
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



                                        </tr>
                                      <?endforeach?>
                                        </tbody>

                                </table>




                            </div>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
        </div>
                <!-- /.col-lg-12 -->
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
                    <input type="text" id="txtMensajeCabeceraVe" name="txtMensajeCabeceraVe" class="input form-control input-sm">
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
                     <button name='btnAdicionDocumentoValidarInmueble' class='btn btn-success anchoBotones' onclick='adicionarDocDialogValidacion(4)'>+ Documento</button>
                       <?php
                       } 
                    ?>
                     
                </div>
            </div>



            <table id="tablaMaquinariaValidados" class="table table-striped table-bordered" cellspacing="0" width="100%">
            </table>




             <form id="formularioValidacionMaquinaria">

              <input type="hidden" id="txtIdDocumentoMaquinaria" name="txtIdDocumentoMaquinaria" value="">
              <input type="hidden" id="txtTipoDocumentoMaquinaria" name="txtTipoDocumentoMaquinaria" value="">
              <input type="hidden" id="txtIdValidacionMaquinaria" name="txtIdValidacionMaquinaria" value="">
              <input type="hidden" id="txtIdBienMaquinaria" name="txtIdBienMaquinaria" value="">
              <input type="hidden" id="txtIdB" name="txtIdB" value="">
              <input type="hidden" id="operacion" name="operacion" value="">
              <input type="hidden" id="txtListaObservacionesMaquinaria" name="txtListaObservacionesMaquinaria" value="">
                <div id="divCondicionesValidacionMaquinaria" class="row" style="display: none;">

                        <div class="col-xs-4">
                            <span class="help-block">¿Adjunta?</span>
                            <select id="cbAdjuntaMaquinaria" class="form-control input-sm linkResetCb" name="cbAdjuntaMaquinaria" >
                                <option value="-1">Seleccione</option>
                                <option value="t">Si</option>
                                <option value="f">No</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <span class="help-block">¿Corresponde al Bien?</span>
                            <select id="cbCorrespondeMaquinaria" class="form-control input-sm linkResetCb" name="cbCorrespondeMaquinaria" >
                                <option value="-1">Seleccione</option>
                                <option value="1">Si</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <span class="help-block">¿Legible?</span>
                            <select id="cbLegibleMaquinaria" class="form-control input-sm linkResetCb" name="cbLegibleMaquinaria" >
                                <option value="-1">Seleccione</option>
                                <option value="t">Si</option>
                                <option value="f">No</option>
                            </select>
                        </div>
                        <div class="col-xs-3" style="display:none">
                            <span class="help-block">Estado Documentación</span>
                            <select id="cbEstadoDocumentacionMaquinaria" class="form-control input-sm" name="cbEstadoDocumentacionMaquinaria" readonly="readonly">
                                <option value="-1">Seleccione</option>
                                <option value="1">Definitiva</option>
                                <option value="2">Provisional</option>
                                <option value="3">Preventivo</option>
                            </select>
                        </div>

                </div>

                <div id="divDatosValidacionDocMaquinariaProvisional" class="row" style="display: none;">
                    <div class="col-xs-4">
                          <div class="row">
                            <div class="col-xs-12">
                                <span class="help-block">Nro Documento</span>
                                <input type="text" value=""  id="txtNroDocumentoMaquinariaProv" class="input form-control input-sm" name="txtNroDocumentoMaquinariaProv" readonly="readonly" tabindex="-1">
                            </div>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                             <span class="help-block">Opcion Validación</span>
                              <select id="cbNroDocumentoOpcionMaquinariaProv" class="form-control input-sm linkResetCb" name="cbNroDocumentoOpcionMaquinariaProv" position="1">
                               
                              </select>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                            <div class="col-xs-12">
                                <!--<span class="help-block">Nro Documento observado</span>-->
                                <input type="hidden" value=""  id="txtNroDocumentoMaquinariaObservadoProv" class="input form-control input-sm" name="txtNroDocumentoMaquinariaObservadoProv" readonly="true" position="2">
                            </div>
                          </div>
                      </div>

              </div>


                <div id="divDatosValidacionMaquinaria" class="row" style="display: none;">
                   <!-- <div class="row">-->
                        <div class="col-xs-4">
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro Documento</span>
                                    <input type="text" value=""  id="txtNroDocumentoMaquinaria" class="input form-control input-sm" name="txtNroDocumentoMaquinaria" readonly="readonly" tabindex="-1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Equipo</span>
                                    <input type="text" value=""  id="txtEquipoMaquinaria" class="input form-control input-sm" name="txtEquipoMaquinaria" readonly="readonly" tabindex="-1">
                                </div>
                            </div>

                            <!--2018
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Marca</span>
                                    <input type="text" value=""  id="txtMarcaMaquinaria" class="input form-control input-sm" name="txtMarcaMaquinaria" readonly="readonly" tabindex="-1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Modelo</span>
                                    <input type="text" value=""  id="txtModeloMaquinaria" class="input form-control input-sm" name="txtModeloMaquinaria" readonly="readonly" tabindex="-1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Serie</span>
                                    <input type="text" value=""  id="txtSerieMaquinaria" class="input form-control input-sm" name="txtSerieMaquinaria" readonly="readonly" tabindex="-1">
                                </div>
                            </div>
                            -->
                        </div>
           <div class="col-xs-4">
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbNroDocumentoMaquinariaOpcion" class="form-control input-sm linkResetCb" name="cbNroDocumentoMaquinariaOpcion" position="1">
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbEquipoMaquinariaOpcion" class="form-control input-sm linkResetCb" name="cbEquipoMaquinariaOpcion" position="3">
                                       
                                    </select>
                                </div>
                            </div>
                            <!--2018
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbMarcaMaquinariaOpcion" class="form-control input-sm linkResetCb" name="cbMarcaMaquinariaOpcion" position="5">
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbModeloMaquinariaOpcion" class="form-control input-sm linkResetCb" name="cbModeloMaquinariaOpcion" position="7">
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbSerieMaquinariaOpcion" class="form-control input-sm linkResetCb" name="cbSerieMaquinariaOpcion" position="9">
                                       
                                    </select>
                                </div>
                            </div>
                            -->
                        </div>
           <div class="col-xs-4">


                            <div class="row">
                                <div class="col-xs-12" id="divNroDocumentoObservadoMaquinaria">
                                    <!--<span class="help-block">Nro Documento observado</span>-->
                                    <input type="hidden" value=""  id="txtNroDocumentoObservadoMaquinaria" class="input form-control input-sm" name="txtNroDocumentoObservadoMaquinaria" readonly="true" position="2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12" id="divEquipoObservadoMaquinaria">
                                    <!--<span class="help-block">Descripción observada</span>-->
                                    <input type="hidden" value=""  id="txtDescripcionObservadoMaquinaria" class="input form-control input-sm" name="txtDescripcionObservadoMaquinaria" readonly="true" position="4">
                                </div>
                            </div>
                            <!--2018
                            <div class="row">
                                <div class="col-xs-12" id="divMarcaObservadoMaquinaria">
                                    <span class="help-block">Marca observada</span>
                                    <input type="text" value=""  id="txtMarcaObservadoMaquinaria" class="input form-control input-sm" name="txtMarcaObservadoMaquinaria" readonly="true" position="6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12" id="divModeloObservadoMaquinaria">
                                    <span class="help-block">Modelo observado</span>
                                    <input type="text" value=""  id="txtModeloObservadoMaquinaria" class="input form-control input-sm" name="txtModeloObservadoMaquinaria" readonly="true" position="8">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12" id="divSerieObservadoMaquinaria">
                                    <span class="help-block">Serie observada</span>
                                    <input type="text" value=""  id="txtSerieObservadoMaquinaria" class="input form-control input-sm" name="txtSerieObservadoMaquinaria" readonly="true" position="10">
                                </div>
                            </div>
                            -->
                        </div>
                    <!--</div>-->
                </div>
                <div id="divObservacionesMaquinaria" class="row ocultaDiv" style="display:none">
                  <div class="row">
                      <div class="col-xs-12">
                      <legend>Observaciones Generales</legend>
                        <span class="help-block">Observaciones Específicas</span>
                        <select id="cbObservacionEspecificaMaquinaria" name="cbObservacionEspecificaMaquinaria" class="form-control input-sm linkResetCb selectpicker" multiple="multiple">

                        </select>

                      </div>
                   </div>
                   <div class="row">
                        <div class="col-xs-12">
                            <span class="help-block">Observaciones Generales</span>
                            <textarea class="form-control input-sm" id="txtObservacionesGeneralesMaquinaria" name="txtObservacionesGeneralesMaquinaria" rows="4" cols="2" value="" ></textarea>
                        </div>
                    </div>
               </div>
                </form>



                  </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
           <?php
            if (estadoentidad($identidad) == 1)
             {?>
                <button id="btnGuardarValidacionMaquinaria" type="button" class="btn btn-primary" disabled="disabled" >Guardar</button>
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
      
      eventosCombosValidacionMaquinaria();
      botonesDialogoValidacion();
      opcionMultiselect();
       habilitaObservaciones();
        $("#divAnadirDocumentoValidar").on('hidden.bs.modal', function () {
            //alert('asdfgadsf');
            $("body").addClass("modal-open");
          });
        $("#divAnadirPersonasDoc").on('hidden.bs.modal', function () {
            //alert('asdfgadsf');
            $("body").addClass("modal-open");
          });
    // verificarSeleccion();
    // eventosCombosValidacionVehiculo();
    // botonesDialogoVehiculoValidacion();

     //habilitaObservaciones();

    });
</script>
