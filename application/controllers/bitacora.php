 function bitacora($idBien,$idDocumento,$accion)
    {
          $datestring = " %Y-%m-%d %H:%i:%s";
          $time = time();
          $fecha =  mdate($datestring, $time);

           $idusu = $this->session->userdata('idfuncionario');
           $datos = $this->inmuebles_model->getValidacionDocumento1($idDocumento);
           $adicionado=$datos[0]->adicionado;
           $tipodocumento=$datos[0]->idtipodocumento;
           $bitacora = $this->documentacion_model->insertar_bitacora(1,$idusu,$idBien,$idDocumento,$tipodocumento,$adicionado,$fecha,$fecha);

    }



    function insertar_bitacora($accion,$idusu,$idBien,$iddoc,$idtipodoc,$adicionado,$fecha1,$fecha2)
  {
    
      $data = array(
          'accion' => $accion,  
          'idvalidador'=> $idusu,
          'idbien'=> $idBien,
          'iddocumento'=> $iddoc,
          'idtipodoc'=> $idtipodoc,
          'adicionado'=> $adicionado,
          'fecdoc'=> $fecha1,
          'fechadocumento'=> $fecha2
        );
      $this->db->insert('nueva_validacion.bitacora2',$data); 
    return $this->db->insert();

  } 