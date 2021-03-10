<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Dejurbe2020 extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->db_dejurbe = $this->load->database('db_dejurbe_gestion2020', TRUE);
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        $data = '';     
        $this->response($data, REST_Controller::HTTP_OK);
    }
    public function estadodejurbe_get()
	{
        $data = $this->db_dejurbe->get("dj_activos.vista_estadodejurbe")->result();
        $this->response($data, REST_Controller::HTTP_OK);
	}
      
    
    	
}