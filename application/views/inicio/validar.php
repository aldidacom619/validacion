
<ul class="nav nav-tabs" >
    <li class="active"><a href="<?php echo base_url()?>index.php/inicio" class="validar">Entidades a Validar</a></li>
    <li><a href="<?php echo base_url()?>index.php/inicio/validadas"  >Entidades Validadas</a></li>
</ul>
<div class="contenido">
    <h2 class="label label-info" style="font-size: 1.15em;">Listado de Entidades a Validar</h2>
</div>

<div class="row">
    <div class="col-lg-12">
          <?php  $bienes = 0;$vali = 0; $sal = 0;?>
            <table width="100%" class="table table-fit table-striped table-bordered table-hover" id="dataTables-example">
               <thead class="thead">
        		<th>#</th>
        		<th>Id</th>
        		<th>Nombre Completo</th>
        		<th>Total Bienes</th>
        		<th>Total Bienes Validados</th>
        		<th>Total Bienes a Validar</th>
                <th>Total Documentos</th>
                <th>Total Documentos Validados</th>
                <th>Total Documentos a Validar</th>
        		<th>Opción</th>
        		</thead>
        		<tbody>
        		<? $cont = 1?>
              		<? foreach($filas as $fila):?>
                    <tr class="odd gradeX">
                      <td><?= $cont++ ?></td>
        				<td><?= $fila->id?></td>
        				<td><?= $fila->entidad?></td>
        				<td><?= $fila->totalbienes?></td>
        				<td><?= $fila->bienesvalidados?></td>
        				<td><?= $fila->saldo?></td>
                        <td><?= $fila->totaldocumentos?></td>
                        <td><?= $fila->totaldocumentos_val?></td>
                        <td><?= $fila->totaldocumentos_noval?></td>


                        <!-- ID: http://172.18.9.13/VALIDACIONDOCUMENTAL/index.php/inmuebles/tablasinmuebles/229 -->
        				<td><?=anchor("inmuebles/tablasinmuebles/$fila->id",'VALIDAR', 'class="btn btn-primary"')?>
        				</td>
                         <?php  $bienes = $bienes + $fila->totalbienes;
                                $vali = $vali + $fila->bienesvalidados;
                                $sal = $sal + $fila->saldo ;?>
                    </tr>
                  <?endforeach?>
                </tbody>
            </table>
            <table width="100%" class="table table-striped table-bordered table-hover" >
               <thead class="cabezera">
                <th >Total</th>
                <th>Total Bienes <span class="badge"><?= $bienes?></span></th>
                <th>Total Bienes Validados <span class="badge"><?= $vali?></span></th>
                <th>Total Bienes a Validar <span class="badge"><?= $sal?></span></th>
                </thead>
            </table>

        </div>
    </div>
