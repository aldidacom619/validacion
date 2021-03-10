<script type="text/javascript" src="<?php echo  base_url() ?>jsd/reportes.js"></script>
<h1 class="label label-info" style="font-size: 1.15em; display: block;">Reportes de Validación</h1>

<!--
ESTILO PARA LA VISTA REPORTES
/*autor:Wilmer Villca*/
-->

<div id="divReportesValidador">
    <h5><strong>Reporte de Bienes Validados por Entidad y Rubro</strong></h5>
    <div id="reporte1" class="row" style="background: #c9ced6; padding: 0.75em; ">
        <div class="col-xs-6">
            <select id="cbEntidadesAsignadas" class="form-control input-sm" name="cbEntidadesAsignadas">
            </select>
        </div>
        <div class="col-xs-6">
            <div class="input-group">
                <select id="cbRubro" class="form-control input-sm" name="cbRubro">
                    <option value="-1">Seleccione un rubro</option>
                    <option value="1">Inmuebles</option>
                    <option value="3">Vehículos</option>
                    <option value="4">Maquinaria y Equipos</option>
                    <option value="6">Maquinaria Pesada</option>
                    <option value="5">Inmuebles Alquiler</option>
                    <option value="7">Vehículos Alquiler</option>
                </select>
                <span class="input-group-btn" >
                <button id="btnReporteBVD" class="btn btn-link" type="button">Generar Reporte</button>
                </span>
            </div>
        </div>
        <div class="col-xs-2"></div>
    </div>
    <br>
    <h5><strong>Reporte de Estado Legal de los Bienes Declarados</strong></h5>

    <div id="reporte3" class="row" style="background: #c9ced6; padding: 0.75em; ">
        <div class="col-xs-12">
        	<div class="input-group">
            <select id="cbEntidadesAsignadas2" class="form-control input-sm" name="cbEntidadesAsignadas2">
            </select>
            <span class="input-group-btn">
                <button id="btnReporteEBD" class="btn btn-link" type="button">Generar Reporte</button>
                </span>
            </div>
        </div>
        <div class="col-xs-2"></div>
    </div>
    <br>

    <h5><strong>Reporte de Validación Diaria</strong></h5>
    <input type="hidden" id="idfunc" name="idfunc" value="<?php echo $id; ?>" />
    <div id="reporte2" class="row" style="background: #c9ced6; padding: 0.75em; ">
        <div class="col-xs-6">
            <input type="text" id="fechainicio" class="form-control input-sm" name="fechainicio" placeholder="Seleccione una fecha"/>
        </div>
        <div class="col-xs-6">
            <div class="input-group">
                <input type="text" id="fechafin" class="form-control input-sm" name="fechafin" placeholder="Seleccione una fecha"/>
                <span class="input-group-btn">
                <button id="btnReporteVD" class="btn btn-link" type="button">Generar Reporte</button>
                </span>
            </div>
        </div>
        <div class="col-xs-2"></div>
    </div>
    <br>
    <h5><strong>Reporte de Bienes Validados por Entidad y Rubro</strong></h5>
    <div id="reporte1" class="row" style="background: #c9ced6; padding: 0.75em;">
        <input type="hidden" id="cbvalidadores" name="cbvalidadores" value="<?php echo $id; ?>" />
        <div class="col-xs-12">
            <div class="input-group">
                <select id="cbentidad" class="form-control input-sm" name="cbentidad">
                </select>
                <span class="input-group-btn">
                <button id="btnReportevalidacion" class="btn btn-link" type="button">Generar Reporte</button>
                </span>
            </div>
        </div>

    </div>
    <br>
    <h5><strong>Reporte de Bienes Validados Observados por Entidad y Rubro</strong></h5>
    <div id="reporte1" class="row" style="background: #c9ced6; padding: 0.75em;">
        <div class="col-xs-12">
            <div class="input-group">
                <select id="cbentidadobss" class="form-control input-sm" name="cbentidadobss">
                </select>
                <span class="input-group-btn">
                <button id="btnReportevalidacionobss" class="btn btn-link" type="button">Generar Reporte de Observados</button>
                </span>
            </div>
        </div>
    </div>
    <div class="">
        <p class="text-center">&nbsp;</p>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function(){

        var enlace = "<?php echo  base_url() ?>";

        baseurl(enlace);
        seleccionarentidad()
		cargarComboEntidadesAsignadas();
        generarReporte();
		fechas();
		generarReportexValidador();
		generarReporteEstadoLegal();
    });
</script>
