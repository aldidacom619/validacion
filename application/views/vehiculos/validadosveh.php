<script type="text/javascript" src="<?php echo  base_url() ?>jsd/vehiculos.js"></script>
<br>
<ul class="nav nav-tabs">

   <li ><a href="<?php echo base_url()?>index.php/inmuebles/validar/<?php echo $identidad;?>" >Inmuebles</a></li>

    <li class="active"><a href="<?php echo base_url()?>index.php/vehiculos/validarveh/<?php echo $identidad;?>"  >Vehículos</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinaria/validarmaq/<?php echo $identidad;?>"  >Maquinaria</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinariapesada/validar/<?php echo $identidad;?>"  >Maquinaria Pesada</a></li>
    <li ><a href="<?php echo base_url()?>index.php/inmueblesalquiler/validar/<?php echo $identidad;?>"  >Inmuebles Alquiler</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculosalquiler/validar/<?php echo $identidad;?>"  >Vehículos Alquiler</a></li>
</ul>


<ul class="nav nav-tabs">
    <li><a href="<?php echo base_url()?>index.php/vehiculos/validarveh/<?php echo $identidad;?>" >Lista de Vehículos a Validar</a></li>
    <li class="active"><a href="<?php echo base_url()?>index.php/vehiculos/validadosveh/<?php echo $identidad;?>"  >Lista de Vehículos Validados</a></li>
</ul>


<div class="row">
        <div class="col-lg-12">

                          <h3 class="label label-info" style="font-size: 1.15em; display: block;">Vehículos Validados</h3>


                     <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                   <thead>

                                    <th width="20">Opciones</th>
                                    <th width="20">IdBien</th>
                                    <th width="20">Tipo de Vehículo</th>
                                    <th width="20">Clase</th>
                                    <th width="20">Marca</th>
                                    <th width="20">Placa</th>
                                    <th width="20">Nro. Chasis</th>
                                    <th width="20">Nro. Motor</th>
                                    <th width="20">Documentos</th>
                                    <th width="10">Estado</th>
                   </thead>
                  <tbody>
                   <? $cont = 1?>
                                            <? foreach($filas as $fila):?>

                                        <tr class="odd gradeX">

                                            <td width="20">




                                                <button name='btnValidarInmueble' class='btn btn-primary anchoBotones' onclick='abrirDialogValidacionVehiculo(<?= $fila->idbien?>)'>Validar  Doc.</button>
                                                <button name='btnAdicionDocumentoValidarInmueble' class='btn btn-success anchoBotones' onclick='adicionarDocDialogValidacion(<?= $fila->idbien?>,3)'>+ Documento</button>
                                                <button name='btnAdicionarPersona' class='btn btn-warning anchoBotones' onclick='adicionarDialogNuevaPersona(<?= $fila->idbien?>,3)'>+ Persona</button>
                                                <?php if($fila->documentos == ''){
                                                    ?>
                                                    <button name='btnSinDocumentacion' class='btn btn-danger anchoBotones' onclick='validarSinDocumentacion(<?= $fila->idbien?>,3)'>Sin Doc</button>
                                                    <?php
                                                     } ?>
                                            </td>
                                            <td width="20"><?= $fila->idbien?></td>
                                            <td width="20"><?= $fila->tipobien?></td>
                                            <td width="20"><?= $fila->clase?></td>
                                            <td width="20"><?= $fila->marca?></td>
                                            <td width="20"><?= $fila->placa?></td>
                                            <td width="20"><?= $fila->nrochasis ?></td>
                                            <td width="20"><?= $fila->nromotor?></td>
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


<div id = "largemodalv" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
                    <input type="text" id="txtMensajeCabeceraVe" name="txtMensajeCabeceraVe" class="input form-control input-sm" position="1">
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

          <table id="tablaDocumentacionVehiculo" class="table table-striped table-bordered" cellspacing="0" width="100%">
          </table>


         <form id="formularioVehiculo">

              <input type="hidden" id="txtIdDocumentoVehiculo" name="txtIdDocumentoVehiculo" value="">
              <input type="hidden" id="txtTipoDocumentoVehiculo" name="txtTipoDocumentoVehiculo" value="">
              <input type="hidden" id="txtIdValidacionVehiculo" name="txtIdValidacionVehiculo" value="">
              <input type="hidden" id="txtIdBienVehiculo" name="txtIdBienVehiculo" value="">
              <input type="hidden" id="accionVehiculo" name="accionVehiculo" value="">
              <input type="hidden" id="txtListaObservacionesVehiculo" name="txtListaObservacionesVehiculo" value="">

              <div id="divCondicionesValidacionVehiculo" class="row ocultaDiv" style="display: none;">

                      <div class="col-xs-4">
                        <span class="help-block">Adjunta?</span>
                        <select id="cbAdjuntaVehiculo" class="form-control input-sm linkResetCb" name="cbAdjuntaVehiculo" position="2">
                            <option value="-1">Seleccione</option>
                            <option value="t">Si</option>
                            <option value="f">No</option>
                        </select>
                      </div>
                      <div class="col-xs-4">
                          <span class="help-block">Corresponde al Bien?</span>
                            <select id="cbCorrespondeVehiculo" class="form-control input-sm linkResetCb" name="cbCorrespondeVehiculo" position="3">
                                <option value="-1">Seleccione</option>
                                <option value="1">Si</option>
                                <option value="2">No</option>
                            </select>
                      </div>
                      <div class="col-xs-4">
                        <span class="help-block">Legible?</span>
                        <select id="cbLegibleVehiculo" class="form-control input-sm linkResetCb" name="cbLegibleVehiculo" position="4">
                            <option value="-1">Seleccione</option>
                            <option value="t">Si</option>
                            <option value="f">No</option>
                        </select>
                      </div>
                      <div class="col-xs-3" style="display:none">
                        <span class="help-block">Estado Documentación</span>
                        <select id="cbEstadoDocumentacionVehiculo" class="form-control input-sm linkResetCb" name="cbEstadoDocumentacionVehiculo" readonly="readonly" >
                            <option value="-1">Seleccione</option>
                            <option value="1">Definitiva</option>
                            <option value="2">Provisional</option>
                            <option value="3">Preventivo</option>
                        </select>
                      </div>

              </div>

              <div id="divDatosValidacionDocVehiculoProvisional" class="row" style="display: none;">
                    <div class="col-xs-4">
                          <div class="row">
                            <div class="col-xs-12">
                                <span class="help-block">Nro Documento</span>
                                <input type="text" value=""  id="txtNroDocumentoVehiculoProv" class="input form-control input-sm" name="txtNroDocumentoVehiculoProv" readonly="true">
                            </div>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                             <span class="help-block">Opcion Validación</span>
                              <select id="cbNroDocumentoOpcionVehiculoProv" class="form-control input-sm" name="cbNroDocumentoOpcionVehiculoProv" position="5">
                                <option value="-1">Seleccione opción</option>
                                <option value="t">Correcto</option>
                                <option value="f">Incorrecto</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                            <div class="col-xs-12">
                                <span class="help-block">Nro Documento observados</span>
                                <input type="text" value=""  id="txtNroDocumentoVehiculoObservadoProv" class="input form-control input-sm" name="txtNroDocumentoVehiculoObservadoProv" readonly="true" position="6">
                            </div>
                          </div>
                      </div>

              </div>

              <div id="divDatosValidacionVehiculo" class="row ocultaDiv" style="display: none;">

                      <div class="col-xs-4">
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Nro Documento</span>
                                  <input type="text" value=""  id="txtNroDocumentoVehiculo" class="input form-control input-sm linkResetTxt" name="txtNroDocumentoVehiculo" readonly="readonly">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Tipo</span>
                                <input type="text" value=""  id="txtClase" class="input form-control input-sm linkResetTxt" name="txtClase" readonly="readonly">

                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Clase</span>
                  <input type="text" value=""  id="txtTipoVehiculo" class="input form-control input-sm linkResetTxt" name="txtTipoVehiculo" readonly="readonly">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Marca</span>
                                  <input type="text" value=""  id="txtMarca" class="input form-control input-sm linkResetTxt" name="txtMarca" readonly="readonly">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Placa</span>
                                  <input type="text" value=""  id="txtPlaca" class="input form-control input-sm linkResetTxt" name="txtPlaca" readonly="readonly">
                              </div>
                          </div>
                           <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Nº de Motor</span>
                                  <input type="text" value=""  id="txtNumeroMotor" class="input form-control input-sm linkResetTxt" name="txtNumeroMotor" readonly="readonly">
                              </div>
                          </div>
                           <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Nº de Chasis</span>
                                  <input type="text" value=""  id="txtNumeroChasis" class="input form-control input-sm linkResetTxt" name="txtNumeroChasis" readonly="readonly">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Procedencia</span>
                                  <input type="text" value=""  id="txtProcedencia" class="input form-control input-sm linkResetTxt" name="txtProcedencia" readonly="readonly">
                              </div>
                          </div>
                           <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Modelo</span>
                                  <input type="text" value=""  id="txtModelo" class="input form-control input-sm linkResetTxt" name="txtModelo" readonly="readonly">
                              </div>
                          </div>

                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbNroDocumentoVehiculoOpcion" class="form-control input-sm linkResetCb" name="cbNroDocumentoVehiculoOpcion" position="5">
                                    <option value="-1">Seleccione</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbClaseOpcion" class="form-control input-sm linkResetCb" name="cbClaseOpcion" position="7">
                                    <option value="-1">Seleccione</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                  <select id="cbTipoVehiculoOpcion" class="form-control input-sm linkResetCb" name="cbTipoVehiculoOpcion" position="9">
                                    <option value="-1">Seleccione</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>

                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbMarcaOpcion" class="form-control input-sm linkResetCb" name="cbMarcaOpcion" position="11">
                                    <option value="-1">Seleccione</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbPlacaOpcion" class="form-control input-sm linkResetCb" name="cbPlacaOpcion" position="13">
                                    <option value="-1">Seleccione</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbMotorOpcion" class="form-control input-sm linkResetCb" name="cbMotorOpcion" position="15">
                                    <option value="-1">Seleccione</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbChasisOpcion" class="form-control input-sm linkResetCb" name="cbChasisOpcion" position="17">
                                    <option value="-1">Seleccione</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbProcedenciaOpcion" class="form-control input-sm linkResetCb" name="cbProcedenciaOpcion" position="19">
                                    <option value="-1">Seleccione</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbModeloOpcion" class="form-control input-sm linkResetCb" name="cbModeloOpcion" position="21">
                                    <option value="-1">Seleccione</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                              <div class="col-xs-12" id="divDocumentoObservado">
                                  <span class="help-block">Nro Documento observado</span>
                                  <input type="text" value=""  id="txtNroDocumentoVehiculoObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtNroDocumentoVehiculoObservado" readonly="true" position="6">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divTipoVehiculoObservado">
                                  <span class="help-block">Tipo Observado</span>
                                  <input type="text" value=""  id="txtClaseVehiculoObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtClaseVehiculoObservado" readonly="true" position="8">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divClaseVehiculoObservado">
                                  <span class="help-block">Clase de Vehículo Observado</span>
                                  <input type="text" value=""  id="txtTipoVehiculoObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtTipoVehiculoObservado" readonly="true" position="10">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divMarcaVehiculoObservado">
                                  <span class="help-block">Marca observada</span>
                                  <input type="text" value=""  id="txtMarcaVehiculoObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtMarcaVehiculoObservado" readonly="true" position="12">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divPlacaVehiculoObservado">
                                  <span class="help-block">Placa observada</span>
                                  <input type="text" value=""  id="txtPlacaVehiculoObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtPlacaVehiculoObservado" readonly="true" position="14">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divNumeroMotorVehiculoObservado">
                                  <span class="help-block">Nº de Motor observado</span>
                                  <input type="text" value=""  id="txtNumeroMotorVehiculoObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtNumeroMotorVehiculoObservado" readonly="true" position="16">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divNumeroChasisVehiculoObservado">
                                  <span class="help-block">Nº de Chasis observado</span>
                                  <input type="text" value=""  id="txtNumeroChasisVehiculoObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtNumeroChasisVehiculoObservado" readonly="true" position="18">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divProcedenciaVehiculoObservado">
                                  <span class="help-block">Procedencia observada</span>
                                  <input type="text" value=""  id="txtProcedenciaVehiculoObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtProcedenciaVehiculoObservado" readonly="true" position="20">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divModeloVehiculoObservado">
                                  <span class="help-block">Modelo observado</span>
                                  <input type="text" value=""  id="txtModeloVehiculoObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtModeloVehiculoObservado" readonly="true" position="22">
                              </div>
                          </div>
                      </div>

              </div>
               <div id="divObservaciones" class="row ocultaDiv" style="display:none">
                  <div class="row">
                      <div class="col-xs-12">
                      <legend>Observaciones Generales</legend>
                        <span class="help-block">Observaciones Específicas</span>
                        <select id="cbObservacionEspecifica" name="cbObservacionEspecifica" class="form-control input-sm linkResetCb selectpicker" multiple="multiple">

                        </select>

                      </div>
                   </div>
                   <div class="row">
                        <div class="col-xs-12">
                            <span class="help-block">Observaciones Generales</span>
                            <textarea class="form-control input-sm" id="txtObservacionesGeneralesVehiculo" name="txtObservacionesGeneralesVehiculo" rows="4" cols="2" value="" position="23"></textarea>
                        </div>
                    </div>
               </div>
               <div id="agregarPersonaVehiculo" class="row ocultaDiv" style="display:none">
          <select id="tipoPersonaOpcionVehiculo">
                      <option value="-1">Seleccione Una Opción</option>
                        <option value="1">Persona Natural</option>
                        <option value="2">Entidad Pública</option>
                        <option value="3">Entidad Privada</option>
                    </select>
                    <div id="personaNaturalVehiculo" style="display:none">

                    </div>
                    <div id="entidadPúblicaVehiculo" style="display:none">

                    </div>
                    <div id="entidadPrivadaVehiculo" style="display:none">

                    </div>
               </div>
                </form>
      </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal" position="24">Cerrar</button>
          <button id="btnGuardarValidacionVehiculo" type="button" class="btn btn-primary" disabled="disabled" position="25">Guardar</button>
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
     //cargaTablaVehiculos();
     //cargaTablaVehiculosValidados();
     //OperacionesTablaVehiculo();
     //marcarFilaTablaDocumentacion();
     verificarSeleccion();
     eventosCombosValidacionVehiculo();
     botonesDialogoVehiculoValidacion();

     habilitaObservaciones();
     opcionMultiselect();


    });
</script>
