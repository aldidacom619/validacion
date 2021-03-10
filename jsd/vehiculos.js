
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
  //alert(base_url);
}
 function cargacorrespondenciav(){
    var enlace = base_url + "index.php/inmuebles/correspondeciadoc";
    $.ajax({
        type: "GET",
        url : enlace,
        success: function (data) {
        $('#cbNroDocumentoOpcionVehiculoProv').html(data);
        $('#cbNroDocumentoVehiculoOpcion').html(data);
        $('#cbClaseOpcion').html(data);
        $('#cbTipoVehiculoOpcion').html(data);
        $('#cbMarcaOpcion').html(data);
        $('#cbPlacaOpcion').html(data);
        $('#cbMotorOpcion').html(data);
        $('#cbChasisOpcion').html(data);
        $('#cbProcedenciaOpcion').html(data);
        $('#cbModeloOpcion').html(data);
        $('#cbColorOpcion').html(data);
        

       } 
    });
}
function abrirDialogValidacionVehiculo(idb, identidad){
    validar=1;
        if (identidad!=undefined){
          //alert(verificaEntAsignada(identidad));
          if(verificaEntAsignada(identidad) == false) 
            validar=0;//2019  
                  
            getnombre_ent(identidad);
         }
        //else 
          //alert("no existe valor de id bien");
          /* solo letras para los colores */
  if(validar==1){
        $('#txtColorVehiculoObservado').on('input', function () { 
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ ]/,'');
        });
       
       
       idBien = idb;
       
       getEstadoBien2(idb);
        $('.btnGuardarValidacionVehiculo').prop('disabled', true);
        if(idb==null)
        {
                  alert("Debe seleccionar un bien a validar");
        }
        else
        { 
            cargarTablaDocumentacionVe(idb);
            getDatosObservacionesVe();
            getDatosParaValidarVehiculo(idb);
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
 else alert("ENTIDAD NO ASIGNADA AL VALIDADOR..");    
  
} 
function getnombre_ent(ident){
    var enlace = base_url + "index.php/inicio/nombre_ent";
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: ident},
       success: function (data) {
           var result = JSON.parse(data);
                $.each(result, function(i, datos){
                  $("#nombre_entidad").html(datos.nombre);
                  if(datos.estadoentidad==1){
                      $("#btnAdicionDocumentoValidarInmueble").show();
                      $("#btnGuardarValidacionVehiculo").show();
                    }
                    else{
                      $("#btnAdicionDocumentoValidarInmueble").hide(); 
                      $("#btnGuardarValidacionVehiculo").hide();
                    }
                });
           }
    });
  
} 
function getDatosObservacionesVe(){
  
  
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


function getDatosParaValidarVehiculo(idb){//2019
 
   //enlace
    //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/vehiculos/getDatosVehiculo";

    var enlace = base_url + "index.php/vehiculos/getDatosVehiculo";

    $.ajax({
        type: "GET", 
        url: enlace,
        data: {id: idb},
        success: function(data){
 
                var result = JSON.parse(data);
                $.each(result, function(i, datos){
              $("#txtIdB").val(datos.id);
              $("#txtIdBienVehiculo").val(datos.idbien); 
              
              $('#txtTipoVehiculo').val(datos.tipobien);
              $('#txtClase').val(datos.clase);
              $('#txtMarca').val(datos.marca);
              $('#txtPlaca').val(datos.placa);
              $('#txtNumeroMotor').val(datos.nromotor);
              $('#txtNumeroChasis').val(datos.nrochasis); 
              $('#txtProcedencia').val(datos.descripcion); 
              $('#txtModelo').val(datos.modelo);
              $('#txtColor').val(datos.color);
              $('#txtMensajeCabeceraVe').val('IdBien: '+datos.idbien +', Clase: '+datos.tipobien+', Tipo Vehículo: '+datos.clase+', Marca: '+datos.marca+' Placa:'+datos.placa+', Motor: '+datos.nromotor+', Chasis: '+datos.nrochasis+', Modelo: '+datos.modelo+'.');
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
        $('#estadoBien1').html('Estado: '+data);
       }
    });
} 

function cargarTablaDocumentacionVe(idb){
    var enlace = base_url + "index.php/vehiculos/getDocumentos";
    $.ajax({
        type: "GET",
        url : enlace,
       data: {id: idb, estado: 1},
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
              $("#txtIdB").val(datos.idb);
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
              //alert(datos.nrodocumento);
              
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
                          $('#txtColorVehiculoObservado').val(datos.color);

                          $('#cbNroDocumentoVehiculoOpcion option[value="'+datos.correctodocumento+'"]').prop('selected','selected');
                          $('#cbTipoVehiculoOpcion option[value="'+datos.correctovehiculo+'"]').prop('selected','selected');
                          $('#cbClaseOpcion option[value="'+datos.correctoclase+'"]').prop('selected','selected');
                          $('#cbMarcaOpcion option[value="'+datos.correctomarca+'"]').prop('selected','selected');
                          $('#cbPlacaOpcion option[value="'+datos.correctoplaca+'"]').prop('selected','selected');
                          $('#cbMotorOpcion option[value="'+datos.correctomotor+'"]').prop('selected','selected');
                          $('#cbChasisOpcion option[value="'+datos.correctochasis+'"]').prop('selected','selected');
                          $('#cbProcedenciaOpcion option[value="'+datos.correctoprocedencia+'"]').prop('selected','selected');
                          $('#cbModeloOpcion option[value="'+datos.correctomodelo+'"]').prop('selected','selected');
                          $('#cbColorOpcion option[value="'+datos.correctocolor+'"]').prop('selected','selected');
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
                    accionComboModelo();
                    accionComboColor();

                    
                    var idTipoDocumento = $('#txtTipoDocumentoVehiculo').val();
                    if(idTipoDocumento == 4)
                    {  
                      $('#divCondicionesValidacionVehiculo').show(); 
                    }
                
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
                            accionComboModelo();
                            accionComboColor();
                             var x= '';
                            var dataarray=x.split("|");
                                  //alert(dataarray);
                                   $("#cbObservacionEspecifica").val(dataarray);
                                   $("#cbObservacionEspecifica").multiselect("refresh");

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
   if(adjunto=='t' && corresponde==1 && legible=='t')
   {
     
     if(idTipoDocumento == 4)
        $('#divDatosValidacionVehiculo').show();
     else
       $('#divDatosValidacionDocVehiculoProvisional').show(); 
   }else
   {
       $('#divDatosValidacionVehiculo').hide();
     $('#divDatosValidacionDocVehiculoProvisional').hide(); 
   }
   if (adjunto == 'f'){
   $('#cbCorrespondeVehiculo').val(2);
   $('#cbLegibleVehiculo').val('f');
   }
}

function verificarSeleccionVe(){
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
        if (valor == 2){
            $('#txtNroDocumentoVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoObservado').val('');
            $('#txtNroDocumentoVehiculoObservado').attr('readonly', true);
        }
}

function accionComboDocumentoAux(){
  var valor = $('#cbNroDocumentoOpcionVehiculoProv').val();
        if (valor == 2){
            $('#txtNroDocumentoVehiculoObservadoProv').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoObservadoProv').val('');
            $('#txtNroDocumentoVehiculoObservadoProv').attr('readonly', true);
        }

}

function accionComboTipoVehiculo(){
     var valor = $('#cbTipoVehiculoOpcion').val();
        if (valor == 2){
            $('#txtTipoVehiculoObservado').attr('readonly',false);
        }else{
            $('#txtTipoVehiculoObservado').val('');
            $('#txtTipoVehiculoObservado').attr('readonly', true);
        }
}

function accionComboClase(){
    var valor = $('#cbClaseOpcion').val();
        if (valor == 2){
            $('#txtClaseVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtClaseVehiculoObservado').val('');
            $('#txtClaseVehiculoObservado').attr('readonly', true);
        }
}
function accionComboMarca(){
    var valor = $('#cbMarcaOpcion').val();
        if (valor == 2){
            $('#txtMarcaVehiculoObservado').attr('readonly', false);            
        }else{
            $('#txtMarcaVehiculoObservado').val('');
            $('#txtMarcaVehiculoObservado').attr('readonly', true);
        }
}
function accionComboPlaca(){
    var valor = $('#cbPlacaOpcion').val();
        if (valor == 2){
            $('#txtPlacaVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtPlacaVehiculoObservado').val('');
            $('#txtPlacaVehiculoObservado').attr('readonly', true);
        }
}
function accionComboMotor(){
    var valor = $('#cbMotorOpcion').val();
        if (valor == 2){
            $('#txtNumeroMotorVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNumeroMotorVehiculoObservado').val('');
            $('#txtNumeroMotorVehiculoObservado').attr('readonly', true);
        }
}
function accionComboChasis(){
    var valor = $('#cbChasisOpcion').val();
        if (valor == 2){
            $('#txtNumeroChasisVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNumeroChasisVehiculoObservado').val('');
            $('#txtNumeroChasisVehiculoObservado').attr('readonly', true);
        }
}

function accionComboProcedencia(){
    var valor = $('#cbProcedenciaOpcion').val();
        if (valor == 2){
            $('#txtProcedenciaVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtProcedenciaVehiculoObservado').val('');
            $('#txtProcedenciaVehiculoObservado').attr('readonly', true);
        }

}
function accionComboModelo(){

  //if($('#cbModeloOpcion').val()=='f' && $('#txtModeloVehiculoObservado').val() == ''){
    var valor = $('#cbModeloOpcion').val();
        if (valor == 2){
            $('#txtModeloVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtModeloVehiculoObservado').val('');
            $('#txtModeloVehiculoObservado').attr('readonly', true);
        }

}
function accionComboColor(){

  //if($('#cbModeloOpcion').val()=='f' && $('#txtModeloVehiculoObservado').val() == ''){
    var valor = $('#cbColorOpcion').val();
   // alert(valor);
        if (valor == 2){
            $('#txtColorVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtColorVehiculoObservado').val('');
            $('#txtColorVehiculoObservado').attr('readonly', true);
        }

}

function eventosCombosValidacionVehiculo(){
    $('#cbNroDocumentoVehiculoOpcion').change(function() {
        var valor = $('#cbNroDocumentoVehiculoOpcion').val();
        if (valor == 2){
            $('#txtNroDocumentoVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNroDocumentoVehiculoObservado').val('');
            $('#txtNroDocumentoVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbTipoVehiculoOpcion').change(function() {
        var valor = $('#cbTipoVehiculoOpcion').val();
        if (valor == 2){
            $('#txtTipoVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtTipoVehiculoObservado').val('');
            $('#txtTipoVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbClaseOpcion').change(function() {
        var valor = $('#cbClaseOpcion').val();
        if (valor == 2){
            $('#txtClaseVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtClaseVehiculoObservado').val('');
            $('#txtClaseVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbMarcaOpcion').change(function() {
        var valor = $('#cbMarcaOpcion').val();
        if (valor == 2){
            $('#txtMarcaVehiculoObservado').attr('readonly', false);
            $('#txtMarcaVehiculoObservado').autocomplete({
      source: function( request, response ) {
          $.ajax({
              type: "GET",
              url: base_url+"index.php/vehiculos/getMarcasText",
              dataType: "json",
              data: {
                  term: request.term
              },
              success: function( data ) {
                  response( data );
              },
              error: function(){
              }
          });
      }
    });
        }else{
            $('#txtMarcaVehiculoObservado').val('');
            $('#txtMarcaVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbPlacaOpcion').change(function() {
        var valor = $('#cbPlacaOpcion').val();
        if (valor == 2){
            $('#txtPlacaVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtPlacaVehiculoObservado').val('');
            $('#txtPlacaVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbMotorOpcion').change(function() {
        var valor = $('#cbMotorOpcion').val();
        if (valor == 2){
            $('#txtNumeroMotorVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNumeroMotorVehiculoObservado').val('');
            $('#txtNumeroMotorVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbChasisOpcion').change(function() {
        var valor = $('#cbChasisOpcion').val();
        if (valor == 2){
            $('#txtNumeroChasisVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtNumeroChasisVehiculoObservado').val('');
            $('#txtNumeroChasisVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbProcedenciaOpcion').change(function() {
        var valor = $('#cbProcedenciaOpcion').val();
        if (valor == 2){
            $('#txtProcedenciaVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtProcedenciaVehiculoObservado').val('');
            $('#txtProcedenciaVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbModeloOpcion').change(function() {
        var valor = $('#cbModeloOpcion').val();
        if (valor == 2){
            $('#txtModeloVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtModeloVehiculoObservado').val('');
            $('#txtModeloVehiculoObservado').attr('readonly', true);
        }
    }); 
  $('#cbColorOpcion').change(function() {
        var valor = $('#cbColorOpcion').val();
        if (valor == 2){
            $('#txtColorVehiculoObservado').attr('readonly', false);
        }else{
            $('#txtColorVehiculoObservado').val('');
            $('#txtColorVehiculoObservado').attr('readonly', true);
        }
    }); 
  
  $('#cbNroDocumentoOpcionVehiculoProv').change(function(){
         var valor = $('#cbNroDocumentoOpcionVehiculoProv').val();
        if (valor == 2){
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

            $('#txtNroDocumentoVehiculoObservado').val('');
                          $('#txtTipoVehiculoObservado').val('');
                          $('#txtClaseVehiculoObservado').val('');
                          $('#txtMarcaVehiculoObservado').val('');
                          $('#txtPlacaVehiculoObservado').val('');
                          $('#txtNumeroMotorVehiculoObservado').val('');
                          $('#txtNumeroChasisVehiculoObservado').val('');
                          $('#txtProcedenciaVehiculoObservado').val('');
                          $('#txtModeloVehiculoObservado').val('');
                          $('#txtColorVehiculoObservado').val('');
                          $('#txtNroDocumentoVehiculoObservadoProv').val('');


  
$('#cbNroDocumentoOpcionVehiculoProv option[value="-1"]').prop('selected','selected');
                            $('#cbNroDocumentoVehiculoOpcion option[value="-1"]').prop('selected','selected');
                          $('#cbTipoVehiculoOpcion option[value="-1"]').prop('selected','selected');
                          $('#cbClaseOpcion option[value="-1"]').prop('selected','selected');
                          $('#cbMarcaOpcion option[value="-1"]').prop('selected','selected');
                          $('#cbPlacaOpcion option[value="-1"]').prop('selected','selected');
                          $('#cbMotorOpcion option[value="-1"]').prop('selected','selected');
                          $('#cbChasisOpcion option[value="-1"]').prop('selected','selected');
                          $('#cbProcedenciaOpcion option[value="-1"]').prop('selected','selected');
                          $('#cbModeloOpcion option[value="-1"]').prop('selected','selected');
                          $('#cbColorOpcion option[value="-1"]').prop('selected','selected');
                          accionComboDocumento();
                    accionComboDocumentoAux();
                    accionComboTipoVehiculo();
                    accionComboClase();
                    accionComboMarca();
                    accionComboPlaca();
                    accionComboMotor();
                    accionComboChasis();
                    accionComboProcedencia();
                    accionComboModelo();
                    accionComboColor();
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
function verificaiddocumentoVehiculo(iddoc){//2018 adicionado
var enlace = base_url + "index.php/vehiculos/verifiddocVehiculo";
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

function botonesDialogoVehiculoValidacion(){
        $('#btnCerrarValidacionVehiculo').on('click',function(){
            cancelar();
                    $('#divDatosValidacionDocVehiculoProvisional').hide();
                                            $('#divDatosValidacionVehiculo').hide();
                                            $('#divObservaciones').hide();
                    $('#btnGuardarValidacionVehiculo').prop('disabled', false);
        });

      $('#btnGuardarValidacionVehiculo').on('click',function(){
            //alert("hola");
            iddocvh = $('#txtIdDocumentoVehiculo').val();
            accvh = $('#accionVehiculo').val();
            //alert("valor del id del doc"+iddoc); 
            iddocvalidadovh = verificaiddocumentoVehiculo(iddocvh);// 2018 adic
            //alert("valor de variable"+variable);
            if(iddocvalidadovh == true || accvh == 'editarValidacion')
            {
            
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
                                              swal("Correcto", "La modificación de verificación del documento se realizo correctamente", "success")
                                              .then((value) => {
                                               location.reload();
                                               });

                                              //alert("La modificación de verificación del documento se realizo correctamente");        
                                            }
                                            else
                                            {
                                              
                                              swal("Correcto", "La verificación del documento se realizo correctamente", "success")
                                              .then((value) => {
                                              //location.reload();
                                              });

                                              //alert("La verificación del documento se realizo correctamente"); 
                                            }
                                            $('#txtIdValidacionVehiculo').val(datos.aux);
                                            $('#accionVehiculo').val('editarValidacion');
                                            $('#tablaDocumentacionVehiculo').html(datos.tabla);
                                          if(datos.tipo == 1)
                                          {  
                                            if (datos.estado == 3)
                                            {
                                              
                                               var des = $('#txtMensajeCabeceraVe').val();
                                              swal("Correcto", "EL BIEN \n :"+ des + "\n\nFUE VALIDADO CORRECTAMENTE!!!", "success")
                                              .then((value) => {
                                               location.reload();
                                               });
                                              //alert('EL BIEN \n :'+ des + '\n\nFUE VALIDADO CORRECTAMENTE!!!');
                                              //window.setTimeout('location.reload()', 500);
                                            }
                                          }
                                          
                                         
                                       
                                    }
                                });
                                
                              }

                          }
                          else{
                              alert(alertaValidacionVehiculo + '\n DEBEN SER LLENADOS O  SELECCIONADOS');
                          } 


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
    if($('#cbAdjuntaVehiculo').val()=='t' && $('#cbCorrespondeVehiculo').val()=='1' && $('#cbLegibleVehiculo').val()=='t')
    {
        if(tipoDocumentoVehiculo==4)
        {
          if($('#cbNroDocumentoVehiculoOpcion').val()=='-1')
          {
              todook=false;
              alertaValidacionVehiculo += ' \n -Nro. Documento,';
          }
          if($('#cbTipoVehiculoOpcion').val()=='-1'){
              todook=false;
              alertaValidacionVehiculo += ' \n -Tipo Vehículo1,';
          }
          if($('#cbClaseOpcion').val()=='-1'){
              todook=false;
              alertaValidacionVehiculo += '\n - Clase Vehículo,';
          }
          if($('#cbMarcaOpcion').val()=='-1'){
              todook=false;
              alertaValidacionVehiculo += '\n - Marca Vehículo,';
          }
          if($('#cbPlacaOpcion').val()=='-1'){
              todook=false;
              alertaValidacionVehiculo += '\n - Placa Vehículo,';
          }
          if($('#cbMotorOpcion').val()=='-1'){
              todook=false;
              alertaValidacionVehiculo += '\n - Motor,';
          }
          if($('#cbChasisOpcion').val()=='-1'){
              todook=false;
              alertaValidacionVehiculo += '\n - Chasis,';
          }
          if($('#cbProcedenciaOpcion').val()=='-1'){
              todook=false;
              alertaValidacionVehiculo += ' \n -Procedencia,';
          }
          if($('#cbModeloOpcion').val()=='-1'){
              todook=false;
              alertaValidacionVehiculo += '\n - Modelo,';
          }
          if($('#cbColorOpcion').val()=='-1'){
              todook=false;
              alertaValidacionVehiculo += '\n - Color,';
          }
          //--------------------------
          /*
          if($('#cbNroDocumentoVehiculoOpcion').val()==2 && $('#txtNroDocumentoVehiculoObservado').val() == ''){
              todook=false;
              alertaValidacionVehiculo += '\n - Nro. Documento,';
          }
          
          if($('#cbTipoVehiculoOpcion').val()==2 && $('#txtTipoVehiculoObservado').val() == ''){
              todook=false;
              alertaValidacionVehiculo += '\n -Clase Vehículo ,';
          }
          
          if($('#cbClaseOpcion').val()==2 && $('#txtClaseVehiculoObservado ').val() == ''){
              todook=false;
              alertaValidacionVehiculo += '\n - Tipo Vehículo,';
          }
          
          if($('#cbMarcaOpcion').val()==2 && $('#txtMarcaVehiculoObservado').val() == ''){
              todook=false;
              alertaValidacionVehiculo += '\n - Marca Vehículo,';
          }
          
          if($('#cbPlacaOpcion').val()==2 && $('#txtPlacaVehiculoObservado').val() == ''){
              todook=false;
              alertaValidacionVehiculo += '\n - Placa Vehículo,';
          }
          
          if($('#cbMotorOpcion').val()==2 && $('#txtNumeroMotorVehiculoObservado').val() == ''){
              todook=false;
              alertaValidacionVehiculo += '\n - Motor,';
          }
          
          if($('#cbChasisOpcion').val()==2 && $('#txtNumeroChasisVehiculoObservado').val() == ''){
              todook=false;
              alertaValidacionVehiculo += '\n - Chasis,';
          }
          
          if($('#cbProcedenciaOpcion').val()==2 && $('#txtProcedenciaVehiculoObservado').val() == ''){
              todook=false;
              alertaValidacionVehiculo += '\n - Procedencia,';
          }
          
          if($('#cbModeloOpcion').val()==2 && $('#txtModeloVehiculoObservado').val() == ''){
              todook=false;
              alertaValidacionVehiculo += '\n - Modelo,';
          }
          // validar observacion color 2018
          if($('#cbColorOpcion').val()==2 && $('#txtColorVehiculoObservado').val() == ''){
              todook=false;
              alertaValidacionVehiculo += '\n - Color,';
          }
          */
      }
      else
      {
         if($('#cbNroDocumentoOpcionVehiculoProv').val()=='-1'){
                todook=false;
                alertaValidacionVehiculo += ' Nro. Documento,';
            }
            /*
            if($('#cbNroDocumentoOpcionVehiculoProv').val()==2 && $('#txtNroDocumentoVehiculoObservadoProv').val() == '')
            {
              todook=false;
              alertaValidacionVehiculo += "\n - Nro Documento observado es obligatorio";
            }
*/
      } 
    }
    else{
         if($('#txtListaObservacionesVehiculo').val()==""){
                todook=false;
                alertaValidacionVehiculo += "\n Posibles Observaciones"; 
            }
    }
    return todook;
}

