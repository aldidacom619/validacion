<?php
class Adminclase_model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }
    public function get()
    {
//        $this->db->order_by('descripcion', 'ASC');
        $query = $this->db->get('dj_activos.clase');
        return $query->result();
    }
}
?>