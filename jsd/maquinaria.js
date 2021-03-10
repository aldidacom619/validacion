var idEntidad;
var idBien;
var filaTablaDocumento;
var idDocumentoBien=null;
var alertaValidacionInmueble="";
var tablaDocValidadosInmuebles = false;
var alertaValidacionMaquinaria="";

function baseurl(enlace)
{
  base_url = enlace;
 
}
function cargacorrespondencia(){
    var enlace = base_url + "index.php/inmuebles/correspondeciadoc";
    $.ajax({
        type: "GET",
        url : enlace,
        success: function (data) 
        {
        $('#cbNroDocumentoOpcionMaquinariaProv').html(data); 
        $('#cbNroDocumentoMaquinariaOpcion').html(data);
        $('#cbEquipoMaquinariaOpcion').html(data);
        $('#cbMarcaMaquinariaOpcion').html(data);
        $('#cbModeloMaquinariaOpcion').html(data);
        $('#cbSerieMaquinariaOpcion').html(data);
     
        }
    });
}
function abrirDialogValidacion(idbien)
{
    //  alert(idbien);
 $('#txtListaObservaciones').val(''); 
   $('#txtObservacionesInmuebles').val('');

   $('#txtIdBienMaquinaria').val(idbien);
   $('#divCondicionesValidacionMaquinaria').hide(); 
   
   $('#divObservacionesMaquinaria').hide();
   $('#divDatosValidacionMaquinaria').hide(); 
   $('#divDatosValidacionDocMaquinariaProvisional').hide(); 
   $('#divCondicionesValidacionMaquinaria').hide(); 

   $('#cbNroDocumentoOpcionProv option[value="-1"]').prop('selected','selected');
   $('#txtNroDocumentoInmuebleObservadoProv').val('');
   $('#btnGuardarValidacionMaquinaria').prop('disabled', true);
   getDatosObservaciones();
  cargarTablaDocumentacion(idbien);
  getDatosParaValidar(idbien);
  getEstadoBien(idbien);
  VerificarSeleccionMaquinaria();
  $('#largemodal').modal('show'); 
} 
function getDatosObservaciones(){
   var enlace = base_url + "index.php/maquinaria/obtenerObservaciones";
    var u = '1';
    $.ajax({
       type: "GET",
       url: enlace,  
       data: {id: u},
       success: function (data) {
           $('#cbObservacionEspecificaMaquinaria').html(data);
           $('#cbObservacionEspecificaMaquinaria').multiselect('rebuild');
       }
    });
}

function mostrarDatosValidacionMaquinaria(){
   var adjunto = $('#cbAdjuntaMaquinaria').val();
   var corresponde = $('#cbCorrespondeMaquinaria').val();
   var legible = $('#cbLegibleMaquinaria').val();
   var tipoDocumento = $('#txtTipoDocumentoMaquinaria').val();
   
   if(tipoDocumento==8){
       $('#cbEstadoDocumentacionMaquinaria').val(1);
   }else{
       $('#cbEstadoDocumentacionMaquinaria').val(2);   
   } 
    
   if(adjunto=='t' && corresponde==1 && legible=='t'){
      if(tipoDocumento==8)
          $('#divDatosValidacionMaquinaria').show();
    else 
      $('#divDatosValidacionDocMaquinariaProvisional').show();
    //alert(idBien);        
        getDatosParaValidarMaquinaria(idBien);
        eventosCombosValidacionMaquinaria();
   }else{
       $('#divDatosValidacionMaquinaria').hide();
     $('#divDatosValidacionDocMaquinariaProvisional').hide();
   }  
   if (adjunto == 'f'){
   $('#cbCorrespondeMaquinaria').val(2);
   $('#cbLegibleMaquinaria').val('f');
   }
}
function VerificarSeleccionMaquinaria(){
    $('#cbAdjuntaMaquinaria').change(function() {
        mostrarDatosValidacionMaquinaria();        
    }); 
    $('#cbCorrespondeMaquinaria').change(function() {
        mostrarDatosValidacionMaquinaria();        
    }); 
    $('#cbLegibleMaquinaria').change(function() {
        mostrarDatosValidacionMaquinaria();        
    }); 
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
//*******///
function accionComboDocumento(){


        var valor = $('#cbNroDocumentoMaquinariaOpcion').val();
       // alert(valor);
        if (valor == 2){
            $('#txtNroDocumentoObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtNroDocumentoObservadoMaquinaria').val('');
            $('#txtNroDocumentoObservadoMaquinaria').attr('readonly', true);
        }  
}

function accionComboEquipo(){
   var valor = $('#cbEquipoMaquinariaOpcion').val();
        if (valor == 2){
            $('#txtDescripcionObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtDescripcionObservadoMaquinaria').val('');
            $('#txtDescripcionObservadoMaquinaria').attr('readonly', true);
        }
}

function accionComboMarca(){
  var valor = $('#cbMarcaMaquinariaOpcion').val();
        if (valor == 2){
            $('#txtMarcaObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtMarcaObservadoMaquinaria').val('');
            $('#txtMarcaObservadoMaquinaria').attr('readonly', true);
        }
}

function accionComboModelo(){ 
  var valor = $('#cbModeloMaquinariaOpcion').val();
        if (valor == 2){
            $('#txtModeloObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtModeloObservadoMaquinaria').val('');
            $('#txtModeloObservadoMaquinaria').attr('readonly', true);
        }
}

function accionComboSerie(){
  var valor = $('#cbSerieMaquinariaOpcion').val();
        if (valor == 2){
            $('#txtSerieObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtSerieObservadoMaquinaria').val('');
            $('#txtSerieObservadoMaquinaria').attr('readonly', true);
        }

}

function accionComboDocumentoAux(){
  var valor = $('#cbNroDocumentoOpcionMaquinariaProv').val();
        if (valor == 2){
            $('#txtNroDocumentoMaquinariaObservadoProv').attr('readonly', false);
        }else{
            $('#txtNroDocumentoMaquinariaObservadoProv').val('');
            $('#txtNroDocumentoMaquinariaObservadoProv').attr('readonly', true);
        }

}
///////

function eventosCombosValidacionMaquinaria(){

    $('#cbNroDocumentoMaquinariaOpcion').change(function() {
        var valor = $('#cbNroDocumentoMaquinariaOpcion').val();
        if (valor == 2){
            $('#txtNroDocumentoObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtNroDocumentoObservadoMaquinaria').val('');
            $('#txtNroDocumentoObservadoMaquinaria').attr('readonly', true);
        }
    }); 
    $('#cbEquipoMaquinariaOpcion').change(function(){
        var valor = $('#cbEquipoMaquinariaOpcion').val();
        if (valor == 2){
            $('#txtDescripcionObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtDescripcionObservadoMaquinaria').val('');
            $('#txtDescripcionObservadoMaquinaria').attr('readonly', true);
        }
    });
    $('#cbMarcaMaquinariaOpcion').change(function(){
        var valor = $('#cbMarcaMaquinariaOpcion').val();
        if (valor == 2){
            $('#txtMarcaObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtMarcaObservadoMaquinaria').val('');
            $('#txtMarcaObservadoMaquinaria').attr('readonly', true);
        }
    });
    $('#cbModeloMaquinariaOpcion').change(function(){
        var valor = $('#cbModeloMaquinariaOpcion').val();
        if (valor == 2){
            $('#txtModeloObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtModeloObservadoMaquinaria').val('');
            $('#txtModeloObservadoMaquinaria').attr('readonly', true);
        }
    });
    $('#cbSerieMaquinariaOpcion').change(function(){
        var valor = $('#cbSerieMaquinariaOpcion').val();
        if (valor == 2){
            $('#txtSerieObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtSerieObservadoMaquinaria').val('');
            $('#txtSerieObservadoMaquinaria').attr('readonly', true);
        }
    });
  
  $('#cbNroDocumentoOpcionMaquinariaProv').change(function(){

         var valor = $('#cbNroDocumentoOpcionMaquinariaProv').val();

        if (valor == 2){
            $('#txtNroDocumentoMaquinariaObservadoProv').attr('readonly', false);
        }else{
            $('#txtNroDocumentoMaquinariaObservadoProv').val('');
            $('#txtNroDocumentoMaquinariaObservadoProv').attr('readonly', true);
        }
    });
}
function verificaiddocumentoMaquinaria(iddoc){//2018 adicionado
var enlace = base_url + "index.php/maquinaria/verifiddocmaquinaria";
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

function botonesDialogoValidacion(){
    $('#btnGuardarValidacionMaquinaria').on('click',function(){
       // alert('holaaa');
        iddocmaq = $('#txtIdDocumentoMaquinaria').val();
        accmaq = $('#operacion').val();
        //alert("valor del id del doc"+iddoc); 
        iddocvalidado = verificaiddocumentoMaquinaria(iddocmaq);// 2018 adic
        //alert("valor de variable"+variable);
        if(iddocvalidado == true || accmaq == 'editarValidacion')
        {
         guardarValidacion();//2018 
        }

    });
    $('#cancelarValidacionInmueble').on('click',function(){
        $('#largemodal').modal('hide');
    });
    
}

function getDatosParaValidar(idbien){
 
     var enlace = base_url + "index.php/maquinaria/getDatosmaquinaria";

    $.ajax({
        type: "GET", 
        url: enlace,
        data: {id: idbien},
        success: function(data)
        {
        
            var result = JSON.parse(data);
                $.each(result, function(i, datos){

                  
             $('#txtIdB').val(datos.idb);
             $('#txtIdBienMaquinaria').val(datos.idbien);
             $('#txtEquipoMaquinaria').val(datos.descripcion);
              $('#txtMarcaMaquinaria').val(datos.marca);
              $('#txtModeloMaquinaria').val(datos.modelo);
              $('#txtSerieMaquinaria').val(datos.nroserie);
             $('#txtMensajeCabeceraVe').val('IdBien: '+datos.idbien+', Equipo: '+datos.descripcion+', Marca: '+datos.marca+', Modelo: '+datos.modelo+' Nro. Serie:'+datos.nroserie+'.');      



               });
         
        }

    });  
}
function getEstadoBien(idbien){
    
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


function limpiarcampos()
{
            $('#txtIdValidacionMaquinaria').val('');
            $('#txtTipoDocumentoMaquinaria').val('');
            $('#txtNroDocumentoMaquinaria').val('');
            $('#txtNroDocumentoMaquinariaProv').val('');
            $('#cbAdjuntaMaquinaria option[value=-1]').prop('selected','selected');
            $('#cbCorrespondeMaquinaria').val('');
            $('#cbLegibleMaquinaria option[value=-1]').prop('selected','selected');
            $('#txtListaObservacionesMaquinaria').val('');
            $('#txtNroDocumentoObservadoMaquinaria').val('');
            $('#txtDescripcionObservadoMaquinaria').val('');
            $('#txtMarcaObservadoMaquinaria').val('');
            $('#txtModeloObservadoMaquinaria').val('');
            $('#txtSerieObservadoMaquinaria').val('');
            $('#txtObservacionesGeneralesMaquinaria').val('');

            $('#cbNroDocumentoMaquinariaOpcion option[value=-1]').prop('selected','selected');
            $('#cbEquipoMaquinariaOpcion option[value=-1]').prop('selected','selected');
            $('#cbMarcaMaquinariaOpcion option[value=-1]').prop('selected','selected');
            $('#cbModeloMaquinariaOpcion option[value=-1]').prop('selected','selected');
            $('#cbSerieMaquinariaOpcion option[value=-1]').prop('selected','selected');
            $('#txtNroDocumentoMaquinariaObservadoProv').val('');
            $('#cbNroDocumentoOpcionMaquinariaProv option[value=-1]').prop('selected','selected');
             $('#divDatosValidacionDocMaquinariaProvisional').hide();
             $('#divDatosValidacionMaquinaria').hide(); 
            accionComboDocumento();
            accionComboEquipo();
            accionComboMarca();
            accionComboModelo();
            accionComboSerie();
            accionComboDocumentoAux();

}
function opcionMultiselect(){ 
  $('#cbObservacionEspecificaMaquinaria').multiselect({
        buttonText: function(options, select) {
            if (options.length === 0) {
              $('#txtListaObservacionesMaquinaria').val('');
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
                $('#txtListaObservacionesMaquinaria').val(listaIdObservaciones);
                return labels.join(', ') + ' ';
            }
        }
    });
}
function compruebaObservaciones(){
  var adjunto = $('#cbAdjuntaMaquinaria').val();
   var corresponde = $('#cbCorrespondeMaquinaria').val();
   var legible = $('#cbLegibleMaquinaria').val();
   var tipoDocumento = $('#txtTipoDocumentoMaquinaria').val();
   if(tipoDocumento==8){
       $('#cbEstadoDocumentacionMaquinaria').val(1);
   }else{
       $('#cbEstadoDocumentacionMaquinaria').val(2);   
   }
   if(adjunto=='t' && corresponde==1 && legible=='t' ){
        //$('#divDatosValidacion').show();
        //$('#divObservacionesMaquinaria').hide();
    $('#divObservacionesMaquinaria').show();
   }else{
       //if(adjunto!=-1 || corresponde!=-1 || legible!=-1){
     if(adjunto=='f' || corresponde==2 || legible=='f'){
           //$('#divDatosValidacion').hide();
          $('#txtNroDocumentoObservadoMaquinaria').val('');
          $('#txtDescripcionObservadoMaquinaria').val('');
          $('#txtMarcaObservadoMaquinaria').val('');
          $('#txtModeloObservadoMaquinaria').val('');
           $('#txtSerieObservadoMaquinaria').val('');

          $('#cbNroDocumentoMaquinariaOpcion option[value="-1"]').prop('selected','selected');
          $('#cbEquipoMaquinariaOpcion option[value="-1"]').prop('selected','selected');
          $('#cbMarcaMaquinariaOpcion option[value="-1"]').prop('selected','selected');
          $('#cbModeloMaquinariaOpcion option[value="-1"]').prop('selected','selected');
          $('#cbSerieMaquinariaOpcion option[value="-1"]').prop('selected','selected');

          $('#txtNroDocumentoMaquinariaObservadoProv').val('');
          $('#cbNroDocumentoOpcionMaquinariaProv option[value="-1"]').prop('selected','selected');
             accionComboDocumento();
                    accionComboEquipo();
                    accionComboMarca();
                    accionComboModelo();
                    accionComboSerie();
                    accionComboDocumentoAux();
       $('#divObservacionesMaquinaria').show();
       }
   }  
}

function habilitaObservaciones(){
  var primeraOpcion = 0;
  var segundaOpcion = 0;
  $('#cbAdjuntaMaquinaria').change(function() {
    compruebaObservaciones();
  });
  $('#cbCorrespondeMaquinaria').change(function() {
    compruebaObservaciones(); 
  });
  $('#cbLegibleMaquinaria').change(function() {
    compruebaObservaciones();   
  });
}
function documentacionbien(idd)
{
   //alert(idd);
   limpiarcampos();
    $('#txtIdDocumentoMaquinaria').val(idd);
    //$('#txtListaObservacionesMaquinaria').val('');
    $('#btnGuardarValidacionMaquinaria').prop('disabled', false);
    
     
    
    var enlace = base_url + "index.php/maquinaria/verificarValidacion";
    $.ajax({
        type: "GET",
        url : enlace,
       data: {id: idd},
        success: function (data) { 
           //alert(data);
           datos = $.parseJSON(data);
          $('#tablaMaquinariaValidados').html(datos.tabla); 
           if(datos.tienevalidacion=='true')
           {
            
                         $('#txtIdValidacionMaquinaria').val(datos.idvalidacion);
                         $('#txtTipoDocumentoMaquinaria').val(datos.idtipodocumento);
                         $('#txtNroDocumentoMaquinaria').val(datos.nrodoc); 
                         $('#txtNroDocumentoMaquinariaProv').val(datos.nrodoc);
                         
                          $('#cbAdjuntaMaquinaria option[value="'+datos.adjunta+'"]').prop('selected','selected');
                          $('#cbCorrespondeMaquinaria').val(datos.corresponde);
                          $('#cbLegibleMaquinaria option[value="'+datos.legible+'"]').prop('selected','selected');
                          $('#txtListaObservacionesMaquinaria').val(datos.observaciondetalle);

                          $('#txtObservacionesGeneralesMaquinaria').val(datos.observaciones);

                          $('#divCondicionesValidacionMaquinaria').show(); 

                   if(datos.idtipodocumento==8){
                                          $('#txtNroDocumentoObservadoMaquinaria').val(datos.nrodocumento);
                                          $('#txtDescripcionObservadoMaquinaria').val(datos.descripcion);
                                          $('#txtMarcaObservadoMaquinaria').val(datos.marca);
                                          $('#txtModeloObservadoMaquinaria').val(datos.modelo);
                                           $('#txtSerieObservadoMaquinaria').val(datos.serie);

                                          $('#cbNroDocumentoMaquinariaOpcion option[value="'+datos.correctodocumento+'"]').prop('selected','selected');
                                          $('#cbEquipoMaquinariaOpcion option[value="'+datos.correctodescripcion+'"]').prop('selected','selected');
                                          $('#cbMarcaMaquinariaOpcion option[value="'+datos.correctomarca+'"]').prop('selected','selected');
                                          $('#cbModeloMaquinariaOpcion option[value="'+datos.correctomodelo+'"]').prop('selected','selected');
                                          $('#cbSerieMaquinariaOpcion option[value="'+datos.correctoserie+'"]').prop('selected','selected');
                  } else {
                                          $('#txtNroDocumentoMaquinariaObservadoProv').val(datos.nrodocumento);
                                          $('#cbNroDocumentoOpcionMaquinariaProv option[value="'+datos.correctodocumento+'"]').prop('selected','selected');
                  }
                    
                  var dataarray=datos.observaciondetalle.split("|");


              $("#cbObservacionEspecificaMaquinaria").val(dataarray);
         
             
              $("#cbObservacionEspecificaMaquinaria").multiselect("refresh");
              
                    $('#operacion').val('editarValidacion');


                 
                    accionComboDocumento();
                    accionComboEquipo();
                    accionComboMarca();
                    accionComboModelo();
                    accionComboSerie();
                    accionComboDocumentoAux();
                  
                   $('#divObservacionesMaquinaria').show();
  
                  var idTipoDocumento = $('#txtTipoDocumentoMaquinaria').val();
                 

             mostrarDatosValidacionMaquinaria();
           }
           else
           {
              
              $('#cbAdjuntaMaquinaria option[value="-1"]').prop('selected','selected');
              $('#cbCorrespondeMaquinaria option[value="-1"]').prop('selected','selected');
              $('#cbLegibleMaquinaria option[value=-1]').prop('selected','selected');
              $('#divDatosValidacion').hide();
              $('#divObservacionesMaquinaria').hide();
              $('#operacion').val('guardarValidacion');
              mostrarDatosValidacionMaquinaria();
              
           
            

              $('#txtTipoDocumentoMaquinaria').val(datos.idtipodocumento);
              $('#txtNroDocumentoMaquinaria').val(datos.nrodoc);
              $('#txtNroDocumentoMaquinariaProv').val(datos.nrodoc);
              var x= '';
              var dataarray=x.split("|");


              $("#cbObservacionEspecificaMaquinaria").val(dataarray);
                
              
              $("#cbObservacionEspecificaMaquinaria").multiselect("refresh");

              $('#divCondicionesValidacionMaquinaria').show(); 
              $('#divObservacionesMaquinaria').show();
              

              
                
           }
      }
    });//*/

   
    
}

function guardarValidacion(){
    
    //alert('oholas');
    if(validarFormularioMaquinaria())
    {
        //$('#btnGuardarValidacionInmueble').prop('disabled', true);
        
        var enlace = base_url + "index.php/maquinaria/guardarvalidacion";
        var datos = $('#formularioValidacionMaquinaria').serialize();
        $.ajax({
            type: "GET",
            url: enlace,
            data: datos,
            success: function(data) 
             {
                
                 datos=$.parseJSON(data); 
                  if (datos.aux == 2)
                  {
                       swal("Correcto", "La modificación de verificación del documento se realizo correctamente", "success")
                          .then((value) => {
                          location.reload();
                          });

                      //alert("La modificación de verificación del documento se realizo correctamente"); 
                  }
                  else
                  {
                      $('#operacion').val('editarValidacion');
                      $('#txtIdValidacionMaquinaria').val(datos.aux);
                      swal("Correcto", "La verificación del documento se realizo correctamente", "success")
                          .then((value) => {
                          //location.reload();
                          });

                      //alert("La verificación del documento se realizo correctamente");
                  } 
                $('#tablaMaquinariaValidados').html(datos.tabla); // */

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
    else
    {
        alert("Las opcciones de validación:  "+alertaValidacionMaquinaria+" \n Deberán ser seleccionados");
        alertaValidacionMaquinaria="";
    }    
}





function validarFormularioMaquinaria(){
    var todook = true;
     
    if($('#cbAdjuntaMaquinaria').val()=='-1'||$('#cbCorrespondeMaquinaria').val()=='-1'||$('#cbLegibleMaquinaria').val()=='-1')
    {
      if($('#cbAdjuntaMaquinaria').val()=='-1'){
          todook=false;
          alertaValidacionMaquinaria += '\n - Adjunta';
      }
      if($('#cbCorrespondeMaquinaria').val()=='-1'){
          todook=false;
          alertaValidacionMaquinaria += '\n - Corresponde';
      }
      if($('#cbLegibleMaquinaria').val()=='-1'){
          todook=false;
          alertaValidacionMaquinaria += '\n - Legible';
      }
    }
    else
    {
      if($('#cbAdjuntaMaquinaria').val()=='t' && $('#cbCorrespondeMaquinaria').val()=='1'&& $('#cbLegibleMaquinaria').val()=='t')
      {  
        var tipoDocumentoMaquinaria=$('#txtTipoDocumentoMaquinaria').val();
        if(tipoDocumentoMaquinaria==8){
          if($('#cbNroDocumentoMaquinariaOpcion').val()=='-1'){
              todook=false;
              alertaValidacionMaquinaria += '\n - Nro. Documento';
          }
          if($('#cbEquipoMaquinariaOpcion').val()=='-1'){
              todook=false;
              alertaValidacionMaquinaria += '\n - Equipo';
          }
          if($('#cbMarcaMaquinariaOpcion').val()=='-1'){ 
              todook=false;
              alertaValidacionMaquinaria += '\n - Marca';
          }
          if($('#cbModeloMaquinariaOpcion').val()=='-1'){
              todook=false;
              alertaValidacionMaquinaria += '\n - Modelo';
          }
          if($('#cbSerieMaquinariaOpcion').val()=='-1'){
              todook=false;
              alertaValidacionMaquinaria += '\n - Serie';
          }

          /*2018
           if($('#cbNroDocumentoMaquinariaOpcion').val()==2 && $('#txtNroDocumentoObservadoMaquinaria').val() == '' ){
              todook=false;
              alertaValidacionMaquinaria += '\n - Nro. Documento es obligatorio';
          }
          if($('#cbEquipoMaquinariaOpcion').val()==2 && $('#txtDescripcionObservadoMaquinaria').val() == '' ){
              todook=false;
              alertaValidacionMaquinaria += '\n - Equipo es obligatorio';
          }
          
          if($('#cbMarcaMaquinariaOpcion').val()==2 && $('#txtMarcaObservadoMaquinaria').val() == ''){
              todook=false;
              alertaValidacionMaquinaria += '\n - Marca es obligatorio';
          }
          if($('#cbModeloMaquinariaOpcion').val()==2 && $('#txtModeloObservadoMaquinaria').val() == ''){
              todook=false;
              alertaValidacionMaquinaria += '\n - Modelo es obligatorio';
          }
          if($('#cbSerieMaquinariaOpcion').val()==2 && $('#txtSerieObservadoMaquinaria').val() == ''){
              todook=false;
              alertaValidacionMaquinaria += '\n - Serie es obligatorio';
          }
          */

          }
          else
          {
              if($('#cbNroDocumentoOpcionMaquinariaProv').val()==2){
                /*
                if($('#txtNroDocumentoMaquinariaObservadoProv').val()=='')
                {
                  todook=false;
                  alertaValidacionMaquinaria += '\n - Nro. Documento Observado es obligatorio';
                } 
                */
              }
              if($('#cbNroDocumentoOpcionMaquinariaProv').val()=='f' /*&& $('#txtNroDocumentoMaquinariaObservadoProv').val() == '' */){
                  todook=false;
                  alertaValidacionMaquinaria += '\n - Nro. Documento es obligatorio';
              }
          }
      }
      else
      {
         if($('#txtListaObservacionesMaquinaria').val()=="")
            {
               todook=false;
               alertaValidacionMaquinaria += "\n -Observaciones Específicas1"; 
            }
      }    
    }  
    return todook;
}



