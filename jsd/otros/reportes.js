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
} 

function generarReporte(){
	
    $('#btnReporteBVD').on('click',function(){
       var identidad=$('#cbEntidadesAsignadas').val();
       var idrubro=$('#cbRubro').val();
       if(identidad==-1 || idrubro==-1){
           alert('Debe seleccionar una Entidad y un Rubro');
       }else{
           //window.open('http://127.0.0.1:8080/sistemavalidacion/reportes/reporte.validacionporrubro.php?idrubro='+idrubro+'&identidad='+identidad); 
           window.open('http://desarrollo.senape.gob.bo/sistemavalidacion/reportes/reporte.validacionporrubro.php?idrubro='+idrubro+'&identidad='+identidad); 
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
	   //	alert("Debe seleccionar el rango de fechas para generar el Reporte4546465465");
	   		//window.open('http://127.0.0.1:8080/sistemavalidacion/reportes/reporteValidacionFuncionarioFechas.php?fechainicio='+fechainicio+'&fechafin='+fechafin+'&idfuncionario='+idfuncionario); 
	   		window.open('http://desarrollo.senape.gob.bo/sistemavalidacion/reportes/reporteValidacionFuncionarioFechas.php?fechainicio='+fechainicio+'&fechafin='+fechafin+'&idfuncionario='+idfuncionario); 

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
	   		//window.open('http://127.0.0.1:8080/sistemavalidacion/reportes/reporteBienClaseEntidad.php?idEntidad='+identidad); 
	   		window.open('http://desarrollo.senape.gob.bo/sistemavalidacion/reportes/reporteBienClaseEntidad.php?idEntidad='+identidad); 
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
	 /**/
}

function generarReporte1(){
    $('#btnReporte1').on('click',function(){
       
          // window.open('http://127.0.0.1:8080/sistemavalidacion/reportes/reporteRubroGeneral.php');
       
       
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
