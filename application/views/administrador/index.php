<script type="text/javascript" src="<?php echo  base_url() ?>jsd/principal.js"></script><!--2019 hist-->
<div class="row">
    <div class="col-xs-12">
        <table width="100%">
            <thead>
            <tr>
                <td align="left" width="100%"><h2 class="nav-header">Entidades</h2></td>
                <td>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#graficos">
                        <img border="0" width="35px" src="<?= base_url() ?>assets/icon/estadistica.ico" alt="Ver estadistica" title="Ver Graficos">
                    </button>
                </td>
            </tr>
            </thead>
        </table>
        <table width="100%" class="table table-striped table-bordered dataTable no-footer" id="tableResumen">
            <thead >
            <tr role="row" style="font-size: 8pt">
                <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 145px;">Tipo</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 80px;">Total Entidades</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 80px;">Total Documentos</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 80px;">Documentos Validados</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 80px;">Total Bienes</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 80px;">Bienes Validados</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $cont = 1;
            $tEntidades = 0;
            $tBienes = 0;
            $tBiensVal = 0;
            $tDocumentos = 0;
            $tDocumentosVal = 0;
            $data = null;
            foreach ($entidadesr as $lista) {
                ?>
                <tr role="row" class="odd" style="font-size: 9pt">
                    <th><?= $lista->tipo ?></th>
                    <td><?= $lista->t_entidades ?></td>
                    <td><?= $lista->t_doc ?></td>
                    <td><?= $lista->t_doc_val ?></td>
                    <td><?= $lista->t_bienes ?></td>
                    <td><?= $lista->ast_bval ?></td>
                </tr>
                <?php
                $label = substr($lista->tipo,10);
                $asignacion[] = ['name' => $label,'y' => 0+$lista->t_entidades];
                $cont++;
                $tEntidades = $tEntidades + $lista->t_entidades;
                $tBienes = $tBienes + $lista->t_bienes;
                $tBiensVal = $tBiensVal + $lista->ast_bval;
                $tDocumentosVal = $tDocumentosVal + $lista->t_doc_val;
                $tDocumentos = $tDocumentos + $lista->t_doc;
                $dataTD[] = 0+$lista->t_doc;
                $dataTD[] = 0+$lista->t_doc_val;
                $dataTD[] = 0+$lista->t_bienes;
                $dataTD[] = 0+$lista->ast_bval;
                $documentos[] = ['name' => $label,'data' => $dataTD];
                unset($dataTD);
            }
            $asignacion = json_encode($asignacion);
            $documentos =json_encode($documentos);
            ?>
            </tbody>
            <tfoot>
            <tr role="row" class="odd" style="font-size: 9pt">
                <td>Totales</td>
                <td><?= $tEntidades ?></td>
                <td><?= $tDocumentos ?></td>
                <td><?= $tDocumentosVal ?></td>
                <td><?= $tBienes ?></td>
                <td><?= $tBiensVal ?></td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-xs-6">
        <table>
            <thead>
            <tr>
                <td align="left" width="100%"><h3>Entidades Por Asignar</h3>
                </td>
                <td>
                    <form role="form" action="<?= base_url() ?>adminreportes/reporteentidadesasignar" method="POST" target="_blank">
                        <div class="col-lg-12" align="right">
                            <button type="submit" class="btn btn-default" data-toggle="modal" id="btnImprimir">
                                <img border="0" width="25px" src="<?= base_url() ?>assets/icon/export_to_file.ico" alt="Generar pdf" title="Generar pdf">
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
            </thead>
        </table>
        <div class="panel panel-default">
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered dataTable no-footer tableEight" id="tableEight">
                    <thead >
                    <tr role="row" style="font-size: 8pt">
                        <th style="width: 30px;">#</th>
                        <th style="width: 180px;">Nombre Entidad</th>
                        <th style="width: 70px;">Distrito</th>
                        <th style="width: 70px;">Total Bienes</th>
                        <th style="width: 70px;">Total Documentos</th>
                        <th style="width: 70px;">Validadores</th><!--2019 hist-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $cont = 1;
                    foreach ($entidades as $lista) {
                        ?>
                        <tr id="filaValidador<?= $lista->id ?>" role="row" class="odd" style="font-size: 9pt">
                            <td><?= $cont ?></td>
                            <td><?= $lista->nombre ?></td>
                            <td><?= $lista->departamento ?></td>
                            <td><?= $lista->totaldocumentos ?></td>
                            <td><?= $lista->totalbienes ?></td>
                            <td><button type="button" class="btn btn-warning" onclick="MostVAlidadores(<?= $lista->id ?>,'<?= $lista->nombre ?>')">Mostrar</button></td><!--2019 hist-->
                        </tr>
                        <?php
                        $cont++;
                    }
                    ?>
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <table>
            <thead>
            <tr>
                <td align="left" width="100%"><h3>Entidades Asignadas</h3></td>
                <td>
                    <form role="form" action="<?= base_url() ?>adminreportes/reporteentidadesasignados" method="POST" target="_blank">
                        <div class="col-lg-12" align="right">
                            <button type="submit" class="btn btn-default" data-toggle="modal" id="btnImprimir">
                                <img border="0" width="25px" src="<?= base_url() ?>assets/icon/export_to_file.ico" alt="Generar pdf" title="Generar pdf">
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
            </thead>
        </table>
        <div class="panel panel-default">
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered dataTable no-footer tableEight" id="tableEight">
                    <thead >
                    <tr role="row" style="font-size: 8pt" >
                        <th style="width: 30px;">#</th>
                        <th style="width: 180px;">Nombre Entidad</th>
                        <th style="width: 70px;">Distrito</th>
                        <th style="width: 70px;">Total Bienes</th>
                        <th style="width: 70px;">Total Documentos</th>
                        <th style="width: 70px;">Validadores</th><!--2019 hist-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $cont = 1;
                    foreach ($entidadesn as $lista) {
                        ?>
                        <tr id="filaValidador<?= $lista->id ?>" role="row" class="odd" style="font-size: 9pt">
                            <td><?= $cont ?></td>
                            <td><?= $lista->nombre ?></td>
                            <td><?= $lista->departamento ?></td>
                            <td><?= $lista->totalbienes ?></td>
                            <td><?= $lista->totaldocumentos ?></td>
                            <td><button type="button" class="btn btn-warning" onclick="MostVAlidadores(<?= $lista->identidad ?>,'<?= $lista->nombre ?>')">Mostrar</button></td><!--2019 hist-->
                        </tr>
                        <?php
                        $cont++;
                    }
                    ?>
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="graficos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="col-xs-10 col-lg-offset-1">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Gráficos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Asignación de Entidades
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-pie-chart"></div>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Documentos Validados
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-pie-chart2"></div>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!--                <button type="button" class="btn btn-primary">Guardar</button>-->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<!--2019 hist-->
<div id = "largeModalhistValidadores" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-full" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title label label-info">ENTIDAD: <label style="font-size: small;" id="nombre_ent"></label></h2>
      </div>
        <div class="modal-body">

                    <table id="HistorialTable2" class="able table-striped table-bordered dataTable no-footer" style="font-size: 9pt;">
                         <thead >
                        <tr class="bg-grey-300">
                            <th width="5%">Nro.</th>
                            <th width="95%">NOMBRE</th>
                        </tr>
                      </thead>
                    <tbody >                    
                        
                    </tbody>                               
                                        
                    </table>
      </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          
      </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>

<script type="text/javascript">
   var enlace = "<?php echo  base_url() ?>";  //2019
      baseurl(enlace); //2019
    function formatDate(date) {
        var monthNamesI = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        var monthNamesE = [
            "Enero", "Febrero", "Marzo",
            "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre",
            "Noviembre", "Deciembre"
        ];
        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();
        return monthNamesE[monthIndex] + ' ' + day + ' de ' + year;
    }
    var fechaActual = formatDate(new Date());
    //Flot Pie Chart
    var data = <?=$asignacion?>;
    Highcharts.chart('flot-pie-chart', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
            margin: [0, 0, 0, 0],
            spacingTop: 0,
            spacingBottom: 0,
            spacingLeft: 0,
            spacingRight: 0
        },
        title: {
            text: 'Entidades Asignación'
        },
        subtitle: {
            text: 'Fuente: <a href="">senape.gob.bo, </a><br>'+fechaActual
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                size:'45%',
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>:<br> {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: data
        }]
    });

    data = <?=$documentos?>;
    var categories = ['Total <br> Documentos', 'Total <br> Documentos <br> Validados', 'Total <br> Bienes', 'Total <br> Bienes <br> Validados'];
    Highcharts.chart('flot-pie-chart2', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Documentos, Bienes Validados'
        },
        subtitle: {
            text: 'Fuente: <a href="">senape.gob.bo </a><br>'+fechaActual
        },
        xAxis: {
            categories: categories,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Validación Documentos (miles)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' millions'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -2,
            y: 20,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: true
        },
        series: data
    });



</script>
