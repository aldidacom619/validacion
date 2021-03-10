<?php 
class Maquinariapesada extends CI_Controller 
{
  function __construct(){
    parent::__construct();
    $this->_is_logued_in();
    $this->load->model('usuarios_model');  
    $this->load->model('maquinariapesada_model');
    $this->load->model('inmuebles_model');
    $this->load->model('documentacion_model');
    $this->load->helper('date');
    $this->load->helper('validacion_helper');
  //  $this->load->helper('download');
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
function verifiddocMP()//2018
  {
    $iddocumento = $this->input->get('id');
    $datos = $this->maquinariapesada_model->verifiddocumentoMP($iddocumento);
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
    $dato['title']= "Maquinaria Pesada a Validar";
     $dato['aux']= 1; 
    $dato['filas'] = $this->maquinariapesada_model->select_validar($identidad);

    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("maquinariapesada/maquinariatab",$dato);
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
    $dato['title']= "Maquinaria Pesada Validada";
     $dato['aux']= 2; 
    $dato['filas'] = $this->maquinariapesada_model->select_validadas($identidad);

    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("maquinariapesada/maquinariatab",$dato);
    $this->load->view("inicio/verdocumentos",$dato);
    $this->load->view("inicio/verpersonas",$dato);
    $this->load->view("inicio/sindocumento",$dato);
    $this->load->view("inicio/pie");
  }
  function totalmaqp($identidad)//2018
  {
    
    $menu = $this->session->userdata('menu');
    $id = $this->session->userdata('idfuncionario');
    $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
    $dato ['id']= $id;
    $dato ['identidad']= $identidad;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
    $dato['tipo_user'] = $this->session->userdata('tipo_user');
    $dato['title']= "Total de Maquinarias Pesadas";
     $dato['aux']= 3; 
    $dato['filas'] = $this->maquinariapesada_model->select_totalmaqp($identidad);

    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("maquinariapesada/maquinariatab",$dato);
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

    function getDatosMaquinariaPesada()
    {
       $id = $this->input->get('id');
      // $id = 110888;
       $datos = $this->maquinariapesada_model->selec_maquinaria_id($id);
       //echo $datos[0]->denominacion;
       $json = json_encode($datos); 
        echo $json;

         //echo $id."holaaa";
    }
    function getDatosEstado()
    {
       $id = $this->input->get('id');
       
       $id = 37134;
       $datos = $this->maquinariapesada_model->getEstadoBien($id);
       echo $datos[0]->descripcion;
    }

    function getDocumentos()
    {
      $id = $this->input->get('id'); 


      //$estado = $this->input->get('estado');
       
     
       $datos = $this->maquinariapesada_model->getTablaDocumentos($id);
        $options  = "<tr>";
          $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>";
       $options.= "</tr>";
      
           
          foreach($datos as $fila)
          {
              
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='verificarSiTieneValidacionMaquinariaPesada(".$fila->id.")'>Ver</button>";
                $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",6)'> Per</button>";
              
              if($fila->val == 'Validado')
              {

                $options.= "<tr>";
                $options.= "<td bgcolor='#D9EDF7' >".$boton."</td><td bgcolor='#D9EDF7'>".$fila->id."</td><td bgcolor='#D9EDF7'>".$fila->descripcion."</td><td bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td bgcolor='#D9EDF7'>".$fila->gestion."</td><td bgcolor='#D9EDF7'> ".$fila->registradopor."</td><td bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
                $options.= "</tr>";
             }
             else
             {
               $options.= "<tr>";
                $options.= "<td >".$boton."</td><td >".$fila->id."</td><td >".$fila->descripcion."</td><td >".$fila->nrodocumento."</td><td >".$fila->gestion."</td><td > ".$fila->registradopor."</td><td >".$fila->val."</td><td>".$boton2."</td>";
                $options.= "</tr>";
             }
          }    
          
      
       echo $options; 
    }
    function getDocumentoslistas($id,$doc)
    {
      //$id = $this->input->get('id');
      //$estado = $this->input->get('estado');
       
     // $id = 183307;
       $datos = $this->maquinariapesada_model->getTablaDocumentos($id);
        $options  = "<tr>";
         $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>"; 
       $options.= "</tr>";
           
          foreach($datos as $fila  )
          {

              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='verificarSiTieneValidacionMaquinariaPesada(".$fila->id.")'>Ver</button>";
              $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",6)'> Per</button>";
              if($fila->val == 'Validado'&& $fila->id != $doc)
              {

                $options.= "<tr>";
                $options.= "<td bgcolor='#D9EDF7' >".$boton."</td><td bgcolor='#D9EDF7'>".$fila->id."</td><td bgcolor='#D9EDF7'>".$fila->descripcion."</td><td bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td bgcolor='#D9EDF7'>".$fila->gestion."</td><td bgcolor='#D9EDF7'> ".$fila->registradopor."</td><td bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
                $options.= "</tr>";
              }
              else
             {
                 if($fila->id == $doc)
                {
                     $options.= "<tr>";
                $options.= "<td bgcolor='#fbc361' >".$boton."</td><td bgcolor='#fbc361'>".$fila->id."</td><td bgcolor='#fbc361'>".$fila->descripcion."</td><td bgcolor='#fbc361'>".$fila->nrodocumento."</td><td bgcolor='#fbc361'>".$fila->gestion."</td><td bgcolor='#fbc361'> ".$fila->registradopor."</td><td bgcolor='#fbc361'>".$fila->val."</td><td>".$boton2."</td>";
                $options.= "</tr>";
                }
                else
                {
                $options.= "<tr>";
                $options.= "<td >".$boton."</td><td >".$fila->id."</td><td >".$fila->descripcion."</td><td >".$fila->nrodocumento."</td><td >".$fila->gestion."</td><td > ".$fila->registradopor."</td><td >".$fila->val."</td><td>".$boton2."</td>";
                $options.= "</tr>";
                }
             }

          }     
     
      return $options; 
    }
    function verificarValidacion()
    {
      $id = $this->input->get('id');

     
      $tipodoc=0;$nrodoc="";
      if($datos = $this->maquinariapesada_model->getValidacionDocumento1($id))
      {
             $tipodoc=$datos[0]->idtipodocumento;
             $nrodoc=$datos[0]->nrodocumento;
             $gestion_doc = $datos[0]->gestion;
             $idbien = $datos[0]->idbien;
             $idb = $datos[0]->idb;
      }
      $lista = $this->getDocumentoslistas($idb,$id);
      
      if($filas = $this->maquinariapesada_model->getValidacionDocumento2($id,$gestion_doc))
      {
        
             $datos='{"tienevalidacion":"true","idvalidacion":"'.$filas[0]->id.'",
                        "corresponde":"'.$filas[0]->idcorrespondencia.'",'
                        . '"adjunta":"'.$filas[0]->adjunta.'",
                        "legible":"'.$filas[0]->legible.'",
                        "observaciones":"'.$filas[0]->observacionesgenerales.'",
                        '. '"nrodocumento":"'.$filas[0]->nrodocumento.'",
                        "correctodocumento":"'.$filas[0]->correctodocumento.'",
                        '. '"descripcion":"'.$filas[0]->descripcion.'",
                        "correctodescripcion":"'.$filas[0]->correctodescripcion.'",
                        '. '"marca":"'.$filas[0]->marca.'",
                        "correctomarca":"'.$filas[0]->correctomarca.'",
                        '. '"modelo":"'.$filas[0]->modelo.'",
                        "correctomodelo":"'.$filas[0]->correctomodelo.'",
                        '. '"nrochasis":"'.$filas[0]->nrochasis.'",
                        "correctonrochasis":"'.$filas[0]->correctonrochasis.'",
                        '. '"nromotor":"'.$filas[0]->nromotor.'",
                        "correctonromotor":"'.$filas[0]->correctonromotor.'",
                        '. '"color":"'.$filas[0]->color.'",
                        "correctocolor":"'.$filas[0]->correctocolor.'",
                        "observaciondetalle":"'.$filas[0]->observaciones.'",
                        "idtipodocumento":"'.$tipodoc.'",
                        "nrodoc":"'.$nrodoc.'",
                      "tabla":"'.$lista.'"}';
                
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
           $filas =  $this->maquinariapesada_model->getListaObservaciones();
           
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
           $datos = $this->inmuebles_model->getValidacionDocumento1($idDocumento);
           $adicionado = $datos[0]->adicionado;
           $tipodocumento=$datos[0]->idtipodocumento;
           $numero=$datos[0]->nrodocumento;
           $datos = $this->documentacion_model->getrubrobien($idb);
           $rubro=$datos[0]->idclase;
           $entidad=$datos[0]->identidad;
           $bitacora = $this->documentacion_model->insertar_bitacora($accion,$idusu,$idBien,$idDocumento,$tipodocumento,$adicionado,$rubro,$entidad,$numero,$fecha,$fecha,$idb);
           return 1;
    }

    function guardarvalidacion()
    {
      $accion = $this->input->get('accionMP');

      $idDocumentoBien =  $this->input->get('txtIdDocumentoMaquinariaPesada');
      $idval =  $this->input->get('txtIdValidacionMaquinariaPesada');
      $idBien = $this->input->get('txtIdBienMaquinariaPesada');
      $idB = $this->input->get('txtIdBMP');
      $idGestion = GESTION;
      $idCorrespondencia =  $this->input->get('cbCorrespondeMaquinariaPesada');
      $adjunta = $this->input->get('cbAdjuntaMaquinariaPesada');
      $legible = $this->input->get('cbLegibleMaquinariaPesada');
      $observaciones= $this->input->get('txtObservacionesMaquinariaPesada');
      $idTipoDocumento = $this->input->get('txtTipoDocumentoMaquinariaPesada');
      $estadoDocumentacion = $this->input->get('cbEstadoDocumentacionMaquinariaPesada');
      $listaObservaciones= $this->input->get('txtListaObservacionesMaquinariaPesada'); 

        $NroDocumento= $this->input->get('txtNroDocumentoMaquinariaPesadaObservado');
        $Descripcion= $this->input->get('txtEquipoMaquinariaPesadaObservado');
        $Marca= $this->input->get('txtMarcaMaquinariaPesadaObservado');
        $Modelo= $this->input->get('txtModeloMaquinariaPesadaObservado');
        $NroChasis= $this->input->get('txtChasisMaquinariaPesadaObservado');
        $NroMotor= $this->input->get('txtMotorMaquinariaPesadaObservado');
        $Color= $this->input->get('txtColorMaquinariaPesadaObservado');
        $CorrectoDocumento= $this->input->get('cbNroDocumentoMaquinariaPesadaOpcion');
        //$CorrectoDocumento                   
        $CorrectoDescripcion= $this->input->get('cbEquipoMaquinariaPesadaOpcion');
        $CorrectoMarca= $this->input->get('cbMarcaMaquinariaPesadaOpcion');
        $CorrectoModelo= $this->input->get('cbModeloMaquinariaPesadaOpcion');
        $CorrectoNroChasis= $this->input->get('cbChasisMaquinariaPesadaOpcion');
        $CorrectoNroMotor= $this->input->get('cbMotorMaquinariaPesadaOpcion');
        $CorrectoColor= $this->input->get('cbColorMaquinariaPesadaOpcion');

          $NroDocumentoprov = $this->input->get('txtNroDocumentoMPObservadoProv');
        $CorrectoDocumentoprov = $this->input->get('cbNroDocumentoOpcionMPProv');
       
      $tipodoc = 4;

        if($accion == "nuevaValidacion")
      //if (1 == 1)
      {
          $idval = $this->maquinariapesada_model->guardarValidacionmaquinariapesada($idB,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$observaciones,$idDocumentoBien);
         
        // $idval = 1323;
         

           if($adjunta=='t' && $legible=='t' && $idCorrespondencia==0)
            {
                
             //if (1 == 1)
              if($idTipoDocumento==7)
              {  
                     $update = $this->maquinariapesada_model->guardarDetalleValidacionmaquinariapesada($idval,$NroDocumento,$Descripcion,$Marca,$Modelo,$NroChasis,$NroMotor,$Color,$CorrectoDocumento,$CorrectoDescripcion,$CorrectoMarca,$CorrectoModelo,$CorrectoNroChasis,$CorrectoNroMotor,$CorrectoColor);
                     $tipodoc = 1;
              }
              else
              {
                  $update = $this->maquinariapesada_model->guardarDetalleValidacionmaquinariapesada($idval,
                    $NroDocumentoprov,null,null,null,null,null,null,$CorrectoDocumentoprov,null,null,null,null,null,null);
                  $tipodoc = 2;
              }//*/
               
            }

         
           
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
          
          $document = $this->documentacion_model->validarDocumento($idDocumentoBien,$idBien,$fecha,$tipodoc,$idB);//
           
          if($listaObservaciones!="")
            {
                 $valoresObservacion = explode("|", $listaObservaciones);
                  $cantidad = count($valoresObservacion);
                 
                  if($cantidad > 0)
                  {
                    if($listaObservaciones != "")
                    {  
                      $eliminar = $this->maquinariapesada_model->eliobservacion($idval);
                     foreach ($valoresObservacion as $valor) 
                     {
                       
                        $guardar = $this->maquinariapesada_model->guardarObservacionesValidacion($idval,$valor);
                     }
                    } 
                  }  
            
            } 
            else
            {
               $eliminar = $this->maquinariapesada_model->eliobservacion($idval);
            }
            //echo $listaObservaciones;
            //$x= 2;
          
          $lista = $this->getDocumentoslistas($idB,$idDocumentoBien);
         $bitacora = $this->bitacora($idBien,$idDocumentoBien,1,$idB);//BITACORA 
          $tip = 1;
          $estadodevalidacion = $this->maquinariapesada_model->estadovalidacionbien($idB);
          $estado = $estadodevalidacion[0]->idestadovalidacion;

         
          $datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';
          //$datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'"}';
         echo $datos;/*/
          //echo $idval; 
          //echo 2;*/
      }
      else
      {
        
         $update = $this->maquinariapesada_model->modificarvalidacionmaquinariapesada($idval,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$observaciones,$idDocumentoBien);
          if($adjunta=='t' && $legible=='t' && $idCorrespondencia==0)
          {
            if($this->maquinariapesada_model->exitedetalleval($idval))
            { 
              if($idTipoDocumento==7 )
              {
                
                 $update = $this->maquinariapesada_model->editarDetalleValidacionmaquinariapesada($idval,$NroDocumento,$Descripcion,$Marca,$Modelo,$NroChasis,$NroMotor,$Color,$CorrectoDocumento,$CorrectoDescripcion,$CorrectoMarca,$CorrectoModelo,$CorrectoNroChasis,$CorrectoNroMotor,$CorrectoColor);
                //echo $idval;
                 $tipodoc = 1;

              }
              else
              {
                 $update = $this->maquinariapesada_model->editarDetalleValidacionmaquinariapesada($idval,
                      $NroDocumentoprov,null,null,null,null,null,null,$CorrectoDocumentoprov,null,null,null,null,null,null);
                 $tipodoc = 2;
              }
            }
            else
            {
                if($idTipoDocumento==7)
                {  
                       $update = $this->maquinariapesada_model->guardarDetalleValidacionmaquinariapesada($idval,$NroDocumento,$Descripcion,$Marca,$Modelo,$NroChasis,$NroMotor,$Color,$CorrectoDocumento,$CorrectoDescripcion,$CorrectoMarca,$CorrectoModelo,$CorrectoNroChasis,$CorrectoNroMotor,$CorrectoColor);
                       $tipodoc = 1;
                }
                else
                {
                    $update = $this->maquinariapesada_model->guardarDetalleValidacionmaquinariapesada($idval,
                      $NroDocumentoprov,null,null,null,null,null,null,$CorrectoDocumentoprov,null,null,null,null,null,null);
                    $tipodoc = 2;
                }//*/
            }  

          }
          else{
            if($this->maquinariapesada_model->exitedetalleval($idval))
            { 
              if($idTipoDocumento==7 )
              {
                
                 $update = $this->maquinariapesada_model->editarDetalleValidacionmaquinariapesada($idval,$NroDocumento,$Descripcion,$Marca,$Modelo,$NroChasis,$NroMotor,$Color,$CorrectoDocumento,$CorrectoDescripcion,$CorrectoMarca,$CorrectoModelo,$CorrectoNroChasis,$CorrectoNroMotor,$CorrectoColor);
                //echo $idval;
                 $tipodoc = 1;

              }
              else
              {
                 $update = $this->maquinariapesada_model->editarDetalleValidacionmaquinariapesada($idval,
                      $NroDocumentoprov,null,null,null,null,null,null,null,null,null,null,null,null,null);
                 $tipodoc = 2;
              }
            }
            else
            {
                if($idTipoDocumento==7)
                {  
                       $update = $this->maquinariapesada_model->guardarDetalleValidacionmaquinariapesada($idval,$NroDocumento,$Descripcion,$Marca,$Modelo,$NroChasis,$NroMotor,$Color,$CorrectoDocumento,$CorrectoDescripcion,$CorrectoMarca,$CorrectoModelo,$CorrectoNroChasis,$CorrectoNroMotor,$CorrectoColor);
                       $tipodoc = 1;
                }
                else
                {
                    $update = $this->maquinariapesada_model->guardarDetalleValidacionmaquinariapesada($idval,
                      $NroDocumentoprov,null,null,null,null,null,null,null,null,null,null,null,null,null);
                    $tipodoc = 2;
                }//*/
            }
          }
         
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
          if($listaObservaciones!="")
            {
                 $valoresObservacion = explode("|", $listaObservaciones);
                  $cantidad = count($valoresObservacion);
                 
                  if($cantidad > 0)
                  {
                    if($listaObservaciones != "")
                    {  
                      $eliminar = $this->maquinariapesada_model->eliobservacion($idval);
                     foreach ($valoresObservacion as $valor) 
                     {
                       
                        $guardar = $this->maquinariapesada_model->guardarObservacionesValidacion($idval,$valor);
                     }
                    } 
                  }  
            
            } 
            else
            {
               $eliminar = $this->maquinariapesada_model->eliobservacion($idval);
            }
          $document = $this->documentacion_model->validarDocumento($idDocumentoBien,$idBien,$fecha,$tipodoc,$idB);//
          $bitacora = $this->bitacora($idBien,$idDocumentoBien,2,$idB);//BITACORA 
          $x= 2;
         $lista = $this->getDocumentoslistas($idB,$idDocumentoBien);
         $tip = 2;
         
          $estadodevalidacion = $this->maquinariapesada_model->estadovalidacionbien($idB);
          $estado = $estadodevalidacion[0]->idestadovalidacion;
          $datos = '{"tabla":"'.$lista.'","aux":"'.$x.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';
          //$datos = '{"tabla":"'.$lista.'","aux":"'.$x.'"}';
         
          echo $datos; //*/
          //echo 2;
          //echo 2;
      }
     
      

  }
  function pruebas()
  {

    $update = $this->maquinariapesada_model->guardarDetalleValidacionmaquinariapesada(1380,
                    null,null,null,null,null,null,null,null,null,null,null,null,null,null);
  } 
   function guardarvalidacion2()
    {
       $idval = 1331;
      $nroDocumentoOpcion = "t";
      $nroDocumento = "594/91";
      $accion = "editarValidacion";
      $idCorrespondencia = 0;
      $adjunta = "t";
      $legible = "t";
      $idTipoDocumento = 3;
      
     $update = $this->maquinariapesada_model->guardarDetalleValidacionmaquinariapesada($idval,$NroDocumento,$Descripcion,$Marca,$Modelo,$NroChasis,$NroMotor,$Color,$CorrectoDocumento,$CorrectoDescripcion,$CorrectoMarca,$CorrectoModelo,$CorrectoNroChasis,$CorrectoNroMotor,$CorrectoColor);

     $update = $this->maquinariapesada_model->editarDetalleValidacionmaquinariapesada(1336,
                    'f',null,null,null,null,null,null,null,null,null,null,null,null,null);

     
      //echo $accion;

      /*if($accion == "nuevaValidacion")
      {

      }
      else
      {
      
      // $update = $this->inmuebles_model->modificarvalidacion($idval,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones);
        //echo $idval."-".$idBien."-".$idGestion."-".$idCorrespondencia."-".$adjunta."-".$legible."-".$idDocumentoBien."-".$observaciones;

       /* 
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
?>