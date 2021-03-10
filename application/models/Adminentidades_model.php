<?php
 
class Adminentidades_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function activarentidades($id)
    {
       $query = $this->db->get_where('nueva_validacion.users_universo', array('id' => $id));
        if ($query->num_rows() > 0) {
            if ($query->row()->estadoentidad == 1) {
                $this->db->update('nueva_validacion.users_universo', array('estadoentidad' => 0), array('id' => $id));
            } else {
                $this->db->update('nueva_validacion.users_universo', array('estadoentidad' => 1), array('id' => $id)); 
            }
        }
    }



    
    public function get($id = 0) {
        $this->db->select('a.id identidad, count(b.identidad) totaldoc,a.nombre entidad,d.descripcion depto,b.idgestion gestion,c.asignado asignado,c.id iduu');
        $this->db->join('nueva_validacion.bien b', 'a.id = b.identidad');
        $this->db->join('nueva_validacion.users_universo c', 'a.id=c.identidad');
        $this->db->join('geografia.departamento d', 'a.departamento=d.id');
        $this->db->where('b.idgestion', GESTION);
        $this->db->where('c.idusuario', $id);
        $this->db->group_by('a.id,b.identidad,d.descripcion,b.idgestion,c.asignado,c.id');
        $this->db->order_by('a.nombre', 'ASC');
        $query = $this->db->get('gobierno.entidades a');
        return $query->result();
    }

    public function buscador($abuscar) {
//        $query = $this->db->query("SELECT a.id identidad, a.nombre entidad,d.id_funcionario idvalidador, d.nombre validador,c.asignado asignado
//                                    FROM gobierno.entidades a
//                                    INNER JOIN dj_dejurbe.declaraciones b ON a.id = b.identidad
//                                    LEFT JOIN nueva_validacion.users_universo c ON a.id=c.identidad
//                                    LEFT JOIN nueva_validacion.usuario d ON c.idusuario=d.id_funcionario
//                                    WHERE a.nombre ILIKE '%" . $abuscar . "%'
//                                    AND b.idgestion=" . GESTION . "
//                                    AND b.idestado_declaracion=3
//                                    LIMIT 5");
        $query = $this->db->query("SELECT a.id identidad, a.nombre entidad,c.id_funcionario idvalidador, c.nombre validador,b.asignado asignado
                                    FROM nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di a
                                    LEFT JOIN nueva_validacion.users_universo b ON a.id=b.identidad AND b.asignado=true
                                    LEFT JOIN nueva_validacion.usuario c ON b.idusuario=c.id_funcionario
                                    WHERE a.nombre ILIKE '%" . $abuscar . "%'
                                    LIMIT 5");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getAsignado($identidad) {
        $this->db->where('identidad', $identidad);
        $this->db->where('asignado', true);
        $query = $this->db->get('nueva_validacion.users_universo');
        return $query->row();
    }

    function registrar($data) {
        $this->db->insert('nueva_validacion.users_universo', $data);
    }
    public function getNombreValidador($idFuncionario){
        $query= $this->db->query("select upper(nombre) as nombre from nueva_validacion.usuario where id_funcionario = ".$idFuncionario);
        return $query->row();
    }
    public function getNombreEntidad($idEntidad){
        $query= $this->db->query("select upper(E.nombre) nombre
            from gobierno.entidades E
            where id = ".$idEntidad);
        return $query->row();
    }
    public function reporteBienesxFecha($idFuncionario,$fecha){
        //$datos = array();
        $query = $this->db->query("SELECT  a.id,nombre,totalbienes,totaldocumentos,case when e.bienesvalidados is null then 0 else e.bienesvalidados end as bienesvalidados,
case when docsvalidados is null then 0 else docsvalidados end as docsvalidados,
case when docsadicionados is null then 0 else docsadicionados end as docsadicionados
FROM nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di a
LEFT JOIN(
select identidad, sum(cantidadbienesval) as bienesvalidados
FROM (
select identidad,count(*) as cantidadbienesval
from nueva_validacion.bien 
where idestadovalidacion = 3 and fechavalidacionbien::date = '".$fecha."' 
group by identidad 
UNION ALL
select identidad,count(*) as cantidadbienesval
from nueva_validacion.bienalquiler 
where idestadovalidacion = 3 and fechavalidacionbien::date = '".$fecha."'
group by identidad ) as e group by identidad
) as e on e.identidad = a.id
LEFT JOIN (
select identidad,sum(cantidadvalidados) as docsvalidados FROM
(
select identidad,count(*) as cantidadvalidados
from nueva_validacion.documentobien a
join nueva_validacion.bien b on b.idbien = a.idbien
where validado is true and eliminado is false and fechavalidaciondoc::date = '".$fecha."' 
group by identidad
UNION ALL
select identidad,count(*) as cantidadvalidados
from nueva_validacion.documentobienalquiler a
join nueva_validacion.bienalquiler b on b.idbien = a.idbien
where validado is true  and eliminado is false and fechavalidaciondoc::date = '".$fecha."'
group by identidad) as d group by identidad) as d on d.identidad = a.id
LEFT JOIN (
select identidad, sum(cantidadadicionados) as docsadicionados FROM
(
select identidad,count(*) as cantidadadicionados
from nueva_validacion.documentobien a
join nueva_validacion.bien b on a.idbien = b.idbien
where adicionado is true and idfuncionario is not null
 and validado is true and eliminado is false and fechavalidaciondoc::date = '".$fecha."'  
 group by identidad
UNION ALL
select identidad,count(*) as cantidadadicionados
from nueva_validacion.documentobienalquiler a
join nueva_validacion.bienalquiler b on a.idbien = b.idbien
where adicionado is true and idfuncionario is not null
and validado is true and eliminado is false and fechavalidaciondoc::date = '".$fecha."' 
group by identidad
) as c group by identidad) as c on c.identidad = a.id
JOIN nueva_validacion.users_universo uu on uu.identidad = a.id
where uu.idusuario = $idFuncionario
order by id
");
        return $query->result();
    } 
    public function reportedetalladodocumentos($inicio,$fin,$idfuncionario)//2018
    {
        $query = $this->db->query("select us.nombre as validador,e.nombre as entidad,c.descripcion as rubro,b.idbien,b.iddocumento,dd.descripcion as documento,b.nrodoc as nrodocumento,case when b.adicionado = 't' then 'SI' else 'NO' end as adicionado,
            case when b.accion = 1 then 'Nuevo' else 'Modificación' end as accion,
            b.fecdoc as fecdoc,b.fechadocumento
            from nueva_validacion.v_bitacora3 b
            join dj_activos.clase c on c.id = b.rubro
            join nueva_validacion.usuario us on us.id_funcionario = b.idvalidador 
            left join dj_documento.documento dd on dd.id =b.idtipodoc
            join gobierno.entidades e on e.id = b.identidad
            where b.fecdoc::date between '".$inicio."' and '".$fin."' and b.idvalidador =".$idfuncionario."  order by  b.fechadocumento asc");
            return $query->result();
    }//2018 CAMBIO validacionxgestioninmueble POR v_validxgestinmueble por que en tabla hay datos repetidos
    public function reporteDetalleValidacionInmueble($idEntidad){
        $query = $this->db->query("select b.id,b.idbien,d.id as iddoc, td.descripcion,d.idtipodocumento,
          case when gi.adjunta = 't' then 'SI' else 'NO' end as adjunta,
          case when gi.idcorrespondencia = 1 then 'NO' else 'SI' end as idcorrespondencia,
          case when gi.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
          cs.descripcion as csuperficie, 
          cc.descripcion as ccatastro,
          cde.descripcion as cdenominacion,
          cdi.descripcion as cdireccion,
          gi.observacionesgeneral, 'SI' as documentacion, t1.observaciones,gi.id,
          d.fecvalidado
          from nueva_validacion.bien b
          join nueva_validacion.documentobien d on d.idb = b.id
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_validxgestinmueble gi on d.id = gi.iddocumentobien
          left join nueva_validacion.detallevalidacioninmueble dv on gi.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd on cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cs on cs.id = dv.correctosupterreno
          left join nueva_validacion.correspondencia cc on cc.id = dv.correctocatastro
          left join nueva_validacion.correspondencia cde on cde.id = dv.correctodenominacion
          left join nueva_validacion.correspondencia cdi on cdi.id = dv.correctodireccion
          left join (select o.idvalidacion,array_to_string(array_agg(o.idtipoobservacion),'|') as observaciones from nueva_validacion.v_validxgestinmueble v
          join nueva_validacion.observacioninmueble o on v.id = o.idvalidacion where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gi.id
          where b.idclase in (1,2)
          and d.validado = 't'
          and d.eliminado = 'f' and b.idestadovalidacion = 3 and gi.idtipovalidacion !=3 
          and b.identidad = ".$idEntidad." order by b.idbien asc "); //d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
    function reporteDetalleValidacionInmueblesindoc($idEntidad)
    {
      # code...
         $query = $this->db->query("select b.idbien,fecvalidado from nueva_validacion.bien  b where b.identidad = ".$idEntidad." and b.idclase in (1,2)and b.idestadodocumentacion in (3) and idestadovalidacion = 3  order by b.idbien asc ");
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
     public function reporteDetalleValidacionInmueble2($idEntidad,$fechaI,$fechaF){
        $query = $this->db->query("select b.id,b.idbien,d.id as iddoc, td.descripcion,d.idtipodocumento,
          case when gi.adjunta = 't' then 'SI' else 'NO' end as adjunta,
          case when gi.idcorrespondencia = 1 then 'NO' else 'SI' end as idcorrespondencia,
          case when gi.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
          cs.descripcion as csuperficie,
          cc.descripcion as ccatastro,
          cde.descripcion as cdenominacion,
          cdi.descripcion as cdireccion,
          gi.observacionesgeneral, 'SI' as documentacion, t1.observaciones,gi.id,
          d.fecvalidado
          from nueva_validacion.bien b
          join nueva_validacion.documentobien d on d.idb = b.id
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.validacionxgestioninmueble gi on d.id = gi.iddocumentobien
          left join nueva_validacion.detallevalidacioninmueble dv on gi.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd on cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cs on cs.id = dv.correctosupterreno
          left join nueva_validacion.correspondencia cc on cc.id = dv.correctocatastro
          left join nueva_validacion.correspondencia cde on cde.id = dv.correctodenominacion
          left join nueva_validacion.correspondencia cdi on cdi.id = dv.correctodireccion
          left join (select o.idvalidacion,array_to_string(array_agg(o.idtipoobservacion),'|') as observaciones from nueva_validacion.validacionxgestioninmueble v
          join nueva_validacion.observacioninmueble o on v.id = o.idvalidacion where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gi.id
          where b.idclase in (1,2)
          and d.validado = 't' and b.idestadovalidacion = 3
          and d.eliminado = 'f'
          and b.identidad = ".$idEntidad." order by d.fecvalidado asc ");
        return $query->result();
    }
    //2018 cambio llamada a tabla de validacionxgestionvehiculo por v_valxgestvehiculo por que en tabla hay datos repetidos
    public function reporteDetalleValidacionVehiculo($idEntidad){
        $query = $this->db->query("select b.id,b.idbien,d.id as iddoc, td.descripcion,d.idtipodocumento,
          case when gv.adjunta = 't' then 'SI' else 'NO' end as adjunta,
          case when gv.idcorrespondencia = 1 then 'SI' else 'NO' end as idcorrespondencia,
          case when gv.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
          cm.descripcion as cmarca,
          cv.descripcion as cclase,
          ccl.descripcion as ctipo,
          cp.descripcion as cplaca,
          cmt.descripcion as cmotor,
          cch.descripcion as cchasis,
          cpr.descripcion as cprocedencia,
          cmo.descripcion as cmodelo,
          col.descripcion as ccolor,
          gv.observacionesgenerales, 'SI' as documentacion , t1.observaciones,gv.id,
          d.fecvalidado
          from nueva_validacion.bien b
          join nueva_validacion.documentobien d on d.idbien = b.idbien
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_valxgestvehiculo gv on d.id = gv.iddocumentobien
          left join nueva_validacion.detallevalidacionvehiculo dv on gv.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd on cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cm on cm.id = dv.correctomarca
          left join nueva_validacion.correspondencia cv on cv.id = dv.correctovehiculo
          left join nueva_validacion.correspondencia ccl on ccl.id = dv.correctoclase
          left join nueva_validacion.correspondencia cp on cp.id = dv.correctoplaca
          left join nueva_validacion.correspondencia cmt on cmt.id = dv.correctomotor
          left join nueva_validacion.correspondencia cch on cch.id = dv.correctochasis
          left join nueva_validacion.correspondencia cpr on cpr.id = dv.correctoprocedencia
          left join nueva_validacion.correspondencia cmo on cmo.id = dv.correctomodelo
          left join nueva_validacion.correspondencia col on col.id = dv.correctocolor
          left join (select o.idvalidacion,array_to_string(array_agg(o.idtipoobservacion),'|') as observaciones from nueva_validacion.v_valxgestvehiculo v
          join nueva_validacion.observacionvehiculo o on v.id = o.idvalidacion where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gv.id
          where b.identidad = ".$idEntidad."
          and b.idclase in (3) and b.idestadovalidacion = 3 and gv.idtipovalidacion !=3 --2019
          and d.validado = 't'
          and d.eliminado = 'f'
          order by b.idbien asc "); //2018 d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
     function reporteDetalleValidacionVehiculosindoc($idEntidad)
    {
      # code...
         $query = $this->db->query("select b.idbien,fecvalidado from nueva_validacion.bien  b where b.identidad = ".$idEntidad." and b.idclase in (3)and b.idestadodocumentacion in (3) and idestadovalidacion = 3  order by b.idbien asc ");
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
    function reporteDetalleObservaciones($idEntidad)//2019
    {
      
         $query = $this->db->query("select * from nueva_validacion.vista_bienesxtipoobservacion  where id = '".$idEntidad."'");
        return $query->result();
    }


    //2018 CAMBIO validacionxgestionmaquinaria POR v_validxgestmaquinaria por que en tabla hay datos repetidos
    public function reporteDetalleValidacionMaquinariaEq($idEntidad){
        $query = $this->db->query("select b.idbien, d.id as iddoc,td.descripcion,d.idtipodocumento, 
        case when gm.adjunta = 't' then 'SI' else 'NO' end as adjunta,
        case when gm.idcorrespondencia = '1' then 'SI' else 'NO' end as idcorrespondencia,
        case when gm.legible = 't' then 'SI' else 'NO' end as legible,
        case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
        cd.descripcion as cdocumento,
        cde.descripcion as cequipo,
        cm.descripcion as cmarca,
        cml.descripcion as cmodelo,
        csr.descripcion as cserie,
        gm.observacionesgenerales, 'SI' as documentacion,
        t1.observaciones,
        d.fecvalidado
        from nueva_validacion.bien b
        join nueva_validacion.documentobien d on d.idbien = b.idbien
        left join dj_documento.documento td on td.id = d.idtipodocumento
        join nueva_validacion.v_validxgestmaquinaria gm on d.id = gm.iddocumentobien
        left join nueva_validacion.detallevalidacionmaquinaria dv on gm.id = dv.idvalidacion
        left join nueva_validacion.correspondencia cd on cd.id = dv.correctodocumento
        left join nueva_validacion.correspondencia cde on cde.id = dv.correctodescripcion
        left join nueva_validacion.correspondencia cm on cm.id = dv.correctomarca
        left join nueva_validacion.correspondencia cml on cml.id = dv.correctomodelo
        left join nueva_validacion.correspondencia csr on csr.id = dv.correctonroserie
        left join (select o.idvalidacion,array_to_string(array_agg(o.idtipoobservacion),'|') as observaciones from nueva_validacion.v_validxgestmaquinaria v
        join nueva_validacion.observacionmaquinaria o on v.id = o.idvalidacion where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gm.id
        where b.idclase in (4)
        
        and d.validado = 't'
        and d.eliminado = 'f' and b.idestadovalidacion = 3
        and b.identidad = ".$idEntidad." 
        order by b.idbien asc "); //d.fecvalidado 2018

        //and d.fecvalidado::date between '".$fechaI."'and '".$fechaF."'
        return $query->result();
    }
     function reporteDetalleValidacionMaquinariaEqsindoc($idEntidad)
    {
      # code...
         $query = $this->db->query("select b.idbien,fecvalidado from nueva_validacion.bien  b where b.identidad = ".$idEntidad." and b.idclase in (4)and b.idestadodocumentacion in (3) and idestadovalidacion = 3  order by b.idbien asc ");
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
    //2018 CAMBIO validacionxgestionmaquinariapesada POR v_validxgestmaquinariapesada por que en tabla hay datos repetidos
    public function reporteDetalleValidacionMaquinariaPe($idEntidad){
        $query = $this->db->query("select b.id,b.idbien,d.id iddoc ,td.descripcion,d.idtipodocumento, case when gmp.adjunta = 't' then 'SI' else 'NO' end as adjunta, case when gmp.idcorrespondencia = '0' then 'SI' else 'NO' end as idcorrespondencia, case when gmp.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
          cde.descripcion as cdescripcion,
          cm.descripcion as cmarca,
          cml.descripcion as cmodelo,
          cch.descripcion as cchasis,
          cmt.descripcion as cmotor,
          ccl.descripcion as ccolor,
          gmp.observacionesgenerales, 'SI' as documentacion, t1.observaciones,d.fecvalidado
          from nueva_validacion.bien b
          join nueva_validacion.documentobien d on d.idbien = b.idbien
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_validxgestmaquinariapesada gmp on d.id = gmp.iddocumentobien
          left join nueva_validacion.detallevalidacionmaquinariapesada dv on gmp.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd ON cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cde ON cde.id = dv.correctodescripcion
          left join nueva_validacion.correspondencia cm ON cm.id = dv.correctomarca
          left join nueva_validacion.correspondencia cml ON cml.id = dv.correctomodelo
          left join nueva_validacion.correspondencia cch ON cch.id = dv.correctonrochasis
          left join nueva_validacion.correspondencia cmt ON cmt.id = dv.correctonromotor
          left join nueva_validacion.correspondencia ccl ON ccl.id = dv.correctocolor
          left join (select o.idvalidacion,array_to_string(array_agg(o.idtipoobservacion),'|') as observaciones from nueva_validacion.v_validxgestmaquinariapesada v
          join nueva_validacion.observacionmaquinariapesada o on v.id = o.idvalidacion where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gmp.id
          where b.idclase in (6)
          and d.validado = 't'
          and d.eliminado = 'f' and b.idestadovalidacion = 3
          and b.identidad = ".$idEntidad."
          
          order by b.idbien asc"); //2018 d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."'and '".$fechaF."'
        return $query->result();
    }
     function reporteDetalleValidacionMaquinariaPesindoc($idEntidad)
    {
      # code...
         $query = $this->db->query("select b.idbien,fecvalidado from nueva_validacion.bien  b where b.identidad = ".$idEntidad." and b.idclase in (6)and b.idestadodocumentacion in (3) and idestadovalidacion = 3  order by b.idbien asc ");
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
    //2018 cambio validacionxgestioninmueblealquiler por v_validxgestinmueblealquiler por que en tabla hay datos repetidos
    public function reporteDetalleValidacionInmuebleAlquiler($idEntidad){
        $query = $this->db->query("select b.id,b.idbien,d.id as iddoc, td.descripcion,d.idtipodocumento, 
          case when gi.adjunta = 't' then 'SI' else 'NO' end as adjunta,
          case when gi.idcorrespondencia = '0' then 'SI' else 'NO' end as idcorrespondencia,
          case when gi.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
          cde.descripcion as cdepartamento,
          cdi.descripcion as cdireccion,
          cic.descripcion as ciniciocontrato,
          cfc.descripcion as cfincontrato,
          cca.descripcion as ccanonalquiler,
          gi.observacionesgenerales, 'SI' as documentacion, t1.observaciones,d.fecvalidado
          from nueva_validacion.bienalquiler b
          join nueva_validacion.documentobienalquiler d on d.idbien = b.idbien
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_validxgestinmueblealquiler gi on d.id = gi.iddocumentobien
          left join nueva_validacion.detallevalidacioninmueblealquiler dv on gi.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd ON cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cde ON cde.id = dv.correctodepartamento
          left join nueva_validacion.correspondencia cz ON cz.id = dv.correctozona
          left join nueva_validacion.correspondencia cdi ON cdi.id = dv.correctodireccion
          left join nueva_validacion.correspondencia cic ON cic.id = dv.correctoiniciocontrato
          left join nueva_validacion.correspondencia cfc ON cfc.id = dv.correctofincontrato
          left join nueva_validacion.correspondencia cca ON cca.id = dv.correctocanonalquiler
          left join (select o.idvalidacion,array_to_string(array_agg(o.idtipoobservacion),'|') as observaciones from nueva_validacion.v_validxgestinmueblealquiler v
          join nueva_validacion.observacioninmueblealquiler o on v.id = o.idvalidacion where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gi.id
          where b.idclase in (5)
          and d.validado = 't'
          and d.eliminado = 'f'
          and b.idestadovalidacion = 3
          and b.identidad = ".$idEntidad."
          
          order by b.idbien asc ");//2018 d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
      function reporteDetalleValidacionInmuebleAlquilersindoc($idEntidad)
    {
      # code...
         $query = $this->db->query("select b.idbien,fecvalidado from nueva_validacion.bienalquiler  b where b.identidad = ".$idEntidad." and b.idclase in (5)and b.idestadodocumentacion in (3) and idestadovalidacion = 3  order by b.idbien asc ");
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
    //2018 cambio validacionxgestionvehiculoalquiler por v_validxgestvehiculoalquiler por que en tabla hay datos repetidos
    public function reporteDetalleValidacionVehiculoalquiler($idEntidad){
        $query = $this->db->query("select b.id,b.idbien,d.id as iddoc, b.idbien, td.descripcion,d.idtipodocumento,
          case when gi.adjunta = 't' then 'SI' else 'NO' end as adjunta,
          case when gi.idcorrespondencia = 1 then 'SI' else 'NO' end as idcorrespondencia,
          case when gi.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
          cde.descripcion as cdepartamento,
          cdi.descripcion as cdireccion,
          cic.descripcion as ciniciocontrato,
          cfc.descripcion as cfincontrato,
          cca.descripcion as ccanonalquiler,
          gi.observacionesgenerales, 'SI' as documentacion,t1.observaciones ,d.fecvalidado
          from nueva_validacion.bienalquiler b
          join nueva_validacion.documentobienalquiler d on d.idb = b.id
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_validxgestvehiculoalquiler gi on d.id = gi.iddocumentobien
          left join nueva_validacion.detallevalidacionvehiculoalquiler dv on gi.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd ON cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cde ON cde.id = dv.correctodepartamento
          left join nueva_validacion.correspondencia cdi ON cdi.id = dv.correctodireccion
          left join nueva_validacion.correspondencia cic ON cic.id = dv.correctoiniciocontrato
          left join nueva_validacion.correspondencia cfc ON cfc.id = dv.correctofincontrato
          left join nueva_validacion.correspondencia cca ON cca.id = dv.correctocanonalquiler
          left join (select o.idvalidacion,array_to_string(array_agg(o.idtipoobservacion),'|') as observaciones from nueva_validacion.v_validxgestvehiculoalquiler v
          join nueva_validacion.observacionvehiculoalquiler o on v.id = o.idvalidacion where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gi.id
          where b.idclase in (7) and d.validado = 't' and d.eliminado = 'f' and b.idestadovalidacion = 3
          and b.identidad = ".$idEntidad." 
          
          order by b.idbien asc "); //2018 d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."'and '".$fechaF."'
        return $query->result();
    }
     function reporteDetalleValidacionVehiculoalquilersindoc($idEntidad)
    {
      # code...
         $query = $this->db->query("select b.idbien,fecvalidado from nueva_validacion.bienalquiler  b where b.identidad = ".$idEntidad." and b.idclase in (7)and b.idestadodocumentacion in (3) and idestadovalidacion = 3 order by b.idbien asc ");
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }

    function getComboObservaciones($rubro)
    {
      $query = $this->db->query ("select id,descripcion from nueva_validacion.tipoobservacion where idrubro=".$rubro."order by id asc");
      return $query->result();
    }
       /***********************************************2020**********************************/ 
/* para los remitir reortes a la entidades 2020 */
    public function reporteDetalleValidacionInmuebleobservaciones($idEntidad){
        $query = $this->db->query("select b.id,b.idbien,td.descripcion,d.idtipodocumento,
          case when gi.adjunta = 't' then 'SI' else 'NO' end as adjunta,
          case when gi.idcorrespondencia = 1 then 'NO' else 'SI' end as idcorrespondencia,
          case when gi.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
          cs.descripcion as csuperficie, 
          cc.descripcion as ccatastro,
          cde.descripcion as cdenominacion,
          cdi.descripcion as cdireccion,
          case 
           WHEN length (gi.observacionesgeneral) >0  and length (t1.observaciones) >0  then 
              concat(t1.observaciones,E'\n -',gi.observacionesgeneral)
           WHEN length (gi.observacionesgeneral) > 0 then 
              concat(' - ',gi.observacionesgeneral)       
          else 
             t1.observaciones
          end as observaciones
          --coalesce (t1.observaciones,'A') as observaciones 
          from nueva_validacion.bien b
          join nueva_validacion.documentobien d on d.idb = b.id
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_validxgestinmueble gi on d.id = gi.iddocumentobien
          left join nueva_validacion.detallevalidacioninmueble dv on gi.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd on cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cs on cs.id = dv.correctosupterreno
          left join nueva_validacion.correspondencia cc on cc.id = dv.correctocatastro
          left join nueva_validacion.correspondencia cde on cde.id = dv.correctodenominacion
          left join nueva_validacion.correspondencia cdi on cdi.id = dv.correctodireccion
          left join (select o.idvalidacion,concat(' - ',(array_to_string(array_agg(p.descripcion),E'\n -'))) as observaciones from nueva_validacion.v_validxgestinmueble v
          join nueva_validacion.observacioninmueble o on v.id = o.idvalidacion 
          left  join nueva_validacion.tipoobservacion p on p.id= o.idtipoobservacion

           where 1=1 and o.idtipoobservacion !=74 group by o.idvalidacion) as t1 on t1.idvalidacion=gi.id
          where b.idclase in (1,2) and ( length (observaciones) > 0 or length (observacionesgeneral) > 0)
          and d.validado = 't'
          and d.eliminado = 'f' and b.idestadovalidacion = 3 and gi.idtipovalidacion !=3  
          and b.identidad = ".$idEntidad." order by b.idbien asc "); //d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
        public function reporteDetalleValidacionVehiculoobservacion($idEntidad){
        $query = $this->db->query("select b.id,b.idbien, td.descripcion,
          case when gv.adjunta = 't' then 'SI' else 'NO' end as adjunta,
          case when gv.idcorrespondencia = 1 then 'SI' else 'NO' end as idcorrespondencia,
          case when gv.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
          cm.descripcion as cmarca,
          cv.descripcion as cclase,
          ccl.descripcion as ctipo,
          cp.descripcion as cplaca,
          cmt.descripcion as cmotor,
          cch.descripcion as cchasis,
          cpr.descripcion as cprocedencia,
          cmo.descripcion as cmodelo,
          col.descripcion as ccolor,
          case 
          WHEN length (gv.observacionesgenerales) >0  and length (t1.observaciones) >0  then 
               concat(t1.observaciones,E'\n -',gv.observacionesgenerales)
          WHEN length (gv.observacionesgenerales) > 0 then 
               concat(' - ',gv.observacionesgenerales)       
          else 
               t1.observaciones
          end as observaciones
          from nueva_validacion.bien b
          join nueva_validacion.documentobien d on d.idbien = b.idbien
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_valxgestvehiculo gv on d.id = gv.iddocumentobien
          left join nueva_validacion.detallevalidacionvehiculo dv on gv.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd on cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cm on cm.id = dv.correctomarca
          left join nueva_validacion.correspondencia cv on cv.id = dv.correctovehiculo
          left join nueva_validacion.correspondencia ccl on ccl.id = dv.correctoclase
          left join nueva_validacion.correspondencia cp on cp.id = dv.correctoplaca
          left join nueva_validacion.correspondencia cmt on cmt.id = dv.correctomotor
          left join nueva_validacion.correspondencia cch on cch.id = dv.correctochasis
          left join nueva_validacion.correspondencia cpr on cpr.id = dv.correctoprocedencia
          left join nueva_validacion.correspondencia cmo on cmo.id = dv.correctomodelo
          left join nueva_validacion.correspondencia col on col.id = dv.correctocolor
          left join (select o.idvalidacion,concat(' - ',(array_to_string(array_agg(p.descripcion),E'\n -'))) as observaciones from nueva_validacion.v_valxgestvehiculo v
          join nueva_validacion.observacionvehiculo o on v.id = o.idvalidacion
          left  join nueva_validacion.tipoobservacion p on p.id= o.idtipoobservacion
           where 1=1 and o.idtipoobservacion !=75 group by o.idvalidacion ) as t1 on t1.idvalidacion=gv.id
          where b.identidad = ".$idEntidad." and ( length (observaciones) > 0 or length (observacionesgenerales) > 0)
          and b.idclase in (3) and b.idestadovalidacion = 3 and gv.idtipovalidacion !=3 --2019
          and d.validado = 't'
          and d.eliminado = 'f'
          order by b.idbien asc"); //2018 d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
   public function reporteDetalleValidacionMaquinariaEqobservacion($idEntidad){
        $query = $this->db->query("select b.idbien, d.id as iddoc,td.descripcion,d.idtipodocumento, 
        case when gm.adjunta = 't' then 'SI' else 'NO' end as adjunta,
        case when gm.idcorrespondencia = '1' then 'SI' else 'NO' end as idcorrespondencia,
        case when gm.legible = 't' then 'SI' else 'NO' end as legible,
        case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
        cd.descripcion as cdocumento,
        cde.descripcion as cequipo,
        cm.descripcion as cmarca,
        cml.descripcion as cmodelo,
        csr.descripcion as cserie,
        case 
        WHEN length (gm.observacionesgenerales) >0  and length (t1.observaciones) >0  then 
           concat(t1.observaciones,E'\n -',gm.observacionesgenerales)
        WHEN length (gm.observacionesgenerales) > 0 then 
           concat(' - ',gm.observacionesgenerales)       
        else 
          t1.observaciones
        end as observaciones
        from nueva_validacion.bien b
        join nueva_validacion.documentobien d on d.idbien = b.idbien
        left join dj_documento.documento td on td.id = d.idtipodocumento
        join nueva_validacion.v_validxgestmaquinaria gm on d.id = gm.iddocumentobien
        left join nueva_validacion.detallevalidacionmaquinaria dv on gm.id = dv.idvalidacion
        left join nueva_validacion.correspondencia cd on cd.id = dv.correctodocumento
        left join nueva_validacion.correspondencia cde on cde.id = dv.correctodescripcion
        left join nueva_validacion.correspondencia cm on cm.id = dv.correctomarca
        left join nueva_validacion.correspondencia cml on cml.id = dv.correctomodelo
        left join nueva_validacion.correspondencia csr on csr.id = dv.correctonroserie
        left join (select o.idvalidacion,concat(' - ',(array_to_string(array_agg(p.descripcion),E'\n -'))) as observaciones from nueva_validacion.v_validxgestmaquinaria v
        join nueva_validacion.observacionmaquinaria o on v.id = o.idvalidacion 
        left  join nueva_validacion.tipoobservacion p on p.id= o.idtipoobservacion
        where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gm.id
        where b.idclase in (4)  and ( length (observaciones) > 0 or length (observacionesgenerales) > 0)
        and d.validado = 't'
        and d.eliminado = 'f' and b.idestadovalidacion = 3   --2019
        and b.identidad = ".$idEntidad." 
        order by b.idbien asc "); //d.fecvalidado 2018

        //and d.fecvalidado::date between '".$fechaI."'and '".$fechaF."'
        return $query->result();
    }
    public function reporteDetalleValidacionMaquinariaPeobservacion($idEntidad){
        $query = $this->db->query("select b.id,b.idbien,td.descripcion, case when gmp.adjunta = 't' then 'SI' else 'NO' end as adjunta, case when gmp.idcorrespondencia = '0' then 'SI' else 'NO' end as idcorrespondencia, case when gmp.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
           cch.descripcion as cchasis,
         case 
         WHEN length (gmp.observacionesgenerales) >0  and length (t1.observaciones) >0  then 
              concat(t1.observaciones,E'\n -',gmp.observacionesgenerales)
         WHEN length (gmp.observacionesgenerales) > 0 then 
               concat(' - ',gmp.observacionesgenerales)      
         else 
      t1.observaciones
      end as observacionesgenerales
          from nueva_validacion.bien b
          join nueva_validacion.documentobien d on d.idbien = b.idbien
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_validxgestmaquinariapesada gmp on d.id = gmp.iddocumentobien
          left join nueva_validacion.detallevalidacionmaquinariapesada dv on gmp.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd ON cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cde ON cde.id = dv.correctodescripcion
          left join nueva_validacion.correspondencia cm ON cm.id = dv.correctomarca
          left join nueva_validacion.correspondencia cml ON cml.id = dv.correctomodelo
          left join nueva_validacion.correspondencia cch ON cch.id = dv.correctonrochasis
          left join nueva_validacion.correspondencia cmt ON cmt.id = dv.correctonromotor
          left join nueva_validacion.correspondencia ccl ON ccl.id = dv.correctocolor
          left join (select o.idvalidacion,concat(' - ',(array_to_string(array_agg(p.descripcion),E'\n -'))) as observaciones from nueva_validacion.v_validxgestmaquinariapesada v
          join nueva_validacion.observacionmaquinariapesada o on v.id = o.idvalidacion
          left  join nueva_validacion.tipoobservacion p on p.id= o.idtipoobservacion
          where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gmp.id
          where b.idclase in (6) and ( length (observaciones) > 0 or length (observacionesgenerales) > 0)
          and d.validado = 't'
          and d.eliminado = 'f' and b.idestadovalidacion = 3
          and b.identidad = ".$idEntidad."
          
          order by b.idbien asc"); //2018 d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."'and '".$fechaF."'
        return $query->result();
    }
     
     public function reporteDetalleValidacionInmuebleAlquilerobservacion($idEntidad){
        $query = $this->db->query("select b.id,b.idbien,td.descripcion,d.idtipodocumento, 
          case when gi.adjunta = 't' then 'SI' else 'NO' end as adjunta,
          case when gi.idcorrespondencia = '0' then 'SI' else 'NO' end as idcorrespondencia,
          case when gi.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
          cde.descripcion as cdepartamento,
          cdi.descripcion as cdireccion,
          cic.descripcion as ciniciocontrato,
          cfc.descripcion as cfincontrato,
          cca.descripcion as ccanonalquiler,
           case 
           WHEN length (gi.observacionesgenerales) >0  and length (t1.observaciones) >0  then 
                concat(t1.observaciones,E'\n -',gi.observacionesgenerales)
           WHEN length (gi.observacionesgenerales) > 0 then 
                 concat(' - ',gi.observacionesgenerales)      
           else 
           t1.observaciones
           end as observacionesgenerales
          from nueva_validacion.bienalquiler b
          join nueva_validacion.documentobienalquiler d on d.idbien = b.idbien
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_validxgestinmueblealquiler gi on d.id = gi.iddocumentobien
          left join nueva_validacion.detallevalidacioninmueblealquiler dv on gi.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd ON cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cde ON cde.id = dv.correctodepartamento
          left join nueva_validacion.correspondencia cz ON cz.id = dv.correctozona
          left join nueva_validacion.correspondencia cdi ON cdi.id = dv.correctodireccion
          left join nueva_validacion.correspondencia cic ON cic.id = dv.correctoiniciocontrato
          left join nueva_validacion.correspondencia cfc ON cfc.id = dv.correctofincontrato
          left join nueva_validacion.correspondencia cca ON cca.id = dv.correctocanonalquiler
          left join (select o.idvalidacion,concat(' - ',(array_to_string(array_agg(p.descripcion),E'\n -'))) as observaciones from nueva_validacion.v_validxgestinmueblealquiler v
          join nueva_validacion.observacioninmueblealquiler o on v.id = o.idvalidacion 
          left  join nueva_validacion.tipoobservacion p on p.id= o.idtipoobservacion
          where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gi.id
          where b.idclase in (5)  and ( length (observaciones) > 0 or length (observacionesgenerales) > 0)
          and d.validado = 't'
          and d.eliminado = 'f'
          and b.idestadovalidacion = 3
          and b.identidad =  ".$idEntidad."
          order by b.idbien asc ");//2018 d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    
   }
   public function reporteDetalleValidacionVehiculoalquilerobservacion($idEntidad){
        $query = $this->db->query("select b.id,b.idbien, b.idbien, td.descripcion,d.idtipodocumento,
          case when gi.adjunta = 't' then 'SI' else 'NO' end as adjunta,
          case when gi.idcorrespondencia = 1 then 'SI' else 'NO' end as idcorrespondencia,
          case when gi.legible = 't' then 'SI' else 'NO' end as legible,
          case when d.adicionado = 't' then 'SI' else 'NO' end as adicionado,
          cd.descripcion as cdocumento,
          cde.descripcion as cdepartamento,
          cdi.descripcion as cdireccion,
          cic.descripcion as ciniciocontrato,
          cfc.descripcion as cfincontrato,
          cca.descripcion as ccanonalquiler,
          case 
           WHEN length (gi.observacionesgenerales) >0  and length (t1.observaciones) >0  then 
                concat(t1.observaciones,E'\n -',gi.observacionesgenerales)
           WHEN length (gi.observacionesgenerales) > 0 then 
                 concat(' - ',gi.observacionesgenerales)      
           else 
           t1.observaciones
          end as observacionesgenerales
          from nueva_validacion.bienalquiler b
          join nueva_validacion.documentobienalquiler d on d.idb = b.id
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_validxgestvehiculoalquiler gi on d.id = gi.iddocumentobien
          left join nueva_validacion.detallevalidacionvehiculoalquiler dv on gi.id = dv.idvalidacion
          left join nueva_validacion.correspondencia cd ON cd.id = dv.correctodocumento
          left join nueva_validacion.correspondencia cde ON cde.id = dv.correctodepartamento
          left join nueva_validacion.correspondencia cdi ON cdi.id = dv.correctodireccion
          left join nueva_validacion.correspondencia cic ON cic.id = dv.correctoiniciocontrato
          left join nueva_validacion.correspondencia cfc ON cfc.id = dv.correctofincontrato
          left join nueva_validacion.correspondencia cca ON cca.id = dv.correctocanonalquiler
          left join (select o.idvalidacion,concat(' - ',(array_to_string(array_agg(p.descripcion),E'\n -'))) as observaciones from nueva_validacion.v_validxgestvehiculoalquiler v
          join nueva_validacion.observacionvehiculoalquiler o on v.id = o.idvalidacion
          left  join nueva_validacion.tipoobservacion p on p.id= o.idtipoobservacion
          where 1=1 group by o.idvalidacion) as t1 on t1.idvalidacion=gi.id
          where b.idclase in (7) and ( length (observaciones) > 0 or length (observacionesgenerales) > 0)
          and d.validado = 't' and d.eliminado = 'f' and b.idestadovalidacion = 3
          and b.identidad = ".$idEntidad." 
          
          order by b.idbien asc "); //2018 d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."'and '".$fechaF."'
        return $query->result();
    } 
     // reporte titularidad//
    public function reportetitularidadInmueble($idEntidad){
      

        $query = $this->db->query("select b.id,b.idbien,td.descripcion,d.idtipodocumento,d.nrodocumento,
          
         
           p.descripcion as tipo
          --coalesce (t1.observaciones,'A') as observaciones 
          from nueva_validacion.bien b
          join nueva_validacion.documentobien d on d.idb = b.id
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.v_validxgestinmueble gi on d.id = gi.iddocumentobien
          left join nueva_validacion.detallevalidacioninmueble dv on gi.id = dv.idvalidacion
          left join nueva_validacion.observacioninmueble ov  on gi.id=ov.idvalidacion
          left  join nueva_validacion.tipoobservacion p on p.id= ov.idtipoobservacion
          where b.idclase in (1,2) and  ov.idtipoobservacion =74
          and d.validado = 't'
          and d.eliminado = 'f' and b.idestadovalidacion = 3 and gi.idtipovalidacion !=3  
          and b.identidad = ".$idEntidad." order by b.idbien asc  "); //d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }

     public function reportetitularidadvevhiculo($idEntidad){
        $query = $this->db->query("select b.id,b.idbien, td.descripcion,d.idtipodocumento,d.nrodocumento,
        
               p.descripcion as tipo
          from nueva_validacion.bien b
          join nueva_validacion.documentobien d on d.idbien = b.idbien
          left join dj_documento.documento td on td.id = d.idtipodocumento
          join nueva_validacion.validacionxgestionvehiculo gv on d.id = gv.iddocumentobien
          left join nueva_validacion.detallevalidacionvehiculo dv on gv.id = dv.idvalidacion
          join nueva_validacion.observacionvehiculo o on o.idvalidacion = gv.id
          left  join nueva_validacion.tipoobservacion p on p.id= o.idtipoobservacion
          
          where b.identidad = ".$idEntidad." and p.id=75
          and b.idclase in (3) and b.idestadovalidacion = 3 and gv.idtipovalidacion !=3 --2019
          and d.validado = 't'
          and d.eliminado = 'f'
          order by b.idbien asc"); //2018 d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
    public function reporteresumenrubros($idEntidad){
        $query = $this->db->query("select z.id as orden, z.descripcion as clase,case when cantidad is null then 0 else cantidad end,
    case when validados is null then 0 else validados end, case when definitivo is null then 0 else definitivo end,
    case when intermedio is null then 0 else intermedio end,case when sindoc is null then 0 else sindoc end, case when nobservado is null then 0 else nobservado end , case when observado is null then 0 else observado end
    from dj_activos.clase z left join
    (
    select a.idclase,b.descripcion as clase, count(a.*) as cantidad
    from nueva_validacion.bien a inner join dj_activos.clase b on a.idclase = b.id
    where  a.habilitado=1
    and a.identidad = ".$idEntidad."
    group by a.idclase, b.descripcion) as c on c.idclase = z.id

    left join
    (
     select a.idclase,b.descripcion as clase, count(a.*) as validados
    from nueva_validacion.bien a inner join dj_activos.clase b on a.idclase = b.id
    where  a.habilitado=1
    and a.identidad = ".$idEntidad." and a.idestadovalidacion=3
    group by a.idclase, b.descripcion) as v on v.idclase = z.id

    left join
    (
    select a.idclase,b.descripcion as clase, count(a.*) as definitivo
      from nueva_validacion.bien a inner join dj_activos.clase b on a.idclase = b.id
      join nueva_validacion.documentobien d on a.idbien=d.idbien
      where  a.habilitado=1
      and a.identidad = ".$idEntidad." and a.idestadovalidacion=3 and idtipodocumento in (1,4)
      group by a.idclase, b.descripcion) as def on def.idclase = z.id

    left join
    (
    select a.idclase,b.descripcion as clase, count(a.*) as intermedio
    from nueva_validacion.bien a inner join dj_activos.clase b on a.idclase = b.id
      join nueva_validacion.documentobien d on a.idbien=d.idbien
      where  a.habilitado=1
      and a.identidad = ".$idEntidad." and a.idestadovalidacion=3 and idtipodocumento not in (1,4)
      group by a.idclase, b.descripcion) as inte on inte.idclase = z.id

    left join
    (
    select a.idclase,b.descripcion as clase, count(a.*) as sindoc
      from nueva_validacion.bien a inner join dj_activos.clase b on a.idclase = b.id
      where  a.idbien not in (select d.idbien from nueva_validacion.documentobien d)  
      and a.identidad = ".$idEntidad." and a.idestadovalidacion=3 and a.habilitado=1
      group by a.idclase, b.descripcion) as sin on sin.idclase = z.id
   
    left join
    (select a.idclase,b.descripcion as clase, count(a.*) as nobservado
    from nueva_validacion.bien a inner join dj_activos.clase b on a.idclase = b.id
    and a.identidad = ".$idEntidad." and a.habilitado=1 and  a.idbien not in  (select idbien from nueva_validacion.vista_bienesxtipoobservacion)
    group by a.idclase, b.descripcion) as ot on ot.idclase = z.id
    left join
    (select a.idclase,b.descripcion as clase, count(a.*) as observado
    from nueva_validacion.bien a inner join dj_activos.clase b on a.idclase = b.id
    and a.identidad = ".$idEntidad." and a.habilitado=1 and  a.idbien in  (select idbien from nueva_validacion.vista_bienesxtipoobservacion)
    group by a.idclase, b.descripcion) as o on o.idclase = z.id
    where z.id not in (5,7)
    order by orden asc 
    "); //2018 d.fecvalidado
            //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }

     public function reporteresumenalquiler($idEntidad){
        $query = $this->db->query("select z.id as orden, z.descripcion as clase,case when cantidad is null then 0 else cantidad end,
      case when validados is null then 0 else validados end,case when definitivo is null then 0 else definitivo end,
      case when intermedio is null then 0 else intermedio end,case when sindoc is null then 0 else sindoc end, case when nobservado is null then 0 else nobservado end , case when observado is null then 0 else observado end
      from dj_activos.clase z left join
      (
      select a.idclase,b.descripcion as clase, count(a.*) as cantidad
      from nueva_validacion.bienalquiler a inner join dj_activos.clase b on a.idclase = b.id
      where  a.habilitado=1
      and a.identidad = ".$idEntidad."
      group by a.idclase, b.descripcion) as c on c.idclase = z.id


      left join
      (
      select a.idclase,b.descripcion as clase, count(a.*) as validados
      from nueva_validacion.bienalquiler a inner join dj_activos.clase b on a.idclase = b.id
      where  a.habilitado=1
      and a.identidad = ".$idEntidad." and a.idestadovalidacion=3
      group by a.idclase, b.descripcion
       ) as v on v.idclase = z.id
      left join
      (
      select a.idclase,b.descripcion as clase, count(a.*) as definitivo
      from nueva_validacion.bienalquiler a inner join dj_activos.clase b on a.idclase = b.id
      join nueva_validacion.documentobienalquiler d on a.idbien=d.idbien
      where  a.habilitado=1
      and a.identidad = ".$idEntidad." and a.idestadovalidacion=3 and idtipodocumento in (23)
      group by a.idclase, b.descripcion) as def on def.idclase = z.id

      left join
      (
      select a.idclase,b.descripcion as clase, count(a.*) as intermedio
      from nueva_validacion.bienalquiler a inner join dj_activos.clase b on a.idclase = b.id
      join nueva_validacion.documentobienalquiler d on a.idbien=d.idbien
      where  a.habilitado=1
      and a.identidad = ".$idEntidad." and a.idestadovalidacion=3 and idtipodocumento not in (23)
      group by a.idclase, b.descripcion) as inte on inte.idclase = z.id

      left join
      (
      select a.idclase,b.descripcion as clase, count(a.*) as sindoc
      from nueva_validacion.bienalquiler a inner join dj_activos.clase b on a.idclase = b.id
      where  a.idbien not in (select d.idbien from nueva_validacion.documentobienalquiler d)  
      and a.identidad = ".$idEntidad." and a.idestadovalidacion=3 and a.habilitado=1
      group by a.idclase, b.descripcion) as sin on sin.idclase = z.id
      left join
      (select a.idclase,b.descripcion as clase, count(a.*) as nobservado
      from nueva_validacion.bienalquiler a inner join dj_activos.clase b on a.idclase = b.id
      inner join gobierno.entidades e on e.id = a.identidad
      inner join dj_dejurbe.declaraciones d on d.identidad = e.id
      where a.idsituacion in (1) and a.idbien not in  (select idbien from nueva_validacion.vista_bienesxtipoobservacion)
      and a.identidad = ".$idEntidad." and d.idestado_declaracion >=3 and d.idgestion = 2019 and a.habilitado=1
      group by a.idclase, b.descripcion) as ot on ot.idclase = z.id
      left join
      (select a.idclase,b.descripcion as clase, count(a.*) as observado
      from nueva_validacion.bienalquiler a inner join dj_activos.clase b on a.idclase = b.id
      inner join gobierno.entidades e on e.id = a.identidad
      inner join dj_dejurbe.declaraciones d on d.identidad = e.id
      where a.idsituacion in (1) and a.idbien in  (select idbien from nueva_validacion.vista_bienesxtipoobservacion)
      and a.identidad = ".$idEntidad." and d.idestado_declaracion >=3 and d.idgestion = 2019  and a.habilitado=1
      group by a.idclase, b.descripcion) as o on o.idclase = z.id
      where z.id not in (1,2,3,4,6)
      order by orden asc
      "); //2018 d.fecvalidado
        //and d.fecvalidado::date between '".$fechaI."' and '".$fechaF."'
        return $query->result();
    }
}

