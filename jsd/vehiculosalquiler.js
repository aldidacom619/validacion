var idBien;
var filatablaVehiculoAlquiler;
var idTipoDocumento;
var idDocumento;
var filaTablaDocumentoAlquiler;
var alertaValidacionVehiculoAlquiler ="";
var tablaDocValidadosVehiculosAlquiler = false;
var base_url;
function baseurl(enlace)
{
  base_url = enlace;
   //alert(base_url);
}

function cargacorrespondencia(){
    var enlace = base_url + "index.php/inmuebles/correspondeciadoc";
    $.ajax({
        type: "GET",
        url : enlace,
        success: function (data) 
        {
        $('#cbNroDocumentoOpcionVehiculoAlquilerProv').html(data); 
        $('#cbNroDocumentoVehiculoAlquilerOpcion').html(data);
        $('#cbCiudadVehiculoAlquilerOpcion').html(data);
        $('#cbDireccionVehiculoAlquilerOpcion').html(data);
        $('#cbInicioContratoVehiculoAlquilerOpcion').html(data);
        $('#cbFinContratoVehiculoAlquilerOpcion').html(data);
        $('#cbCanonVehiculoAlquilerOpcion').html(data);
        
        }
    });
}

function OperacionesTablaVehiculoAlquiler(){
    $('#tablaVehiculoAlquiler tbody').delegate("tr", "click", filaVehiculo);
}

function filaVehiculo()
{
   if(filatablaVehiculoAlquiler){
      $("td:first", filatablaVehiculoAlquiler).parent().children().each(function(){$(this).removeClass('markrow');});
   }
   filatablaVehiculoAlquiler = this;
   $("td:first", this).parent().children().each(function(){$(this).addClass('markrow');});
   var a = $("td:first", this).text();
   //var b = $("td:eq(1)", this).text();
   idBien = a;
   $('#btnGuardarValidacionVehiculoAlquiler').prop('disabled', false);
}

function botonesTablaVehiculo() {
	$(document).on("click",".linkValidacionBien",function(event){
        event.preventDefault();
		vidBien = $(this).attr("idbien");
		if(idBien==null){
            alert("Debe seleccionar un bien a validar");
		}
		else{
	
			despliegaDialogoVehiculoAlquiler();
			
		}
	});
   
}


function abrirDialogValidacionVehiculoAlquiler(idbien){
	idBien = idbien;
	if(idBien==null){
            alert("Debe seleccionar un bien a validar");
		}
	else{
			cargarTablaDocumentacion(idBien);
			despliegaDialogoVehiculoAlquiler();
			getDatosParaValidarVehiculoAlquiler(idBien);
      getDatosObservaciones();
                        $('#divDatosValidacionDocVehiculoAlquilerProvisional').hide();
					   $('#cbNroDocumentoOpcionVehiculoAlquilerProv option[value=-1]').prop('selected','selected');
					   $('#txtNroDocumentoVehiculoAlquilerObservadoProv').val('');
					   $('#divCondicionesValidacionVehiculoAlquiler').hide();
					   $('.linkResetCb').val('-1');
					   $('#divDatosValidacionVehiculoAlquiler').hide();
					   $('#divObservacionesVehiculoAlquiler').hide();
					   $('#txtListaObservacionesVehiculoAlquiler').val('');
					   $('#txtObservacionesGeneralesVehiculoAlquiler').val('');
					   $('#btnGuardarValidacionVehiculoAlquiler').prop('disabled', true);
					  // resetearCampos();
			 
	}
} 


function despliegaDialogoVehiculoAlquiler(){
   /* $('#divTablaDocumentoAlquiler').modal({
        backdrop: 'static',
        keyboard: false
    });*/
	  
	 // $('#nombreEntidad6').text('Entidad: '+nombreEntidad);
    $('#divTablaDocumentoAlquiler').modal('show');
	 $('#btnGuardarValidacionVehiculoAlquiler').prop('disabled', true);

}



function cargarTablaDocumentacion(idbien){
    idBien = idbien;

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
function marcarFilaTablaDocumentacion(){
    $('#tablaDocumentacionVehiculoAlquiler').on('click','tbody tr',filaDocumentoAlquiler); 
	 
}


function getDatosParaValidarVehiculoAlquiler(idbien){
      var enlace = base_url + "index.php/vehiculosalquiler/getDatosvehiculosalquiler";
    $.ajax({
        type: "GET",
        url: enlace,
        data: {id: idbien},
        success: function(data){
 
                var result = JSON.parse(data);
                $.each(result, function(i, datos)
                {
            
                    $("#txtIdB").val(idbien);
                    $("#txtIdBienVehiculoAlquiler").val(datos.idbien);
                    $('#txtCiudadVehiculoAlquiler').val(datos.ciudad);
                    $('#txtDireccionVehiculoAlquiler').val(datos.direccion);
                    $('#txtInicioContratoVehiculoAlquiler').val(datos.fechainicio);
                    $('#txtFinContratoVehiculoAlquiler').val(datos.fechafin);
                    $('#txtCanonVehiculoAlquiler').val(datos.canonalquiler);
                    $('#txtMensajeCabeceraVeAl').val('IdBien: '+datos.idbien+', Ciudad: '+datos.ciudad+', Ubicación: '+datos.direccion+', Fecha Inicio Contrato: '+datos.fechainicio+' Fecha Fin Contrato:'+datos.fechafin+', Canon Alquiler: '+datos.canonalquiler+'.');
               });
        }

    });  


}



 

function mostrarDatosValidacionVehiculoAlquiler(){
   var adjunto = $('#cbAdjuntaVehiculoAlquiler').val();
   var corresponde = $('#cbCorrespondeVehiculoAlquiler').val();
   var legible = $('#cbLegibleVehiculoAlquiler').val();
   if(adjunto=='t' && corresponde==1 && legible=='t'){
	  idTipoDocumento =  $('#txtTipoDocumentoVehiculoAlquiler').val();

    //alert(idTipoDocumento);
	   if(idTipoDocumento == 23)
		  $('#divDatosValidacionVehiculoAlquiler').show();
	   else
	   	 $('#divDatosValidacionDocVehiculoAlquilerProvisional').show(); 
   }
   else
   {
       $('#divDatosValidacionVehiculoAlquiler').hide();
	     $('#divDatosValidacionDocVehiculoAlquilerProvisional').hide(); 
   }
}


function verificarSeleccion(){
    $('#cbAdjuntaVehiculoAlquiler').change(function() {

        var valor = $('#cbAdjuntaVehiculoAlquiler').val();
        if(valor=='f'){
            $('#cbLegibleVehiculoAlquiler option[value="f"]').prop('selected','selected');
            $('#cbCorrespondeVehiculoAlquiler option[value="2"]').prop('selected','selected');
        }
        mostrarDatosValidacionVehiculoAlquiler();
    }); 
    $('#cbCorrespondeVehiculoAlquiler').change(function() {
        mostrarDatosValidacionVehiculoAlquiler();
    }); 
    $('#cbLegibleVehiculoAlquiler').change(function() {
        mostrarDatosValidacionVehiculoAlquiler();
    }); 
}
function verificaiddocumentoVA(iddoc){//2018 adicionado
var enlace = base_url + "index.php/vehiculosalquiler/verifiddocVA";
var result= true;
    $.ajax({
        type: "GET",
        url: enlace,
        async: false,
        data: {id: iddoc},
        success: function(data){
            if(data == 1){
                             
                             result = false;
                             
                             } else {
                                
                                result = true;
                             }
                
        }

    });

    return result;

}


function botonesDialogoVehiculoAlquilerValidacion(){
    $('#btnCerrarValidacionVehiculoAlquiler').on('click',function(){
        cancelar();
		$('#divDatosValidacionDocVehiculoAlquilerProvisional').hide();
					$('#divDatosValidacionVehiculoAlquiler').hide();
					$('#divObservacionesVehiculoAlquiler').hide();
		$('#btnGuardarValidacionVehiculoAlquiler').prop('disabled', false);
    });

	$('#btnGuardarValidacionVehiculoAlquiler').on('click',function(){
		
		//  $('#btnGuardarValidacionVehiculoAlquiler').prop('disabled', true);
      iddocVA = $('#txtIdDocumentoVehiculoAlquiler').val();
        accVA = $('#accionVehiculoAlquiler').val();
        //alert("valor del id del doc"+iddoc); 
        iddocvalidado = verificaiddocumentoVA(iddocVA);// 2018 adic
        //alert("valor de variable"+variable);
        if(iddocvalidado == true || accVA == 'editarValidacion')
        {
               


                      if(validarFormularioAV())
                      {
                          idTipoDocumento = $('#txtTipoDocumentoVehiculoAlquiler').val();
                          //alert(idTipoDocumento);
                         
                  			     // $("#txtTipoDocumentoVehiculoAlquiler").val(idTipoDocumento);
                              //$("#txtIdDocumentoVehiculoAlquiler").val(idDocumento);
                                  var datos = "";

                                //alert(idTipoDocumento);
                                
                        // alert('ffffff');
                                
                                  var enlace = base_url + "index.php/vehiculosalquiler/guardarvalidacion";
                                  var datos = $('#formularioVehiculoAlquiler').serialize();
                                  $.ajax({
                                      type: "GET",
                                      url: enlace,
                                      data: datos,
                                      success: function(data) 
                                       {
                                          //alert(data);
                                          datos=$.parseJSON(data); 
                                  //alert(datos.aux);
                                            if(datos.aux == 2)
                                              {
                                                swal("Correcto", "La modificación de verificación del documento se realizo correctamente", "success")
                                               .then((value) => {
                                                location.reload();
                                                });

                                                //alert("La modificación de verificación del documento se realizo correctamente");        
                                               } 
                                              else
                                              {
                                                //alert("La verificación del documento se realizo correctamente"); 
                                                swal("Correcto", "La verificación del documento se realizo correctamente", "success")
                                                 .then((value) => {
                                                 //location.reload();
                                                 });

                                                 $('#txtIdValidacionVA').val(datos.aux);
                                              }

                                               $('#accionVehiculoAlquiler').val('editarValidacion');
                                              
                                              $('#tablaDocumentacionVehiculoAlquiler').html(datos.tabla);


                                               if(datos.tipo == 1)
                                              {  
                                                if (datos.estado == 3)
                                                {
                                                  
                                                   var des = $('#txtMensajeCabeceraVeAl').val();
                                                  //alert(des + ' FUE VALIDADO CORRECTAMENTE');
                                                  swal("Correcto", "EL BIEN \n :"+ des + "\n\nFUE VALIDADO CORRECTAMENTE!!!", "success")
                                                   .then((value) => {
                                                    location.reload();
                                                  });

                                                  //alert('EL BIEN \n :'+ des + '\n\nFUE VALIDADO CORRECTAMENTE!!!');
                                                  //window.setTimeout('location.reload()', 500);
                                                }
                                              }


                                           
                                      }
                                    });//*/

                        }
                      else{
                          alert("Las opciones de validación:"+alertaValidacionVehiculoAlquiler  +"\n Deberán ser llenados o seleccionados");
                          alertaValidacionVehiculoAlquiler  ="";
                      }  
             
    }
    //


		
	});
	
}

function validarFormularioAV(){
    var todook = true;
    if($('#cbAdjuntaVehiculoAlquiler').val()=='-1'||$('#cbCorrespondeVehiculoAlquiler').val()=='-1'||$('#cbLegibleVehiculoAlquiler').val()=='-1')
    {
        todook = false;
        if($('#cbAdjuntaVehiculoAlquiler').val()=='-1'){
            alertaValidacionVehiculoAlquiler += "\n -adjunta";
        }
        if($('#cbCorrespondeVehiculoAlquiler').val()=='-1'){
            alertaValidacionVehiculoAlquiler += "\n -corresponde";
        }
        if($('#cbLegibleVehiculoAlquiler').val()=='-1'){
            alertaValidacionVehiculoAlquiler += "\n -legible";
        }

    }
    else{
       
        if($('#cbAdjuntaVehiculoAlquiler').val()=='t'&& $('#cbCorrespondeVehiculoAlquiler').val()== '1' && $('#cbLegibleVehiculoAlquiler').val()=='t')
        {
           //todook=false;
           
            
            var tipoDocumento = $('#txtTipoDocumentoVehiculoAlquiler').val();

          
            if(tipoDocumento==23){
            
            // todook=false;
              //alertaValidacionVehiculoAlquiler += "\n" + tipoDocumento; 
                   if($('#cbNroDocumentoVehiculoAlquilerOpcion').val()=='-1'){

                         todook=false;
                        alertaValidacionVehiculoAlquiler += "\n -Nro. Documentación";
                    }
                    
                    if($('#cbCiudadVehiculoAlquilerOpcion').val()=='-1'){

                    todook=false;
                        alertaValidacionVehiculoAlquiler += " \n -Ciudad";
                    }
                    if($('#cbDireccionVehiculoAlquilerOpcion').val()=='-1'){

                    todook=false;
                        alertaValidacionVehiculoAlquiler += " \n -Dirección";
                    }
                    if($('#cbInicioContratoVehiculoAlquilerOpcion').val()=='-1'){

                    todook=false;
                        alertaValidacionVehiculoAlquiler += " \n -Inicio Contrato";
                    }
                    if($('#cbFinContratoVehiculoAlquilerOpcion').val()=='-1'){

                    todook=false;
                        alertaValidacionVehiculoAlquiler += " \n -Conclusión Contrato";
                    }
                    if($('#cbCanonVehiculoAlquilerOpcion').val()=='-1'){

                    todook=false;
                        alertaValidacionVehiculoAlquiler += " \n -Canon Alquiler";
                    }
                

                      if($('#cbNroDocumentoVehiculoAlquilerOpcion').val()==2 && $('#txtNroDocumentoVehiculoAlquilerObservado').val() == '' ){

                         todook=false;
                        alertaValidacionVehiculoAlquiler += "\n -Nro. Documentación son obligados";
                    }
                    
                    if($('#cbCiudadVehiculoAlquilerOpcion').val()==2 && $('#txtCiudadVehiculoAlquilerObservado').val() == ''){

                    todook=false;
                        alertaValidacionVehiculoAlquiler += " \n -Ciudad son obligados"; 
                    }
                    if($('#cbDireccionVehiculoAlquilerOpcion').val()==2 && $('#txtDireccionVehiculoAlquilerObservado').val() == ''){

                    todook=false;
                        alertaValidacionVehiculoAlquiler += " \n -Dirección son obligados";
                    }
                    if($('#cbInicioContratoVehiculoAlquilerOpcion').val()==2 && $('#txtInicioContratoVehiculoAlquilerObservado').val() == ''){

                    todook=false;
                        alertaValidacionVehiculoAlquiler += " \n -Inicio Contrato son obligados";
                    }
                    if($('#cbFinContratoVehiculoAlquilerOpcion').val()==2 && $('#txtFinContratoVehiculoAlquilerObservado').val() == ''){

                    todook=false;
                        alertaValidacionVehiculoAlquiler += " \n -Conclusión Contrato son obligados";
                    }
                    if($('#cbCanonVehiculoAlquilerOpcion').val()==2 && $('#txtCanonVehiculoAlquilerObservado').val() == ''){

                    todook=false;
                        alertaValidacionVehiculoAlquiler += " \n -Canon Alquiler son obligados";
                    }
              
            }else{
                if($('#cbNroDocumentoOpcionVehiculoAlquilerProv').val()=='-1'){
                    todook=false;
                    alertaValidacionVehiculoAlquiler += "\n Nro. Documentación";
                }
            }
        }else{
             //if($('#cbAdjuntaVehiculoAlquiler').val()=='f'||$('#cbCorrespondeVehiculoAlquiler').val()=='f'||$('#cbLegibleVehiculoAlquiler').val()=='f'){
            //todook=false;
            if($('#txtListaObservacionesVehiculoAlquiler').val()=="")
            {
              todook=false;
               alertaValidacionVehiculoAlquiler += "\n -Observaciones Específicas es obligatorio"; 
            }
        }
    }
    
    return todook;
}

function cancelar(){
	resetearCampos();
    $('#divTablaDocumentoAlquiler').modal('hide');
}

function resetearCampos(){
  idBien = '';
  idTipoDocumento = '';
  $('.linkResetTxt').val('');
  $('.linkResetCb').val('-1');
  $('.linkSoloLectura').attr('readonly', true);
  $('.ocultaDiv').hide();
}



function accionComboDocumento(){
    var valor = $('#cbNroDocumentoVehiculoAlquilerOpcion').val();
        if (valor == 2){
            $('#txtNroDocumentoVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoAlquilerObservado').val('');
            $('#txtNroDocumentoVehiculoAlquilerObservado').attr('readonly', true);
        }
}

function accionComboDocumentoAux(){
	var valor = $('#cbNroDocumentoOpcionVehiculoAlquilerProv').val();
        if (valor == 2){
            $('#txtNroDocumentoVehiculoObservadoAlquilerProv').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoAlquilerObservadoProv').val('');
            $('#txtNroDocumentoVehiculoAlquilerObservadoProv').attr('readonly', true);
        }

}

function accionComboCiudadVehiculoAlquiler(){
     var valor = $('#cbCiudadVehiculoAlquilerOpcion').val();
        if (valor == 2){
            $('#txtCiudadVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtCiudadVehiculoAlquilerObservado').val('');
            $('#txtCiudadVehiculoAlquilerObservado').attr('readonly', true);
        }
}

function accionComboDireccionVehiculoAlquiler(){
		var valor = $('#cbDireccionVehiculoAlquilerOpcion').val();
        if (valor == 2){
            $('#txtDireccionVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtDireccionVehiculoAlquilerObservado').val('');
            $('#txtDireccionVehiculoAlquilerObservado').attr('readonly', true);
        }
}
function accionComboInicioContrato(){
		var valor = $('#cbInicioContratoVehiculoAlquilerOpcion').val();
        if (valor == 2){
            $('#txtInicioContratoVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtInicioContratoVehiculoAlquilerObservado').val('');
            $('#txtInicioContratoVehiculoAlquilerObservado').attr('readonly', true);
        }
}
function accionComboFinContrato(){
		var valor = $('#cbFinContratoVehiculoAlquilerOpcion').val();
        if (valor == 2){
            $('#txtFinContratoVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtFinContratoVehiculoAlquilerObservado').val('');
            $('#txtFinContratoVehiculoAlquilerObservado').attr('readonly', true);
        }
}
function accionComboCanonAlquiler(){
		var valor = $('#cbCanonVehiculoAlquilerOpcion').val();
        if (valor == 2){
            $('#txtCanonVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtCanonVehiculoAlquilerObservado').val('');
            $('#txtCanonVehiculoAlquilerObservado').attr('readonly', true);
        }
}


function eventosCombosValidacionVehiculoAlquiler(){
    $('#cbNroDocumentoVehiculoAlquilerOpcion').change(function() {
        accionComboDocumento();
    }); 
	
	$('#cbCiudadVehiculoAlquilerOpcion').change(function() {
        accionComboCiudadVehiculoAlquiler();
    });
	 
	$('#cbDireccionVehiculoAlquilerOpcion').change(function() {
        accionComboDireccionVehiculoAlquiler();
    }); 
	
	$('#cbInicioContratoVehiculoAlquilerOpcion').change(function() {
		accionComboInicioContrato();
        
    }); 
	
	$('#cbFinContratoVehiculoAlquilerOpcion').change(function() {
        accionComboFinContrato();
    }); 
	
	$('#cbCanonVehiculoAlquilerOpcion').change(function() {
        accionComboCanonAlquiler();
    }); 
	
	
	$('#cbNroDocumentoOpcionVehiculoAlquilerProv').change(function(){
        accionComboDocumentoAux();
    });

}
function limpiartodo()
{
     $("#txtTipoDocumentoVehiculoAlquiler").val('');
                      
                      $('#txtNroDocumentoVehiculoAlquiler').val('');
                      $('#txtNroDocumentoVehiculoAlquilerProv').val('');

                        $('#cbAdjuntaVehiculoAlquiler option[value="0"]').prop('selected','selected');
                        $('#cbCorrespondeVehiculoAlquiler option[value="-1"]').prop('selected','selected');
                        $('#cbLegibleVehiculoAlquiler option[value=-1]').prop('selected','selected');
                        $('#txtNroDocumentoVehiculoAlquilerObservado').val('');
                        $('#cbNroDocumentoVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtCiudadVehiculoAlquilerObservado').val('');
                        $('#cbCiudadVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtDireccionVehiculoAlquilerObservado').val('');
                        $('#cbDireccionVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtInicioContratoVehiculoAlquilerObservado').val('');
                        $('#cbInicioContratoVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtFinContratoVehiculoAlquilerObservado').val('');
                        $('#cbFinContratoVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtCanonVehiculoAlquilerObservado').val('');
                        $('#cbCanonVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        
                        $('#txtListaObservacionesVehiculoAlquiler').val('');
                      
                        $('#accionVehiculoAlquiler').val('guardarValidacion');
                        $('#cbEstadoDocumentacionVehiculoAlquiler').val('');
                        eventosCombosValidacionVehiculoAlquiler();
                          accionComboDocumento();
                          accionComboCiudadVehiculoAlquiler();
                          accionComboDireccionVehiculoAlquiler();
                          accionComboInicioContrato();
                          accionComboFinContrato();
                          accionComboCanonAlquiler();
                          accionComboDocumentoAux();
                        $('#divCondicionesValidacionVehiculoAlquiler').show();
                        $('#divDatosValidacionVehiculoAlquiler').hide();
                        $('#divObservacionesVehiculoAlquiler').hide();
                          mostrarDatosValidacionVehiculoAlquiler();
  
}
function verificarSiTieneValidacion(iddocumento)
{
 // alert(iddocumento);
 limpiartodo();
   $('#cbNroDocumentoOpcionVehiculoAlquilerProv option[value=-1]').prop('selected','selected');
   $('#txtNroDocumentoVehiculoAlquilerObservadoProv').val('');
   $('#divCondicionesValidacionVehiculoAlquiler').show();
   //

   $('#divDatosValidacionVehiculoAlquiler').hide();
   $('#divDatosValidacionDocVehiculoAlquilerProvisional').hide();
   $('#divObservacionesVehiculoAlquiler').hide();
   $('#btnGuardarValidacionVehiculoAlquiler').prop('disabled', false);
   $('#txtObservacionesGeneralesVehiculoAlquiler').val('');
   $("#txtIdDocumentoVehiculoAlquiler").val(iddocumento);//*/

    var enlace = base_url + "index.php/vehiculosalquiler/verificarValidacion";
    $.ajax({
    type: "GET",
    url : enlace,
    data: {id: iddocumento},
    success: function (data) 
    { 
   
           datos = $.parseJSON(data);
           
           //alert(datos.tienevalidacion);
            $('#tablaDocumentacionVehiculoAlquiler').html(datos.tabla);
            		   if(datos.tienevalidacion=='true')
                    {
                      
                         // alert('holas');
                          //idTipoDocumento = datos.idtipodocumento;
                          $("#txtTipoDocumentoVehiculoAlquiler").val(datos.idtipodocumento);

                          $('#txtNroDocumentoVehiculoAlquiler').val(datos.nrodoc);
                          $('#txtNroDocumentoVehiculoAlquilerProv').val(datos.nrodoc);
                          
                          $('#cbAdjuntaVehiculoAlquiler option[value="'+datos.adjunta+'"]').prop('selected','selected');
                          $('#cbCorrespondeVehiculoAlquiler').val(datos.corresponde);
                          
                          $('#cbLegibleVehiculoAlquiler option[value="'+datos.legible+'"]').prop('selected','selected');
              			      //$('#txtTipoDocumentoVehiculoAlquiler').val(idtipodocumento);

                          //alert(datos.idtipodocumento);

                          if(datos.idtipodocumento == 23 )
                          {
                                  $('#txtNroDocumentoVehiculoAlquilerObservado').val(datos.nrodocumento);
                                  $('#txtCiudadVehiculoAlquilerObservado').val(datos.departamento);
                                  $('#txtDireccionVehiculoAlquilerObservado').val(datos.direccion);
                                  $('#txtInicioContratoVehiculoAlquilerObservado').val(datos.iniciocontrato);
                                  $('#txtFinContratoVehiculoAlquilerObservado').val(datos.fincontrato);
                                  $('#txtCanonVehiculoAlquilerObservado').val(datos.canonalquiler);
    			                         $('#cbNroDocumentoVehiculoAlquilerOpcion option[value="'+datos.correctodocumento+'"]').prop('selected','selected');
                                  $('#cbCiudadVehiculoAlquilerOpcion option[value="'+datos.correctodepartamento+'"]').prop('selected','selected');
                                  $('#cbDireccionVehiculoAlquilerOpcion option[value="'+datos.correctodireccion+'"]').prop('selected','selected');
                                  $('#cbInicioContratoVehiculoAlquilerOpcion option[value="'+datos.correctoiniciocontrato+'"]').prop('selected','selected');
                                  $('#cbFinContratoVehiculoAlquilerOpcion option[value="'+datos.correctofincontrato+'"]').prop('selected','selected');
                                  $('#cbCanonVehiculoAlquilerOpcion option[value="'+datos.correctocanonalquiler+'"]').prop('selected','selected');
  			  
                    			  }
                    			  else
                            {
                                  $('#txtNroDocumentoVehiculoAlquilerObservadoProv').val(datos.nrodocumento);
                                  $('#cbNroDocumentoOpcionVehiculoAlquilerProv option[value="'+datos.correctodocumento+'"]').prop('selected','selected');	   
              			        }
                  			   $('#accionVehiculoAlquiler').val('editarValidacion');
                  			   
                           if($('#txtTipoDocumentoVehiculoAlquiler').val()==23)
                  			   {
                           		$('#cbEstadoDocumentacionVehiculoAlquiler').val(1); 
                            }
                  			   else
                			    	{ 
                              $('#cbEstadoDocumentacionVehiculoAlquiler').val(2); 
                            }
                  			   $('#txtIdValidacionVA').val(datos.idvalidacion);
                  			   $('#txtObservacionesGeneralesVehiculoAlquiler').val(datos.observaciones);
                  			   $('#txtListaObservacionesVehiculoAlquiler').val(datos.observaciondetalle);
                  			   var dataarray=datos.observaciondetalle.split("|");
                            $("#cbObservacionEspecificaVehiculoAlquiler").val(dataarray);
                            $("#cbObservacionEspecificaVehiculoAlquiler").multiselect("refresh");
                  				  
                  				  eventosCombosValidacionVehiculoAlquiler();
                  				  accionComboDocumento();
                  				  accionComboCiudadVehiculoAlquiler();
                  				  accionComboDireccionVehiculoAlquiler();
                  				  accionComboInicioContrato();
                  				  accionComboFinContrato();
                  				  accionComboCanonAlquiler();
                  				  accionComboDocumentoAux();
    				                $('#divObservacionesVehiculoAlquiler').show();
				                     var idTipoDocumento = $('#txtTipoDocumentoVehiculoAlquiler').val();
    		                     if(datos.idtipodocumento == 23)
    	       			              { 
                                    
                                    $('#divCondicionesValidacionVehiculoAlquiler').show();
                                }
                             mostrarDatosValidacionVehiculoAlquiler();
                   }
                   else
                   {
                       //idTipoDocumento = datos.idtipodocumento;
                      $("#txtTipoDocumentoVehiculoAlquiler").val(datos.idtipodocumento);
                      
                      $('#txtNroDocumentoVehiculoAlquiler').val(datos.nrodoc);
                      $('#txtNroDocumentoVehiculoAlquilerProv').val(datos.nrodoc);

                        $('#cbAdjuntaVehiculoAlquiler option[value="0"]').prop('selected','selected');
                        $('#cbCorrespondeVehiculoAlquiler option[value="-1"]').prop('selected','selected');
                        $('#cbLegibleVehiculoAlquiler option[value=-1]').prop('selected','selected');
                        $('#txtNroDocumentoVehiculoAlquilerObservado').val('');
                        $('#cbNroDocumentoVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtCiudadVehiculoAlquilerObservado').val('');
                        $('#cbCiudadVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtDireccionVehiculoAlquilerObservado').val('');
                        $('#cbDireccionVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtInicioContratoVehiculoAlquilerObservado').val('');
                        $('#cbInicioContratoVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtFinContratoVehiculoAlquilerObservado').val('');
                        $('#cbFinContratoVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtCanonVehiculoAlquilerObservado').val('');
                        $('#cbCanonVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        
                        $('#txtListaObservacionesVehiculoAlquiler').val('');
                      
                        $('#accionVehiculoAlquiler').val('guardarValidacion');
                        $('#cbEstadoDocumentacionVehiculoAlquiler').val('');
                        var x ='';
                         var dataarray=x.split("|");
                            $("#cbObservacionEspecificaVehiculoAlquiler").val(dataarray);
                            $("#cbObservacionEspecificaVehiculoAlquiler").multiselect("refresh");
                			  eventosCombosValidacionVehiculoAlquiler();
                				  accionComboDocumento();
                				  accionComboCiudadVehiculoAlquiler();
                				  accionComboDireccionVehiculoAlquiler();
                				  accionComboInicioContrato();
                				  accionComboFinContrato();
                				  accionComboCanonAlquiler();
                				  accionComboDocumentoAux();
                        $('#divCondicionesValidacionVehiculoAlquiler').show();
                        $('#divDatosValidacionVehiculoAlquiler').hide();
			                  $('#divObservacionesVehiculoAlquiler').hide();
                          mostrarDatosValidacionVehiculoAlquiler();
                  }
           }
    });
    //*/
}


function getDatosObservaciones()
{
   
     var enlace = base_url + "index.php/vehiculosalquiler/obtenerObservaciones";
    var u = '1';
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: u},
       success: function (data) {
           $('#cbObservacionEspecificaVehiculoAlquiler').html(data);
           $('#cbObservacionEspecificaVehiculoAlquiler').multiselect('rebuild');
       }
    });
} 

function opcionMultiselect(){	
  //alert('hola');
	$('#cbObservacionEspecificaVehiculoAlquiler').multiselect({
        buttonText: function(options, select) {
            if (options.length === 0) {
              $('#txtListaObservacionesVehiculoAlquiler').val('');
                return 'Ninguna opción seleccionada';
            }
            else if (options.length > 30) {
                return 'Todo ha sido seleccionado';
            }
            else {
                var labels = [];
                var valores = [];
                var listaIdObservaciones;
                options.each(function() {
                    if ($(this).attr('label') !== undefined) {
                        labels.push($(this).attr('label'));
                        valores.push($(this).val());

                    }
                    else {
                        labels.push($(this).html());
                        valores.push($(this).val());
                    }
                });
                listaIdObservaciones = valores.join("|");
                $('#txtListaObservacionesVehiculoAlquiler').val(listaIdObservaciones);
                return labels.join(', ') + ' ';
            }
        }
    });
}


function compruebaObservaciones(){
	var adjunto = $('#cbAdjuntaVehiculoAlquiler').val();
   var corresponde = $('#cbCorrespondeVehiculoAlquiler').val();
   var legible = $('#cbLegibleVehiculoAlquiler').val();
   var tipoDocumento = $('#txtTipoDocumentoVehiculoAlquiler').val();
   if(tipoDocumento==23){
       $('#cbEstadoDocumentacionVehiculoAlquiler').val(1);
   }else{
       $('#cbEstadoDocumentacionVehiculoAlquiler').val(2);   
   }
   if(adjunto=='t' && corresponde==1 && legible=='t' ){
  
      
		$('#divObservacionesVehiculoAlquiler').show();

   }else{
       //if(adjunto!=-1 || corresponde!=-1 || legible!=-1){
	   if(adjunto=='f' || corresponde==2 || legible=='f'){
           
           $('#txtNroDocumentoVehiculoAlquilerObservado').val('');
                        $('#cbNroDocumentoVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtCiudadVehiculoAlquilerObservado').val('');
                        $('#cbCiudadVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtDireccionVehiculoAlquilerObservado').val('');
                        $('#cbDireccionVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtInicioContratoVehiculoAlquilerObservado').val('');
                        $('#cbInicioContratoVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtFinContratoVehiculoAlquilerObservado').val('');
                        $('#cbFinContratoVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
                        $('#txtCanonVehiculoAlquilerObservado').val('');
                        $('#cbCanonVehiculoAlquilerOpcion option[value="-1"]').prop('selected','selected');
		   $('#divObservacionesVehiculoAlquiler').show();
       }
   }  
}


function habilitaObservaciones(){
	var primeraOpcion = 0;
	var segundaOpcion = 0;
	$('#cbNroDocumentoVehiculoAlquilerOpcion').change(function() {
 		compruebaObservaciones();
	});
	
	$('#cbCiudadVehiculoAlquilerOpcion').change(function() {
 		compruebaObservaciones();
	});

	$('#cbDireccionVehiculoAlquilerOpcion').change(function() {
 		compruebaObservaciones();
	});
	
	$('#cbInicioContratoVehiculoAlquilerOpcion').change(function() {
 		compruebaObservaciones();
	});
	
	$('#cbFinContratoVehiculoAlquilerOpcion').change(function() {
 		compruebaObservaciones();
	});
	
	$('#cbCanonVehiculoAlquilerOpcion').change(function() {
 		compruebaObservaciones();
	});
	
	
	$('#cbAdjuntaVehiculoAlquiler').change(function() {
 		compruebaObservaciones();
			
	});
	
	$('#cbCorrespondeVehiculoAlquiler').change(function() {
 		compruebaObservaciones();
		
	});
	
	$('#cbLegibleVehiculoAlquiler').change(function() {
 		compruebaObservaciones();
			
	});
	
	
	
		
}

