<?php

/*
 */

class Entidades_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    function getTablaEntHIst($idfunc) //2019 histvalidador
    {
        $query = $this->db->query("select * from gobierno.entidades e
                                    join (
                                    select distinct identidad from (select * from nueva_validacion.bitacora where idvalidador = '" . $idfunc . "') a
                                    ) v on v.identidad=e.id
                                ");
        return $query->result();
    }
    function getTablaEntValidadorHIst($ident) //2019 histadmin
    {
        $query = $this->db->query("select * from nueva_validacion.usuario u
                                    join (
                                    select distinct idvalidador from (select * from nueva_validacion.bitacora where identidad = '" . $ident . "') a
                                    ) v on v.idvalidador=u.id_funcionario
                                ");
        return $query->result();
    }
    function getTnumBienes($ent, $val) //2019
    {
        $query = $this->db->query("select count(a) as cantidad 
                                    from (select distinct idbien from nueva_validacion.bitacora where idvalidador='" . $val . "' and identidad='" . $ent . "' order by idbien asc) as a");
        return $query->row();
    }
    function getTnumDocumentos($ent, $val) //2019
    {
        $query = $this->db->query("select count(a) as cantidad 
            from (select distinct iddocumento from nueva_validacion.bitacora where idvalidador='" . $val . "' and identidad='" . $ent . "' and iddocumento!=0 order by iddocumento asc) as a");
        return $query->row();
    }
    function estado_entidad($identidad)
    {
        $query = $this->db->query("select *from nueva_validacion.users_universo where asignado = true and identidad = " . $identidad);
        return $query->result();
    }
    function select_validadores()
    {
        $query = $this->db->query("select *from nueva_validacion.usuario where activo = 't' and administrador = 'f'");
        return $query->result();
    }

    function select_validar($id)
    { //2019

        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto, 
                totaldocumentos, totaldocumentos_val, totaldocumentos_noval
                FROM (select * from (
                             select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo, totaldocumentos,totaldocumentos_val,totaldocumentos_noval 
                             from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                                join nueva_validacion.vista_users_universo us on us.identidad=a.id) 

us where saldo>0 and us.idusuario='" . $id . "' order by id asc");


        return $query->result();
    }
    function select_verifEntidad($ident, $idval)
    { //2019 para modulo buscar
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where saldo>0 and us.idusuario=" . $idval . " and us.id = " . $ident . " order by id asc");


        return $query->row();
    }

    function select_validadas($id)
    { //2019 validadas
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto,
                totaldocumentos, totaldocumentos_val, totaldocumentos_noval 
                FROM (select * from (
                                select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo, totaldocumentos,totaldocumentos_val,totaldocumentos_noval  
                                from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where saldo=0 and us.idusuario=" . $id . "order by id asc");


        return $query->result();
    }

    function select_validar2($id)
    {
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where  us.idusuario=" . $id . "order by id asc");


        return $query->result();
    }

    function devolver_entidad($identidad)
    {

        $this->db->select('*');
        $this->db->where('id', $identidad);
        $query = $this->db->get('nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di');
        return $query->result();
    }

    function getTablaInmuebles($id, $estado)
    {
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where saldo=0 and us.idusuario=" . $id . "order by id asc");


        return $query->result();
    }


    function entidadrubro($identidad)
    {
        $query = $this->db->query(" select a.rubro ,sum(a.bien)as bien,sum( a.validado)as validado from
(SELECT case when c.id = 1 or c.id = 2 then 'INMUEBLES' else c.descripcion end as rubro,
    COUNT(CASE WHEN b.idestadovalidacion != 3 then 1 ELSE NULL END) bien,
    COUNT(CASE WHEN b.idestadovalidacion = 3 then 1 ELSE NULL END) validado
FROM nueva_validacion.bien b
INNER JOIN dj_activos.clase c ON b.idclase=c.id
WHERE b.identidad=" . $identidad . " and b.idsituacion = 1
GROUP BY c.descripcion,b.idclase,c.id
UNION ALL
SELECT case when c.id = 1 or c.id = 2 then 'INMUEBLES' else c.descripcion end as rubro,
    COUNT(CASE WHEN b.idestadovalidacion != 3 then 1 ELSE NULL END) bien,
    COUNT(CASE WHEN b.idestadovalidacion = 3 then 1 ELSE NULL END) validado
FROM nueva_validacion.bienalquiler b
INNER JOIN dj_activos.clase c ON b.idclase=c.id
WHERE b.identidad=" . $identidad . " and b.idsituacion = 1
GROUP BY c.descripcion,b.idclase,c.id)as a GROUP BY a.rubro
");
        return $query->result();
    }

    function select_dejurbe()
    {
        $query = $this->db->query("select *from gobierno.vista_entidades where declara = 't'");
        return $query->result();
    }

    function select_dejurbe2()
    {
        $query = $this->db->query("select *from gobierno.vista_entidades where declara = 'f'");
        return $query->result();
    }

    function altaentidad($identidad)
    {
        $data = array(
            'declara' => 't'
        );
        $this->db->where('id', $identidad);
        return $this->db->update('gobierno.entidades', $data);
    }

    function altaentidaduser($identidad)
    {
        $data = array(
            'activo' => 't'
        );
        $this->db->where('identidad', $identidad);
        return $this->db->update('dj_seguridad.usuarios', $data);
    }

    function bajaentidad($identidad)
    {
        $data = array(
            'declara' => 'f'
        );
        $this->db->where('id', $identidad);
        return $this->db->update('gobierno.entidades', $data);
    }

    function bajaentidaduser($identidad)
    {
        $data = array(
            'activo' => 'f'
        );
        $this->db->where('identidad', $identidad);
        return $this->db->update('dj_seguridad.usuarios', $data);
    }
    //inicio validacion 2018
    function getUgestion()
    {
        $query = $this->db->query("select * from nueva_validacion.gestion where anio in (select max(idgestion) as gestion from nueva_validacion.bien)");
        return $query->row();
    }
    function getmaxgestbien()
    {
        $query = $this->db->query("select max(idgestion) as gestion from nueva_validacion.bien");
        return $query->row();
    }

    function habilitados()
    {
        $query1 = $this->db->query("select max(idgestion) as gestion from nueva_validacion.bien");
        $gestion = $query1->row()->gestion;
        $query = $this->db->query("
                                (
                    select 
                    b.identidad, 
                    de.idgestion, 
                    b.idtipobien, 
                    b.idestado_validacion, 
                    b.idestado_documentacion, 
                    b.id, b.idsituacion, 
                    b.idestadobien, b.iduso, 
                    b.idclase, b.idciudad, 
                    b.codigo_activo,
                    dep.descripcion, 
                        case
                        WHEN de.idgestion=" . $gestion . " THEN 1
                        END AS habilitado
                     
                    from dj_activos.bien b

                    join gobierno.entidades e on b.identidad=e.id
                    join dj_dejurbe.declaraciones de on b.identidad=de.identidad
                    left join geografia.departamento dep on dep.id=b.idciudad
                    where

                     b.identidad != 27 and b.idsituacion in (1,3,5) and de.idgestion=" . $gestion . " and de.idestado_declaracion=3 

                    )
                    
                    order by id asc


            ");

        return $query->result();
    }
    function habilitados1()
    {
        $query1 = $this->db->query("select max(idgestion) as gestion from nueva_validacion.bien");
        $gestion = $query1->row()->gestion;
        $query = $this->db->query("
                                select b.id as idnv, b.idbien, cb.id, cb.habilitado 
from nueva_validacion.vista_bien b
join (
                    select 
                    --b.identidad, 
                   -- de.idgestion, 
                    --b.idtipobien, 
                    --b.idestado_validacion, 
                   -- b.idestado_documentacion, 
                    b.id, 
            --b.idsituacion, 
                   -- b.idestadobien, b.iduso, 
                   -- b.idclase, b.idciudad, 
                    --b.codigo_activo,
                    --dep.descripcion, 
                        case
                        WHEN de.idgestion=" . $gestion . " THEN 1
                        END AS habilitado
                     
                    from dj_activos.bien b

                    join gobierno.entidades e on b.identidad=e.id
                    join dj_dejurbe.declaraciones de on b.identidad=de.identidad
                    left join geografia.departamento dep on dep.id=b.idciudad
                    where

                     b.identidad != 27 and b.idsituacion in (1,3,5) and de.idgestion=" . $gestion . " and de.idestado_declaracion=3 

                    ) cb on b.idbien=cb.id

order by id asc


            ");

        return $query->result();
    }
    function habilitarbien()
    {
        $query1 = $this->db->query("select max(idgestion) as gestion from nueva_validacion.bien");
        $gestion = $query1->row()->gestion;
        $query = $this->db->query("
            update nueva_validacion.bien set habilitado=0;                    
            update nueva_validacion.bien set habilitado=1
--order by id asc
where id in (select b.id as idnv
--, b.idbien, cb.id, cb.habilitado 
from nueva_validacion.vista_bien b
join (
                    select 
                    --b.identidad, 
                   -- de.idgestion, 
                    --b.idtipobien, 
                    --b.idestado_validacion, 
                   -- b.idestado_documentacion, 
                    b.id, 
            --b.idsituacion, 
                   -- b.idestadobien, b.iduso, 
                   -- b.idclase, b.idciudad, 
                    --b.codigo_activo,
                    --dep.descripcion, 
                        case
                        WHEN de.idgestion=" . $gestion . " THEN 1
                        END AS habilitado
                     
                    from dj_activos.bien b

                    join gobierno.entidades e on b.identidad=e.id
                    join dj_dejurbe.declaraciones de on b.identidad=de.identidad
                    left join geografia.departamento dep on dep.id=b.idciudad
                    where

                     b.identidad != 27 and b.idsituacion in (1,3,5) and de.idgestion=" . $gestion . " and de.idestado_declaracion=3 

                    ) cb on b.idbien=cb.id
join nueva_validacion.bien nvb on nvb.id=b.id)



            ");

        if ($this->db->affected_rows() > 0) return TRUE;
        else return FALSE;
    }
    function habilitarbienalquiler()
    {
        $query1 = $this->db->query("select max(idgestion) as gestion from nueva_validacion.bien");
        $gestion = $query1->row()->gestion;
        $query = $this->db->query("
            TRUNCATE TABLE nueva_validacion.users_universo RESTART IDENTITY;
            alter sequence nueva_validacion.users_universo_id_seq1 restart with 1;
            update nueva_validacion.bienalquiler set habilitado=0; 
            update nueva_validacion.bienalquiler set habilitado=1
            where id in (select b.id as idnv
            from nueva_validacion.vista_bienalquiler b
            join (
                    select 
                    b.id, 
                     case
                        WHEN de.idgestion=" . $gestion . " THEN 1
                        END AS habilitado
                     
                    from dj_alquiler.bien b

                    join gobierno.entidades e on b.identidad=e.id
                    join dj_dejurbe.declaraciones de on b.identidad=de.identidad
                    left join geografia.departamento dep on dep.id=b.idciudad
                    where

                     b.identidad != 27 and b.idsituacion in (1,3,5) and de.idgestion=" . $gestion . " and de.idestado_declaracion=3 

                    ) cb on b.idbien=cb.id
join nueva_validacion.bienalquiler nvb on nvb.id=b.id)


            ");

        if ($this->db->affected_rows() > 0) return TRUE;
        else return FALSE;
    }

    function guardargestnew($gestion)
    {
        $data = array(
            'anio' => $gestion

        );
        $this->db->insert('nueva_validacion.gestion', $data);
    }
    function idBienNuevavalidacion($idb)
    {
        $query = $this->db->query("select id from nueva_validacion.bien where idbien='" . $idb . "' order by id desc limit 1");
        return $query->row();
    }
    function updateHabilitanv($idnv, $habilitar)
    {
        $data = array(
            'habilitado' => 15
        );
        $this->db->where('id', $idnv);
        return  $this->db->update('nueva_validacion.bien', $data);
    }
    // fin validacion 2018
    //inicio buscar
    function get_data_bienv($datobien)
    {
        $query = $this->db->query("
                select v.*, 'VEHICULO' as rubro, e.nombre, vg.idtipovalidacion
                from nueva_validacion.vista_vehiculos v
                join gobierno.entidades e on v.identidad=e.id
                left join (
                select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestionvehiculo where idtipovalidacion=2
                ) vg on vg.idb=v.id
                where v.habilitado=1 and (v.nrochasis ilike('%$datobien%') or v.placa ilike('%$datobien%') or v.documentos ilike('%$datobien%') or TO_CHAR(v.idbien, '99999999') ilike('%$datobien%')) 
                order by v.idbien asc
            ");
        return $query->result();
    }
    function get_data_bien_mp($datobien)
    {
        $query = $this->db->query("
                select mp.*, 'MAQUINARIA PESADA MOVIL' as rubro, e.nombre, vg.idtipovalidacion
                from nueva_validacion.vista_maquinariapesada mp
                join gobierno.entidades e on mp.identidad=e.id
                left join (
                select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestionmaquinariapesada where idtipovalidacion=2
                ) vg on vg.idb=mp.id

                where mp.habilitado=1 and (mp.nrochasis ilike('%$datobien%') or mp.documentos ilike('%$datobien%') or TO_CHAR(mp.idbien, '99999999') ilike('%$datobien%'))
                order by idbien asc
            ");
        return $query->result();
    }
    function get_data_bien_inm($datobien)
    { //2019
        //$numero="";
        //if(is_numeric($datobien)) $numero = "or inm.superficieterreno=$datobien";

        $query = $this->db->query("
                select inm.*, 'INMUEBLES' as rubro, e.nombre, vg.idtipovalidacion
                from nueva_validacion.vista_inmuebles inm
                join gobierno.entidades e on inm.identidad=e.id
                left join (
                select distinct idb, idtipovalidacion from nueva_validacion.validacionxgestioninmueble where idtipovalidacion=2
                ) vg on vg.idb=inm.id

                where inm.habilitado=1 and (inm.direccion ilike('%$datobien%') or inm.documentos ilike('%$datobien%') or TO_CHAR(inm.superficieterreno, '99999999') ilike('%$datobien%') or TO_CHAR(inm.idbien, '99999999') ilike('%$datobien%'))
                order by idbien asc
            ");
        return $query->result();
    }
    function get_estadoEnt($ident)
    {
        $query = $this->db->query("
                select u.*, e.nombre from nueva_validacion.users_universo u
                    join gobierno.entidades e on u.identidad=e.id
                where asignado = true and identidad = '" . $ident . "'
            ");
        return $query->result();
    }

    function select_validarTodo()
    {
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us order by id asc");
        return $query->result();
    }
    function select_validarTodo1()
    {
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where id between 1 and 100 order by id asc");
        return $query->result();
    }
    function select_validarTodo2()
    {
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where id between 101 and 200 order by id asc");
        return $query->result();
    }
    function select_validarTodo3()
    {
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where id between 201 and 300 order by id asc");
        return $query->result();
    }
    function select_validarTodo4()
    {
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where id between 301 and 400 order by id asc");
        return $query->result();
    }
    function select_validarTodo5()
    {
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where id between 401 and 500 order by id asc");
        return $query->result();
    }
    function select_validarTodo6()
    {
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where id >= 501 order by id asc");
        return $query->result();
    }
    function select_validarTodo7($desde, $hasta)
    {
        $query = $this->db->query("select id,entidad,totalbienes,bienesvalidados,saldo,
                identidad,idusuario,nombre,corto FROM (select * from (select id,nombre as entidad,totalbienes,bienesvalidados,totalbienes-bienesvalidados as saldo from nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di) a
                join nueva_validacion.vista_users_universo us on us.identidad=a.id) us where id between " . $desde . " and " . $hasta . " order by id asc");
        return $query->result();
    }
}
