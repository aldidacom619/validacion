<script type="text/javascript" src="<?php echo  base_url() ?>jsd/principal.js"></script>
<div class="modal fade" id="divValidarSinDoc" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true" style="display:none">
    <div class="modal-dialog modal-lg" style="width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>    
            </div>
            <div class="modal-body">
            <h4 class="modal-title" id="myModalLabel">Esta Seguro de proceder con la Validación el siguiente Bien Sin Documentación?</h4>
            </div>
            <div class="modal-footer">
            <button id="btnCancelarSinDoc" type="button" class="btn btn-default">Cancelar</button>
            <button id="btnGuardarSinDoc" type="button" value="" class="btn btn-primary">Aceptar</button>
            </div>
         </div>
     </div>
</div>
 
<script type="text/javascript">
        $( document ).ready(function() {
             btnGuardarValidacionSinDoc();
        });
    </script>