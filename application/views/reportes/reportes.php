<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Reportes</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte Diario
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>reportes/reportevalidaciondiario" method="POST" target="_blank">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fecha inicio</label>
                                <input type="text" name="fecha1" class="form-control fecha" value="<?= $hoy ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fecha final</label>
                                <input type="text" name="fecha2" class="form-control fecha" value="<?= $hoy ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-default">Generar</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte Detalle de Validacion
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="" method="POST" target="_blank" onsubmit="return false">
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
                        <div class="col-lg-12">
                            <!-- <button type="submit" class="btn btn-default">Generar</button> -->
                            <button class="btn btn-default" onclick="this.form.action = '/Reportes/reportediario4'; this.form.submit();">Generar</button>
                            <button class="btn btn-default" onclick="this.form.action = '/Reportes/reportediario4xls'; this.form.submit();">Exportar Excel</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte Detalle de Observaciones
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>Reportes/reportediario5" method="POST" target="_blank">
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
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-default">Generar</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte de Observaciones de la Validación Documental
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>Reportes/reportediario6" method="POST" target="_blank">

                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Entidades asignadas</label>
                                <select class="form-control" name="selEntidad4" id="selEntidad4" required>
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
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-default">Generar</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte de Titularidad de la Validación Documental
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>Reportes/reportetitularidad" method="POST" target="_blank">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Entidades asignadas</label>
                                <select class="form-control" name="selEntidad5" id="selEntidad5" required>
                                    <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-default">Generar</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Resumen Validación Documental
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="" method="POST" target="_blank" onsubmit="return false">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Entidades asignadas</label>
                                <select class="form-control" name="selEntidad9" id="selEntidad9" required>
                                    <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-default" onclick="this.form.action = '/Reportes/reportevalidaciondocumentacion'; this.form.submit();">Generar</button>
                            <button class="btn btn-default" onclick="this.form.action = '/Reportes/reportevalidaciondocumentacionxls'; this.form.submit();">Exportar Excel</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var id = "<?php echo  $id; ?>";
        $.ajax({
            url: '<?= base_url() ?>reportes/getentidadesAsignadas/',
            type: 'POST',
            data: 'id=' + id,
            success: function(data) {
                $('#selEntidad2').html(data);
                $('#selEntidad3').html(data);
                $('#selEntidad4').html(data);
                $('#selEntidad5').html(data);
                $('#selEntidad9').html(data);
            }
        });
    });
</script>