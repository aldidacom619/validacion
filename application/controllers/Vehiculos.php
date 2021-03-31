<?php 
class Vehiculos extends CI_Controller 
{
  function __construct(){
    parent::__construct();
    $this->_is_logued_in();
    $this->load->model('usuarios_model');
    $this->load->model('inmuebles_model');
    $this->load->model('vehiculos_model');
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
 
  
  function validarveh($identidad) 
  {
    
    $menu = $this->session->userdata('menu');
    $id = $this->session->userdata('idfuncionario');
    $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
    $dato ['id']= $id;
    $dato ['identidad']= $identidad;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
    $dato['tipo_user'] = $this->session->userdata('tipo_user');
    $dato['title']= "Listado de Vehículos para su Validación";
    $dato['aux']= 1;  
    $dato['filas'] = $this->vehiculos_model->select_validarveh($identidad);
    $dato['clases'] = $this->vehiculos_model->getclase();

    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("vehiculos/validarveh",$dato);
    $this->load->view("inicio/verdocumentos",$dato);
    $this->load->view("inicio/verpersonas",$dato);
    $this->load->view("inicio/sindocumento",$dato);
        $this->load->view("inicio/pie");
  } 


  function validadosveh($identidad)
  {
    
    $menu = $this->session->userdata('menu');
    $id = $this->session->userdata('idfuncionario');
    $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
    $dato ['id']= $id;
    $dato ['identidad']= $identidad;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
    $dato['tipo_user'] = $this->session->userdata('tipo_user');
    $dato['title']= "Listado de Vehículos Validados";
    $dato['aux']= 2;  
    $dato['filas'] = $this->vehiculos_model->select_validadasveh($identidad);
    $dato['clases'] = $this->vehiculos_model->getclase();
    
    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("vehiculos/validarveh",$dato);
    $this->load->view("inicio/verdocumentos",$dato);
    $this->load->view("inicio/verpersonas",$dato);
    $this->load->view("inicio/sindocumento",$dato);
    $this->load->view("inicio/pie");
  }
  function totalveh($identidad)//2018
  {
    
    $menu = $this->session->userdata('menu');
    $id = $this->session->userdata('idfuncionario');
    $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
    $dato ['id']= $id;
    $dato ['identidad']= $identidad;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
    $dato['tipo_user'] = $this->session->userdata('tipo_user');
    $dato['title']= "Listado total de Vehículos";
    $dato['aux']= 3;  
    $dato['filas'] = $this->vehiculos_model->select_totalveh($identidad);
    $dato['clases'] = $this->vehiculos_model->getclase();
    
    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("vehiculos/validarveh",$dato);
    $this->load->view("inicio/verdocumentos",$dato);
    $this->load->view("inicio/verpersonas",$dato);
    $this->load->view("inicio/sindocumento",$dato);
    $this->load->view("inicio/pie");
  }
  


  
    function getDatosVehiculo()
    {
       $id = $this->input->get('id');
       //$id = 37134;
       $datos = $this->vehiculos_model->selec_vehiculo_id($id);
       //echo $datos[0]->denominacion;
         $json = json_encode($datos); 
         echo $json;

         //echo $id."holaaa";
    }
    function getDatosEstado()
    {
       $id = $this->input->get('id');
       //$id = 37134;
       $datos = $this->vehiculos_model->getEstadoBien($id);

       if($datos[0]->descripcion == 'BAJA')
       {
         $datos2 = $this->vehiculos_model->getEstadobaja($id);          
         echo $datos[0]->descripcion."<br>Tipo:".$datos2[0]->descripcion."<br>Doc:".$datos2[0]->resolucion_respaldo."<br>Fecha:".$datos2[0]->fecha."<br>Desc::".$datos2[0]->observaciones;
       }
       else
      {
        echo $datos[0]->descripcion; 
      }
 
       
    }  
    function getDatosDocumento()
    {
      $id = $this->input->get('id');
      $filas = $this->vehiculos_model->getDatosDocumento($id);
      $datos = '{"idtipodocumento":"'.$filas[0]->idtipodocumento.'","idb":"'.$filas[0]->idb.'","idbien":"'.$filas[0]->idbien.'","nrodocumento":"'.$filas[0]->nrodocumento.'"}';
      echo $datos;


    }
    function getDocumentos()
    {
      $id = $this->input->get('id');
       $datos = $this->vehiculos_model->getTablaDocumentos($id);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>"; 
          $options.= "</tr>";
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='verDocumento(".$fila->id.")'>Ver</button>";
              $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",3)'> Per</button>";
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
    function getDocumentoslista($id)
    {
      
       $datos = $this->vehiculos_model->getTablaDocumentos($id);
        $options  = "<tr>";
         $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>"; 
          $options.= "</tr>";
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='verDocumento(".$fila->id.")'>Ver</button>";
                  $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",3)'> Per</button>";
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
       return $options; 
    }


      function getDocumentoslista2($id,$doc)
    {
     
        $datos = $this->vehiculos_model->getTablaDocumentos($id);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>"; 
          $options.= "</tr>";
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='verDocumento(".$fila->id.")'>Ver</button>";
                  $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",3)'> Per</button>";
              if($fila->val == 'Validado' && $fila->id != $doc )
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
      //echo $id;
      //$id = 207923;
      $tipodoc=0;$nrodoc="";
     
      if($datos = $this->vehiculos_model->getValidacionDocumento1($id))
      {
             $tipodoc=$datos[0]->idtipodocumento;
             $nrodoc=$datos[0]->nrodocumento;
             $idBien=$datos[0]->idbien;
             $idb=$datos[0]->idb;
      }


      $lista = $this->getDocumentoslista2($idb,$id);

      if($filas = $this->vehiculos_model->getValidacionDocumento2($id))
      {
        
            
            $datos='{"tienevalidacion":"true","idvalidacion":"'.$filas[0]->id.'","corresponde":"'.$filas[0]->idcorrespondencia.'",'
                        . '"adjunta":"'.$filas[0]->adjunta.'","legible":"'.$filas[0]->legible.'","observaciones":"'.$filas[0]->observacionesgenerales.'",'
                        . '"nrodocumento":"'.$filas[0]->nrodocumento.'","correctodocumento":"'.$filas[0]->correctodocumento.'",'
                        . '"marca":"'.$filas[0]->marca.'","correctomarca":"'.$filas[0]->correctomarca.'",'
                        . '"tipovehiculo":"'.$filas[0]->idtipovehiculo.'","correctovehiculo":"'.$filas[0]->correctovehiculo.'",'
                        . '"clase":"'.$filas[0]->clase.'","correctoclase":"'.$filas[0]->correctoclase.'",'
                        . '"placa":"'.$filas[0]->placa.'",
                        "correctoplaca":"'.$filas[0]->correctoplaca.'",
                        "nromotor":"'.$filas[0]->nromotor.'",
                        "correctomotor":"'.$filas[0]->correctomotor.'",
                        "nrochasis":"'.$filas[0]->nrochasis.'",
                        "correctochasis":"'.$filas[0]->correctochasis.'", 
                        "procedencia":"'.$filas[0]->procedencia.'",
                        "correctoprocedencia":"'.$filas[0]->correctoprocedencia.'", 
                        "modelo":"'.$filas[0]->modelo.'",
                        "correctomodelo":"'.$filas[0]->correctomodelo.'",
                        "color":"'.$filas[0]->color.'",
                        "correctocolor":"'.$filas[0]->correctocolor.'",
                        "observaciondetalle":"'.$filas[0]->observaciones.'","tabla":"'.$lista.'"}';
             echo  $datos;
      
          
      }
      else
      {

        $datos = '{"tienevalidacion":"false","tabla":"'.$lista.'"}';
       echo $datos;
      
        
      }
       
      
    
    }
    function obtenerObservaciones()
    {
           $filas =  $this->vehiculos_model->getListaObservaciones();
           
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

    function verifiddocVehiculo()//2018
  {
    $iddocumento = $this->input->get('id');
    $datos = $this->vehiculos_model->verifiddocumentoVehiculo($iddocumento);
    if($datos) echo 1;
    else echo 0; 

  }
    function guardarvalidacionvehiculo()
    {
      

      $idVal = 1;
        $accion = $this->input->get('accionVehiculo');

        $idDocumento = $this->input->get('txtIdDocumentoVehiculo');
        $idBien = $this->input->get('txtIdBienVehiculo');
        $idb = $this->input->get('txtIdB');
        $idval = $this->input->get('txtIdValidacionVehiculo');
        $idGestion = GESTION;
        $idCorrespondencia = $this->input->get('cbCorrespondeVehiculo');
        $adjunta = $this->input->get('cbAdjuntaVehiculo');
        $legible = $this->input->get('cbLegibleVehiculo');
        $idDocumentoBien = $this->input->get('txtIdDocumentoVehiculo');
        $idTipoDocumento = $this->input->get('txtTipoDocumentoVehiculo');

        if($this->input->get('txtObservacionesGeneralesVehiculo')==''){
         $observaciones = "";
        }else{
         $observaciones = $this->input->get('txtObservacionesGeneralesVehiculo');
        }
        
        $nroDocumentoPro = $this->input->get('txtNroDocumentoVehiculoObservadoProv');
        $nroDocumentoOpcionPro = $this->input->get('cbNroDocumentoOpcionVehiculoProv');
        
        $nroDocumentoOpcion = $this->input->get('cbNroDocumentoVehiculoOpcion');
        $tipoVehiculoOpcion = $this->input->get('cbTipoVehiculoOpcion');
        $claseVehiculoOpcion = $this->input->get('cbClaseOpcion');
        $marcaVehiculoOpcion = $this->input->get('cbMarcaOpcion');
        $placaVehiculoOpcion = $this->input->get('cbPlacaOpcion');
        $motorVehiculoOpcion = $this->input->get('cbMotorOpcion');
        $chasisVehiculoOpcion = $this->input->get('cbChasisOpcion');
        $procedenciaVehiculoOpcion = $this->input->get('cbProcedenciaOpcion');
        $modeloVehiculoOpcion = $this->input->get('cbModeloOpcion');
        $colorVehiculoOpcion = $this->input->get('cbColorOpcion');
        
        $nroDocumento = $this->input->get('txtNroDocumentoVehiculoObservado');
        $tipoVehiculo = $this->input->get('txtTipoVehiculoObservado');
        $claseVehiculo = $this->input->get('txtClaseVehiculoObservado');
        $marcaVehiculo = $this->input->get('txtMarcaVehiculoObservado');
        $placaVehiculo = $this->input->get('txtPlacaVehiculoObservado');
        $motorVehiculo = $this->input->get('txtNumeroMotorVehiculoObservado');
        $chasisVehiculo = $this->input->get('txtNumeroChasisVehiculoObservado');
        $procedenciaVehiculo = $this->input->get('txtProcedenciaVehiculoObservado');
        $modeloVehiculo = $this->input->get('txtModeloVehiculoObservado');
        $colorVehiculo = $this->input->get('txtColorVehiculoObservado');
        $listaObservaciones = $this->input->get('txtListaObservacionesVehiculo');
        $tipodoc = 4;
        
        //INICIO VALIDACION DOC INTERMEDIA
      $tipodocV = $this->vehiculos_model->getDatosDocV($idDocumento);
      if($adjunta=="t" and $idCorrespondencia==1 and $legible=="t" and $tipodocV[0]->idtipodocumento==4)
        {
        $docIntermediaVe = $this->documentacion_model->validarDocumentoIntermediaVe($idb,$idBien,$idDocumento); //2019 
        
        }
        
     // echo $accion;

       if($accion == "guardarValidacion")
       {
          $idval = $this->vehiculos_model->guardarValidacionVehiculo($idb,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$observaciones,$idDocumentoBien);
            //$idVal = 12133;
           if($adjunta == 't' && $idCorrespondencia == 1 && $legible == 't' )
           {
              if($idTipoDocumento==4)
              {
                 // echo 1;
                    $update = $this->vehiculos_model->guardarDetalleValidacionveh($idval,$nroDocumento,$nroDocumentoOpcion,$marcaVehiculo,$marcaVehiculoOpcion,$tipoVehiculo,$tipoVehiculoOpcion,$claseVehiculo,$claseVehiculoOpcion,$placaVehiculo,$placaVehiculoOpcion,$motorVehiculo,$motorVehiculoOpcion,$chasisVehiculo,$chasisVehiculoOpcion,$procedenciaVehiculo,$procedenciaVehiculoOpcion,$modeloVehiculo,$modeloVehiculoOpcion,$colorVehiculo,$colorVehiculoOpcion);
                    $tipodoc = 1;
              }
              else
              {
                
                   $update = $this->vehiculos_model->guardarDetalleValidacionveh($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);

                   $tipodoc = 2;
                 
                
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
                      $eliminar = $this->vehiculos_model->eliobservacion($idval);
                     foreach ($valoresObservacion as $valor) 
                     {
                       
                        $guardar = $this->vehiculos_model->guardarObservacionesValidacion($idval,$valor);
                     }
                    } 
                  }  
            
            } 
            else
            {
              $eliminar = $this->vehiculos_model->eliobservacion($idval);
            }
         
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time(); 
          $fecha =  mdate($datestring, $time);

         $document = $this->documentacion_model->validarDocumentoVehiculo($idDocumento,$idBien,$fecha,$tipodoc,$idb);
         
         $bitacora = $this->bitacora($idBien,$idDocumento,1,$idb);//BITACORA 

         $lista = $this->getDocumentoslista($idb);

          $tip = 1;
          $estadodevalidacion = $this->vehiculos_model->estadovalidacionbien($idb);
          $estado = $estadodevalidacion[0]->idestadovalidacion;

         
          $datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';

         // $datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'"}';
         
          echo $datos; 
            
           //echo $idval;
       
      }
      else
      {
       
        $update = $this->vehiculos_model->modificarvalidacionveh($idval,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$observaciones,$idDocumentoBien);
         
           if($adjunta == 't' && $idCorrespondencia == 1 && $legible == 't' )
           {
             if($this->vehiculos_model->exitedetalleval($idval))
            {  

              if($idTipoDocumento==4)
              {
                 // echo 1;
                    $update = $this->vehiculos_model->editarDetalleValidacionveh($idval,$nroDocumento,$nroDocumentoOpcion,$marcaVehiculo,$marcaVehiculoOpcion,$tipoVehiculo,$tipoVehiculoOpcion,$claseVehiculo,$claseVehiculoOpcion,$placaVehiculo,$placaVehiculoOpcion,$motorVehiculo,$motorVehiculoOpcion,$chasisVehiculo,$chasisVehiculoOpcion,$procedenciaVehiculo,$procedenciaVehiculoOpcion,$modeloVehiculo,$modeloVehiculoOpcion,$colorVehiculo,$colorVehiculoOpcion);
                    $tipodoc = 1;
              }
              else
              {
                
                   $update = $this->vehiculos_model->editarDetalleValidacionveh($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                   $tipodoc = 2;
              }
            }
            else
            {
              if($idTipoDocumento==4)
              {
                 // echo 1;
                    $update = $this->vehiculos_model->guardarDetalleValidacionveh($idval,$nroDocumento,$nroDocumentoOpcion,$marcaVehiculo,$marcaVehiculoOpcion,$tipoVehiculo,$tipoVehiculoOpcion,$claseVehiculo,$claseVehiculoOpcion,$placaVehiculo,$placaVehiculoOpcion,$motorVehiculo,$motorVehiculoOpcion,$chasisVehiculo,$chasisVehiculoOpcion,$procedenciaVehiculo,$procedenciaVehiculoOpcion,$modeloVehiculo,$modeloVehiculoOpcion);
                    $tipodoc = 1;
              }
              else
              {
                
                   $update = $this->vehiculos_model->guardarDetalleValidacionveh($idval,$nroDocumentoPro,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                   $tipodoc = 2;
              } 
            }
          }
          else
          {
            if($this->vehiculos_model->exitedetalleval($idval))
            {  

              if($idTipoDocumento==4)
              {
                 // echo 1;
                    $update = $this->vehiculos_model->editarDetalleValidacionveh($idval,$nroDocumento,$nroDocumentoOpcion,$marcaVehiculo,$marcaVehiculoOpcion,$tipoVehiculo,$tipoVehiculoOpcion,$claseVehiculo,$claseVehiculoOpcion,$placaVehiculo,$placaVehiculoOpcion,$motorVehiculo,$motorVehiculoOpcion,$chasisVehiculo,$chasisVehiculoOpcion,$procedenciaVehiculo,$procedenciaVehiculoOpcion,$modeloVehiculo,$modeloVehiculoOpcion,$colorVehiculo,$colorVehiculoOpcion);
                    $tipodoc = 1;
              }
              else
              {
                
                   $update = $this->vehiculos_model->editarDetalleValidacionveh($idval,$nroDocumentoPro,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                   $tipodoc = 2;
              }
            }
            else
            {
              if($idTipoDocumento==4)
              {
                 // echo 1;
                    $update = $this->vehiculos_model->guardarDetalleValidacionveh($idval,$nroDocumento,$nroDocumentoOpcion,$marcaVehiculo,$marcaVehiculoOpcion,$tipoVehiculo,$tipoVehiculoOpcion,$claseVehiculo,$claseVehiculoOpcion,$placaVehiculo,$placaVehiculoOpcion,$motorVehiculo,$motorVehiculoOpcion,$chasisVehiculo,$chasisVehiculoOpcion,$procedenciaVehiculo,$procedenciaVehiculoOpcion,$modeloVehiculo,$modeloVehiculoOpcion);
                    $tipodoc = 1;
              }
              else
              {
                
                   $update = $this->vehiculos_model->guardarDetalleValidacionveh($idval,$nroDocumentoPro,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);//2018 aumento de 2 null
                   $tipodoc = 2;
              } 
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
                      $eliminar = $this->vehiculos_model->eliobservacion($idval);
                     foreach ($valoresObservacion as $valor) 
                     {
                       
                        $guardar = $this->vehiculos_model->guardarObservacionesValidacion($idval,$valor);
                     }
                    } 
                  }  
            
            } 
            else
            {
              $eliminar = $this->vehiculos_model->eliobservacion($idval);
            }
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
          $document = $this->documentacion_model->validarDocumentoVehiculo($idDocumento,$idBien,$fecha,$tipodoc,$idb);
          
          $bitacora = $this->bitacora($idBien,$idDocumento,2,$idb);//BITACORA
          
          $lista = $this->getDocumentoslista($idb);

          

           $tip = 2;
          $estadodevalidacion = $this->vehiculos_model->estadovalidacionbien($idb);
          $estado = $estadodevalidacion[0]->idestadovalidacion;

         // $datos = '{"tabla":"'.$lista.'","aux":"'.$x.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';

          $datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';
         
          echo $datos; 
         // echo 2;
      }
     
      //echo 1;*/

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
       //$idval = 8881;
      $idBien = 23855;
      $nroDocumentoOpcion = "t";
      $nroDocumento = "594/91";
      $accion = "guardarValidacion";
      $idCorrespondencia = 1;
      $adjunta = "t";
      $legible = "t";
      $idTipoDocumento = 12;
      $idGestion = 2014;
      $idDocumentoBien = 14430;
      $observaciones = "";
      $nroDocumentoPro = 454654654;
      $nroDocumentoOpcionPro = "f";

      //$nroDocumentoOpcionPro = "t";
       if($accion == "guardarValidacion")
       {
           //$idval = $this->vehiculos_model->guardarValidacionVehiculo($idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$observaciones,$idDocumentoBien);
            $idval = 12134;
           $update = $this->vehiculos_model->editarDetalleValidacionveh($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);

           echo 2;
       
      }
  
    }
    function getMarcasText()
    {  
        $var = $_GET["term"];
        $filas =  $this->vehiculos_model->getmarcastext($var);
        foreach($filas as $fila)
        {
             $row_set[] = $fila->marca;
        } 
        echo json_encode($row_set);
        /*$row_set = array('a','b','c',$_GET["term"]);
        echo json_encode($row_set);  */
    }

      
}
?>