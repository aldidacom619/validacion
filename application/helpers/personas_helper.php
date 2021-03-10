<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



function devol_persona($id)
{
    $CI =& get_instance();
    $CI->load->model('personas_model');

    $dato = $CI->personas_model->selec_persona($id);
    $nombre = $dato[0]->nombre_per;
    $ap = $dato[0]->ap_per;
   
    return "$nombre $ap"; 
}
function devol_persona_todo($id)
{
    $CI =& get_instance();
    $CI->load->model('personas_model');

    $dato = $CI->personas_model->selec_persona($id);
    $nombre = $dato[0]->nombre_per;
    $ap = $dato[0]->ap_per;
    $ci = $dato[0]->ci_per;
    $direccion = $dato[0]->direccion_per;
    $telefono = $dato[0]->telefono_per; 

   
    return "C.I.: $ci - NOMBRE: $nombre $ap - DIRECCION : $direccion - TELEFONO : $telefono "; 
}

function devol_persona2($id)
{
    $CI =& get_instance();
    $CI->load->model('personas_model');

    $dato = $CI->personas_model->selec_persona($id);
    $nombre = $dato[0]->nombre_per;
    $ap = $dato[0]->ap_per;
    $ci = $dato[0]->ci_per;
    $direccion = $dato[0]->direccion_per;
    $telefono = $dato[0]->telefono_per;

   
    return "C.I.: $ci - NOMBRE: $nombre $ap "; 
}
function devol_departamento($id)
{
    $CI =& get_instance();
    $CI->load->model('cargos_model');

    $dato = $CI->cargos_model->select_departamento_id($id);
    $nombre = $dato[0]->nombre_dep;
    return "$nombre"; 
}
function devol_provicia($id)
{
    if($id > 0)
    { 
        $CI =& get_instance();
        $CI->load->model('cargos_model');

        $dato = $CI->cargos_model->selec_prov_id($id);
        $nombre = $dato[0]->nombre_red;
     }else { 
        $nombre = "-";
    }
    return "$nombre"; 
}
function devol_municipio($id)
{
    if($id > 0)
    { 
        $CI =& get_instance();
        $CI->load->model('cargos_model');

        $dato = $CI->cargos_model->selec_mun_id($id);
        $nombre = $dato[0]->nombre_mun;
     }else { 
        $nombre = "-";
    }
    return "$nombre"; 
}
function devol_comunidad($id)
{ 
    if($id > 0)
    { 
        $CI =& get_instance();
        $CI->load->model('cargos_model');

        $dato = $CI->cargos_model->selec_com_id($id);
        $nombre = $dato[0]->nombre_cumu;
     }else { 
        $nombre = "-";
    }
    return "$nombre"; 
}
function devol_establecimiento($id)
{
    if($id > 0)
    { 
        $CI =& get_instance();
        $CI->load->model('cargos_model');

        $dato = $CI->cargos_model->selec_estab_id($id);
        $nombre = $dato[0]->nombre_est;
    }else { 
        $nombre = "-";
    }
    return "$nombre"; 
}
function devol_jefatura($id)
{
     if($id > 0)
    { 
    $CI =& get_instance();
    $CI->load->model('cargos_model');

    $dato = $CI->cargos_model->select_jefatura_id($id);
    $nombre = $dato[0]->nombre_jefatura;
    }else { 
        $nombre = "-";
    }
    return "$nombre"; 
}
function devol_unidad($id)
{
    if($id > 0)
    {    
    $CI =& get_instance();
    $CI->load->model('cargos_model');

    $dato = $CI->cargos_model->selec_uni_id($id);
    $nombre = $dato[0]->nombre_uni;
    }else { 
        $nombre = "-";
    }
    return "$nombre"; 
}
function devol_area($id)
{
    if($id > 0)
    {    
    $CI =& get_instance();
    $CI->load->model('cargos_model');

    $dato = $CI->cargos_model->selec_area_id($id);
    $nombre = $dato[0]->nombre_area;
     }else { 
        $nombre = "-";
    }
    return "$nombre"; 
}
function devolver_edad($edad)
{
    $datestring = " %Y-%m-%d";
    $time = time();
    $hoy =  mdate($datestring, $time); 
    

    $fecha1 = new DateTime($edad);
    $fecha2 = new DateTime($hoy);
    $fecha = $fecha1->diff($fecha2);
    $e = "$fecha->y años $fecha->m meses ";
    return $e;

}
function devolver_anhos($edad)
{
    $datestring = " %Y-%m-%d";
    $time = time();
    $hoy =  mdate($datestring, $time);
    $fecha1 = new DateTime($edad);
    $fecha2 = new DateTime($hoy);
    $fecha = $fecha1->diff($fecha2);
    $e = $fecha->y;
    return $e;
}

function devolver_numerodedias($id_per)
{
      
    $CI =& get_instance();
    $CI->load->model('permiso_model');
    $dato = $CI->permiso_model->ver_dias($id_per);
    $num = 0;
    foreach ($dato as $da)
    {
        $num = $num + 1;           
    }
    return "$num"; 
}