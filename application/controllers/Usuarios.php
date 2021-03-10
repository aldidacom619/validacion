<?php 
class Usuarios extends CI_Controller 
{
	function __construct(){
		parent::__construct();
			$this->load->model('usuarios_model');
    		$this->load->helper(array('form', 'url'));
			$this->load->library('email');
			$this->load->library('form_validation');
			$this->load->helper('date'); 
	}

	function index()
	{
		$dato['error'] ="";
		$dato['title']= "Ingreso de Usuarios";
		$this->load->view("inicio/cabecera2",$dato); 
		$this->load->view("usuario/logued",$dato);
        $this->load->view("inicio/pie");
	}
	function logued() 
		{
			$username = $this->input->post('username');
			$password = md5($this->input->post('pass'));
			$login = $this->usuarios_model->loguear($username, $password);
			if($login)
			{
				//echo var_dump($login);
				$data = array(
						'is_logued_in'  => TRUE,								
						'usuario'=> $login['usuario'],
		                'nombre'=> $login['nombre'],
		                'apellidopat'=> $login['apellidopat'],
		                'apellidomat'=> $login['apellidomat'],
		                'idfuncionario'=> $login['idfuncionario'],
						'administrador'=> $login['administrador'],
						'nombre_completo'=> $login['nombre']." ".$login['apellidopat']." ".$login['apellidomat']
						); 
						$this->session->set_userdata($data);						
						if($login['administrador'] == 't')
						{
							redirect("administrador");		
						}
						else
						{
							redirect("inicio");			
						}

			}		
			else 
			{
				$dato['title']= "Ingreso de usuarios";	
				$dato['error'] ="El nombre de usuario o contraseña son incorrectos";	
				$this->load->view("inicio/cabecera2",$dato); 
				$this->load->view("usuario/logued",$dato);
		        $this->load->view("inicio/pie");
			}
		}
	function salir()
	{
		$this->session->sess_destroy();
		redirect('usuarios');

	}
	function cambio_clave()
	{
		$dato['error'] ="";
		$dato['title']= "Recuperar Contraseña";
		$this->load->view("inicio/cabecera2",$dato); 
		$this->load->view("usuario/correo",$dato);
        $this->load->view("inicio/pie");
	}
	

	function recu_contra($id)
	{
			
			
			$dato ['id']= $id;
			

			$dato['error'] ="";

			$dato['title']= "Cambiar Contraseña";	
			$this->load->view("inicio/cabecera2",$dato);
			$this->load->view("usuario/re_contra",$dato);
			$this->load->view("inicio/pie");
	}
	function _control_clave($clave) 
	{
		
		$user = $this->session->userdata('user');

		return $this->usuarios_model->contro_user($user, $clave);
	}

	function cambiar_contra($id)
	{

		$dato ['id']= $id;
		$nueva =  md5($this->input->post('password'));
		$confimar = md5($this->input->post('repassword'));

			if($nueva == $confimar)
			{
				$update = $this->usuarios_model->cambiar_clave($id,$nueva);
				$dato['error'] ="SE MODIFICO SU CONTRASEÑA ...!!";
				$dato['title']= "Ingreso de Usuarios";
				$this->load->view("inicio/cabecera2",$dato); 
				$this->load->view("usuario/logued",$dato);
        		$this->load->view("inicio/pie");
			}
			else
			{
				$dato['error'] ="Los campos nueva contraseña  y confimar contraseña  no coinciden ...!!";
				$dato['title']= "Cambiar Contraseña";	
				$this->load->view("inicio/cabecera2",$dato);
				$this->load->view("usuario/re_contra",$dato);
				$this->load->view("inicio/pie");

			}	
		
		
			

	}

	function reset_session(){
//        is_logued_in
        var_dump($this->session);
    }
}

?>