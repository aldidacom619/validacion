<?php
/*
*/

class Reportes_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function validacioninmueble($identidad)
	{
		$query = $this->db->query("select b.idbien, td.descripcion, case when gi.adjunta = 't' then '1' else '0' end as adjunta, gi.idcorrespondencia, case when gi.legible = 't' then '1' else '0' end as legible,
			case when dv.correctodocumento = 't' then '1' else '0' end as correctodocumento, 
			case when dv.correctocatastro = 't' then '1' else '0' end as correctocatastro,
			case when dv.correctodenominacion = 't' then '1' else '0' end as correctodenominacion,
			case when dv.correctodireccion = 't' then '1' else '0' end as correctodireccion,
			gi.observacionesgeneral, 'SI' as documentacion from nueva_validacion.bien  b 
			join nueva_validacion.documentobien d on d.idbien = b.idbien
			left join dj_documento.documento td on td.id = d.idtipodocumento
			join nueva_validacion.validacionxgestioninmueble gi on d.id = gi.iddocumentobien
			left join nueva_validacion.detallevalidacioninmueble dv on gi.id = dv.idvalidacion
			where b.identidad = ".$identidad." and b.idclase in (1,2)and b.idestadodocumentacion in (1,2) and d.validado = 't' and d.eliminado = 'f' order by b.idbien asc ");
        return $query->result(); 
	}
		 
}
?>