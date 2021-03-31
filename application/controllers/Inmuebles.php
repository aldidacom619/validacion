<?php 
class Inmuebles extends CI_Controller 
{
  function __construct(){
    parent::__construct();
    $this->_is_logued_in();
    $this->load->model('usuarios_model');
    $this->load->model('inmuebles_model');
      $this->load->model('entidades_model');
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
 
  function tablasinmuebles($identidad)
  {
    $menu = $this->session->userdata('menu');
    $id = $this->session->userdata('idfuncionario');
    $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
    $dato ['id']= $id;
    $dato ['identidad']= $identidad;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
    $dato['tipo_user'] = $this->session->userdata('tipo_user');
    $dato['title']= "Listado de Inmuebles para su Validación";
    $dato['aux']= 1; 
    $dato['filas'] = $this->inmuebles_model->select_validar($identidad);
    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("inmuebles/validar");
    $this->load->view("inicio/verdocumentos",$dato);
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
    $dato['title']= "Listado de Inmuebles para su Validación";
    $dato['aux']= 1;  
    $dato['filas'] = $this->inmuebles_model->select_validar($identidad);


    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("inmuebles/validar",$dato);
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
    $dato['title']= "Listado de Inmuebles Validados";
    $dato['aux']= 2;  
    $dato['filas'] = $this->inmuebles_model->select_validadas($identidad);

    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("inmuebles/validar",$dato);
    $this->load->view("inicio/verdocumentos",$dato);
    $this->load->view("inicio/verpersonas",$dato);
    $this->load->view("inicio/sindocumento",$dato);
        $this->load->view("inicio/pie");
  }
  function totalbienes($identidad)
  {
    
    $menu = $this->session->userdata('menu');
    $id = $this->session->userdata('idfuncionario');
    $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
    $dato ['id']= $id;
    $dato ['identidad']= $identidad; 
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
    $dato['tipo_user'] = $this->session->userdata('tipo_user');
    $dato['title']= "Listado total de Inmuebles";
    $dato['aux']= 3;  
    $dato['filas'] = $this->inmuebles_model->select_listatotal($identidad);

    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("inmuebles/validartotal",$dato);
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

   function correspondeciadoc()
   {
      $filas =  $this->inmuebles_model->getcorrespondencia();
      $options="<option value='-1'>Seleccione una opción</option>"; 
      foreach($filas as $fila)
      {
           $options.= "<option value='".$fila->id."'>".$fila->descripcion."</option>";
      }     
      echo $options;
    }
    function getDatosInmueble()
    {
       $id = $this->input->get('id');
       //$id = 37134;
       $datos = $this->inmuebles_model->selec_inmueble_id($id);
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
       
      // $id = 77940; 
       $datos = $this->inmuebles_model->getTablaDocumentos($id);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>"; 
       $options.= "</tr>";
           
          foreach($datos as $fila)
          {
              
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documentacionbien(".$fila->id.")'>Ver</button>";
             $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",1)'> Per</button>";

              $options.= "<tr>";
                if($fila->val == 'Validado')
              {
                 $options.= "<td bgcolor='#D9EDF7'>".$boton."</td><td bgcolor='#D9EDF7'>".$fila->id."</td><td bgcolor='#D9EDF7'>".$fila->descripcion."</td><td bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td bgcolor='#D9EDF7'>".$fila->gestion."</td><td bgcolor='#D9EDF7'>".$fila->registradopor."</td><td bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr>";
              }
              else
              {
                 $options.= "<td>".$boton."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td><td>".$fila->registradopor."</td><td>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr>";
              }
          }     
          
      // $options.= "<option value='".$fila->id."'>".$fila->descripcion."</option>";
       
      // echo $datos[0]->descripcion; */
       echo $options; 
    }
    function getDocumentoslista($id)
    {
     
       $datos = $this->inmuebles_model->getTablaDocumentos($id);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>"; 
       $options.= "</tr>";
           
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documentacionbien(".$fila->id.")'>Ver</button>";
               $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",1)'> Per</button>";
              $options.= "<tr>";
              if($fila->val == 'Validado')
              {
                 $options.= "<td bgcolor='#D9EDF7'>".$boton."</td><td bgcolor='#D9EDF7'>".$fila->id."</td><td bgcolor='#D9EDF7'>".$fila->descripcion."</td><td bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td bgcolor='#D9EDF7'>".$fila->gestion."</td><td bgcolor='#D9EDF7'>".$fila->registradopor."</td><td bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr>";
              }
              else
              {
                 $options.= "<td>".$boton."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td><td>".$fila->registradopor."</td><td>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr>";
              }
             
          }     
          
       return $options; 
    }
     function getDocumentoslista2($idb,$doc)
    {
     
       $datos = $this->inmuebles_model->getTablaDocumentos($idb);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>"; 
       $options.= "</tr>";
           
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documentacionbien(".$fila->id.")'>Ver</button>";
                 $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",1)'> Per</button>";
              $options.= "<tr>";
              if($fila->val == 'Validado' && $fila->id != $doc)
              {
                 $options.= "<td bgcolor='#D9EDF7'>".$boton."</td><td bgcolor='#D9EDF7'>".$fila->id."</td><td bgcolor='#D9EDF7'>".$fila->descripcion."</td><td bgcolor='#D9EDF7'>".trim($fila->nrodocumento)."</td><td bgcolor='#D9EDF7'>".$fila->gestion."</td><td bgcolor='#D9EDF7'>".$fila->registradopor."</td><td bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr>";
              }
              else
              {
                  if($fila->id == $doc)
                {
                 $options.= "<td bgcolor='#fbc361'>".$boton."</td><td bgcolor='#fbc361'>".$fila->id."</td><td bgcolor='#fbc361'>".$fila->descripcion."</td><td bgcolor='#fbc361'>".trim($fila->nrodocumento)."</td><td bgcolor='#fbc361'>".$fila->gestion."</td><td bgcolor='#fbc361'>".$fila->registradopor."</td><td bgcolor='#fbc361'>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr>";
              }else
              {
                 $options.= "<td>".$boton."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".trim($fila->nrodocumento)."</td><td>".$fila->gestion."</td><td>".$fila->registradopor."</td><td>".$fila->val."</td><td>".$boton2."</td>";
                  $options.= "</tr>";
                }
              }
             
             
          }     
          
       return $options; 
    } 
    function verificarValidacion()//2019
    {
      $id = $this->input->get('id');

      //$id = 289415;
      $tipodoc=0;$nrodoc="";
      if($datos = $this->inmuebles_model->getValidacionDocumento1($id))
      {
             $tipodoc=$datos[0]->idtipodocumento;
             $nrodoc=trim($datos[0]->nrodocumento);
             $idB=$datos[0]->idb; 
      } 
      $lista = $this->getDocumentoslista2($idB,$id);
      
      if($filas = $this->inmuebles_model->getValidacionDocumento2($id))
      {
        
            $datos = '{"tienevalidacion":"true","idvalidacion":"'.$filas[0]->id.'","corresponde":"'.$filas[0]->idcorrespondencia.'",'
                        . '"adjunta":"'.$filas[0]->adjunta.'","legible":"'.$filas[0]->legible.'","observaciones":"'.$filas[0]->observacionesgeneral.'",'. '"nrodocumento":"'.trim($filas[0]->nrodocumento).'","correctodocumento":"'.$filas[0]->correctodocumento.'",'. '"superficieterreno":"'.$filas[0]->superficieterreno.'","correctosupterreno":"'.$filas[0]->correctosupterreno.'",'. '"denominacion":"'.$filas[0]->denominacion.'","correctodenominacion":"'.$filas[0]->correctodenominacion.'",'
                        . '"direccion":"'.$filas[0]->direccion.'","correctadireccion":"'.$filas[0]->correctodireccion.'",'
                        . '"catastro":"'.$filas[0]->catastro.'","correctocatastro":"'.$filas[0]->correctocatastro.'","observaciondetalle":"'.$filas[0]->observaciones.'","idtipodocumento":"'.$tipodoc.'","nrodoc":"'.$nrodoc.'","tabla":"'.$lista.'" }';
         
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
           $filas =  $this->inmuebles_model->getListaObservaciones();
           
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
    function verifiddoc()//2018
  {
    $iddocumento = $this->input->get('id');
    $datos = $this->inmuebles_model->verifiddocumento($iddocumento);
    if($datos) echo 1;
    else echo 0; 

  }
    function guardarvalidacion()
    {
      $accion = $this->input->get('accion');
      $idDocumento = $this->input->get('txtIdDocumento');
      $idval = $this->input->get('txtIdValidacion');
      $idBien = $this->input->get('txtIdBienInmueble');
      if($this->input->get('txtIdB1') != "") //2019
        $idB = $this->input->get('txtIdB1');
      else 
        $idB = $this->input->get('txtIdB');
      $idGestion = GESTION;
      $idCorrespondencia = $this->input->get('cbCorrespondeInmueble');//2019
      $adjunta = $this->input->get('cbAdjuntaInmueble');//2019
      $legible = $this->input->get('cbLegibleInmueble'); //2019
      $idDocumentoBien = $this->input->get('txtIdDocumento');
      $idTipoDocumento = $this->input->get('txtTipoDocumento');
      $observaciones=$this->input->get('txtObservacionesInmuebles');
      $estadoDocumentacion = $this->input->get('cbEstadoDocumentacionInmueble');
      $nroDocumentoOpcion = $this->input->get('cbNroDocumentoOpcion');
      $superficieOpcion = $this->input->get('cbSuperficieOpcion');
      $direccionOpcion = $this->input->get('cbDireccionOpcion');
      $catastroOpcion = $this->input->get('cbCatastroOpcion');
      $denominacionOpcion = $this->input->get('cbDenominacionOpcion');
      $nroDocumento = $this->input->get('txtNroDocumentoInmuebleObservado');
      $superficie = $this->input->get('txtSuperficieInmuebleObservado');
      $direccion = $this->input->get('txtDireccionInmuebleObservado');
      $catastro = $this->input->get('txtCatastroInmuebleObservado');
      $denominacion = $this->input->get('txtDenominacionInmuebleObservado');
      $nroDocumentoPro = $this->input->get('txtNroDocumentoInmuebleObservadoProv');
      $nroDocumentoOpcionPro = $this->input->get('cbNroDocumentoOpcionProv');
      $listaObservaciones = $this->input->get('txtListaObservaciones');

      $tipodoc = 4;

      //INICIO VALIDACION DOC INTERMEDIA
      $tipodocum = $this->inmuebles_model->getDatosDoc($idDocumento);
      if($adjunta=="t" and $idCorrespondencia==0 and $legible=="t" and $tipodocum[0]->idtipodocumento==1)
        {
        $docIntermedia = $this->documentacion_model->validarDocumentoIntermedia($idB,$idBien,$idDocumento); //2019 importante!!!
        }
        
      
       if($accion == "nuevaValidacion")
      {
          
            $idval = $this->inmuebles_model->guardarValidacionInmueble($idB,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones);

            if($adjunta=='t' && $legible=='t' && $idCorrespondencia==0)
            {
              if($idTipoDocumento==1 || $idTipoDocumento==2)
              {
                 // echo 1;
                  $update = $this->inmuebles_model->guardarDetalleValidacion($idval,$nroDocumento,$nroDocumentoOpcion,$superficie,$superficieOpcion,$catastro,$catastroOpcion,$denominacion,$denominacionOpcion,$direccion,$direccionOpcion);
                  $tipodoc = 1;
              }
              else
              {
                
                 $update = $this->inmuebles_model->guardarDetalleValidacion($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null);
                  $tipodoc = 2;
                  //echo 2;
              }
            }
            if($listaObservaciones!="")
            {
                 $valoresObservacion = explode("|", $listaObservaciones);
                  $cantidad = count($valoresObservacion);
                 
                  if($cantidad > 0)
                  {
                    if($listaObservaciones != "")
                    {  
                      $eliminar = $this->inmuebles_model->eliobservacion($idval);
                     foreach ($valoresObservacion as $valor) 
                     {
                       
                        $guardar = $this->inmuebles_model->guardarObservacionesValidacion($idval,$valor);
                     }
                    } 
                  }  
            
            } 
            else
            {
              $eliminar = $this->inmuebles_model->eliobservacion($idval);
            }
         
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
          $document = $this->documentacion_model->validarDocumento($idDocumento,$idBien,$fecha,$tipodoc,$idB); //2019 importante!!! 
        // $this->inmuebles_model->guardarEstadoDocumentacionGeneral($idValidacion,1);
          $bitacora = $this->bitacora($idBien,$idDocumento,1,$idB);

          $lista = $this->getDocumentoslista($idB);
          $tip = 1;
          $estadodevalidacion = $this->inmuebles_model->estadovalidacionbien($idB);
          $estado = $estadodevalidacion[0]->idestadovalidacion;
          $datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';
          echo $datos; 


          //  echo $idval; 
       
      }
      else
      {
        
         $update = $this->inmuebles_model->modificarvalidacion($idval,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$idDocumentoBien,$observaciones);
         
          if($adjunta=='t' && $legible=='t' && $idCorrespondencia==0)
          {
            if($this->inmuebles_model->exitedetalleval($idval))
            {  
                 if($idTipoDocumento==1 || $idTipoDocumento==2)
                {
                   // echo 1;
                    $update = $this->inmuebles_model->editarDetalleValidacion($idval,$nroDocumento,$nroDocumentoOpcion,$superficie,$superficieOpcion,$catastro,$catastroOpcion,$denominacion,$denominacionOpcion,$direccion,$direccionOpcion);
                      $tipodoc = 1;
                }
                else
                {
                  
                   $update = $this->inmuebles_model->editarDetalleValidacion($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null);
                  $tipodoc = 2;
                    //echo 2;
                }
            }
            else
            {
                 if($idTipoDocumento==1 || $idTipoDocumento==2)
                 {
                 // echo 1;
                  $update = $this->inmuebles_model->guardarDetalleValidacion($idval,$nroDocumento,$nroDocumentoOpcion,$superficie,$superficieOpcion,$catastro,$catastroOpcion,$denominacion,$denominacionOpcion,$direccion,$direccionOpcion);
                  $tipodoc = 1;
                 }
                 else
                  {
                  
                   $update = $this->inmuebles_model->guardarDetalleValidacion($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null);
                    $tipodoc = 2;
                    //echo 2;
                  }
            }
          }
          else
          {
            $update = $this->inmuebles_model->editarDetalleValidacion($idval,null,null,null,null,null,null,null,null,null,null);
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
                $eliminar = $this->inmuebles_model->eliobservacion($idval);
               foreach ($valoresObservacion as $valor) 
               { 
                  //echo "<br>";
                  //echo $valor;
                  $guardar = $this->inmuebles_model->guardarObservacionesValidacion($idval,$valor);
               }
              } 
            }  
          
          } 
         else
            {
              $eliminar = $this->inmuebles_model->eliobservacion($idval);
            }
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
          $document = $this->documentacion_model->validarDocumento($idDocumento,$idBien,$fecha,$tipodoc,$idB);
        
          $bitacora = $this->bitacora($idBien,$idDocumento,2,$idB);
        // $this->inmuebles_model->guardarEstadoDocumentacionGeneral($idValidacion,1);

          $x= 2;
          $lista = $this->getDocumentoslista($idB);
          $tip = 2;
          $estadodevalidacion = $this->inmuebles_model->estadovalidacionbien($idB);
          $estado = $estadodevalidacion[0]->idestadovalidacion;
          $datos = '{"tabla":"'.$lista.'","aux":"'.$x.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';
    
          echo $datos; 


          //echo 2;
      }
     
     //fin
      

  }

  function estado()
  {
    $estadodevalidacion = $this->inmuebles_model->estadovalidacionbien(512);
    $estado = $estadodevalidacion[0]->idestadovalidacion;
    echo $estado;
  }
  function pruebas2()
  {
      $listaObservaciones = "2|8|9";
      $valoresObservacion = explode("|", $listaObservaciones);
        $cantidad = count($valoresObservacion);
        echo $cantidad;
        if($cantidad > 0)
        {
          if($listaObservaciones != "")
          {  
            $eliminar = $this->inmuebles_model->eliobservacion(13520);
           foreach ($valoresObservacion as $valor) 
           {
              echo "<br>";
              echo $valor;
              $guardar = $this->inmuebles_model->guardarObservacionesValidacion(13520,$valor);
           }
          } 
        }  
     /* if($listaObservaciones!="")
          {
              $guardar = $this->inmuebles_model->guardarObservacionesValidacion($listaObservaciones,13520);
          
          } //*/
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


     function revalidardocumentacion()
    {
      $datestring = " %Y-%m-%d %H:%i:%s";
      $time = time();
      $fecha =  mdate($datestring, $time);

      $con = 0;
      $con2 = 0;
      $cadena = "";

      $entidades = $this->entidades_model->select_validar(51); 
      foreach ($entidades as $end) 
      {
        $identidad = $end->id;
        $filas = $this->inmuebles_model->select_validar($identidad);
        foreach ($filas as $fila) 
        {
            $idBien = $fila->idbien;
            $filas2 = $this->documentacion_model->validocin($idBien);
            $nroTotalDocumentos=$filas2[0]->total;
            $nroDocumentosValidados=$filas2[0]->validados;
          
         
          if($nroTotalDocumentos==$nroDocumentosValidados)
          {
              $con = $con +1;
              if($nroTotalDocumentos>0)
              {
                $cadena = $cadena."-".$idBien;  
              } 
              
          }
          else
          {
             $con2 = $con2 +1;
          }

            //$con = $con +1;

        }
      }
      echo $con." - ".$con2." - ".$cadena;

    }

    function pruebafecha()
    {
        $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);

        echo $fecha;

    }
  
}
?>