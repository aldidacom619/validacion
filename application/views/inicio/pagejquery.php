<?php
function script() {
  $script = "<script type='text/javascript'> src='".base_url()."jsd/vehiculos.js'";
  $script .= "</script>";
  return $script;
}
function script2() {
  $script = "<script type='text/javascript'>";
  $script .= "  $(function() {";
  $script .= "    	$( '.btnvalidarvehiculo').click(function(e) {";
  //$script .= "alert('hola');";  
  $script .= "		e.preventDefault();";  
  
  $script .= "	});";  
  //$script .= "    $( '#format' ).buttonset();";
  $script .= "  });";
  $script .= "</script>";
  return $script;
}
function script3(){
	 $script = "<script type='text/javascript'>";
	
	 $script .= "$(document).ready(function(){";
	 	
	 $script .= " 	$('#search').keyup(function(){";
	$script .= " 		_this = this;";
	$script .= "	 	$.each($('.mytable tbody tr'), function() {";
	$script .= " 			if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)";
	$script .= " 			$(this).hide();";
	$script .= " 			else";
	$script .= " 			{ $(this).show();}";
	//$script .= " 		alert('hola:'+ $(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()));}";
	$script .= " 		});";
	$script .= " 	 });";
	$script .= "});";
	$script .= "</script>";
 return $script;

}
if(isset($opcion)) {
	switch($opcion) {
		
		case 'data_bien':
				$script2 = script2();
      			echo $script2;
      			$script3 = script3();
      			echo $script3;
      			echo "<center>";
      			//echo "<div id='dataresp2'> prueba</div>";
      			echo "<button type='button' class='btn btn-info active' style='background-color: #fff;padding: 15px 15px;'></button><label>&nbsp Sin validar &nbsp</label>";
                echo "<button type'button' class='btn btn-info active' style='background-color: #fea6a0;padding: 15px 15px;''></button><label>&nbsp Validado pendiente &nbsp</label>";
                echo "<button type'button' class='btn btn-info active' style='background-color: #d5f8b5;padding: 15px 15px;''></button><label>&nbsp Validado &nbsp</label>";
      		  	echo "<button type'button' class='btn btn-info active' style='background-color: #f0f194;padding: 15px 15px;''></button><label>&nbsp Validado Automático &nbsp</label>";
      		  echo "<div class='form-group'>";
 			  echo "<input type='text' class='form-control pull-right' style='width:10%' id='search' placeholder='Buscar...'>";
			  echo "</div>";
      		if($datosbien_v != FALSE) {

				$cont = 1;
				//iicio paneles con tablas
				echo "<div style ='padding:0px 15px' class='panel panel-default'>";
				echo "<div class='panel panel-primary'>";

				 echo "<div class='panel-heading'>Listado de vehículos</div>";
				 //paneles con tablas
				  //echo "<div class='panel-body'>";
				    //echo "<p>...</p>";
				  //echo "</div>";
				//echo "<div class='panel-heading'>";
		        	//echo "<h4>";
		        	//echo "LISTADO DE VEHICULOS "; 
		        //echo "</div>";
        echo "<div style='max-height: 300px; overflow-y: scroll; width: 97%;'>";
        
        echo "<table width='100%' class='table table-striped mytable' id='dataTables-example' >";
					echo "<thead>";
					//cod_asig, cod_af, descripcion, subgrupo, estado
						echo "<tr><td>No</td>
								  <td>OPCIONES</td>
								  <td>IDBIEN</td>
								  <td>CLASE</td>
								  <td>TIPO VEHICULO</td>
								  <td>MARCA</td>
								  <td>PLACA</td>
								  <td>NRO. CHASIS</td>
								  <td>NRO MOTOR</td>
								  <td>DOCUMENTOS</td>
								 
								  <td>ENTIDAD</td>";
								  //<td>RUBRO</td></tr>
					echo "</thead>";
					echo "<tbody>";
					foreach($datosbien_v as $fila) {
						//
						if ($fila->idestadovalidacion==5) echo "<tr style='background-color:#fea6a0;'>";
						else 
						 {	
							if ($fila->idestadovalidacion==3) 
									 {
	                                    if ($fila->idtipovalidacion==2) 
	                                           echo "<tr style='background-color:#f0f194;'>";
	                                        else
	                                          echo "<tr style='background-color:#d5f8b5;'>";
	                                  } 
								
							else echo "<tr>";
						}
						    echo "<td>".$cont."</td>";
							echo "<td width='20'> 
              <button name='btnvalidarvehiculo' class='btn btn-primary anchoBotones btnvalidarvehiculo' onclick='abrirDialogValidacionVehiculo(".$fila->id.",".$fila->identidad.")'>Validar  Doc..</button>";
						if($fila->documentos == '')	{
							echo "<button name='btnSinDocumentacion' class='btn btn-danger anchoBotones btnvalidarvehiculo' onclick='validarSinDocumentacion(".$fila->id.",3)'>Sin Doc</button>";
						}               		



              echo "</td>";
							
              				$resultado3 = strripos($fila->idbien, $dato_b);
														if($resultado3 !== FALSE)
															echo "<td style='color: #ec110a;'>".$fila->idbien."</td>";	
														else
															echo "<td>".$fila->idbien."</td>";	
							echo "<td>".$fila->clase."</td>";
							echo "<td>".$fila->tipobien."</td>";
							echo "<td>".$fila->marca."</td>";
							$resultado = strripos($fila->placa, $dato_b);
							if($resultado !== FALSE)
    							echo "<td style='color: #ec110a;'>".$fila->placa."</td>";
							else
								echo "<td>".$fila->placa."</td>";
							

							$resultado1 = strripos($fila->nrochasis, $dato_b);
							if($resultado1 !== FALSE)
								echo "<td style='color: #ec110a;'>".$fila->nrochasis."</td>";
							else
								echo "<td>".$fila->nrochasis."</td>";
							echo "<td>".$fila->nromotor."</td>";
							

							$resultado2 = strripos($fila->documentos, $dato_b);
							if($resultado2 !== FALSE)
								echo "<td style='color: #ec110a;'>".$fila->documentos."</td>";
							else
								echo "<td>".$fila->documentos."</td>";

							echo "<td>".$fila->nombre."</td>";
							//echo "<td>".$fila->rubro."</td>";
							//echo "<td>".$fila->estado."</td>";
							//echo "<input type='hidden' name='".$cod."' id='".$cod."' value='".$fila->id_af."'>";
						echo "</tr>";
						$cont++;
					}
					echo "</tbody>";
					echo "</table>";
					//paneul table
					echo "</div>";
					echo "</div>";
					//fin panel table
			} else echo "<div class='alert alert-danger'>
                              <p>No existe informacion en el rubro Vehículos</p>
                    	 </div>";
			echo "</div>";
      //echo "<br>";
      if($datosbien_mp != FALSE) {

				$cont = 1;
        	//iicio paneles con tablas
				echo "<div style ='padding:0px 15px' class='panel panel-default'>";
				echo "<div class='panel panel-primary'>";

				 echo "<div class='panel-heading'>Listado de maquinaria pesada móvil</div>";
				 //paneles con tablas
        //echo "<div class='panel-heading'>";
			        	//echo "<h4>";
			        	//echo "LISTA DE MAQUINARIA PESADA MOVIL"; 
			        //echo "</div>";
        echo "<div style='max-height: 300px; overflow-y: scroll; width: 97%;'>";
					
				echo "<table width='100%' class='table table-striped mytable'>";
					echo "<thead>";
					//cod_asig, cod_af, descripcion, subgrupo, estado
						echo "<tr><td>No</td>
								  <td>OPCIONES</td>
								  <td>IDBIEN</td>
								  <td>DESCRIPCION</td>
								  <td>TIPO BIEN</td>
								  <td>MARCA</td>
								  <td>MODELO</td>
								  <td>CHASIS</td>
								  <td>MOTOR</td>
								  <td>DOCUMENTOS</td>
								 
								  <td>ENTIDAD</td>";
								  //<td>RUBRO</td></tr>
					echo "</thead>";
					echo "<tbody>";
					foreach($datosbien_mp as $fila1) {
						if ($fila1->idestadovalidacion==5) echo "<tr style='background-color:#fea6a0;'>";
						else 
						{	
							if ($fila1->idestadovalidacion==3) 
									 {
	                                    if ($fila1->idtipovalidacion==2) 
	                                           echo "<tr style='background-color:#f0f194;'>";
	                                        else
	                                          echo "<tr style='background-color:#d5f8b5;'>";
	                                  } 
								
							else echo "<tr>";
						}
						
							echo "<td>".$cont."</td>";
							echo "<td>
							<input type='button' class='btn btn-primary anchoBotones' onclick='abrirDialogValidacionMaquinariaPesada(".$fila1->id.",".$fila1->identidad.")' value='Validar Doc..'>";
							if($fila1->documentos==''){
								echo "<button name='btnSinDocumentacion' class='btn btn-danger anchoBotones btnvalidarvehiculo' onclick='validarSinDocumentacion(".$fila1->id.",6)'>Sin Doc</button>";
							}

							echo "</td>";
							$resultado5 = strripos($fila1->idbien, $dato_b);
										if($resultado5 !== FALSE)
											echo "<td style='color: #ec110a;'>".$fila1->idbien."</td>";
											else
											echo "<td>".$fila1->idbien."</td>";
							echo "<td>".$fila1->descripcion."</td>";
							echo "<td>".$fila1->tipobien."</td>";
							echo "<td>".$fila1->marca."</td>";
							echo "<td>".$fila1->modelo."</td>";

							$resultado3 = strripos($fila1->nrochasis, $dato_b);
							if($resultado3 !== FALSE)
								echo "<td style='color: #ec110a;'>".$fila1->nrochasis."</td>";
							else
								echo "<td>".$fila1->nrochasis."</td>";	
							echo "<td>".$fila1->nromotor."</td>";

							$resultado4 = strripos($fila1->documentos, $dato_b);
							if($resultado4 !== FALSE)
								echo "<td style='color: #ec110a;'>".$fila1->documentos."</td>";
							else
								echo "<td>".$fila1->documentos."</td>";
							echo "<td>".$fila1->nombre."</td>";
							//echo "<td>".$fila1->rubro."</td>";
							//echo "<td>".$fila->estado."</td>";
							//echo "<input type='hidden' name='".$cod."' id='".$cod."' value='".$fila->id_af."'>";
						echo "</tr>";
						$cont++;
					}
					echo "</tbody>";
          echo "</table>";
          //panel table
          echo "</div>";
          echo "</div>";
          // fin panel table
			   echo "<center>";
			} else echo "<div class='alert alert-danger'>
                              <p>No existe informacion en el rubro Maquinaria Pesada Móvil </p>
                    	 </div>";
          echo "</div>";



          //inicio inmuebles
          if($datosbien_inm != FALSE) {

				$cont = 1;
        	//iicio paneles con tablas
				echo "<div style ='padding:0px 15px' class='panel panel-default'>";
				echo "<div class='panel panel-primary'>";

				 echo "<div class='panel-heading'>Listado de Inmuebles</div>";
				 //paneles con tablas
        //echo "<div class='panel-heading'>";
			        	//echo "<h4>";
			        	//echo "LISTA DE MAQUINARIA PESADA MOVIL"; 
			        //echo "</div>";
        echo "<div style='max-height: 300px; overflow-y: scroll; width: 97%;'>";
					
				echo "<table width='100%' class='table table-striped mytable'>";
					echo "<thead>";
					//cod_asig, cod_af, descripcion, subgrupo, estado
						echo "<tr><td>No</td>
								  <td>OPCIONES</td>
								  <td>IDBIEN</td>
								  <td>DENOMINACION INMUEBLE</td>
								  <td>TERRENO O EDIFICACIÓN</td>
								  <td>DIRECCIÓN</td>
								  <td>SUP. TERRENO</td>
								  <td>SUP. CONTRUIDA</td>
								  <td>DEPARTAMENTO</td>
								  <td>DOCUMENTOS</td>
								 
								  <td>ENTIDAD</td>";
								  //<td>RUBRO</td></tr>
					echo "</thead>";
					echo "<tbody>";
					foreach($datosbien_inm as $fila2) {
						if ($fila2->idestadovalidacion==5) echo "<tr style='background-color:#fea6a0;'>";
						else 
						{	
							if ($fila2->idestadovalidacion==3) 
									 {
	                                    if ($fila2->idtipovalidacion==2) 
	                                           echo "<tr style='background-color:#f0f194;'>";
	                                        else
	                                          echo "<tr style='background-color:#d5f8b5;'>";
	                                  } 
								
							else echo "<tr>";
						}
							echo "<td>".$cont."</td>";
							echo "<td>
							<input type='button' class='btn btn-primary anchoBotones' onclick='abrirDialogValidacion(".$fila2->id.",".$fila2->identidad.")' value='Validar Doc..'>";
							if($fila2->documentos==''){
								echo "<button name='btnSinDocumentacion' class='btn btn-danger anchoBotones btnvalidarvehiculo' onclick='validarSinDocumentacion(".$fila2->id.",1)'>Sin Doc</button>";
							}

							echo "</td>";

							$resultado6 = strripos($fila2->idbien, $dato_b);
														if($resultado6 !== FALSE)
															echo "<td style='color: #ec110a;'>".$fila2->idbien."</td>";	
														else
															echo "<td>".$fila2->idbien."</td>";
							echo "<td>".$fila2->denominacion."</td>";
							echo "<td>".$fila2->tipobien."</td>";

							$resultado3 = strripos($fila2->direccion, $dato_b);
														if($resultado3 !== FALSE)
															echo "<td style='color: #ec110a;'>".$fila2->direccion."</td>";
														else
															echo "<td>".$fila2->direccion."</td>";	

							
							$resultado5 = strripos($fila2->superficieterreno, $dato_b);
														if($resultado5 !== FALSE)
															echo "<td style='color: #ec110a;'>".$fila2->superficieterreno."</td>";
														else
															echo "<td>".$fila2->superficieterreno."</td>";								


							echo "<td>".$fila2->superficieconstruida."</td>";
							echo "<td>".$fila2->departamento."</td>";
							
							
							$resultado4 = strripos($fila2->documentos, $dato_b);
							if($resultado4 !== FALSE)
								echo "<td style='color: #ec110a;'>".$fila2->documentos."</td>";
							else
								echo "<td>".$fila2->documentos."</td>";
							echo "<td>".$fila2->nombre."</td>";
							//echo "<td>".$fila1->rubro."</td>";
							//echo "<td>".$fila->estado."</td>";
							//echo "<input type='hidden' name='".$cod."' id='".$cod."' value='".$fila->id_af."'>";
						echo "</tr>";
						$cont++;
					}
					echo "</tbody>";
          echo "</table>";
          //panel table
          echo "</div>";
          echo "</div>";
          // fin panel table
			   echo "<center>";
			} else echo "<div class='alert alert-danger'>
                              <p>No existe informacion en el rubro Inmuebles</p>
                    	 </div>";
          echo "</div>";
          //fin inmuebles
		break;
		case 'data_identidad':
		echo $nombreEntidad->nombre;
		break;
		
	}
}
?>