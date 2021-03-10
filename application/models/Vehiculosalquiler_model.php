<?php
/*
*/

class Vehiculosalquiler_model extends CI_Model 
{
	
	function __construct()
	{
		parent::__construct();
	}
 
	function estadovalidacionbien($id)
	{
		$query = $this->db->query("select * from nueva_validacion.vista_vehiculosalquiler where id =".$id);
        return $query->result();		
	}
	function verifiddocumentoVA($idd)//2018
	{
			$query = $this->db->query("select * from nueva_validacion.validacionxgestionvehiculoalquiler where iddocumentobien='".$idd."'");	
			return $query->result();  	
	}

	
	function select_validar($id)
	{
		//$sql = "select * from nueva_validacion.vista_inmueblealquiler where idestadovalidacion in (1,5) and identidad=$idEntidad ".$condicion;
		$query = $this->db->query("select *from(select id, identidad, idgestion, idtipobien, idestadovalidacion, idestadodocumentacion, idbien, iduso, idclase, 
 		marca, placa, nromotor, nrochasis, modelo, color, tipobien, canonalquiler, fechainicio, fechafin, uso, clasebien, zona, direccion,entidad, sigla, usuario, ciudad, documentos,idsituacion from nueva_validacion.vista_vehiculosalquiler where habilitado = 1) a where a.idestadovalidacion not in (3) and a.idsituacion = 1 and a.identidad = ".$id);
        return $query->result();	
	} 
	function select_validadas($id) 
	{
		$query = $this->db->query("select *from (select id, identidad, idgestion, idtipobien, idestadovalidacion, idestadodocumentacion, idbien, iduso, idclase, marca, placa, nromotor, nrochasis, modelo, color, tipobien, canonalquiler, fechainicio, fechafin, uso, clasebien, zona, direccion,
 entidad, sigla, usuario, ciudad, documentos, idsituacion from nueva_validacion.vista_vehiculosalquiler where habilitado = 1) a
where a.idestadovalidacion = 3 and a.idsituacion = 1  AND a.identidad = ". $id);
      
       return $query->result();	
	}

	function selec_vehiculo_id($idbien)
	{
		$sql = "select id,idbien,upper(ciudad) as ciudad,direccion,fechainicio,fechafin,canonalquiler
						from nueva_validacion.vista_vehiculosalquiler where id=".$idbien;
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
                where eliminado = 'f' and docmodificado = 'f' and idb=".$idBien;

        $query = $this->db->query($sql);
                

		return $query->result();
	}

	function getValidacionDocumento1($idDocumento)
	{
		$query = $this->db->query("select idb,idtipodocumento,nrodocumento,idbien,adicionado from nueva_validacion.documentobienalquiler where id=".$idDocumento);
		return $query->result(); 
	}
	function getValidacionDocumento2($idDocumento) 
	{		
			 
			$query = $this->db->query("select a.id,idcorrespondencia,adjunta,legible,observacionesgenerales,nrodocumento,correctodocumento,departamento,correctodepartamento,direccion,correctodireccion,iniciocontrato,correctoiniciocontrato,fincontrato,correctofincontrato,canonalquiler,correctocanonalquiler,t1.observaciones from nueva_validacion.v_validxgestvehiculoalquiler a 
                left join nueva_validacion.detallevalidacionvehiculoalquiler b on a.id=b.idvalidacion 
                left join (select idvalidacion,array_to_string(array_agg(idtipoobservacion),'|') as observaciones from nueva_validacion.v_validxgestvehiculoalquiler a
                join nueva_validacion.observacionvehiculoalquiler b on a.id=b.idvalidacion
                where iddocumentobien=".$idDocumento." and idgestion >2015
                group by idvalidacion) as t1 on t1.idvalidacion=a.id
                where iddocumentobien=".$idDocumento);

			return $query->result();
	}

	function getListaObservaciones()
	{
		$query = $this->db->query("select id,descripcion from nueva_validacion.tipoobservacion where idrubro=7");
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
                'idtipovalidacion'=> 1
		 );
		$this->db->insert('nueva_validacion.validacionxgestionvehiculoalquiler',$data); 
		return $this->db->insert_id();
		

      	 
 	
	}
	function guardarDetalleValidacion($idvalidacion,$nrodocumento,$correctodocumento,$departamento,$correctoDepartamento,$direccion,$correctoDireccion,$inicioContrato,$correctoInicioContrato,$finContrato,$correctoFinContrato,$canonAlquiler,$correctoCanonAlquiler)
    {
    	$data = array( 

    	'idvalidacion' => $idvalidacion,
		'nrodocumento' => $nrodocumento,
		'correctodocumento' => $correctodocumento,
		'departamento' => $departamento, 
		'correctodepartamento' => $correctoDepartamento, 
		'direccion' => $direccion, 
		'correctodireccion' => $correctoDireccion, 
		'iniciocontrato' => $inicioContrato, 
		'correctoiniciocontrato' => $correctoInicioContrato, 
		'fincontrato' => $finContrato, 
		'correctofincontrato' => $correctoFinContrato , 
		'canonalquiler' => $canonAlquiler, 
		'correctocanonalquiler' => $correctoCanonAlquiler
		);
    	$this->db->insert('nueva_validacion.detallevalidacionvehiculoalquiler',$data); 
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
                'idtipovalidacion'=> 1
		 );
		$this->db->where('id',$idval);
		return  $this->db->update('nueva_validacion.validacionxgestionvehiculoalquiler',$data);
	}
	function editarDetalleValidacion($idvalidacion,$nrodocumento,$correctodocumento,$departamento,$correctoDepartamento,$direccion,$correctoDireccion,$inicioContrato,$correctoInicioContrato,$finContrato,$correctoFinContrato,$canonAlquiler,$correctoCanonAlquiler)
    {
    	$data = array( 

    	'idvalidacion' => $idvalidacion,
		'nrodocumento' => $nrodocumento,
		'correctodocumento' => $correctodocumento,
		'departamento' => $departamento, 
		'correctodepartamento' => $correctoDepartamento, 
		'direccion' => $direccion, 
		'correctodireccion' => $correctoDireccion, 
		'iniciocontrato' => $inicioContrato, 
		'correctoiniciocontrato' => $correctoInicioContrato, 
		'fincontrato' => $finContrato, 
		'correctofincontrato' => $correctoFinContrato , 
		'canonalquiler' => $canonAlquiler, 
		'correctocanonalquiler' => $correctoCanonAlquiler
		);
    	
		$this->db->where('idvalidacion',$idvalidacion);
		return  $this->db->update('nueva_validacion.detallevalidacionvehiculoalquiler',$data);

    }
	function eliobservacion($idval)
	{
		$this->db->where('idvalidacion', $idval);
		$this->db->delete('nueva_validacion.observacionvehiculoalquiler');
	}

	function guardarObservacionesValidacion($idval,$valor)
	{
      	$data = array(
			'idvalidacion' => $idval,
			'idtipoobservacion' => $valor,
			);
		return  $this->db->insert('nueva_validacion.observacionvehiculoalquiler',$data);
        //$sql2 = "insert into nueva_validacion.observacioninmueble (idvalidacion,idtipoobservacion) values ($idValidacion,$valor)";
        
	}
	function guardarEstadoDocumentacionGeneral($idValidacion,$idClase)
	{
        $query = $this->db->query("select * from nueva_validacion.estadodocumentacionbien(".$idValidacion.",".$idClase.")");
		return $query->result();
    }

    function exitedetalleval($val)
    {
		$this->db->where('idvalidacion',$val);
		$query = $this->db->get('nueva_validacion.detallevalidacionvehiculoalquiler');
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
    }
   
}
?>