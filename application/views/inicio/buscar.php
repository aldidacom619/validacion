<script type="text/javascript" src="<?php echo  base_url() ?>jsd/vehiculos.js"></script>
<script type="text/javascript" src="<?php echo  base_url() ?>jsd/maquinariapesada.js"></script>
<script type="text/javascript" src="<?php echo  base_url() ?>jsd/inmuebles.js"></script>
<div class="contenido">
    <h2 class="label label-info" style="font-size: 1.15em;">Búsqueda de bienes</h2>
</div>
<div >
   
        <form id="form_calcular">
          
          <div class="row"> 
          <fieldset class="form-group">
            <legend style="width: auto;">Introduzca dato técnico del bien (idbien, número de documento, chasis, placa, direccion o superficie terreno)</legend>
                       
             <div class="col-lg-3">
              <div class="input-group">
                <!--<label>INGRESE IDBIEN</label>-->
                <!--<input name="buscar" id="buscar" class="form-control1" onKeyPress='return validar(event)' type="text" value="" size="20" minlength="" />-->
              <input name="buscar" id="buscar" class="form-control" type="text" value="" size="20" minlength="" />
              <span class="input-group-btn">
              <button  class="btn btn-default" type="button" name="ver" id="ver">Buscar</button>
              </span>
              </div>
                
             </div>
   
        </fieldset>    
          </div>
         <table id="dataresp" class="table table-striped table-bordered" cellspacing="0" width="100%">
          </table>
      </form>
 </div>



 <?php include "buscar_v.php";?>
 <?php include "buscar_mp.php";?>
 <?php include "buscar_inm.php";?>
<script language="JavaScript"> 
$(function(){
  $('button#ver').click(function(){
    var val = $('#buscar').val();
    valtrim = val.trim();
    //alert(val.length);
    //var enlace = "<?php echo  base_url() ?>";
    //var enlace = "<?php echo  base_url() ?>" + "index.php/inmuebles/correspondeciadoc";
    //alert("valor del idbien"+enlace);
    if(valtrim != '' && valtrim.length >=3){
      $.ajax({
            dataType  : 'html',
            type    : "POST",
            url     : "<?= base_url()?>inicio/load_idbien",
            data    : 'dato_bien='+valtrim,
            beforeSend  : function(requestData) {
              $('#dataresp').html('<img src="<?= base_url()?>images/ajax.gif" />');
            },
            success   : function(theResponse) {
              $("#dataresp").html(theResponse);
              $("#dataresp").hide();
              $("#dataresp").show("slow");
            },
            error   : function(requestData, strError, strTipoError) {
              alert("Error " + strTipoError +' : ' + strError);
            }
          });
    }
     else
     alert("Debe ingresar parametro de búsqueda mayor a 3 (tres) caracteres");    

  });



$('button#cerrar').click(function(){
    alert("entro al cancelar");

  });


 
});

</script> 

<style type="text/css">
  fieldset 
  {
    border: 1px solid #ddd !important;
    margin: 0;
    min-width: 0;
    padding: 10px;       
    position: relative;
    border-radius:4px;
    background-color:#f5f5f5;
    padding-left:10px!important;
  } 
  
    legend
    {
      font-size:14px;
      font-weight:bold;
      margin-bottom: 0px; 
      width: 35%; 
      border: 1px solid #ddd;
      border-radius: 4px; 
      padding: 5px 5px 5px 10px; 
      background-color: #ffffff;
    }
</style>