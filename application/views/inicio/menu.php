<ul class="nav nav-tabs" >
<ul class="nav nav-pills">

   <li role="presentation" class="active">
    <a class="dropdown-toggle"  data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      INICIO<span class="caret"></span>
    </a>
      <ul class="dropdown-menu">
       <li role="presentation"><?=anchor('inicio','INICIO')?></li>
       <li role="presentation"><?=anchor('personas/cambio_contra','CAMBIAR CONTRASEÑA')?></li>
       <li role="presentation"><?=anchor('usuarios/salir','SALIR')?></li>
    </ul>
  </li>

  
  <li role="presentation" class="active">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      CONTROL DE USUARIOS <span class="caret"></span>
    </a>
      <ul class="dropdown-menu">
        <li role="presentation"><?=anchor('personas/selec_usuarios','VER USUARIOS')?></li>
         <li role="presentation"><?=anchor('inicio/ver_descarga','OBTENCION DE BAKUP')?></li>


    </ul>
  </li>
  <li role="presentation" class="active">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      CONTROL DE PERSONAL <span class="caret"></span>
    </a>
      <ul class="dropdown-menu">
         <li role="presentation"><?=anchor('personas/registrar_nuevo','REGISTRAR NUEVO')?></li>
        <li role="presentation"><?=anchor('personas/sel_person','VER PERSONAL')?></li>
        <li role="presentation"><?=anchor('curriculum/lista_personal','REGISTRO DE CURRICULUM')?></li>
        <li role="presentation"><?=anchor('curriculum/lista_personas_curriculum','IMPRIMIR KARDEX PERSONAL')?></li>
        <li role="presentation"><?=anchor('personas/selepersonas_baja','PERSONAL BAJA')?></li>
      </ul>
  </li>
   <li role="presentation" class="active">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      CARGOS<span class="caret"></span>
    </a>
      <ul class="dropdown-menu">
          <li role="presentation"><?=anchor('cargos/ver_jefaturas','JEFATURAS')?></li>
          <li role="presentation"><?=anchor('cargos/ver_unidad','UNIDADES')?></li>
          <li role="presentation"><?=anchor('cargos/lista_establecimiento','REGISTRO DE ESTABLECIMIENTOS')?></li>
          <li role="presentation"><?=anchor('cargos/ver_cargos','CARGOS')?></li>


      </ul>
  </li>
  <li role="presentation" class="active">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      ASIGNACIONES<span class="caret"></span>
    </a>
      <ul class="dropdown-menu">

          <li role="presentation"><?=anchor('cargos/asignar_cargos','ASIGNAR CARGO')?></li>
          <li role="presentation"><?=anchor('cargos/lista_asignaciones','LISTA DE ASIGNACIONES')?></li>
          <li role="presentation"><?=anchor('transferencias/asignaciones_actuales','TRANSFERENCIAS CARGO')?></li>
          <li role="presentation"><?=anchor('cargos/desasignar','DESASIGNACIONES CARGO')?></li>
          <li role="presentation"><?=anchor('transferencias/lista_transferencias','LSITA DE TRANSFERENCIAS')?></li>
          <li role="presentation"><?=anchor('cargos/lista_terminaciones','LISTA DE DESASIGNACIONES')?></li>

      </ul>
  </li>
  <li role="presentation" class="active">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      SEGUIMIENTO DE PERSONAL<span class="caret"></span>
    </a>
      <ul class="dropdown-menu">
          <li role="presentation"><?=anchor('permiso/lis_personal','REGISTRO DE PERMISOS')?></li>
          <li role="presentation"><?=anchor('vacaciones/lis_personal','PROGRAMACION DE DIAS DE VACACION')?></li>
          <li role="presentation"><?=anchor('llamadas/lis_personal','REGISTRO DE LLAMAS DE ATENCION')?></li>
          <li role="presentation"><?=anchor('cargos/ver_cargos','CONTROL DE VACACIONES')?></li>
          <li role="presentation"><?=anchor('cargos/ver_cargos','REPORTE DE VACACIONES')?></li>
      </ul>
  </li>



</ul>
