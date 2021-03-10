/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var idEntidad;
var idBien;
var filaTablaDocumento;
var idDocumentoBien=null;
var alertaValidacionInmueble="";
var tablaDocValidadosInmuebles = false;

function cargarTablaDocumentacion(idbien){
    var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/inmuebles/getDocumentos";
    $.ajax({
        type: "GET",
        url : enlace,
       data: {id: idbien},
        success: function (data) {
        $('#tablaDocumentacionInmueble').html(data);
       }
    });
    
}
function marcarFilaTablaDocumentacion(){
    //alert('hola');
    $('#tablaDocumentacionInmueble').on('click','tbody tr',filaDocumento); 
}
function filaDocumento(){
   if(filaTablaDocumento){
      $("td:first", filaTablaDocumento).parent().children().each(function(){$(this).removeClass('markrow');});
   }
   filaTablaDocumento = this;
   $("td:first", this).parent().children().each(function(){$(this).addClass('markrow');});
   var a = $("td:first", this).text();
   idDocumentoBien=a;
   $('#txtIdDocumento').val(idDocumentoBien);
   $('#txtObservacionesInmuebles').val('');
   $('#btnGuardarValidacionInmueble').prop('disabled', false);
   cargarComboObservaciones();
   verificarSiTieneValidacion(a);   
}
function abrirDialogValidacion(idbien){
   //alert('hola');
   $('#txtListaObservaciones').val('');
   $('#txtObservacionesInmuebles').val('');
   $('#txtIdBienInmueble').val(idbien);
   $('#divCondicionesValidacion').hide();
   $('#divDatosValidacion').hide(); 
   $('#divObservacionesInmueble').hide(); 
   $('#divDatosValidacionDocProvisional').hide(); 
   $('#cbNroDocumentoOpcionProv option[value="-1"]').prop('selected','selected');
   $('#txtNroDocumentoInmuebleObservadoProv').val('');
   $('#btnGuardarValidacionInmueble').prop('disabled', true);
   cargarTablaDocumentacion(idbien);
   getDatosParaValidar(idbien);
   $('#nombreEntidad1').text('Entidad: '+nombreEntidad);
   getEstadoBien(idbien);
   $('#largeModal').modal('show');
}


function mostrarDatosValidacion(){
   var adjunto = $('#cbAdjuntaInmueble').val();
   var corresponde = $('#cbCorrespondeInmueble').val();
   var legible = $('#cbLegibleInmueble').val();
   var tipoDocumento = $('#txtTipoDocumento').val();
   
   if(tipoDocumento=='1'){
       $('#cbEstadoDocumentacionInmueble').val(1);
   }else{
       $('#cbEstadoDocumentacionInmueble').val(2);   
   }
   if(tipoDocumento==1||tipoDocumento==2){
        if(adjunto=='t' && corresponde==0 && legible=='t'){
            $('#divDatosValidacionDocProvisional').hide();
            $('#divDatosValidacion').show();
            //$('#divObservacionesInmueble').hide();
      $('#divObservacionesInmueble').show();
        }else{ 
            if(adjunto=='f' || corresponde==1 || legible=='f'){
                $('#divDatosValidacion').hide();
                $('#divObservacionesInmueble').show();  
            }
        }
   }else{
        if(adjunto=='t' && corresponde==0 && legible=='t'){
            $('#divDatosValidacionDocProvisional').show();
            $('#divDatosValidacion').hide();
            //$('#divObservacionesInmueble').hide();
      $('#divObservacionesInmueble').show();
        }else{ 
            if(adjunto=='f' || corresponde==1 || legible=='f'){
                $('#divDatosValidacion').hide();
                $('#divDatosValidacionDocProvisional').hide();
                $('#divObservacionesInmueble').show();  
            }
        } 
   } 
}
function verificarSeleccion(){
    $('#cbAdjuntaInmueble').change(function() {
        var valor = $('#cbAdjuntaInmueble').val();
        if(valor=="f"){
            $('#cbLegibleInmueble option[value="f"]').prop('selected','selected');
            $('#cbCorrespondeInmueble option[value="1"]').prop('selected','selected');
        }
        mostrarDatosValidacion();
    }); 
    $('#cbCorrespondeInmueble').change(function() {
        mostrarDatosValidacion();
    }); 
    $('#cbLegibleInmueble').change(function() {
        mostrarDatosValidacion();
    }); 
}
function eventosCombosValidacion(){
    $('#cbNroDocumentoOpcion').change(function() {
        accionComboNroDocumento();
    }); 
    $('#cbSuperficieOpcion').change(function(){
        accionComboSuperficie(); 
    });
    $('#cbDireccionOpcion').change(function(){
        accionComboDireccion();
    });
    $('#cbCatastroOpcion').change(function(){
        accionComboCatastro();
    });
    $('#cbDenominacionOpcion').change(function(){
        accionComboDenominacion();
    });
    $('#cbNroDocumentoOpcionProv').change(function(){
        accionComboNroDocumentoProv();
    });
}
function accionComboNroDocumentoProv(){
    var valor = $('#cbNroDocumentoOpcionProv').val();
    if (valor == 'f'){
        $('#txtNroDocumentoInmuebleObservadoProv').attr('readonly', false);
    }else{
        $('#txtNroDocumentoInmuebleObservadoProv').val('');
        $('#txtNroDocumentoInmuebleObservadoProv').attr('readonly', true);
    }
}
function accionComboNroDocumento(){
    var valor = $('#cbNroDocumentoOpcion').val();
    if (valor == 'f'){
        $('#txtNroDocumentoInmuebleObservado').attr('readonly', false);
    }else{
        $('#txtNroDocumentoInmuebleObservado').val('');
        $('#txtNroDocumentoInmuebleObservado').attr('readonly', true);
    }
}
function accionComboSuperficie(){
    var valor = $('#cbSuperficieOpcion').val();
    if (valor == 'f'){
        $('#txtSuperficieInmuebleObservado').attr('readonly', false);
    }else{
        $('#txtSuperficieInmuebleObservado').val('');
        $('#txtSuperficieInmuebleObservado').attr('readonly', true);
    }
}
function accionComboDireccion(){
    var valor = $('#cbDireccionOpcion').val();
    if (valor == 'f'){
        $('#txtDireccionInmuebleObservado').attr('readonly', false);
    }else{
        $('#txtDireccionInmuebleObservado').val('');
        $('#txtDireccionInmuebleObservado').attr('readonly', true);
    } 
}
function accionComboCatastro(){
    var valor = $('#cbCatastroOpcion').val();
    if (valor == 'f'){
        $('#txtCatastroInmuebleObservado').attr('readonly', false);
    }else{
        $('#txtCatastroInmuebleObservado').val('');
        $('#txtCatastroInmuebleObservado').attr('readonly', true);
    }
}
function accionComboDenominacion(){
    var valor = $('#cbDenominacionOpcion').val();
    if (valor == 'f'){
        $('#txtDenominacionInmuebleObservado').attr('readonly', false);
    }else{
        $('#txtDenominacionInmuebleObservado').val('');
        $('#txtDenominacionInmuebleObservado').attr('readonly', true);
    }
}
    function botonesDialogoValidacion(){
        $('#btnGuardarValidacionInmueble').on('click',function(){
            guardarValidacion();
        });
        $('#cancelarValidacionInmueble').on('click',function(){
            $('#largeModal').modal('hide');
        });

    }

function getDatosParaValidar(idbien){
 
   
    var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/inmuebles/getDatosInmueble";
    $.ajax({
        type: "GET",
        url: enlace,
        data: {id: idbien},
        success: function(data){
 
      var result = JSON.parse(data);
      $.each(result, function(i, val){
                $('#txtSuperficieInmueble').val(val.superficieterreno);
                $('#txtDireccionInmueble').val(val.direccion+' (Zona:'+val.zona+')');
                $('#txtCatastroInmueble').val(val.nrocatastro);
                $('#txtDenominacionInmueble').val(val.denominacion);
        $('#txtMensajeCabeceraIn').val('IdBien: '+idbien+', Denominacion: '+val.denominacion+', Superficie: '+val.superficieterreno+', Dirección: '+val.direccion+' (Zona:'+val.zona+')');

       });
        }

    });
}

function getDatosDocumento(idDocumento){
    var url = "controladores/controlador.inmuebles.php";
    $.ajax({
        type: "GET",
        url : url,
        data: "accion=getDatosDocumento&iddocumento="+idDocumento,
        success: function (data) {
            datos = $.parseJSON(data);
            $('#txtNroDocumentoInmueble').val(datos.nrodocumento);
            $('#txtTipoDocumento').val(datos.idtipodocumento);
            $('#txtNroDocumentoInmuebleProv').val(datos.nrodocumento);
            
        }
    });
}
function verificarSiTieneValidacion(iddocumento){
    var url = "controladores/controlador.inmuebles.php";
    $.ajax({
        type: "GET",
        url : url,
        data: "accion=verificarValidacion&iddocumento="+iddocumento,
        success: function (data) {
           datos = $.parseJSON(data);
           if(datos.tienevalidacion=='true')
           {
              $('#txtNroDocumentoInmueble').val(datos.nrodoc);
              $('#txtTipoDocumento').val(datos.idtipodocumento);
              $('#txtNroDocumentoInmuebleProv').val(datos.nrodoc);
              $('#cbAdjuntaInmueble option[value="'+datos.adjunta+'"]').prop('selected','selected');
              $('#cbCorrespondeInmueble').val(datos.corresponde);
              $('#cbLegibleInmueble option[value="'+datos.legible+'"]').prop('selected','selected');
              $('#accion').val('editarValidacion');
              $('#txtIdValidacion').val(datos.idvalidacion);
              $('#txtListaObservaciones').val(datos.observaciondetalle);
              $('#txtObservacionesInmuebles').val(datos.observaciones);
              $('#divCondicionesValidacion').show(); 
              var tipoDocumento = $('#txtTipoDocumento').val();
              if(tipoDocumento==1 || tipoDocumento==2){
                $('#txtNroDocumentoInmuebleObservado').val(datos.nrodocumento);
                $('#cbNroDocumentoOpcion option[value="'+datos.correctodocumento+'"]').prop('selected','selected');
                $('#txtSuperficieInmuebleObservado').val(datos.superficieterreno);
                $('#cbSuperficieOpcion option[value="'+datos.correctosupterreno+'"]').prop('selected','selected');
                $('#txtDireccionInmuebleObservado').val(datos.direccion);
                $('#cbDireccionOpcion option[value="'+datos.correctadireccion+'"]').prop('selected','selected');
                $('#txtCatastroInmuebleObservado').val(datos.catastro);
                $('#cbCatastroOpcion option[value="'+datos.correctocatastro+'"]').prop('selected','selected');
                $('#txtDenominacionInmuebleObservado').val(datos.denominacion);
                $('#cbDenominacionOpcion option[value="'+datos.correctodenominacion+'"]').prop('selected','selected');  
              }else{
                $('#txtNroDocumentoInmuebleObservadoProv').val(datos.nrodocumento);
                $('#cbNroDocumentoOpcionProv option[value="'+datos.correctodocumento+'"]').prop('selected','selected');
              }
              $('#cbEstadoDocumentacionInmueble').val($('#txtTipoDocumento').val());
              var dataarray=datos.observaciondetalle.split("|");
              $("#cbObservacionesInmuebles").val(dataarray);
              $("#cbObservacionesInmuebles").multiselect("refresh");
              accionComboNroDocumentoProv();
              accionComboNroDocumento();
              accionComboSuperficie();
              accionComboDireccion();
              accionComboCatastro();
              accionComboDenominacion();
              mostrarDatosValidacion();
           }else{
              $('#txtNroDocumentoInmueble').val(datos.nrodoc);
              $('#txtTipoDocumento').val(datos.idtipodocumento);
              $('#txtNroDocumentoInmuebleProv').val(datos.nrodoc); 
              $('#cbAdjuntaInmueble option[value="-1"]').prop('selected','selected');
              $('#cbCorrespondeInmueble option[value="-1"]').prop('selected','selected');
              $('#cbLegibleInmueble option[value=-1]').prop('selected','selected');
              $('#txtNroDocumentoInmuebleObservado').val('');
              $('#cbNroDocumentoOpcion option[value="-1"]').prop('selected','selected');
              $('#txtSuperficieInmuebleObservado').val('');
              $('#cbSuperficieOpcion option[value="-1"]').prop('selected','selected');
              $('#txtDireccionInmuebleObservado').val('');
              $('#cbDireccionOpcion option[value="-1"]').prop('selected','selected');
              $('#txtCatastroInmuebleObservado').val('');
              $('#cbCatastroOpcion option[value="-1"]').prop('selected','selected');
              $('#txtDenominacionInmuebleObservado').val('');
              $('#cbDenominacionOpcion option[value="-1"]').prop('selected','selected');
              $('#accion').val('nuevaValidacion');
              accionComboNroDocumentoProv();
              accionComboNroDocumento();
              accionComboSuperficie(); 
              accionComboDireccion();
              accionComboCatastro();
              accionComboDenominacion();
              $('#cbEstadoDocumentacionInmueble').val('');
              $('#divCondicionesValidacion').show();
              $('#divDatosValidacion').hide();
              $('#divObservacionesInmueble').hide();   
              $('#divDatosValidacionDocProvisional').hide();
              $('#cbNroDocumentoOpcionProv option[value="-1"]').prop('selected','selected');
              $('#txtNroDocumentoInmuebleObservadoProv').val('');
           }
        }
        
    });
    
}
function guardarValidacion(){
    if(validarFormulario()){
        $('#btnGuardarValidacionInmueble').prop('disabled', true);
        var url = "controladores/controlador.inmuebles.php";
        var datos = $('#formularioValidacionInmueble').serialize();
        $.ajax({
            type: "GET",
            url: url,
            data: datos,
            success: function(data) {
        if (data == -1){
          alert("vuelva a iniciar sesion");
          window.location.href = "index.php";
        } else{
          if(data>0){
            alert("El documento fue validado correctamente");
            $('#tablaDocumentacionInmueble').dataTable().fnDraw();
            $('#tablaInmueble').dataTable().fnDraw();
            if(tablaDocValidadosInmuebles==true){
               $('#tablaInmuebleValidados').dataTable().fnDraw();
            }
            //
          }else{
            alert("Se produjo un error al validar el documento, favor comunicarse con el Area de Sistemas")
          }
        }
            }
        });
    }else{
        alert("Las opcciones de validación: "+alertaValidacionInmueble+" deberán ser seleccionados");
        alertaValidacionInmueble="";
    }    
}

function cargarComboObservaciones(){
    var url = "controladores/controlador.inmuebles.php";
    $.ajax({
       type: "GET",
       url: url,
       data: "accion=obtenerObservaciones",
       success: function (data) {
           $('#cbObservacionesInmuebles').html(data);
           $('#cbObservacionesInmuebles').multiselect('rebuild');
       }
    });
    
}
function comboMultiSelect(){
    $('#cbObservacionesInmuebles').multiselect({
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
                var listaIdBienes;
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
                listaIdBienes = valores.join("|");
                $('#txtListaObservaciones').val(listaIdBienes);
          return labels.join(', ') + ' ';
            }
        }
    });
}

function validarFormulario(){
    var todook = true;
    if($('#cbAdjuntaInmueble').val()=='-1'||$('#cbCorrespondeInmueble').val()=='-1'||$('#cbLegibleInmueble').val()=='-1'){
        todook = false;
        if($('#cbAdjuntaInmueble').val()=='-1'){
            alertaValidacionInmueble += "adjunta";
        }
        if($('#cbCorrespondeInmueble').val()=='-1'){
            alertaValidacionInmueble += " corresponde";
        }
        if($('#cbLegibleInmueble').val()=='-1'){
            alertaValidacionInmueble += " legible";
        }
        if($('#cbAdjuntaInmueble').val()=='f'||$('#cbCorrespondeInmueble').val()=='1'||$('#cbLegibleInmueble').val()=='f'){
            if($('#txtListaObservaciones').val()==""){
               alertaValidacionInmueble += " Tipo de Observaciones"; 
            }
        }
    }else{
        if($('#cbAdjuntaInmueble').val()=='t' && $('#cbCorrespondeInmueble').val()=='0' && $('#cbLegibleInmueble').val()=='t'){
            var tipoDocumento = $('#txtTipoDocumento').val();
            if(tipoDocumento==1 || tipoDocumento==2){
                if($('#cbNroDocumentoOpcion').val()=='-1'||
                   $('#cbSuperficieOpcion').val()=='-1'||
                   $('#cbDireccionOpcion').val()=='-1'||
                   $('#cbCatastroOpcion').val()=='-1'||
                   $('#cbDenominacionOpcion').val()=='-1'){
                    todook=false;
                    if($('#cbNroDocumentoOpcion').val()=='-1'){
                        alertaValidacionInmueble += "Nro. Documentación";
                    }
                    if($('#cbSuperficieOpcion').val()=='-1'){
                        alertaValidacionInmueble += " Superficie ";
                    }
                    if($('#cbDireccionOpcion').val()=='-1'){
                        alertaValidacionInmueble += " Dirección";
                    }
                    if($('#cbCatastroOpcion').val()=='-1'){
                        alertaValidacionInmueble += " Catastro";
                    }
                    if($('#cbDenominacionOpcion').val()=='-1'){
                        alertaValidacionInmueble += " Denominación";
                    }
                }
            }else{
                if($('#cbNroDocumentoOpcionProv').val()=='-1'){
                    todook=false;
                    alertaValidacionInmueble += "Nro. Documentación";
                }
            }
        }else{
            if($('#txtListaObservaciones').val()==""){
                todook=false;
                alertaValidacionInmueble += " Posibles Observaciones"; 
            }
        }
    }
    return todook;
}
function pestanaValidados(){
    $('#linkPestanaValidado').on('click',function(){
  cargaTablaInmueblesValidados(); 
        tablaDocValidadosInmuebles=true;
    });
}


function getEstadoBien(idbien){
    var url = "controladores/controlador.inmuebles.php";
    $.ajax({
        type: "GET",
        url : url,
        data: "accion=getEstadoBien&idbien="+idbien,
        success: function (data) {
        $('#estadoBien1').text('Estado: '+data);
       }
    });
}

