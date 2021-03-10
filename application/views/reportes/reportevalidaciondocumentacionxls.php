<?php
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=reportevalidaciondocumentacionxls.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<html>

<head>

</head>

<body>
    <table border="1">
        <caption><?= utf8_decode($titulo) ?><br><?= utf8_decode($subtitulo) ?></caption>
        <thead>
            <tr style="background-color: #0592ff;color: #fff;">
                <th><?= utf8_decode('Rubro de bien'); ?></th>
                <th><?= utf8_decode('Bienes registrados'); ?></th>
                <th><?= utf8_decode('Bienes validados'); ?></th>
                <th><?= utf8_decode('Documentación definitiva'); ?></th>
                <th><?= utf8_decode('Documentación intermedia'); ?></th>
                <th><?= utf8_decode('Sin documentación'); ?></th>
                <th><?= utf8_decode('N° Total de Bienes sin Observaciones'); ?></th>
                <th><?= utf8_decode('N° Total de Bienes con Observaciones'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_registrados = 0;
            $total_validados = 0;
            $total_definitiva = 0;
            $total_intermedia = 0;
            $total_sin_documentacion = 0;
            $total_sin_observacion = 0;
            $total_con_observacion = 0;
            foreach ($datos as $dato) {
            ?>
                <tr>
                    <td><?= $dato->clase; ?></td>
                    <td><?= $dato->cantidad; ?></td>
                    <td><?= $dato->validados; ?></td>
                    <td><?= $dato->definitivo; ?></td>
                    <td><?= $dato->intermedio; ?></td>
                    <td><?= $dato->sindoc; ?></td>
                    <td><?= $dato->nobservado; ?></td>
                    <td><?= $dato->observado; ?></td>
                </tr>
            <?php
                $total_registrados = $total_registrados + $dato->cantidad;
                $total_validados = $total_validados + $dato->validados;
                $total_definitiva = $total_definitiva + $dato->definitivo;
                $total_intermedia = $total_intermedia + $dato->intermedio;
                $total_sin_documentacion = $total_sin_documentacion + $dato->sindoc;
                $total_sin_observacion = $total_sin_observacion + $dato->nobservado;
                $total_con_observacion = $total_con_observacion + $dato->observado;
            }
            ?>
            <?php
            foreach ($datosalquiler as $datoalquiler) {
            ?>
                <tr>
                    <td><?= $datoalquiler->clase; ?></td>
                    <td><?= $datoalquiler->cantidad; ?></td>
                    <td><?= $datoalquiler->validados; ?></td>
                    <td><?= $datoalquiler->definitivo; ?></td>
                    <td><?= $datoalquiler->intermedio; ?></td>
                    <td><?= $datoalquiler->sindoc; ?></td>
                    <td><?= $datoalquiler->nobservado; ?></td>
                    <td><?= $datoalquiler->observado; ?></td>
                </tr>
            <?php
                $total_registrados = $total_registrados + $datoalquiler->cantidad;
                $total_validados = $total_validados + $datoalquiler->validados;
                $total_definitiva = $total_definitiva + $datoalquiler->definitivo;
                $total_intermedia = $total_intermedia + $datoalquiler->intermedio;
                $total_sin_documentacion = $total_sin_documentacion + $datoalquiler->sindoc;
                $total_sin_observacion = $total_sin_observacion + $datoalquiler->nobservado;
                $total_con_observacion = $total_con_observacion + $datoalquiler->observado;
            }
            ?>
        </tbody>
        <tfoot>
            <tr style="background-color: silver;">
                <th>TOTALES</th>
                <th><?= $total_registrados; ?></th>
                <th><?= $total_validados; ?></th>
                <th><?= $total_definitiva; ?></th>
                <th><?= $total_intermedia; ?></th>
                <th><?= $total_sin_documentacion; ?></th>
                <th><?= $total_sin_observacion; ?></th>
                <th><?= $total_con_observacion; ?></th>
            </tr>
        </tfoot>
    </table>
    <p><?= utf8_decode('Resumen de datos validados obtenidos mediante el Sistema de Validación Documental.'); ?></p>
    <p><?= utf8_decode('* Para revisión, control y fines de auditoría, el reporte de los bienes validados por Entidad y Rubro a detalle se encuentra en el CD adjunto y en el Sistema de Validación Documental.'); ?></p>
</body>

</html>