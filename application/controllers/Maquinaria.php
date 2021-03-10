 <?php 
class Maquinaria extends CI_Controller 
{
  function __construct(){
    parent::__construct();
    $this->_is_logued_in();
    $this->load->model('usuarios_model');
    $this->load->model('inmuebles_model');
    $this->load->model('maquinaria_model');
      $this->load->model('documentacion_model');
      $this->load->helper('date');
      $this->load->helper('validacion_helper');
  
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
 
  
  function validarmaq($identidad) 
  {
    $menu = $this->session->userdata('menu');
    $id = $this->session->userdata('idfuncionario');
    $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
    $dato ['id']= $id;
    $dato ['identidad']= $identidad;
        $dato['tipo_user'] = $this->session->userdata('tipo_user');
    $dato['title']= "Maquinaria para su Validación";
    $dato['aux']= 1; 
    $dato['filas'] = $this->maquinaria_model->select_validarmaq($identidad);
    
    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("maquinaria/validarmaq",$dato);
      $this->load->view("inicio/verdocumentos",$dato);
      $this->load->view("inicio/verpersonas",$dato);
      $this->load->view("inicio/sindocumento",$dato);
      $this->load->view("inicio/pie");
  } 

function verifiddocmaquinaria()//2018
  {
    $iddocumento = $this->input->get('id');
    $datos = $this->maquinaria_model->verifiddocumentomaq($iddocumento);
    if($datos) echo 1;
    else echo 0; 

  }


  function validadosmaq($identidad)
  {
    
    $menu = $this->session->userdata('menu');
    $id = $this->session->userdata('idfuncionario');
    $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
    $dato ['id']= $id;
    $dato ['identidad']= $identidad;
        
    $dato['tipo_user'] = $this->session->userdata('tipo_user');
    $dato['title']= "Maquinaria Validada";
    $dato['filas'] = $this->maquinaria_model->select_validadasmaq($identidad);
    $dato['aux']= 2; 
    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("maquinaria/validarmaq",$dato);
      $this->load->view("inicio/verdocumentos",$dato);
      $this->load->view("inicio/verpersonas",$dato);
      $this->load->view("inicio/sindocumento",$dato);
      $this->load->view("inicio/pie");
  }
   function totalmaq($identidad)//2018
  {
    
    $menu = $this->session->userdata('menu');
    $id = $this->session->userdata('idfuncionario');
    $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
    $dato ['id']= $id;
    $dato ['identidad']= $identidad;
        
    $dato['tipo_user'] = $this->session->userdata('tipo_user');
    $dato['title']= "Listado total de Maquinarias";
    $dato['filas'] = $this->maquinaria_model->select_totalmaq($identidad);
    $dato['aux']= 3; 
    $this->load->view("inicio/cabecera",$dato); 
    $this->load->view("maquinaria/validarmaq",$dato);
      $this->load->view("inicio/verdocumentos",$dato);
      $this->load->view("inicio/verpersonas",$dato);
      $this->load->view("inicio/sindocumento",$dato);
      $this->load->view("inicio/pie");
  }
  


  
    function getDatosmaquinaria()
    {
       $id = $this->input->get('id');
      // $id = 20944;
       $datos = $this->maquinaria_model->selec_maquinaria_id($id);
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
       echo $datos[0]->descripcion;
    } 
    function getDatosDocumento()
    {
      $id = $this->input->get('id');
      $filas = $this->vehiculos_model->getDatosDocumento($id);
      $datos = '{"idtipodocumento":"'.$filas[0]->idtipodocumento.'","idbien":"'.$filas[0]->idbien.'","nrodocumento":"'.$filas[0]->nrodocumento.'"}';
      echo $datos;


    }

    function getDocumentos()
    {
      $id = $this->input->get('id');

      //$estado = $this->input->get('estado');
       
      // $id = 310246;
       $datos = $this->maquinaria_model->getTablaDocumentos($id);
        $options  = "<table><tr>";
      $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>"; 
       $options.= "</tr>";
           
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documentacionbien(".$fila->id.")'>Ver</button>";
                $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",4)'> Per</button>";
             if($fila->val == 'Validado')
              {
              $options.= "<tr>";
                $options.= "<td bgcolor='#D9EDF7'>".$boton."</td><td bgcolor='#D9EDF7'>".$fila->id."</td><td bgcolor='#D9EDF7'>".$fila->descripcion."</td><td bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td bgcolor='#D9EDF7'>".$fila->gestion."</td><td bgcolor='#D9EDF7'>".$fila->registradopor."</td><td bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr></table>";
             }
             else
             {
                $options.= "<tr>";
                $options.= "<td >".$boton."</td><td >".$fila->id."</td><td >".$fila->descripcion."</td><td >".$fila->nrodocumento."</td><td >".$fila->gestion."</td><td >".$fila->registradopor."</td><td >".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr></table>";
             }
          }     
          
      // $options.= "<option value='".$fila->id."'>".$fila->descripcion."</option>";
       
      // echo $datos[0]->descripcion; */
       echo $options; 
    }
     function getDocumentoslista($id)
    {
      
       $datos = $this->maquinaria_model->getTablaDocumentos($id);
        $options  = "<table><tr>";
      $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>"; 
       $options.= "</tr>";
           
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documentacionbien(".$fila->id.")'>Ver</button>";
                $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",4)'> Per</button>";
              if($fila->val == 'Validado')
              {
              $options.= "<tr>";
                $options.= "<td bgcolor='#D9EDF7'>".$boton."</td><td bgcolor='#D9EDF7'>".$fila->id."</td><td bgcolor='#D9EDF7'>".$fila->descripcion."</td><td bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td bgcolor='#D9EDF7'>".$fila->gestion."</td><td bgcolor='#D9EDF7'>".$fila->registradopor."</td><td bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr></table>";
             }
             else
             {
               $options.= "<tr>";
                $options.= "<td>".$boton."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td><td>".$fila->registradopor."</td><td>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr></table>";
             }
          }     
          
      // $options.= "<option value='".$fila->id."'>".$fila->descripcion."</option>";
       
      // echo $datos[0]->descripcion; */
       return $options; 
    }
    function getDocumentoslista2($id,$doc)
    {
      
       $datos = $this->maquinaria_model->getTablaDocumentos($id);
        $options  = "<table><tr>";
       $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th><th>Registrado por</th><th>Estado Validaciones</th><th>Persona</th>"; 
       $options.= "</tr>";
           
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documentacionbien(".$fila->id.")'>Ver</button>";
                $boton2 =  "<button name='btnValidarInmueble' class='fa fa-user' onclick='adicionarDialogNuevaPersona(".$fila->id.",  ".$fila->idb.",4)'> Per</button>";
               if($fila->val == 'Validado' && $fila->id != $doc)
              {
              $options.= "<tr>";
                $options.= "<td bgcolor='#D9EDF7'>".$boton."</td><td bgcolor='#D9EDF7'>".$fila->id."</td><td bgcolor='#D9EDF7'>".$fila->descripcion."</td><td bgcolor='#D9EDF7'>".$fila->nrodocumento."</td><td bgcolor='#D9EDF7'>".$fila->gestion."</td><td bgcolor='#D9EDF7'>".$fila->registradopor."</td><td bgcolor='#D9EDF7'>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr></table>";
             }
             else
             {
                if($fila->id == $doc)
                {
              $options.= "<tr>";
                $options.= "<td bgcolor='#fbc361'>".$boton."</td><td bgcolor='#fbc361'>".$fila->id."</td><td bgcolor='#fbc361'>".$fila->descripcion."</td><td bgcolor='#fbc361'>".$fila->nrodocumento."</td><td bgcolor='#fbc361'>".$fila->gestion."</td><td bgcolor='#fbc361'>".$fila->registradopor."</td><td bgcolor='#fbc361'>".$fila->val."</td><td>".$boton2."</td>";
               $options.= "</tr></table>";
             }
                else
                {
                 $options.= "<tr>";
                  $options.= "<td>".$boton."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td><td>".$fila->registradopor."</td><td>".$fila->val."</td><td>".$boton2."</td>";
                 $options.= "</tr></table>";
                }
             }
          }     
       return $options; 
    }



    function verificarValidacion()
    {
      $id = $this->input->get('id');
     // echo $id;
      //$id = 248431;
      
      $tipodoc=0;$nrodoc="";

      if($datos = $this->inmuebles_model->getValidacionDocumento1($id))
      {
             $tipodoc=$datos[0]->idtipodocumento;
             $nrodoc=$datos[0]->nrodocumento;
             $idBien=$datos[0]->idbien;
             $idB=$datos[0]->idb;
      }

      $lista = $this->getDocumentoslista2($idB,$id);
      if($filas = $this->maquinaria_model->getValidacionDocumento2($id))
      {

             $datos='{"tienevalidacion":"true","idvalidacion":"'.$filas[0]->id.'",
             "corresponde":"'.$filas[0]->idcorrespondencia.'",
             '. '"adjunta":"'.$filas[0]->adjunta.'",
             "legible":"'.$filas[0]->legible.'",
             "observaciones":"'.$filas[0]->observacionesgenerales.'",
             '. '"nrodocumento":"'.$filas[0]->nrodocumento.'",
             "correctodocumento":"'.$filas[0]->correctodocumento.'",
             '. '"descripcion":"'.$filas[0]->descripcion.'",
             "correctodescripcion":"'.$filas[0]->correctodescripcion.'",
             '. '"marca":"'.$filas[0]->marca.'",
              "correctomarca":"'.$filas[0]->correctomarca.'",
              '.'"serie":"'.$filas[0]->nroserie.'",
               "correctoserie":"'.$filas[0]->correctonroserie.'",
              "modelo":"'.$filas[0]->modelo.'", 
              "correctomodelo":"'.$filas[0]->correctomodelo.'",
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
           $filas =  $this->maquinaria_model->getListaObservaciones();
           
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
      
      $accion = $this->input->get('operacion');
        $idDocumento = $this->input->get('txtIdDocumentoMaquinaria');
    $idBien = $this->input->get('txtIdBienMaquinaria');
    $idb = $this->input->get('txtIdB');
    $idval = $this->input->get('txtIdValidacionMaquinaria');
    $idGestion = GESTION;
    $idCorrespondencia = $this->input->get('cbCorrespondeMaquinaria');
    $adjunta = $this->input->get('cbAdjuntaMaquinaria');
    $legible = $this->input->get('cbLegibleMaquinaria');
    $idDocumentoBien = $this->input->get('txtIdDocumentoMaquinaria');
    $idTipoDocumento = $this->input->get('txtTipoDocumentoMaquinaria');
    if($this->input->get('txtObservacionesGeneralesMaquinaria')==''){
    $observaciones = "";
    }else{
    $observaciones = $this->input->get('txtObservacionesGeneralesMaquinaria');
    }
    
    $listaObservaciones = $this->input->get('txtListaObservacionesMaquinaria');
     
    $nroDocumentoOpcion = $this->input->get('cbNroDocumentoMaquinariaOpcion');
    $descripcionOpcion = $this->input->get('cbEquipoMaquinariaOpcion');
    $marcaOpcion = $this->input->get('cbMarcaMaquinariaOpcion');
    $modeloOpcion = $this->input->get('cbModeloMaquinariaOpcion');
    $serieOpcion = $this->input->get('cbSerieMaquinariaOpcion');
    
    $nroDocumento = $this->input->get('txtNroDocumentoObservadoMaquinaria');
    $descripcion = $this->input->get('txtDescripcionObservadoMaquinaria');
    $marca = $this->input->get('txtMarcaObservadoMaquinaria');
    $modelo = $this->input->get('txtModeloObservadoMaquinaria');
    $serie = $this->input->get('txtSerieObservadoMaquinaria');
    $nroDocumentoPro = $this->input->get('txtNroDocumentoMaquinariaObservadoProv');
    $nroDocumentoOpcionPro = $this->input->get('cbNroDocumentoOpcionMaquinariaProv');

     $tipodoc = 4;     
     // echo $accion;

       if($accion == "guardarValidacion")
       {
          
         $idval = $this->maquinaria_model->guardarValidacionMaquinaria($idb,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$observaciones,$idDocumentoBien);
            //$idval = 5205;
          if($adjunta == 't' && $idCorrespondencia == 1 && $legible == 't' )
          {     
              if($idTipoDocumento==8){
                     // echo 1;
                     $update = $this->maquinaria_model->guardarDetalleValidacionmaq($idval,$nroDocumento,$nroDocumentoOpcion,$descripcion,$descripcionOpcion,$marca,$marcaOpcion,$modelo,$modeloOpcion,$serie,$serieOpcion);
                     $tipodoc = 1;
              }
              else
              {
                   $update = $this->maquinaria_model->guardarDetalleValidacionmaq($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null);
                   $tipodoc = 2;
              }
          }
      
         
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
         $document = $this->documentacion_model->validarDocumentoVehiculo($idDocumento,$idBien,$fecha,$tipodoc,$idb);
           
          if($listaObservaciones!="")
            {
                 $valoresObservacion = explode("|", $listaObservaciones);
                  $cantidad = count($valoresObservacion);
                 
                  if($cantidad > 0)
                  {
                    if($listaObservaciones != "")
                    {  
                      $eliminar = $this->maquinaria_model->eliobservacion($idval);
                     foreach ($valoresObservacion as $valor) 
                     {
                       
                        $guardar = $this->maquinaria_model->guardarObservacionesValidacion($idval,$valor);
                     }
                    } 
                  }  
            
            } 
            else
            {
              $eliminar = $this->maquinaria_model->eliobservacion($idval); 
            }

          $lista = $this->getDocumentoslista2($idb,$idDocumento);
          $bitacora = $this->bitacora($idBien,$idDocumento,1,$idb);//BITACORA 
          $tip = 1;
          $estadodevalidacion = $this->maquinaria_model->estadovalidacionbien($idb);
          $estado = $estadodevalidacion[0]->idestadovalidacion;

         
          $datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';

          //$datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'"}';
         
          echo $datos; 
          // echo $idval;
       
      }
      else
      {
       
          $update = $this->maquinaria_model->modificarvalidacionmaq($idval,$idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$observaciones,$idDocumentoBien);
        
      
            if($adjunta == 't' && $idCorrespondencia == 1 && $legible == 't' )
           {      
              if($this->maquinaria_model->exitedetalleval($idval))
              { 
                if($idTipoDocumento==8)
                {                     
                         $update = $this->maquinaria_model->editarDetalleValidacionmaq($idval,$nroDocumento,$nroDocumentoOpcion,$descripcion,$descripcionOpcion,$marca,$marcaOpcion,$modelo,$modeloOpcion,$serie,$serieOpcion);
                         $tipodoc = 1;
                }
                else
                {
                    $update = $this->maquinaria_model->editarDetalleValidacionmaq($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null);
                    $tipodoc = 2;
                }
            }
            else
            {
                if($idTipoDocumento==8){
                     // echo 1;
                     $update = $this->maquinaria_model->guardarDetalleValidacionmaq($idval,$nroDocumento,$nroDocumentoOpcion,$descripcion,$descripcionOpcion,$marca,$marcaOpcion,$modelo,$modeloOpcion,$serie,$serieOpcion);
                     $tipodoc = 1;
                }
                else
                {
                    $update = $this->maquinaria_model->guardarDetalleValidacionmaq($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null);
                    $tipodoc = 2;
                } 
            }

          }
          else{
            if($this->maquinaria_model->exitedetalleval($idval))
              { 
                if($idTipoDocumento==8)
                {                     
                         $update = $this->maquinaria_model->editarDetalleValidacionmaq($idval,$nroDocumento,$nroDocumentoOpcion,$descripcion,$descripcionOpcion,$marca,$marcaOpcion,$modelo,$modeloOpcion,$serie,$serieOpcion);
                         $tipodoc = 1;
                }
                else
                {
                    $update = $this->maquinaria_model->editarDetalleValidacionmaq($idval,$nroDocumentoPro,null,null,null,null,null,null,null,null,null);
                    $tipodoc = 2;
                }
            }
            else
            {
                if($idTipoDocumento==8){
                     // echo 1;
                     $update = $this->maquinaria_model->guardarDetalleValidacionmaq($idval,$nroDocumento,$nroDocumentoOpcion,$descripcion,$descripcionOpcion,$marca,$marcaOpcion,$modelo,$modeloOpcion,$serie,$serieOpcion);
                     $tipodoc = 1;
                }
                else
                {
                    $update = $this->maquinaria_model->guardarDetalleValidacionmaq($idval,$nroDocumentoPro,null,null,null,null,null,null,null,null,null);
                    $tipodoc = 2;
                } 
            }
          }
      
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);
         $document = $this->documentacion_model->validarDocumentoVehiculo($idDocumento,$idBien,$fecha,$tipodoc,$idb);
           if($listaObservaciones!="")
            {
                 $valoresObservacion = explode("|", $listaObservaciones);
                  $cantidad = count($valoresObservacion);
                 
                  if($cantidad > 0)
                  {
                    if($listaObservaciones != "")
                    {  
                      $eliminar = $this->maquinaria_model->eliobservacion($idval);
                     foreach ($valoresObservacion as $valor) 
                     {
                       
                        $guardar = $this->maquinaria_model->guardarObservacionesValidacion($idval,$valor); 
                     }
                    } 
                  }  
            
            } 
             else
            {
              $eliminar = $this->maquinaria_model->eliobservacion($idval);
            }
          $x= 2;
          $lista = $this->getDocumentoslista2($idb,$idDocumento);


          $bitacora = $this->bitacora($idBien,$idDocumento,2,$idb);//BITACORA

          $tip = 2;
          $estadodevalidacion = $this->maquinaria_model->estadovalidacionbien($idb);
          $estado = $estadodevalidacion[0]->idestadovalidacion;
          //$datos = '{"tabla":"'.$lista.'","aux":"'.$idval.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';
          
          $datos = '{"tabla":"'.$lista.'","aux":"'.$x.'","estado":"'.$estado.'","tipo":"'.$tip.'"}';
         
          echo $datos; 
          //echo 2;
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
      $nroDocumentoPro = "";
      $nroDocumentoOpcionPro = "t";

      //$nroDocumentoOpcionPro = "t";
       if($accion == "guardarValidacion")
       {
           //$idval = $this->vehiculos_model->guardarValidacionVehiculo($idBien,$idGestion,$idCorrespondencia,$adjunta,$legible,$observaciones,$idDocumentoBien);
           $idval = 5205;
           //$update = $this->vehiculos_model->editarDetalleValidacionveh($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
           $update = $this->maquinaria_model->editarDetalleValidacionmaq($idval,$nroDocumentoPro,$nroDocumentoOpcionPro,null,null,null,null,null,null,null,null);
           echo 2;
       
      }
  
    }


      
}
?>