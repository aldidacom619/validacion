<?php
/**
 * Created by PhpStorm.
 * User: framos
 * Date: 2/8/2017
 * Time: 5:52 PM
 */
?>

<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-validadores">
    <thead>
    <tr>
        <th colspan="7" >
            <a onclick="" style="cursor:pointer;"><img border="0" width="30px" src="<?php echo  base_url() ?>images/iconosabm/cancel_icon.png" alt="Nuevo Validador" title="Nuevo Validador"></a>
            <a onclick="" style="cursor:pointer;"><img border="0" width="30px" src="<?php echo  base_url() ?>images/iconosabm/cancel_icon.png" alt="Detalle Proceso" title="Detalle Proceso"></a>
            <a onclick=adicionarValidador() style="cursor:pointer;"><img border="0" width="30px" src="<?php echo  base_url() ?>images/iconosabm/cancel_icon.png" alt="Detalle Proceso" title="Detalle Proceso"></a>
        </th>
    </tr>
    <tr>
        <th>#</th>
        <th>Nombre Validador</th>
        <th>Nro. Entidades</th>
        <th>Nro. Inmuebles</th>
        <th>Adicionar</th>
        <th>Validador</th>
        <th>Seg. Dia</th>
    </tr>
    </thead>
    <tbody>
    <? $cont = 1;
    foreach ($datos as $dato): ?>
        <tr class="even gradeA">
            <td><?=$cont++?></td>
            <td><? echo $dato->nombre; ?></td>
            <td><? echo $dato->id; ?></td>
            <td>100</td>
            <td>
                <button id="btn1" ><img border="0" width="20px" src="<?php echo  base_url() ?>/images/iconosabm/editar-25x25.png" alt="opcion1" title="opcion1"></button>
            </td>
            <td>
                <a onclick="" style="cursor:pointer;"><img border="0" width="20px" src="<?php echo  base_url() ?>/images/iconosabm/editar-25x25.png" alt="Detalle Proceso" title="Detalle Proceso"></a>
            </td>
            <td>
                <a onclick="" style="cursor:pointer;"><img border="0" width="20px" src="<?php echo  base_url() ?>/images/iconosabm/cancel_icon.png" alt="Detalle Proceso" title="Detalle Proceso"></a>
            </td>
        </tr>
    <?endforeach?>
    </tbody>
</table>
