<?php 
class Documentos extends CI_Controller 
{
  function __construct(){
    parent::__construct();
    $this->_is_logued_in();
    $this->load->model('usuarios_model');
    //$this->load->model('inmuebles_model');
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
  //pruebas
 
  function getTipoDocumentos()
  {

          $idtipo = $this->input->get('id');
        //  $idtipo = 1;
          $filas =  $this->documentacion_model->getTipoDocumentacionbienalquiler($idtipo);
          $options="<option value='-1'>Seleccione un Tipo Documento</option>";
          foreach($filas as $fila)
          {

               $options.= "<option value='".$fila->id."'>".$fila->descripcion."</option>";
          }     
          
          echo $options;
          //echo  $idtipo;
  }
  

  function getTipoDocumentos3()
  { 

          $idtipo = $this->input->get('id');
          $idbien = $this->input->get('idb');
          if($idtipo == 5 || $idtipo == 7)
          {
            $filas =  $this->documentacion_model->getTipoDocumentacionbienalquiler($idtipo,$idbien);
          }
          else
          {
              $filas =  $this->documentacion_model->getTipoDocumentacionbien($idtipo,$idbien);
            }
        $options="<option value='-1'>Seleccione un Tipo Documento</option>";
          foreach($filas as $fila)
          {
               $options.= "<option value='".$fila->id."'>".$fila->descripcion."</option>";
          }     
          echo $options;
  }  


  function listadoAddAlquiler()
  {
 
      $idbien = $this->input->get('id');
      // $idbien = 3847; 

       $datos =  $this->documentacion_model->getTablaDocumentosBienAddalquiler($idbien);
       $options  = "<tr>";
       $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th>"; 
       $options.= "</tr>";
         
          foreach($datos as $fila)
          {
            
            $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documemntosver(".$fila->id.")'>Editar</button>";
            $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='documemntoseliminar(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td>";
               $options.= "</tr>";   
          }     
          echo $options;
  }

  function listadoAdd()
  {
     $idbien = $this->input->get('id');

      $datos =  $this->documentacion_model->getTablaDocumentosBienAdd($idbien);
        $options  = "<tr>";
       $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th>"; 
       $options.= "</tr>";
         
          foreach($datos as $fila)
          {
            
            $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documemntosver(".$fila->id.")'>Editar</button>";
            $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='documemntoseliminar(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td>";
               $options.= "</tr>";   
          }     
          echo $options;
  }

  function guraaaa()
  {
     $idfun = $this->session->userdata('idfuncionario');
     $datestring = " %Y-%m-%d %H:%i:%s";
      $time = time();
      $fecha =  mdate($datestring, $time);

      $insert = $this->documentacion_model->insertar_documento(36967,2,45678,$fecha,$idfun);
      echo $insert;
  }
  function guardardocumento()
  {
      $idfun = $this->session->userdata('idfuncionario');
      $accion = $this->input->get('accionDoc');
      $tipoDoc = $this->input->get('cbTipoDocumentoAdicionar');
      $nroDoc = $this->input->get('txtNroDocumentoAdicionar');
      $idB = $this->input->get('txtIdBienAdicionarDoc');
      $idDoc = $this->input->get('txtIdDocAdd');
      $clase = $this->input->get('txtIdClaseDoc');

      $datestring = " %Y-%m-%d %H:%i:%s";
      $time = time();
      $fecha =  mdate($datestring, $time);
      if($accion == "nuevoDoc")
      { 
        
        $estadobien = $this->documentacion_model->getdatosbien($idB);
        $idbien = $estadobien[0]->idbien;
        $insert = $this->documentacion_model->insertar_documento($idB,$idbien,$tipoDoc,$nroDoc,$fecha,$idfun);
        
        $datos =  $this->documentacion_model->getTablaDocumentosBienAdd($idB);



        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th>"; 
        $options.= "</tr>";
         
          foreach($datos as $fila)
          {
            $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documemntosver(".$fila->id.")'>Editar</button>";
            $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='documemntoseliminar(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td>";
               $options.= "</tr>";  
          } 
          $x = 1;    
          $insert = 1;

           $filas =  $this->documentacion_model->getTipoDocumentacionbien($clase,$idB);
            
        $options2="<option value='-1'>Seleccione un Tipo Documento</option>";
          foreach($filas as $fila)
          {
               $options2.= "<option value='".$fila->id."'>".$fila->descripcion."</option>";
          }     

         $datos = '{"tabla":"'.$options.'","iddocume":"'.$insert.'","aux":"'.$x.'","doc":"'.$options2.'"}';
         
          echo $datos; 
         
      }
      if($accion == "editarDoc")
      {

        $insert = $this->documentacion_model->update_documento($idDoc,$tipoDoc,$nroDoc,$fecha);

        $datos =  $this->documentacion_model->getTablaDocumentosBienAdd($idB);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th>"; 
        $options.= "</tr>";
         
          foreach($datos as $fila)
          {
            $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documemntosver(".$fila->id.")'>Editar</button>";
            $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='documemntoseliminar(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td>";
               $options.= "</tr>";  
          } 
        
        $x = 2;    
          
        $datos = '{"tabla":"'.$options.'","iddocume":"'.$idDoc.'","aux":"'.$x.'"}';
         
        echo $datos;
       }
    

  }
  function guardardocumentoalquiler()
  {
      $idfun = $this->session->userdata('idfuncionario');
      $accion = $this->input->get('accionDoc');
      $tipoDoc = $this->input->get('cbTipoDocumentoAdicionar');
      $nroDoc = $this->input->get('txtNroDocumentoAdicionar');
      $idB = $this->input->get('txtIdBienAdicionarDoc');
      $idDoc = $this->input->get('txtIdDocAdd');
      $datestring = " %Y-%m-%d %H:%i:%s";
      $time = time();
      $fecha =  mdate($datestring, $time);
      

  
      
      
      if($accion == "nuevoDocAlquiler")
        if(1 == 1)
      { 
        $estadobien = $this->documentacion_model->getdatosbienalquiler($idB);
        $idbien = $estadobien[0]->idbien;        
        $insert = $this->documentacion_model->insertar_documentoalquiler($idB,$idbien,$tipoDoc,$nroDoc,$fecha,$idfun);
      //  echo "$idBien -$tipoDoc -$nroDoc -$fecha - $idfun - $idBien";
       
       $datos =  $this->documentacion_model->getTablaDocumentosBienAddalquiler($idB);
        $options  = "<tr>";
       $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th>"; 
       $options.= "</tr>";
         
          foreach($datos as $fila)
          {
            
            $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documemntosver(".$fila->id.")'>Editar</button>";
            $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='documemntoseliminar(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td>";
               $options.= "</tr>";   
          } 
          $x = 1;    
          $insert = 1;
         $datos = '{"tabla":"'.$options.'","iddocume":"'.$insert.'","aux":"'.$x.'"}';
         
          echo $datos;//*/
         
      }
     else
      {
      
        $insert = $this->documentacion_model->update_documentoalquiler($idDoc,$tipoDoc,$nroDoc,$fecha); 

       $datos =  $this->documentacion_model->getTablaDocumentosBienAddalquiler($idB);
        $options  = "<tr>";
       $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th>"; 
       $options.= "</tr>";
         
          foreach($datos as $fila)
          {
            
            $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documemntosver(".$fila->id.")'>Editar</button>";
            $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='documemntoseliminar(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td>";
               $options.= "</tr>";   
          } 
        
        $x = 2;    
          
        $datos = '{"tabla":"'.$options.'","iddocume":"'.$idDoc.'","aux":"'.$x.'"}';
         
        echo $datos;
       }

  }
  function getDocumentoAlquiler()
  {
      $id = $this->input->get('id');
       //$id = 37134;
     $datos = $this->documentacion_model->selecdocalquiler_id($id);
       //echo $datos[0]->denominacion;
      $json = json_encode($datos); 
      echo $json;
  }
  function getDocumento()
  {
     $id = $this->input->get('id');
       //$id = 37134;
     $datos = $this->documentacion_model->selecdoc_id($id);
       //echo $datos[0]->denominacion;
      $json = json_encode($datos); 
      echo $json;
      //echo $id;
  }
  function eliminarDocumentoAlquiler()
  {
    $idDoc = $this->input->get('id');
    $bien = $this->input->get('bi');
    //echo $bien;
       $eliminar = $this->documentacion_model->eliminarDocumentoAddAlquiler($idDoc);

       $datos =  $this->documentacion_model->getTablaDocumentosBienAddalquiler($bien);
        $options  = "<tr>";
       $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th>"; 
       $options.= "</tr>";
         
          foreach($datos as $fila)
          {
            
            $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documemntosver(".$fila->id.")'>Editar</button>";
            $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='documemntoseliminar(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td>";
               $options.= "</tr>";   
          } 
        
        $x = 2;    
          
        $datos = '{"tabla":"'.$options.'","iddocume":"'.$idDoc.'","aux":"'.$x.'"}';
         
        echo $datos;
  }

  
  function eliminarDocumento()
  {
    $idDoc = $this->input->get('id');
    $idBien = $this->input->get('bi');
    //echo $bien;

        $eliminar = $this->documentacion_model->eliminar_documento($idDoc);
        $datos =  $this->documentacion_model->getTablaDocumentosBienAdd($idBien);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Tipo documento</th><th>Nro Documento</th><th>Gestión Registro</th>"; 
        $options.= "</tr>";
         
          foreach($datos as $fila)
          {
            $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='documemntosver(".$fila->id.")'>Editar</button>";
            $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='documemntoseliminar(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->nrodocumento."</td><td>".$fila->gestion."</td>";
               $options.= "</tr>";  
          } 
        
        $x = 2;    
          
        $datos = '{"tabla":"'.$options.'","iddocume":"'.$idDoc.'","aux":"'.$x.'"}';
         
        echo $datos;
  }

//PERSONAS

  function getTipoDocumentos2()
  {

          $idtipo = $this->input->get('id');
          $doc = $this->input->get('doc');


          if($idtipo == 5 || $idtipo == 7)
        {
          $datos = $this->documentacion_model->getValidacionDocumentoalquiler($doc);
          $tipodoc=$datos[0]->idtipodocumento;
        }
        else
        {
          $datos = $this->documentacion_model->getValidacionDocumento($doc);
          $tipodoc=$datos[0]->idtipodocumento; 
        }
        //  $idtipo = 1;
          $options="";
          $filas =  $this->documentacion_model->getTipoDocumentaciontipo($tipodoc);
          
          foreach($filas as $fila)
          {

               $options.= "<option value='".$fila->id."'>".$fila->descripcion."</option>";
          }     
          echo $options;
          //echo  $idtipo;
  }  
  function listadoPersona()
  {
    $id = $this->input->get('id');
      //$estado = $this->input->get('estado');
       
      
       $datos = $this->documentacion_model->getTablaPersonaDocumentosBien($id);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Nombre/Razón</th><th>Tipo Persona/Entidad</th><th>Documento</th>"; 
       $options.= "</tr>";
           
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='editarpersona(".$fila->id.")'>Editar</button>";
               $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='eli_persona(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->tipodatoadicional."</td><td>".$fila->documento."</td>";
               $options.= "</tr>";
          }     
          
       echo $options; 
       //echo $id; 
  }
    function listadoPersonaalquiler()
  {
    $id = $this->input->get('id');
      //$estado = $this->input->get('estado');
       
      
       $datos = $this->documentacion_model->getTablaPersonaDocumentosBienAlquiler($id);
        $options  = "<tr>";
        $options.="<th>OPC.</th><th>ID</th><th>Nombre/Razón</th><th>Tipo Persona/Entidad</th><th>Documento</th>"; 
       $options.= "</tr>";
           
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='editarpersona(".$fila->id.")'>Editar</button>";
               $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='eli_persona(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->tipodatoadicional."</td><td>".$fila->documento."</td>";
               $options.= "</tr>";
          }     
          
       echo $options; 
       //echo $id; 
  }


function getEntidades()
{
  
  $filas =  $this->documentacion_model->getentidades();
  $options="<option value='-1'>Seleccione alguna Entidad</option>";
  $options="<option value='-1'>Seleccione un Tipo Documento</option>";
  foreach($filas as $fila)
  {
       $options.= "<option value='".$fila->entidad."'>".$fila->entidad."</option>";
  }     
  echo $options;
}
function getEntidadesText()
{  
    $var = $_GET["term"];
    $filas =  $this->documentacion_model->getentidadestext($var);
    foreach($filas as $fila)
    {
         $row_set[] = $fila->entidad;
    } 
    echo json_encode($row_set);
}

function guardarpersona()
{
      $datestring = " %Y-%m-%d %H:%i:%s";
      $time = time();
      $fecha =  mdate($datestring, $time);
      $accion = $this->input->get('accionPersona');
      $tipoDoc=$this->input->get('cbTipoDocumentoPropietario');
     $idpersona = $this->input->get('txtIdPersona');
      $tipoPersona = $this->input->get('cbPropietario');
      if($tipoPersona == 1)
         {$persona=$this->input->get('txtNuevoPropietario');}
      if($tipoPersona == 2)
          {$persona=$this->input->get('txtNuevaEntidadPublica');}
      if($tipoPersona == 3)
        {$persona=$this->input->get('txtNuevaEntidadPrivada');}
      if($tipoPersona == 4)
        {$persona=$this->input->get('txtNuevoPropietario');}    

        $idb=$this->input->get('txtIdBienAdicionarPersona');
        $doc=$this->input->get('txtIddocAdicionarPersona');
      $claseBien = $this->input->get('txtClaseBien');
         if($claseBien == 5 || $claseBien == 7)
        {
          $datos = $this->documentacion_model->getValidacionDocumentoalquiler($doc);
          $idBien=$datos[0]->idbien;   
        }
        else
        {
          $datos = $this->documentacion_model->getValidacionDocumento($doc);
          $idBien=$datos[0]->idbien;
        }
        $claseBien = $this->input->get('txtClaseBien');
    
      $idfun = $this->session->userdata('idfuncionario');  
      $options = "";
      $insert = 0;
     // echo $accion;
     if($accion == "nuevaPersona")
      { 
        if($claseBien == 5 || $claseBien == 7)
        {  $insert = $this->documentacion_model->insertar_personaalquiler($idb,$doc,$idBien, $tipoDoc, $tipoPersona, $persona,$idfun);
            $datos = $this->documentacion_model->getTablaPersonaDocumentosBienAlquiler($doc);
            //$datos = $this->documentacion_model->getTablaPersonaDocumentosBien($idBien);
        }
        else
        {  $insert = $this->documentacion_model->insertar_persona($idb,$doc,$idBien, $tipoDoc, $tipoPersona, $persona,$idfun);
            $datos = $this->documentacion_model->getTablaPersonaDocumentosBien($doc);
         }

  
          $options  = "<tr>";
          $options.="<th>OPC.</th><th>ID</th><th>Nombre/Razón</th><th>Tipo Persona/Entidad</th><th>Documento</th>"; 
          $options.= "</tr>";
             
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='editarpersona(".$fila->id.")'>Editar</button>";
               $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='eli_persona(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->tipodatoadicional."</td><td>".$fila->documento."</td>";
               $options.= "</tr>";
          }
          $x = 1;    
          
         

          $datos = '{"tabla":"'.$options.'","iddocume":"'.$insert.'","aux":"'.$x.'"}';
         
          echo $datos;
          
         
      }
      else
      {

        if($claseBien == 5 || $claseBien == 7)
        {  $insert = $this->documentacion_model->editarPersonaDocumentoBienAlquiler($idpersona, $tipoDoc, $tipoPersona, $persona);

          $datos = $this->documentacion_model->getTablaPersonaDocumentosBienAlquiler($doc);
          }
        else
        {  $insert = $this->documentacion_model->editarPersonaDocumentoBien($idpersona, $tipoDoc, $tipoPersona, $persona); 
          $datos = $this->documentacion_model->getTablaPersonaDocumentosBien($doc);
        }
        

        
        //$datos = $this->documentacion_model->getTablaPersonaDocumentosBien($idBien);
          $options  = "<tr>";
          $options.="<th>OPC.</th><th>ID</th><th>Nombre/Razón</th><th>Tipo Persona/Entidad</th><th>Documento</th>"; 
          $options.= "</tr>";
             
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='editarpersona(".$fila->id.")'>Editar</button>";
               $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='eli_persona(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->tipodatoadicional."</td><td>".$fila->documento."</td>";
               $options.= "</tr>";
          }
          $x = 2;    
          
         

          $datos = '{"tabla":"'.$options.'","iddocume":"'.$idpersona.'","aux":"'.$x.'"}';
         
          echo $datos;
      }


}
function getPersona()
{
      $id = $this->input->get('id');
      $tipo = $this->input->get('tipo');
       //$id = 37134;
      if ($tipo == 5 || $tipo == 7 )
      {
        $datos = $this->documentacion_model->getPersonaAdicionadoalquiler($id);
      }
      else
      {
        $datos = $this->documentacion_model->getPersonaAdicionado($id);  
      }
      

       //echo $datos[0]->denominacion;
      $json = json_encode($datos); 
      echo $json;
}

function eliminarpersona()
{
      $id = $this->input->get('idper');
      $claseBien = $this->input->get('tipo');
      $idBien = $this->input->get('bien');

        if($claseBien == 5 || $claseBien == 7)
        { 
            $insert = $this->documentacion_model->eliminar_personaalquiler($id);
            $datos = $this->documentacion_model->getTablaPersonaDocumentosBienAlquiler($idBien);
            //$datos = $this->documentacion_model->getTablaPersonaDocumentosBien($idBien);
        }
        else
        {  $insert = $this->documentacion_model->eliminar_persona($id);
            $datos = $this->documentacion_model->getTablaPersonaDocumentosBien($idBien);
         }

  
          $options  = "<tr>";
          $options.="<th>OPC.</th><th>ID</th><th>Nombre/Razón</th><th>Tipo Persona/Entidad</th><th>Documento</th>"; 
          $options.= "</tr>";
             
          foreach($datos as $fila)
          {
              $boton =  "<button name='btnValidarInmueble' class='fa fa-pencil' onclick='editarpersona(".$fila->id.")'>Editar</button>";
               $boton2 =  "<button name='btnValidarInmueble' class='fa fa-times' onclick='eli_persona(".$fila->id.")'>Eliminar</button>";
              $options.= "<tr>";
                $options.= "<td>".$boton." ".$boton2."</td><td>".$fila->id."</td><td>".$fila->descripcion."</td><td>".$fila->tipodatoadicional."</td><td>".$fila->documento."</td>";
               $options.= "</tr>";
          }
          $x = 1;    
          
         

          $datos = '{"tabla":"'.$options.'","aux":"'.$x.'"}';
         
          echo $datos;
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
    
      }
 

    }


    function validarSinDoc()
    {
      $bien = $this->input->get('bien');
      $tipo = $this->input->get('tipo');
      $datestring = " %Y-%m-%d %H:%i:%s";
      $time = time();  
      $fecha =  mdate($datestring, $time);
      $idusu = $this->session->userdata('idfuncionario');
      
      if($tipo == 5 || $tipo == 7)
      {
        $datos = $this->documentacion_model->getrubrobien2($bien);
      } 
      else
      { 
        $datos = $this->documentacion_model->getrubrobien($bien);
      }

      $rubro=$datos[0]->idclase;
      $entidad=$datos[0]->identidad;
      $idbien=$datos[0]->idbien;

      $bitacora = $this->documentacion_model->insertar_bitacora(1,$idusu,$idbien,0,0,'f',$rubro,$entidad,'SIN DOCUMENTOS',$fecha,$fecha,$bien);



      $insert = $this->documentacion_model->validarSinDocumento($bien,$tipo,$fecha);
      echo $bien; 
    }

  
}
?>