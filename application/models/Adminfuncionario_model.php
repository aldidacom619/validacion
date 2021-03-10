<?php
class Adminfuncionario_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db_sicenad = $this->load->database('db_sicenad', TRUE);    
    }
    public function get()
    {        
        $query = $this->db_sicenad->get('personal.funcionarios');
        return $query->result();        
    }
    public function getLike($data)
    {        
        $this->db_sicenad->like('nombre', $data);
        $query = $this->db_sicenad->get('personal.funcionarios');
        return $query->result();        
    }

}
?>