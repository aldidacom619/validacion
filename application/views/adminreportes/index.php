<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Reportes</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte General
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>adminreportes/reportegeneral" method="GET" target="_blank">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Validador</label>
                                <select class="form-control" onchange="entidades(1)" name="selValidador1" id="selValidador1" required>
                                    <option value="all">-- Todos --</option>
                                    <?php
                                    foreach ($getuser as $user) {
                                        echo '<option value="' . $user->id_funcionario . '">' . $user->nombre . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Entidades asignadas</label>
                                <select class="form-control" name="selEntidad1" id="selEntidad1">
                                    <option value="all">-- Todos --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12" align="right">
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
                Reporte Diario
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>adminreportes/reportevalidaciondiario" method="GET" target="_blank">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Validador</label>
                                <select class="form-control" name="selValidador" id="selValidador" required>
                                    <option value="">-- Seleccione --</option>
                                    <?php
                                    foreach ($getuser as $user) {
                                        echo '<option value="' . $user->id_funcionario . '">' . $user->nombre . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fecha inicio</label>
                                <input type="text" name="fecha1" class="form-control fecha" value="<?= $hoy ?>" required">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fecha final</label>
                                <input type="text" name="fecha2" class="form-control fecha" value="<?= $hoy ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-12" align="right">
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
                    <form role="form" action="" method="GET" target="_blank" onsubmit="return false">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Validador</label>
                                <select class="form-control" onchange="entidades(2)" name="selValidador2" id="selValidador2" required>
                                    <option value="">-- Seleccione --</option>
                                    <?php
                                    foreach ($getuser as $user) {
                                        echo '<option value="' . $user->id_funcionario . '">' . $user->nombre . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Entidades asignadas</label>
                                <select class="form-control" name="selEntidad2" id="selEntidad2" required>
                                    <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                        </div>
                        <div id="fechas" style="display: none">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Fecha inicio</label>
                                    <input type="text" name="fecha3" class="form-control fecha" value="<?= $hoy ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Fecha final</label>
                                    <input type="text" name="fecha4" class="form-control fecha" value="<?= $hoy ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" align="right">
                            <!-- <button type="submit" class="btn btn-default">Generar</button> -->
                            <button class="btn btn-default" onclick="this.form.action = 'adminreportes/reportediario4'; this.form.submit();">Generar</button>
                            <button class="btn btn-default" onclick="this.form.action = 'adminreportes/reportediario4xls'; this.form.submit();">Exportar Excel</button>
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
                    <form role="form" action="<?= base_url() ?>adminreportes/reportediario6" method="GET" target="_blank">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Validador 2020</label>
                                <select class="form-control" onchange="entidades(4)" name="selValidador4" id="selValidador4" required>
                                    <option value="">-- Seleccione --</option>
                                    <?php echo $getuser;
                                    foreach ($getuser as $user) {
                                        echo '<option value="' . $user->id_funcionario . '">' . $user->nombre . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Entidades asignadas</label>
                                <select class="form-control" name="selEntidad4" id="selEntidad4" required>
                                    <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                        </div>
                        <div id="fechas" style="display: none">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Fecha inicio</label>
                                    <input type="text" name="fecha3" class="form-control fecha">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Fecha final</label>
                                    <input type="text" name="fecha4" class="form-control fecha">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" align="right">
                            <button type="submit" class="btn btn-default">Generar</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte de Avance General de Validacíon Documental
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>adminreportes2/reporteAvanceGeneral/<?= $_SESSION['idfuncionario']; ?>" method="POST" target="_blank">
                        <div class="col-lg-12" align="right">
                            <button type="submit" class="btn btn-default">Generar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte de Validacion por Departamento
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>adminreportes2/reporteValidacionDepartamento/<?= $_SESSION['idfuncionario']; ?>" method="POST" target="_blank">
                        <div class="col-lg-12" align="right">
                            <button type="submit" class="btn btn-default">Generar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporte General de Avance de Validacion por Servidor Público
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?= base_url() ?>adminreportes2/reporteAvanceServidor/<?= $_SESSION['idfuncionario']; ?>" method="POST" target="_blank">
                        <div class="col-lg-12" align="right">
                            <button type="submit" class="btn btn-default">Generar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function entidades(idselector) {
        var id = $('#selValidador' + idselector).val();
        if (id > 0)
            $.ajax({
                url: '<?= base_url() ?>adminreportes/entidadesAsignadas/' + idselector,
                type: 'POST',
                data: 'id=' + id,
                success: function(data) {
                    $('#selEntidad' + idselector).html(data);
                },
                error: function() {
                    alert('Error!');
                }
            });
        else
        if (idselector === 1)
            $('#selEntidad' + idselector).html('<option value="all">-- Todos --</option>');
        else
            $('#selEntidad' + idselector).html('<option value="">-- Seleccione --</option>');

    }
</script>