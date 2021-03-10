<?php
/*
*/

class Vehiculos_model extends CI_Model
{ 
	 
	function __construct()
	{
		parent::__construct();
	}
 	function estadovalidacionbien($id)
	{
		$query = $this->db->query("select * from nueva_validacion.vista_vehiculos where id =".$id);
        return $query->result();		
	}
	
	function select_validarveh($id)
	{
		$query = $this->db->query("select * from (select id,idbien,tipobien,clase,marca,placa, nromotor, nrochasis, modelo,documentos,idestadovalidacion,identidad,idsituacion
									from nueva_validacion.vista_vehiculos where habilitado = 1  ) as a where  idestadovalidacion not in (3)  AND identidad =".$id);
        return $query->result();	
	}
	function select_validadasveh($id)
	{
		$query = $this->db->query("select id,idbien,tipobien,clase,marca,placa, nromotor, nrochasis, modelo,documentos,idestadovalidacion,identidad,idsituacion, vg.idtipovalidacion
from nueva_validacion.vista_vehiculos vv
left join (
select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestionvehiculo where idtipovalidacion=2
) vg on vg.idb=vv.id
where habilitado = 1 and idestadovalidacion = 3 and  identidad =".$id);
      
       return $query->result();	
	}
	function select_totalveh($id)//2018
	{
		$query = $this->db->query("select id,idbien,tipobien,clase,marca,placa, nromotor, nrochasis, modelo,documentos,idestadovalidacion,identidad,idsituacion, vg.idtipovalidacion
from nueva_validacion.vista_vehiculos vv
left join (
select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestionvehiculo where idtipovalidacion=2
) vg on vg.idb=vv.id
where habilitado = 1 and  identidad =".$id);
      
       return $query->result();	
	}

	function verifiddocumentoVehiculo($idd)//2018
	{
			$query = $this->db->query("select * from nueva_validacion.validacionxgestionvehiculo where iddocumentobien='".$idd."'");	
			return $query->result();  	
	}


	function selec_vehiculo_id($idbien)
	{
		$query = $this->db->query("select vv.id, vv.idbien,vv.idtipobien,vv.clase,vv.marca,vv.placa,nromotor,vv.nrochasis,vv.modelo,vv.color,tipobien ,vv.idprocedencia, p.descripcion from nueva_validacion.vista_vehiculos vv
			LEFT OUTER JOIN geografia.pais p on p.iso2 = vv.idprocedencia
			where vv.id=".$idbien);
      
       return $query->result();	
		
	}

	function getEstadoBien($idbien)
	{ 
		$query = $this->db->query("select a.id, idbien, descripcion from dj_activos.situacionbien a join nueva_validacion.bien b on a.id = b.idsituacion where 	b.id =".$idbien);
      
       return $query->result();	
			
	} 

	function getEstadobaja($idbien)
	{
		$query = $this->db->query("select b.idbien, m.descripcion,resolucion_respaldo,b.observaciones,fecha from dj_activos.bajasbienes b, dj_activos.motivo m where b.idmotivo = m.id and b.idbien =".$idbien);
      
       return $query->result();	
	}
	
	function getDatosDocV($idd)//2019
	{
		$query = $this->db->query("select db.idtipodocumento, djb.idestado_documentaciondejurbe, db.id,db.idbien,db.idb,d.descripcion,db.nrodocumento,gestion,case when validado then 'Validado' else 'Sin Validar' end as val,case when adicionado  = 't' then 'Validador' else 'Entidad' end as registradopor,db.idb 
        	    from nueva_validacion.documentobien db 
        	    join dj_documento.documento d on db.idtipodocumento=d.id
        	    join dj_activos.bien djb on djb.id=db.idbien
                where db.eliminado = false and docmodificado = 'f' and db.id=".$idd );
                

		return $query->result();
	}


	function getTablaDocumentos($idBien)
	{	
		
        
        $query = $this->db->query("select db.idtipodocumento, djb.idestado_documentaciondejurbe,db.id,db,idb,db.idbien,d.descripcion,db.nrodocumento,gestion,case when validado then 'Validado' else 'Sin Validar' end as val,case when adicionado  = 't' then 'Validador' else 'Entidad' end as registradopor 
        		from nueva_validacion.documentobien db 
                join dj_documento.documento d on db.idtipodocumento=d.id
                join dj_activos.bien djb on djb.id=db.idbien
                where eliminado = false and docmodificado = 'f' and idb=".$idBien." order by db.idtipodocumento" );

		return $query->result();
	}


	function getDatosDocumento($idDocumento)
	{
        $query = $this->db->query("select idb,idbien,idtipodocumento,nrodocumento from nueva_validacion.documentobien where id=".$idDocumento );
 		return $query->result();
		
	}
	function getValidacionDocumento1($idDocumento)
	{
		$query = $this->db->query("select idb,idtipodocumento,nrodocumento,idbien,adicionado from nueva_validacion.documentobien where id=".$idDocumento);
		return $query->result();
	}
	function getValidacionDocumento2($idDocumento)
	{
			  $sql = "select a.id,idcorrespondencia,adjunta,legible,observacionesgenerales,nrodocumento,correctodocumento,marca,correctomarca,clase,correctoclase,placa,correctoplaca,nrochasis,correctochasis,nromotor,correctomotor,procedencia,correctoprocedencia,modelo,correctomodelo,color,correctocolor,idtipovehiculo,correctovehiculo,t1.observaciones
			   from nueva_validacion.v_valxgestvehiculo a 
                left join nueva_validacion.detallevalidacionvehiculo b on a.id=b.idvalidacion 
                left join (select idvalidacion,array_to_string(array_agg(idtipoobservacion),'|') as observaciones from nueva_validacion.v_valxgestvehiculo a
                join nueva_validacion.observacionvehiculo b on a.id=b.idvalidacion
                where iddocumentobien=".$idDocumento." and idgestion>=2014
                group by idvalidacion) as t1 on t1.idvalidacion=a.id
                where iddocumentobien=".$idDocumento;

			$query = $this->db->query($sql);

			return $query->result();
	}

	function getListaObservaciones()
	{
		$query = $this->db->query("select id,descripcion from nueva_validacion.tipoobservacion where idrubro=2");
		return $query->result();
	}

//todo guardar 

	function guardarValidacionVehiculo($idb,$idbien,$idgestion,$idcorrespondencia,$adjunta,$legible,$observaciones,$iddocumento)
	{
		$data = array(
			'idbien'=>$idbien,
			'idb'=>$idb,
	        'idgestion'=>$idgestion,
	        'idcorrespondencia' =>$idcorrespondencia,
	        'adjunta'=>$adjunta,
	        'legible'=>$legible,
	        'observacionesgenerales'=>$observaciones,
	        'iddocumentobien'=>$iddocumento,
                'idtipovalidacion'=> 1
		 );
		$this->db->insert('nueva_validacion.validacionxgestionvehiculo',$data); 
		return $this->db->insert_id();
		
		
	}

	function guardarDetalleValidacionveh($idvalidacion,$nrodocumento,$correctodocumento,$marca,$correctoMarca,$tipoVehiculo,$correctoTipoVehiculo,$clase,$correctoClase,$placa,$correctorPlaca,$nroMotor,$correctoMotor,$nroChasis,$correctoChasis,$procedencia,$correctoProcedencia,$modelo,$correctoModelo,$color,$correctocolor)
    {
    	$data = array(

           'idvalidacion'=>$idvalidacion,
           'nrodocumento'=>$nrodocumento,
           'correctodocumento'=>$correctodocumento,
           'marca'=>$marca,
           'correctomarca'=>$correctoMarca,
           'idtipovehiculo'=>$tipoVehiculo,
           'correctovehiculo'=>$correctoTipoVehiculo,
           'clase'=>$clase,
           'correctoclase'=>$correctoClase,
           'placa'=>$placa,
           'correctoplaca'=>$correctorPlaca,
           'nromotor'=>$nroMotor,
           'correctomotor'=>$correctoMotor,
           'nrochasis'=>$nroChasis,
           'correctochasis'=>$correctoChasis,
           'procedencia'=>$procedencia,
           'correctoprocedencia'=>$correctoProcedencia,
           'modelo'=>$modelo,
           'correctomodelo'=>$correctoModelo,
           'color'=>$color,
           'correctocolor'=>$correctocolor
        				
		 );
    	$this->db->insert('nueva_validacion.detallevalidacionvehiculo',$data); 
		return $this->db->insert_id();
		

          
    }


//todo editar

	function modificarvalidacionveh($idval,$idbien,$idgestion,$idcorrespondencia,$adjunta,$legible,$observaciones,$iddocumento)
	{

		$data = array(
			//'idbien'=>$idbien,
	       // 'idgestion'=>$idgestion,
	        'idcorrespondencia' =>$idcorrespondencia,
	        'adjunta'=>$adjunta,
	        'legible'=>$legible,
	        'observacionesgenerales'=>$observaciones,
	        'iddocumentobien'=>$iddocumento,
                'idtipovalidacion'=> 1
		 );
		$this->db->where('id',$idval);
		return  $this->db->update('nueva_validacion.validacionxgestionvehiculo',$data);

	}
	
	function eliobservacion($idval)
	{
		$this->db->where('idvalidacion', $idval);
		$this->db->delete('nueva_validacion.observacionvehiculo');
	}

	function guardarObservacionesValidacion($idval,$valor)
	{
      	$data = array(
			'idvalidacion' => $idval,
			'idtipoobservacion' => $valor,
			);
		return  $this->db->insert('nueva_validacion.observacionvehiculo',$data);
        //$sql2 = "insert into nueva_validacion.observacioninmueble (idvalidacion,idtipoobservacion) values ($idValidacion,$valor)";
        
	}

	function guardarEstadoDocumentacionGeneral($idValidacion,$idClase)
	{
        $query = $this->db->query("select * from nueva_validacion.estadodocumentacionbien(".$idValidacion.",".$idClase.")");
		return $query->result();
    }
    function editarDetalleValidacionveh($idvalidacion,$nrodocumento,$correctodocumento,$marca,$correctoMarca,$tipoVehiculo,$correctoTipoVehiculo,$clase,$correctoClase,$placa,$correctorPlaca,$nroMotor,$correctoMotor,$nroChasis,$correctoChasis,$procedencia,$correctoProcedencia,$modelo,$correctoModelo,$color,$correctocolor)
    {
    	$data = array(

          
           'nrodocumento'=>$nrodocumento,
           'correctodocumento'=>$correctodocumento,
           'marca'=>$marca,
           'correctomarca'=>$correctoMarca,
           'idtipovehiculo'=>$tipoVehiculo,
           'correctovehiculo'=>$correctoTipoVehiculo,
           'clase'=>$clase,
           'correctoclase'=>$correctoClase,
           'placa'=>$placa,
           'correctoplaca'=>$correctorPlaca,
           'nromotor'=>$nroMotor,
           'correctomotor'=>$correctoMotor,
           'nrochasis'=>$nroChasis,
           'correctochasis'=>$correctoChasis,
           'procedencia'=>$procedencia,
           'correctoprocedencia'=>$correctoProcedencia,
           'modelo'=>$modelo,
           'correctomodelo'=>$correctoModelo,
           'color'=>$color,
           'correctocolor'=>$correctocolor
        	
			
		 );
		$this->db->where('idvalidacion',$idvalidacion);
		return  $this->db->update('nueva_validacion.detallevalidacionvehiculo',$data);

    }
    function exitedetalleval($val)
    {

    	$this->db->where('idvalidacion',$val);
		$query = $this->db->get('nueva_validacion.detallevalidacionvehiculo');
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
    }
    function getmarcastext($var)
	{ 
	    $query = $this->db->query("select id,descripcion as marca from dj_activos.marcavehiculos where descripcion ilike '%".$var."%' limit 5");
	    return $query->result();
	}
	function getclase()
	{ 
	    $query = $this->db->query("select * from dj_activos.vista_tipobienclase where idclase=3");
	    return $query->result();
	}
}
?>