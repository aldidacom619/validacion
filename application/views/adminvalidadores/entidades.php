<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Entidades</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-xs-6">
                    Lista de Entidades asignadas al validador:<strong> <?= $validador->nombre ?></strong><br><br>
                    <div class="progress" style="background: silver;">
                        <div class="progress-bar progress-bar-success active" role="progressbar"
                             aria-valuenow="<?= $porcentajeval ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $porcentajeval ?>%">
                            <?= $porcentajeval ?>% Completado
                        </div>
                    </div>
                    <p style="margin-top: -20px">Total validados <?= (isset($totales->tval)) ? $totales->tval : '0' ?> de <?= (isset($totales->tbien)) ? $totales->tbien : '0' ?> bienes.</p>
                </div>
                <div class="col-xs-6" align="right">
                    <a href="<?= base_url() ?>adminvalidadores/validadores" class="btn btn-primary btn-lg">
                        <span class="fa fa-arrow-left"></span> Volver
                    </a>
                    <!--<a class="btn btn-primary btn-lg" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">-->
                    <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#getEntidades">
                        <span class="fa fa-plus"></span> ADICIONAR
                    </a>
                </div>
                <div class="col-xs-12">
                    <br>
                    <div class="panel panel-default">
                        <div id="collapseTwo" class="panel-collapse collapse"> 
                            <div class="panel-body">
                                <form action="<?= base_url() ?>adminentidades/asignarentidad" method="POST">
                                    <!--                                    <div class="col-xs-2">
                                                                            <input maxlength="4" type="text" name="gestion" class="form-control" placeholder="gestion">
                                                                        </div>-->
                                    <div class="col-xs-12">
                                        <div class="form-group input-group">
                                            <input type="hidden" class="identidad" name="identidad">
                                            <input type="hidden" class="idvalidador" name="idvalidador" value="<?= $idvalidador ?>">
                                            <input type="text" name="autocompletar" maxlength="50" class="form-control autocompletar" placeholder="Escribe en nombre de la entidad">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default asignar" type="submit" disabled><i class="fa fa-plus"> ASIGNAR</i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr style="font-size: 8pt">
                            <th>#</th>
                            <th>Entidad</th>
                            <!--<th>Departamento</th>-->
                            <th>Bienes declarados</th>
                            <th>Bienes validados</th>
                            <th>Documentos declarados</th>
                            <th>Documentos validados</th>
                            <th>Documentos por validar</th>
                            <th>Documentos agregados</th>
                            <th>Documentos agregados validados</th>
                            <th>Documentos agregados por validar</th>
                            <th>Fecha asignación</th>
                            <th>Habilitar Edición</th>
                            <th>Desasignar</th>
                            <th>Rubro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cont = 1;
                        foreach ($get as $lista) {
                            ?>
                            <tr class="even gradeA">
                                <td><?= $cont++ ?></td>
                                <td><?= $lista->nombre . ' [' . $lista->departamento . ']' ?></td>
    <!--                                <td><?= $lista->departamento ?></td>-->
                                <td><?= $lista->totalbienes ?></td>
                                <td><?= $lista->bienesvalidados ?></td>
                                <td><?= $lista->totaldocumentos  ?></td>
                                <td><?= $lista->totaldocumentos_val  ?></td>
                                <td><?= $lista->totaldocumentos_noval  ?></td>
                                <td><?= $lista->totaldocumentos_adicionado ?></td>
                                <td><?= $lista->totaldocumentos_adicionado ?></td>
                                <td><?= $lista->totaldocumentos_adicionado ?></td>
                                <td><?= $lista->fecha_asignacion ?></td>
                                <td id="vActivo<?= $lista->idusuario ?>" align="center"><input onchange="activoasiginuverso(<?=  $lista->iduu ?>)" type="checkbox" data-toggle="toggle" data-size="mini" <?= ($lista->estadoentidad == 1) ? 'checked ' : '' ?>></td>
                                <td align="center"><a href="#" alt="Desasignar" onclick="asignado(<?= $lista->iduu ?>)"><span class="fa fa-trash"></span></a></td>
                                <td align="center"><a href="#" alt="Rubros" onclick="documentos(<?= $lista->identidad ?>)" data-toggle="modal" data-target="#getSeguimiento"><i class="fa fa-arrow-right"></i> </a></td>
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
<div class="modal fade" id="getEntidades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Entidades</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Entidad</th>
                                    <th>Estado</th>
                                    <th>Opcion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cont = 1;
                                foreach ($entidades as $entidad) {
                                    ?>
                                    <tr>
                                        <td><?= $cont++ ?></td>
                                        <td><?= $entidad->entidad ?></td>
                                        <td><?= ($entidad->validador == NULL) ? '<span class="alert-success">[DISPONIBLE]</span>' : '<span class="alert-danger">' . $entidad->validador . '</span>' ?></td>
                                        <td><?= ($entidad->validador == NULL) ? '<button onclick="asignar(' . $entidad->identidad . ',' . $idvalidador . ')" class="btn btn-primary">Asignar</button>' : '-' ?></td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "modal-footer">
                <button type = "button" class = "btn btn-default" data-dismiss = "modal">Cerrar</button>
            </div>
        </div>
        <!--/.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div>

<div class = "modal fade" id = "getSeguimiento" tabindex = "-1" role = "dialog" aria-labelledby = "myModalLabel" aria-hidden = "true">
    <div class = "modal-dialog">
        <div class = "modal-content">
            <div class = "modal-header">
                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">&times;
                </button>
                <h4 class = "modal-title" id = "myModalLabel">Detalle de Rubros</h4>
            </div>
            <div class = "modal-body">
                <div class = "panel panel-default">
                    <div class = "panel-body">
                        <table width = "100%" class = "table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                <!--<th>#</th>-->
                                    <th>Rubro</th>
                                    <th>Bienes a validar</th>
                                    <th>Bienes validados</th>
                                </tr>
                            </thead>
                            <tbody class = "modal-documentos">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "modal-footer">
                <button type = "button" class = "btn btn-default" data-dismiss = "modal">Cerrar</button>
            </div>
        </div>
        <!--/.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div>
<script>
    $(function() {
        $(".autocompletar").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>adminentidades/autocompletar",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                if (!ui.item.idvalidador)
                {
                    $('.asignar').removeAttr('disabled');
                    $('.autocompletar').val(ui.item.entidad);
                    $('.identidad').val(ui.item.identidad);
                } else
                {
                    if (ui.item.asignado == 't')
                    {
                        $('.asignar').attr('disabled', 'disabled');
                        $('.autocompletar').val(ui.item.entidad);
                        $('.identidad').val('none');
                    } else {
                        $('.asignar').removeAttr('disabled');
                        $('.autocompletar').val(ui.item.entidad);
                        $('.identidad').val(ui.item.identidad);
                    }
                }
                return false;
            }
        }).autocomplete("instance")._renderItem = function(ul, item)
        {
            if (item.entidad)
            {
                if (item.asignado == 't')
                {
                    if (item.validador)
                    {
                        return $("<li class='alert alert-danger'>")
                                .append("" + item.entidad + " - [ " + item.validador + " ]<br>")
                                .appendTo(ul);
                    } else
                    {
                        return $("<li class='alert alert-danger'>")
                                .append("" + item.entidad + " - [ NO DISPONIBLE ]<br>")
                                .appendTo(ul);
                    }
                } else
                {
                    return $("<li class='alert alert-success'>")
                            .append("" + item.entidad + " - [ DISPONIBLE ]<br>")
                            .appendTo(ul);
                }
            } else
            {
                return $("<li>")
                        .appendTo(ul);
            }
        };
    });
    function asignado(id)
    {
        if (confirm("Esta seguro de desasignar esta entidad?")) {
            $.ajax({
                url: '<?= base_url() ?>adminentidades/asignadoestadovalidador',
                type: 'POST',
                data: 'id=' + id,
                success: function(data) {
                    location.reload();
                },
                error: function() {
                    alert('Error!');
                }
            });
        } else {
            return false;
        }
    }
    function asignar(identidad, idvalidador)
    {
        if (confirm("Esta seguro de asignar esta entidad?")) {
            var parametros = {
                "identidad": identidad,
                "idvalidador": idvalidador
            };
            $.ajax({
                url: '<?= base_url() ?>adminentidades/asignarentidad',
                type: 'POST',
                data: parametros,
                success: function(data) {
                    location.reload();
                },
                error: function() {
                    alert('Error!');
                }
            });
        } else {
            return false;
        }
    }
    function documentos(id)
    {
        $.ajax({
            url: '<?= base_url() ?>adminentidades/getdocumentosEntidades',
            type: 'POST',
            data: 'id=' + id,
            success: function(data) {
                $('.modal-documentos').html(data);
            },
            error: function() {
                alert('Error!');
            }
        });
    }
     function activoasiginuverso(id)
    {
        
        $.ajax({
            url: '<?= base_url() ?>adminentidades/activarentidaduniverso',
            type: 'POST',
            data: 'id=' + id,
            success: function(data) {
//                                                alert(data);
            },
            error: function() {
                alert('Error!');
            }
        });
    }
</script>