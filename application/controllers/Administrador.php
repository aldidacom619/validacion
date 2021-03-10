<?php 
class Administrador extends CI_Controller 
{
    function __construct(){
        parent::__construct();
        $this->_is_logued_in();
        $this->load->model('usuarios_model');
        $this->load->model('entidades_model');
        $this->load->model('reportes_model');
        $this->load->model('resumenentidades_model');
        $this->load->model('adminusuario_model'); 
        $this->load->model('adminusersuniverso_model');
        $this->load->model('adminentidades_model');
        $this->load->model('documentacion_model');
        $this->load->helper('fechas_helper');
        $this->load->helper('validacion_helper');
        $this->load->helper(array('form', 'url')); 
        $this->usuario['usuario'] = $this->session->userdata('nombre_completo');
        $this->_is_logued_in();
    }
    //pruebas ****** **** ********* ********* ******
    function _is_logued_in(){ 
        $is_logued_in = $this->session->userdata('is_logued_in');        
        $tipo_user = $this->session->userdata('administrador');
        if($is_logued_in == 1){
            if($tipo_user != 't'){
                redirect('inicio');
            }
        }  
        else{
            redirect('usuarios');
        }
    }    
    public function index()
    {
                 
        $verificarGestion = $this->entidades_model->getUgestion();
        if(!$verificarGestion) {
        //echo "no existe";
        echo "valor de bien es: ".actualizarbien();  
        }  

        //var_dump($this->documentacion_model->validacionAutomaticaInmuebles()); //2019
        //echo ($this->documentacion_model->validacionAutomaticaInmuebles()); //2019

        $this->load->view("layout/cabecera",$this->usuario);
        $data["entidadesr"] = $this->resumenentidades_model->entidadesResumen();
        $data["entidades"] = $this->resumenentidades_model->entidadesNoAsignadas();
        $data["entidadesn"] = $this->resumenentidades_model->entidadesAsignadas();
        $this->load->view("administrador/index",$data);
        $this->load->view("layout/pie");
    }
    public function validadores()
    {
        $this->load->model('users_universo');
//        $data["get"]=$this->adminusuario_model->get();
        $this->load->view("layout/cabecera",$this->usuario);
        $data['datos'] = $this->usuarios_model->usuarios();
        $data['get'] = $this->users_universo->listaValidadores(getCurrentYear());
        $this->load->view("administrador/validadores",$data);
        $this->load->view("layout/pie");
    }   
    public function entidades()
    {
        $data["get"]=$this->adminentidades_model->get();
        $this->load->view("administrador/entidades",$data);
        $this->load->view("layout/pie");
    }
    public function reportes()
    {
//        $data["get"]=$this->adminvalidador_model->get();

        
        $this->load->view("administrador/reportes");
        $this->load->view("layout/pie");
    }
    public function activoValidador()
    {
        $this->adminusuario_model->activo($this->input->post('id'));
    }
    public function adminValidador()
    {
        $this->adminusuario_model->admin($this->input->post('id'));
    }
} 
?>
