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
}
