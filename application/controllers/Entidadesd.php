<?php 
class Entidadesd extends CI_Controller 
{
    function __construct(){
        parent::__construct();
        $this->_is_logued_in();
        $this->load->model('usuarios_model');
        $this->load->model('entidades_model');
        $this->load->model('reportes_model');
        
        $this->load->model('adminusuario_model');
        $this->load->model('adminusersuniverso_model');
        $this->load->model('adminentidades_model');
        $this->load->model('adminclase_model');
        
        $this->load->helper('validacion_helper');
        $this->load->helper(array('form', 'url')); 
        $this->usuario['usuario'] = $this->session->userdata('nombre_completo');        
    }
    function _is_logued_in(){
       /* $is_logued_in = $this->session->userdata('is_logued_in');
        $tipo_user = $this->session->userdata('administrador');
        if($is_logued_in != TRUE&&$tipo_user == 'f')
        {
            redirect('usuarios');
        }  */
    }    
   function index()
    {
        $menu = $this->session->userdata('menu');
        $id = $this->session->userdata('idfuncionario');
        $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
        $dato ['id']= $id;
         $dato ['identidad']=0;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
        $dato['tipo_user'] = $this->session->userdata('tipo_user');
        $dato['title']= "Pagina de Inicio";
        $dato['filas'] = $this->entidades_model->select_dejurbe($id); 

        $this->load->view("inicio/cabecera",$dato); 
        $this->load->view("inicio/entidad",$dato);
        $this->load->view("inicio/pie");
    }
    function entidadesbaja()
    {
        $menu = $this->session->userdata('menu');
        $id = $this->session->userdata('idfuncionario');
        $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
        $dato ['id']= $id;
         $dato ['identidad']=0;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
        $dato['tipo_user'] = $this->session->userdata('tipo_user');
        $dato['title']= "Pagina de Inicio";
        $dato['filas'] = $this->entidades_model->select_dejurbe2($id); 

        $this->load->view("inicio/cabecera",$dato); 
        $this->load->view("inicio/entidad2",$dato);
        $this->load->view("inicio/pie");
    }
    function alta($identidad)
    {
       $update = $this->entidades_model->altaentidad($identidad);
       $update = $this->entidades_model->altaentidaduser($identidad);
                $this->entidadesbaja();        
    }
    function baja($identidad)
    {
      $update = $this->entidades_model->bajaentidad($identidad);
       $update = $this->entidades_model->bajaentidaduser($identidad);
        $this->index();

    }
}