<script type="text/javascript" src="<?php echo  base_url() ?>jsd/vehiculosalquiler.js"></script>




<ul class="nav nav-tabs">
    <li ><a href="<?php echo base_url()?>index.php/inmuebles/validar/<?php echo $identidad;?>" >Inmuebles</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculos/validarveh/<?php echo $identidad;?>"  >Vehículos</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinaria/validarmaq/<?php echo $identidad;?>"  >Maquinaria y Equipos</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinariapesada/validar/<?php echo $identidad;?>"  >Maquinaria Pesada Móvil</a></li>
    <li ><a href="<?php echo base_url()?>index.php/inmueblesalquiler/validar/<?php echo $identidad;?>"  >Inmuebles Alquiler</a></li>
    <li class="active" ><a href="<?php echo base_url()?>index.php/vehiculosalquiler/validar/<?php echo $identidad;?>"  >Vehículos Alquiler</a></li>

</ul>



<ul class="nav nav-tabs">
    <li <? if($aux == 1){echo "class='active'"; }?>><a href="<?php echo base_url()?>index.php/vehiculosalquiler/validar/<?php echo $identidad;?>" >Lista de Vehículos Alquiler a Validar</a></li>
    <li <? if($aux == 2){echo "class='active'"; }?> ><a href="<?php echo base_url()?>index.php/vehiculosalquiler/validados/<?php echo $identidad;?>"  >Lista de Vehículos Alquiler Validados</a></li>
</ul> 


<div class="row">
        <div class="col-lg-12">
                    <div class=" panel-default">

                          <h3 class="label label-info" style="font-size: 1.15em; display: block;"><?echo $title?></h3>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                   <thead>

                  									<th width="20">Opciones</th>
                  									<th width="20">Idbien</th>
                  									<th width="20">Tipo de Vehículo</th>
                  									<th width="20">Modelo</th>
                  									<th width="20">Marca</th>
                                    <th width="20">Placa</th>
                                    <th width="20">Nro Chasis</th>
                                    <th width="20">Inicio Contrato</th>
									                  <th width="20">Fin contrato</th>
                                    <th width="20">Canon de Alquiler</th>
                                    <th width="20">Documentos</th>
            									 </thead>
            									<tbody>
            									 <? $cont = 1?>
                                            <? foreach($filas as $fila):?>

                                        <tr class="odd gradeX">

                                            <td width="20">



                                                <button name='btnValidarInmueble' class='btn btn-primary anchoBotones' onclick='abrirDialogValidacionVehiculoAlquiler(<?= $fila->id?>)'>Validar  Doc..</button>
                                               
                                              


                                                <?php if($fila->documentos == ''){
                                                    ?>
                                                    <button name='btnSinDocumentacion' class='btn btn-danger anchoBotones' onclick='validarSinDocumentacion(<?= $fila->id?>,7)'>Sin Doc</button>
                                                    <?php
                                                     } ?>
                                            </td>
                                            <td width="20"><?= $fila->idbien?></td>
                                            <td width="20"><?= $fila->tipobien?></td>
                                            <td width="20"><?= $fila->modelo?></td>
                                            <td width="20"><?= $fila->marca?></td>
                                            <td width="20"><?= $fila->placa?></td>
                                            <td width="20"><?= $fila->nrochasis?></td>
                                            <td width="20"><?= $fila->fechainicio?></td>
                                            <td width="20"><?= $fila->fechafin?></td>
                                            <td width="20"><?= $fila->canonalquiler?></td>
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



<div id = "divTablaDocumentoAlquiler" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
                    <input type="text" id="txtMensajeCabeceraVeAl" name="txtMensajeCabeceraVeAl" class="input form-control input-sm">
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
                     <button name='btnAdicionDocumentoValidarInmueble' class='btn btn-success anchoBotones' onclick='adicionarDocDialogValidacion(7)'>+ Documento</button> 
                       <?php
                       } 
                    ?>
                     
                </div>
            </div>

          <table id="tablaDocumentacionVehiculoAlquiler" class="table table-striped table-bordered" cellspacing="0" width="100%">
          </table>


         <form id="formularioVehiculoAlquiler">
              <input type="hidden" id="txtIdDocumentoVehiculoAlquiler" name="txtIdDocumentoVehiculoAlquiler" value="">
              <input type="hidden" id="txtTipoDocumentoVehiculoAlquiler" name="txtTipoDocumentoVehiculoAlquiler" value="">
              <input type="hidden" id="txtIdValidacionVA" name="txtIdValidacionVA" value="">
              <input type="hidden" id="txtIdBienVehiculoAlquiler" name="txtIdBienVehiculoAlquiler" value="">
              <input type="hidden" id="txtIdB" name="txtIdB" value="">
              <input type="hidden" id="accionVehiculoAlquiler" name="accionVehiculoAlquiler" value="">
              <input type="hidden" id="txtListaObservacionesVehiculoAlquiler" name="txtListaObservacionesVehiculoAlquiler" value="">
              <div id="divCondicionesValidacionVehiculoAlquiler" class="row ocultaDiv" style="display: none;">

                      <div class="col-xs-4">
                        <span class="help-block">Adjunta?</span>
                        <select id="cbAdjuntaVehiculoAlquiler" class="form-control input-sm linkResetCb" name="cbAdjuntaVehiculoAlquiler">
                            <option value="-1">Seleccione</option>
                            <option value="t">Si</option>
                            <option value="f">No</option>
                        </select>
                      </div>
                      <div class="col-xs-4">
                          <span class="help-block">Corresponde al Bien?</span>
                            <select id="cbCorrespondeVehiculoAlquiler" class="form-control input-sm linkResetCb" name="cbCorrespondeVehiculoAlquiler">
                                <option value="-1">Seleccione</option>
                                <option value="1">Si</option>
                                <option value="2">No</option>
                            </select>
                      </div>
                      <div class="col-xs-4">
                        <span class="help-block">Legible?</span>
                        <select id="cbLegibleVehiculoAlquiler" class="form-control input-sm linkResetCb" name="cbLegibleVehiculoAlquiler">
                            <option value="-1">Seleccione</option>
                            <option value="t">Si</option>
                            <option value="f">No</option>
                        </select>
                      </div>
                      <div class="col-xs-3" style="display:none">
                        <span class="help-block">Estado Documentación</span>
                        <select id="cbEstadoDocumentacionVehiculoAlquiler" class="form-control input-sm linkResetCb" name="cbEstadoDocumentacionVehiculoAlquiler" readonly="readonly" >
                            <option value="-1">Seleccione</option>
                            <option value="1">Definitiva</option>
                            <option value="2">Provisional</option>
                            <option value="3">Preventivo</option>
                        </select>
                      </div>

              </div>

              <div id="divDatosValidacionDocVehiculoAlquilerProvisional" class="row" style="display: none;">
                    <div class="col-xs-4">
                          <div class="row">
                            <div class="col-xs-12">
                                <span class="help-block">Nro Documento</span>
                                <input type="text" value=""  id="txtNroDocumentoVehiculoAlquilerProv" class="input form-control input-sm" name="txtNroDocumentoVehiculoAlquilerProv" readonly="true" tabindex="-1">
                            </div>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                             <span class="help-block">Opcion Validación</span>
                              <select id="cbNroDocumentoOpcionVehiculoAlquilerProv" class="form-control input-sm" name="cbNroDocumentoOpcionVehiculoAlquilerProv" position="1">
                                
                              </select>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                            <div class="col-xs-12">
                                <span class="help-block">Nro Documento observado</span>
                                <input type="text" value=""  id="txtNroDocumentoVehiculoAlquilerObservadoProv" class="input form-control input-sm" name="txtNroDocumentoVehiculoAlquilerObservadoProv" readonly="true" position="2">
                            </div>
                          </div>
                      </div>

              </div>

              <div id="divDatosValidacionVehiculoAlquiler" class="row ocultaDiv" style="display: none;">
                  <!--<div class="row">-->
                      <div class="col-xs-4">
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Nro Documento</span>
                                  <input type="text" value=""  id="txtNroDocumentoVehiculoAlquiler" class="input form-control input-sm linkResetTxt" name="txtNroDocumentoVehiculoAlquiler" readonly="readonly" tabindex="-1">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Ciudad</span>
                                  <input type="text" value=""  id="txtCiudadVehiculoAlquiler" class="input form-control input-sm linkResetTxt" name="txtCiudadVehiculoAlquiler" readonly="readonly" tabindex="-1">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Dirección Ubicación</span>
                                  <input type="text" value=""  id="txtDireccionVehiculoAlquiler" class="input form-control input-sm linkResetTxt" name="txtDireccionVehiculoAlquiler" readonly="readonly" tabindex="-1">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Inicio de Contrato</span>
                                  <input type="text" value=""  id="txtInicioContratoVehiculoAlquiler" class="input form-control input-sm linkResetTxt" name="txtInicioContratoVehiculoAlquiler" readonly="readonly" tabindex="-1">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Conclusión del Contrato</span>
                                  <input type="text" value=""  id="txtFinContratoVehiculoAlquiler" class="input form-control input-sm linkResetTxt" name="txtFinContratoVehiculoAlquiler" readonly="readonly" tabindex="-1">
                              </div>
                          </div>
                           <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Canon de Alquiler</span>
                                  <input type="text" value=""  id="txtCanonVehiculoAlquiler" class="input form-control input-sm linkResetTxt" name="CanonVehiculoAlquiler" readonly="readonly" tabindex="-1">
                              </div>
                          </div>
                      </div>
          <div class="col-xs-4">
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbNroDocumentoVehiculoAlquilerOpcion" class="form-control input-sm linkResetCb" name="cbNroDocumentoVehiculoAlquilerOpcion" position="1">
                                    
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbCiudadVehiculoAlquilerOpcion" class="form-control input-sm linkResetCb" name="cbCiudadVehiculoAlquilerOpcion" position="3">
                                   
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbDireccionVehiculoAlquilerOpcion" class="form-control input-sm linkResetCb" name="cbDireccionVehiculoAlquilerOpcion" position="5">
                                    
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbInicioContratoVehiculoAlquilerOpcion" class="form-control input-sm linkResetCb" name="cbInicioContratoVehiculoAlquilerOpcion" position="7">
                                   
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbFinContratoVehiculoAlquilerOpcion" class="form-control input-sm linkResetCb" name="cbFinContratoVehiculoAlquilerOpcion" position="9">
                                    
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12">
                                  <span class="help-block">Opcion Validación</span>
                                  <select id="cbCanonVehiculoAlquilerOpcion" class="form-control input-sm linkResetCb" name="cbCanonVehiculoAlquilerOpcion" position="11">
                                   
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <div class="row">
                              <div class="col-xs-12" id="divDocumentoObservado">
                                  <span class="help-block">Nro Documento observado</span>
                                  <input type="text" value=""  id="txtNroDocumentoVehiculoAlquilerObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtNroDocumentoVehiculoAlquilerObservado" readonly="true" position="2">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divCiudadVehiculoAlquilerObservado">
                                  <span class="help-block">Ciudad de Vehículo en Alquiler observado</span>
                                  <input type="text" value=""  id="txtCiudadVehiculoAlquilerObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtCiudadVehiculoAlquilerObservado" readonly="true" position="4">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divDireccionVehiculoAlquilerObservado">
                                  <span class="help-block">Dirección observada</span>
                                  <input type="text" value=""  id="txtDireccionVehiculoAlquilerObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtDireccionVehiculoAlquilerObservado" readonly="true" position="6">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divInicioContratoVehiculoAlquilerObservado">
                                  <span class="help-block">Inicio Contrato observado</span>
                                  <input type="text" value=""  id="txtInicioContratoVehiculoAlquilerObservado" class="input form-control input-sm linkResetTxt linkSoloLectura fecha" name="txtInicioContratoVehiculoAlquilerObservado" readonly="true" position="8">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divFinContratoVehiculoAlquilerObservado">
                                  <span class="help-block">Fin Contrato observado</span>
                                  <input type="text" value=""  id="txtFinContratoVehiculoAlquilerObservado" class="input form-control input-sm linkResetTxt linkSoloLectura fecha" name="txtFinContratoVehiculoAlquilerObservado" readonly="true" position="10">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12" id="divCanonVehiculoAlquilerObservado">
                                  <span class="help-block">Canon de Alquiler observado</span>
                                  <input type="text" value=""  id="txtCanonVehiculoAlquilerObservado" class="input form-control input-sm linkResetTxt linkSoloLectura" name="txtCanonVehiculoAlquilerObservado" readonly="true" position="12">
                              </div>
                          </div>
                      </div>
                  <!--</div>-->
              </div>
               <div id="divObservacionesVehiculoAlquiler" class="row ocultaDiv" style="display:none">
                  <div class="row">
                      <div class="col-xs-12">
                      <legend>Observaciones Generales</legend>
                        <span class="help-block">Observaciones Específicas</span>
                        <select id="cbObservacionEspecificaVehiculoAlquiler" name="cbObservacionEspecificaVehiculoAlquiler" class="form-control input-sm linkResetCb selectpicker" multiple="multiple">

                        </select>

                      </div>
                   </div>
                   <div class="row">
                        <div class="col-xs-12">
                            <span class="help-block">Observaciones Generales</span>
                            <textarea class="form-control input-sm" id="txtObservacionesGeneralesVehiculoAlquiler" name="txtObservacionesGeneralesVehiculoAlquiler" rows="4" cols="2" value=""></textarea>
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
                <button id="btnGuardarValidacionVehiculoAlquiler" type="button" class="btn btn-primary" disabled="disabled">Guardar</button>
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
      $(".fecha").datepicker({ 
            autoclose: true,
            language: 'es',
            format: 'yyyy/mm/dd'
        });

       var enlace = "<?php echo  base_url() ?>";
      baseurl(enlace);
      cargacorrespondencia();
     botonesDialogoVehiculoAlquilerValidacion();
     verificarSeleccion();
     eventosCombosValidacionVehiculoAlquiler();
      habilitaObservaciones();
      opcionMultiselect();
       $("#divAnadirDocumentoValidar").on('hidden.bs.modal', function () {
            //alert('asdfgadsf');
            $("body").addClass("modal-open");
          });
       $("#divAnadirPersonasDoc").on('hidden.bs.modal', function () {
            //alert('asdfgadsf');
            $("body").addClass("modal-open");
          });
      //opcionMultiselect();
    //cambiaPestania();
    });
</script>
