var base_url;
function baseurl(enlace)
{
  base_url = enlace;
  //var  url = "<?= base_url()?>";
  //var base_url = '<?php echo base_url();?>';
  //var url = “<?php echo ; ?>” ;
  // alert(base_url);
}

function cargarComboEntidadesAsignadas(){
   
//alert('asdfasd');

     var enlace = base_url + "index.php/reportes/getentidadesAsignadas";
    var u = '1';
    $.ajax({
       type: "GET",
       url: enlace,
       data: {id: u},
       success: function (data) {
           $('#cbEntidadesAsignadas').html('');
            $('#cbEntidadesAsignadas').html(data);
			$('#cbEntidadesAsignadas2').html('');
            $('#cbEntidadesAsignadas2').html(data);
       }
    });

    var valor = $('#cbvalidadores').val();
        //alert(valor);
        var enlace = base_url + "index.php/Administrador/getEntidades";
        $.ajax({
            type: "GET",
            url: enlace,
            data: {id: valor},
            success: function(data){
             // alert(data);
                 $('#cbentidad').html(data);
                  $('#cbentidadobss').html(data);
            } 

        });  
} 

function generarReporte(){
	
    $('#btnReporteBVD').on('click',function(){
       var identidad=$('#cbEntidadesAsignadas').val();
       var idrubro=$('#cbRubro').val();
       if(identidad==-1 || idrubro==-1){
           alert('Debe seleccionar una Entidad y un Rubro');
       }else{
           window.open('http://127.0.0.1:8080/VALIDACIONADM/reportes/reporte.validacionporrubro.php?idrubro='+idrubro+'&identidad='+identidad); 
          // window.open('http://amauta.senape.gob.bo/validacion_admin/reportes/reporte.validacionporrubro.php?idrubro='+idrubro+'&identidad='+identidad); 
                        

       }
       
    });
}

function generarReportexValidador(){
	
    $('#btnReporteVD').on('click',function(){
       var idfuncionario=$('#idfunc').val();
       var fechainicio=$('#fechainicio').val();
  	   var fechafin = $('#fechafin').val(); 
  	   if(fechainicio == '' || fechafin == ''){
  	   		alert("Debe seleccionar el rango de fechas para generar el Reporte");
  	   }
  	   else {
  	   		window.open('http://127.0.0.1:8080/VALIDACIONADM/reportes/reporteValidacionFuncionarioFechas.php?fechainicio='+fechainicio+'&fechafin='+fechafin+'&idfuncionario='+idfuncionario); 
  	   	//	window.open('http://amauta.senape.gob.bo/validacion_admin/reportes/reporteValidacionFuncionarioFechas.php?fechainicio='+fechainicio+'&fechafin='+fechafin+'&idfuncionario='+idfuncionario); 
        }
    });

        $('#btnReporteVD2').on('click',function(){
       var idfuncionario=$('#cbvalidadores2').val();
       var fechainicio=$('#fechainicio2').val();
       var fechafin = $('#fechafin2').val(); 
       if(fechainicio == '' || fechafin == ''){
          alert("Debe seleccionar el rango de fechas para generar el Reporte");
       }
       else {
         window.open('http://127.0.0.1:8080/VALIDACIONADM/reportes/reporteavancevalidacion.php?fechainicio='+fechainicio+'&fechafin='+fechafin+'&idfuncionario='+idfuncionario); 
         // window.open('http://amauta.senape.gob.bo/validacion_admin/reportes/reporteValidacionFuncionarioFechas.php?fechainicio='+fechainicio+'&fechafin='+fechafin+'&idfuncionario='+idfuncionario); 
        }
    });
}

function generarReporteEstadoLegal(){
    $('#btnReporteEBD').on('click',function(){
       var identidad=$('#cbEntidadesAsignadas2').val();
	   if(identidad == -1){
	   		alert("Debe seleccionar una Entidad");
	   }
	   else {

	   	//alert("Debe seleccionar una Entidadasdadsasd");
	   		window.open('http://127.0.0.1:8080/VALIDACIONADM/reportes/reporteBienClaseEntidad.php?idEntidad='+identidad); 
	   		//window.open('http://amauta.senape.gob.bo/validacion_admin/reportes/reporteBienClaseEntidad.php?idEntidad='+identidad); 
	   }
       
    });
}

function fechas(){
	//alert('asdfasdfas');
//	$("#fechainicio").val('holaaa');
//	$("#fechafin").val('holaaasasa');

 $("#fechainicio").datepicker({
    
    format: "yyyy-mm-dd",
	orientation: "top left",
    language: "es"
 });
	 
 $("#fechafin").datepicker({
    
    format: "yyyy-mm-dd",
	orientation: "top left",
    language: "es"
 });
  $("#fechainicio2").datepicker({
    
    format: "yyyy-mm-dd",
  orientation: "top left",
    language: "es"
 });
   
 $("#fechafin2").datepicker({
    
    format: "yyyy-mm-dd",
  orientation: "top left",
    language: "es"
 });
	 /**/
}

function generarReporte1(){
    $('#btnReporte1').on('click',function(){
       
          // window.open('http://127.0.0.1:8080/VALIDACIONADM/reportes/reporteRubroGeneral.php');
       
       
    });
}

function generarReporte2(){
    $('#btnReporte2').on('click',function(){
       
           //window.open('reportes/reporteRubroDocAdicionado.php');
       
       
    });
}

function generarReporte3(){
    $('#btnReporte3').on('click',function(){
       
         //  window.open('reportes/reporteValidadoresAvance.php');
       
       
    });
}

function generarReporte4(){
    $('#btnReporte4').on('click',function(){
       
         //  window.open('reportes/reporteAvanceDepto.php');
       
       
    });
}

function generarReporte5(){
    $('#btnReporte5').on('click',function(){
       
          // window.open('reportes/reporteAvanceValDocumental.php');
       
       
    });
}
function seleccionarentidad()
{
  $('#cbvalidadores').change(function() {
        var valor = $('#cbvalidadores').val();
        //alert(valor);
        var enlace = base_url + "index.php/Administrador/getEntidades";
        $.ajax({
            type: "GET",
            url: enlace,
            data: {id: valor},
            success: function(data){
              //alert(data);
                  $('#cbentidad').html(data);

            }

        });  
    }); 
  $('#cbvalidadoresobs').change(function() {
        var valor = $('#cbvalidadoresobs').val();
        //alert(valor);
        var enlace = base_url + "index.php/Administrador/getEntidades";
        $.ajax({
            type: "GET",
            url: enlace,
            data: {id: valor},
            success: function(data){
              //alert(data);
                  $('#cbentidadobs').html(data);
            }

        });  
    }); 


   $('#btnReportevalidacion').on('click',function(){
       var identidad=$('#cbentidad').val();
       var idfuncionario=$('#cbvalidadores').val();

        if(identidad == -1)
        {
          alert("Debe seleccionar una Entidad");
        } 
        else
        {
        //window.open(base_url + "index.php/administrador/imprimir_prueba/"+identidad);
          window.open('http://127.0.0.1:8080/VALIDACIONADM/reportes/reportevalidaciontotal.php?idEntidad='+identidad+'&idfuncionario='+idfuncionario); 
        //window.open('http://amauta.senape.gob.bo/validacion_admin/reportes/reportevalidaciontotal.php?idEntidad='+identidad+'&idfuncionario='+idfuncionario); 
        }
       
    });

    $('#btnReportevalidacionobs').on('click',function(){
       var identidad=$('#cbentidadobs').val();
       var idfuncionario=$('#cbvalidadoresobs').val();

        if(identidad == -1)
        {
          alert("Debe seleccionar una Entidad");
        }
        else
        {
        //window.open(base_url + "index.php/administrador/imprimir_prueba/"+identidad);
          window.open('http://127.0.0.1:8080/VALIDACIONADM/reportes/reportevalidacionobservados.php?idEntidad='+identidad+'&idfuncionario='+idfuncionario); 
        //window.open('http://amauta.senape.gob.bo/validacion_admin/reportes/reportevalidaciontotal.php?idEntidad='+identidad+'&idfuncionario='+idfuncionario); 
        }
       
    });
    $('#btnReportevalidacionobss').on('click',function(){
       var identidad=$('#cbentidadobss').val();
       var idfuncionario=$('#cbvalidadores').val();

        if(identidad == -1)
        {
          alert("Debe seleccionar una Entidad");
        }
        else
        {
        //window.open(base_url + "index.php/administrador/imprimir_prueba/"+identidad);
          window.open('http://127.0.0.1:8080/VALIDACIONADM/reportes/reportevalidacionobservados.php?idEntidad='+identidad+'&idfuncionario='+idfuncionario); 
        //window.open('http://amauta.senape.gob.bo/validacion_admin/reportes/reportevalidaciontotal.php?idEntidad='+identidad+'&idfuncionario='+idfuncionario); 
        }
       
    });
  
  
}
