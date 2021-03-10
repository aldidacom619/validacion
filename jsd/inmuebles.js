var idEntidad;
var idBien;
var filaTablaDocumento;
var idDocumentoBien=null;
var alertaValidacionInmueble="";
var tablaDocValidadosInmuebles = false;
var base_url;

function baseurl(enlace)
{
  
  base_url = enlace;
 

}

function idfuncval(id){
  //alert("hola"+id);
  idfuncionarioval = id; //2019
}
function cargacorrespondencia(){
    var enlace = base_url + "index.php/inmuebles/correspondeciadoc";
    $.ajax({
        type: "GET",
        url : enlace,
        success: function (data) 
        {
        $('#cbNroDocumentoOpcion').html(data);
        $('#cbSuperficieOpcion').html(data);
        $('#cbDireccionOpcion').html(data);
        $('#cbCatastroOpcion').html(data);
        $('#cbNroDocumentoOpcion').html(data);
        $('#cbNroDocumentoOpcionProv').html(data);
        $('#cbDenominacionOpcion').html(data);
        }
    });
}
function verificaEntAsignada(ident){//2019 adicionado
  //var idval = "<?php echo  base_url(); ?>";
  //alert("valor de identidad: "+ident);
 
var enlace = base_url + "index.php/inicio/verifIdEntidad";
var result= true;
    $.ajax({
        type: "GET",
        url: enlace,
        async: false,
        data: {ide: ident, idf:idfuncionarioval},
        success: function(data){

            if(data == 1){
                             
                             result = true;
                             
                             } else {
                                
                                result = false;
                             }
                
        }

    });

    return result;
    

}
/* 
Boton Validar Doc
*/

function abrirDialogValidacion(idbien, identidad) {
  validar=1;
      if (identidad!=undefined){//2019
            //alert(verificaEntAsignada(identidad));
            if(verificaEntAsignada(identidad) == false) 
                validar=0;//2019  

        getnombre_entInm(identidad);
        }
   if(validar==1){
    $('#txtListaObservaciones').val('');
   $('#txtObservacionesInmuebles').val('');
   $('#txtIdB').val(idbien);
   $('#txtIdB1').val(idbien);
   $('#divCondicionesValidacion').hide();
   $('#divDatosValidacion').hide();
   $('#divObservacionesInmueble').hide();
   $('#divDatosValidacionDocProvisional').hide();
   $('#cbNroDocumentoOpcionProv option[value="-1"]').prop('selected','selected');
   $('#txtNroDocumentoInmuebleObservadoProv').val('');
   $('#btnGuardarValidacionInmueble').prop('disabled', true);
  cargarTablaDocumentacion(idbien);
  getDatosParaValidar(idbien);
     cargarComboObservaciones();
        getEstadoBien(idbien);
        $('#largemodal').modal('show');  
   }  
   else alert("ENTIDAD NO ASIGNADA AL VALIDADOR...");    
   
}
function getnombre_entInm(ident){//2019
    var enlace = base_url + "index.php/inicio/nombre_ent";
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: ident},
       success: function (data) {
           var result = JSON.parse(data);
                $.each(result, function(i, datos){
                  $("#nombre_entidadMaqp").html(datos.nombre);
                  if(datos.estadoentidad==1){
                      $("#btnAdicionDocumentoValidarInmueble").show();
                      $("#btnGuardarValidacionInmueble").show();
                    }
                    else{
                      $("#btnAdicionDocumentoValidarInmueble").hide(); 
                      $("#btnGuardarValidacionInmueble").hide();
                    }
                });
           }
    });
  
} 
function mostrarDatosValidacion(){
   var adjunto = $('#cbAdjuntaInmueble').val();
   var corresponde = $('#cbCorrespondeInmueble').val();
   var legible = $('#cbLegibleInmueble').val();
   var tipoDocumento = $('#txtTipoDocumento').val();
 /*   alert(adjunto);
   alert(corresponde);
   alert(legible);
   alert(tipoDocumento);*/

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
  console.log('CALL function eventosCombosValidacion');

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
    if (valor == 2){
        $('#txtNroDocumentoInmuebleObservadoProv').attr('readonly', false);
    }else{
        $('#txtNroDocumentoInmuebleObservadoProv').val('');
        $('#txtNroDocumentoInmuebleObservadoProv').attr('readonly', true);
    }
}

function accionComboNroDocumento(){
    var valor = $('#cbNroDocumentoOpcion').val();
    if (valor == 2){
        $('#txtNroDocumentoInmuebleObservado').attr('readonly', false);
    }else{
        $('#txtNroDocumentoInmuebleObservado').val('');
        $('#txtNroDocumentoInmuebleObservado').attr('readonly', true);
    }
}

function accionComboSuperficie(){
    var valor = $('#cbSuperficieOpcion').val();
    if (valor == 2){
        $('#txtSuperficieInmuebleObservado').attr('readonly', false);
    }else{
        $('#txtSuperficieInmuebleObservado').val('');
        $('#txtSuperficieInmuebleObservado').attr('readonly', true);
    }
}

function accionComboDireccion(){
    var valor = $('#cbDireccionOpcion').val();
    if (valor == 2){
        $('#txtDireccionInmuebleObservado').attr('readonly', false);
    }else{
        $('#txtDireccionInmuebleObservado').val('');
        $('#txtDireccionInmuebleObservado').attr('readonly', true);
    }
}

function accionComboCatastro(){
    var valor = $('#cbCatastroOpcion').val();
    if (valor == 2){
        $('#txtCatastroInmuebleObservado').attr('readonly', false);
    }else{
        $('#txtCatastroInmuebleObservado').val('');
        $('#txtCatastroInmuebleObservado').attr('readonly', true);
    }
}

function accionComboDenominacion(){
    var valor = $('#cbDenominacionOpcion').val();
    if (valor == 2){
        $('#txtDenominacionInmuebleObservado').attr('readonly', false);
    }else{
        $('#txtDenominacionInmuebleObservado').val('');
        $('#txtDenominacionInmuebleObservado').attr('readonly', true);
    }
}
function verificaiddocumento(iddoc){//2018 adicionado
var enlace = base_url + "index.php/inmuebles/verifiddoc";
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

// MODAL CANCELAR SUBMIT
function botonesDialogoValidacion(){//2018 
 // console.log('CALL function botonesDialogoValidacion');

    $('#btnGuardarValidacionInmueble').on('click',function(){

        iddoc = $('#txtIdDocumento').val();
        acc = $('#accion').val();
        //alert("valor del id del doc"+iddoc); 
        iddocvalidado = verificaiddocumento(iddoc);// 2018 adic
        //alert("hola: "+iddocvalidado);
        //alert("valor de variable"+variable);
        if(iddocvalidado == true || acc == 'editarValidacion')
        {
         guardarValidacion();//2018 
        }

    });
    $('#cancelarValidacionInmueble').on('click',function(){
        $('#largemodal').modal('hide');
    });

}


function getDatosParaValidar(idbien) {
    //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/inmuebles/getDatosInmueble";
    var enlace = base_url + "index.php/inmuebles/getDatosInmueble";
    $.ajax({
        type: "GET",
        url: enlace,
        data: {id: idbien},
        success: function(data){

                var result = JSON.parse(data);
                $.each(result, function(i, val){
                $('#txtIdBienInmueble').val(val.idbien);  
                $('#txtSuperficieInmueble').val(val.superficieterreno);
                $('#txtDireccionInmueble').val(val.direccion);
                $('#txtCatastroInmueble').val(val.nrocatastro);
                $('#txtDenominacionInmueble').val(val.denominacion);


           $('#txtMensajeCabeceraIn').val('IdBien: '+val.idbien+', Denominacion: '+val.denominacion+', Superficie: '+val.superficieterreno+', Dirección: '+val.direccion);

               });
        }

    });
}

function getEstadoBien(idbien){

    //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/inmuebles/";
    //var enlace = base_url + "index.php/inmuebles/getDatosEstado";
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

function cargarTablaDocumentacion(idbien){
    //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/inmuebles/";
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

function limpiarcampos() {

              $('#txtNroDocumentoInmueble').val('');
              $('#txtTipoDocumento').val('');
              $('#txtNroDocumentoInmuebleProv').val('');
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
              $('#divDatosValidacionDocProvisional').hide();
              // $("#cbObservacionesInmuebles").val('');
              $('#txtListaObservaciones').val('');
              accionComboNroDocumentoProv();
              accionComboNroDocumento();
              accionComboSuperficie();
              accionComboDireccion();
              accionComboCatastro();
              accionComboDenominacion();
               $('#cbEstadoDocumentacionInmueble').val('');

              $('#cbNroDocumentoOpcionProv option[value="-1"]').prop('selected','selected');
              $('#txtNroDocumentoInmuebleObservadoProv').val('');
}

function documentacionbien(idd) {
   //alert(idd);
   limpiarcampos();
    $('#txtIdDocumento').val(idd);
    $('#txtObservacionesInmuebles').val('');
    $('#btnGuardarValidacionInmueble').prop('disabled', false);



    //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/inmuebles/";
     var enlace = base_url + "index.php/inmuebles/verificarValidacion";
    $.ajax({
        type: "GET",
        url : enlace,
       data: {id: idd},
        success: function (data) {
           //alert(data);
           datos = $.parseJSON(data);
           //alert(datos.tienevalidacion);
           $('#tablaDocumentacionInmueble').html(datos.tabla);
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



              $('#txtObservacionesInmuebles').val(datos.observaciones);
              $('#divCondicionesValidacion').show();

              //var tipoDocumento = $('#txtTipoDocumento').val();
              if(datos.idtipodocumento==1 || datos.idtipodocumento==2){
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

                }
                else{
                $('#txtNroDocumentoInmuebleObservadoProv').val(datos.nrodocumento);
                $('#cbNroDocumentoOpcionProv option[value="'+datos.correctodocumento+'"]').prop('selected','selected');
                }

              $('#cbEstadoDocumentacionInmueble').val($('#txtTipoDocumento').val());

              //
              var dataarray=datos.observaciondetalle.split("|");
              $("#cbObservacionesInmuebles").val(dataarray);
              $("#cbObservacionesInmuebles").multiselect("refresh");

              $('#txtListaObservaciones').val(datos.observaciondetalle);


              accionComboNroDocumentoProv();
              accionComboNroDocumento();
              accionComboSuperficie();
              accionComboDireccion();
              accionComboCatastro();
              accionComboDenominacion();
              mostrarDatosValidacion();


           }else{
              $('#txtIdValidacion').val(datos.idvalidacion);
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
               var x= '';
               var dataarray=x.split("|");
              $("#cbObservacionesInmuebles").val(dataarray);
              $("#cbObservacionesInmuebles").multiselect("refresh");
           }
      }
    });



}

function guardarValidacion(){ //2019 tico

   //alert('LLEGA AQUI');
   if(validarFormulario()){
       
        var enlace = base_url + "index.php/inmuebles/guardarvalidacion";
        var datos = $('#formularioValidacionInmueble').serialize(); 
        console.log(datos);
        $.ajax({
            type: "GET",
            url: enlace, 
            data: datos,
            success: function(data)
             {//inicio
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
                    swal("Correcto", "La verificación del documento se realizo correctamente", "success")
                          .then((value) => {
                          //location.reload();
                          });
                    //alert("La verificación del documento se realizo correctamente");
                    $('#txtIdValidacion').val(datos.aux);
                  }

                  $('#accion').val('editarValidacion');

                  $('#tablaDocumentacionInmueble').html(datos.tabla);
                  //alert(datos.tipo);
                  if(datos.tipo == 1)
                  {
                    if (datos.estado == 3)
                    {

                       var des = $('#txtMensajeCabeceraIn').val();
                      //alert(des + ' FUE VALIDADO CORRECTAMENTE');
                      swal("Correcto", "EL BIEN \n :"+ des + "\n\nFUE VALIDADO CORRECTAMENTE!!!", "success")
                          .then((value) => {
                          //location.reload();
                          });
                      //alert('EL BIEN \n :'+ des + '\n\nFUE VALIDADO CORRECTAMENTE!!!');
                      window.setTimeout('location.reload()', 500);
                    }
                  }

              
            } //fin
        });
       // alert(alertaValidacionInmueble);
    }else{
        alert("Las opcciones de validación: "+alertaValidacionInmueble+" \n deberán ser seleccionados o llenados");
        alertaValidacionInmueble="";
    }
}

function cargarComboObservaciones(){
    //var enlace = "http://127.0.0.1:8080/VALIDACIONDOCUMENTAL/index.php/inmuebles/";
    var enlace = base_url + "index.php/inmuebles/obtenerObservaciones";
    var u = '1';
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: u},
       success: function (data) {
           $('#cbObservacionesInmuebles').html(data);
           $('#cbObservacionesInmuebles').multiselect('rebuild');
       }
    });

}

function comboMultiSelect(){
    console.log('CALL function comboMultiSelect');

    $('#cbObservacionesInmuebles').multiselect({
        buttonText: function(options, select) {
            if (options.length === 0) {

               $('#txtListaObservaciones').val('');
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
                $('#txtListaObservaciones').val(listaIdBienes);
              return labels.join(', ') + ' ';
            }
        }
    });//*/
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
    }else
    {
        if($('#cbAdjuntaInmueble').val()=='t' && $('#cbCorrespondeInmueble').val()=='0' && $('#cbLegibleInmueble').val()=='t')
        {
            var tipoDocumento = $('#txtTipoDocumento').val();
                      if(tipoDocumento==1 || tipoDocumento==2)
                      {
                          if($('#cbNroDocumentoOpcion').val()=='-1'||
                             $('#cbSuperficieOpcion').val()=='-1'||
                             $('#cbDireccionOpcion').val()=='-1'||
                             $('#cbCatastroOpcion').val()=='-1'||
                             $('#cbDenominacionOpcion').val()=='-1')
                            {
                              todook=false;
                              if($('#cbNroDocumentoOpcion').val()=='-1')
                              {
                                  alertaValidacionInmueble += "\n - Nro. Documentación";
                              }
                              if($('#cbSuperficieOpcion').val()=='-1'){
                                  alertaValidacionInmueble += "\n - Superficie ";
                              }
                              if($('#cbDireccionOpcion').val()=='-1'){
                                  alertaValidacionInmueble += "\n - Dirección";
                              }

                              if($('#cbCatastroOpcion').val()=='-1'){
                                  alertaValidacionInmueble += "\n - Catastro";
                              }

                              if($('#cbDenominacionOpcion').val()=='-1'){
                                  alertaValidacionInmueble += "\n - Denominación";
                              }

                          }
                          /* elim restriccion en doc observados 2019
                          if($('#cbNroDocumentoOpcion').val()==2 && $('#txtNroDocumentoInmuebleObservado').val() == '')
                          {
                            todook=false;
                            alertaValidacionInmueble += "\n - Nro Documento observado es obligatorio";
                          }
                          
                  
                          if($('#cbSuperficieOpcion').val()==2  && $('#txtSuperficieInmuebleObservado').val() == '' )
                          {
                            todook=false;
                            alertaValidacionInmueble += "\n - Superficie observada es obligatorio";
                          }
                          

                          if($('#cbDireccionOpcion').val()==2  && $('#txtDireccionInmuebleObservado').val() == '')
                          {
                            todook=false;
                            alertaValidacionInmueble += "\n - Dirección Ubicación observada es obligatorio";
                          }
                          

                          if($('#cbCatastroOpcion').val()==2  && $('#txtCatastroInmuebleObservado').val() == '')
                          {
                            todook=false;
                            alertaValidacionInmueble += "\n - Catastro observado es obligatorio";
                          }

                          if($('#cbDenominacionOpcion').val()==2  && $('#txtDenominacionInmuebleObservado').val() == '')
                          {
                            todook=false;
                            alertaValidacionInmueble += "\n - Denominación observado es obligatorio";
                          }
                          */

                      }
                      else
                      {
                          if($('#cbNroDocumentoOpcionProv').val()=='-1')
                          {
                              todook=false;
                              alertaValidacionInmueble += "\n - Nro. Documentación";

                          }
                          /* elim restriccion de cod observado
                          if($('#cbNroDocumentoOpcionProv').val()==2 && $('#txtNroDocumentoInmuebleObservadoProv').val() == '')
                          {
                            todook=false;
                            alertaValidacionInmueble += "\n - Nro Documento observado es obligatorio";
                          }
                          */
                      }



        }
        else{
            if($('#txtListaObservaciones').val()==""){
                todook=false;
                alertaValidacionInmueble += "\n Posibles Observaciones";
            }
        }
    }

    return todook;
}
