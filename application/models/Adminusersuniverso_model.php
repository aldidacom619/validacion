<?php
class Adminusersuniverso_model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }
    public function get()
    {
        $this->db->order_by('usuario', 'ASC');
        $query = $this->db->get('nueva_validacion.usuario');
        return $query->result();
    }
    public function getAll($id)
    {
        $this->db->join('gobierno.entidades ge','ge.id=nuu.identidad');
        $this->db->order_by('ge.nombre', 'ASC');
        $this->db->where('nuu.idusuario', $id);
        $query = $this->db->get('nueva_validacion.users_universo nuu');
        return $query->result();
    }

}
?>