<?php 
class Inicio extends CI_Controller 
{
	function __construct(){
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('usuarios_model');
        $this->load->model('entidades_model');
	    $this->load->helper('validacion_helper');
	//	$this->load->helper('download');
		$this->load->helper(array('form', 'url')); 
	}
	function _is_logued_in(){
		$is_logued_in = $this->session->userdata('is_logued_in');
		$tipo_user = $this->session->userdata('tipo_user');
		if($is_logued_in != TRUE)
		{
			redirect('usuarios');
		}
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
		$dato['filas'] = $this->entidades_model->select_validar($id); 

		$this->load->view("inicio/cabecera",$dato); 
		$this->load->view("inicio/validar",$dato);
        $this->load->view("inicio/pie");
	}
	public function listasHist (){ //2019 hist
	$value = $this->input->post('func');	
	$datos = $this->entidades_model->getTablaEntHIst($value);
			if($datos){
				foreach($datos as $key=>$fila){
						$num = $key+1;
						$nom = $fila->nombre;
						$data[] = array("nro"=>$num,"nombre"=>$nom);
						/*
						$row = [];
						$row[] = $key+1;
						$row[] = $fila->nombre;
						$output['aaData'][] = $row;
						*/
					}	
			}else{
						/*
						$row = [];
						$row[] = '';
						$row[] = '';
						$output['aaData'][] = $row;
						*/
						$data[] = array("nro"=>'',"nombre"=>'');
			}	
			$data=array("data"=>$data);		
		echo json_encode($data);

	}
	public function listasHistEntidadValidador (){ //2019 histVAlidador
	$value = $this->input->post('func');	
	$datos = $this->entidades_model->getTablaEntValidadorHIst($value);
			if($datos){
				foreach($datos as $key=>$fila){
						/*
						$num = $key+1;
						$nom = $fila->nombre;
						$data[] = array("nro"=>$num,"nombre"=>$nom);
						*/
						$row = [];
						$row[] = $key+1;
						$row[] = $fila->nombre;
						$output['aaData'][] = $row;
						
					}	
			}else{
						
						$row = [];
						$row[] = '';
						$row[] = '';
						$output['aaData'][] = $row;
						/*
						$data[] = array("nro"=>'',"nombre"=>'');
						*/
			}	
			//$data=array("data"=>$data);		
		echo json_encode($output);

	}
	function validadas()
	{
		
		$menu = $this->session->userdata('menu');
		$id = $this->session->userdata('idfuncionario');
		$dato['nombre_completo'] = $this->session->userdata('nombre_completo');
		$dato ['id']= $id;
		 $dato ['identidad']= 0;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
		$dato['tipo_user'] = $this->session->userdata('tipo_user');
		$dato['title']= "Pagina de Inicio";
		$dato['filas'] = $this->entidades_model->select_validadas($id); 

		$this->load->view("inicio/cabecera",$dato); 
		$this->load->view("inicio/validadas",$dato);
        $this->load->view("inicio/pie");
	}
	//iniico buscar
	function buscar()
	{
		
		$menu = $this->session->userdata('menu');
		$id = $this->session->userdata('idfuncionario');
		$dato['nombre_completo'] = $this->session->userdata('nombre_completo');
		$dato ['id']= $id;
		 $dato ['identidad']= 0;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
		$dato['tipo_user'] = $this->session->userdata('tipo_user');
		$dato['title']= "Buscar";
		//$dato['filas'] = $this->entidades_model->select_validadas($id); 

		$this->load->view("inicio/cabecera",$dato); 
		$this->load->view("inicio/buscar",$dato);
       $this->load->view("inicio/verdocumentos",$dato);
	    $this->load->view("inicio/verpersonas",$dato);
	    $this->load->view("inicio/sindocumento",$dato);
        $this->load->view("inicio/pie");
	}
	function load_idbien() {//
		$datob = trim($this->input->post('dato_bien'));
		$data = array();
		$data['datosbien_v'] = $this->entidades_model->get_data_bienv($datob);
		$data['datosbien_mp'] = $this->entidades_model->get_data_bien_mp($datob);
		$data['datosbien_inm'] = $this->entidades_model->get_data_bien_inm($datob);
		$data['dato_b'] = $datob;
		$data['opcion'] = 'data_bien';
		$this->load->view('inicio/pagejquery', $data);
		
	}
	function nombre_ent() {//
		$dato_identidad = $this->input->get('id');
		$estadoEntidad = $this->entidades_model->get_estadoEnt($dato_identidad);
		$json = json_encode($estadoEntidad); 
         echo $json;
		//$data['opcion'] = 'data_identidad';
		//$this->load->view('inicio/pagejquery', $data);
	}
	 function verifIdEntidad()//2019 para modulo buscar
  {
    
    $idEntidad = $this->input->get('ide');
    $idValidador = $this->input->get('idf');
    //echo $idValidador;
    $datos = $this->entidades_model->select_verifEntidad($idEntidad,$idValidador);
    if($datos) echo 1;
    else echo 0; 

  }
	//fin buscar	
} 
?>