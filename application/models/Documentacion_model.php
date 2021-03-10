<?php
/* 
*/

class Documentacion_model extends CI_Model
{
  
  function __construct() 
  {
    parent::__construct();
    $this->load->helper('date');
  }

   
function getTipoDocumentacion($tipo)
{
  

  $query = $this->db->query("select d.id,d.descripcion from dj_documento.documento d JOIN dj_documento.documento_clasebien cb ON d.id = cb.iddocumento where idclase=".$tipo);
    return $query->result();  
}  

function getTipoDocumentacionbien($tipo,$bien) 
{
   $query = $this->db->query("select d.id,d.descripcion from dj_documento.documento d 
JOIN dj_documento.documento_clasebien cb ON d.id = cb.iddocumento where idclase= ".$tipo." and activo = 't' and d.id not in(select idtipodocumento from nueva_validacion.documentobien where idb = ".$bien." and eliminado = 'f')");
      
    return $query->result();  
} 
function getTipoDocumentacionbienalquiler($tipo,$bien)
{
   $query = $this->db->query("select d.id,d.descripcion from dj_documento.documento d 
JOIN dj_documento.documento_clasebien cb ON d.id = cb.iddocumento where idclase= ".$tipo." and activo = 't' and d.id not in(select idtipodocumento from nueva_validacion.documentobienalquiler where idb = ".$bien." and eliminado = 'f')");
      
    return $query->result();  
}  

function getTipoDocumentaciontipo($tipo)
{
  

    $query = $this->db->query("select d.id,d.descripcion from dj_documento.documento d where d.id=".$tipo);
      
    return $query->result();  
}  
// kerenhapuc1983
 
function getTablaDocumentosBienAdd($idBien)
{
   
    $query = $this->db->query("select db.id,d.descripcion,db.nrodocumento,gestion from nueva_validacion.documentobien db 
                join dj_documento.documento d on db.idtipodocumento=d.id
                where adicionado=true and eliminado = false and idb=".$idBien);
      
    return $query->result();
}

function getTablaDocumentosBienAddalquiler($idBien)
{
   
    $query = $this->db->query("select db.id,d.descripcion,db.nrodocumento,gestion from nueva_validacion.documentobienalquiler db 
                join dj_documento.documento d on db.idtipodocumento=d.id
                where adicionado=true and eliminado = false and idb=".$idBien);
      
    return $query->result();
}

function insertar_documento($idb,$idBien,$tipoDoc,$nroDoc,$fecha,$idfun)
{
  
    $data = array(
      'idb'=>$idb,
      'idbien'=>$idBien,
      'idtipodocumento'=>$tipoDoc,
      'nrodocumento'=>$nroDoc,
      'adicionado'=>true,
      'idfuncionario'=>$idfun,
      'gestion'=>2017,
      'validado'=>false,
      'tiporegistro'=> 1,
      'docmodificado'=>false,
      'antiguo'=>false,
      'eliminado'=>false,
      'fechaadicion'=>$fecha,
      'fecha_registro'=>$fecha,
      
      );
    $this->db->insert('nueva_validacion.documentobien',$data); 
  return $this->db->insert_id();

}
function update_documento($idDoc,$tipoDoc,$nroDoc,$fecha)
{
   $data = array(
        'validado'=>false,
        'eliminado'=>false,
        
        'idtipodocumento'=>$tipoDoc,
      'nrodocumento'=>$nroDoc,
      'fechaadicion'=>$fecha,
      'fecha_registro'=>$fecha,
      );
  $this->db->where('id',$idDoc);
  return  $this->db->update('nueva_validacion.documentobien',$data);

    //$this->db->insert('nueva_validacion.documentobien',$data); 
}
// ALQUILER
function insertar_documentoalquiler($idb,$idBien,$tipoDoc,$nroDoc,$fecha,$idfun) 
{
  
    $data = array(
      'idb'=>$idb,
      'idbien'=>$idBien,
      'idtipodocumento'=>$tipoDoc,
      'nrodocumento'=>$nroDoc,
      'adicionado'=>true,
      'idfuncionario'=>$idfun,
      'gestion'=>2017,
      'validado'=>false,
      
      'eliminado'=>false,
      'fechavalidaciondoc'=>$fecha,
      'tiporegistro'=>1,
      'docmodificado'=>false,
      );
    $this->db->insert('nueva_validacion.documentobienalquiler',$data); 
  return $this->db->insert_id();

}
function update_documentoalquiler($idDoc,$tipoDoc,$nroDoc,$fecha)
{
   $data = array(
        'idtipodocumento'=>$tipoDoc,
      'nrodocumento'=>$nroDoc,
      'fechavalidaciondoc'=>$fecha,
      );
  $this->db->where('id',$idDoc);
  return  $this->db->update('nueva_validacion.documentobienalquiler',$data);

    //$this->db->insert('nueva_validacion.documentobien',$data); 
}

 
function eliminar_documento($idDoc)
{
   $data = array(
        'eliminado'=>true,
      );
  $this->db->where('id',$idDoc);
  return  $this->db->update('nueva_validacion.documentobien',$data);

}
function eliminarDocumentoAddAlquiler($idDoc)
{
       
    $data = array(
        'eliminado'=>true,
      );
  $this->db->where('id',$idDoc);
  return  $this->db->update('nueva_validacion.documentobienalquiler',$data);
}
function selecdoc_id($id)
{
  $query = $this->db->query("select b.idtipodocumento,b.nrodocumento,d.descripcion from nueva_validacion.documentobien b join dj_documento.documento d on d.id = b.idtipodocumento where b.id=".$id);
      
    return $query->result();
}
function selecdocalquiler_id($id)
{
  $query = $this->db->query("select b.idtipodocumento,b.nrodocumento,d.descripcion from nueva_validacion.documentobienalquiler b join dj_documento.documento d on d.id = b.idtipodocumento where b.id=".$id);
      
    return $query->result();
}

// PERSONAS

function getTablaPersonaDocumentosBien($id) 
{
  $query = $this->db->query("select a.id,a.idb,a.iddocumento, a.idbien, a.descripcion, a.idtipodatoadicional, b.descripcion as tipodatoadicional, a.idtipodocumento, d.descripcion as documento, a.eliminado
from nueva_validacion.datoadicional a
join nueva_validacion.tipodatoadicional b on a.idtipodatoadicional = b.id
join dj_documento.documento d on d.id = a.idtipodocumento 
where eliminado = false and iddocumento =".$id);
      
    return $query->result();
}

function getentidades()
{
  
  $query = $this->db->query("select id,nombre as entidad from gobierno.entidades order by nombre asc");
    return $query->result();
}
function getentidadestext($var)
{ 
    $query = $this->db->query("select DISTINCT nombre as entidad from gobierno.entidades where nombre ilike '%".$var."%' limit 10");
    return $query->result();
}

function insertar_persona($idb,$iddocumento,$idBien, $tipoDoc, $tipoPersona, $persona,$idfun)
{
   $data = array(
      'idb'=>$idb,
      'iddocumento'=>$iddocumento,
      'idbien'=>$idBien,
      'idtipodocumento'=>$tipoDoc,
      'descripcion'=>$persona,
      'idtipodatoadicional'=>$tipoPersona,
      'eliminado'=>false,
      'idfuncionario'=>$idfun,
      
      );
    $this->db->insert('nueva_validacion.datoadicional',$data); 
  return $this->db->insert_id();


}

function insertar_personaalquiler($idb,$iddocumento,$idBien, $tipoDoc, $tipoPersona, $persona,$idfun)
{
  $data = array(
      'idb'=>$idb,
      'iddocumento'=>$iddocumento,
      'idbien'=>$idBien,
      'idtipodocumento'=>$tipoDoc,
      'descripcion'=>$persona,
      'idtipodatoadicional'=>$tipoPersona, 
      'eliminado'=>false,
      'idfuncionario'=>$idfun,
      
      );
    $this->db->insert('nueva_validacion.datoadicionalalquiler',$data); 
  return $this->db->insert_id();
 
}
 
function editarPersonaDocumentoBien($idpersona, $tipoDoc, $tipoPersona, $persona)
{
  $data = array(
        'idtipodocumento'=>$tipoDoc,
      'idtipodatoadicional'=>$tipoPersona,
      'descripcion'=>$persona
    );
  $this->db->where('id',$idpersona);
  return  $this->db->update('nueva_validacion.datoadicional',$data);

  
}
function eliminar_persona($idpersona)
{
  $data = array(
      'eliminado'=> true
    );
  $this->db->where('id',$idpersona);
  return  $this->db->update('nueva_validacion.datoadicional',$data);
}
function editarPersonaDocumentoBienAlquiler($idpersona, $tipoDoc, $tipoPersona, $persona)
{
  $data = array(
        
      'idtipodocumento'=>$tipoDoc,
      'descripcion'=>$persona,
      'idtipodatoadicional'=>$tipoPersona,
      
      );
  $this->db->where('id',$idpersona);
  return  $this->db->update('nueva_validacion.datoadicionalalquiler',$data);
}

function eliminar_personaalquiler($idpersona)
{
  $data = array(
        
          'eliminado'=> true
      
      );
  $this->db->where('id',$idpersona);
  return  $this->db->update('nueva_validacion.datoadicionalalquiler',$data);  
}

function getPersonaAdicionado($id)
{
  $query = $this->db->query("select id,idtipodocumento,idtipodatoadicional,descripcion from nueva_validacion.datoadicional where id=".$id);
    return $query->result();
  
}

function getPersonaAdicionadoalquiler($id)
{
  $query = $this->db->query("select id,idtipodocumento,idtipodatoadicional,descripcion from nueva_validacion.datoadicionalalquiler where id=".$id);
    return $query->result();
  
}

function getTablaPersonaDocumentosBienAlquiler($id) 
{
  $query = $this->db->query("select a.id,a.idb,a.iddocumento, a.idbien, a.descripcion, a.idtipodatoadicional, b.descripcion as tipodatoadicional, a.idtipodocumento, d.descripcion as documento, a.eliminado
from nueva_validacion.datoadicionalalquiler a
join nueva_validacion.tipodatoadicional b on a.idtipodatoadicional = b.id
join dj_documento.documento d on d.id = a.idtipodocumento
where eliminado = false and iddocumento =".$id);
      
    return $query->result();
}
     
function getValidacionDocumento($idDocumento)
{
  $query = $this->db->query("select idb,idtipodocumento,nrodocumento,idbien,adicionado from nueva_validacion.documentobien where id=".$idDocumento);
  return $query->result();
}  

function getValidacionDocumentoalquiler($idDocumento)
{
  $query = $this->db->query("select idb,idtipodocumento,nrodocumento,idbien,adicionado from nueva_validacion.documentobienalquiler where id=".$idDocumento);
  return $query->result();
}  


//INICIO DE VALIDACION AUTOMATICA 2019
function verifiddocumentoInm($idd)//2018
  {
      $query = $this->db->query("select * from nueva_validacion.validacionxgestioninmueble where iddocumentobien='".$idd."'");  
      return $query->result();    
  }
function validarDocumentoIntermedia($idB,$idBien,$idDocumento){
$datestring = " %Y-%m-%d %H:%i:%s";
$time = time();
$fecha =  mdate($datestring, $time); 

$query = $this->db->query("
select db.idtipodocumento, djb.idestado_documentaciondejurbe,db.id as iddocbien,db.idbien,db.idb,d.descripcion
from nueva_validacion.documentobien db 
join dj_documento.documento d on db.idtipodocumento=d.id
join dj_activos.bien djb on djb.id=db.idbien
where db.eliminado = false and docmodificado = 'f' and db.idb='".$idB."'
  ");
$valor = $query->result();
       foreach ($valor as $fila)  
       {
              if($fila->idtipodocumento!=1)
                {
                  $existDocInm = $this->verifiddocumentoInm($fila->iddocbien);
                  if(!$existDocInm){


                            $data = array(
                                      'idb'=>$fila->idb,
                                      'idbien'=>$fila->idbien,
                                      'idgestion'=>2019,
                                      'idcorrespondencia' =>1,
                                      'adjunta'=>false,
                                      'legible'=>false,
                                      'observacionesgeneral'=>'validacion automatica de documentacion intermedia',
                                      'iddocumentobien'=>$fila->iddocbien,
                                      'idtipovalidacion'=>'3'
                                 );
                                $this->db->insert('nueva_validacion.validacionxgestioninmueble',$data); 
                                $idval = $this->db->insert_id();

                                //actualizacion estado documentobien
                                $data2 = array(
                                    'validado'=>true,
                                    'fechavalidaciondoc'=>$fecha,
                                    'fecvalidado'=>$fecha,
                                    'gestion_validacion'=>2019,

                                );
                              $this->db->where('id',$fila->iddocbien);
                              $filas = $this->db->update('nueva_validacion.documentobien',$data2); 
                      }
                }
      
       }

       $data3 = array(
        'idestadovalidacion'=>3,
            'fechavalidacionbien'=>$fecha,
            'fecvalidado'=>$fecha,
            'idestadodocumentacion'=>2
        );
      $this->db->where('id',$idB);
      $this->db->update('nueva_validacion.bien',$data3);


}
//vehiculos
function verifiddocumentoVe($idd)//2018
  {
      $query = $this->db->query("select * from nueva_validacion.validacionxgestionvehiculo where iddocumentobien='".$idd."'");  
      return $query->result();    
  }
function validarDocumentoIntermediaVe($idB,$idBien,$idDocumento){
$datestring = " %Y-%m-%d %H:%i:%s";
$time = time();
$fecha =  mdate($datestring, $time); 

$queryV = $this->db->query("
select db.idtipodocumento, djb.idestado_documentaciondejurbe,db.id as iddocbien,db,idb,db.idbien,d.descripcion,db.nrodocumento 
from nueva_validacion.documentobien db 
join dj_documento.documento d on db.idtipodocumento=d.id
join dj_activos.bien djb on djb.id=db.idbien
where eliminado = false and docmodificado = 'f' and idb='".$idB."'
  ");
$valorV = $queryV->result();
       foreach ($valorV as $fila)  
       {
              if($fila->idtipodocumento!=4)
                {
                  $existDocVe = $this->verifiddocumentoVe($fila->iddocbien);
                  if(!$existDocVe){


                            $data = array(
                                      'idb'=>$fila->idb,
                                      'idbien'=>$fila->idbien,
                                      'idgestion'=>2019,
                                      'idcorrespondencia' =>1,
                                      'adjunta'=>false,
                                      'legible'=>false,
                                      'observacionesgenerales'=>'validacion automatica de documentacion intermedia',
                                      'iddocumentobien'=>$fila->iddocbien,
                                      'idtipovalidacion'=>'3'
                                 );
                                $this->db->insert('nueva_validacion.validacionxgestionvehiculo',$data); 
                                $idvalV = $this->db->insert_id();

                                //actualizacion estado documentobien
                                $data2 = array(
                                    'validado'=>true,
                                    'fechavalidaciondoc'=>$fecha,
                                    'fecvalidado'=>$fecha,
                                    'gestion_validacion'=>2019,

                                );
                              $this->db->where('id',$fila->iddocbien);
                              $filas = $this->db->update('nueva_validacion.documentobien',$data2); 
                      }
                }
      
       }

       $data3 = array(
        'idestadovalidacion'=>3,
            'fechavalidacionbien'=>$fecha,
            'fecvalidado'=>$fecha,
            'idestadodocumentacion'=>2
        );
      $this->db->where('id',$idB);
      $this->db->update('nueva_validacion.bien',$data3);


}

function validacionAutomaticaInmuebles(){
$cont=0;
$query = $this->db->query("
select * from vistas2018.v_validxgestinmueble2018 v
join (
select idbien from nueva_validacion.bien where habilitado=1 and idclase in (1,2) and idbien not in(
select * from vistas2019.inmuebles_nuevos_modificados2019 
)
order by idbien asc
) val on val.idbien=v.idbien
--where v.idbien=201
order by v.idbien asc
  ");
$valor = $query->result();
 foreach ($valor as $fila) 
   {
    $query1 = $this->db->query("select id from nueva_validacion.documentobien where iddocumento='".$fila->iddocdejurbe."'");
    $valor1 = $query1->result();
    $iddoc = $valor1[0]->id;
    //$iddocbien = $valor1[0]->iddocumentobien;
      $queryVerif = $this->db->query("select id from nueva_validacion.validacionxgestioninmueble where iddocumentobien='".$iddoc."'");
          $existDoc = $queryVerif->result();
               if(!$existDoc){
                     $idval2018=$fila->id; 
                            $data = array(
                          'idb'=>$fila->idb,
                          'idbien'=>$fila->idbien,
                          'idgestion'=>$fila->idgestion,
                          'idcorrespondencia' =>$fila->idcorrespondencia,
                          'adjunta'=>$fila->adjunta,
                          'legible'=>$fila->legible,
                          'observacionesgeneral'=>$fila->observacionesgeneral,
                          'iddocumentobien'=>$iddoc,
                          'idtipovalidacion'=>'2'
                     );
                    $this->db->insert('nueva_validacion.validacionxgestioninmueble',$data); 
                    $idval = $this->db->insert_id();
                        $query2 = $this->db->query("select * from vistas2018.detallevalidacioninmueble2018 where idvalidacion='".$idval2018."'");
                        $detalleVal2018 = $query2->result();
                                if($detalleVal2018) {
                                  $data2 = array(
                                          'idvalidacion'=>$idval,
                                          'nrodocumento'=>$detalleVal2018[0]->nrodocumento,
                                          'correctodocumento'=>$detalleVal2018[0]->correctodocumento,
                                          'superficieterreno' =>$detalleVal2018[0]->superficieterreno,
                                          'correctosupterreno'=>$detalleVal2018[0]->correctosupterreno,
                                          'catastro'=>$detalleVal2018[0]->catastro,
                                          'correctocatastro'=>$detalleVal2018[0]->correctocatastro,
                                          'denominacion'=>$detalleVal2018[0]->denominacion,
                                          'correctodenominacion'=>$detalleVal2018[0]->correctodenominacion,
                                          'zona'=>$detalleVal2018[0]->zona,
                                          'correctozona'=>$detalleVal2018[0]->correctozona,
                                          'direccion'=>$detalleVal2018[0]->direccion,
                                          'correctodireccion'=>$detalleVal2018[0]->correctodireccion
                                
                             );
                            $this->db->insert('nueva_validacion.detallevalidacioninmueble',$data2); 
                            $idval2 = $this->db->insert_id();
                        }

                                    $query3 = $this->db->query("select * from vistas2018.observacioninmueble2018 where idvalidacion='".$idval2018."'");
                                     $obs2018 = $query3->result();
                                    if($obs2018) {
                                        foreach ($obs2018 as $fila1){
                                            $data3 = array(
                                                      'idvalidacion'=>$idval,
                                                      'idtipoobservacion'=>$fila1->idtipoobservacion
                                                                                          
                                              );
                                             $this->db->insert('nueva_validacion.observacioninmueble',$data3); 
                                             $idval3 = $this->db->insert_id();
                                        }
                                             
                                    }

                             $datestring = " %Y-%m-%d %H:%i:%s";
                             $time = time();
                             $fecha =  mdate($datestring, $time);  
                             $tipodoc=3;     
                             $document1 = $this->validarDocumento($iddoc,$fila->idbien,$fecha,$tipodoc,$fila->idb);

               } 
         
//var_dump($detalleVal2018);
//$cont=$cont+$fila->idbien; 
   }

/*
$query1 = $this->db->query("select id from nueva_validacion.documentobien where iddocumento=243895");
$valor1 = $query1->result();
return $valor1[0]->id;
  //return "hola desde documentos";
*/
return $idval;
}


 









//FIN DE VALIDACION AUTOMATICA 2019


// DE INMUEBLES

function validarDocumento($idDocumento,$idBien,$fecha,$tipodocumento,$idb){
        
    $data = array(
      'validado'=>true,
          'fechavalidaciondoc'=>$fecha,
          'fecvalidado'=>$fecha,
          'gestion_validacion'=>2019,

      );
    $this->db->where('id',$idDocumento);
    $filas = $this->db->update('nueva_validacion.documentobien',$data);
        $query = $this->db->query("select (select count(*) from nueva_validacion.documentobien where idb=".$idb." and eliminado=false and docmodificado = 'f') as total, (select count(*) from nueva_validacion.documentobien where idb=".$idb." and eliminado=false and validado=true and docmodificado = 'f') as validados");
        $filas2 = $query->result();
        $nroTotalDocumentos=$filas2[0]->total;
        $nroDocumentosValidados=$filas2[0]->validados;

       $estadodoc = $this->db->query("select *from nueva_validacion.bien where id=".$idb);
        $respuesta = $estadodoc->result();

        $estado = $respuesta[0]->idestadodocumentacion;
        if($estado == 1)
        {
          $tipodocumento = 1;
        }


        if($nroTotalDocumentos==$nroDocumentosValidados)
        {
          $data = array(
        'idestadovalidacion'=>3,
            'fechavalidacionbien'=>$fecha,
            'fecvalidado'=>$fecha,
            'idestadodocumentacion'=>$tipodocumento
        );
      $this->db->where('id',$idb);
      $this->db->update('nueva_validacion.bien',$data);
        }else{
            $data = array(
        'idestadovalidacion'=>5,
            'idestadodocumentacion'=>$tipodocumento
        );
      $this->db->where('id',$idb);
      $consulta2 = $this->db->update('nueva_validacion.bien',$data);
    }
    return $idDocumento;
    }


    function validocin($idBien)
    {
       $query = $this->db->query("select (select count(*) from nueva_validacion.documentobien where idbien=".$idBien." and eliminado=false) as total, (select count(*) from nueva_validacion.documentobien where idbien=".$idBien." and eliminado=false and validado=true) as validados");
    return $query->result();
    }
//VEHICULOS
    function validarDocumentoVehiculo($idDocumento,$idBien,$fecha,$tipodocumento,$idb){
        $data = array(
      'validado'=>true,
          'fechavalidaciondoc'=>$fecha,
          'fecvalidado'=>$fecha,
          'gestion_validacion'=>2017,
      );
    $this->db->where('id',$idDocumento);
    $filas = $this->db->update('nueva_validacion.documentobien',$data);
        $query = $this->db->query("select (select count(*) from nueva_validacion.documentobien where idb=".$idb." and eliminado=false and docmodificado = 'f') as total, (select count(*) from nueva_validacion.documentobien where idb=".$idb." and eliminado=false and validado=true and docmodificado = 'f' ) as validados"); 
        $filas2 = $query->result();
        $nroTotalDocumentos=$filas2[0]->total;
        $nroDocumentosValidados=$filas2[0]->validados;

        $estadodoc = $this->db->query("select *from nueva_validacion.bien where id=".$idb);
        $respuesta = $estadodoc->result();

        $estado = $respuesta[0]->idestadodocumentacion;
        if($estado == 1)
        {
          $tipodocumento = 1;
        }

        if($nroTotalDocumentos==$nroDocumentosValidados){
          $data = array(
        'idestadovalidacion'=>3,
            'fechavalidacionbien'=>$fecha,
            'idestadodocumentacion'=>$tipodocumento,
            'fecvalidado'=>$fecha 
        );
      $this->db->where('id',$idb);
      $this->db->update('nueva_validacion.bien',$data);
        }else{
            $data = array(
        'idestadovalidacion'=>5,
            'idestadodocumentacion'=>$tipodocumento
        );
      $this->db->where('id',$idb);
      $consulta2 = $this->db->update('nueva_validacion.bien',$data);
    }
    return $idDocumento;
     }
    //VEHICULOS
    function validarDocumentoalquilerinmueble($idDocumento,$idBien,$fecha,$tipodocumento,$idb)
    {
      $data = array(
      'validado'=>true,
          'fechavalidaciondoc'=>$fecha,
          'fecvalidado'=>$fecha,
          'gestion_validacion'=>2017,
      ); 
    $this->db->where('id',$idDocumento);
    $filas = $this->db->update('nueva_validacion.documentobienalquiler',$data);
        

        $query = $this->db->query("select (select count(*) from  nueva_validacion.documentobienalquiler where idb=".$idb." and eliminado=false) as total, (select count(*) from nueva_validacion.documentobienalquiler where idb=".$idb." and eliminado=false and validado=true) as validados");
        
        $filas2 = $query->result();
        $nroTotalDocumentos=$filas2[0]->total;
        $nroDocumentosValidados=$filas2[0]->validados;
        $estadodoc = $this->db->query("select *from nueva_validacion.bienalquiler where id=".$idb);
        $respuesta = $estadodoc->result();
    $estado = $respuesta[0]->idestadodocumentacion;
        if($estado == 1)
        {
          $tipodocumento = 1;
        }

        if($nroTotalDocumentos==$nroDocumentosValidados){
          
          $data = array(
        'idestadovalidacion'=>3,
            'fechavalidacionbien'=>$fecha,
            'idestadodocumentacion'=>$tipodocumento ,
            'fecvalidado'=>$fecha 
        );
      $this->db->where('id',$idb);
      $this->db->update('nueva_validacion.bienalquiler',$data);
      }
      else
      {
              $data = array(
          'idestadovalidacion'=>5,
          'idestadodocumentacion'=>$tipodocumento 
              
          );
        $this->db->where('id',$idb);
        $consulta2 = $this->db->update('nueva_validacion.bienalquiler',$data);
        }
    return $nroTotalDocumentos;
        
    }

  function  validarSinDocumento($bien, $tipo,$fecha)
  {
    if($tipo == 5 || $tipo == 7)
    {
           $data = array(
        'idestadovalidacion'=>3,
            'idestadodocumentacion'=>3,
            'fechavalidacionbien' =>$fecha,
            'fecvalidado'=>$fecha

       );
      $this->db->where('id',$bien);
      return  $this->db->update('nueva_validacion.bienalquiler',$data);
    }
    else
    {
      $data = array(
        'idestadovalidacion'=>3,
            'idestadodocumentacion'=>3,
            'fecvalidado'=>$fecha,
            'fechavalidacionbien' =>$fecha
       );
      $this->db->where('id',$bien);
      return  $this->db->update('nueva_validacion.bien',$data);
    }
  }
  function insertar_bitacora($accion,$idusu,$idBien,$iddoc,$idtipodoc,$adicionado,$rubro,$entidad,$numero,$fecha1,$fecha2,$idb)
  {
    
      $data = array(
          'accion' => $accion,  
          'idvalidador'=> $idusu,
          'idbien'=> $idBien,
          'iddocumento'=> $iddoc,
          'idtipodoc'=> $idtipodoc,
          'adicionado'=> $adicionado,
          'fecdoc'=> $fecha1,
          'fechadocumento'=> $fecha2,
          'rubro'=> $rubro,
          'identidad'=>$entidad,
          'nrodoc'=>$numero,
          'idb'=> $idb
        );
      $this->db->insert('nueva_validacion.bitacora',$data); 
    //return $this->db->insert();

  } 
 function getrubrobien($idBien)
  {
    $query = $this->db->query("select * from nueva_validacion.bien where id=".$idBien);
    return $query->result();  
  }
  function getrubrobien2($idBien)
  {
    $query = $this->db->query("select * from nueva_validacion.bienalquiler where id=".$idBien);
    return $query->result();  
  }

  function getdatosbien($id)
  {
    $query = $this->db->query("select  *from nueva_validacion.bien where id=".$id);
      return $query->result();
    
  }
  function getdatosbienalquiler($id)
  {
    $query = $this->db->query("select  *from nueva_validacion.bienalquiler where id=".$id);
      return $query->result();
  }

}

?>