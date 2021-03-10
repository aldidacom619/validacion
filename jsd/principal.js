var base_url;
var tipo;
var idbien;

function baseurl(enlace)
{
  base_url = enlace; 
}
function abrirDialoghistorial(idfuncionario){//2019 hist

  cargarEntidadesHist(idfuncionario);  
  $('#largemodalhistorial').modal('show');

}

function cargarEntidadesHist(id){//2019 hist
      //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/inmuebles/";

    $("#HistorialTable1").DataTable( {
         ajax: {
            url: base_url+"index.php/inicio/listasHist",
            type: "POST",
            data: function ( d ) {
                d.func = id
                
            }
        },
        
        "columns": [
           { "data": "nro"},
           { "data": "nombre"}
           ],
        
        "autoWidth": false, //
       "scrollY":        "350px",
        "bDestroy": true,//
        "bProcessing": true,
        "aLengthMenu": [[10, -1], [10, "Todo"]],
        "iDisplayLength": 10,
                        
    });
}
 function MostVAlidadores(ident, ent){//2019 hist2

        //alert("hola"+ent);
        $('label#nombre_ent').html(ent);
        cargarValidadoEntidad1(ident); 
        $('#largeModalhistValidadores').modal('show');
    }
    function cargarValidadoEntidad1(id){//2019 hist2
      //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/inmuebles/";
      //var base_url = "<?php echo  base_url() ?>";
    $("#HistorialTable2").DataTable( {
         ajax: {
            url: base_url+"index.php/inicio/listasHistEntidadValidador",
            type: "POST",
            data: function ( d ) {
                d.func = id
                
            }
        },
        
        "autoWidth": false, //
       "scrollY":        "200px",
        "bDestroy": true,//
        "bProcessing": true,
        "aLengthMenu": [[10, -1], [10, "Todo"]],
        "iDisplayLength": 10,
                        
    });
}

function adicionarDocDialogValidacion(tipobien)
{
    tipo = tipobien;
	//alert(idbien);
    idbien = $('#txtIdB').val();
	$('#divFormAddDoc').hide();

    $('#btnGuardarAddDoc').prop('disabled', true);
    $('#txtIdBienAdicionarDoc').val(idbien);
    $('#txtIdClaseDoc').val(tipobien);
    cargarTablaDocumentosAdicionados(idbien);
	$('#divEntidadPrivada').hide();
	$('#divEntidadPublica').hide();
	$('#divPersonaNatural').hide();	
	$('#txtIdDocAdd').val('');
    var enlace = base_url + "index.php/documentos/getTipoDocumentos3";
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: tipobien, idb: idbien},
       success: function (data) {
           $('#cbTipoDocumentoAdicionar').html('');
           $('#cbTipoDocumentoAdicionar').html(data);
           $('#divAnadirDocumentoValidar').modal('show'); 
       }
    }); 
    
}
function adicionarDocDialogValidacion2(tipobien)
{
    tipo = tipobien;
    //alert(idbien);
    idbien = $('#txtIdBMP').val();
    $('#divFormAddDoc').hide();

    $('#btnGuardarAddDoc').prop('disabled', true);
    $('#txtIdBienAdicionarDoc').val(idbien);
    $('#txtIdClaseDoc').val(tipobien);
    cargarTablaDocumentosAdicionados(idbien);
    $('#divEntidadPrivada').hide();
    $('#divEntidadPublica').hide();
    $('#divPersonaNatural').hide(); 
    $('#txtIdDocAdd').val('');
    var enlace = base_url + "index.php/documentos/getTipoDocumentos3";
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: tipobien, idb: idbien},
       success: function (data) {
           $('#cbTipoDocumentoAdicionar').html('');
           $('#cbTipoDocumentoAdicionar').html(data);
           $('#divAnadirDocumentoValidar').modal('show'); 
       }
    }); 
    
}
function cargarTablaDocumentosAdicionados(idbien){
	var urls = "";
	if($('#txtIdClaseDoc').val()==5 || $('#txtIdClaseDoc').val()==7)
	{	
		urls=base_url + "index.php/documentos/listadoAddAlquiler"; 
	}
	else
	{	
		urls=base_url + "index.php/documentos/listadoAdd"; }

	//var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/documentos/getDocumentos";
    $.ajax({
        type: "GET",
        url : urls,
       data: {id: idbien},
        success: function (data) {
        	$('#tablaDocumentosAdicionados').html(data);
       }
    });

    
}

 


function botonesAddDoc(){
	
    $('#btnNuevoAddDoc').on('click',function(){
        
		var enlace = base_url + "index.php/documentos/getTipoDocumentos3";
        $.ajax({
           type: "GET",
           url: enlace,
           data: {id: tipo, idb: idbien},
           success: function (data) {
               $('#cbTipoDocumentoAdicionar').html('');
               $('#cbTipoDocumentoAdicionar').html(data);
               //$('#divAnadirDocumentoValidar').modal('show'); 
           }
        }); 


        if( $('#txtIdClaseDoc').val()== 5 ||  $('#txtIdClaseDoc').val() == 7)
	        $('#accionDoc').val('nuevoDocAlquiler');
		else
			$('#accionDoc').val('nuevoDoc');
        $('#cbTipoDocumentoAdicionar option[value="-1"]').prop('selected','selected');
        $('#txtNroDocumentoAdicionar').val('');
        $('#divFormAddDoc').show();
        $('#btnGuardarAddDoc').prop('disabled', true);
    });



	$('#btnCancelarAddDoc').on('click',function(){
		 
           // window.setTimeout('location.reload()', 500);
           //alert(tipo);
            if(tipo==1)
            {
                var enlace = base_url + "index.php/inmuebles/getDocumentos";
                $.ajax({
                    type: "GET",
                    url : enlace,
                   data: {id: idbien},
                    success: function (data) {
                    $('#tablaDocumentacionInmueble').html(data);
                   }
                });       
            }
            if(tipo==3)
            { 
                
               var enlace = base_url + "index.php/vehiculos/getDocumentos";
                $.ajax({
                    type: "GET",
                    url : enlace,
                   data: {id: idbien, estado: 1},
                    success: function (data) {
                    $('#tablaDocumentacionVehiculo').html(data);
                   }
                });
            }

            if(tipo == 4)
            {
                  var enlace = base_url + "index.php/maquinaria/getDocumentos";
                    $.ajax({
                        type: "GET",
                        url : enlace,
                       data: {id: idbien},
                        success: function (data) {
                        //alert(data);
                        $('#tablaMaquinariaValidados').html(data); 

                       }
                    });
            }
            if(tipo == 6)
            {
                  var enlace = base_url + "index.php/maquinariapesada/getDocumentos";
                    $.ajax({
                        type: "GET",
                        url : enlace,
                       data: {id: idbien},
                        success: function (data) {
                        $('#tablaDocumentacionMaquinariaPesada').html(data);
                       }
                    });
            }
            if(tipo == 5)
            {
                 var enlace = base_url + "index.php/inmueblesalquiler/getDocumentos";
                $.ajax({                           
                    type: "GET",
                    url : enlace,
                   data: {id: idbien}, 
                    success: function (data) {
                    //  alert(data);
                    $('#tablaDocumentacionInmuebleAlquiler').html(data);
                   }
                });
            }
            if(tipo == 7)
            {
                    var enlace = base_url + "index.php/vehiculosalquiler/getDocumentos";
                    $.ajax({                           
                        type: "GET",
                        url : enlace,
                       data: {id: idbien},
                        success: function (data) {
                        //  alert(data);
                        $('#tablaDocumentacionVehiculoAlquiler').html(data);
                       }
                    });

            }

         
       $('#divAnadirDocumentoValidar').modal('hide');


	});
    $('#btnGuardarAddDoc').on('click',function(){
        
        if( $('#txtIdClaseDoc').val()== 5 ||  $('#txtIdClaseDoc').val() == 7)
        {
            var enlace = base_url + "index.php/documentos/guardardocumentoalquiler";
        }
        else
            {
                var enlace = base_url + "index.php/documentos/guardardocumento";
            }
        


        var datos = $('#formAdicionarDocumento').serialize();
        $('#btnGuardarAddDoc').prop('disabled', true);
        //$('#btnGuardarAddDoc').prop('disabled', false);
        $.ajax({
            type:'GET',
            url:enlace,
            data:datos,
            success:function(data){
				
                //alert(data);
				 datos=$.parseJSON(data);
                   
                	if(datos.aux == 1)
                	{	
                		
                		alert('SE REALIZO CORRECTAMENTE EL REGISTRO DEL DOCUMENTO');
                	}
                	else
                	{	
                		alert('SE REALIZO LA MODIFICACIÓN CORRECTAMENTE DEL DOCUMENTO');
                	}
                		
            	    $('#txtIdDocAdd').val(datos.iddocume);
            		  //$('#cbTipoDocumentoAdicionar').html(datos.doc);
            		$('#tablaDocumentosAdicionados').html(datos.tabla);	//*/
                
            }
        });
         
    });
   
    
}


function documemntosver(id)
{
	
	if( $('#txtIdClaseDoc').val()== 5 ||  $('#txtIdClaseDoc').val() == 7)
        	$('#accionDoc').val('editarDocAlquiler');
		else 
			$('#accionDoc').val('editarDoc');
        getDocumentoAdicionado(id);
     $('#btnGuardarAddDoc').prop('disabled', false);

}
function getDocumentoAdicionado(iddoc)
{
    //var iddoc = $('#txtIdDocAdd').val();
    var option = '';
    $('#txtIdDocAdd').val(iddoc);
	var urls="";
	if( $('#txtIdClaseDoc').val()== 5 ||  $('#txtIdClaseDoc').val() == 7)
	{
			urls = base_url + "index.php/documentos/getDocumentoAlquiler"; 
	}

		
	else
	{

		urls = base_url + "index.php/documentos/getDocumento";
	}
		
    $.ajax({
            type:'GET',
            url:urls,
            data: {id: iddoc},
            success:function(data)
            {
			   //alert(data);
			    var result = JSON.parse(data);
                $.each(result, function(i, val){
                	
                  option = '<option value='+val.idtipodocumento+'>'+val.descripcion+'</option>';    

                   //alert(option);
                    $('#cbTipoDocumentoAdicionar').html(option);
                    
	           		
                     $('#txtNroDocumentoAdicionar').val(val.nrodocumento);
                });
				$('#divFormAddDoc').show();
        	}
    });
}


function documemntoseliminar(iddoc)
{
	 var bien = $('#txtIdBienAdicionarDoc').val();
   
    $('#txtIdDocAdd').val(iddoc);
	var enlace="";
	if( $('#txtIdClaseDoc').val()== 5 ||  $('#txtIdClaseDoc').val() == 7)
	{
		enlace = base_url + "index.php/documentos/eliminarDocumentoAlquiler"; 
	}
	else
	{
        enlace = base_url + "index.php/documentos/eliminarDocumento";
	}

    $.ajax({
        type:'GET',
        url:enlace,
        data: {id: iddoc,bi: bien},
        success:function(data){
			//alert(data);
			 	datos=$.parseJSON(data);
                $('#txtIdDocAdd').val('');
        		$('#accionDoc').val('');
        		$('#tablaDocumentosAdicionados').html(datos.tabla);
        		alert('SE ELIMINO CORRECTAMENTE EL DOCUMENTO');

        }
    });

}
//////////////////////////////////////////PERSONAS



function adicionarDialogNuevaPersona(iddoc,idbien,tipobien)
{
	//alert(iddoc + '-'+ idbien + '-' + tipobien);
   limpiar_persona();
    $('#btnGuardarAddPersona').prop('disabled', true);
	$('#divFormAddPersona').hide();
    $('#txtIdBienAdicionarPersona').val(idbien);
    $('#txtIddocAdicionarPersona').val(iddoc);
	$('#txtClaseBien').val(tipobien);
	
	if(tipobien == 5 || tipobien == 7 ){
    	cargarTablaPersonaAdicionadosAlquiler(iddoc);
		$('#divListadoPersonaAdicionado').hide();
		$('#divListadoPersonaAdicionadoAlquiler').show();
	}
	else {
    	cargarTablaPersonaAdicionados(iddoc);
		$('#divListadoPersonaAdicionado').show();
		$('#divListadoPersonaAdicionadoAlquiler').hide();
	}
	$('#divFormAddPersona').show();
    $('#btnGuardarAddPersona').prop('disabled', true);
     $('#accionPersona').val('nuevaPersona');
    var enlace = base_url + "index.php/documentos/getTipoDocumentos2";
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: tipobien, doc : iddoc},
       success: function (data) {
           //alert(data);
           $('#cbTipoDocumentoPropietario').html('');
            $('#cbTipoDocumentoPropietario').html(data);
            $('#divAnadirPersonasDoc').modal('show');
       }
    });
    
	//$('#divAnadirPersonasDoc').modal('show');
}
function limpiar_persona()
{

      $('#txtIdPersona').val('');
      $('#txtClaseBien').val('');
      $('#accionPersona').val(''); 
      $('#cbPropietario option[value="-1"]').prop('selected','selected');
      $('#txtNuevaEntidadPublica option[value="-1"]').prop('selected','selected');
      $('#txtNuevoPropietario').val('');
      $('#txtNuevoPropietario').val('');
      $('#txtNuevaEntidadPrivada').val('');
}
function cargarTablaPersonaAdicionados(iddoc){

	//alert(idbien);
    var urls = "";
	urls=base_url + "index.php/documentos/listadoPersona";
    $.ajax({
        type: "GET",
        url : urls,
        data: {id: iddoc},
        success: function (data) {
           // alert(data);	
            $('#tablaPersonaAdicionado').html(data);
        }
    });
 }

 function cargarTablaPersonaAdicionadosAlquiler(iddoc){

    //alert(idbien);
    var urls = "";
    urls=base_url + "index.php/documentos/listadoPersonaalquiler";
    $.ajax({
        type: "GET",
        url : urls,
        data: {id: iddoc},
        success: function (data) {
           // alert(data);  
            $('#tablaPersonaAdicionadoAlquiler').html(data);
        }
    });
 }



function botonesAddPersona(){
         $('#btnNuevoAddPersona').on('click',function(){
        $('#accionPersona').val('nuevaPersona');
        $('#cbTipoDocumentoPropietario option[value="-1"]').prop('selected','selected');
        $('#cbPropietario option[value="-1"]').prop('selected','selected');
        $('#txtNuevaEntidadPublica option[value="-1"]').prop('selected','selected');
        $('#txtNuevoPropietario').val('');
        $('#divFormAddPersona').show();
		$('#btnGuardarAddPersona').prop('disabled', false);
          $('#divPersonaNatural').hide();
                        $('#divEntidadPublica').hide();
                        $('#divEntidadPrivada').hide();

    });
	$('#btnCancelarAddPersona').on('click',function(){
		$('#divAnadirPersonasDoc').modal('hide');
	});
    
    $('#btnGuardarAddPersona').on('click',function()
    {
        

        var enlace = base_url + "index.php/documentos/guardarpersona";
        var datos = $('#formAdicionarPersona').serialize();
        $('#btnGuardarAddPersona').prop('disabled', true);
        
        $.ajax({
            type:'GET',
            url:enlace,
            data:datos,
            success:function(data){
                //alert(data);
                  datos=$.parseJSON(data);
                
                    if(datos.aux == 1)
                    {   
                        
                        alert('SE REALIZO CORRECTAMENTE EL REGISTRO DE LA PERSONA');
                    }
                    else
                    {   
                        alert('SE REALIZO LA MODIFICACIÓN CORRECTAMENTE DE LA PERSONA');
                    }
                    $('#divFormAddPersona').hide(); 
                    $('#txtIdPersona').val('');
                    $('#accionPersona').val('');
                    if($('#txtClaseBien').val() == 5 || $('#txtClaseBien').val() == 7)
                    {
                        $('#tablaPersonaAdicionadoAlquiler').html(datos.tabla);
                    }
                    else{
                        $('#tablaPersonaAdicionado').html(datos.tabla);
                    }
                    //alert(datos.iddocume);
                    //$('#tablaDocumentosAdicionados').html(datos.tabla); */
                
            }
        });
        
    });
    $('#btnEditPersona').on('click',function(){
		$('#btnGuardarAddPersona').prop('disabled', false);
        $('#accionPersona').val('editarPersona');
        getPersonaAdicionado();
    });
    $('#btnEliminarPersona').on('click',function(){
        $('#accionPersona').val('eliminarPersona');
        eliminarPersonas();
    });
}
function accionComboTipoPersona(){
    
    $('#cbPropietario').change(function() {
        //$('#txtNuevaEntidadPublica').hide();    
        var valor = $('#cbPropietario').val();
        $('#btnGuardarAddPersona').prop('disabled', true);
        if (valor == -1){
            $('#divPersonaNatural').hide();
            $('#divEntidadPrivada').hide();
            $('#divEntidadPublica').hide();
        }
        else if (valor == 1 || valor == 4 ){
            $('#divPersonaNatural').show();
            $('#divEntidadPrivada').hide(); 
            $('#divEntidadPublica').hide();
        } else if (valor == 2){
            $('#divEntidadPrivada').hide();
            $('#divPersonaNatural').hide();
            $('#divEntidadPublica').show();
            eventoAutocompletar();
        } else {
             
            $('#divEntidadPublica').hide();
            $('#divPersonaNatural').hide();
            $('#divEntidadPrivada').show();
        }
    });     
}

function eventoAutocompletar(){
    var urls = "";
    var a = 1;
    urls=base_url + "index.php/documentos/getEntidades";
    $.ajax({
        type: "GET",
        url : urls,
        data: {id: a},
        success: function (data) {
            $('#txtNuevaEntidadPublica').html('');
            $('#txtNuevaEntidadPublica').html(data);
        }
    });
}
function editarpersona(idper)
{
    //alert(idper);
    $('#btnGuardarAddPersona').prop('disabled', false);
        $('#accionPersona').val('editarPersona');
    getPersonaAdicionado(idper);
}
function getPersonaAdicionado(idper)
{
   
    eventoAutocompletar();
    $('#txtIdPersona').val(idper);

     var tipobien = $('#txtClaseBien').val();
    var   urls = base_url + "index.php/documentos/getPersona";
   
        
    $.ajax({
            type:'GET',
            url:urls,
            data: {id: idper, tipo: tipobien},
            success:function(data)
            {
               //alert(data);
                var result = JSON.parse(data);
                $.each(result, function(i, val){
                     //$('#cbTipoDocumentoAdicionar option[value="'+val.idtipodocumento+'"]').prop('selected','selected');
                     //$('#txtNroDocumentoAdicionar').val(val.nrodocumento);
                        $('#divPersonaNatural').hide();
                        $('#divEntidadPublica').hide();
                        $('#divEntidadPrivada').hide();
                        
                        $('#cbTipoDocumentoPropietario option[value="'+val.idtipodocumento+'"]').prop('selected','selected');
                        $('#cbPropietario option[value="'+val.idtipodatoadicional+'"]').prop('selected','selected');
                        $('#txtNuevaEntidadPublica option[value="'+val.descripcion+'"]').prop('selected','selected');
                        //$('#txtNuevaEntidadPublica').val(val.descripcion);
                        $('#txtNuevoPropietario').val(val.descripcion);
                        
                        $('#txtNuevaEntidadPrivada').val(val.descripcion);

                         if(val.idtipodatoadicional == 1){
                          //  $('#txtNuevoPropietario').val(val.descripcion);
                            $('#divPersonaNatural').show();
                        }
                         if(val.idtipodatoadicional == 4){
                          //  $('#txtNuevoPropietario').val(val.descripcion);
                            $('#divPersonaNatural').show();
                        }
                        if(val.idtipodatoadicional == 2){
                            //$('#txtNuevoPropietario').val(val.descripcion);
                           // $('#txtNuevaEntidadPublica option[value="'+val.descripcion+'"]').prop('selected','selected');
                            $('#divEntidadPublica').show();

                        }
                        if(val.idtipodatoadicional == 3){
                            //$('#txtNuevaEntidadPrivada').val(val.descripcion);
                             $('#divEntidadPrivada').show();
                        }
                      
                });
                $('#divFormAddPersona').show();
            }
    });
}

function eli_persona(id)
{
   // alert(id);
    
    idbien = $('#txtIdBienAdicionarPersona').val();
    tipobien = $('#txtClaseBien').val();
     var enlace = base_url + "index.php/documentos/eliminarpersona";
       
        $('#btnGuardarAddPersona').prop('disabled', true);
        
        $.ajax({
            type:'GET',
            url:enlace,
            //data: {idper: id, tipobien:tipo, bien:idbien},
            data: {idper: id, tipo:tipobien, bien:idbien},
            success:function(data){
               // alert(data);
                  datos=$.parseJSON(data);
                
                    if(datos.aux == 1)
                    {   
                        
                        alert('SE ELIMINO CORRECTAMENTE EL REGISTRO DE LA PERSONA');
                    }
                   

                    $('#divFormAddPersona').hide(); 
                    $('#txtIdPersona').val('');
                    $('#accionPersona').val('');
                    if($('#txtClaseBien').val() == 5 || $('#txtClaseBien').val() == 7)
                    {
                        $('#tablaPersonaAdicionadoAlquiler').html(datos.tabla);
                    }
                    else
                    {
                        $('#tablaPersonaAdicionado').html(datos.tabla);
                    }
                   
                
            }
        });
}
/*validar inputs y text area */ 
$(document).ready( function () {
                /* Validación para los inputs y tex Área 
                /* CONVIERTE INPUT EN MAYUSCULAS*/
                $(":input").on("keypress", function () {
                    var $input = $(this);
                    setTimeout(function () {
                        //$input.val($input.val().toUpperCase());
                        $input.val( $input.val().replace(/[^a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ0-9 _@.,;: /#+-?¡!¿°´]/g, '' ) );
                        $input.val( $input.val().replace(/[<>=´]/g, '' ) );
                    },50);
                });
                /**/
            });

function validarSinDocumentacion(idbien,tipobien)
{
    //alert('holaaa'+idbien);
  $('#divValidarSinDoc').modal('show');
  $('#btnGuardarSinDoc').prop('disabled', false);
  $("#btnGuardarSinDoc").val(idbien+" "+tipobien);
}

function btnGuardarValidacionSinDoc(){
    //alert('holaaadsdasd');
    
    $('#btnCancelarSinDoc').on('click',function(){
                $('#divValidarSinDoc').modal('hide');
           $('#btnGuardarSinDoc').prop('disabled', false);
    });
   

    $('#btnGuardarSinDoc').on('click',function(){

       // alert('holaaadsdasd');
            var urls = "";
            var cadenaValores = $(this).val().split(" ");
            var idbien = cadenaValores[0];
            var tipobien = cadenaValores[1];
            var   urls = base_url + "index.php/documentos/validarSinDoc";
           
        //console.log("idbien:"+idbien+"-tipobien:"+tipobien);
            $('#divValidarSinDoc').modal('hide');
            $('#btnGuardarSinDoc').prop('disabled', true);
            //alert(idbien +'--'+tipobien);
            $.ajax({
                type:'GET',
                url:urls,
                data: {bien: idbien,tipo: tipobien},
                success:function(data){
                    
                    if(data>0){
                        alert("Se verificó correctamente el bien sin documentación");
                         window.setTimeout('location.reload()', 500);
                        
                    }else{
                        alert("Se produjo un error, contactese con el área de sistemas "+data);
                    }
                }
            });
    });
}