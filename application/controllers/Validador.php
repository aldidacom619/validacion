<?php

/**
 * Created by PhpStorm.
 * User: framos
 * Date: 2/8/2017
 * Time: 5:58 PM
 */
class Validador extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->_is_logued_in();
        $this->load->model('usuarios_model');
        $this->load->helper('validacion_helper');
        $this->load->helper('fechas_helper');
        $this->load->helper(array('form', 'url'));
        $dato['usuario'] = $this->session->userdata('nombre_completo');
        $this->usuario['usuario'] = $this->session->userdata('nombre_completo');
//        $this->load->view("layout/cabecera",$dato);
    }
    function _is_logued_in(){
        $is_logued_in = $this->session->userdata('is_logued_in');
        $tipo_user = $this->session->userdata('administrador');
        if($is_logued_in != TRUE&&$tipo_user == 'f')
        {
            redirect('usuarios');
        }
    }

    public function store() {
        $query = $this->db->query("select sub.nombre,sub.corto ,sub.sigla,sub.usuario,
        sub.password,sub.id_funcionario
        from
        dblink('dbname=sicenad14 hostaddr=192.168.15.100 user =postgres password=js3QmA9vZ7edF2X port=5432',
        'select nombres||'' ''||paterno||'' ''||materno nombre,
        nombres||'' ''||substr(paterno,1,1)||''.'' corto,
        substr(nombres,1,1)||substr(paterno,1,1)||substr(materno,1,1) sigla,
        usu_usuario,usu_contrasena,usu_funcionario
        from seguridad.usuarios seg
        inner join personal.funcionarios fun on usu_funcionario = idfunc
        where fun.id_estructura in (12,13,4)and fun.estado = 1') as
        sub(nombre varchar(100), corto varchar(50),sigla varchar(5),usuario varchar(50), password varchar(80),id_funcionario integer)
        where sub.id_funcionario not in(select id_funcionario from nueva_validacion.usuario )
        and sub.id_funcionario = ".$this->input->post('idfuncionario'));
        $query->row_array();
        $idUsuario = $this->usuarios_model->addUsuario($query->result_array[0]);
        $datos = $this->usuarios_model->getUsuario($idUsuario,getCurrentYear());
        $json = json_encode($datos);
        if($idUsuario > 0) {
            echo $json;
        }
        else{
            echo 0;
        }
    }
    public function store2() {
        $id = $this->input->get('idfuncionario');
        var_dump($id);
        //$id = 37134;
//        $datos = $this->inmuebles_model->getEstadoBien($id);
//        echo $datos[0]->descripcion;
        $id = $this->input->post("idfuncionario");
        var_dump($id);
        echo 'ssssssssss';
        if($id != null) {
            $data = $this->model_usuario->consulta($id);
        }
    }
}