<?php

/**
 * Created by PhpStorm.
 * User: framos
 * Date: 13/9/2017
 * Time: 4:05 PM
 */
class Adminreporte_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }
    public function reporteGeneralValidacion()
    {
        $query = $this->db->query("select
          (select count(idbien)as binmuebles from nueva_validacion.bien where habilitado = 1 and idclase in (1,2)) as inmuebles
          ,(select count(idbien)as binmuebles from nueva_validacion.bien where habilitado = 1 and idclase = 3) as vehiculos
            ,(select count(idbien)as binmuebles from nueva_validacion.bien where habilitado = 1 and idclase = 4) as maquinaria
            ,(select count(idbien)as binmuebles from nueva_validacion.bien where habilitado = 1 and idclase = 6) as maquinaria_pesada
            ,(select count(idbien)as binmuebles from nueva_validacion.bienalquiler where habilitado = 1 and idclase = 5) as inmueble_alquiler
            ,(select count(idbien)as binmuebles from nueva_validacion.bienalquiler where habilitado = 1 and idclase = 7) as vehiculo_alquiler
            ,(select sum(binmuebles) from(select count(idbien)as binmuebles from nueva_validacion.bien where habilitado = 1
            union all
            select count(idbien)as binmuebles from nueva_validacion.bienalquiler where habilitado = 1
            )as t1
            ) as total
            union all
        --total bienes validados
            select
            (select count(idbien)as binmuebles from nueva_validacion.bien where habilitado = 1 and idestadovalidacion = 3 and idclase in (1,2)) as inmuebles
            ,(select count(idbien)as binmuebles from nueva_validacion.bien where habilitado = 1 and idestadovalidacion = 3 and idclase = 3)as vehiculos
            ,(select count(idbien)as binmuebles from nueva_validacion.bien where habilitado = 1 and idestadovalidacion = 3 and idclase = 4) as maquinaria
            ,(select count(idbien)as binmuebles from nueva_validacion.bien where habilitado = 1 and idestadovalidacion = 3 and idclase = 6) as maquinaria_pesada
            ,(select count(idbien)as binmuebles from nueva_validacion.bienalquiler where habilitado = 1 and idestadovalidacion = 3 and idclase = 5)as inmueble_alquiler
            ,(select count(idbien)as binmuebles from nueva_validacion.bienalquiler where habilitado = 1 and idestadovalidacion = 3 and idclase = 7) as vehiculo_alquiler
            ,(select sum(binmuebles) from(select count(idbien)as binmuebles from nueva_validacion.bien where habilitado = 1 and idestadovalidacion = 3
            union all
            select count(idbien)as binmuebles from nueva_validacion.bienalquiler where habilitado = 1 and idestadovalidacion = 3)as t1
            )as total
            union all
            --total docuementos
            select (select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (1,2) and d.eliminado = 'f' and d.adicionado = 'f') as inmuebles
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (3) and d.eliminado = 'f' and d.adicionado = 'f') as vehiculos
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (4) and d.eliminado = 'f' and d.adicionado = 'f') as maquinaria
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (6) and d.eliminado = 'f' and d.adicionado = 'f') as maquinaria_pesada
            ,(select count(d.id)as binmuebles from nueva_validacion.bienalquiler b
            join nueva_validacion.documentobienalquiler d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (5) and d.eliminado = 'f' and d.adicionado = 'f')as inmueble_alquiler
            ,(select count(d.id)as binmuebles from nueva_validacion.bienalquiler b
            join nueva_validacion.documentobienalquiler d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (7) and d.eliminado = 'f' and d.adicionado = 'f') as vehiculo_alquiler
            ,(select sum(binmuebles) from(select count(d.id)as binmuebles from nueva_validacion.bien b join nueva_validacion.documentobien d on d.idb = b.id where b.habilitado = 1 and d.eliminado = 'f' and d.adicionado = 'f'
            union all
            select count(d.id)as binmuebles from nueva_validacion.bienalquiler b join nueva_validacion.documentobienalquiler d on d.idb = b.id where b.habilitado = 1 and d.eliminado = 'f' and d.adicionado = 'f'
            )as t2
            )as total
            union all
            ---total docuementos validados
            select (select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (1,2) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 'f') as inmuebles
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (3) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 'f') as vehiculos
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (4) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 'f') as maquinaria
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (6) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 'f' )as maquinaria_pesada
            ,(select count(d.id)as binmuebles from nueva_validacion.bienalquiler b
            join nueva_validacion.documentobienalquiler d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (5) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 'f')as inmueble_alquiler
            ,(select count(d.id)as binmuebles from nueva_validacion.bienalquiler b
            join nueva_validacion.documentobienalquiler d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (7) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 'f') as vehiculo_alquiler
            ,(select sum(binmuebles) from(select count(d.id)as binmuebles from nueva_validacion.bien b join nueva_validacion.documentobien d on d.idb = b.id where b.habilitado = 1 and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 'f'
            union all
            select count(d.id)as binmuebles from nueva_validacion.bienalquiler b join nueva_validacion.documentobienalquiler d on d.idb = b.id where b.habilitado = 1 and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 'f'
            )as t2
            )as total
            union all
            --total docuementos agregados
            select (select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (1,2) and d.eliminado = 'f' and d.adicionado = 't') as inmuebles
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (3) and d.eliminado = 'f' and d.adicionado = 't') as vehiculos
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (4) and d.eliminado = 'f' and d.adicionado = 't') as maquinaria
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (6) and d.eliminado = 'f' and d.adicionado = 't')as maquinaria_pesada
            ,(select count(d.id)as binmuebles from nueva_validacion.bienalquiler b
            join nueva_validacion.documentobienalquiler d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (5) and d.eliminado = 'f' and d.adicionado = 't')as inmueble_alquiler
            ,(select count(d.id)as binmuebles from nueva_validacion.bienalquiler b
            join nueva_validacion.documentobienalquiler d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (7) and d.eliminado = 'f' and d.adicionado = 't') as vehiculo_alquiler
            ,(select sum(binmuebles) from(select count(d.id)as binmuebles from nueva_validacion.bien b join nueva_validacion.documentobien d on d.idb = b.id where b.habilitado = 1 and d.eliminado = 'f' and d.adicionado = 't'
            union all
            select count(d.id)as binmuebles from nueva_validacion.bienalquiler b join nueva_validacion.documentobienalquiler d on d.idb = b.id where b.habilitado = 1 and d.eliminado = 'f' and d.adicionado = 't'
            )as t2
            )as total
            union all
            ---total docuementos agregados validados
            select (select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (1,2) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 't') as inmuebles
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (3) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 't') as vehiculos
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (4) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 't') as maquinaria
            ,(select count(d.id)as binmuebles from nueva_validacion.bien b
            join nueva_validacion.documentobien d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (6) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 't' ) as maquinaria_pesada
            ,(select count(d.id)as binmuebles from nueva_validacion.bienalquiler b
            join nueva_validacion.documentobienalquiler d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (5) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 't')as inmueble_alquiler
            ,(select count(d.id)as binmuebles from nueva_validacion.bienalquiler b
            join nueva_validacion.documentobienalquiler d on d.idb = b.id
            where b.habilitado = 1 and b.idclase in (7) and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 't') as vehiculo_alquiler
            ,(select sum(binmuebles) from(select count(d.id)as binmuebles from nueva_validacion.bien b join nueva_validacion.documentobien d on d.idb = b.id where b.habilitado = 1 and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 't'
            union all
            select count(d.id)as binmuebles from nueva_validacion.bienalquiler b join nueva_validacion.documentobienalquiler d on d.idb = b.id where b.habilitado = 1 and d.eliminado = 'f' and d.validado = 't' and d.adicionado = 't'
            )as t2
            )as total
            ");
        return $query->result();
    }
    public function reporteValidacionDepartamento()
    {
        $query = $this->db->query("select descripcion, count(departamento)as departamento,sum(totalbienes)as totalbienes,sum(bienesvalidados)as bienesvalidados,sum(totalbienes) - sum(bienesvalidados) as saldobienes
          ,sum(totaldocumentos)as totaldocumentos ,sum(totaldocumentos_val)as totaldocumentos_val,sum(totaldocumentos_noval)as totaldocumentos_noval,sum(totaldocumentos_adicionado)as totaldocumentos_adicionado
          ,sum(totaldocumentos_adicionado_val)as totaldocumentos_adicionado_val,sum(totaldocumentos_adicionado_noval)as totaldocumentos_adicionado_noval
          from(
          select *from nueva_validacion.totales_bienes_documentos_di c
          JOIN gobierno.entidades b ON c.identidad = b.id
          JOIN geografia.departamento d ON d.id = b.departamento
          LEFT JOIN nueva_validacion.bienesvalidados_di a ON a.identidad = b.id
          WHERE b.id <> 27
          )as t1 group by departamento,descripcion order by departamento desc");
        return $query->result();
    }
    public function reporteGeneralAvance()
    {
        $query = $this->db->query("select *from nueva_validacion.ztotalbienes_documento_validador_di");
        return $query->result();
    }

}