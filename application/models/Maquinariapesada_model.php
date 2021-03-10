				<?php
/*
*/

class Maquinariapesada_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct(); 
	}
 
	function estadovalidacionbien($id)
	{
		$query = $this->db->query("select * from nueva_validacion.vista_maquinariapesada where id =".$id);
        return $query->result();		
	}
	function select_validar($id)
	{ 

		$query = $this->db->query("select * from nueva_validacion.vista_maquinariapesada where identidad=".$id." and idestadovalidacion in (1,5) and habilitado = 1 ");
        return $query->result();	
	} 
	function verifiddocumentoMP($idd)//2018
	{
			$query = $this->db->query("select * from nueva_validacion.validacionxgestionmaquinariapesada where iddocumentobien='".$idd."'");	
			return $query->result();  	
	}

	function select_validadas($id)
	{
		$query = $this->db->query("select vmp.*,vg.idtipovalidacion 
from nueva_validacion.vista_maquinariapesada vmp 
left join (
select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestionmaquinariapesada where idtipovalidacion=2
) vg on vg.idb=vmp.id
where habilitado = 1  and idestadovalidacion = 3 and identidad=".$id);
      
       return $query->result();	
	}
	function select_totalmaqp($id)//2018
	{
		$query = $this->db->query("select vmp.*,vg.idtipovalidacion 
from nueva_validacion.vista_maquinariapesada vmp 
left join (
select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestionmaquinariapesada where idtipovalidacion=2
) vg on vg.idb=vmp.id
where habilitado = 1 and identidad=".$id);
      
       return $query->result();	
	}

	function selec_maquinaria_id($idbien)
	{
		$query = $this->db->query("select idb,idbien,descripcion,marca,modelo,nrochasis,nromotor,color from nueva_validacion.maquinariapesada where idb= ".$idbien." and idgestion >= 2014");
      
       return $query->result();	
		 
	}

	function getEstadoBien($idbien)
	{
		$query = $this->db->query("select a.id, idbien, descripcion from dj_activos.situacionbien a join nueva_validacion.bien b on a.id 						= b.idsituacion where idbien=".$idbien);
      
       return $query->result();	
			
	}
	function getTablaDocumentos($idBien)
	{
   
                
        $query = $this->db->query("select db.id,db.idb,db.idbien,d.descripcion,db.nrodocumento,gestion,case when validado then 'Validado' else 'Sin Validar' end as val,case when adicionado ='t' then 'Validador' else 'Entidad' end as registradopor from nueva_validacion.documentobien db 
                join dj_documento.documento d on db.idtipodocumento=d.id
                where eliminado = false and docmodificado = 'f' and  idb=".$idBien );

		return $query->result();
	}
	function getValidacionDocumento1($idDocumento)
	{
		$query = $this->db->query("select idb,idtipodocumento,gestion,nrodocumento, idbien,adicionado from nueva_validacion.documentobien  where id=".$idDocumento);

		return $query->result();
	}
	function getValidacionDocumento2($idDocumento,$gestion_doc)
	{

			$sql = "select a.id,idcorrespondencia,adjunta,legible,observacionesgenerales,
                nrodocumento,correctodocumento,descripcion,correctodescripcion,marca,correctomarca,
                modelo,correctomodelo,nrochasis,correctonrochasis,nromotor,correctonromotor,color,correctocolor
                ,t1.observaciones from nueva_validacion.v_validxgestmaquinariapesada a 
                left join nueva_validacion.detallevalidacionmaquinariapesada b on a.id=b.idvalidacion 
                left join (select idvalidacion,array_to_string(array_agg(idtipoobservacion),'|') as observaciones from nueva_validacion.v_validxgestmaquinariapesada a
                join nueva_validacion.observacionmaquinariapesada b on a.id=b.idvalidacion
                where iddocumentobien=".$idDocumento." 
                group by idvalidacion) as t1 on t1.idvalidacion=a.id
                where iddocumentobien=".$idDocumento;
//and idgestion=$gestion_doc

			$query = $this->db->query($sql);

			return $query->result();
	}

	
	function getListaObservaciones()
	{
		$query = $this->db->query("select id,descripcion from nueva_validacion.tipoobservacion where idrubro=4 ");
		return $query->result();
	}

//todo guardar
	function guardarValidacionmaquinariapesada($idb,$idbien,$idgestion,$idcorrespondencia,$adjunta,$legible,$observaciones,$iddocumento)
	{
		$data = array(
			'idb' => $idb,
			'idbien' => $idbien,
		 	'idgestion'=> $idgestion,
		 	'idcorrespondencia'  =>$idcorrespondencia,
		 	'adjunta' => $adjunta,
		 	'legible' => $legible,
		 	'observacionesgenerales' => $observaciones,
		 	'iddocumentobien' => $iddocumento,
                        'idtipovalidacion'=> 1,

		 );
		$this->db->insert('nueva_validacion.validacionxgestionmaquinariapesada',$data); 
		return $this->db->insert_id();

	}
	function guardarDetalleValidacionmaquinariapesada($idval,$NroDocumento,$Descripcion,$Marca,$Modelo,$NroChasis,$NroMotor,$Color,$CorrectoDocumento,$CorrectoDescripcion,$CorrectoMarca,$CorrectoModelo,$CorrectoNroChasis,$CorrectoNroMotor,$CorrectoColor)
    {

    	$data = array(  
		    'idvalidacion'=>$idval,
			'nrodocumento'=>$NroDocumento,
			'correctodocumento'=>$CorrectoDocumento,
			'descripcion'=>$Descripcion,
			'correctodescripcion'=>$CorrectoDescripcion,
			'marca'=>$Marca,
			'correctomarca'=>$CorrectoMarca,
			'modelo'=>$Modelo,
			'correctomodelo'=>$CorrectoModelo,
			'nrochasis'=>$NroChasis,
			'correctonrochasis'=>$CorrectoNroChasis,
			'nromotor'=>$NroMotor,
			'correctonromotor'=>$CorrectoNroMotor,
			'color'=>$Color,
			'correctocolor'=>$CorrectoColor //*/
		);	 
    	$this->db->insert('nueva_validacion.detallevalidacionmaquinariapesada',$data); 
		return $this->db->insert_id();//*/

    }


//todo editar
	function modificarvalidacionmaquinariapesada($idval,$idbien,$idgestion,$idcorrespondencia,$adjunta,$legible,$observaciones,$iddocumento)
	{

		$data = array(
			'idbien' => $idbien,
		 	'idgestion'=> $idgestion,
		 	'idcorrespondencia'  =>$idcorrespondencia,
		 	'adjunta' => $adjunta,
		 	'legible' => $legible,
		 	'observacionesgenerales' => $observaciones,
		 	'iddocumentobien' => $iddocumento,
                        'idtipovalidacion'=> 1
		 );
		$this->db->where('id',$idval);
		return  $this->db->update('nueva_validacion.validacionxgestionmaquinariapesada',$data);


	}
	function editarDetalleValidacionmaquinariapesada($idval,$NroDocumento,$Descripcion,$Marca,$Modelo,$NroChasis,$NroMotor,$Color,$CorrectoDocumento,$CorrectoDescripcion,$CorrectoMarca,$CorrectoModelo,$CorrectoNroChasis,$CorrectoNroMotor,$CorrectoColor)
    {
    	$data = array(
  
			'nrodocumento'=>$NroDocumento,
			'correctodocumento'=>$CorrectoDocumento,
			'descripcion'=>$Descripcion,
			'correctodescripcion'=>$CorrectoDescripcion,
			'marca'=>$Marca,
			'correctomarca'=>$CorrectoMarca,
			'modelo'=>$Modelo,
			'correctomodelo'=>$CorrectoModelo,
			'nrochasis'=>$NroChasis,
			'correctonrochasis'=>$CorrectoNroChasis,
			'nromotor'=>$NroMotor,
			'correctonromotor'=>$CorrectoNroMotor,
			'color'=>$Color,
			'correctocolor'=>$CorrectoColor
			
		 );
		$this->db->where('idvalidacion',$idval);
		return  $this->db->update('nueva_validacion.detallevalidacionmaquinariapesada',$data);

    }
	 function eliobservacion($idval)
	{
		$this->db->where('idvalidacion', $idval);
		$this->db->delete('nueva_validacion.observacionmaquinariapesada');
	}

	function guardarObservacionesValidacion($idval,$valor)
	{
      	$data = array(
			'idvalidacion' => $idval,
			'idtipoobservacion' => $valor,
			);
		return  $this->db->insert('nueva_validacion.observacionmaquinariapesada',$data);
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
		$query = $this->db->get('nueva_validacion.detallevalidacionmaquinariapesada');
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
    }
   
}
?>