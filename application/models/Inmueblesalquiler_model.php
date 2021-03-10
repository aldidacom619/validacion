<?php
/*
*/

class Inmueblesalquiler_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct(); 
	} 
 	function estadovalidacionbien($id)
	{
		$query = $this->db->query("select * from nueva_validacion.vista_inmueblealquiler where id =".$id);
        return $query->result();		
	}

	function select_validar($id)
	{
		//$sql = "select * from nueva_validacion.vista_inmueblealquiler where idestadovalidacion in (1,5) and identidad=$idEntidad ".$condicion;
		$query = $this->db->query("select * from nueva_validacion.vista_inmueblealquiler where idestadovalidacion not in (3) and idsituacion = 1 and habilitado = 1  and identidad=".$id);
        return $query->result();	
	}
	function select_validadas($id)
	{
		$query = $this->db->query("select * from nueva_validacion.vista_inmueblealquiler where idestadovalidacion=3 and habilitado = 1 and  idsituacion = 1 and identidad =". $id);
      
       return $query->result();	
	} 
	function verifiddocumentoIA($idd)//2018
	{
			$query = $this->db->query("select * from nueva_validacion.validacionxgestioninmueblealquiler where iddocumentobien='".$idd."'");	
			return $query->result();  	
	}

	function selec_inmueble_id($idbien)
	{
		$sql = "select idb,idbien,a.denominacion,direccion,canonalquiler,fechainicio,fechafin,b.descripcion,b.descripcion as departamento,zona from nueva_validacion.inmueblealquiler a join geografia.departamento b on b.id=a.idciudad where idb=".$idbien;
		$query = $this->db->query($sql);
       
       return $query->result();	 
		
	}

	function getEstadoBien($idbien)
	{
		$query = $this->db->query("select a.id, idbien, descripcion from dj_activos.situacionbien a join nueva_validacion.bien b on a.id 						= b.idsituacion where idbien=".$idbien);
      
       return $query->result();	
			
	}
	function getTablaDocumentos($idBien) 
	{
		  $sql = "select db.id,db.idb,d.descripcion,db.nrodocumento,gestion,case when validado then 'Validado' else 'Sin Validar' end as val,case when adicionado  = 't' then 'Validador' else 'Entidad' end as registradopor from nueva_validacion.documentobienalquiler db 
                join dj_documento.documento d on db.idtipodocumento=d.id
                where  eliminado = 'f' and docmodificado = 'f' and idb=".$idBien;

        $query = $this->db->query($sql); 
                
		return $query->result();
	}

	function getValidacionDocumento1($idDocumento)
	{
		$query = $this->db->query("select idb,idtipodocumento,nrodocumento,idbien, adicionado from nueva_validacion.documentobienalquiler where id=".$idDocumento);
		return $query->result();
	}
	function getValidacionDocumento2($idDocumento)
	{
			 
			$query = $this->db->query("select a.id,idcorrespondencia,adjunta,legible,observacionesgenerales,nrodocumento,correctodocumento,direccion,
                correctodireccion,departamento,correctodepartamento,iniciocontrato,correctoiniciocontrato,fincontrato,
                correctofincontrato,canonalquiler,correctocanonalquiler,t1.observaciones from nueva_validacion.v_validxgestinmueblealquiler a 
                left join nueva_validacion.detallevalidacioninmueblealquiler b on a.id=b.idvalidacion 
                left join (select idvalidacion,array_to_string(array_agg(idtipoobservacion),'|') as observaciones from nueva_validacion.v_validxgestinmueblealquiler a
                join nueva_validacion.observacioninmueblealquiler b on a.id=b.idvalidacion
                where iddocumentobien=".$idDocumento." and idgestion > 2016
                group by idvalidacion) as t1 on t1.idvalidacion=a.id 
                where iddocumentobien=".$idDocumento);
 
			return $query->result();
	}

	function getListaObservaciones()
	{
		$query = $this->db->query("select id,descripcion from nueva_validacion.tipoobservacion where idrubro=5");
		return $query->result();
	}

//todo guardar
	function guardarValidacion($idb,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones)
	{
		$data = array(
			'idb'=>$idb,
			'idbien'=>$idBien,
	        'idgestion'=>$idGestion,
	        'idcorrespondencia' =>$idCorrespondencia,
	        'adjunta'=>$adjunta,
	        'legible'=>$legible,
	        'observacionesgenerales'=>$observaciones,
	        'iddocumentobien'=>$idDocumentoBien,
                'idtipovalidacion'=> 1,
		 );
		$this->db->insert('nueva_validacion.validacionxgestioninmueblealquiler',$data); 
		return $this->db->insert_id();
		

      	
 	
	}
	function guardarDetalleValidacion($idvalidacion,$nrodocumento,$correctodocumento,$departamento,$correctoDepartamento,$direccion,$correctoDireccion,$inicioContrato,$correctoInicioContrato,$finContrato,$correctoFinContrato,$canon,$correctoCanon)
    {
    	$data = array( 'idvalidacion' => $idvalidacion,
			'nrodocumento' => $nrodocumento,
			'correctodocumento' => $correctodocumento,
            'departamento' => $departamento,
            'correctodepartamento' => $correctoDepartamento,
            'direccion' => $direccion,
            'correctodireccion' => $correctoDireccion,
            'iniciocontrato' => $inicioContrato,
            'correctoiniciocontrato' => $correctoInicioContrato,
            'fincontrato' => $finContrato,
            'correctofincontrato' => $correctoFinContrato,
            'canonalquiler' => $canon,
            'correctocanonalquiler' => $correctoCanon) ;
    	$this->db->insert('nueva_validacion.detallevalidacioninmueblealquiler',$data); 
		return $this->db->insert_id();

				
	}


//todo editar
	function editarValidacion($idval,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones)
	{
		$data = array(
			'idbien'=>$idBien,
	        'idgestion'=>$idGestion,
	        'idcorrespondencia' =>$idCorrespondencia,
	        'adjunta'=>$adjunta,
	        'legible'=>$legible,
	        'observacionesgenerales'=>$observaciones,
	        'iddocumentobien'=>$idDocumentoBien,
                'idtipovalidacion'=> 1,
		 );
		$this->db->where('id',$idval);
		return  $this->db->update('nueva_validacion.validacionxgestioninmueblealquiler',$data);
	}
	function editarDetalleValidacion($idvalidacion,$nrodocumento,$correctodocumento,$departamento,$correctoDepartamento,$direccion,$correctoDireccion,$inicioContrato,$correctoInicioContrato,$finContrato,$correctoFinContrato,$canon,$correctoCanon)
    {
    	$data = array( 'idvalidacion' => $idvalidacion,
			'nrodocumento' => $nrodocumento,
			'correctodocumento' => $correctodocumento,
            'departamento' => $departamento,
            'correctodepartamento' => $correctoDepartamento,
            'direccion' => $direccion,
            'correctodireccion' => $correctoDireccion,
            'iniciocontrato' => $inicioContrato,
            'correctoiniciocontrato' => $correctoInicioContrato,
            'fincontrato' => $finContrato,
            'correctofincontrato' => $correctoFinContrato,
            'canonalquiler' => $canon,
            'correctocanonalquiler' => $correctoCanon) ;
		$this->db->where('idvalidacion',$idvalidacion);
		return  $this->db->update('nueva_validacion.detallevalidacioninmueblealquiler',$data);

    }
	function eliobservacion($idval)
	{
		$this->db->where('idvalidacion', $idval);
		$this->db->delete('nueva_validacion.observacioninmueblealquiler');
	}

	function guardarObservacionesValidacion($idval,$valor)
	{
      	$data = array(
			'idvalidacion' => $idval,
			'idtipoobservacion' => $valor,
			);
		return  $this->db->insert('nueva_validacion.observacioninmueblealquiler',$data);
        //$sql2 = "insert into nueva_validacion.observacioninmueble (idvalidacion,idtipoobservacion) values ($idValidacion,$valor)";
        
	}
	function guardarEstadoDocumentacionGeneral($idValidacion,$idClase)
	{
        $query = $this->db->query("select * from nueva_validacion.observacioninmueblealquiler(".$idValidacion.",".$idClase.")");
		return $query->result();
    }
    function exitedetalleval($val)
    {
		$this->db->where('idvalidacion',$val);
		$query = $this->db->get('nueva_validacion.detallevalidacioninmueblealquiler');
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
    }
   
}
?>