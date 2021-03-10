
<ul class="nav nav-tabs" >
    <li ><a href="<?php echo base_url()?>index.php/Entidadesd" class="validar">DECLARAN</a></li>
    <li class="active"><a href="<?php echo base_url()?>index.php/Entidadesd/entidadesbaja"  >NO DECLARAN</a></li>
</ul>
<div class="contenido">
    <h2 class="label label-info" style="font-size: 1.15em; width: 25%;">Listado de Entidades que no Declaran</h2>
</div>
<div class="row">
    <div class="col-lg-12">
          <?php  $bienes = 0;$vali = 0; $sal = 0;?>
            <table width="100%" class="table table-fit table-striped table-bordered table-hover" id="dataTables-example">
               <thead class="thead">
                <th>#</th>
                <th>Id</th>
                <th>Nombre Entidad</th>
                 <th>Sigla</th>
                <th>Usuario</th>

                <th>Departamento</th>
                <th>Estado</th>
                <th>Opción</th>
                </thead>
                <tbody>
                <? $cont = 1?>
                    <? foreach($filas as $fila):?>
                    <tr class="odd gradeX">
                      <td><?= $cont++ ?></td>
                        <td><?= $fila->identidad?></td>
                        <td><?= $fila->nombre?></td>
                        <td><?= $fila->sigla?></td>
                        <td><?= $fila->usuario?></td>

                        <td><?= $fila->departamento?></td>
                        <td><? if ($fila->declara == 't') {ECHO "DECLARA";}else{ECHO "NO DECLARA";}?></td>
                        <!-- ID: http://172.18.9.13/VALIDACIONDOCUMENTAL/index.php/inmuebles/tablasinmuebles/229 -->
                       <td><? if ($fila->declara == 't') {?><?=anchor("Entidadesd/baja/$fila->identidad",'BAJA', 'class="btn btn-primary"')?> <?}else{?><?=anchor("Entidadesd/alta/$fila->identidad",'ALTA', 'class="btn btn-primary"')?><?}?>



                        </td>

                    </tr>
                  <?endforeach?>
                </tbody>
            </table>


        </div>
    </div>
