<script type="text/javascript" src="<?php echo  base_url() ?>jsd/maquinariapesada.js"></script>

<ul class="nav nav-tabs">

    <li ><a href="<?php echo base_url()?>index.php/inmuebles/validar/<?php echo $identidad;?>" >Inmuebles</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculos/validarveh/<?php echo $identidad;?>"  >Vehículos</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinaria/validarmaq/<?php echo $identidad;?>"  >Maquinaria y Equipos</a></li>
    <li class="active"><a href="<?php echo base_url()?>index.php/maquinariapesada/validar/<?php echo $identidad;?>"  >Maquinaria Pesada Móvil</a></li>
    <li ><a href="<?php echo base_url()?>index.php/inmueblesalquiler/validar/<?php echo $identidad;?>"  >Inmuebles Alquiler</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculosalquiler/validar/<?php echo $identidad;?>"  >Vehículos Alquiler</a></li>
</ul>


<ul class="nav nav-tabs">
   <li <? if($aux == 1){echo "class='active'"; }?>><a href="<?php echo base_url()?>index.php/maquinariapesada/validar/<?php echo $identidad;?>" >Maquinaria Pesada a Validar</a></li>
    <li <? if($aux == 2){echo "class='active'"; }?>><a href="<?php echo base_url()?>index.php/maquinariapesada/validados/<?php echo $identidad;?>"  >Maquinaria Pesada Validada</a></li>
     <li <? if($aux == 3){echo "class='active'"; }?>><a href="<?php echo base_url()?>index.php/maquinariapesada/totalmaqp/<?php echo $identidad;?>"  >Total Maquinaria Pesada</a></li>
</ul>


<div class="row">

        <div class="col-lg-12">


                          <h3 class="label label-info" style="font-size: 1.15em; display: block;"><?echo $title?></h3>
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
                                    <th width="20">Chasis</th> 
                                    <th width="20">Motor</th>
                                    <th width="20">Color</th>
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

<button name='btnValidarInmueble' class='btn btn-primary anchoBotones' onclick='abrirDialogValidacionMaquinariaPesada(<?= $fila->id?>)'>Validar  Doc.</button>


                                                <?php if($fila->documentos == ''){
                                                    ?>
                                                    <button name='btnSinDocumentacion' class='btn btn-danger anchoBotones' onclick='validarSinDocumentacion(<?= $fila->id?>,6)'>Sin Doc</button>
                                                    <?php
                                                     } ?> 
                                            </td>
                                           <td width="20"><?= $fila->idbien?></td>
                                            <td width="20"><?= $fila->descripcion?></td>
                                            <td width="20"><?= $fila->tipobien?></td>
                                            <td width="20"><?= $fila->marca?></td>
                                            <td width="20"><?= $fila->modelo?></td> 
                                        <td width="20"><?= $fila->nrochasis ?></td>
                                        <td width="20"><?= $fila->nromotor ?></td>
                                        <td width="20"><?= $fila->color ?></td>
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


<div id = "ModalMaquinariaPesadaValidar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
                    <input type="text" id="txtMensajeCabeceraMP" name="txtMensajeCabeceraMP" class="input form-control input-sm" >
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
                     
                            <button name='btnAdicionDocumentoValidarInmueble' class='btn btn-success anchoBotones' onclick='adicionarDocDialogValidacion(6)'>+ Documento</button>
                       <?php
                       } 
                    ?>
                    
                </div>
            </div>

           <table id="tablaDocumentacionMaquinariaPesada" class="table table-striped table-bordered" cellspacing="0" width="100%">
            </table>




             <form id="formularioValidacionMaquinariaPesada">
                <input type="hidden" id="txtIdDocumentoMaquinariaPesada" name="txtIdDocumentoMaquinariaPesada">
                <input type="hidden" id="txtTipoDocumentoMaquinariaPesada" name="txtTipoDocumentoMaquinariaPesada">
                <input type="hidden" id="txtIdValidacionMaquinariaPesada" name="txtIdValidacionMaquinariaPesada">
                <input type="hidden" id="txtIdBienMaquinariaPesada" name="txtIdBienMaquinariaPesada">
                <input type="hidden" id="txtIdBMP" name="txtIdBMP">
                <input type="hidden" id="accionMP" name="accionMP">
                <input type="hidden" id="txtListaObservacionesMaquinariaPesada" name="txtListaObservacionesMaquinariaPesada">
                <div id="divCondicionesValidacionMaquinariaPesada" class="row" style="display: none;">
                        <div class="col-xs-4">
                            <span class="help-block">¿Adjunta?</span>
                            <select id="cbAdjuntaMaquinariaPesada" class="form-control input-sm" name="cbAdjuntaMaquinariaPesada" >
                                <option value="-1">Seleccione</option>
                                <option value="t">Si</option>
                                <option value="f">No</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <span class="help-block">¿Corresponde al Bien?</span>
                            <select id="cbCorrespondeMaquinariaPesada" class="form-control input-sm" name="cbCorrespondeMaquinariaPesada" >
                                <option value="-1">Seleccione</option>
                                <option value="0">Si</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <span class="help-block">¿Legible?</span>
                            <select id="cbLegibleMaquinariaPesada" class="form-control input-sm" name="cbLegibleMaquinariaPesada" >
                                <option value="-1">Seleccione</option>
                                <option value="t">Si</option>
                                <option value="f">No</option>
                            </select>
                        </div>
                        <div class="col-xs-3" style="display:none">
                            <span class="help-block">Estado Documentación</span>
                            <select id="cbEstadoDocumentacionMaquinariaPesada" class="form-control input-sm" name="cbEstadoDocumentacionMaquinariaPesada">
                                <option value="-1">Seleccione</option>
                                <option value="1">Definitiva</option>
                                <option value="2">Provisional</option>
                                <option value="3">Preventivo</option>
                            </select>
                        </div>
                </div>
                <div id="divDatosValidacionDocProvisionalMP" class="row" style="display: none;">
                    <div class="col-xs-4">
                          <div class="row">
                            <div class="col-xs-12">
                                <span class="help-block">Nro Documento</span>
                                <input type="text" value=""  id="txtNroDocumentoMPProv" class="input form-control input-sm" name="txtNroDocumentoMPProv" readonly="true" tabindex="-1">
                            </div>
                          </div>
                    </div>
                    <div class="col-xs-4">
                          <div class="row">
                             <span class="help-block">Opcion Validación</span>
                              <select id="cbNroDocumentoOpcionMPProv" class="form-control input-sm" name="cbNroDocumentoOpcionMPProv" position="1">
                               
                              </select>
                          </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="row">
                          <div class="col-xs-12">
                                <!--<span class="help-block">Nro Documento observado</span>-->
                                <input type="hidden" value=""  id="txtNroDocumentoMPObservadoProv" class="input form-control input-sm" name="txtNroDocumentoMPObservadoProv" readonly="true" position="2">
                          </div>
                        </div>
                    </div>

              </div>
                <div id="divDatosValidacionMaquinariaPesada" class="row" style="display: none;">
                        <div class="col-xs-4">
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro Documento</span>
                                    <input type="text" value=""  id="txtNroDocumentoMaquinariaPesada" class="input form-control input-sm" name="txtNroDocumentoMaquinariaPesada" tabindex="-1">
                                </div>
                            </div>
                            <!--2018
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Equipo</span>
                                    <input type="text" value=""  id="txtEquipoMaquinariaPesada" class="input form-control input-sm" name="txtEquipoMaquinariaPesada" tabindex="-1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Marca</span>
                                    <input type="text" value=""  id="txtMarcaMaquinariaPesada" class="input form-control input-sm" name="txtMarcaMaquinariaPesada" tabindex="-1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Modelo</span>
                                    <input type="text" value=""  id="txtModeloMaquinariaPesada" class="input form-control input-sm" name="txtModeloMaquinariaPesada" tabindex="-1">
                                </div>
                            </div>
                            -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro. Chasis</span>
                                    <input type="text" value=""  id="txtChasisMaquinariaPesada" class="input form-control input-sm" name="txtChasisMaquinariaPesada" tabindex="-1">
                                </div>
                            </div>
                            <!--2018
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro. Motor</span>
                                    <input type="text" value=""  id="txtMotorMaquinariaPesada" class="input form-control input-sm" name="txtMotorMaquinariaPesada" tabindex="-1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Color</span>
                                    <input type="text" value=""  id="txtColorMaquinariaPesada" class="input form-control input-sm" name="txtColorMaquinariaPesada" tabindex="-1">
                                </div>
                            </div>
                            -->
                        </div>
                        <div class="col-xs-4">
                            <div class="row">
                               <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbNroDocumentoMaquinariaPesadaOpcion" class="form-control input-sm" name="cbNroDocumentoMaquinariaPesadaOpcion" position="1">
                                       
                                    </select>
                                </div>
                            </div>
                            <!--
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbEquipoMaquinariaPesadaOpcion" class="form-control input-sm" name="cbEquipoMaquinariaPesadaOpcion" position="3">
                                    
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbMarcaMaquinariaPesadaOpcion" class="form-control input-sm" name="cbMarcaMaquinariaPesadaOpcion" position="5">
                                      
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbModeloMaquinariaPesadaOpcion" class="form-control input-sm" name="cbModeloMaquinariaPesadaOpcion" position="7">
                                    
                                    </select>
                                </div>
                            </div>
                            -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbChasisMaquinariaPesadaOpcion" class="form-control input-sm" name="cbChasisMaquinariaPesadaOpcion" position="9">
                                      
                                    </select>
                                </div>
                            </div>
                            <!--
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbMotorMaquinariaPesadaOpcion" class="form-control input-sm" name="cbMotorMaquinariaPesadaOpcion" position="11">
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbColorMaquinariaPesadaOpcion" class="form-control input-sm" name="cbColorMaquinariaPesadaOpcion" position="13">
                                       
                                    </select>
                                </div>
                            </div>
                            -->
                        </div>
                        <div class="col-xs-4">
                            <div class="row">
                                <div class="col-xs-12">
                                    <!--<span class="help-block">Nro Documento observado</span>-->
                                    <input type="hidden" value=""  id="txtNroDocumentoMaquinariaPesadaObservado" class="input form-control input-sm" name="txtNroDocumentoMaquinariaPesadaObservado" readonly="true" position="2">
                                </div>
                            </div>
                            <!--
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Equipo observada</span>
                                    <input type="text" value=""  id="txtEquipoMaquinariaPesadaObservado" class="input form-control input-sm" name="txtEquipoMaquinariaPesadaObservado" readonly="true" position="4">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Marca observada</span>
                                    <input type="text" value=""  id="txtMarcaMaquinariaPesadaObservado" class="input form-control input-sm" name="txtMarcaMaquinariaPesadaObservado" readonly="true" position="6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Modelo observado</span>
                                    <input type="text" value=""  id="txtModeloMaquinariaPesadaObservado" class="input form-control input-sm" name="txtModeloMaquinariaPesadaObservado" readonly="true" position="8">
                                </div>
                            </div>
                            -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <!--<span class="help-block">Nro. Chasis observado</span>-->
                                    <input type="hidden" value=""  id="txtChasisMaquinariaPesadaObservado" class="input form-control input-sm" name="txtChasisMaquinariaPesadaObservado" readonly="true" position="10">
                                </div>
                            </div>
                            <!--
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro. Motor observado</span>
                                    <input type="text" value=""  id="txtMotorMaquinariaPesadaObservado" class="input form-control input-sm" name="txtMotorMaquinariaPesadaObservado" readonly="true" position="12">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Color observado</span>
                                    <input type="text" value=""  id="txtColorMaquinariaPesadaObservado" class="input form-control input-sm" name="txtColorMaquinariaPesadaObservado" readonly="true" position="14">
                                </div>
                            </div>
                            -->
                        </div>
                </div>
                <div id="divObservacionesMaquinariaPesada" style="display: none;">
                    <div class="row">
                        <div class="col-xs-12">
                            <span class="help-block">Posibles observaciones</span>
                            <select id="cbObservacionesMaquinariaPesada" class="form-control input-sm selectpicker" multiple="multiple" name="cbObservacionesMaquinariaPesada">
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <span class="help-block">Otras observaciones</span>
                            <textarea id="txtObservacionesMaquinariaPesada" class="form-control" rows="3" name="txtObservacionesMaquinariaPesada" ></textarea>
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
                    <button id="btnGuardarValidacionMP" type="button" class="btn btn-primary" disabled="disabled" >Guardar</button>
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
     VerificarSeleccionMaquinariaPesada();
      mostrarDatosValidacionMaquinariaPesada();

     eventosCombosValidacionMaquinariaPesada();
     botonesDialogoValidacionMaquinariaPesada();
      comboMultiSelectMaquinariaPesada();
       $("#divAnadirDocumentoValidar").on('hidden.bs.modal', function () {
            //alert('asdfgadsf');
            $("body").addClass("modal-open");
          });
       $("#divAnadirPersonasDoc").on('hidden.bs.modal', function () {
            //alert('asdfgadsf');
            $("body").addClass("modal-open");
          });
      //eventosCombosValidacionMaquinaria();
      //botonesDialogoValidacion();

    // verificarSeleccion();
    // eventosCombosValidacionVehiculo();
    // botonesDialogoVehiculoValidacion();

     //habilitaObservaciones();

    });
</script>
