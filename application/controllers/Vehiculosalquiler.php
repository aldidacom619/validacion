<?php 
class Vehiculosalquiler extends CI_Controller 
{
	function __construct(){ 
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('usuarios_model');
		$this->load->model('vehiculosalquiler_model');
    $this->load->model('documentacion_model');
    $this->load->helper('date');
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

  function verifiddocVA()//2018
  {
    $iddocumento = $this->input->get('id');
    $datos = $this->vehiculosalquiler_model->verifiddocumentoVA($iddocumento);
    if($datos) echo 1;
    else echo 0; 

  }

	function validar($identidad)
	{
		
		$menu = $this->session->userdata('menu');
		$id = $this->session->userdata('idfuncionario');
		$dato['nombre_completo'] = $this->session->userdata('nombre_completo');
		$dato ['id']= $id;
		$dato ['identidad']= $identidad;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
		$dato['tipo_user'] = $this->session->userdata('tipo_user'); 
		$dato['title']= "Listado de Vehículos en Alquiler a Validar";
     $dato['aux']= 1; 
		$dato['filas'] = $this->vehiculosalquiler_model->select_validar($identidad);

		$this->load->view("inicio/cabecera",$dato); 
		$this->load->view("vehiculosalquiler/vehiculosalquilertab",$dato);
    $this->load->view("inicio/verdocumentos",$dato);
    $this->load->view("inicio/verpersonas",$dato);
    $this->load->view("inicio/sindocumento",$dato);
        $this->load->view("inicio/pie");
	}


	function validados($identidad)
	{
		
		$menu = $this->session->userdata('menu');
		$id = $this->session->userdata('idfuncionario');
		$dato['nombre_completo'] = $this->session->userdata('nombre_completo');
		$dato ['id']= $id;
		$dato ['identidad']= $identidad;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
		$dato['tipo_user'] = $this->session->userdata('tipo_user');
		$dato['title']= "Listado de Vehículos en Alquiler Validados";
     $dato['aux']= 2; 
$dato['filas'] = $this->vehiculosalquiler_model->select_validadas($identidad);

		$this->load->view("inicio/cabecera",$dato); 
  $this->load->view("vehiculosalquiler/vehiculosalquilertab",$dato);
    $this->load->view("inicio/verdocumentos",$dato);
    $this->load->view("inicio/verpersonas",$dato);
    $this->load->view("inicio/sindocumento",$dato);
        $this->load->view("inicio/pie");
	}
	

	 function info_inmueble()
        {
          // set_time_limit(500);
          $id = $this->input->get('idperson');
         // $id = 29335;
         // $dato['filas'] = $this->inmueble_model->get_inmueble($id);
          //$dato['persona'] = $this->consultas_model->get_ciudadano($idpersona);

          //$this->load->view("inmueble/info_inmueble",$dato);
          
          echo $id;
        }

    function getDatosvehiculosalquiler()
    {
    	 $id = $this->input->get('id');
    	 
    	 $datos = $this->vehiculosalquiler_model->selec_vehiculo_id($id);
    	 //echo $datos[0]->denominacion;
         $json = json_encode($datos); 
         echo $json;

         //echo $id."holaaa";
    }
    function getDatosEstado()
    {
    	 $id = $this->input->get('id');
    	 //$id = 37134;
    	 $datos = $this->inmuebles_model->getEstadoBien($id);
    	 echo $datos[0]->descripcion;
    }

    
    function getDocumentos()
    {
    	$id = $this->input->get('id');
    	//$estado = $this->input->get('estado');
    	 
    	// $id = 3847;
    	 $datos = $this->vehiculosalquiler_model->getTablaDocumentos($id);
    	  $options  = "<tr>";
    	  $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>";
    	 $options.= "</tr>";
           
          foreach($datos as $fila)
          {
          		$boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='verificarSiTieneValidacion(".$fila->id.")'>Ver</button>";
          		  $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",7)'> Per</button>";

                 if($fila->val == 'Validado' )
              {

              $options.= "<tr>";
                $options.= "<td  bgcolor='#D9EDF7'>".$boton."</td><td  bgcolor='#D9EDF7'>".$fila->id."</td><td  bgcolor='#D9EDF7'>".$fila->descripcion."</td><td  bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td  bgcolor='#D9EDF7'>".$fila->gestion."</td><td  bgcolor='#D9EDF7'>".$fila->registradopor."</td><td  bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr>";
              }
              else
              {
                
                  $options.= "<tr>";
                    $options.= "<td>".$boton."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td><td>".$fila->registradopor."</td><td>".$fila->val."</td><td>".$boton2."</td>";
                   $options.= "</tr>";
               }

          }     
       echo $options;	
    }

    function getDocumentoslistas($id,$doc)
    {
      //$id = $this->input->get('id');
      //$estado = $this->input->get('estado');
       
      // $id = 3847;
       $datos = $this->vehiculosalquiler_model->getTablaDocumentos($id);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>";
       $options.= "</tr>";
             
          foreach($datos as $fila)
          { 
            $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='verificarSiTieneValidacion(".$fila->id.")'>Ver</button>";
              $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",7)'> Per</button>";
               if($fila->val == 'Validado' && $fila->id != $doc)
              {

              $options.= "<tr>";
                $options.= "<td  bgcolor='#D9EDF7'>".$boton."</td><td  bgcolor='#D9EDF7'>".$fila->id."</td><td  bgcolor='#D9EDF7'>".$fila->descripcion."</td><td  bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td  bgcolor='#D9EDF7'>".$fila->gestion."</td><td  bgcolor='#D9EDF7'>".$fila->registradopor."</td><td  bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr>";
              }
              else
              {
                if($fila->id == $doc)
                {

                  $options.= "<tr>";
                    $options.= "<td bgcolor='#fbc361'>".$boton."</td><td bgcolor='#fbc361'>".$fila->id."</td><td bgcolor='#fbc361'>".$fila->descripcion."</td><td bgcolor='#fbc361'>".$fila->nrodocumento."</td><td bgcolor='#fbc361'>".$fila->gestion."</td><td bgcolor='#fbc361'>".$fila->registradopor."</td><td bgcolor='#fbc361'>".$fila->val."</td><td>".$boton2."</td>";
                   $options.= "</tr>";
                }
                else
                {
                  $options.= "<tr>";
                    $options.= "<td>".$boton."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td><td>".$fila->registradopor."</td><td>".$fila->val."</td><td>".$boton2."</td>";
                   $options.= "</tr>";}
               }

              
          }   
      return $options; 
    }


    function verificarValidacion()
    { 
    	$id = $this->input->get('id');

    	//$id = 1525;
    	$tipodoc=0;$nrodoc="";
    	if($datos = $this->vehiculosalquiler_model->getValidacionDocumento1($id))
    	{
    		    $tipodoc=$datos[0]->idtipodocumento;
             $nrodoc=$datos[0]->nrodocumento;
             $idbien=$datos[0]->idbien;
             $idb=$datos[0]->idb;
    	}
    	$lista = $this->getDocumentoslistas($idb,$id);

    	if($filas = $this->vehiculosalquiler_model->getValidacionDocumento2($id))
    	{
    		    

             $datos='{"tienevalidacion":"true",
                     "idvalidacion":"'.$filas[0]->id.'",
                     "corresponde":"'.$filas[0]->idcorrespondencia.'",
                     '. '"adjunta":"'.$filas[0]->adjunta.'",
                     "legible":"'.$filas[0]->legible.'",
                    "observaciones":"'.$filas[0]->observacionesgenerales.'",
                    '.'"nrodocumento":"'.$filas[0]->nrodocumento.'",
                    "correctodocumento":"'.$filas[0]->correctodocumento.'",
                    '. '"departamento":"'.$filas[0]->departamento.'",
                    "correctodepartamento":"'.$filas[0]->correctodepartamento.'",
                    '.'"direccion":"'.$filas[0]->direccion.'",
                        "correctodireccion":"'.$filas[0]->correctodireccion.'",
                    '.'"iniciocontrato":"'.$filas[0]->iniciocontrato.'",
                    "correctoiniciocontrato":"'.$filas[0]->correctoiniciocontrato.'",
                    '.'"fincontrato":"'.$filas[0]->fincontrato.'",
                    "correctofincontrato":"'.$filas[0]->correctofincontrato.'",
                    "canonalquiler":"'.$filas[0]->canonalquiler.'",
                    "correctocanonalquiler":"'.$filas[0]->correctocanonalquiler.'",
                    "observaciondetalle":"'.$filas[0]->observaciones.'",
                     "idtipodocumento":"'.$tipodoc.'","nrodoc":"'.$nrodoc.'","tabla":"'.$lista.'"}';//*/
	      
	          echo  $datos; 
    	}
    	else
    	{
    		$datos = '{"tienevalidacion":"false","idtipodocumento":"'.$tipodoc.'","nrodoc":"'.$nrodoc.'","tabla":"'.$lista.'"}';
    	 echo $datos;
      }
   }

    function obtenerObservaciones()
    {
      $options = "";
           $filas =  $this->vehiculosalquiler_model->getListaObservaciones();
          
          foreach($filas as $fila)
          {
               $options.= "<option value='".$fila->id."'>".$fila->descripcion."</option>";
          }     
          echo $options;
    }

     function bitacora($idBien,$idDocumento,$accion,$idb)
    {
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);

           $idusu = $this->session->userdata('idfuncionario');
           $datos = $this->vehiculosalquiler_model->getValidacionDocumento1($idDocumento);
           $adicionado = $datos[0]->adicionado;
           $tipodocumento=$datos[0]->idtipodocumento;
           $numero=$datos[0]->nrodocumento;
           $datos = $this->documentacion_model->getrubrobien2($idb);
           $entidad=$datos[0]->identidad;
           $bitacora = $this->documentacion_model->insertar_bitacora($accion,$idusu,$idBien,$idDocumento,$tipodocumento,$adicionado,7,$entidad,$numero,$fecha,$fecha,$idb);
           return 1;
    }

    function guardarvalidacion()
    {   
      $accion = $this->input->get('accionVehiculoAlquiler');
      
       $idDocumento = $this->input->get('txtIdDocumentoVehiculoAlquiler');
        $idB = $this->input->get('txtIdB');
        $idBien = $this->input->get('txtIdBienVehiculoAlquiler');
        $idGestion = GESTION;
            
        
        $idCorrespondencia = $this->input->get('cbCorrespondeVehiculoAlquiler');
        $adjunta = $this->input->get('cbAdjuntaVehiculoAlquiler');
        $legible = $this->input->get('cbLegibleVehiculoAlquiler');
        $idDocumentoBien = $this->input->get('txtIdDocumentoVehiculoAlquiler');
        $idTipoDocumento = $this->input->get('txtTipoDocumentoVehiculoAlquiler');
        if($this->input->get('txtObservacionesGeneralesVehiculoAlquiler')==''){
        $observaciones = "";
        }else{
        $observaciones = $this->input->get('txtObservacionesGeneralesVehiculoAlquiler');
        }
        
        
         $nroDocumentoPro = $this->input->get('txtNroDocumentoVehiculoAlquilerObservadoProv');
        $nroDocumentoOpcionPro = $this->input->get('cbNroDocumentoOpcionVehiculoAlquilerProv');
        
        
        $nroDocumentoOpcion = $this->input->get('cbNroDocumentoVehiculoAlquilerOpcion');
        $ciudadOpcion = $this->input->get('cbCiudadVehiculoAlquilerOpcion');
        $direccionOpcion = $this->input->get('cbDireccionVehiculoAlquilerOpcion');
        $inicioContratoOpcion = $this->input->get('cbInicioContratoVehiculoAlquilerOpcion');
        $finContratoOpcion = $this->input->get('cbFinContratoVehiculoAlquilerOpcion');
        $canonAlquilerOpcion = $this->input->get('cbCanonVehiculoAlquilerOpcion');
     
    
        $nroDocumento = $this->input->get('txtNroDocumentoVehiculoAlquilerObservado');
        
        $ciudad = $this->input->get('txtCiudadVehiculoAlquilerObservado');
        $direccion = $this->input->get('txtDireccionVehiculoAlquilerObservado');
        $inicioContrato = $this->input->get('txtInicioContratoVehiculoAlquilerObservado');
        $finContrato = $this->input->get('txtFinContratoVehiculoAlquilerObservado');
        $canonAlquiler = $this->input->get('txtCanonVehiculoAlquilerObservado');
        
        $listaObservaciones = $this->input->get('txtListaObservacionesVehiculoAlquiler');
        $tipodoc = 4;

       if( $accion == "guardarValidacion")
       
       {
       
          $idval = $this->vehiculosalquiler_model->guardarValidacion($idB,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones);
            if($adjunta == 't' && $idCorrespondencia == 1 && $legible == 't' )
            {
              if($idTipoDocumento==23)
              {
                 $update = $this->vehiculosalquiler_model->guardarDetalleValidacion($idval,$nroDocumento,$nroDocumentoOpcion,$ciudad,$ciudadOpcion,$direccion,$direccionOpcion,$inicioContrato,$inicioContratoOpcion,$finContrato,$finContratoOpcion,$canonAlquiler,$canonAlquilerOpcion);
                 $tipodoc = 1;
              }
              else
              {
                  $update = $this->vehiculosalquiler_model->guardarDetalleValidacion($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null,null,null);
                  $tipodoc = 2;
              }
            }


            if($listaObservaciones!="")
          {
             
             // $guardar = $this->inmuebles_model->guardarObservacionesValidacion($listaObservaciones,$idval);
            $valoresObservacion = explode("|", $listaObservaciones);
            $cantidad = count($valoresObservacion);
            //echo $cantidad;
            if($cantidad > 0)
            {
              if($listaObservaciones != "")
              {  
                $eliminar = $this->vehiculosalquiler_model->eliobservacion($idval);
               foreach ($valoresObservacion as $valor) 
               {
                  //echo "<br>";
                  //echo $valor;
                  $guardar = $this->vehiculosalquiler_model->guardarObservacionesValidacion($idval,$valor);
               } 
              } 
            }  
          
          } 
          else
          {
            $eliminar = $this->vehiculosalquiler_model->eliobservacion($idval);
          }
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
          $document = $this->documentacion_model->validarDocumentoalquilerinmueble($idDocumento,$idBien,$fecha,$tipodoc,$idB);
          $bitacora = $this->bitacora($idBien,$idDocumento,1,$idB);//BITACORA 
            
            $lista = $this->getDocumentoslistas($idB,$idDocumento);

           $tip = 1;
          $estadodevalidacion = $this->vehiculosalquiler_model->estadovalidacionbien($idB);
          $estado = $estadodevalidacion[0]->idestadovalidacion;

         
          $datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';
        //  $datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'"}';
         
          echo $datos; 
      
      }
      else
      {
         $idval = $this->input->get('txtIdValidacionVA');
        //$idval=287;
        
         $update = $this->vehiculosalquiler_model->editarValidacion($idval,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones);
          //if($adjunta=='t' && $legible=='t' && $idCorrespondencia==0)
        if($adjunta == 't' && $idCorrespondencia == 1 && $legible == 't' )
        {
            if($this->vehiculosalquiler_model->exitedetalleval($idval))
            { 
              if($idTipoDocumento==23)
              {
               // echo 1;
                 $update = $this->vehiculosalquiler_model->editarDetalleValidacion($idval,$nroDocumento,$nroDocumentoOpcion,$ciudad,$ciudadOpcion,$direccion,$direccionOpcion,$inicioContrato,$inicioContratoOpcion,$finContrato,$finContratoOpcion,$canonAlquiler,$canonAlquilerOpcion);
                 $tipodoc = 1;
              }
              else
              { 
                $update = $this->vehiculosalquiler_model->editarDetalleValidacion($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null,null,null);
                $tipodoc = 2;
              }
           }
           else
           {
              if($idTipoDocumento==23)
              {
                 $update = $this->vehiculosalquiler_model->guardarDetalleValidacion($idval,$nroDocumento,$nroDocumentoOpcion,$ciudad,$ciudadOpcion,$direccion,$direccionOpcion,$inicioContrato,$inicioContratoOpcion,$finContrato,$finContratoOpcion,$canonAlquiler,$canonAlquilerOpcion);
                 $tipodoc = 1;
              }
              else
              {
                  $update = $this->vehiculosalquiler_model->guardarDetalleValidacion($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null,null,null);
                  $tipodoc = 2;
              }
           }   

        }
        else
        {
          $update = $this->vehiculosalquiler_model->editarDetalleValidacion($idval,null,null,null,null,null,null,null,null,null,null,null,null);
        }
           
           if($listaObservaciones!="")
          {
             
             // $guardar = $this->inmuebles_model->guardarObservacionesValidacion($listaObservaciones,$idval);
            $valoresObservacion = explode("|", $listaObservaciones);
            $cantidad = count($valoresObservacion);
            //echo $cantidad;
            if($cantidad > 0)
            {
              if($listaObservaciones != "")
              {  
                $eliminar = $this->vehiculosalquiler_model->eliobservacion($idval);
               foreach ($valoresObservacion as $valor) 
               {
                  //echo "<br>";
                  //echo $valor;
                  $guardar = $this->vehiculosalquiler_model->guardarObservacionesValidacion($idval,$valor);
               }
              } 
            }  
          
          } 
          else
          {
            $eliminar = $this->vehiculosalquiler_model->eliobservacion($idval);
          }
      
         
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
          $document = $this->documentacion_model->validarDocumentoalquilerinmueble($idDocumento,$idBien,$fecha,$tipodoc,$idB);//*/
          $bitacora = $this->bitacora($idBien,$idDocumento,2,$idB);//BITACORA 

          $x= 2;
           $lista = $this->getDocumentoslistas($idB,$idDocumento);

           $tip = 2;
          $estadodevalidacion = $this->vehiculosalquiler_model->estadovalidacionbien($idB);
          $estado = $estadodevalidacion[0]->idestadovalidacion;

         
          $datos = '{"tabla":"'.$lista.'","aux":"'.$x.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';
          //$datos = '{"tabla":"'.$lista.'","aux":"'.$x.'"}';
         
          echo $datos; 
      }
  }
  function cccccc()
  {
    $datestring = " %Y-%m-%d %H:%i:%s";
    $time = time();
    $fecha =  mdate($datestring, $time);
    $update = $this->documentacion_model->validarDocumento(12871,20343,$fecha);
    echo $fecha;
  } 
   function guardarvalidacion2()
    {
       $idval = 8881;
      $nroDocumentoOpcion = "t";
      $nroDocumento = "594/91";
      $accion = "editarValidacion";
      $idCorrespondencia = 0;
      $adjunta = "t";
      $legible = "t";
      $idTipoDocumento = 3;
      
        
      //echo $accion;

      if($accion == "nuevaValidacion")
      {

      }
      else
      {
      
      // $update = $this->inmuebles_model->modificarvalidacion($idval,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones);
        //echo $idval."-".$idBien."-".$idGestion."-".$idCorrespondencia."-".$adjunta."-".$legible."-".$idDocumentoBien."-".$observaciones;

        
        if($adjunta=='t' && $legible=='t' && $idCorrespondencia==0)
        {
          if($idTipoDocumento==1 || $idTipoDocumento==2)
          {
              echo 1;
              $update = $this->inmuebles_model->editarDetalleValidacion($idTipoDocumento,$idval,$nroDocumento,$nroDocumentoOpcion,$superficie,$superficieOpcion,$catastro,$catastroOpcion,$denominacion,$denominacionOpcion,$direccion,$direccionOpcion);
          }
          else
          {
            
              $update = $this->inmuebles_model->editarDetalleValidacion($idval,$nroDocumento,$nroDocumentoOpcion,null,null,null,null,null,null,null,null);
           
             echo 2;
          }
        }
     
        
      //echo $accion;

            
       /* if($listaObservaciones!=""){
             $guardar = $this->inmuebles_model->guardarObservacionesValidacion($listaObservaciones,$idval);
        }  
        $this->documentacion_model->validarDocumento($idDocumento,$idBien);
        $this->inmuebles_model->guardarEstadoDocumentacionGeneral($idValidacion,1);

        */
      



      





      }


    }
  
}
?>