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
  //var  url = "<?= base_url()?>";
  //var base_url = '<?php echo base_url();?>';
  //var url = “<?php echo ; ?>” ;
  //alert(base_url);
}
function abrirDialogValidacion(idbien)
{
      //  alert(idbien);
   $('#txtListaObservaciones').val(''); 
   $('#txtObservacionesInmuebles').val('');

   $('#txtIdBienMaquinaria').val(idbien);
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
        if (valor == 'f'){
            $('#txtNroDocumentoObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtNroDocumentoObservadoMaquinaria').val('');
            $('#txtNroDocumentoObservadoMaquinaria').attr('readonly', true);
        }  
}

function accionComboEquipo(){
   var valor = $('#cbEquipoMaquinariaOpcion').val();
        if (valor == 'f'){
            $('#txtDescripcionObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtDescripcionObservadoMaquinaria').val('');
            $('#txtDescripcionObservadoMaquinaria').attr('readonly', true);
        }
}

function accionComboMarca(){
  var valor = $('#cbMarcaMaquinariaOpcion').val();
        if (valor == 'f'){
            $('#txtMarcaObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtMarcaObservadoMaquinaria').val('');
            $('#txtMarcaObservadoMaquinaria').attr('readonly', true);
        }
}

function accionComboModelo(){
  var valor = $('#cbModeloMaquinariaOpcion').val();
        if (valor == 'f'){
            $('#txtModeloObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtModeloObservadoMaquinaria').val('');
            $('#txtModeloObservadoMaquinaria').attr('readonly', true);
        }
}

function accionComboSerie(){
  var valor = $('#cbSerieMaquinariaOpcion').val();
        if (valor == 'f'){
            $('#txtSerieObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtSerieObservadoMaquinaria').val('');
            $('#txtSerieObservadoMaquinaria').attr('readonly', true);
        }

}

function accionComboDocumentoAux(){
  var valor = $('#cbNroDocumentoOpcionMaquinariaProv').val();
        if (valor == 'f'){
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
        if (valor == 'f'){
            $('#txtNroDocumentoObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtNroDocumentoObservadoMaquinaria').val('');
            $('#txtNroDocumentoObservadoMaquinaria').attr('readonly', true);
        }
    }); 
    $('#cbEquipoMaquinariaOpcion').change(function(){
        var valor = $('#cbEquipoMaquinariaOpcion').val();
        if (valor == 'f'){
            $('#txtDescripcionObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtDescripcionObservadoMaquinaria').val('');
            $('#txtDescripcionObservadoMaquinaria').attr('readonly', true);
        }
    });
    $('#cbMarcaMaquinariaOpcion').change(function(){
        var valor = $('#cbMarcaMaquinariaOpcion').val();
        if (valor == 'f'){
            $('#txtMarcaObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtMarcaObservadoMaquinaria').val('');
            $('#txtMarcaObservadoMaquinaria').attr('readonly', true);
        }
    });
    $('#cbModeloMaquinariaOpcion').change(function(){
        var valor = $('#cbModeloMaquinariaOpcion').val();
        if (valor == 'f'){
            $('#txtModeloObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtModeloObservadoMaquinaria').val('');
            $('#txtModeloObservadoMaquinaria').attr('readonly', true);
        }
    });
    $('#cbSerieMaquinariaOpcion').change(function(){
        var valor = $('#cbSerieMaquinariaOpcion').val();
        if (valor == 'f'){
            $('#txtSerieObservadoMaquinaria').attr('readonly', false);
        }else{
            $('#txtSerieObservadoMaquinaria').val('');
            $('#txtSerieObservadoMaquinaria').attr('readonly', true);
        }
    });
  
  $('#cbNroDocumentoOpcionMaquinariaProv').change(function(){

         var valor = $('#cbNroDocumentoOpcionMaquinariaProv').val();

        if (valor == 'f'){
            $('#txtNroDocumentoMaquinariaObservadoProv').attr('readonly', false);
        }else{
            $('#txtNroDocumentoMaquinariaObservadoProv').val('');
            $('#txtNroDocumentoMaquinariaObservadoProv').attr('readonly', true);
        }
    });
}
function botonesDialogoValidacion(){
    $('#btnGuardarValidacionMaquinaria').on('click',function(){
       // alert('holaaa');
        guardarValidacion();
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
             $('#txtEquipoMaquinaria').val(datos.descripcion);
              $('#txtMarcaMaquinaria').val(datos.marca);
              $('#txtModeloMaquinaria').val(datos.modelo);
              $('#txtSerieMaquinaria').val(datos.nroserie);
             $('#txtMensajeCabeceraVe').val('IdBien: '+idbien+', Equipo: '+datos.descripcion+', Marca: '+datos.marca+', Modelo: '+datos.modelo+' Nro. Serie:'+datos.nroserie+'.');      



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
        $('#estadoBien1').text('Estado: '+data);
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
    $('#txtListaObservacionesMaquinaria').val('');
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
                //alert(data); 
                 datos=$.parseJSON(data); 
                  if (datos.aux == 2)
                  {
                       
                      alert("Se realizo la modificación correctamente"); 
                  }
                  else
                  {
                      $('#operacion').val('editarValidacion');
                      $('#txtIdValidacionMaquinaria').val(datos.aux);
                      alert("Se realizo el registro correctamente");
                  } 
                $('#tablaMaquinariaValidados').html(datos.tabla); // */
            }
        });
    }
    else
    {
        alert("Las opcciones de validación: "+alertaValidacionMaquinaria+" deberán ser seleccionados");
        alertaValidacionMaquinaria="";
    }    
}





function validarFormularioMaquinaria(){
    var todook = true;
    if($('#cbAdjuntaMaquinaria').val()=='-1'){
        todook=false;
        alertaValidacionMaquinaria += ' Adjunta';
    }
    if($('#cbCorrespondeMaquinaria').val()=='-1'){
        todook=false;
        alertaValidacionMaquinaria += ' Corresponde';
    }
    if($('#cbLegibleMaquinaria').val()=='-1'){
        todook=false;
        alertaValidacionMaquinaria += ' Legible';
    }
    var tipoDocumentoMaquinaria=$('#txtTipoDocumentoMaquinaria').val();
    if(tipoDocumentoMaquinaria==8){
        if($('#cbNroDocumentoMaquinariaOpcion').val()=='-1'){
            todook=false;
            alertaValidacionMaquinaria += ' Nro. Documento';
        }
        if($('#cbEquipoMaquinariaOpcion').val()=='-1'){
            todook=false;
            alertaValidacionMaquinaria += ' Equipo';
        }
        if($('#cbMarcaMaquinariaOpcion').val()=='-1'){
            todook=false;
            alertaValidacionMaquinaria += ' Marca';
        }
        if($('#cbModeloMaquinariaOpcion').val()=='-1'){
            todook=false;
            alertaValidacionMaquinaria += ' Modelo';
        }
        if($('#cbSerieMaquinariaOpcion').val()=='-1'){
            todook=false;
            alertaValidacionMaquinaria += ' Serie';
        }
    }else{
        if($('#cbNroDocumentoOpcionMaquinariaProv').val()=='-1'){
            todook=false;
            alertaValidacionMaquinaria += ' Nro. Documento';
        }
    }
    return todook;
}



