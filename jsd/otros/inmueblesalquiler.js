/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var idEntidad;
var idBien;
var filaTablaDocumentoIA;
var idDocumentoBienIA=null;
var alertaValidacionInmuebleAI="";
var tablaDocValidadosInmuebleAlquiler = false;
var base_url;
function baseurl(enlace)
{
  base_url = enlace;
  //var  url = "<?= base_url()?>";
  //var base_url = '<?php echo base_url();?>';
  //var url = “<?php echo ; ?>” ;
   //alert(base_url);
}
 

function cargarTablaDocumentacionIA(idbien){

    
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

function marcarFilaTablaDocumentacionIA(){
    $('#tablaDocumentacionInmuebleAlquiler').on('click','tbody tr',filaDocumentoIA); 
}

function filaDocumentoIA(){
   if(filaTablaDocumentoIA){
      $("td:first", filaTablaDocumentoIA).parent().children().each(function(){$(this).removeClass('markrow');});
   }
   filaTablaDocumentoIA = this;
   $("td:first", this).parent().children().each(function(){$(this).addClass('markrow');});
   var a = $("td:first", this).text();
   idDocumentoBienIA=a;
   $('#txtIdDocumentoIA').val(idDocumentoBienIA);
   $('#txtObservacionesInmueblesAlquiler').val('');
   $('#btnGuardarValidacionInmuebleAlquiler').prop('disabled', false);
   
   verificarSiTieneValidacionIA(a);   
}

function abrirDialogValidacionIA(idbien){
   
//alert(idbien);
  $('#txtListaObservacionesIA').val('');
   $('#txtObservacionesInmueblesAlquiler').val('');
   $('#txtIdBienInmuebleAlquiler').val(idbien);
   $('#divCondicionesValidacionIA').hide();
   $('#divDatosValidacionIA').hide(); 
   $('#divObservacionesIA').hide(); 
   $('#divDatosValidacionDocProvisionalIA').hide(); 
   $('#cbNroDocumentoIAOpcionProv option[value="-1"]').prop('selected','selected');
   $('#txtNroDocumentoIAObservadoProv').val('');
   cargarTablaDocumentacionIA(idbien);
   getDatosParaValidarIA(idbien);
   cargarComboObservacionesIA();
   
   $('#ModalInmuebleAlquilerValidar').modal('show');
}

function getDatosParaValidarIA(idbien){
    var enlace = base_url + "index.php/inmueblesalquiler/getDatosInmueblealquiler";
    $.ajax({
        type: "GET",
        url: enlace,
        data: {id: idbien},
        success: function(data){
 
                var result = JSON.parse(data);
                $.each(result, function(i, datos){
                     
            $('#txtDepartamentoIA').val(datos.departamento);
            $('#txtDireccionIA').val(datos.direccion+' (Zona:'+datos.zona+')');
            $('#txtInicioContratoIA').val(datos.fechainicio);
            $('#txtConclusionContratoIA').val(datos.fechafin);
            $('#txtCanonIA').val(datos.canonalquiler);
            $('#txtMensajeCabeceraIA').val('IdBien: '+idbien+', Departamento: '+datos.departamento+', Dirección: '+datos.direccion+' (Zona:'+datos.zona+')'+' Inicio Contrato:'+datos.fechainicio+' Fin Contrato:'+datos.fechafin+' Canon Alquiler:'+datos.canonalquiler);

               });
        }

    });  


}
function cargarComboObservacionesIA(){
     var enlace = base_url + "index.php/inmueblesalquiler/obtenerObservaciones";
    var u = '1';
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: u},
       success: function (data) {
           $('#cbObservacionesInmueblesAlquiler').html(data);
           $('#cbObservacionesInmueblesAlquiler').multiselect('rebuild');
       }
    });
    
}
function verificarSiTieneValidacionIA(iddocumento){

   $('#txtIdDocumentoIA').val(iddocumento);
   $('#txtObservacionesInmueblesAlquiler').val('');
   $('#btnGuardarValidacionInmuebleAlquiler').prop('disabled', false);
   
   
    
  //  alert(iddocumento);
      var enlace = base_url + "index.php/inmueblesalquiler/verificarValidacion";
    $.ajax({
    type: "GET",
    url : enlace,
    data: {id: iddocumento},
    success: function (data) 
    { 
   
           datos = $.parseJSON(data);
           $('#tablaDocumentacionInmuebleAlquiler').html(datos.tabla);

           if(datos.tienevalidacion=='true')
           {
              $('#txtNroDocumentoIA').val(datos.nrodoc);
              $('#txtTipoDocumentoIA').val(datos.idtipodocumento);
              $('#txtNroDocumentoIAProv').val(datos.nrodoc);
              $('#cbAdjuntaInmuebleAlquiler option[value="'+datos.adjunta+'"]').prop('selected','selected');
              $('#cbCorrespondeInmuebleAlquiler').val(datos.corresponde);
              $('#cbLegibleInmuebleAlquiler option[value="'+datos.legible+'"]').prop('selected','selected');
              $('#accionIA').val('editarValidacion');
              
              $('#txtIdValidacionIA').val(datos.idvalidacion);
              $('#txtListaObservacionesIA').val(datos.observaciondetalle);
              $('#txtObservacionesInmueblesAlquiler').val(datos.observaciones);
              $('#divCondicionesValidacionIA').show(); 
              var tipoDocumento = $('#txtTipoDocumentoIA').val();
              if(tipoDocumento==23){
                $('#txtNroDocumentoIAObservado').val(datos.nrodocumento);
                $('#cbNroDocumentoIAOpcion option[value="'+datos.correctodocumento+'"]').prop('selected','selected');
                $('#txtDepartamentoIAObservado').val(datos.departamento);
                $('#cbDepartamentoIAOpcion option[value="'+datos.correctodepartamento+'"]').prop('selected','selected');
                $('#txtDireccionIAObservado').val(datos.direccion);
                $('#cbDireccionIAOpcion option[value="'+datos.correctodireccion+'"]').prop('selected','selected');
                $('#txtInicioContratoIAObservado').val(datos.iniciocontrato);
                $('#cbInicioContratoIAOpcion option[value="'+datos.correctoiniciocontrato+'"]').prop('selected','selected');
                $('#txtConclusionContratoIAObservado').val(datos.fincontrato);
                $('#cbConclusionContratoIAOpcion option[value="'+datos.correctofincontrato+'"]').prop('selected','selected');  
                $('#txtCanonIAObservado').val(datos.canonalquiler);
                $('#cbCanonIAOpcion option[value="'+datos.correctocanonalquiler+'"]').prop('selected','selected');  
                
              }else{
                $('#txtNroDocumentoIAObservadoProv').val(datos.nrodocumento);
                $('#cbNroDocumentoIAOpcionProv option[value="'+datos.correctodocumento+'"]').prop('selected','selected');
              }
              $('#cbEstadoDocumentacionInmuebleAlquiler').val($('#txtTipoDocumentoIA').val());
              $('#txtListaObservacionesIA').val(datos.observaciondetalle);
              var dataarray=datos.observaciondetalle.split("|");
              $("#cbObservacionesInmueblesAlquiler").val(dataarray);
              $("#cbObservacionesInmueblesAlquiler").multiselect("refresh");
              estadosCombosIA();
              
              mostrarDatosValidacionIA();
           }else{
              $('#txtNroDocumentoIA').val(datos.nrodoc);
              $('#txtTipoDocumentoIA').val(datos.idtipodocumento);
              $('#txtNroDocumentoIAProv').val(datos.nrodoc); 
              $('#cbAdjuntaInmuebleAlquiler option[value="-1"]').prop('selected','selected');
              $('#cbCorrespondeInmuebleAlquiler option[value="-1"]').prop('selected','selected');
              $('#cbLegibleInmuebleAlquiler option[value=-1]').prop('selected','selected');
              $('#txtNroDocumentoIAObservado').val('');
              $('#cbNroDocumentoIAOpcion option[value="-1"]').prop('selected','selected');
              $('#txtDepartamentoIAObservado').val('');
              $('#cbDepartamentoIAOpcion option[value="-1"]').prop('selected','selected');
              $('#txtDireccionIAObservado').val('');
              $('#cbDireccionIAOpcion option[value="-1"]').prop('selected','selected');
              $('#txtInicioContratoIAObservado').val('');
              $('#cbInicioContratoIAOpcion option[value="-1"]').prop('selected','selected');
              $('#txtConclusionContratoIAObservado').val('');
              $('#cbConclusionContratoIAOpcion option[value="-1"]').prop('selected','selected');
              $('#txtCanonIAObservado').val('');
              $('#cbCanonIAOpcion option[value="-1"]').prop('selected','selected');
              $('#accionIA').val('nuevaValidacion');
               // alert(iddocumento);
              estadosCombosIA();
              $('#cbEstadoDocumentacionInmuebleAlquiler').val('');
              $('#divCondicionesValidacionIA').show();
              $('#divDatosValidacionIA').hide();
              $('#divObservacionesIA').hide();   
              $('#divDatosValidacionDocProvisionalIA').hide();
              $('#cbNroDocumentoIAOpcionProv option[value="-1"]').prop('selected','selected');
              $('#txtNroDocumentoIAObservadoProv').val('');
           }
        }
        
    });//*/
    
}
function estadosCombosIA(){
    //alert('gggggggg');
    var combo = $('#cbNroDocumentoIAOpcion');
    var cajatexto = $("#txtNroDocumentoIAObservado");
    comportamientoComboValidacionIA(combo,cajatexto);
    combo = $('#cbDepartamentoIAOpcion');
    cajatexto = $("#txtDepartamentoIAObservado");
    comportamientoComboValidacionIA(combo,cajatexto);
    combo = $('#cbDireccionIAOpcion');
    cajatexto = $("#txtDireccionIAObservado");
    comportamientoComboValidacionIA(combo,cajatexto);
    combo = $('#cbInicioContratoIAOpcion');
    cajatexto = $("#txtInicioContratoIAObservado");
    comportamientoComboValidacionIA(combo,cajatexto);
    combo = $('#cbConclusionContratoIAOpcion');
    cajatexto =  $("#txtConclusionContratoIAObservado");
    comportamientoComboValidacionIA(combo,cajatexto);
    combo = $('#cbCanonIAOpcion');
    cajatexto =  $("#txtCanonIAObservado");
    comportamientoComboValidacionIA(combo,cajatexto);
    combo = $('#cbNroDocumentoIAOpcionProv');
    cajatexto =  $("#txtNroDocumentoIAObservadoProv");
    comportamientoComboValidacionIA(combo,cajatexto); 
}
function comportamientoComboValidacionIA(elemento0,elemento1){
    
    var valor = $(elemento0).val();
    if (valor == 'f'){
        $(elemento1).attr('readonly', false);
    }else{
        $(elemento1).val('');
        $(elemento1).attr('readonly', true);
    }
}
function mostrarDatosValidacionIA(){ 

   var adjunto = $('#cbAdjuntaInmuebleAlquiler').val();
   var corresponde = $('#cbCorrespondeInmuebleAlquiler').val();
   var legible = $('#cbLegibleInmuebleAlquiler').val();
   var tipoDocumento = $('#txtTipoDocumentoIA').val();
    //alert(tipoDocumento);
   if(tipoDocumento==23){
       $('#cbEstadoDocumentacionInmuebleAlquiler').val(1);
   }else{
       $('#cbEstadoDocumentacionInmuebleAlquiler').val(2);   
   }
   if(tipoDocumento==23){
        if(adjunto=='t' && corresponde==0 && legible=='t'){
            $('#divDatosValidacionIA').show();
            $('#divDatosValidacionDocProvisionalIA').hide();
            //$('#divObservacionesIA').hide();
      $('#divObservacionesIA').show();
        }else{ 
            if(adjunto=='f' || corresponde==1 || legible=='f'){
                $('#divDatosValidacionIA').hide();
                $('#divObservacionesIA').show();  
            }
        }
   }else{
        if(adjunto=='t' && corresponde==0 && legible=='t'){
            $('#divDatosValidacionIA').hide();
            //$('#divObservacionesIA').hide();
      $('#divObservacionesIA').show();
            $('#divDatosValidacionDocProvisionalIA').show();
        }else{ 
            if(adjunto=='f' || corresponde==1 || legible=='f'){
                $('#divDatosValidacionIA').hide();
                $('#divDatosValidacionDocProvisionalIA').hide();
                $('#divObservacionesIA').show();  
            }
        } 
   }  
}
function VerificarSeleccionIA(){
    $('#cbAdjuntaInmuebleAlquiler').change(function() {
        var valor = $('#cbAdjuntaInmuebleAlquiler').val();
        if(valor=="f"){
            $('#cbLegibleInmuebleAlquiler option[value="f"]').prop('selected','selected');
            $('#cbCorrespondeInmuebleAlquiler option[value="1"]').prop('selected','selected');
        }
        mostrarDatosValidacionIA();        
    }); 
    $('#cbCorrespondeInmuebleAlquiler').change(function() {
        mostrarDatosValidacionIA();        
    }); 
    $('#cbLegibleInmuebleAlquiler').change(function() {
        mostrarDatosValidacionIA();        
    }); 
}
function comboMultiSelectIA(){
    $('#cbObservacionesInmueblesAlquiler').multiselect({
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
                $('#txtListaObservacionesIA').val(listaIdBienes);
          return labels.join(', ') + ' ';
            }
        }
    });
}
function comboMultiSelectIA(){
  
    $('#cbObservacionesInmueblesAlquiler').multiselect({
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
                $('#txtListaObservacionesIA').val(listaIdBienes);
          return labels.join(', ') + ' ';
            }
        }
    });
}
function comportamientoComboValidacion(elemento0,elemento1){
    var valor = $(elemento0).val();
    if (valor == 'f'){
        $(elemento1).attr('readonly', false);
    }else{
        $(elemento1).val('');
        $(elemento1).attr('readonly', true);
    }
    
}
function eventosCombosValidacionIA(){
    $('#cbNroDocumentoIAOpcionProv').on("change",function() {
        var cajatexto = $("#txtNroDocumentoIAObservadoProv");
        comportamientoComboValidacion(this,cajatexto);
    }); 
    
    $('#cbNroDocumentoIAOpcion').change(function() {
        var cajatexto = $("#txtNroDocumentoIAObservado");
        comportamientoComboValidacion(this,cajatexto);
    });
    
    $('#cbDepartamentoIAOpcion').change(function() {
        var cajatexto = $("#txtDepartamentoIAObservado");
        comportamientoComboValidacion(this,cajatexto);
    });
    
    $('#cbDireccionIAOpcion').change(function() {
        var cajatexto = $("#txtDireccionIAObservado");
        comportamientoComboValidacion(this,cajatexto);
    });
    
    $('#cbInicioContratoIAOpcion').change(function() {
        var cajatexto = $("#txtInicioContratoIAObservado");
        comportamientoComboValidacion(this,cajatexto);
    });
    
    $('#cbConclusionContratoIAOpcion').change(function() {
        var cajatexto = $("#txtConclusionContratoIAObservado");
        comportamientoComboValidacion(this,cajatexto);
    });
    
    $('#cbCanonIAOpcion').change(function() {
        var cajatexto = $("#txtCanonIAObservado");
        comportamientoComboValidacion(this,cajatexto);
    });
    
    
}
function botonesDialogoValidacionIA(){
    $('#btnGuardarValidacionInmuebleAlquiler').on('click',function(){
        guardarValidacionIA();
    });
    $('#btnCancelarValidacionInmuebleAlquiler').on('click',function(){
        $('#ModalInmuebleAlquilerValidar').modal('hide');
    });
}

function guardarValidacionIA(){
    if(validarFormularioAI()){
      // alert('ffffff');
      
        var enlace = base_url + "index.php/inmueblesalquiler/guardarvalidacion";
        var datos = $('#formularioValidacionInmuebleAlquiler').serialize();
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
                    
                    $('#txtIdValidacionIA').val(datos.aux);
                     alert("Se realizo el registro correctamente"); 
                  }

                   $('#accionIA').val('editarValidacion');
                   $('#tablaDocumentacionInmuebleAlquiler').html(datos.tabla);


                  
              
            }
        });
    }
    else{
        alert("Las opciones de validación: "+alertaValidacionInmuebleAI+" deberán ser seleccionados");
        alertaValidacionInmuebleAI="";
    }    
}
function pestanaValidadosIA(){
    $('#linkPestanaValidadoIA').on('click',function(){
  cargaTablaInmueblesAlquilerValidados();
        tablaDocValidadosInmuebleAlquiler=true;
    });
}
function validarFormularioAI(){
    var todook = true;
    if($('#cbAdjuntaInmuebleAlquiler').val()=='-1'||$('#cbCorrespondeInmuebleAlquiler').val()=='-1'||$('#cbLegibleInmuebleAlquiler').val()=='-1'){
        todook = false;
        if($('#cbAdjuntaInmuebleAlquiler').val()=='-1'){
            alertaValidacionInmuebleAI += "adjunta";
        }
        if($('#cbCorrespondeInmuebleAlquiler').val()=='-1'){
            alertaValidacionInmuebleAI += " corresponde";
        }
        if($('#cbLegibleInmuebleAlquiler').val()=='-1'){
            alertaValidacionInmuebleAI += " legible";
        }
        if($('#cbAdjuntaInmuebleAlquiler').val()=='f'||$('#cbCorrespondeInmuebleAlquiler').val()=='1'||$('#cbLegibleInmuebleAlquiler').val()=='f'){
            if($('#txtListaObservacionesIA').val()==""){
               alertaValidacionInmuebleAI += " Tipo de Observaciones"; 
            }
        }
    }else{
        if($('#cbAdjuntaInmuebleAlquiler').val()=='t' && $('#cbCorrespondeInmuebleAlquiler').val()=='0' && $('#cbLegibleInmuebleAlquiler').val()=='t'){
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
                        alertaValidacionInmuebleAI += "Nro. Documentación";
                    }
                    if($('#cbDepartamentoIAOpcion').val()=='-1'){
                        alertaValidacionInmuebleAI += " Departamento";
                    }
                    if($('#cbDireccionIAOpcion').val()=='-1'){
                        alertaValidacionInmuebleAI += " Dirección";
                    }
                    if($('#cbInicioContratoIAOpcion').val()=='-1'){
                        alertaValidacionInmuebleAI += " Inicio Contrato";
                    }
                    if($('#cbConclusionContratoIAOpcion').val()=='-1'){
                        alertaValidacionInmuebleAI += " Conclusión Contrato";
                    }
                    if($('#cbCanonIAOpcion').val()=='-1'){
                        alertaValidacionInmuebleAI += " Canon Alquiler";
                    }
                }
            }else{
                if($('#cbNroDocumentoIAOpcionProv').val()=='-1'){
                    todook=false;
                    alertaValidacionInmuebleAI += "Nro. Documentación";
                }
            }
        }else{
            if($('#txtListaObservacionesIA').val()==""){
                todook=false;
                alertaValidacionInmuebleAI += " Posibles Observaciones"; 
            }
        }
    }
    return todook;
}