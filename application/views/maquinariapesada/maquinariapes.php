<script type="text/javascript" src="<?php echo  base_url() ?>jsd/maquinariapesada.js"></script>
<br>
<ul class="nav nav-tabs">

    <li ><a href="<?php echo base_url()?>index.php/inmuebles/validar/<?php echo $identidad;?>" >Inmuebles</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculos/validarveh/<?php echo $identidad;?>"  >Vehículos</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinaria/validarmaq/<?php echo $identidad;?>"  >Maquinaria</a></li>
    <li class="active"><a href="<?php echo base_url()?>index.php/maquinariapesada/validar/<?php echo $identidad;?>"  >Maquinaria Pesada</a></li>
    <li ><a href="<?php echo base_url()?>index.php/inmueblesalquiler/validar/<?php echo $identidad;?>"  >Inmuebles Alquiler</a></li>
   <li ><a href="<?php echo base_url()?>index.php/vehiculosalquiler/validar/<?php echo $identidad;?>"  >Vehículos Alquiler</a></li>
</ul>


<ul class="nav nav-tabs">
   <li  ><a href="<?php echo base_url()?>index.php/maquinariapesada/validar/<?php echo $identidad;?>" >Maquinaria Pesada a Validar</a></li>
    <li class="active"><a href="<?php echo base_url()?>index.php/maquinariapesada/validados/<?php echo $identidad;?>"  >Maquinaria Pesada Validada</a></li>
</ul>


<div class="row">

        <div class="col-lg-12">


                          <h3 class="label label-info" style="font-size: 1.15em; display: block;">Maquinaria Pesada a Validar</h3>

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

                                        <tr class="odd gradeX">

                                            <td width="20">

<button name='btnValidarInmueble' class='btn btn-primary anchoBotones' onclick='abrirDialogValidacionMaquinariaPesada(<?= $fila->idbien?>)'>Validar  Doc.</button>
<button name='btnAdicionDocumentoValidarInmueble' class='btn btn-success anchoBotones' onclick='adicionarDocDialogValidacion(<?= $fila->idbien?>,6)'>+ Documento</button>
<button name='btnAdicionarPersona' class='btn btn-warning anchoBotones' onclick='adicionarDialogNuevaPersona(<?= $fila->idbien?>,6)'>+ Persona</button>
                                                <?php if($fila->documentos == ''){
                                                    ?>
                                                    <button name='btnSinDocumentacion' class='btn btn-danger anchoBotones' onclick='validarSinDocumentacion(<?= $fila->idbien?>,6)'>Sin Doc</button>
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
                    <input type="text" id="txtMensajeCabeceraMP" name="txtMensajeCabeceraMP" class="input form-control input-sm" position="1">
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
            <legend>Documentos presentados por la entidad</legend>

           <table id="tablaDocumentacionMaquinariaPesada" class="table table-striped table-bordered" cellspacing="0" width="100%">
            </table>




             <form id="formularioValidacionMaquinariaPesada">
                <input type="hidden" id="txtIdDocumentoMaquinariaPesada" name="txtIdDocumentoMaquinariaPesada">
                <input type="hidden" id="txtTipoDocumentoMaquinariaPesada" name="txtTipoDocumentoMaquinariaPesada">
                <input type="hidden" id="txtIdValidacionMaquinariaPesada" name="txtIdValidacionMaquinariaPesada">
                <input type="hidden" id="txtIdBienMaquinariaPesada" name="txtIdBienMaquinariaPesada">
                <input type="hidden" id="accionMP" name="accionMP">
                <input type="hidden" id="txtListaObservacionesMaquinariaPesada" name="txtListaObservacionesMaquinariaPesada">
                <div id="divCondicionesValidacionMaquinariaPesada" class="row" style="display: none;">
                        <div class="col-xs-4">
                            <span class="help-block">¿Adjunta?</span>
                            <select id="cbAdjuntaMaquinariaPesada" class="form-control input-sm" name="cbAdjuntaMaquinariaPesada" position="2">
                                <option value="-1">Seleccione</option>
                                <option value="t">Si</option>
                                <option value="f">No</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <span class="help-block">¿Corresponde al Bien?</span>
                            <select id="cbCorrespondeMaquinariaPesada" class="form-control input-sm" name="cbCorrespondeMaquinariaPesada" position="3">
                                <option value="-1">Seleccione</option>
                                <option value="0">Si</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <span class="help-block">¿Legible?</span>
                            <select id="cbLegibleMaquinariaPesada" class="form-control input-sm" name="cbLegibleMaquinariaPesada" position="4">
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
                                <input type="text" value=""  id="txtNroDocumentoMPProv" class="input form-control input-sm" name="txtNroDocumentoMPProv" readonly="true">
                            </div>
                          </div>
                    </div>
                    <div class="col-xs-4">
                          <div class="row">
                             <span class="help-block">Opcion Validación</span>
                              <select id="cbNroDocumentoOpcionMPProv" class="form-control input-sm" name="cbNroDocumentoOpcionMPProv" position="5">
                                <option value="-1">Seleccione opción</option>
                                <option value="t">Correcto</option>
                                <option value="f">Incorrecto</option>
                              </select>
                          </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="row">
                          <div class="col-xs-12">
                                <span class="help-block">Nro Documento observado</span>
                                <input type="text" value=""  id="txtNroDocumentoMPObservadoProv" class="input form-control input-sm" name="txtNroDocumentoMPObservadoProv" readonly="true" position="6">
                          </div>
                        </div>
                    </div>

              </div>
                <div id="divDatosValidacionMaquinariaPesada" class="row" style="display: none;">
                        <div class="col-xs-4">
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro Documento</span>
                                    <input type="text" value=""  id="txtNroDocumentoMaquinariaPesada" class="input form-control input-sm" name="txtNroDocumentoMaquinariaPesada">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Equipo</span>
                                    <input type="text" value=""  id="txtEquipoMaquinariaPesada" class="input form-control input-sm" name="txtEquipoMaquinariaPesada">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Marca</span>
                                    <input type="text" value=""  id="txtMarcaMaquinariaPesada" class="input form-control input-sm" name="txtMarcaMaquinariaPesada">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Modelo</span>
                                    <input type="text" value=""  id="txtModeloMaquinariaPesada" class="input form-control input-sm" name="txtModeloMaquinariaPesada">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro. Chasis</span>
                                    <input type="text" value=""  id="txtChasisMaquinariaPesada" class="input form-control input-sm" name="txtChasisMaquinariaPesada">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro. Motor</span>
                                    <input type="text" value=""  id="txtMotorMaquinariaPesada" class="input form-control input-sm" name="txtMotorMaquinariaPesada">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Color</span>
                                    <input type="text" value=""  id="txtColorMaquinariaPesada" class="input form-control input-sm" name="txtColorMaquinariaPesada">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="row">
                               <div class="col-xs-12">
                                    <span class="help-block">Opcion Validacións</span>
                                    <select id="cbNroDocumentoMaquinariaPesadaOpcion" class="form-control input-sm" name="cbNroDocumentoMaquinariaPesadaOpcion" position="5">
                                        <option value="-1">Seleccione</option>
                                        <option value="t">Correcto</option>
                                        <option value="f">Incorrecto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbEquipoMaquinariaPesadaOpcion" class="form-control input-sm" name="cbEquipoMaquinariaPesadaOpcion" position="7">
                                        <option value="-1">Seleccione</option>
                                        <option value="t">Correcto</option>
                                        <option value="f">Incorrecto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbMarcaMaquinariaPesadaOpcion" class="form-control input-sm" name="cbMarcaMaquinariaPesadaOpcion" position="9">
                                        <option value="-1">Seleccione</option>
                                        <option value="t">Correcto</option>
                                        <option value="f">Incorrecto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbModeloMaquinariaPesadaOpcion" class="form-control input-sm" name="cbModeloMaquinariaPesadaOpcion" position="11">
                                        <option value="-1">Seleccione</option>
                                        <option value="t">Correcto</option>
                                        <option value="f">Incorrecto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbChasisMaquinariaPesadaOpcion" class="form-control input-sm" name="cbChasisMaquinariaPesadaOpcion" position="13">
                                        <option value="-1">Seleccione</option>
                                        <option value="t">Correcto</option>
                                        <option value="f">Incorrecto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbMotorMaquinariaPesadaOpcion" class="form-control input-sm" name="cbMotorMaquinariaPesadaOpcion" position="15">
                                        <option value="-1">Seleccione</option>
                                        <option value="t">Correcto</option>
                                        <option value="f">Incorrecto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Opcion Validación</span>
                                    <select id="cbColorMaquinariaPesadaOpcion" class="form-control input-sm" name="cbColorMaquinariaPesadaOpcion" position="17">
                                        <option value="-1">Seleccione</option>
                                        <option value="t">Correcto</option>
                                        <option value="f">Incorrecto</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro Documento observado</span>
                                    <input type="text" value=""  id="txtNroDocumentoMaquinariaPesadaObservado" class="input form-control input-sm" name="txtNroDocumentoMaquinariaPesadaObservado" readonly="true" position="6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Equipo observada</span>
                                    <input type="text" value=""  id="txtEquipoMaquinariaPesadaObservado" class="input form-control input-sm" name="txtEquipoMaquinariaPesadaObservado" readonly="true" position="8">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Marca observada</span>
                                    <input type="text" value=""  id="txtMarcaMaquinariaPesadaObservado" class="input form-control input-sm" name="txtMarcaMaquinariaPesadaObservado" readonly="true" position="10">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Modelo observado</span>
                                    <input type="text" value=""  id="txtModeloMaquinariaPesadaObservado" class="input form-control input-sm" name="txtModeloMaquinariaPesadaObservado" readonly="true" position="12">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro. Chasis observado</span>
                                    <input type="text" value=""  id="txtChasisMaquinariaPesadaObservado" class="input form-control input-sm" name="txtChasisMaquinariaPesadaObservado" readonly="true" position="14">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Nro. Motor observado</span>
                                    <input type="text" value=""  id="txtMotorMaquinariaPesadaObservado" class="input form-control input-sm" name="txtMotorMaquinariaPesadaObservado" readonly="true" position="16">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="help-block">Color observado</span>
                                    <input type="text" value=""  id="txtColorMaquinariaPesadaObservado" class="input form-control input-sm" name="txtColorMaquinariaPesadaObservado" readonly="true" position="18">
                                </div>
                            </div>
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
                            <textarea id="txtObservacionesMaquinariaPesada" class="form-control" rows="3" name="txtObservacionesMaquinariaPesada" position="19"></textarea>
                        </div>
                    </div>
                </div>
                </form>


                  </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal" position="20">Cerrar</button>
          <button id="btnGuardarValidacionMP" type="button" class="btn btn-primary" disabled="disabled" position="21">Guardar</button>
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
     VerificarSeleccionMaquinariaPesada();
      mostrarDatosValidacionMaquinariaPesada();

     eventosCombosValidacionMaquinariaPesada();
     botonesDialogoValidacionMaquinariaPesada();
      comboMultiSelectMaquinariaPesada();
      //eventosCombosValidacionMaquinaria();
      //botonesDialogoValidacion();

    // verificarSeleccion();
    // eventosCombosValidacionVehiculo();
    // botonesDialogoVehiculoValidacion();

     //habilitaObservaciones();

    });
</script>
