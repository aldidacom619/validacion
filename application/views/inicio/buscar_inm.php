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
                    <span class="help-block" id="nombreEntidad1"><strong>Entidad: <label id="nombre_entidad"></label></strong></span>
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
                
                     
                     <button name='btnAdicionDocumentoValidarInmueble' class='btn btn-success anchoBotones'          onclick='adicionarDocDialogValidacion(1)'>+ Documento</button>
                       
                </div>
            </div>

          <table id="tablaDocumentacionInmueble" class="table table-striped table-bordered" cellspacing="0" width="100%">
          </table>


         <form id="formularioValidacionInmueble">
          <input type="hidden" id="txtIdDocumento" name="txtIdDocumento">
          <input type="hidden" id="txtTipoDocumento" name="txtTipoDocumento">
          <input type="hidden" id="txtIdValidacion" name="txtIdValidacion">
          <input type="hidden" id="txtIdBienInmueble" name="txtIdBienInmueble">
          <input type="hidden" id="txtIdB1" name="txtIdB1">
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
                            <span class="help-block">Nro Documento observado</span>
                            <input type="text" value=""  id="txtNroDocumentoInmuebleObservadoProv" class="input form-control input-sm" name="txtNroDocumentoInmuebleObservadoProv" readonly="true" position="2">
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
                              <span class="help-block">Nro Documento observado</span>
                              <input type="text" value=""  id="txtNroDocumentoInmuebleObservado" class="input form-control input-sm" name="txtNroDocumentoInmuebleObservado" readonly="true" position="2">
                          </div>
                      </div> 
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Superficie observada</span>
                              <input type="text" value=""  id="txtSuperficieInmuebleObservado" class="input form-control input-sm" name="txtSuperficieInmuebleObservado" readonly="true" position="4">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                              <span class="help-block">Dirección Ubicación observada</span>
                              <input type="text" value=""  id="txtDireccionInmuebleObservado" class="input form-control input-sm" name="txtDireccionInmuebleObservado" readonly="true" position="6">
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
          
          <button style="display:none;" id="btnGuardarValidacionInmueble" type="button" class="btn btn-primary" disabled="disabled">Guardar</button>   
      </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
<script language='JavaScript'> 
$(function(){
  
  $('button#cerrar').click(function(){
    alert('entro al cancelar');
    $('div').remove('#largemodalv'); 
  });


 
});

</script> 

<script type="text/javascript">
  $(document).ready(function(){
       var enlace = "<?php echo  base_url() ?>";
       var idfunc = "<?= $_SESSION['idfuncionario']; ?>";
      baseurl(enlace);
      idfuncval(idfunc);
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
