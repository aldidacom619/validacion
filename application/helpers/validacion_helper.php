<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function devol_entidad_nombre($id)
{
	if($id>0)
	{
    $CI =& get_instance();
    $CI->load->model('entidades_model');
    $dato = $CI->entidades_model->devolver_entidad($id);
    $nombre = $dato[0]->nombre;
	}
	else
	{
		$nombre = "";
	}
    return $nombre; 


}

function estadoentidad($identidad)
{
    $CI =& get_instance();
    $CI->load->model('entidades_model');

    $dato = $CI->entidades_model->estado_entidad($identidad);
    $estado = $dato[0]->estadoentidad;
    
    return $estado; 
}

function actualizarbien()
 {

  $fila =& get_instance();  
  $fila->load->model('entidades_model');
  $listado_habilitadosbien = $fila->entidades_model->habilitarbien();
  $listado_habilitadosbienalquiler = $fila->entidades_model->habilitarbienalquiler();
  if ($listado_habilitadosbien == TRUE and $listado_habilitadosbienalquiler == TRUE)
    {
     $fila->entidades_model->guardargestnew($fila->entidades_model->getmaxgestbien()->gestion);
     return "exito";
    }
  else 
    return "fallo la actualizacion";
 
 }

 