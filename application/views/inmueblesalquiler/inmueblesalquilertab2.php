<script type="text/javascript" src="<?php echo  base_url() ?>jsd/inmueblesalquiler.js"></script>




<ul class="nav nav-tabs">
    <li ><a href="<?php echo base_url()?>index.php/inmuebles/validar/<?php echo $identidad;?>" >Inmuebles</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculos/validarveh/<?php echo $identidad;?>"  >Vehículos</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinaria/validarmaq/<?php echo $identidad;?>"  >Maquinarias</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinariapesada/validar/<?php echo $identidad;?>"  >Maquinaria Pesada</a></li>
    <li class="active"><a href="<?php echo base_url()?>index.php/inmueblesalquiler/validar/<?php echo $identidad;?>"  >Inmuebles Alquiler</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculosalquiler/validar/<?php echo $identidad;?>"  >Vehículos Alquiler</a></li>
</ul>



<ul class="nav nav-tabs">
    <li ><a href="<?php echo base_url()?>index.php/inmueblesalquiler/validar/<?php echo $identidad;?>" >Lista de Inmuebles Alquiler a Validar</a></li>
    <li class="active"><a href="<?php echo base_url()?>index.php/inmueblesalquiler/validados/<?php echo $identidad;?>"  >Lista de Inmuebles Alquiler Validados</a></li>
</ul>


<div class="row">
        <div class="col-lg-12">
                    <div class="panel panel-default">

                          <h3 class="label label-info" style="font-size: 1.15em; display: block;">Listado de Inmuebles Alquiler Validados</h3>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                   <thead>

                  									<th width="20">Opciones</th>
                  									<th width="20">Idbien</th>
                  									<th width="20">Dirección o ubicación</th>
                  									<th width="20">Departamento</th>
                  									<th width="20">Denominación</th>
                                    <th width="20">Tipo de Bien</th>
                                    <th width="20">Canon Alquiler</th>
                                    <th width="20">Inicio Contrato</th>
									                  <th width="20">Fin contrato</th>
                                    <th width="20">Documentos</th>
            									 </thead>
            									<tbody>
            									 <? $cont = 1?>
                                            <? foreach($filas as $fila):?>

                                        <tr class="odd gradeX">

                                            <td width="20">



                                                <button name='btnValidarInmueble' class='btn btn-primary anchoBotones' onclick='abrirDialogValidacionIA(<?= $fila->idbien?>)'>Validar  Doc..</button>
                                                <button name='btnAdicionDocumentoValidarInmueble' class='btn btn-success anchoBotones' onclick='adicionarDocDialogValidacion(<?= $fila->idbien?>,5)'>+ Documentos</button>
                                                <button name='btnAdicionarPersona' class='btn btn-warning anchoBotones' onclick='adicionarDialogNuevaPersona(<?= $fila->idbien?>,5)'>+ Persona</button>
                                                <?php if($fila->documentos == ''){
                                                    ?>
                                                    <button name='btnSinDocumentacion' class='btn btn-danger anchoBotones' onclick='validarSinDocumentacion(<?= $fila->idbien?>,5)'>Sin Doc</button>
                                                    <?php
                                                     } ?>
                                            </td>
                                            <td width="20"><?= $fila->idbien?></td>
                                            <td width="20"><?= $fila->direccion?></td>
                                            <td width="20"><?= $fila->departamento?></td>
                                            <td width="20"><?= $fila->denominacion?></td>
                                            <td width="20"><?= $fila->tipobien?></td>
                                            <td width="20"><?= $fila->canonalquiler?></td>
                                            <td width="20"><?= $fila->fechainicio?></td>
                                            <td width="20"><?= $fila->fechafin?></td>
                                            <td width="20"><?= $fila->documentos?></td>

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

<div id = "ModalInmuebleAlquilerValidar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
                    <input type="text" id="txtMensajeCabeceraIA" name="txtMensajeCabeceraIA" class="input form-control input-sm">
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

          <table id="tablaDocumentacionInmuebleAlquiler" class="table table-striped table-bordered" cellspacing="0" width="100%">
          </table>


         <form id="formularioValidacionInmuebleAlquiler">
              <input type="hidden" id="txtIdDocumentoIA" name="txtIdDocumentoIA">
              <input type="hidden" id="txtTipoDocumentoIA" name="txtTipoDocumentoIA">
              <input type="hidden" id="txtIdValidacionIA" name="txtIdValidacionIA">
              <input type="hidden" id="txtIdBienInmuebleAlquiler" name="txtIdBienInmuebleAlquiler">
              <input type="hidden" id="accionIA" name="accionIA">
              <input type="hidden" id="txtListaObservacionesIA" name="txtListaObservacionesIA">
              <div id="divCondicionesValidacionIA" class="row" style="display: none;">
                      <div class="col-xs-4">
                        <span class="help-block">Adjunta?</span>
                        <select id="cbAdjuntaInmuebleAlquiler" class="form-control input-sm" name="cbAdjuntaInmuebleAlquiler">
                            <option value="-1">Seleccione opción</option>
                            <option value="t">Si</option>
                            <option value="f">No</option>
                        </select>
                      </div>
                      <div class="col-xs-4">
                          <span class="help-block">Corresponde al Bien?</span>
                          <select id="cbCorrespondeInmuebleAlquiler" class="form-control input-sm" name="cbCorrespondeInmuebleAlquiler">
                                <option value="-1">Seleccione opción</option>
                                <option value="0">Si</option>
                                <option value="1">No</option>
                            </select>
                      </div>
                      <div class="col-xs-4">
                        <span class="help-block">Legible?</span>
                        <select id="cbLegibleInmuebleAlquiler" class="form-control input-sm" name="cbLegibleInmuebleAlquiler">
                            <option value="-1">Seleccione opción</option>
                            <option value="t">Si</option>
                            <option value="f">No</option>
                        </select>
                      </div>
                      <div class="col-xs-3" style="display:none">
                        <span class="help-block">Estado Documentación</span>
                            <select id="cbEstadoDocumentacionInmuebleAlquiler" class="form-control input-sm" name="cbEstadoDocumentacionInmuebleAlquiler">
                            <option value="-1">Seleccione opción</option>
                            <option value="1">Definitiva</option>
                            <option value="2">Provisional</option>
                            <option value="3">Preventivo</option>
                        </select>
                      </div>
              </div>
              <div id="divDatosValidacionDocProvisionalIA" class="row" style="display: none;">
                    <div class="col-xs-4">
                          <div class="row">
                            <div class="col-xs-12">
                                <span class="help-block">Nro Documento</span>
                                <input type="text" value=""  id="txtNroDocumentoIAProv" class="input form-control input-sm" name="txtNroDocumentoIAProv" readonly="true">
                            </div>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                             <span class="help-block">Opcion Validación</span>
                              <select id="cbNroDocumentoIAOpcionProv" class="form-control input-sm" name="cbNroDocumentoIAOpcionProv">
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
                                <input type="text" value=""  id="txtNroDocumentoIAObservadoProv" class="input form-control input-sm" name="txtNroDocumentoIAObservadoProv" readonly="true">
                            </div>
                          </div>
                      </div>

              </div>

              <div id="divDatosValidacionIA" class="row" style="display: none;">
                      <div class="col-xs-4">
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Nro Documento</span>
                                  <input type="text" value=""  id="txtNroDocumentoIA" class="input form-control input-sm" name="txtNroDocumentoIA" readonly="true">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Departamento</span>
                                  <input type="text" value=""  id="txtDepartamentoIA" class="input form-control input-sm" name="txtDepartamentoIA" readonly="true">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Dirección o Ubicación</span>
                                  <input type="text" value=""  id="txtDireccionIA" class="input form-control input-sm" name="txtDireccionIA" readonly="true">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Inicio Contrato</span>
                                  <input type="text" value=""  id="txtInicioContratoIA" class="input form-control input-sm" name="txtInicioContratoIA" readonly="true">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Conclusión Contrato</span>
                                  <input type="text" value=""  id="txtConclusionContratoIA" class="input form-control input-sm" name="txtConclusionContratoIA" readonly="true">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Canon Alquiler</span>
                                  <input type="text" value=""  id="txtCanonIA" class="input form-control input-sm" name="txtCanonIA" readonly="true">
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbNroDocumentoIAOpcion" class="form-control input-sm" name="cbNroDocumentoIAOpcion">
                                    <option value="-1">Seleccione opción</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbDepartamentoIAOpcion" class="form-control input-sm" name="cbDepartamentoIAOpcion">
                                    <option value="-1">Seleccione opción</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbDireccionIAOpcion" class="form-control input-sm" name="cbDireccionIAOpcion">
                                    <option value="-1">Seleccione opción</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbInicioContratoIAOpcion" class="form-control input-sm" name="cbInicioContratoIAOpcion">
                                    <option value="-1">Seleccione opción</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbConclusionContratoIAOpcion" class="form-control input-sm" name="cbConclusionContratoIAOpcion">
                                    <option value="-1">Seleccione opción</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbCanonIAOpcion" class="form-control input-sm" name="cbCanonIAOpcion">
                                    <option value="-1">Seleccione opción</option>
                                    <option value="t">Correcto</option>
                                    <option value="f">Incorrecto</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                              <div class="col-xs-12" >
                                  <span class="help-block">Nro Documento observado</span>
                                  <input type="text" value=""  id="txtNroDocumentoIAObservado" class="input form-control input-sm" name="txtNroDocumentoIAObservado" readonly="true">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Departamento</span>
                                  <input type="text" value=""  id="txtDepartamentoIAObservado" class="input form-control input-sm" name="txtDepartamentoIAObservado" readonly="true">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Dirección o Ubicación observada</span>
                                  <input type="text" value=""  id="txtDireccionIAObservado" class="input form-control input-sm" name="txtDireccionIAObservado" readonly="true">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Inicio contrato observado</span>
                                  <input type="text" value=""  id="txtInicioContratoIAObservado" class="input form-control input-sm" name="txtInicioContratoIAObservado" readonly="true">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Conclusión contrato observado</span>
                                  <input type="text" value=""  id="txtConclusionContratoIAObservado" class="input form-control input-sm" name="txtConclusionContratoIAObservado" readonly="true">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Canon alquiler observado</span>
                                  <input type="text" value=""  id="txtCanonIAObservado" class="input form-control input-sm" name="txtCanonIAObservado" readonly="true">
                              </div>
                          </div>
                      </div>
              </div>
              <div id="divObservacionesIA" style="display: none;">
                <div class="row">
                    <div class="col-xs-12">
                        <span class="help-block">Posibles observaciones</span>
                        <select id="cbObservacionesInmueblesAlquiler" class="form-control input-sm selectpicker" multiple="multiple" name="cbObservacionesInmueblesAlquiler" style='width:300px'>


                        </select>
                    </div>
                    <div class="col-xs-12">
                        <span class="help-block">Otras observaciones</span>
                        <textarea id="txtObservacionesInmueblesAlquiler" class="form-control" rows="3" name="txtObservacionesInmueblesAlquiler"></textarea>
                    </div>
                </div>
               </div>
              </form>
      </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button id="btnGuardarValidacionInmuebleAlquiler" type="button" class="btn btn-primary" disabled="disabled">Guardar</button>
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
        //cargaTablaInmuebles();
          // pestanaValidados();
          comboMultiSelectIA();
           //marcarFilaTablaDocumentacion();
          VerificarSeleccionIA();
          eventosCombosValidacionIA();
          botonesDialogoValidacionIA();
           $("#divAnadirDocumentoValidar").on('hidden.bs.modal', function () {
            //alert('asdfgadsf');
            $("body").addClass("modal-open");
          });
           $("#divAnadirPersonasDoc").on('hidden.bs.modal', function () {
            //alert('asdfgadsf');
            $("body").addClass("modal-open");
          });
    });
</script>
