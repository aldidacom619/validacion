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
 
function cargacorrespondencia(){
    var enlace = base_url + "index.php/inmuebles/correspondeciadoc";
    $.ajax({
        type: "GET",
        url : enlace,
        success: function (data) 
        {
        $('#cbNroDocumentoIAOpcionProv').html(data); 
        $('#cbNroDocumentoIAOpcion').html(data);
        $('#cbDepartamentoIAOpcion').html(data);
        $('#cbDireccionIAOpcion').html(data);
        $('#cbInicioContratoIAOpcion').html(data);
        $('#cbConclusionContratoIAOpcion').html(data);
        $('#cbCanonIAOpcion').html(data);
        
        }
    });
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
   $('#txtIdB').val(idbien);
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
            $('#txtDireccionIA').val(datos.direccion);
            $('#txtInicioContratoIA').val(datos.fechainicio);
            $('#txtConclusionContratoIA').val(datos.fechafin);
            $('#txtCanonIA').val(datos.canonalquiler);
            $('#txtIdBienInmuebleAlquiler').val(datos.idbien);
            $('#txtMensajeCabeceraIA').val('IdBien: '+datos.idbien+', Departamento: '+datos.departamento+', Dirección: '+datos.direccion+' Inicio Contrato:'+datos.fechainicio+' Fin Contrato:'+datos.fechafin+' Canon Alquiler:'+datos.canonalquiler);

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
function limpiartodo()
 {
  //$('#txtNroDocumentoIA').val(datos.nrodoc);
              $('#txtTipoDocumentoIA').val('');
              $('#txtNroDocumentoIAProv').val(''); 
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
              $('#txtListaObservacionesIA').val('');
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
function verificarSiTieneValidacionIA(iddocumento){

   $('#txtIdDocumentoIA').val(iddocumento);
   $('#txtObservacionesInmueblesAlquiler').val('');
   $('#btnGuardarValidacionInmuebleAlquiler').prop('disabled', false);
   
   limpiartodo();
    
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
              if(tipoDocumento==23)
              {
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
               var x = '';
                var dataarray=x.split("|");
              $("#cbObservacionesInmueblesAlquiler").val(dataarray);
              $("#cbObservacionesInmueblesAlquiler").multiselect("refresh");


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
    if (valor == 2){
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
/*function comboMultiSelectIA(){
    $('#cbObservacionesInmueblesAlquiler').multiselect({
        buttonText: function(options, select) {
            if (options.length === 0) {

                //$('#txtListaObservacionesIA').val('sss');
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
}*/
function comboMultiSelectIA(){
  
    $('#cbObservacionesInmueblesAlquiler').multiselect({
        buttonText: function(options, select) {
            if (options.length === 0) {
               $('#txtListaObservacionesIA').val('');
                return 'Ninguna opción seleccionada';
            }
            else if (options.length > 30) {
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
    if (valor == 2){
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
function verificaiddocumentoIA(iddoc){//2018 adicionado
var enlace = base_url + "index.php/inmueblesalquiler/verifiddocIA";
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


function botonesDialogoValidacionIA(){
    $('#btnGuardarValidacionInmuebleAlquiler').on('click',function(){
        iddocIA = $('#txtIdDocumentoIA').val();
        accIA = $('#accionIA').val();
        //alert("valor del id del doc"+iddoc); 
        iddocvalidado = verificaiddocumentoIA(iddocIA);// 2018 adic
        //alert("valor de variable"+variable);
        if(iddocvalidado == true || accIA == 'editarValidacion')
        {
         guardarValidacionIA();//2018 
        }


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

               // alert(datos.estado);
                
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

                    $('#txtIdValidacionIA').val(datos.aux);
                     //alert("La verificación del documento se realizo correctamente"); 
                  }

                   $('#accionIA').val('editarValidacion');
                   $('#tablaDocumentacionInmuebleAlquiler').html(datos.tabla);
                    if(datos.tipo == 1)
                    {  
                      if (datos.estado == 3)
                      {
                        
                         var des = $('#txtMensajeCabeceraIA').val();
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
        });
    }
    else{
        alert("Las opciones de validación: "+alertaValidacionInmuebleAI+"\n Deberán ser llenados o seleccionados");
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
            alertaValidacionInmuebleAI += "\n -adjunta";
        }
        if($('#cbCorrespondeInmuebleAlquiler').val()=='-1'){
            alertaValidacionInmuebleAI += "\n -corresponde";
        }
        if($('#cbLegibleInmuebleAlquiler').val()=='-1'){
            alertaValidacionInmuebleAI += "\n -legible";
        }
        if($('#cbAdjuntaInmuebleAlquiler').val()=='f'||$('#cbCorrespondeInmuebleAlquiler').val()=='1'||$('#cbLegibleInmuebleAlquiler').val()=='f'){
            if($('#txtListaObservacionesIA').val()==""){
               alertaValidacionInmuebleAI += "\n -Tipo de Observaciones"; 
            }
        }
    }else{
        if($('#cbAdjuntaInmuebleAlquiler').val()=='t' && $('#cbCorrespondeInmuebleAlquiler').val()=='0' && $('#cbLegibleInmuebleAlquiler').val()=='t'){
            var tipoDocumento = $('#txtTipoDocumentoIA').val();
            if(tipoDocumento==23){
              
                   
                    if($('#cbNroDocumentoIAOpcion').val()=='-1'){
                       todook=false;
                        alertaValidacionInmuebleAI += "\n -Nro. Documentación";
                    }
                    if($('#cbDepartamentoIAOpcion').val()=='-1'){
                       todook=false;
                        alertaValidacionInmuebleAI += "\n -Departamento";
                    }
                    if($('#cbDireccionIAOpcion').val()=='-1'){
                       todook=false;
                        alertaValidacionInmuebleAI += "\n -Dirección";
                    }
                    if($('#cbInicioContratoIAOpcion').val()=='-1'){
                       todook=false;
                        alertaValidacionInmuebleAI += "\n -Inicio Contrato";
                    }
                    if($('#cbConclusionContratoIAOpcion').val()=='-1'){
                       todook=false;
                        alertaValidacionInmuebleAI += "\n -Conclusión Contrato";
                    }
                    if($('#cbCanonIAOpcion').val()=='-1'){
                       todook=false;
                        alertaValidacionInmuebleAI += "\n -Canon Alquiler";
                    }

                    /*
                    if($('#cbNroDocumentoIAOpcion').val()==2 && $('#txtNroDocumentoIAObservado').val() == '' ){
                      todook=false;
                        alertaValidacionInmuebleAI += "\n -Nro. Documentación es Obligatorio";
                    }
                    if($('#cbDepartamentoIAOpcion').val()==2 && $('#txtDepartamentoIAObservado').val() == '' ){
                      todook=false;
                        alertaValidacionInmuebleAI += "\n -Departamento es Obligatorio";
                    }
                    if($('#cbDireccionIAOpcion').val()==2 && $('#txtDireccionIAObservado').val() == '' ){
                      todook=false;
                        alertaValidacionInmuebleAI += "\n -Dirección es Obligatorio";
                    }
                    if($('#cbInicioContratoIAOpcion').val()==2 && $('#txtInicioContratoIAObservado').val() == '' ){
                      todook=false;
                        alertaValidacionInmuebleAI += "\n -Inicio Contrato es Obligatorio";
                    }
                    if($('#cbConclusionContratoIAOpcion').val()==2 && $('#txtConclusionContratoIAObservado').val() == '' ){
                      todook=false;
                        alertaValidacionInmuebleAI += "\n -Conclusión Contrato es Obligatorio";
                    }
                    if($('#cbCanonIAOpcion').val()==2 && $('#txtCanonIAObservado').val() == '' ){
                      todook=false;
                        alertaValidacionInmuebleAI += "\n -Canon Alquiler es Obligatorio";
                    }
                    */

                
            }else{
                if($('#cbNroDocumentoIAOpcionProv').val()=='-1'){
                    todook=false;
                    alertaValidacionInmuebleAI += "\n -Nro. Documentación";
                }
                if($('#cbNroDocumentoIAOpcionProv').val()==2 && $('#txtNroDocumentoIAObservadoProv').val() == ''  ){
                    todook=false;
                    alertaValidacionInmuebleAI += "\n -Nro. Documentación es Obligatorio";
                }
            }
        }else{
            if($('#txtListaObservacionesIA').val()==""){
                todook=false;
                alertaValidacionInmuebleAI += "\n -Posibles Observaciones"; 
            }
        }
    }
    return todook;
}