var idBien;
var filatablaVehiculoAlquiler;
var idTipoDocumento;
var idDocumento;
var filaTablaDocumentoAlquiler;
var alertaValidacionVehiculoAlquiler="";
var tablaDocValidadosVehiculosAlquiler = false;
var base_url;
function baseurl(enlace)
{
  base_url = enlace;
   //alert(base_url);
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
                $.each(result, function(i, datos){
            
            $("#txtIdBienVehiculoAlquiler").val(idbien);
            $('#txtCiudadVehiculoAlquiler').val(datos.ciudad);
            $('#txtDireccionVehiculoAlquiler').val(datos.direccion);
            $('#txtInicioContratoVehiculoAlquiler').val(datos.fechainicio);
            $('#txtFinContratoVehiculoAlquiler').val(datos.fechafin);
            $('#txtCanonVehiculoAlquiler').val(datos.canonalquiler);
            $('#txtMensajeCabeceraVeAl').val('IdBien: '+idbien+', Ciudad: '+datos.ciudad+', Ubicación: '+datos.direccion+', Fecha Inicio Contrato: '+datos.fechainicio+' Fecha Fin Contrato:'+datos.fechafin+', Canon Alquiler: '+datos.canon+'.');
                
           

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
        mostrarDatosValidacionVehiculoAlquiler();
    }); 
    $('#cbCorrespondeVehiculoAlquiler').change(function() {
        mostrarDatosValidacionVehiculoAlquiler();
    }); 
    $('#cbLegibleVehiculoAlquiler').change(function() {
        mostrarDatosValidacionVehiculoAlquiler();
    }); 
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
                              alert("Se realizo la modificación correctamente");        
                             } 
                            else
                            {
                              alert("Se realizo el registro correctamente"); 
                              
                               $('#txtIdValidacionVA').val(datos.aux);
                            }

                             $('#accionVehiculoAlquiler').val('editarValidacion');
                            
                            $('#tablaDocumentacionVehiculoAlquiler').html(datos.tabla);


                         
                    }
                  });//*/
               
         
		
	});
	
}

function validarFormularioAV(){
    var todook = true;
    if($('#cbAdjuntaInmuebleAlquiler').val()=='-1'||$('#cbCorrespondeInmuebleAlquiler').val()=='-1'||$('#cbLegibleInmuebleAlquiler').val()=='-1')
    {
        todook = false;
        if($('#cbAdjuntaInmuebleAlquiler').val()=='-1'){
            alertaValidacionVehiculoAlquiler += "adjunta";
        }
        if($('#cbCorrespondeInmuebleAlquiler').val()=='-1'){
            alertaValidacionVehiculoAlquiler += " corresponde";
        }
        if($('#cbLegibleInmuebleAlquiler').val()=='-1'){
            alertaValidacionVehiculoAlquiler += " legible";
        }
        if($('#cbAdjuntaInmuebleAlquiler').val()=='f'||$('#cbCorrespondeInmuebleAlquiler').val()=='1'||$('#cbLegibleInmuebleAlquiler').val()=='f'){
            if($('#txtListaObservacionesIA').val()==""){
               alertaValidacionVehiculoAlquiler += " Tipo de Observaciones"; 
            }
        }
    }
    else{
        if($('#cbAdjuntaInmuebleAlquiler').val()=='t' && $('#cbCorrespondeInmuebleAlquiler').val()=='0' && $('#cbLegibleInmuebleAlquiler').val()=='t')
        {
            var tipoDocumento = $('#txtTipoDocumentoIA').val();
            if(tipoDocumento==23){
                if($('#cbNroDocumentoIAOpcion').val()=='-1'||
                   $('#cbDepartamentoIAOpcion').val()=='-1'||
                   $('#cbDireccionIAOpcion').val()=='-1'||
                   $('#cbInicioContratoIAOpcion').val()=='-1'||
                   $('#cbConclusionContratoIAOpcion').val()=='-1'||
                   $('#cbCanonIAOpcion').val()=='-1'){
                    todook=false;
                    if($('#cbNroDocumentoIAOpcion').val()=='-1'){
                        alertaValidacionVehiculoAlquiler += "Nro. Documentación";
                    }
                    if($('#cbDepartamentoIAOpcion').val()=='-1'){
                        alertaValidacionVehiculoAlquiler += " Departamento";
                    }
                    if($('#cbDireccionIAOpcion').val()=='-1'){
                        alertaValidacionVehiculoAlquiler += " Dirección";
                    }
                    if($('#cbInicioContratoIAOpcion').val()=='-1'){
                        alertaValidacionVehiculoAlquiler += " Inicio Contrato";
                    }
                    if($('#cbConclusionContratoIAOpcion').val()=='-1'){
                        alertaValidacionVehiculoAlquiler += " Conclusión Contrato";
                    }
                    if($('#cbCanonIAOpcion').val()=='-1'){
                        alertaValidacionVehiculoAlquiler += " Canon Alquiler";
                    }
                }
            }else{
                if($('#cbNroDocumentoIAOpcionProv').val()=='-1'){
                    todook=false;
                    alertaValidacionVehiculoAlquiler += "Nro. Documentación";
                }
            }
        }else{
            if($('#txtListaObservacionesIA').val()==""){
                todook=false;
                alertaValidacionVehiculoAlquiler += " Posibles Observaciones"; 
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
        if (valor == 'f'){
            $('#txtNroDocumentoVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoAlquilerObservado').val('');
            $('#txtNroDocumentoVehiculoAlquilerObservado').attr('readonly', true);
        }
}

function accionComboDocumentoAux(){
	var valor = $('#cbNroDocumentoOpcionVehiculoAlquilerProv').val();
        if (valor == 'f'){
            $('#txtNroDocumentoVehiculoObservadoAlquilerProv').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoAlquilerObservadoProv').val('');
            $('#txtNroDocumentoVehiculoAlquilerObservadoProv').attr('readonly', true);
        }

}

function accionComboCiudadVehiculoAlquiler(){
     var valor = $('#cbCiudadVehiculoAlquilerOpcion').val();
        if (valor == 'f'){
            $('#txtCiudadVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtCiudadVehiculoAlquilerObservado').val('');
            $('#txtCiudadVehiculoAlquilerObservado').attr('readonly', true);
        }
}

function accionComboDireccionVehiculoAlquiler(){
		var valor = $('#cbDireccionVehiculoAlquilerOpcion').val();
        if (valor == 'f'){
            $('#txtDireccionVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtDireccionVehiculoAlquilerObservado').val('');
            $('#txtDireccionVehiculoAlquilerObservado').attr('readonly', true);
        }
}
function accionComboInicioContrato(){
		var valor = $('#cbInicioContratoVehiculoAlquilerOpcion').val();
        if (valor == 'f'){
            $('#txtInicioContratoVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtInicioContratoVehiculoAlquilerObservado').val('');
            $('#txtInicioContratoVehiculoAlquilerObservado').attr('readonly', true);
        }
}
function accionComboFinContrato(){
		var valor = $('#cbFinContratoVehiculoAlquilerOpcion').val();
        if (valor == 'f'){
            $('#txtFinContratoVehiculoAlquilerObservado').attr('readonly', false);
        }else{
            $('#txtFinContratoVehiculoAlquilerObservado').val('');
            $('#txtFinContratoVehiculoAlquilerObservado').attr('readonly', true);
        }
}
function accionComboCanonAlquiler(){
		var valor = $('#cbCanonVehiculoAlquilerOpcion').val();
        if (valor == 'f'){
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

function verificarSiTieneValidacion(iddocumento)
{
 // alert(iddocumento);
 
  $('#cbNroDocumentoOpcionVehiculoAlquilerProv option[value=-1]').prop('selected','selected');
   $('#txtNroDocumentoVehiculoAlquilerObservadoProv').val('');
   
   
   
   //$('#txtNroDocumentoVehiculoAlquiler').val(b);
   //$('#txtNroDocumentoVehiculoAlquilerProv').val(b);
   $('#divCondicionesValidacionVehiculoAlquiler').show();
   //$('.linkResetCb').val('-1');
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
                return 'Ninguna opción seleccionada';
            }
            else if (options.length > 5) {
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

