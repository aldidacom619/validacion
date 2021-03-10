<?php

class Adminusuario_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get() {
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get_where('nueva_validacion.usuario', array('eliminado' => false));
        return $query->result();
    }

    public function getValidador($id) {
        $query = $this->db->get_where('nueva_validacion.usuario', array('id_funcionario' => $id));
        return $query->row();
    }

    public function activo($id) {
        $query = $this->db->get_where('nueva_validacion.usuario', array('id_funcionario' => $id));
        if ($query->num_rows() > 0) {
            if ($query->row()->activo == 't') {
                $this->db->update('nueva_validacion.usuario', array('activo' => false), array('id_funcionario' => $id));
            } else {
                $this->db->update('nueva_validacion.usuario', array('activo' => true), array('id_funcionario' => $id));
            }
        }
    }

    public function admin($id) {
        $query = $this->db->get_where('nueva_validacion.usuario', array('id_funcionario' => $id));
        if ($query->num_rows() > 0) {
            if ($query->row()->administrador == 't') {
                $this->db->update('nueva_validacion.usuario', array('administrador' => false), array('id_funcionario' => $id));
            } else {
                $this->db->update('nueva_validacion.usuario', array('administrador' => true), array('id_funcionario' => $id));
            }
        }
    }

    public function asignadoestado($id) {
        $query = $this->db->get_where('nueva_validacion.users_universo', array('id' => $id));
        if ($query->num_rows() > 0) {
            if ($query->row()->asignado == 't') {
                $this->db->update('nueva_validacion.users_universo', array('asignado' => false, 'fecha_desasignacion' => date('d/m/Y')), array('id' => $id));
            } else {
                $this->db->update('nueva_validacion.users_universo', array('asignado' => true), array('id' => $id));
            }
        }
    }

}

?>