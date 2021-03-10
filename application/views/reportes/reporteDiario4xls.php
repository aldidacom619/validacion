<?php
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=reportexls.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<html>

<head>

</head>

<body>
    <table border="1">
        <caption>
            <?= utf8_decode($titulo) ?><br>
            <?= utf8_decode('Validador: ' . $validador->nombre) ?><br>
            <?= utf8_decode($subtitulo) ?> <br>
            <?= utf8_decode('RUBRO INMUEBLES') ?>
        </caption>
        <thead>
            <tr style="background-color: #0592ff;color: #fff;">
                <th><?= utf8_decode('N°'); ?></th>
                <th><?= utf8_decode('Id Bien'); ?></th>
                <th><?= utf8_decode('Id Doc.'); ?></th>
                <th><?= utf8_decode('Descripción'); ?></th>
                <th><?= utf8_decode('Adjunta'); ?></th>
                <th><?= utf8_decode('Corresponde'); ?></th>
                <th><?= utf8_decode('Legible'); ?></th>
                <th><?= utf8_decode('N° Documento'); ?></th>
                <th><?= utf8_decode('Superficie'); ?></th>
                <th><?= utf8_decode('Dirección'); ?></th>
                <th><?= utf8_decode('Obs. General'); ?></th>
                <th><?= utf8_decode('Cod. Observación'); ?></th>
                <th><?= utf8_decode('Fecha Validación'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cont = 0;
            foreach ($inmuebles as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td><?= $dato->iddoc; ?></td>
                    <td><?= $dato->descripcion; ?></td>
                    <td><?= $dato->adjunta; ?></td>
                    <td><?= $dato->idcorrespondencia; ?></td>
                    <td><?= $dato->legible; ?></td>
                    <td><?= $dato->cdocumento; ?></td>
                    <td><?= $dato->csuperficie; ?></td>
                    <td><?= $dato->cdireccion; ?></td>
                    <td><?= $dato->observacionesgeneral; ?></td>
                    <td><?= $dato->observaciones; ?></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            foreach ($inmueblesdoc as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td></td>
                    <td><?= utf8_decode('SIN DOCUMENTACIÓN') ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <p>
        <?php
        foreach ($codigosinmuebles as $dato) {
        ?>
            <?= utf8_decode('Código: ' . $dato->id . ' = ' . $dato->descripcion) ?> <br>
        <?php
        }
        ?>
    </p>

    <table border="1">
        <caption>
            <?= utf8_decode($titulo) ?><br>
            <?= utf8_decode('Validador: ' . $validador->nombre) ?><br>
            <?= utf8_decode($subtitulo) ?> <br>
            <?= utf8_decode('RUBRO VEHÍCULOS') ?>
        </caption>
        <thead>
            <tr style="background-color: #0592ff;color: #fff;">
                <th><?= utf8_decode('N°'); ?></th>
                <th><?= utf8_decode('Id Bien'); ?></th>
                <th><?= utf8_decode('Id Doc.'); ?></th>
                <th><?= utf8_decode('Descripción'); ?></th>
                <th><?= utf8_decode('Adjunta'); ?></th>
                <th><?= utf8_decode('Corresponde'); ?></th>
                <th><?= utf8_decode('Legible'); ?></th>
                <th><?= utf8_decode('N° Documento'); ?></th>                
                <th><?= utf8_decode('Tipo'); ?></th>
                <th><?= utf8_decode('Clase'); ?></th>
                <th><?= utf8_decode('Marca'); ?></th>
                <th><?= utf8_decode('Placa'); ?></th>
                <th><?= utf8_decode('N° Motor'); ?></th>
                <th><?= utf8_decode('N° Clasis'); ?></th>
                <th><?= utf8_decode('Procedencia'); ?></th>
                <th><?= utf8_decode('Modelo'); ?></th>
                <th><?= utf8_decode('Color'); ?></th>
                <th><?= utf8_decode('Obs. General'); ?></th>
                <th><?= utf8_decode('Cod. Observación'); ?></th>
                <th><?= utf8_decode('Fecha Validación'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cont = 0;
            foreach ($vehiculos as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td><?= $dato->iddoc; ?></td>
                    <td><?= $dato->descripcion; ?></td>
                    <td><?= $dato->adjunta; ?></td>
                    <td><?= $dato->idcorrespondencia; ?></td>
                    <td><?= $dato->legible; ?></td>
                    <td><?= $dato->cdocumento; ?></td>
                    <td><?= $dato->ctipo; ?></td>
                    <td><?= $dato->cclase; ?></td>
                    <td><?= $dato->cmarca; ?></td>
                    <td><?= $dato->cplaca; ?></td>
                    <td><?= $dato->cmotor; ?></td>
                    <td><?= $dato->cchasis; ?></td>
                    <td><?= $dato->cprocedencia; ?></td>
                    <td><?= $dato->cmodelo; ?></td>
                    <td><?= $dato->ccolor; ?></td>
                    <td><?= $dato->observacionesgenerales; ?></td>
                    <td><?= $dato->observaciones; ?></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            foreach ($vehiculosdoc as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td></td>
                    <td><?= utf8_decode('SIN DOCUMENTACIÓN') ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <p>
        <?php
        foreach ($codigosvehiculos as $dato) {
        ?>
            <?= utf8_decode('Código: ' . $dato->id . ' = ' . $dato->descripcion) ?> <br>
        <?php
        }
        ?>
    </p>

    <table border="1">
        <caption>
            <?= utf8_decode($titulo) ?><br>
            <?= utf8_decode('Validador: ' . $validador->nombre) ?><br>
            <?= utf8_decode($subtitulo) ?> <br>
            <?= utf8_decode('RUBRO MAQUINARIA Y EQUIPOS') ?>
        </caption>
        <thead>
            <tr style="background-color: #0592ff;color: #fff;">
                <th><?= utf8_decode('N°'); ?></th>
                <th><?= utf8_decode('Id Bien'); ?></th>
                <th><?= utf8_decode('Id Doc.'); ?></th>
                <th><?= utf8_decode('Descripción'); ?></th>
                <th><?= utf8_decode('Adjunta'); ?></th>
                <th><?= utf8_decode('Corresponde'); ?></th>
                <th><?= utf8_decode('Legible'); ?></th>
                <th><?= utf8_decode('N° Documento'); ?></th>
                <th><?= utf8_decode('Equipo'); ?></th>
                <th><?= utf8_decode('Obs. General'); ?></th>
                <th><?= utf8_decode('Cod. Observación'); ?></th>
                <th><?= utf8_decode('Fecha Validación'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cont = 0;
            foreach ($maquinariaequipos as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td><?= $dato->iddoc; ?></td>
                    <td><?= $dato->descripcion; ?></td>
                    <td><?= $dato->adjunta; ?></td>
                    <td><?= $dato->idcorrespondencia; ?></td>
                    <td><?= $dato->legible; ?></td>
                    <td><?= $dato->cdocumento; ?></td>
                    <td><?= $dato->cequipo; ?></td>
                    <td><?= $dato->observacionesgenerales; ?></td>
                    <td><?= $dato->observaciones; ?></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            foreach ($maquinariaequiposdoc as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td></td>
                    <td><?= utf8_decode('SIN DOCUMENTACIÓN') ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <p>
        <?php
        foreach ($codigosmaquinariaequipos as $dato) {
        ?>
            <?= utf8_decode('Código: ' . $dato->id . ' = ' . $dato->descripcion) ?> <br>
        <?php
        }
        ?>
    </p>

    <table border="1">
        <caption>
            <?= utf8_decode($titulo) ?><br>
            <?= utf8_decode('Validador: ' . $validador->nombre) ?><br>
            <?= utf8_decode($subtitulo) ?> <br>
            <?= utf8_decode('RUBRO MAQUINARIA PESADA') ?>
        </caption>
        <thead>
            <tr style="background-color: #0592ff;color: #fff;">
                <th><?= utf8_decode('N°'); ?></th>
                <th><?= utf8_decode('Id Bien'); ?></th>
                <th><?= utf8_decode('Id Doc.'); ?></th>
                <th><?= utf8_decode('Descripción'); ?></th>
                <th><?= utf8_decode('Adjunta'); ?></th>
                <th><?= utf8_decode('Corresponde'); ?></th>
                <th><?= utf8_decode('Legible'); ?></th>
                <th><?= utf8_decode('N° Documento'); ?></th>
                <th><?= utf8_decode('Equipo'); ?></th>
                <th><?= utf8_decode('Marca'); ?></th>
                <th><?= utf8_decode('Modelo'); ?></th>
                <th><?= utf8_decode('Chasis'); ?></th>
                <th><?= utf8_decode('Motor'); ?></th>
                <th><?= utf8_decode('Color'); ?></th>
                <th><?= utf8_decode('Obs. General'); ?></th>
                <th><?= utf8_decode('Cod. Observación'); ?></th>
                <th><?= utf8_decode('Fecha Validación'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cont = 0;
            foreach ($maquinariapesadas as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td><?= $dato->iddoc; ?></td>
                    <td><?= $dato->descripcion; ?></td>
                    <td><?= $dato->adjunta; ?></td>
                    <td><?= $dato->idcorrespondencia; ?></td>
                    <td><?= $dato->legible; ?></td>
                    <td><?= $dato->cdocumento; ?></td>
                    <td><?= $dato->cdescripcion; ?></td>
                    <td><?= $dato->cmarca; ?></td>
                    <td><?= $dato->cmodelo; ?></td>
                    <td><?= $dato->cchasis; ?></td>
                    <td><?= $dato->cmotor; ?></td>
                    <td><?= $dato->ccolor; ?></td>
                    <td><?= $dato->observacionesgenerales; ?></td>
                    <td><?= $dato->observaciones; ?></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            foreach ($maquinariapesadasdoc as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td></td>
                    <td><?= utf8_decode('SIN DOCUMENTACIÓN') ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <p>
        <?php
        foreach ($codigosmaquinariapesadas as $dato) {
        ?>
            <?= utf8_decode('Código: ' . $dato->id . ' = ' . $dato->descripcion) ?> <br>
        <?php
        }
        ?>
    </p>

    <table border="1">
        <caption>
            <?= utf8_decode($titulo) ?><br>
            <?= utf8_decode('Validador: ' . $validador->nombre) ?><br>
            <?= utf8_decode($subtitulo) ?> <br>
            <?= utf8_decode('RUBRO INMUEBLES EN ALQUILER') ?>
        </caption>
        <thead>
            <tr style="background-color: #0592ff;color: #fff;">
                <th><?= utf8_decode('N°'); ?></th>
                <th><?= utf8_decode('Id Bien'); ?></th>
                <th><?= utf8_decode('Id Doc.'); ?></th>
                <th><?= utf8_decode('Descripción'); ?></th>
                <th><?= utf8_decode('Adjunta'); ?></th>
                <th><?= utf8_decode('Corresponde'); ?></th>
                <th><?= utf8_decode('Legible'); ?></th>
                <th><?= utf8_decode('N° Documento'); ?></th>
                <th><?= utf8_decode('Departamento'); ?></th>
                <th><?= utf8_decode('Dirección'); ?></th>
                <th><?= utf8_decode('Inicio contrato'); ?></th>
                <th><?= utf8_decode('Fin contrato'); ?></th>
                <th><?= utf8_decode('Canon alquiler'); ?></th>
                <th><?= utf8_decode('Obs. General'); ?></th>
                <th><?= utf8_decode('Cod. Observación'); ?></th>
                <th><?= utf8_decode('Fecha Validación'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cont = 0;
            foreach ($inmueblesalquiler as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td><?= $dato->iddoc; ?></td>
                    <td><?= $dato->descripcion; ?></td>
                    <td><?= $dato->adjunta; ?></td>
                    <td><?= $dato->idcorrespondencia; ?></td>
                    <td><?= $dato->legible; ?></td>
                    <td><?= $dato->cdocumento; ?></td>
                    <td><?= $dato->cdepartamento; ?></td>
                    <td><?= $dato->cdireccion; ?></td>
                    <td><?= $dato->ciniciocontrato; ?></td>
                    <td><?= $dato->cfincontrato; ?></td>
                    <td><?= $dato->ccanonalquiler; ?></td>
                    <td><?= $dato->observacionesgenerales; ?></td>
                    <td><?= $dato->observaciones; ?></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            foreach ($inmueblesalquilerdoc as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td></td>
                    <td><?= utf8_decode('SIN DOCUMENTACIÓN') ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <p>
        <?php
        foreach ($codigosinmueblesalquiler as $dato) {
        ?>
            <?= utf8_decode('Código: ' . $dato->id . ' = ' . $dato->descripcion) ?> <br>
        <?php
        }
        ?>
    </p>

    <table border="1">
        <caption>
            <?= utf8_decode($titulo) ?><br>
            <?= utf8_decode('Validador: ' . $validador->nombre) ?><br>
            <?= utf8_decode($subtitulo) ?> <br>
            <?= utf8_decode('RUBRO VEHÍCULOS EN ALQUILER') ?>
        </caption>
        <thead>
            <tr style="background-color: #0592ff;color: #fff;">
                <th><?= utf8_decode('N°'); ?></th>
                <th><?= utf8_decode('Id Bien'); ?></th>
                <th><?= utf8_decode('Id Doc.'); ?></th>
                <th><?= utf8_decode('Descripción'); ?></th>
                <th><?= utf8_decode('Adjunta'); ?></th>
                <th><?= utf8_decode('Corresponde'); ?></th>
                <th><?= utf8_decode('Legible'); ?></th>
                <th><?= utf8_decode('N° Documento'); ?></th>
                <th><?= utf8_decode('Departamento'); ?></th>
                <th><?= utf8_decode('Dirección'); ?></th>
                <th><?= utf8_decode('Inicio contrato'); ?></th>
                <th><?= utf8_decode('Fin contrato'); ?></th>
                <th><?= utf8_decode('Canon alquiler'); ?></th>
                <th><?= utf8_decode('Obs. General'); ?></th>
                <th><?= utf8_decode('Cod. Observación'); ?></th>
                <th><?= utf8_decode('Fecha Validación'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cont = 0;
            foreach ($vehiculosalquiler as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td><?= $dato->iddoc; ?></td>
                    <td><?= $dato->descripcion; ?></td>
                    <td><?= $dato->adjunta; ?></td>
                    <td><?= $dato->idcorrespondencia; ?></td>
                    <td><?= $dato->legible; ?></td>
                    <td><?= $dato->cdocumento; ?></td>
                    <td><?= $dato->cdepartamento; ?></td>
                    <td><?= $dato->cdireccion; ?></td>
                    <td><?= $dato->ciniciocontrato; ?></td>
                    <td><?= $dato->cfincontrato; ?></td>
                    <td><?= $dato->ccanonalquiler; ?></td>
                    <td><?= $dato->observacionesgenerales; ?></td>
                    <td><?= $dato->observaciones; ?></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            foreach ($vehiculosalquilerdoc as $dato) {
            ?>
                <tr>
                    <td><?= ++$cont; ?></td>
                    <td><?= $dato->idbien; ?></td>
                    <td></td>
                    <td><?= utf8_decode('SIN DOCUMENTACIÓN') ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= $dato->fecvalidado; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <p>
        <?php
        foreach ($codigosvehiculosalquiler as $dato) {
        ?>
            <?= utf8_decode('Código: ' . $dato->id . ' = ' . $dato->descripcion) ?> <br>
        <?php
        }
        ?>
    </p>
</body>

</html>