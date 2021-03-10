 <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Reportes</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row"> 
    <div class="col-lg-12">
        
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte Diario
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>reportes/reportevalidaciondiario" method="POST" target="_blank">
                       
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fecha inicio</label>
                                <input type="text" name="fecha1" class="form-control fecha" value="<?= $hoy ?>"  required  >
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fecha final</label>
                                <input type="text" name="fecha2" class="form-control fecha" value="<?= $hoy ?>"  required>
                            </div>
                        </div>
                        <div class="col-lg-12" align="leght">
                            <button type="submit" class="btn btn-default">Generar</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte Detalle de Validacion
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>Reportes/reportediario4" method="POST" target="_blank">
                       
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Entidades asignadas</label>
                                <select class="form-control" name="selEntidad2" id="selEntidad2" required>
                                    <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                        </div>
                        <div id="fechas" style="display: none;">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Fecha inicio</label>
                                    <input type="text" name="fecha3" class="form-control fecha" value="<?= $hoy ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Fecha final</label>
                                    <input type="text" name="fecha4" class="form-control fecha" value="<?= $hoy ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" align="leght">
                            <button type="submit" class="btn btn-default">Generar</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </form>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <!--2019 inicio observacines-->
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte Detalle de Observaciones
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>Reportes/reportediario5" method="POST" target="_blank">
                       
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Entidades asignadas</label>
                                <select class="form-control" name="selEntidad3" id="selEntidad3" required>
                                    <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                        </div>
                        <div id="fechas" style="display: none;">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Fecha inicio</label>
                                    <input type="text" name="fecha3" class="form-control fecha" value="<?= $hoy ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Fecha final</label>
                                    <input type="text" name="fecha4" class="form-control fecha" value="<?= $hoy ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" align="leght">
                            <button type="submit" class="btn btn-default">Generar</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </form>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <!--2019 fin observaciones-->




    </div>
    <!-- /.col-lg-12 -->
</div>
<script>
    $(document).ready(function(){
       
       var id = "<?php echo  $id; ?>";
     
	        $.ajax({
	            url: '<?= base_url() ?>reportes/getentidadesAsignadas/',
	            type: 'POST',
	            data: 'id=' + id,
	            success: function(data) {
	                $('#selEntidad2').html(data);
                    $('#selEntidad3').html(data);
	            }
	            
	        });

          


    });

   
   
</script>