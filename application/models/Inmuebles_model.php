<?php
/*
*/

class Inmuebles_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
    function getcorrespondencia()
    {
    	$query = $this->db->query("select * from nueva_validacion.correspondencia");
        return $query->result();
    }
	function estadovalidacionbien($id)
	{
		$query = $this->db->query("select * from nueva_validacion.vista_inmuebles where id =".$id);
        return $query->result();		
	}
	
	function select_validar($id)
	{
		$query = $this->db->query("select * 
			from nueva_validacion.vista_inmuebles 
			where identidad=". $id."  and idestadovalidacion not in (3) and habilitado = 1  order by idbien asc ");
        return $query->result();	
	}
	
	/*
	function select_validar($id)//muestra validacion de 2017
	{
		$query = $this->db->query("select i.*, vb.validado 
									from nueva_validacion.vista_inmuebles i
									left join nueva_validacion.v_bien2017 vb on i.idbien=vb.idbiendejurbe
									where i.identidad=". $id."  and i.idestadovalidacion not in (3) and i.habilitado = 1 
									order by idbien asc");
        return $query->result();	
	}
	*/

	function select_validadas($id)  
	{
		$query = $this->db->query("select vi.*,vg.idtipovalidacion  
from nueva_validacion.vista_inmuebles vi
left join (
select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestioninmueble where idtipovalidacion=2
) vg on vg.idb=vi.id
where identidad='".$id."'  and idestadovalidacion = 3 and habilitado = 1 order by vi.idbien asc
");
       
       return $query->result();	
	} 
	function select_listatotal($id)  
	{
		$query = $this->db->query("select vi.*,vg.idtipovalidacion  
from nueva_validacion.vista_inmuebles vi
left join (
select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestioninmueble where idtipovalidacion=2
) vg on vg.idb=vi.id
where identidad='".$id."'  and habilitado = 1 order by vi.idbien asc");
      
       return $query->result();	
	} 

	function selec_inmueble_id($idbien)
	{
		$query = $this->db->query("select idb,idbien,superficieterreno||' '|| s.abreviatura as superficieterreno,direccion,denominacion,nrocatastro,zona from nueva_validacion.inmueble i join dj_activos.unidad_superficie s on s.id = i. unidadsuperficie where idb=".$idbien); 
      
       return $query->result();	
		
	}

	function getEstadoBien($idbien)
	{
		$query = $this->db->query("select a.id, idbien, descripcion from dj_activos.situacionbien a join nueva_validacion.bien b on a.id 						= b.idsituacion where idbien=".$idbien);
      
       return $query->result();	
			
	}
	
	function getDatosDoc($idd)//2019
	{
		$query = $this->db->query("select db.idtipodocumento, djb.idestado_documentaciondejurbe, db.id,db.idbien,db.idb,d.descripcion,db.nrodocumento,gestion,case when validado then 'Validado' else 'Sin Validar' end as val,case when adicionado  = 't' then 'Validador' else 'Entidad' end as registradopor,db.idb 
        	    from nueva_validacion.documentobien db 
        	    join dj_documento.documento d on db.idtipodocumento=d.id
        	    join dj_activos.bien djb on djb.id=db.idbien
                where db.eliminado = false and docmodificado = 'f' and db.id=".$idd );
                

		return $query->result();
	}
	function getTablaDocumentos($idB)//2019
	{
        $query = $this->db->query("select db.idtipodocumento, djb.idestado_documentaciondejurbe, db.id,db.idbien,db.idb,d.descripcion,db.nrodocumento,gestion,case when validado then 'Validado' else 'Sin Validar' end as val,case when adicionado  = 't' then 'Validador' else 'Entidad' end as registradopor,db.idb 
        	    from nueva_validacion.documentobien db 
        	    join dj_documento.documento d on db.idtipodocumento=d.id
        	    join dj_activos.bien djb on djb.id=db.idbien
                where db.eliminado = false and docmodificado = 'f' and db.idb=".$idB." order by db.idtipodocumento" );
                

		return $query->result();
	}
	
	function getValidacionDocumento1($idDocumento)
	{
		$query = $this->db->query("select idb,idtipodocumento,nrodocumento,idbien,adicionado from nueva_validacion.documentobien where id=".$idDocumento);
		return $query->result();
	}
	function getValidacionDocumento2($idDocumento)
	{
			$query = $this->db->query("select a.id,idcorrespondencia,adjunta,legible,observacionesgeneral,nrodocumento,correctodocumento,superficieterreno,
                correctosupterreno,denominacion,correctodenominacion,zona,correctozona,direccion,
                correctodireccion,catastro,correctocatastro,t1.observaciones from nueva_validacion.v_validxgestinmueble a 
                left join nueva_validacion.detallevalidacioninmueble b on a.id=b.idvalidacion 
                left join (select idvalidacion,array_to_string(array_agg(idtipoobservacion),'|') as observaciones from nueva_validacion.v_validxgestinmueble a
                join nueva_validacion.observacioninmueble b on a.id=b.idvalidacion
                where iddocumentobien=".$idDocumento." and idgestion>=2014
                group by idvalidacion) as t1 on t1.idvalidacion=a.id
                where iddocumentobien=". $idDocumento);

			return $query->result();
	}

	function getListaObservaciones()
	{
		$query = $this->db->query("select id,descripcion from nueva_validacion.tipoobservacion where idrubro=1");
		return $query->result();
	}
function verifiddocumento($idd)//2018
	{
			$query = $this->db->query("select * from nueva_validacion.validacionxgestioninmueble where iddocumentobien='".$idd."'");	
			return $query->result();  	
	}
//todo guardar
	function guardarValidacionInmueble($idb,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones)
	{
		$data = array(
			'idb'=>$idb,
			'idbien'=>$idBien,
	        'idgestion'=>$idGestion,
	        'idcorrespondencia' =>$idCorrespondencia,
	        'adjunta'=>$adjunta,
	        'legible'=>$legible,
	        'observacionesgeneral'=>$observaciones,
	        'iddocumentobien'=>$idDocumentoBien,
                'idtipovalidacion'=> 1,
		 );
		$this->db->insert('nueva_validacion.validacionxgestioninmueble',$data); 
		return $this->db->insert_id();
		

	}
	function guardarDetalleValidacion($idval,$nrodocumento,$nroDocumentoOpcion,$superficie,$superficieOpcion,$catastro,$catastroOpcion,$denominacion,$denominacionOpcion,$direccion,$direccionOpcion)
    {
    	$data = array(

        	'idvalidacion'=>$idval,
        	'nrodocumento'=>$nrodocumento,
        	'correctodocumento'=>$nroDocumentoOpcion,
        	'superficieterreno'=>$superficie,
        	'correctosupterreno'=>$superficieOpcion,
        	'catastro'=>$catastro,
        	'correctocatastro'=>$catastroOpcion,
        	'denominacion'=>$denominacion,
        	'correctodenominacion'=>$denominacionOpcion,
        	'direccion'=>$direccion,
        	'correctodireccion'=>$direccionOpcion
			
		 );
    	$this->db->insert('nueva_validacion.detallevalidacioninmueble',$data); 
		return $this->db->insert_id();

    }


//todo editar
	function modificarvalidacion($idval,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones)
	{

		$data = array(
			'idbien'=>$idBien,
	        'idgestion'=>$idGestion,
	        'idcorrespondencia' =>$idCorrespondencia,
	        'adjunta'=>$adjunta,
	        'legible'=>$legible,
	        'observacionesgeneral'=>$observaciones,
	        'iddocumentobien'=>$idDocumentoBien,
                'idtipovalidacion'=> 1,
		 );
		$this->db->where('id',$idval);
		return  $this->db->update('nueva_validacion.validacionxgestioninmueble',$data);


	}
	function eliobservacion($idval)
	{
		$this->db->where('idvalidacion', $idval);
		$this->db->delete('nueva_validacion.observacioninmueble');
	}

	function guardarObservacionesValidacion($idval,$valor)
	{
      	$data = array(
			'idvalidacion' => $idval,
			'idtipoobservacion' => $valor,
			);
		return  $this->db->insert('nueva_validacion.observacioninmueble',$data);
        //$sql2 = "insert into nueva_validacion.observacioninmueble (idvalidacion,idtipoobservacion) values ($idValidacion,$valor)";
        
	}
	function guardarEstadoDocumentacionGeneral($idValidacion,$idClase)
	{
        $query = $this->db->query("select * from nueva_validacion.estadodocumentacionbien(".$idValidacion.",".$idClase.")");
		return $query->result();
    }
    function editarDetalleValidacion($idval,$nrodocumento,$nroDocumentoOpcion,$superficie,$superficieOpcion,$catastro,$catastroOpcion,$denominacion,$denominacionOpcion,$direccion,$direccionOpcion)
    {
    	$data = array(

        	'idvalidacion'=>$idval,
        	'nrodocumento'=>$nrodocumento,
        	'correctodocumento'=>$nroDocumentoOpcion,
        	'superficieterreno'=>$superficie,
        	'correctosupterreno'=>$superficieOpcion,
        	'catastro'=>$catastro,
        	'correctocatastro'=>$catastroOpcion,
        	'denominacion'=>$denominacion,
        	'correctodenominacion'=>$denominacionOpcion,
        	'direccion'=>$direccion,
        	'correctodireccion'=>$direccionOpcion
			
		 );
		$this->db->where('idvalidacion',$idval);
		return  $this->db->update('nueva_validacion.detallevalidacioninmueble',$data);

    }
    function exitedetalleval($val)
    {

    	$this->db->where('idvalidacion',$val);
		$query = $this->db->get('nueva_validacion.detallevalidacioninmueble');
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
    }

   
}
?>