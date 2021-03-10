<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Validadores</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-xs-6">
                    Lista de usuarios validadores
                </div>
                <div class="col-xs-6" align="right">
                    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addValidador">
                        ADICIONAR
                    </button>
                </div><div style="clear: both"></div>
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Sigla</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Activo</th>
                            <th>Admin</th>
                            <th>Entidades</th>
                            <th>Seguimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cont = 1;
                        foreach ($get as $lista) {
                            ?>
                            <tr class="even gradeA">
                                <td><?= $cont++ ?></td>
                                <td><?= $lista->nombre ?></td>
                                <td><?= $lista->sigla ?></td>
                                <td><?= $lista->usuario ?></td>
                                <td><?= $lista->email ?></td>
                                <td align="center"><input onchange="activo(<?= $lista->id ?>)" type="checkbox" data-toggle="toggle" data-size="mini" <?= ($lista->activo == 't') ? 'checked ' : '' ?>></td>
                                <td align="center"><input onchange="admin(<?= $lista->id ?>)" type="checkbox" data-toggle="toggle" data-size="mini" <?= ($lista->administrador == 't') ? 'checked ' : '' ?>></td>
                                <td align="center"><a href="<?= base_url() ?>adminentidades/entidades/<?= $lista->id_funcionario ?>"><i class="fa fa-arrow-right"></i> </a></td>
                                <td align="center"><a href="#" data-toggle="modal" data-target="#getSeguimiento"><i class="fa fa-arrow-right"></i> </a></td>
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="modal fade" id="addValidador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Validador</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="funcionario">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="addEntidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Entidades Asignadas</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div>
                                    Lista de Entidades
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <table width="100%" class="table table-responsive table-striped table-bordered table-hover dataTables-modal">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Sigla</th>
                                            <th>Bienes</th>
                                            <th>Validados</th>
                                            <th>Doc.</th>
                                            <th>Asignado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="modal-entidades">

                                    </tbody>
                                </table>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="getSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Seguimiento al Validador</h4>
            </div>
            <div class="modal-body">
                contenido ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function() {
        $('.funcionario').autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: "GET",
                    url: "<?= base_url() ?>adminvalidadores/getfuncionario",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            }
        });
    });
</script>
<script>
    function activo(id)
    {
        alert('a');
        $.ajax({
            url: '<?= base_url() ?>adminvalidadores/activoValidador',
            type: 'POST',
            data: 'id=' + id,
            success: function(data) {
//                alert(data);
            },
            error: function() {
                alert('Error!');
            }
        });
    }
    function admin(id)
    {
        $.ajax({
            url: '<?= base_url() ?>adminvalidadores/adminValidador',
            type: 'POST',
            data: 'id=' + id,
            success: function(data) {
//                alert(data);
            },
            error: function() {
                alert('Error!');
            }
        });
    }
    function asignaEntidades(id)
    {
        $.ajax({
            url: '<?= base_url() ?>adminvalidadores/getEntidades',
            type: 'POST',
            data: 'id=' + id,
            success: function(data) {
                $('.modal-entidades').html(data);
            },
            error: function() {
                alert('Error!');
            }
        });
    }
</script>