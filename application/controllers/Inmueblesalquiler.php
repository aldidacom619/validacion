<?php 
class Inmueblesalquiler extends CI_Controller 
{
	function __construct(){
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('usuarios_model');
		$this->load->model('inmueblesalquiler_model');
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
 function verifiddocIA()//2018
  {
    $iddocumento = $this->input->get('id');
    $datos = $this->inmueblesalquiler_model->verifiddocumentoIA($iddocumento);
    if($datos) echo 1;
    else echo 0; 

  }

  function tablasinmuebles($identidad)
  {
        $menu = $this->session->userdata('menu');
    $id = $this->session->userdata('idfuncionario');
    $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
    $dato ['id']= $id;
    $dato ['identidad']= $identidad;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
    $dato['tipo_user'] = $this->session->userdata('tipo_user');
   $dato['title']= "Listado de Inmuebles Alquiler a Validar";
    $dato['aux']= 1; 
    $dato['filas'] = $this->inmuebles_model->select_validar($identidad);
    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("inmuebles/validar");
    $this->load->view("inicio/sindocumento",$dato);
        $this->load->view("inicio/verpersonas",$dato);
    $this->load->view("inicio/sindocumento",$dato);
    $this->load->view("inicio/pie");
  }  
  function listainmuebles()
  {
     $identidad = $this->input->get('id');
     $dato['filas'] = $this->inmuebles_model->select_validar($identidad);
     $this->load->view("inmuebles/val",$dato);
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
		$dato['title']= "Listado de Inmuebles Alquiler a Validar";
    $dato['aux']= 1; 
		$dato['filas'] = $this->inmueblesalquiler_model->select_validar($identidad);

		$this->load->view("inicio/cabecera",$dato); 
		$this->load->view("inmueblesalquiler/inmueblesalquilertab",$dato);
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
		$dato['title']= "Listado de Inmuebles Alquiler Validados";
		$dato['filas'] = $this->inmueblesalquiler_model->select_validadas($identidad);
    $dato['aux']= 2; 
		$this->load->view("inicio/cabecera",$dato); 
		$this->load->view("inmueblesalquiler/inmueblesalquilertab",$dato);
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

    function getDatosInmueblealquiler()
    {
    	 $id = $this->input->get('id');
    	 //$id = 37134;
      //  $id = 3847;
    	 $datos = $this->inmueblesalquiler_model->selec_inmueble_id($id);
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
    	 $datos = $this->inmueblesalquiler_model->getTablaDocumentos($id);
    	  $options  = "<tr>";
    	  $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>";
    	 $options.= "</tr>";
           
          foreach($datos as $fila)
          {
          		$boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='verificarSiTieneValidacionIA(".$fila->id.")'>Ver</button>";
               $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",5)'> Per</button>";
          	if($fila->val == 'Validado')
              {
                $options.= "<tr>";
                $options.= "<td bgcolor='#D9EDF7'>".$boton."</td><td bgcolor='#D9EDF7'>".$fila->id."</td><td bgcolor='#D9EDF7'>".$fila->descripcion."</td><td bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td bgcolor='#D9EDF7'>".$fila->gestion."</td><td bgcolor='#D9EDF7'>".$fila->registradopor."</td><td bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
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
       $datos = $this->inmueblesalquiler_model->getTablaDocumentos($id);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>";
       $options.= "</tr>";
           
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='verificarSiTieneValidacionIA(".$fila->id.")'>Ver</button>";
                $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",5)'> Per</button>";
              if($fila->val == 'Validado' && $fila->id != $doc)
              {
                $options.= "<tr>";
                $options.= "<td bgcolor='#D9EDF7'>".$boton."</td><td bgcolor='#D9EDF7'>".$fila->id."</td><td bgcolor='#D9EDF7'>".$fila->descripcion."</td><td bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td bgcolor='#D9EDF7'>".$fila->gestion."</td><td bgcolor='#D9EDF7'>".$fila->registradopor."</td><td bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
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
                $options.= "</tr>";
                }
              }
          }     
       return $options; 
    }
    function verificarValidacion() 
    {
    	$id = $this->input->get('id');

    	//$id = 289415;
    	$tipodoc=0;$nrodoc="";
    	if($datos = $this->inmueblesalquiler_model->getValidacionDocumento1($id))
    	{
    		    $tipodoc=$datos[0]->idtipodocumento;
             $nrodoc=$datos[0]->nrodocumento;
             $idbien=$datos[0]->idbien;
             $idb=$datos[0]->idb;
    	}
 
    	$lista = $this->getDocumentoslistas($idb,$id);

    	if($filas = $this->inmueblesalquiler_model->getValidacionDocumento2($id))
    	{
    		
            



            $datos='{"tienevalidacion":"true","idvalidacion":"'.$filas[0]->id.'",
                                "corresponde":"'.$filas[0]->idcorrespondencia.'",'
                        . '"adjunta":"'.$filas[0]->adjunta.'",
                        "legible":"'.$filas[0]->legible.'",
                        "observaciones":"'.$filas[0]->observacionesgenerales.'",
                        '.'"nrodocumento":"'.$filas[0]->nrodocumento.'",
                        "correctodocumento":"'.$filas[0]->correctodocumento.'",
                        '. '"direccion":"'.$filas[0]->direccion.'",
                        "correctodireccion":"'.$filas[0]->correctodireccion.'",
                        '. '"departamento":"'.$filas[0]->departamento.'",
                        "correctodepartamento":"'.$filas[0]->correctodepartamento.'",
                        '. '"iniciocontrato":"'.$filas[0]->iniciocontrato.'",
                        "correctoiniciocontrato":"'.$filas[0]->correctoiniciocontrato.'",
                        '. '"fincontrato":"'.$filas[0]->fincontrato.'",
                        "correctofincontrato":"'.$filas[0]->correctofincontrato.'",
                        "canonalquiler":"'.$filas[0]->canonalquiler.'",
                        "correctocanonalquiler":"'.$filas[0]->correctocanonalquiler.'",
                        "observaciondetalle":"'.$filas[0]->observaciones.'",
                        "idtipodocumento":"'.$tipodoc.'","nrodoc":"'.$nrodoc.'","tabla":"'.$lista.'"}';//*/
	       // echo  $filas[0]->id;*/
	        echo  $datos;
          //echo $nrodoc;
	        
    	}
    	else
    	{
    		/*$datos = array(
			'tienevalidacion' => false,
			'idtipodocumento' => $tipodoc,
			'nrodoc' => $nrodoc
			
			);*/
    		$datos = '{"tienevalidacion":"false","idtipodocumento":"'.$tipodoc.'","nrodoc":"'.$nrodoc.'","tabla":"'.$lista.'"}';
    	 echo $datos;
       //  echo $nrodoc;
    		
    	}
		//echo $datos;
    	//$json = json_encode($datos); 
        //echo $json;
         //echo $datos;
         //echo $filas;
	
    	 
    	
    
    }
    function obtenerObservaciones()
    {
           $filas =  $this->inmueblesalquiler_model->getListaObservaciones();
           
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
           $datos = $this->inmueblesalquiler_model->getValidacionDocumento1($idDocumento);
           $adicionado = $datos[0]->adicionado;
           $tipodocumento=$datos[0]->idtipodocumento;
           $numero=$datos[0]->nrodocumento;
           $datos = $this->documentacion_model->getrubrobien2($idb);
           $entidad=$datos[0]->identidad;
           $bitacora = $this->documentacion_model->insertar_bitacora($accion,$idusu,$idBien,$idDocumento,$tipodocumento,$adicionado,5,$entidad,$numero,$fecha,$fecha,$idb);
           return 1;
    }


    function guardarvalidacion()
    { 
      $accion = $this->input->get('accionIA');
     
        $idDocumento = $this->input->get('txtIdDocumentoIA');
        $idBien = $this->input->get('txtIdBienInmuebleAlquiler');
        $idB = $this->input->get('txtIdB');
        $idGestion = GESTION;
        $idCorrespondencia = $this->input->get('cbCorrespondeInmuebleAlquiler');
        $adjunta = $this->input->get('cbAdjuntaInmuebleAlquiler');
        $legible = $this->input->get('cbLegibleInmuebleAlquiler');
        $idDocumentoBien = $this->input->get('txtIdDocumentoIA');
        $observaciones =$this->input->get('txtObservacionesInmueblesAlquiler');

        $idval  =$this->input->get('txtIdValidacionIA');
        $idTipoDocumento = $this->input->get('txtTipoDocumentoIA');
        $estadoDocumentacion = $this->input->get('cbEstadoDocumentacionInmuebleAlquiler');
        $nroDocumentoOpcion = $this->input->get('cbNroDocumentoIAOpcion');
        $departamentoOpcion = $this->input->get('cbDepartamentoIAOpcion');
        $direccionOpcion = $this->input->get('cbDireccionIAOpcion');
        $inicioContratoOpcion = $this->input->get('cbInicioContratoIAOpcion');
        $conclusionContratoOpcion = $this->input->get('cbConclusionContratoIAOpcion');
        $canonOpcion = $this->input->get('cbCanonIAOpcion');
        $nroDocumento = $this->input->get('txtNroDocumentoIAObservado');
        $nroDocumentoPro = $this->input->get('txtNroDocumentoIAObservadoProv');
        $nroDocumentoOpcionPro = $this->input->get('cbNroDocumentoIAOpcionProv');
        $departamento = $this->input->get('txtDepartamentoIAObservado');
        $direccion = $this->input->get('txtDireccionIAObservado');
        $inicioContrato = $this->input->get('txtInicioContratoIAObservado');
        $conclusionContrato = $this->input->get('txtConclusionContratoIAObservado');
        $canon = $this->input->get('txtCanonIAObservado');
        $listaObservaciones = $this->input->get('txtListaObservacionesIA');
        $tipodoc = 4;
     
     //$idBien = 3847;

      //$idTipoDocumento = 23;
       if( $accion == "nuevaValidacion")
      {
            $idval = $this->inmueblesalquiler_model->guardarValidacion($idB,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones);

            if($adjunta=='t' && $legible=='t' && $idCorrespondencia==0)

            {
              if($idTipoDocumento==23)
              {
               
                  $update = $this->inmueblesalquiler_model->guardarDetalleValidacion($idval,$nroDocumento, $nroDocumentoOpcion,$departamento,$departamentoOpcion,$direccion,$direccionOpcion,$inicioContrato,$inicioContratoOpcion,$conclusionContrato, $conclusionContratoOpcion,$canon,$canonOpcion);
                  $tipodoc = 1;
              }
              else
              {
               
                  $update = $this->inmueblesalquiler_model->guardarDetalleValidacion($idval,$nroDocumentoPro, $nroDocumentoOpcionPro,null,null,null,null,null,null,null,null,null,null);
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
                $eliminar = $this->inmueblesalquiler_model->eliobservacion($idval);
               foreach ($valoresObservacion as $valor) 
               {
                  //echo "<br>";
                  //echo $valor;
                  $guardar = $this->inmueblesalquiler_model->guardarObservacionesValidacion($idval,$valor);
               }
              } 
            }  
          
          } 
          else
          {
                $eliminar = $this->inmueblesalquiler_model->eliobservacion($idval);
          }
         
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
          $document = $this->documentacion_model->validarDocumentoalquilerinmueble($idDocumento,$idBien,$fecha,$tipodoc,$idB);
          $bitacora = $this->bitacora($idBien,$idDocumento,1,$idB);//BITACORA 
          $lista = $this->getDocumentoslistas($idB,$idDocumento);

          $tip = 1;
          $estadodevalidacion = $this->inmueblesalquiler_model->estadovalidacionbien($idB);
          $estado = $estadodevalidacion[0]->idestadovalidacion;

         
          $datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';

          //$datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'"}';
         
          echo $datos; 
       
      }
      else
      {
        //$idval=287;
        
         $update = $this->inmueblesalquiler_model->editarValidacion($idval,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones);
          //if($adjunta=='t' && $legible=='t' && $idCorrespondencia==0)
         if($adjunta=='t' && $legible=='t' && $idCorrespondencia==0)
          {
            if($this->inmueblesalquiler_model->exitedetalleval($idval))
            { 
              if($idTipoDocumento==23 )
              {
                 // echo 1;
                  $update = $this->inmueblesalquiler_model->editarDetalleValidacion($idval,$nroDocumento, $nroDocumentoOpcion,$departamento,$departamentoOpcion,$direccion,$direccionOpcion,$inicioContrato,$inicioContratoOpcion,$conclusionContrato, $conclusionContratoOpcion,$canon,$canonOpcion);
                  $tipodoc = 1;
              }
              else
              {
                
                 $update = $this->inmueblesalquiler_model->editarDetalleValidacion($idval,$nroDocumentoPro, $nroDocumentoOpcionPro,null,null,null,null,null,null,null,null,null,null);
                 $tipodoc = 2;
              }
            }
            else
            {
                if($idTipoDocumento==23)
                {
                 
                    $update = $this->inmueblesalquiler_model->guardarDetalleValidacion($idval,$nroDocumento, $nroDocumentoOpcion,$departamento,$departamentoOpcion,$direccion,$direccionOpcion,$inicioContrato,$inicioContratoOpcion,$conclusionContrato, $conclusionContratoOpcion,$canon,$canonOpcion);
                    $tipodoc = 1;
                }
                else
                {
                 
                    $update = $this->inmueblesalquiler_model->guardarDetalleValidacion($idval,$nroDocumentoPro, $nroDocumentoOpcionPro,null,null,null,null,null,null,null,null,null,null);
                    $tipodoc = 2;
                 
                }
            }  
          }
          else
          {
            $update = $this->inmueblesalquiler_model->editarDetalleValidacion($idval,null, null,null,null,null,null,null,null,null,null,null,null);
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
                $eliminar = $this->inmueblesalquiler_model->eliobservacion($idval);
               foreach ($valoresObservacion as $valor) 
               {
                  //echo "<br>";
                  //echo $valor;
                  $guardar = $this->inmueblesalquiler_model->guardarObservacionesValidacion($idval,$valor);
               }
              } 
            }  
          
          } 
            else
          {
             
                $eliminar = $this->inmueblesalquiler_model->eliobservacion($idval);
          }
         
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
          $document = $this->documentacion_model->validarDocumentoalquilerinmueble($idDocumento,$idBien,$fecha,$tipodoc,$idB);
        // $this->inmuebles_model->guardarEstadoDocumentacionGeneral($idValidacion,1);
          $bitacora = $this->bitacora($idBien,$idDocumento,2,$idB);//BITACORA 
          $x= 2;
           $lista = $this->getDocumentoslistas($idB,$idDocumento);

            $tip = 2;
          $estadodevalidacion = $this->inmueblesalquiler_model->estadovalidacionbien($idB);
          $estado = $estadodevalidacion[0]->idestadovalidacion;

         
          $datos = '{"tabla":"'.$lista.'","aux":"'.$x.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';
          //$datos = '{"tabla":"'.$lista.'","aux":"'.$x.'"}';
         
          echo $datos; 
          
      }
     
      //echo 1;

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