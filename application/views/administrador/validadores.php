
<div class="col-lg-12">
    <h2 class="nav-header">
    <table width="100%">
        <thead>
        <tr>
            <td align="left" width="100%"><h2 class="nav-header">Validadores</h2></td>
            <td>
                <form role="form" action="<?= base_url() ?>adminreportes/reportevalidadores" method="POST" target="_blank">
                    <div class="col-lg-12" align="right">
                        <button type="submit" class="btn btn-default" data-toggle="modal" id="btnImprimir">
                            <img border="0" width="20px" src="<?= base_url() ?>assets/icon/export_to_file.ico" alt="Generar pdf" title="Generar pdf">
                        </button>
                    </div>
                </form>
            </td>
            <td>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addValidador">
                    ADICIONAR
                </button>
            </td>

        </tr>
        </thead>
    </table>
    </h2>
</div>

<!-- /.row -->
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-hover table-bordered dataTable no-footer tableEight" id="tableEight">
                    <thead >
                        <tr style="font-size: 8pt">
                            <th style="width: 30px;">#</th>
                            <th style="width: 150px;">Nombre Validador</th>
                            <th style="width: 80px;">Entidades Asignadas</th>
                            <th style="width: 80px;">Bienes Declarados</th>
                            <th style="width: 80px;">Bienes Validados</th>
                            <th style="width: 80px;">Bienes Validar</th>
                            <th style="width: 80px;">Doc. Declarados</th>
                            <th style="width: 80px;">Doc. Validados </th>
                            <th style="width: 80px;">Doc. Validar</th>
                            <th style="width: 80px;">Activo</th>
                            <th style="width: 80px;">Admin</th>
                            <th style="width: 80px;">Entidades</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cont = 1;
                        foreach ($get as $lista) {
                            ?>
                            <tr id="filaValidador<?= $lista->idusuario ?>" class="even gradeA" style="font-size: 9pt">
                                <td id="vNro<?= $lista->idusuario ?>"><?= $cont ?></td>
                                <td id="vNombre<?= $lista->idusuario ?>"><?= $lista->nombre ?></td>
                                <td id="vTEntidades<?= $lista->idusuario ?>" align="center"><?= $lista->entidades ?></td>
                                <td id="vTBienes<?= $lista->idusuario ?>" align="center"><?= $lista->totalbienes ?></td>
                                <td id="vTBValidados<?= $lista->idusuario ?>" align="center"><?= $lista->bienesvalidados ?></td>
                                <td id="vTBSaldo<?= $lista->idusuario ?>" align="center"><?= $lista->saldo ?></td>
                                <td id="vTDocumentos<?= $lista->idusuario ?>" align="center"><?= $lista->totaldocumentos ?></td>
                                <td id="vTDValidadoss<?= $lista->idusuario ?>" align="center"><?= $lista->totaldocumentos_val ?></td>
                                <td id="vTDSaldo<?= $lista->idusuario ?>" align="center"><?= $lista->saldodoc ?></td>
                                <td id="vActivo<?= $lista->idusuario ?>" align="center"><input onchange="activo(<?= $lista->idusuario ?>)" type="checkbox" data-toggle="toggle" data-size="mini" <?= ($lista->estado_user == 't') ? 'checked ' : '' ?>></td>
                                <td id="vAdministrador<?= $lista->idusuario ?>" align="center"><input onchange="admin(<?= $lista->idusuario ?>)" type="checkbox" data-toggle="toggle" data-size="mini" <?= ($lista->administrador == 't') ? 'checked ' : '' ?>></td>
                                <td id="vEntidad<?= $lista->idusuario ?>" align="center"><a href="<?= base_url() ?>adminentidades/entidades/<?= $lista->idusuario ?>" data-toggle="modal" ><i class="fa fa-arrow-right"></i></a></td>
                            </tr>
                            <?php
                            $cont++;
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
                <div class="bs-example" aria-hidden="true">
                    <div id="alerta1" class="alert alert-warning fade in" aria-hidden="true">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Peligro!</strong> Hubo un problema con la conexionde red</a>.
                    </div>
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> Un <a href="#" class="alert-link">problema</a> ha ocurrido mientras se enviaron los datos.
                    </div>
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Exito!</strong> Procesado con éxito.
                    </div>
                    <div class="alert alert-info fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Nota!</strong> Por favor leer los <a href="#" class="alert-link">comentarios</a> cuidadosamente.
                    </div>
                </div>
            </div>
            <div class="panel-body" >
                <table width="100%" class="table table-striped table-bordered table-hover" id="tableSix" style="font-size: 9pt">
                    <thead>
                        <tr>
                            <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 30px;">Nro.</th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 150px;">Nombre Validador</th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 50px;">Usuario</th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 60px;">Adicionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? $cont = 1;
                        foreach ($datos as $dato): ?>
                        <tr id="fila<?= $dato->idfuncionario ?>" class="even gradeA">
                            <td id="nro<?= $dato->idfuncionario ?>"><?= $cont ?></td>
                            <td id="nombre<?= $dato->idfuncionario ?>"><? echo $dato->nombre; ?></td>
                            <td id="usuario<?= $dato->idfuncionario ?>"><? echo $dato->usuario; ?></td>
                            <td align="center<?= $dato->idfuncionario ?>">
                                <button id="boton<?= $dato->idfuncionario ?>" onclick="addValidador(<?= $dato->idfuncionario ?>, '<?= $dato->nombre ?>')" class="btn btn-primary" data-toggle="modal" data-target="#confirmacion">
                                    Agregar
                                </button>
                            </td>
                        </tr>
                        <?$cont++?>
                        <?endforeach?>
                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!--                <button type="button" class="btn btn-primary">Guardar</button>-->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="addEntidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Entidades Asignadas</h4>
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
<!-- Definición del primer cuadro modal oculto -->
<div id="confirmacion" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog modal-md">
        <div class="panel panel-success">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Confirmacion</h4>
            </div>
                        <div class="panel-body">
            <input type="hidden" name="idFuncionario" value="" id="idFuncionario">
            <p><center>Esta seguro(a) de agregar a
                <label id="nombreFuncionario" ></label>
                como validador?.</center>
            </p>
                        </div>
            <div class="panel-footer">
                <button id="btnAgregar" type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
                <button id="btnCancelar" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div><!-- miCuadroModal1 -->

<script type="text/javascript">
    $(".alert-warning").hide();
    $(".alert-danger").hide();
    $(".alert-success").hide();
    $(".alert-info").hide();

    function activo(id)
    {
        $.ajax({
            url: '<?= base_url() ?>adminvalidadores/activoValidador',
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
    function admin(id)
    {
        $.ajax({
            url: '<?= base_url() ?>adminvalidadores/adminValidador',
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
    var adiciono = 0;
    function addValidador(idfuncionario,nombrefuncionario)
    {
        $("#idFuncionario").val(idfuncionario);
        $("#nombreFuncionario").text(nombrefuncionario);
    }
    $( "#btnCancelar" ).click(function() {
        $("#idFuncionario").val('');
    });

    $( "#btnAgregar" ).click(function() {
        $.ajax({
            url: $("#baseUrl").val()+'validador/store',
            type: "POST",
            // data: 'idfuncionario='+$("#idFuncionario").val(),
            data: {'idfuncionario':$("#idFuncionario").val(),'item2':22},
            success: function(data) {
                var result = JSON.parse(data);
                if (result[0].id > 0){
                    $("#fila"+$("#idFuncionario").val()).remove();
                    setTimeout(function() {
                        $(".alert-success").fadeIn(50);
                    },0);
                    setTimeout(function() {
                        $(".alert-success").fadeOut(1500);
                    },2000);
                    adiciono = 1;
                }
                else{
                    setTimeout(function() {
                        $(".alert-warning").fadeIn(50);
                    },0);
                    setTimeout(function() {
                        $(".alert-warning").fadeOut(1500);
                    },2500);
                }
            },
            error: function(){
                setTimeout(function() {
                    $(".alert-danger").fadeIn(50);
                },0);
                setTimeout(function() {
                    $(".alert-danger").fadeOut(1500);
                },2000);
            }
        });
    });
    $("#addValidador").on('hidden.bs.modal', function () {
        if (adiciono === 1)
            location.href= $("#baseUrl").val()+'Adminvalidadores/validadores';
    });
    $("#confirmacion").on('hidden.bs.modal', function () {
        $("body").addClass("modal-open");
    });

</script>
