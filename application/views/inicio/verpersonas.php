<script type="text/javascript" src="<?php echo  base_url() ?>jsd/principal.js"></script>

<div id = "divAnadirPersonasDoc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" style="width: 800px">
    <div class="modal-content">
       <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
        <h4 class="modal-title">Adicionar Persona y/o Entidad propietaria</h4>
      </div>
        <div class="modal-body" id="infopersona">
            
           

            <div id="divListadoPersonaAdicionado" style="display:none">
                <table id="tablaPersonaAdicionado" class="table table-striped table-bordered" cellspacing="0">
                </table> 
            </div>  
            <div id="divListadoPersonaAdicionadoAlquiler" style="display:none">
                <table id="tablaPersonaAdicionadoAlquiler" class="table table-striped table-bordered" cellspacing="0">
                </table> 
            </div> 
          <form id="formAdicionarPersona">
            <input type="hidden" value=""  id="txtIdBienAdicionarPersona" name="txtIdBienAdicionarPersona">  
            <input type="hidden" value=""  id="txtIddocAdicionarPersona" name="txtIddocAdicionarPersona">  
            <input type="hidden" value=""  id="txtIdPersona" name="txtIdPersona"> 
            <input type="hidden" value=""  id="txtClaseBien" name="txtClaseBien"> 
            <input type="hidden" value="" id="accionPersona" name="accionPersona">


            

             <div id="btnDocAdd">
               <button id="btnNuevoAddPersona" type="button" class="btn btn-success">Propietario Actual</button>
              
            </div>
                <div id="divFormAddPersona" style="display: none">
                    <div class="row">
                        <div class="col-xs-6">
                              <span class="help-block">Tipo de Documento Observado</span>
                              <select id="cbTipoDocumentoPropietario" class="form-control input-sm" name="cbTipoDocumentoPropietario">      
                              </select>
                        </div>
                        <div class="col-xs-6">
                              <span class="help-block">Tipo de Propietario</span>
                              <select id="cbPropietario" class="form-control input-sm" name="cbPropietario">
                                <option value="-1">Seleccione una opcion</option>
                                <option value="1">Persona Natural</option>
                                <option value="2">Entidad Publica</option>
                                <option value="3">Entidad Privada</option>
                                <option value="4">Otra Entidad Pública</option>
                              </select>
                        </div>
                    </div> 
                    <div class="row">  
                        <div class="col-xs-12">
                              <div id="divPersonaNatural" style="display:none">
                                  <span class="help-block">Propietarios</span>
                                  <input type="text" value=""  id="txtNuevoPropietario" class="input form-control input-sm" name="txtNuevoPropietario">
                              </div>
                              <div id="divEntidadPrivada" style="display:none">
                                 <span class="help-block">Propietario</span>
                                   <input type="text" value=""  id="txtNuevaEntidadPrivada" class="input form-control input-sm" name="txtNuevaEntidadPrivada">
                              </div>
                              <div id="divEntidadPublica" style="display:none">
                                   <span class="help-block">Propietario</span>
                                   <!--<select id="txtNuevaEntidadPublica" class="form-control input-sm" name="txtNuevaEntidadPublica"></select>-->
                                   <input type="text" value=""  id="txtNuevaEntidadPublicaText" class="input form-control input-sm txtNuevaEntidadPublicaText" name="txtNuevaEntidadPublica">
                                   
                              </div>
                        </div>
                    </div>
                </div>
            </form>    
          
          
      </div>

      <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

          <?php
                      if (estadoentidad($identidad) == 1)
                       {?>
                   <button id="btnGuardarAddPersona" type="button" class="btn btn-primary">Guardar</button>

                       <?php
                       } 
                    ?>
          
      </div>
      </div>
      
    </div>
  </div>











  <script type="text/javascript">
        $( document ).ready(function() {
        var enlace = "<?php echo  base_url() ?>";
        baseurl(enlace);
      
      botonesAddPersona();
      accionComboTipoPersona();
      $('.txtNuevaEntidadPublicaText').autocomplete({
          source: function( request, response ) {
              $.ajax({
                  type: "GET",
                  url: "<?=base_url()?>index.php/documentos/getEntidadesText",
                  dataType: "json",
                  data: {
                      term: request.term
                  },
                  success: function( data ) {
                      response( data );
                      $("#btnGuardarAddPersona").removeAttr('disabled');
                  },
                  error: function(){
                    $("#btnGuardarAddPersona").attr('disabled','true');
                  }
              });
          },
          select: function(){
            $("#btnGuardarAddPersona").removeAttr('disabled');
          }
        });

        $('#txtNuevoPropietario').keyup(function(){
            if($('#txtNuevoPropietario').val() ==''){
              $('#btnGuardarAddPersona').prop('disabled', true);
            }
            else{
              $('#btnGuardarAddPersona').prop('disabled', false);
            }
         });
        $('#txtNuevaEntidadPrivada').keyup(function(){
            if($('#txtNuevaEntidadPrivada').val() ==''){
              $('#btnGuardarAddPersona').prop('disabled', true);
            }
            else{
              $('#btnGuardarAddPersona').prop('disabled', false);
            }
         });
        
        });

    </script>


