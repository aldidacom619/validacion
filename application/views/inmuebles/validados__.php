<!--
ESTILO PARA LA VISTA VALIDACIONES DE INMUEBLES
/*autor:Wilmer Villca*/
-->
<script type="text/javascript" src="<?php echo  base_url() ?>jsd/inmuebles.js"></script>
<ul class="nav nav-tabs" style="margin-top: 15px;">
    <li class="active"><a href="<?php echo base_url()?>index.php/inmuebles/validar/<?php echo $identidad;?>" >Inmuebles</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculos/validarveh/<?php echo $identidad;?>"  >Vehículos</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinaria/validarmaq/<?php echo $identidad;?>"  >Maquinarias</a></li>
    <li ><a href="<?php echo base_url()?>index.php/maquinariapesada/validar/<?php echo $identidad;?>"  >Maquinaria Pesada</a></li>
    <li><a href="<?php echo base_url()?>index.php/inmueblesalquiler/validar/<?php echo $identidad;?>"  >Inmuebles Alquiler</a></li>
    <li ><a href="<?php echo base_url()?>index.php/vehiculosalquiler/validar/<?php echo $identidad;?>"  >Vehículos Alquiler</a></li>
</ul>
<ul class="nav nav-tabs" style="margin-top: 15px;">
  <p>&nbsp;</p>
    <li ><a href="<?php echo base_url()?>index.php/inmuebles/validar/<?php echo $identidad;?>" >Lista de Inmuebles a Validar</a></li>
    <li class="active"><a href="<?php echo base_url()?>index.php/inmuebles/validados/<?php echo $identidad;?>">Lista de Inmuebles Validados</a></li>
</ul>
<div class="row">
  <div class="paneles">
    <!-- LABEL -->
    <h3 class="label label-info" style="font-size: 1.15em; display: block;">Listado de Inmuebles Validados</h3>
      <div class="tabla">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead class="thead">
            <th>Opciones</th> 
            <th>Id Bien</th>
            <th>Código Inmuebles</th>
            <th>Denominación Inmueble</th>
            <th>Terreno o Edificación</th>
            <th>Dirección</th>
            <th>Sup. Terreno</th>
            <th>Sup. Construida</th>
            <th>Departamento</th>
            <th>Documentos</th>
            <th>Estado</th>
          </thead>
          <tbody>
          <? $cont = 1?>
          <? foreach($filas as $fila):?>
            <tr class="odd gradeX">
                <td width="20">
                    <button name='btnValidarInmueble' class='btn btn-warning anchoBotones' 
                    onclick='abrirDialogValidacion(<?= $fila->id?>)'>Validarss Doc</button>
                    <button name='btnAdicionDocumentoValidarInmueble' class='btn btn-success anchoBotones' onclick='adicionarDocDialogValidacion(<?= $fila->id?>,1)'>Documentos</button>
                    <button name='btnAdicionarPersona' class='btn btn-basic anchoBotones' onclick='adicionarDialogNuevaPersona(<?= $fila->id?>,1)'>Persona</button>
                    <?php if($fila->documentos == ''){
                        ?>
                        <button name='btnSinDocumentacion' class='btn btn-danger anchoBotones' onclick='validarSinDocumentacion(<?= $fila->id?>,1)'>Sin Doc</button>
                        <?php
                         } ?>
                </td>
                <td><?= $fila->idbien?></td>
                <td><?= $fila->codigoactivo?></td>
                <td><?= $fila->denominacion?></td>
                <td><?= $fila->tipobien?></td>
                <td><?= $fila->direccion?></td>
                <td><?= $fila->superficieterreno?></td>
                <td><?= $fila->superficieconstruida?></td>
                <td><?= $fila->departamento?></td>
                <td><?= $fila->documentos?></td>
                <td><? if($fila->idsituacion == 1)
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
                            ?>
                </td>
            </tr>
            <?endforeach?>
          </tbody>
        </table>
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
                    <input type="text" id="txtMensajeCabeceraIn" name="txtMensajeCabeceraIn" class="input form-control input-sm" position="1">
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
                    <select id="cbAdjuntaInmueble" class="form-control input-sm" name="cbAdjuntaInmueble" position="2">
                        <option value="-1">Seleccione opción</option>
                        <option value="t">Si</option>
                        <option value="f">No</option>
                    </select>
                  </div>
                  <div class="col-xs-4">
                      <span class="help-block">Corresponde al Bien?</span>
                      <select id="cbCorrespondeInmueble" class="form-control input-sm" name="cbCorrespondeInmueble" position="3">
                            <option value="-1">Seleccione opción</option>
                            <option value="0">Si</option>
                            <option value="1">No</option>
                        </select>
                  </div>
                  <div class="col-xs-4">
                    <span class="help-block">Legible?</span>
                    <select id="cbLegibleInmueble" class="form-control input-sm" name="cbLegibleInmueble" position="4">
                        <option value="-1">Seleccione opción</option>
                        <option value="t">Si</option>
                        <option value="f">No</option>
                    </select>
                  </div>
                  <div class="col-xs-3" style="display:none">
                    <span class="help-block">Estado Documentación</span>
                        <select id="cbEstadoDocumentacionInmueble" class="form-control input-sm" name="cbEstadoDocumentacionInmueble" readonly="true">
                        <option value="-1">Seleccione opción</option>
                        <option value="1">Definitiva</option>
                        <option value="2">Provisional</option>
                        <option value="3">Preventivo</option>
                    </select>
                  </div>
          </div>
          <div id="divDatosValidacionDocProvisional" class="row" style="display: none;">
                <div class="col-xs-4">
                      <div class="row">
                        <div class="col-xs-12">
                            <span class="help-block">Nro Documentosss</span>
                            <input type="text" value=""  id="txtNroDocumentoInmuebleProv" class="input form-control input-sm" name="txtNroDocumentoInmuebleProv" readonly="true">
                        </div>
                      </div>
                  </div>
                  <div class="col-xs-4">
                      <div class="row">
                         <span class="help-block">Opcion Validaciónsss</span>
                          <select id="cbNroDocumentoOpcionProv" class="form-control input-sm" name="cbNroDocumentoOpcionProv" position="5">
                            
                          </select>
                      </div>
                  </div>
                  <div class="col-xs-4">
                      <div class="row">
                        <div class="col-xs-12">
                            <span class="help-block">Nro Documento observado</span>
                            <input type="text" value=""  id="txtNroDocumentoInmuebleObservadoProv" class="input form-control input-sm" name="txtNroDocumentoInmuebleObservadoProv" readonly="true" position="6">
                        </div>
                      </div>
                  </div>

          </div>

          <div id="divDatosValidacion" class="row" style="display: none;">
                  <div class="col-xs-4">
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Nro Documentoss</span>
                              <input type="text" value=""  id="txtNroDocumentoInmueble" class="input form-control input-sm" name="txtNroDocumentoInmueble" readonly="true">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Superficie</span>
                              <input type="text" value=""  id="txtSuperficieInmueble" class="input form-control input-sm" name="txtSuperficieInmueble" readonly="true">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Dirección Ubicación</span>
                              <input type="text" value=""  id="txtDireccionInmueble" class="input form-control input-sm" name="txtDireccionInmueble" readonly="true">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Catastro</span>
                              <input type="text" value=""  id="txtCatastroInmueble" class="input form-control input-sm" name="txtCatastroInmueble" readonly="true">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Denominación</span>
                              <input type="text" value=""  id="txtDenominacionInmueble" class="input form-control input-sm" name="txtDenominacionInmueble" readonly="true">
                          </div>
                      </div>
                  </div>
                  <div class="col-xs-4">
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Opcion Validaciónss</span>
                              <select id="cbNroDocumentoOpcion" class="form-control input-sm" name="cbNroDocumentoOpcion" position="5">
                                
                              </select>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Opcion Validación</span>
                              <select id="cbSuperficieOpcion" class="form-control input-sm" name="cbSuperficieOpcion" position="7">
                               
                              </select>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Opcion Validación</span>
                              <select id="cbDireccionOpcion" class="form-control input-sm" name="cbDireccionOpcion" position="9">
                               
                              </select>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Opcion Validación</span>
                              <select id="cbCatastroOpcion" class="form-control input-sm" name="cbCatastroOpcion" position="11">
                               
                              </select>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Opcion Validación</span>
                              <select id="cbDenominacionOpcion" class="form-control input-sm" name="cbDenominacionOpcion" position="13">
                              
                              </select>
                          </div>
                      </div>
                  </div>

                  <div class="col-xs-4">
                      <div class="row">
                          <div class="col-xs-12" >
                              <span class="help-block">Nro Documento observado</span>
                              <input type="text" value=""  id="txtNroDocumentoInmuebleObservado" class="input form-control input-sm" name="txtNroDocumentoInmuebleObservado" readonly="true" position="6">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Superficie observada</span>
                              <input type="text" value=""  id="txtSuperficieInmuebleObservado" class="input form-control input-sm" name="txtSuperficieInmuebleObservado" readonly="true" position="8">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Dirección Ubicación observada</span>
                              <input type="text" value=""  id="txtDireccionInmuebleObservado" class="input form-control input-sm" name="txtDireccionInmuebleObservado" readonly="true" position="10">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Catastro observado</span>
                              <input type="text" value=""  id="txtCatastroInmuebleObservado" class="input form-control input-sm" name="txtCatastroInmuebleObservado" readonly="true" position="12">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Denominación observado</span>
                              <input type="text" value=""  id="txtDenominacionInmuebleObservado" class="input form-control input-sm" name="txtDenominacionInmuebleObservado" readonly="true" position="14">
                          </div>
                      </div>
                  </div>
          </div>
          <div id="divObservacionesInmueble" style="display: none;">
            <div class="row">
                <div class="col-xs-12">
                    <span class="help-block">Posibles observaciones</span>
                 <select id="cbObservacionesInmuebles" class="form-control input-sm selectpicker" multiple="multiple" name="cbObservacionesInmuebles" style='width:300px'>


                    </select>
                </div>

                </div>
              <div class="row">
                <div class="col-xs-12">
                    <span class="help-block">Otras observaciones</span>
                    <textarea id="txtObservacionesInmuebles" class="form-control" rows="3" name="txtObservacionesInmuebles" position="15"></textarea>
                </div>
            </div>
           </div>
          </form>
      </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal" position="16">Cerrar</button>
          <button id="btnGuardarValidacionInmueble" type="button" class="btn btn-primary" disabled="disabled" position="17">Guardar</button>
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

           botonesDialogoValidacion();
    });
</script>
