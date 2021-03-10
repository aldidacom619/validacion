<?php

/**
 * Created by PhpStorm.
 * User: framos
 * Date: 16/8/2017
 * Time: 9:23 AM
 */
class Resumenentidades_model extends CI_Model
{
    /**
     * description: extrae entidades asignadas a validadores
     * @return mixed
     */
    public function entidadesAsignadas(){
        $this->db->select('*');
        $this->db->from('nueva_validacion.zentidades_asignadas_di');
        $this->db->order_by('nombre','ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * description: extrae entidades no asignadas a validadores
     * @return mixed
     */
    public function entidadesNoAsignadas(){
        $this->db->select('*');
        $this->db->from('nueva_validacion.zentidades_no_asignadas_di');
        $this->db->order_by('nombre','ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * description: entidades asignadas a validadores y entidades no asignadas
     * @return mixed
     */
    public function entidadesResumen(){
        $this->db->select('*');
        $this->db->from('nueva_validacion.ztotal_bienes_documentos_asignados_di');
        $query = $this->db->get();
        return $query->result();
    }
}