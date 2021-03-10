//bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb alert('hola');
var base_url;
function baseurl(enlace)
{
  base_url = enlace;
 //alert(base_url);
 
}
function adicionarDocDialogValidacion(idbien,tipobien)
{
    
	alert(idbien);
	/*$('#divFormAddDoc').hide();
    $('#txtIdBienAdicionarDoc').val(idbien);
    $('#txtIdClaseDoc').val(tipobien);
    cargarTablaDocumentosAdicionados(idbien);
	$('#divEntidadPrivada').hide();
	$('#divEntidadPublica').hide();
	$('#divPersonaNatural').hide();	
	$('#txtIdDocAdd').val('');
    var enlace = base_url + "index.php/documentos/getTipoDocumentos";
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: tipobien},
       success: function (data) {
           //alert(data);
           $('#cbTipoDocumentoAdicionar').html('');
           $('#cbTipoDocumentoAdicionar').html(data);
           $('#divAnadirDocumentoValidar').modal('show');
       }
    });*/
    
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
        
		if( $('#txtIdClaseDoc').val()== 5 ||  $('#txtIdClaseDoc').val() == 7)
	        $('#accionDoc').val('nuevoDocAlquiler');
		else
			$('#accionDoc').val('nuevoDoc');
        $('#cbTipoDocumentoAdicionar option[value="-1"]').prop('selected','selected');
        $('#txtNroDocumentoAdicionar').val('');
        $('#divFormAddDoc').show();
        $('#btnGuardarAddDoc').prop('disabled', false);
    });



	$('#btnCancelarAddDoc').on('click',function(){
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
            		//$('#accionDoc').val('editarDoc');
            		$('#tablaDocumentosAdicionados').html(datos.tabla);	
                
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
                	 $('#cbTipoDocumentoAdicionar option[value="'+val.idtipodocumento+'"]').prop('selected','selected');
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



function adicionarDialogNuevaPersona(idbien,tipobien)
{
	//alert(idbien);
    limpiar_persona();
    $('#btnGuardarAddPersona').prop('disabled', true);
	$('#divFormAddPersona').hide();
    $('#txtIdBienAdicionarPersona').val(idbien);
	$('#txtClaseBien').val(tipobien);
	
	if(tipobien == 5){
    	cargarTablaPersonaAdicionadosAlquiler(idbien);
		$('#divListadoPersonaAdicionado').hide();
		$('#divListadoPersonaAdicionadoAlquiler').show();
	}
	else {
    	cargarTablaPersonaAdicionados(idbien);
		$('#divListadoPersonaAdicionado').show();
		$('#divListadoPersonaAdicionadoAlquiler').hide();
	}
	
    var enlace = base_url + "index.php/documentos/getTipoDocumentos";
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: tipobien},
       success: function (data) {
           //alert(data);
           $('#cbTipoDocumentoPropietario').html('');
            $('#cbTipoDocumentoPropietario').html(data);
            $('#divAnadirPersonasDoc').modal('show');
       }
    });
    
	//$('#divAnadirPersonasDoc').modal('show');*/
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
function cargarTablaPersonaAdicionados(idbien){

	//alert(idbien);
    var urls = "";
	urls=base_url + "index.php/documentos/listadoPersona";
    $.ajax({
        type: "GET",
        url : urls,
        data: {id: idbien},
        success: function (data) {
           // alert(data);	
            $('#tablaPersonaAdicionado').html(data);
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
                        
                        alert('SE REALIZO CORRECTAMENTE EL REGISTRO DEL DOCUMENTO');
                    }
                    else
                    {   
                        alert('SE REALIZO LA MODIFICACIÓN CORRECTAMENTE DEL DOCUMENTO');
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

        if (valor == -1){
            $('#divPersonaNatural').hide();
            $('#divEntidadPrivada').hide();
            $('#divEntidadPublica').hide();
        }
        else if (valor == 1){
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
    var   urls = base_url + "index.php/documentos/getPersona";
   
        
    $.ajax({
            type:'GET',
            url:urls,
            data: {id: idper},
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
    alert(id);
}