
var base_url;
var idEntidad;
var idBien;
var filatablaVehiculo;
var idTipoDocumento;
var idDocumento;
var alertaValidacionVehiculo="";
var tablaDocValidadosVehiculos = false;
function baseurl(enlace)
{
  base_url = enlace;
  //var  url = "<?= base_url()?>";
  //var base_url = '<?php echo base_url();?>';
  //var url = “<?php echo ; ?>” ;
  // alert(base_url);
}



function abrirDialogValidacionVehiculo(idbien){
 // alert(idbien); 
 idBien = idbien;
 getEstadoBien2(idbien);
  $('#btnGuardarValidacionVehiculo').prop('disabled', true);
  if(idBien==null)
  {
            alert("Debe seleccionar un bien a validar");
  }
  else
  {
      cargarTablaDocumentacion(idBien);
      getDatosObservaciones();
      getDatosParaValidarVehiculo(idBien);
        $('#divDatosValidacionDocVehiculoProvisional').hide();
      //cargarPantalla('contenidoDocumento','TabDocumentosVehiculos');
       $('#cbNroDocumentoOpcionVehiculoProv option[value=-1]').prop('selected','selected');
       $('#txtNroDocumentoVehiculoObservadoProv').val('');
       $('.linkResetCb').val('-1');
       $('#divDatosValidacionVehiculo').hide();
       $('#divCondicionesValidacionVehiculo').hide();
       
       $('#divObservaciones').hide();
        $('#txtListaObservacionesVehiculo').val('');
      $('#txtObservacionesGeneralesVehiculo').val('');
      
      $('#largemodalv').modal('show');
      // $('#btnGuardarValidacionVehiculo').prop('disabled', false);
  }    
  
}

function getDatosObservaciones(){
  
  
      var enlace = base_url + "index.php/vehiculos/obtenerObservaciones";
    var u = '1';
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: u},
       success: function (data) {
           $('#cbObservacionEspecifica').html(data);
           $('#cbObservacionEspecifica').multiselect('rebuild');
       }
    });
  
} 


function getDatosParaValidarVehiculo(idbien){
 
   //enlace
    //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/vehiculos/getDatosVehiculo";

    var enlace = base_url + "index.php/vehiculos/getDatosVehiculo";

    $.ajax({
        type: "GET", 
        url: enlace,
        data: {id: idbien},
        success: function(data){
 
                var result = JSON.parse(data);
                $.each(result, function(i, datos){

              $('#txtTipoVehiculo').val(datos.tipobien);
              $('#txtClase').val(datos.clase);
              $('#txtMarca').val(datos.marca);
              $('#txtPlaca').val(datos.placa);
              $('#txtNumeroMotor').val(datos.nromotor);
              $('#txtNumeroChasis').val(datos.nrochasis);
              $('#txtProcedencia').val(datos.idprocedencia);
              $('#txtModelo').val(datos.modelo);
              $('#txtMensajeCabeceraVe').val('IdBien: '+idbien+', Tipo Vehículo: '+datos.tipobien+', Clase: '+datos.clase+', Marca: '+datos.marca+' Placa:'+datos.placa+', Motor: '+datos.nromotor+', Chasis: '+datos.nrochasis+', Modelo: '+datos.modelo+'.');
                   /* 
                $('#txtSuperficieInmueble').val(val.superficieterreno);
                $('#txtDireccionInmueble').val(val.direccion+' (Zona:'+val.zona+')');
                $('#txtCatastroInmueble').val(val.nrocatastro);
                $('#txtDenominacionInmueble').val(val.denominacion);
                $('#txtMensajeCabeceraIn').val('IdBien: '+idbien+', Denominacion: '+val.denominacion+', Superficie: '+val.superficieterreno+', Dirección: '+val.direccion+' (Zona:'+val.zona+')');
                */
               });
         
        }

    });  

    
}
function getEstadoBien2(idbien){
    
    //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/vehiculos/getDatosEstado";
    var enlace = base_url + "index.php/vehiculos/getDatosEstado";
    $.ajax({
        type: "GET",
        url : enlace,
       data: {id: idbien},
        success: function (data) {
        $('#estadoBien1').text('Estado: '+data);
       }
    });
}

function cargarTablaDocumentacion(idbien){
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


function limpiarcampos()
{
        
            
              $('#cbNroDocumentoOpcionProv option[value="-1"]').prop('selected','selected');
              $('#txtNroDocumentoInmuebleObservadoProv').val('');
              $('#cbAdjuntaVehiculo option[value="0"]').prop('selected','selected');
              $('#cbCorrespondeVehiculo option[value="-1"]').prop('selected','selected');
              $('#cbLegibleVehiculo option[value=-1]').prop('selected','selected');
              $('#accionVehiculo').val('guardarValidacion');
              $('#txtListaObservacionesVehiculo').val('');
              //getDatosObservaciones();
              accionComboDocumento();
              accionComboDocumentoAux();
              accionComboTipoVehiculo();
              accionComboClase();
              accionComboMarca();
              accionComboPlaca();
              accionComboMotor();
              accionComboChasis();
              accionComboProcedencia();
              $('#divCondicionesValidacion').show();
              $('#divDatosValidacion').hide();
              $('#divObservaciones').hide();
}



function verDocumento(idDoc){
  
   //alert (numero);

 //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/vehiculos/";
 var enlace = base_url + "index.php/vehiculos/getDatosDocumento";
    $.ajax({
        type: "GET",
        url : enlace,
        data: {id: idDoc},
        success: function(data) {
            datos = $.parseJSON(data); 
              idTipoDocumento = datos.idtipodocumento;
              $("#txtTipoDocumentoVehiculo").val(datos.idtipodocumento);
              $("#txtIdBienVehiculo").val(datos.idbien);
              $('#txtNroDocumentoVehiculo').val(datos.nrodocumento);
              $('#txtNroDocumentoVehiculoProv').val(datos.nrodocumento);
              verificarSiTieneValidacion(idDoc);
        }
    });
  // alert(x);
   $('#cbNroDocumentoOpcionVehiculoProv option[value=-1]').prop('selected','selected');
   $('#txtNroDocumentoVehiculoObservadoProv').val('');
   

   
   $("#txtIdDocumentoVehiculo").val(idDoc);
   
   
   $('#divCondicionesValidacionVehiculo').show();
   $('.linkResetCb').val('-1');
   $('#divDatosValidacionVehiculo').hide();
   $('#divDatosValidacionDocVehiculoProvisional').hide();
   $('#divObservaciones').hide();
   $('#btnGuardarValidacionVehiculo').prop('disabled', false);
   //getDatosObservaciones();
   $('#txtObservacionesGeneralesVehiculo').val('');
  
}



function verificarSiTieneValidacion(idd)
{
 //alert(idd);

   limpiarcampos();

  
  
   $('#txtIdDocumentoVehiculo').val(idd);
    $('#txtListaObservacionesVehiculo').val('');
    $('#btnGuardarValidacionVehiculo').prop('disabled', false);
    
    //getDatosObservaciones();
    
   
    //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/vehiculos/";
    var enlace = base_url + "index.php/vehiculos/verificarValidacion";
    $.ajax({
        type: "GET",
        url : enlace,
       data: {id: idd},
        success: function (data) { 
          // alert(data);
           datos = $.parseJSON(data);
         // alert(datos.tienevalidacion);
         $('#tablaDocumentacionVehiculo').html(datos.tabla);
         
          if(datos.tienevalidacion=='true')
          {

                                  $('#cbAdjuntaVehiculo option[value="'+datos.adjunta+'"]').prop('selected','selected');
                                  $('#cbCorrespondeVehiculo').val(datos.corresponde);
                                  $('#cbLegibleVehiculo option[value="'+datos.legible+'"]').prop('selected','selected');
                                  if($('#txtTipoDocumentoVehiculo').val()==4)
                                  
                                  {
                                   
                                       
                                        $('#txtNroDocumentoVehiculoObservado').val(datos.nrodocumento);
                                        $('#txtTipoVehiculoObservado').val(datos.tipovehiculo);
                                        $('#txtClaseVehiculoObservado').val(datos.clase);
                                        $('#txtMarcaVehiculoObservado').val(datos.marca);
                                        $('#txtPlacaVehiculoObservado').val(datos.placa);
                                        $('#txtNumeroMotorVehiculoObservado').val(datos.nromotor);
                                        $('#txtNumeroChasisVehiculoObservado').val(datos.nrochasis);
                                        $('#txtProcedenciaVehiculoObservado').val(datos.procedencia);
                                        $('#txtModeloVehiculoObservado').val(datos.modelo);

                                        $('#cbNroDocumentoVehiculoOpcion option[value="'+datos.correctodocumento+'"]').prop('selected','selected');
                                        $('#cbTipoVehiculoOpcion option[value="'+datos.correctovehiculo+'"]').prop('selected','selected');
                                        $('#cbClaseOpcion option[value="'+datos.correctoclase+'"]').prop('selected','selected');
                                        $('#cbMarcaOpcion option[value="'+datos.correctomarca+'"]').prop('selected','selected');
                                        $('#cbPlacaOpcion option[value="'+datos.correctoplaca+'"]').prop('selected','selected');
                                        $('#cbMotorOpcion option[value="'+datos.correctomotor+'"]').prop('selected','selected');
                                        $('#cbChasisOpcion option[value="'+datos.correctochasis+'"]').prop('selected','selected');
                                        $('#cbProcedenciaOpcion option[value="'+datos.correctoprocedencia+'"]').prop('selected','selected');
                                        $('#cbModeloOpcion option[value="'+datos.correctomodelo+'"]').prop('selected','selected');
                                    }
                                    else{
                                      
                                      
                                        $('#txtNroDocumentoVehiculoObservadoProv').val(datos.nrodocumento);
                                        $('#cbNroDocumentoOpcionVehiculoProv option[value="'+datos.correctodocumento+'"]').prop('selected','selected');    
                                    }
                                  $('#accionVehiculo').val('editarValidacion');
                                  if($('#txtTipoDocumentoVehiculo').val()==4)
                                  {  
                                     $('#cbEstadoDocumentacionVehiculo').val(1);
                                  }
                                  else
                                  { 
                                     $('#cbEstadoDocumentacionVehiculo').val(2);
                                  }
                                  
                                  $('#txtIdValidacionVehiculo').val(datos.idvalidacion);
                                  $('#txtObservacionesGeneralesVehiculo').val(datos.observaciones);
                                  $('#txtListaObservacionesVehiculo').val(datos.observaciondetalle);
                                  $('#divObservaciones').show();
       
                                  var dataarray=datos.observaciondetalle.split("|");
                                  //alert(dataarray);
                                   $("#cbObservacionEspecifica").val(dataarray);
                                   $("#cbObservacionEspecifica").multiselect("refresh");

                                 
                               
                                  accionComboDocumento();
                                  accionComboDocumentoAux();
                                  accionComboTipoVehiculo();
                                  accionComboClase();
                                  accionComboMarca();
                                  accionComboPlaca();
                                  accionComboMotor();
                                  accionComboChasis();
                                  accionComboProcedencia();

                                  
                                  var idTipoDocumento = $('#txtTipoDocumentoVehiculo').val();
                                  if(idTipoDocumento == 4)
                                  {  $('#divCondicionesValidacionVehiculo').show(); }
                              
                                  mostrarDatosValidacionVehiculo();
                    }
                    else{
                           //alert(datos.tienevalidacion); 
                             $('#cbAdjuntaVehiculo option[value="0"]').prop('selected','selected');
                            $('#cbCorrespondeVehiculo option[value="-1"]').prop('selected','selected');
                            $('#cbLegibleVehiculo option[value=-1]').prop('selected','selected');
                       
                            $('#accionVehiculo').val('guardarValidacion');
                            $('#txtListaObservacionesVehiculo').val('');
                            //getDatosObservaciones();
                            accionComboDocumento();
                            accionComboDocumentoAux();
                            accionComboTipoVehiculo();
                            accionComboClase();
                            accionComboMarca();
                            accionComboPlaca();
                            accionComboMotor();
                            accionComboChasis();
                            accionComboProcedencia();
                            $('#divCondicionesValidacion').show();
                            $('#divDatosValidacion').hide();
                            $('#divObservaciones').hide();
                    }
      }
    });
//*/
   
    
}


function mostrarDatosValidacionVehiculo(){
   var adjunto = $('#cbAdjuntaVehiculo').val();
   var corresponde = $('#cbCorrespondeVehiculo').val();
   var legible = $('#cbLegibleVehiculo').val();
   if(adjunto=='t' && corresponde==1 && legible=='t'){
     //aquiiii alert(idTipoDocumento);
     if(idTipoDocumento == 4)
        $('#divDatosValidacionVehiculo').show();
     else
       $('#divDatosValidacionDocVehiculoProvisional').show(); 
   }else{
       $('#divDatosValidacionVehiculo').hide();
     $('#divDatosValidacionDocVehiculoProvisional').hide(); 
   }
   if (adjunto == 'f'){
   $('#cbCorrespondeVehiculo').val(2);
   $('#cbLegibleVehiculo').val('f');
   }
}

function verificarSeleccion(){
    $('#cbAdjuntaVehiculo').change(function() {
        mostrarDatosValidacionVehiculo();
    
    }); 
    $('#cbCorrespondeVehiculo').change(function() {
        mostrarDatosValidacionVehiculo();
    }); 
    $('#cbLegibleVehiculo').change(function() {
        mostrarDatosValidacionVehiculo();
    }); 
}
function opcionMultiselect(){ 
  //alert('hola');
  $('#cbObservacionEspecifica').multiselect({
        buttonText: function(options, select) {
            if (options.length === 0) {
              $('#txtListaObservacionesVehiculo').val('');
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
            //alert("3");
                    }
                });
                listaIdObservaciones = valores.join("|");
                $('#txtListaObservacionesVehiculo').val(listaIdObservaciones);
                return labels.join(', ') + ' ';
            }
        }
    });
}
function accionComboDocumento(){
    var valor = $('#cbNroDocumentoVehiculoOpcion').val();
        if (valor == 'f'){
            $('#txtNroDocumentoVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoObservado').val('');
            $('#txtNroDocumentoVehiculoObservado').attr('readonly', true);
        }
}

function accionComboDocumentoAux(){
  var valor = $('#cbNroDocumentoOpcionVehiculoProv').val();
        if (valor == 'f'){
            $('#txtNroDocumentoVehiculoObservadoProv').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoObservadoProv').val('');
            $('#txtNroDocumentoVehiculoObservadoProv').attr('readonly', true);
        }

}

function accionComboTipoVehiculo(){
     var valor = $('#cbTipoVehiculoOpcion').val();
        if (valor == 'f'){
            $('#txtTipoVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtTipoVehiculoObservado').val('');
            $('#txtTipoVehiculoObservado').attr('readonly', true);
        }
}

function accionComboClase(){
    var valor = $('#cbClaseOpcion').val();
        if (valor == 'f'){
            $('#txtClaseVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtClaseVehiculoObservado').val('');
            $('#txtClaseVehiculoObservado').attr('readonly', true);
        }
}
function accionComboMarca(){
    var valor = $('#cbMarcaOpcion').val();
        if (valor == 'f'){
            $('#txtMarcaVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtMarcaVehiculoObservado').val('');
            $('#txtMarcaVehiculoObservado').attr('readonly', true);
        }
}
function accionComboPlaca(){
    var valor = $('#cbPlacaOpcion').val();
        if (valor == 'f'){
            $('#txtPlacaVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtPlacaVehiculoObservado').val('');
            $('#txtPlacaVehiculoObservado').attr('readonly', true);
        }
}
function accionComboMotor(){
    var valor = $('#cbMotorOpcion').val();
        if (valor == 'f'){
            $('#txtNumeroMotorVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNumeroMotorVehiculoObservado').val('');
            $('#txtNumeroMotorVehiculoObservado').attr('readonly', true);
        }
}
function accionComboChasis(){
    var valor = $('#cbChasisOpcion').val();
        if (valor == 'f'){
            $('#txtNumeroChasisVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNumeroChasisVehiculoObservado').val('');
            $('#txtNumeroChasisVehiculoObservado').attr('readonly', true);
        }
}

function accionComboProcedencia(){
    var valor = $('#cbProcedenciaOpcion').val();
        if (valor == 'f'){
            $('#txtProcedenciaVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtProcedenciaVehiculoObservado').val('');
            $('#txtProcedenciaVehiculoObservado').attr('readonly', true);
        }

}

function eventosCombosValidacionVehiculo(){
    $('#cbNroDocumentoVehiculoOpcion').change(function() {
        var valor = $('#cbNroDocumentoVehiculoOpcion').val();
        if (valor == 'f'){
            $('#txtNroDocumentoVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoObservado').val('');
            $('#txtNroDocumentoVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbTipoVehiculoOpcion').change(function() {
        var valor = $('#cbTipoVehiculoOpcion').val();
        if (valor == 'f'){
            $('#txtTipoVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtTipoVehiculoObservado').val('');
            $('#txtTipoVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbClaseOpcion').change(function() {
        var valor = $('#cbClaseOpcion').val();
        if (valor == 'f'){
            $('#txtClaseVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtClaseVehiculoObservado').val('');
            $('#txtClaseVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbMarcaOpcion').change(function() {
        var valor = $('#cbMarcaOpcion').val();
        if (valor == 'f'){
            $('#txtMarcaVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtMarcaVehiculoObservado').val('');
            $('#txtMarcaVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbPlacaOpcion').change(function() {
        var valor = $('#cbPlacaOpcion').val();
        if (valor == 'f'){
            $('#txtPlacaVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtPlacaVehiculoObservado').val('');
            $('#txtPlacaVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbMotorOpcion').change(function() {
        var valor = $('#cbMotorOpcion').val();
        if (valor == 'f'){
            $('#txtNumeroMotorVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNumeroMotorVehiculoObservado').val('');
            $('#txtNumeroMotorVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbChasisOpcion').change(function() {
        var valor = $('#cbChasisOpcion').val();
        if (valor == 'f'){
            $('#txtNumeroChasisVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNumeroChasisVehiculoObservado').val('');
            $('#txtNumeroChasisVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbProcedenciaOpcion').change(function() {
        var valor = $('#cbProcedenciaOpcion').val();
        if (valor == 'f'){
            $('#txtProcedenciaVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtProcedenciaVehiculoObservado').val('');
            $('#txtProcedenciaVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbModeloOpcion').change(function() {
        var valor = $('#cbModeloOpcion').val();
        if (valor == 'f'){
            $('#txtModeloVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtModeloVehiculoObservado').val('');
            $('#txtModeloVehiculoObservado').attr('readonly', true);
        }
    }); 
  
  $('#cbNroDocumentoOpcionVehiculoProv').change(function(){
         var valor = $('#cbNroDocumentoOpcionVehiculoProv').val();
        if (valor == 'f'){
            $('#txtNroDocumentoVehiculoObservadoProv').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoObservadoProv').val('');
            $('#txtNroDocumentoVehiculoObservadoProv').attr('readonly', true);
        }
    });

}


function compruebaObservaciones(){
  var adjunto = $('#cbAdjuntaVehiculo').val();
   var corresponde = $('#cbCorrespondeVehiculo').val();
   var legible = $('#cbLegibleVehiculo').val();
   var tipoDocumento = $('#txtTipoDocumentoVehiculo').val();
   if(tipoDocumento==4){
       $('#cbEstadoDocumentacionVehiculo').val(1);
   }else{
       $('#cbEstadoDocumentacionVehiculo').val(2);   
   }
   if(adjunto=='t' && corresponde==1 && legible=='t' ){
        //$('#divDatosValidacion').show();
        //$('#divObservaciones').hide();
    
    $('#divObservaciones').show();
   }else{
       //if(adjunto!=-1 || corresponde!=-1 || legible!=-1){
     if(adjunto=='f' || corresponde==2 || legible=='f'){
           //$('#divDatosValidacion').hide();
       $('#divObservaciones').show();
       }
     
   }  
}

function habilitaObservaciones(){
  var primeraOpcion = 0;
  var segundaOpcion = 0;
  $('#cbNroDocumentoVehiculoOpcion').change(function() {
    compruebaObservaciones();
  });
  
  $('#cbTipoVehiculoOpcion').change(function() {
    compruebaObservaciones();
  });

  $('#cbClaseOpcion').change(function() {
    compruebaObservaciones();
  });
  
  $('#cbMarcaOpcion').change(function() {
    compruebaObservaciones();
  });
  
  $('#cbPlacaOpcion').change(function() {
    compruebaObservaciones();
  });
  
  $('#cbMotorOpcion').change(function() {
    compruebaObservaciones();
  });
  
  $('#cbChasisOpcion').change(function() {
    compruebaObservaciones();
  });
  
  $('#cbProcedenciaOpcion').change(function() {
    compruebaObservaciones();
  });
  
  $('#cbModeloOpcion').change(function() {
    compruebaObservaciones();
  });
  
  
  $('#cbAdjuntaVehiculo').change(function() {
    compruebaObservaciones();
      
  });
  
  $('#cbCorrespondeVehiculo').change(function() {
    compruebaObservaciones();
    
  });
  
  $('#cbLegibleVehiculo').change(function() {
    compruebaObservaciones();
      
  });
  
  
  
    
}


function botonesDialogoVehiculoValidacion(){
        $('#btnCerrarValidacionVehiculo').on('click',function(){
            cancelar();
                    $('#divDatosValidacionDocVehiculoProvisional').hide();
                                            $('#divDatosValidacionVehiculo').hide();
                                            $('#divObservaciones').hide();
                    $('#btnGuardarValidacionVehiculo').prop('disabled', false);
        });

      $('#btnGuardarValidacionVehiculo').on('click',function(){
            if(validarFormularioVehiculo())
            {
                //$('#btnGuardarValidacionVehiculo').prop('disabled', true);
                if(idTipoDocumento == null)
                {
                    alert("Debe Seleccionar un documento a Validar");
                }
                else
                {
                  //alert("todo bien ");  
                  $("#txtTipoDocumentoVehiculo").val(idTipoDocumento);
                    //$("#txtIdDocumentoVehiculo").val(idDocumento);
                   
                  //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/vehiculos/";
                  var enlace = base_url + "index.php/vehiculos/guardarvalidacionvehiculo";
                  var datos = $('#formularioVehiculo').serialize();
                  $.ajax({
                      type: "GET",
                      url: enlace,
                      data: datos,
                      success: function(data) 
                       {

                           datos=$.parseJSON(data); 
                            if(datos.aux == 2)
                              {
                                alert("Se realizo la modificación correctamente");        
                              }
                              else
                              {
                                $('#txtIdValidacionVehiculo').val(data.aux);
                                alert("Se realizo el registro correctamente"); 
                              }
                            
                            $('#accionVehiculo').val('editarValidacion');
                            $('#tablaDocumentacionVehiculo').html(datos.tabla);
                           
                         
                      }
                  });
                  
                }
            }
            else{
                alert(alertaValidacionVehiculo + ' deben ser seleccionados');
            }        
  });
  
}


function validarFormularioVehiculo(){
    var todook = true;
    alertaValidacionVehiculo = '';
    if($('#cbAdjuntaVehiculo').val()=='-1'){
        todook=false;
        alertaValidacionVehiculo += ' Adjunta,';
    }
    if($('#cbCorrespondeVehiculo').val()=='-1'){
        todook=false;
        alertaValidacionVehiculo += ' Corresponde,';
    }
    if($('#cbLegibleVehiculo').val()=='-1'){
        todook=false;
        alertaValidacionVehiculo += ' Legible,';
    }
    var tipoDocumentoVehiculo=$('#txtTipoDocumentoVehiculo').val();
    if(tipoDocumentoVehiculo==4){
    if($('#cbAdjuntaVehiculo').val()=='t' && $('#cbCorrespondeVehiculo').val()=='1' && $('#cbLegibleVehiculo').val()=='t'){
        if($('#cbNroDocumentoVehiculoOpcion').val()=='-1'){
            todook=false;
            alertaValidacionVehiculo += ' Nro. Documento,';
        }
        if($('#cbTipoVehiculoOpcion').val()=='-1'){
            todook=false;
            alertaValidacionVehiculo += ' Tipo Vehículo,';
        }
        if($('#cbClaseOpcion').val()=='-1'){
            todook=false;
            alertaValidacionVehiculo += ' Clase Vehículo,';
        }
        if($('#cbMarcaOpcion').val()=='-1'){
            todook=false;
            alertaValidacionVehiculo += ' Marca Vehículo,';
        }
        if($('#cbPlacaOpcion').val()=='-1'){
            todook=false;
            alertaValidacionVehiculo += ' Placa Vehículo,';
        }
        if($('#cbMotorOpcion').val()=='-1'){
            todook=false;
            alertaValidacionVehiculo += ' Motor,';
        }
        if($('#cbChasisOpcion').val()=='-1'){
            todook=false;
            alertaValidacionVehiculo += ' Chasis,';
        }
        if($('#cbProcedenciaOpcion').val()=='-1'){
            todook=false;
            alertaValidacionVehiculo += ' Procedencia,';
        }
        if($('#cbModeloOpcion').val()=='-1'){
            todook=false;
            alertaValidacionVehiculo += ' Modelo,';
        }
    }else{
    } 
    }else{
        if($('#cbAdjuntaVehiculo').val()=="f"||$('#cbCorrespondeVehiculo').val()=="2"||$('#cbLegibleVehiculo').val()=="f"){
            
        }else{
            if($('#cbNroDocumentoOpcionVehiculoProv').val()=='-1'){
                todook=false;
                alertaValidacionVehiculo += ' Nro. Documento,';
            }
        }
    }
    return todook;
}

