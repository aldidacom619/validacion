 <?php
/*
*/

class Maquinaria_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	} 
 	
 	function estadovalidacionbien($id)
	{
		$query = $this->db->query("select * from nueva_validacion.vista_maquinaria where id =".$id);
        return $query->result();		
	}

	function select_validarmaq($id)
	{
		$query = $this->db->query("select * from (select id, identidad, idgestion,idtipobien,idestadovalidacion, idestadodocumentacion, idbien, idsituacion, idestadobien, iduso,
                 idclase,descripcion, marca, modelo, nroserie,situacion, tipobien,estadobien, uso, clasebien, entidad, sigla, usuario, documentos
                from nueva_validacion.vista_maquinaria where habilitado = 1) a
                where a.idestadovalidacion not in (3) AND a.identidad = ".$id);

		
        return $query->result();	 
	}
	function select_validadasmaq($id)
	{
		$query = $this->db->query("select id, identidad, idgestion,idtipobien,idestadovalidacion, idestadodocumentacion, idbien, idsituacion, idestadobien, iduso,
                idclase,descripcion, marca, modelo, nroserie,situacion, tipobien,estadobien, uso, clasebien, entidad, sigla, usuario, documentos, vg.idtipovalidacion
from nueva_validacion.vista_maquinaria vm 
left join (
select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestionmaquinaria where idtipovalidacion=2
) vg on vg.idb=vm.id
where habilitado = 1 and idestadovalidacion = 3 AND identidad =".$id);
      
       return $query->result();	
	}
	function select_totalmaq($id)//2018
	{
		$query = $this->db->query("select id, identidad, idgestion,idtipobien,idestadovalidacion, idestadodocumentacion, idbien, idsituacion, idestadobien, iduso,
                idclase,descripcion, marca, modelo, nroserie,situacion, tipobien,estadobien, uso, clasebien, entidad, sigla, usuario, documentos, vg.idtipovalidacion
from nueva_validacion.vista_maquinaria vm 
left join (
select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestionmaquinaria where idtipovalidacion=2
) vg on vg.idb=vm.id
where habilitado = 1 AND identidad =".$id);
      
       return $query->result();	
	}

	
  function verifiddocumentomaq($idd)//2018
	{
			$query = $this->db->query("select * from nueva_validacion.validacionxgestionmaquinaria where iddocumentobien='".$idd."'");	
			return $query->result();  	
	}



	function selec_maquinaria_id($idbien)
	{
		$query = $this->db->query("select idb,idbien,descripcion,marca,modelo,nroserie from nueva_validacion.maquinaria where idb=".$idbien);
      
       return $query->result();	
		
	}

	function getEstadoBien($idbien)
	{
		$query = $this->db->query("select a.id, idbien, descripcion from dj_activos.situacionbien a join nueva_validacion.bien b on a.id = b.idsituacion where 				idbien =".$idbien);
      
       return $query->result();	
			
	} 
	function getTablaDocumentos($idBien)
	{	
		
        
        $query = $this->db->query("select db.id,db.idb,db.idbien,d.descripcion,db.nrodocumento,gestion,case when validado then 'Validado' else 'Sin Validar' end as val,case when adicionado ='t' then 'Validador' else 'Entidad' end as registradopor from nueva_validacion.documentobien db 
                join dj_documento.documento d on db.idtipodocumento=d.id
                where eliminado = false and docmodificado = 'f'  and idb=".$idBien );

		return $query->result();
	}
  

	function getDatosDocumento($idDocumento)
	{
        $query = $this->db->query("select idbien,idtipodocumento,nrodocumento,adicionado from nueva_validacion.documentobien where id=".$idDocumento );
 		return $query->result();
		
	}

	function getValidacionDocumento2($idDocumento)
	{
			 $sql = "select a.id,idcorrespondencia,adjunta,legible,observacionesgenerales,nrodocumento,correctodocumento,descripcion,correctodescripcion,marca,correctomarca,modelo,correctomodelo,nroserie,correctonroserie,t1.observaciones from nueva_validacion.v_validxgestmaquinaria a 
                left join nueva_validacion.detallevalidacionmaquinaria b on a.id=b.idvalidacion 
                left join (select idvalidacion,array_to_string(array_agg(idtipoobservacion),'|') as observaciones from nueva_validacion.v_validxgestmaquinaria a
                join nueva_validacion.observacionmaquinaria b on a.id=b.idvalidacion
                where iddocumentobien=".$idDocumento." and idgestion>=2014
                group by idvalidacion) as t1 on t1.idvalidacion=a.id
                where iddocumentobien=".$idDocumento;

			  
			$query = $this->db->query($sql);

			return $query->result();
	}
 
	function getListaObservaciones()
	{
		$query = $this->db->query("select id,descripcion from nueva_validacion.tipoobservacion where idrubro=4");
		return $query->result();
	}

//todo guardar

	function guardarValidacionMaquinaria($idb,$idbien,$idgestion,$idcorrespondencia,$adjunta,$legible,$observaciones,$iddocumento)
	{
		$data = array(
			'idb'=> $idb,
			'idbien'=>$idbien,
	        'idgestion'=>$idgestion,
	        'idcorrespondencia' =>$idcorrespondencia,
	        'adjunta'=>$adjunta,
	        'legible'=>$legible,
	        'observacionesgenerales'=>$observaciones,
	        'iddocumentobien'=>$iddocumento,
                'idtipovalidacion'=> 1,
		 );
		$this->db->insert('nueva_validacion.validacionxgestionmaquinaria',$data); 
		return $this->db->insert_id();


		
		
	}

	function guardarDetalleValidacionmaq($idval,$nroDocumento,$nroDocumentoOpcion,$descripcion,$descripcionOpcion,$marca,$marcaOpcion,$modelo,$modeloOpcion,$serie,$serieOpcion)
    {
    	$data = array(

           'idvalidacion'=>$idval,
           'nrodocumento'=>$nroDocumento,
           'correctodocumento'=>$nroDocumentoOpcion,
           'descripcion'=>$descripcion,
           'correctodescripcion'=>$descripcionOpcion,
           'marca'=>$marca,
           'correctomarca'=>$marcaOpcion,
           'modelo'=>$modelo,
           'correctomodelo'=>$modeloOpcion,
           'nroserie'=>$serie,
           'correctonroserie'=>$serieOpcion
           
			
		 );
    	$this->db->insert('nueva_validacion.detallevalidacionmaquinaria',$data); 
		return $this->db->insert_id();
		
		
          
    }


//todo editar

	function modificarvalidacionmaq($idval,$idbien,$idgestion,$idcorrespondencia,$adjunta,$legible,$observaciones,$iddocumento)
	{
		$data = array(
			'idbien'=>$idbien,
	        'idgestion'=>$idgestion,
	        'idcorrespondencia' =>$idcorrespondencia,
	        'adjunta'=>$adjunta,
	        'legible'=>$legible,
	        'observacionesgenerales'=>$observaciones,
	        'iddocumentobien'=>$iddocumento,
                'idtipovalidacion'=> 1,
		 );
		$this->db->where('id',$idval);
		return  $this->db->update('nueva_validacion.validacionxgestionmaquinaria',$data);

	}
	function editarDetalleValidacionmaq($idval,$nroDocumento,$nroDocumentoOpcion,$descripcion,$descripcionOpcion,$marca,$marcaOpcion,$modelo,$modeloOpcion,$serie,$serieOpcion)
    {
    	$data = array(

           'idvalidacion'=>$idval,
           'nrodocumento'=>$nroDocumento,
           'correctodocumento'=>$nroDocumentoOpcion,
           'descripcion'=>$descripcion,
           'correctodescripcion'=>$descripcionOpcion,
           'marca'=>$marca,
           'correctomarca'=>$marcaOpcion,
           'modelo'=>$modelo,
           'correctomodelo'=>$modeloOpcion,
           'nroserie'=>$serie,
           'correctonroserie'=>$serieOpcion
           
			
		 );
    	
		$this->db->where('idvalidacion',$idval);
		return  $this->db->update('nueva_validacion.detallevalidacionmaquinaria',$data);

    }
	
	function guardarEstadoDocumentacionGeneral($idValidacion,$idClase)
	{
        $query = $this->db->query("select * from nueva_validacion.estadodocumentacionbien(".$idValidacion.",".$idClase.")");
		return $query->result();
    }


    function eliobservacion($idval)
	{
		$this->db->where('idvalidacion', $idval);
		$this->db->delete('nueva_validacion.observacionmaquinaria');
	}

	function guardarObservacionesValidacion($idval,$valor)
	{
      	$data = array(
			'idvalidacion' => $idval,
			'idtipoobservacion' => $valor,
			);
		return  $this->db->insert('nueva_validacion.observacionmaquinaria',$data);
        //$sql2 = "insert into nueva_validacion.observacioninmueble (idvalidacion,idtipoobservacion) values ($idValidacion,$valor)";
        
	}
	function exitedetalleval($val)
    {
		$this->db->where('idvalidacion',$val);
		$query = $this->db->get('nueva_validacion.detallevalidacionmaquinaria');
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
    }
   
}
?>