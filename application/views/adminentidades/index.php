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
                    Lista de Entidades
                </div>
                <div class="col-xs-6" align="right">
                    <!--<button type="button" class="btn btn-outline btn-info">ADICIONAR</button>-->
                </div><div style="clear: both"></div>
            </div>
            
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Entidad</th>
                            <th>Departamento</th>
                            <th>Bienes</th>
                            <th>Validados</th>
                            <th>Documentos</th>
                            <th>Validador</th>
                        </tr>
                    </thead>
                    <tbody>    
                        <?php
                        $cont = 1;
                        foreach ($get as $lista)
                        { ?>
                            <tr class="even gradeA">
                                <td><?=$cont++?></td>
                                <td><?=$lista->entidad?></td>
                                <td><?=$lista->departamento?></td>
                                <td><?=$lista->totalbienes?></td>
                                <td><?=$lista->bienesvalidados?></td>
                                <td><?=$lista->totaldocumentos?></td>
                                <td><?=$lista->nombre?></td>
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

