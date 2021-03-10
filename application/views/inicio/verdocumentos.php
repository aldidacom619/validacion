<script type="text/javascript" src="<?php echo  base_url() ?>jsd/principal.js"></script>

<div id = "divAnadirDocumentoValidar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" style="width: 800px">
    <div class="modal-content">
       <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
        <h4 class="modal-title">Adicionar nuevos documentos para su validación</h4>
      </div>
        <div class="modal-body" id="infopersona">
            
           

            <table id="tablaDocumentosAdicionados" class="table table-striped table-bordered" cellspacing="0" width="100%">
            </table>
          <form id="formAdicionarDocumento">
            <input type="hidden" value=""  id="txtIdBienAdicionarDoc" name="txtIdBienAdicionarDoc">  
            <input type="hidden" value=""  id="txtIdDocAdd" name="txtIdDocAdd"> 
            <input type="hidden" value=""  id="txtIdClaseDoc" name="txtIdClaseDoc">  
            <input type="hidden" value=""  id="accionDoc" name="accionDoc">
            
 
             <div id="divListadoDocAdicionados">
              <table id="tablaDocumentosAdicionados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                </table> 
            </div>   
            
            <div id="btnDocAdd">
               <button id="btnNuevoAddDoc" type="button" class="btn btn-success">Nuevo Documento</button>
            </div>

            <div id="divFormAddDoc" style="display: none">
                <div class="row">
                    <div class="col-xs-6">
                          <span class="help-block">Tipo de Documento</span>
                          <select id="cbTipoDocumentoAdicionar" class="form-control input-sm" name="cbTipoDocumentoAdicionar">      
                          </select>
                    </div>
                    <div class="col-xs-6">
                          <span class="help-block">Nro Documento</span>
                          <input type="text" value=""  id="txtNroDocumentoAdicionar" class="input form-control input-sm" name="txtNroDocumentoAdicionar">
                    </div>
                </div>
            </div>    
            </form>     
          
         
      </div>
 
      <div class="modal-footer">  
          
          <button type="button" id="btnCancelarAddDoc" class="btn btn-default" >Cerrar</button>
          <button id="btnGuardarAddDoc" type="button" class="btn btn-primary" disabled="true">Guardar</button>
      </div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>










  <script type="text/javascript">
        $( document ).ready(function() {
          var enlace = "<?php echo  base_url() ?>";
          baseurl(enlace);
      // btnCerrar();
        //    OperacionesPanelPrincipal();
            botonesAddDoc();
        //    marcarFilaTablaDocumentacionAdd();
     // botonesAddPersona();
      //accionComboTipoPersona();
       //marcarFilaTablaPersona();
       //marcarFilaTablaPersonaAlquiler();
         //                btnGuardarValidacionSinDoc();
         $('#txtNroDocumentoAdicionar').keyup(function(){
            if($('#txtNroDocumentoAdicionar').val() ==''){
              $('#btnGuardarAddDoc').prop('disabled', true);
            }
            else{
              $('#btnGuardarAddDoc').prop('disabled', false);
            }
         });
        });
    </script>


