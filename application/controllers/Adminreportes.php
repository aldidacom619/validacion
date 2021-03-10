<?php

class Adminreportes extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->_is_logued_in();
        $this->load->model('usuarios_model');
        $this->load->model('entidades_model'); 
        $this->load->model('reportes_model');
        $this->load->model('users_universo');
        $this->load->model('resumenentidades_model');
        $this->load->model('model');
        $this->load->model('adminusuario_model');
        $this->load->model('adminusersuniverso_model');
        $this->load->model('adminentidades_model');
        $this->load->model('adminclase_model');
        $this->load->library('pdf2');
        $this->load->library('pdf3');
        $this->load->helper('validacion_helper');
        $this->load->helper(array('form', 'url'));
        $this->usuario['usuario'] = $this->session->userdata('nombre_completo');
        $this->_is_logued_in();
    }
    function _is_logued_in() {
        $is_logued_in = $this->session->userdata('is_logued_in');        
        $tipo_user = $this->session->userdata('administrador');
        if($is_logued_in == 1){
            if($tipo_user != 't'){
                redirect('inicio');
            }
        }  
        else{
            redirect('usuarios');
        }
    }

    public function index() {
        $data["getuser"] = $this->adminusuario_model->get();
        $data["getclase"] = $this->adminclase_model->get();
        $data["hoy"] = date('d/m/Y');
        $this->load->view("layout/cabecera", $this->usuario);
        $this->load->view("adminreportes/index", $data);
        $this->load->view("layout/pie"); 
    }

    public function entidadesAsignadas($idSelector) {
        $html = '';
        if($idSelector == 1)
            $html .= '<option value="all"> -- Todos -- </option>';
        else
            $html .= '<option value=""> -- Seleccione -- </option>';
        $entidades = $this->model->lista('*'
                , 'nueva_validacion.users_universo a'
                , 'INNER JOIN nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di b ON a.identidad=b.id'
                , 'AND a.idusuario=' . $this->input->post('id') . '
                AND a.asignado=true
                ORDER BY b.nombre');
        foreach ($entidades as $entidad) {
            $html .= '<option value=' . $entidad->identidad . '>' . $entidad->nombre . '</option>';
        }
        echo $html;
    }

    public function reportegeneral() {

        $this->pdf = new Pdf3();
        $this->pdf->AddPage();
        $this->pdf->AliasNbPages();
        $this->pdf->SetTitle("Reporte");
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->Cell(50, 4, 'Fecha: ' . date('d') . ' de ' . $this->pdf->mes[date('n')] . ' del ' . date('Y') . ' Hora: ' . date('H:i:s'));
        $this->pdf->ln(8);
        $this->pdf->SetFillColor(200, 200, 200);
        $this->pdf->SetFont('Arial', 'B', 7);
        $this->pdf->Cell(5, 8, '#', 'TBL', 0, 'C', '1');
        $this->pdf->Cell(60, 8, 'Entidad', 'TB', 0, 'C', '1');
        $this->pdf->Cell(20, 8, 'Departamento', 'TB', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'Bienes', 'T', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'Bienes', 'T', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'Documentos', 'T', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'Documentos', 'T', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'Documentos', 'T', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'Documentos', 'TR', 0, 'C', '1');
        $this->pdf->ln();
        $this->pdf->Cell(85, 4, '');
        $this->pdf->Cell(17, 4, 'declarados', 'B', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'validados', 'B', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'declarados', 'B', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'validados', 'B', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'por validar', 'B', 0, 'C', '1');
        $this->pdf->Cell(17, 4, 'agregados', 'BR', 0, 'C', '1');
        $this->pdf->SetFillColor(255, 255, 255);
        if($this->input->get('selValidador1')&&$this->input->get('selEntidad1'))
        {
        if ($this->input->get('selValidador1') == 'all') {
            $val = '';
        } else {
            $val = 'AND a.idusuario=' . $this->input->get('selValidador1');
        }
        if ($this->input->get('selEntidad1') == 'all') {
            $entidad = '';
        } else {
            $entidad = ' AND b.id=' . $this->input->get('selEntidad1');
        }
        $datosentidad = $this->model->lista('c.nombre validador,b.nombre entidad,*'
                , 'nueva_validacion.users_universo a'
                , 'INNER JOIN nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di b ON a.identidad=b.id
                    INNER JOIN nueva_validacion.usuario c ON a.idusuario=c.id_funcionario'
                , $val . " " . $entidad . "
                AND a.asignado=true ORDER BY c.nombre");

        $cont = 1;
        $validadornombre = '';
        $validadortotal = '';
        $total_bien = 0;
        $total_bien_val = 0;
        $total_doc = 0;
        $total_doc_val = 0;
        $total_doc_noval = 0;
        $total_doc_agre = 0;
        $this->pdf->SetFont('Arial', '', 7);
        foreach ($datosentidad as $dato) {
            if ($validadornombre != $dato->validador) {
                $this->pdf->ln();
                $this->pdf->SetFillColor(150, 150, 150);
                $this->pdf->AjustaCelda(187, 4, utf8_decode($dato->validador), 1, 0, 'C', '1');
                $validadornombre = $dato->validador;
                $cont = 1;
            }
            $this->pdf->SetFillColor(300, 300, 300);
            $this->pdf->ln();
            $this->pdf->Cell(5, 4, $cont++, 1, 0, 'L', '1');
            $this->pdf->AjustaCelda(60, 4, utf8_decode($dato->entidad), 1, 0, 'L', '1');
            $this->pdf->AjustaCelda(20, 4, utf8_decode($dato->departamento), 1, 0, 'L', '1');
            $this->pdf->Cell(17, 4, $dato->totalbienes, 1, 0, 'R', '1');
            $this->pdf->Cell(17, 4, $dato->bienesvalidados, 1, 0, 'R', '1');
            $this->pdf->Cell(17, 4, $dato->totaldocumentos + $dato->totaldocumentos_adicionado, 1, 0, 'R', '1');//2019
            $this->pdf->Cell(17, 4, $dato->totaldocumentos_val + $dato->totaldocumentos_adicionado_val, 1, 0, 'R', '1');
            $this->pdf->Cell(17, 4, $dato->totaldocumentos_noval + $dato->totaldocumentos_adicionado_noval, 1, 0, 'R', '1');
            $this->pdf->Cell(17, 4, $dato->totaldocumentos_adicionado_val, 1, 0, 'R', '1');
            $total_bien = $total_bien + $dato->totalbienes;
            $total_bien_val = $total_bien_val + $dato->bienesvalidados;
            $total_doc = $total_doc + ($dato->totaldocumentos + $dato->totaldocumentos_adicionado_val);
            $total_doc_val = $total_doc_val + ($dato->totaldocumentos_val + $dato->totaldocumentos_adicionado_val);
            $total_doc_noval = $total_doc_noval + ($dato->totaldocumentos_noval + $dato->totaldocumentos_adicionado_noval);
            $total_doc_agre = $total_doc_agre + $dato->totaldocumentos_adicionado_val;
        }

        $this->pdf->ln();
        $this->pdf->SetFillColor(200, 200, 200);
        $this->pdf->Cell(15, 4, 'Totales: ', 'TBL', 0, 'C', '1');
        if($total_bien==0)
        {
            $this->pdf->Cell(70, 4, 'Porcentaje de avance: 0%', 'TB', 0, 'C', '1');
        }
        else
        {
            $this->pdf->Cell(70, 4, 'Porcentaje de avance: ' . round($total_bien_val * 100 / $total_bien,2) . '%', 'TB', 0, 'C', '1');
        }
        
        $this->pdf->Cell(17, 4, $total_bien, 'TB', 0, 'R', '1');
        $this->pdf->Cell(17, 4, $total_bien_val, 'TB', 0, 'R', '1');
        $this->pdf->Cell(17, 4, $total_doc, 'TB', 0, 'R', '1');
        $this->pdf->Cell(17, 4, $total_doc_val, 'TB', 0, 'R', '1');
        $this->pdf->Cell(17, 4, $total_doc_noval, 'TB', 0, 'R', '1');
        $this->pdf->Cell(17, 4, $total_doc_agre, 'TBR', 0, 'R', '1');
        }
        else
        {
            $this->pdf->Ln();
            $this->pdf->Cell(0, 4 , 'VUELVA A GENERAR EL REPORTE', '0');
        }
        $this->pdf->Ln(20);
        $this->pdf->Output("Lista .pdf", 'I');
    }

    public function reportediario() {
        $this->pdf = new Pdf2();
        $this->pdf->AddPage();
        $this->pdf->AliasNbPages();
        $this->pdf->SetTitle("Reporte");
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $validador = $this->model->fila('*', 'nueva_validacion.usuario', '', 'AND id_funcionario=' . $this->input->post('selValidador'));
        $this->pdf->Cell(15, 7, 'Validador: ', 0, 'C', '1');
        $this->pdf->Cell(115, 7, $validador->nombre, 0, 'C', '1');
        $this->pdf->Cell(35, 7, 'De ' . $this->input->post('fecha1') . ' hasta ' . $this->input->post('fecha2'), 0, 'C', '1');
        $this->pdf->ln();
        $this->pdf->SetFillColor(200, 200, 200);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(15, 7, '#', 'TBL', 0, 'C', '1');
        $this->pdf->Cell(60, 7, 'Entidad', 'TB', 0, 'C', '1');
        $this->pdf->Cell(40, 7, 'Rubro', 'TB', 0, 'C', '1');
        $this->pdf->Cell(20, 7, 'Total Bienes', 'TB', 0, 'C', '1');
        $this->pdf->Cell(20, 7, 'Validados', 'TB', 0, 'C', '1');
        $this->pdf->Cell(20, 7, 'Por Validar', 'TBR', 0, 'C', '1');
        $this->pdf->SetFillColor(255, 255, 255);
        if ($this->input->post('selEntidad') == 'all') {
            $entidad = '';
        } else {
            $entidad = 'AND a.identidad=' . $this->input->post('selEntidad');
        }

        $datosentidad = $this->model->lista("b.identidad,c.nombre,count(b.identidad) tbien,b.idclase,d.descripcion,
            SUM(CASE WHEN (b.idestadovalidacion = 3 AND b.fechavalidacionbien BETWEEN '" . $this->input->post('fecha1') . "' AND '" . $this->input->post('fecha2') . "') then 1 ELSE 0 END) tval"
                , 'nueva_validacion.users_universo a'
                , 'INNER JOIN nueva_validacion.bien b ON a.identidad=b.identidad
            INNER JOIN gobierno.entidades c ON a.identidad=c.id
            INNER JOIN dj_activos.clase d ON b.idclase=d.id'
                , "AND a.idusuario=" . $this->input->post('selValidador') . "
            AND a.asignado=true
            AND b.habilitado=1
            GROUP BY b.identidad,b.idclase,c.nombre,d.descripcion
            UNION ALL
            SELECT b.identidad,c.nombre,count(b.identidad) tbien,b.idclase,d.descripcion,
            SUM(CASE WHEN (b.idestadovalidacion = 3 AND b.fechavalidacionbien BETWEEN '" . $this->input->post('fecha1') . "' AND '" . $this->input->post('fecha2') . "') then 1 ELSE 0 END) tval
            FROM nueva_validacion.users_universo a
            INNER JOIN nueva_validacion.bienalquiler b ON a.identidad=b.identidad
            INNER JOIN gobierno.entidades c ON a.identidad=c.id
            INNER JOIN dj_activos.clase d ON b.idclase=d.id
            WHERE a.idusuario=" . $this->input->post('selValidador') . "
            AND a.asignado=true
            AND b.habilitado=1
            GROUP BY b.identidad,b.idclase,c.nombre,d.descripcion
            ORDER BY identidad,idclase");

        $cont = 1;
        $total_doc = 0;
        $total_val = 0;
        $total_por = 0;
        $this->pdf->SetFont('Arial', '', 7);
        foreach ($datosentidad as $dato) {
            $this->pdf->ln();
            $this->pdf->Cell(15, 7, $cont++, 1, 0, 'L', '1');
            $this->pdf->AjustaCelda(60, 7, utf8_decode($dato->nombre), 1, 0, 'L', '1');
            $this->pdf->AjustaCelda(40, 7, $dato->descripcion, 1, 0, 'L', '1');
            $this->pdf->Cell(20, 7, $dato->tbien, 1, 0, 'L', '1');
            $this->pdf->Cell(20, 7, $dato->tval, 1, 0, 'L', '1');
            $this->pdf->Cell(20, 7, $dato->tbien - $dato->tval, 1, 0, 'L', '1');
            $total_doc = $total_doc + $dato->tbien;
            $total_val = $total_val + $dato->tval;
            $total_por = $total_por + ($dato->tbien - $dato->tval);
        }
        $this->pdf->ln();
        $this->pdf->SetFillColor(200, 200, 200);
        $this->pdf->Cell(115, 7, 'Total', 'TBL', 0, 'C', '1');
        $this->pdf->Cell(20, 7, $total_doc, 'TB', 0, 'L', '1');
        $this->pdf->Cell(20, 7, $total_val, 'TB', 0, 'L', '1');
        $this->pdf->Cell(20, 7, $total_por, 'TBR', 0, 'L', '1');
        $this->pdf->Ln(7);
        $this->pdf->Output("Lista .pdf", 'I');
    }

    public function reportediario3() {
            $f1 = explode('/',$this->input->post('fecha1'));
            $fecha_inicio = $f1[2].'-'.$f1[1].'-'.$f1[0];
            $fecha_inicio_aux = $fecha_inicio;
            $f2 = explode('/',$this->input->post('fecha2'));
            $fecha_fin = $f2[2].'-'.$f2[1].'-'.$f2[0];
            $idFuncionario = $this->input->post('selValidador');
            $columns = array();
            $col_color = "255,255,255";
            $celda_invisible = array('height' => '0', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '255,255,255', 'drawcolor' => '255,255,255', 'linewidth' => '0', 'linearea' => 'LTBR');
            $celda_invisible2 = array('height' => '8', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '10', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '255,255,255', 'linewidth' => '0', 'linearea' => 'LTBR');
            $tbl_etiqueta = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '9', 'font_style' => 'B', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
            $tbl_cabecera = array('height' => '5', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '173,173,173', 'textcolor' => '255,255,255', 'drawcolor' => '255,255,255', 'linewidth' => '0.2', 'linearea' => 'LTBR');
            $tbl_cuerpo1 = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
            $tbl_fondoTitulos1 = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '7', 'font_style' => 'b','fillcolor' => '110,110,110', 'textcolor' => '255,255,255', 'drawcolor' => '200,200,200', 'linewidth' => '0.2', 'linearea' => 'LTBR');
            $tbl_cuerpo_totales = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
            $tbl_cuerpo2 = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'BR');
            $tbl_cuerpo3 = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'R');
            $tbl_cuerpo4 = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
            $tbl_cuerpo = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '9', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
            $tbl_cuerpo_firmas = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2','linearea' => '');

            $ancho = array(30,55,38,25,25,25,25,25,25,25,15,15,15,15);
            $anchoinvisible = 10;
            $anchoinvisible2 = 200;
            /* iniciallizacion y despliegue del pdf*/
            $contador = 0;
            $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
            $nombre_validador = $nombre_validador->nombre;            
            $columnas = array();
            $sumTotBienesDeclarados = 0;
            $sumTotBienesValidados = 0;
            $sumTotBienesValidadosDocDef = 0;
            $sumTotBienesValidadosDocInt = 0;
            $sumTotBienesValidadosSinDoc = 0;
            $sumTotBienesBaja = 0;
            $sumTotBienesValidadosBaja = 0;
            $col1 = array();
            $col2 = array();
            $col3 = array();
            $col4 = array();
            $col5 = array();
            $col6 = array();
            $col7 = array();            
            $totaldocumentosasignados=0;
            $totaldocumentosvalidados=0;            
            $col3[] = array_merge(array('text' => "",'width' => $anchoinvisible, 'fillcolor' => $col_color),$celda_invisible);
            $col3[] = array_merge(array('text' => utf8_decode('Fecha de Inicio: '.$fecha_inicio),'width' => $anchoinvisible2, 'fillcolor' => $col_color),$celda_invisible2);
            $col3[] = array_merge(array('text' =>  utf8_decode('Fecha Fin: '.$fecha_fin),'width' => $anchoinvisible2, 'fillcolor' => $col_color),$celda_invisible2);
            $columnas[] = $col3;            
                        $col1[] = array_merge(array('text' => "",'width' => $anchoinvisible, 'fillcolor' => $col_color),$celda_invisible);
                        $col1[] = array_merge(array('text' => utf8_decode('Fecha'),'width' => $ancho[0], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                        $col1[] = array_merge(array('text' => utf8_decode('Entidad Públilca'), 'width' =>  $ancho[1], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                        $col1[] = array_merge(array('text' => utf8_decode('Nº Bienes Declarados'), 'width' =>  $ancho[3], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                        $col1[] = array_merge(array('text' => utf8_decode('Nº Bienes Validados'), 'width' =>  $ancho[4], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                        $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Declarados'), 'width' =>  $ancho[5], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                        $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Validados'), 'width' =>  $ancho[6], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                        $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Adicionados'), 'width' =>  $ancho[7], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                        $col1[] = array_merge(array('text' => utf8_decode('% Avance General'), 'width' =>  $ancho[8], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                        $columnas[] = $col1;
            $suma1 = 0;
            $suma2 = 0;
            $suma3 = 0;

           while($fecha_inicio_aux <= $fecha_fin){            
                $datos = $this->adminentidades_model->reporteBienesxFecha($idFuncionario,$fecha_inicio_aux);
               
           foreach($datos as $valor){            
                        $totaldocumentosasignados = $valor->totaldocumentos;
                        $totaldocumentosvalidados = $valor->docsvalidados;
                        $totalbienesdeclarados = $valor->totalbienes;
                        $totalbienesvalidados = $valor->bienesvalidados;
                        $porcentaje_avance = round(($totalbienesvalidados*100)/$totalbienesdeclarados,2);
                        if($totalbienesvalidados > 0 || $totaldocumentosvalidados > 0){
                            $suma1 = $suma1 +$valor->bienesvalidados;
                            $suma2 = $suma2 +$valor->docsvalidados;
                            $suma3 = $suma3 +$valor->docsadicionados;
                            $col2[] = array_merge(array('text' => "",'width' => $anchoinvisible, 'fillcolor' => $col_color),$celda_invisible);
                            $col2[] = array_merge(array('text' => $fecha_inicio_aux,'width' => $ancho[0], 'fillcolor' => $col_color),$tbl_cuerpo1);
                            $col2[] = array_merge(array('text' => utf8_decode($valor->nombre), 'width' =>  $ancho[1], 'fillcolor' => $col_color),$tbl_cuerpo1);
                            $col2[] = array_merge(array('text' => $valor->totalbienes, 'width' =>  $ancho[3], 'fillcolor' => $col_color),$tbl_cuerpo1);
                            $col2[] = array_merge(array('text' => $valor->bienesvalidados, 'width' =>  $ancho[4], 'fillcolor' => $col_color),$tbl_cuerpo1);
                            $col2[] = array_merge(array('text' => $valor->totaldocumentos, 'width' =>  $ancho[5], 'fillcolor' => $col_color),$tbl_cuerpo1);
                            $col2[] = array_merge(array('text' => $valor->docsvalidados, 'width' =>  $ancho[6], 'fillcolor' => $col_color),$tbl_cuerpo1);
                            $col2[] = array_merge(array('text' => $valor->docsadicionados, 'width' =>  $ancho[7], 'fillcolor' => $col_color),$tbl_cuerpo1);
                            $col2[] = array_merge(array('text' => $porcentaje_avance."%", 'width' =>  $ancho[8], 'fillcolor' => $col_color),$tbl_cuerpo1);
                            $columnas[] = $col2;
                            unset($col2);
                            $contador++;
                        }
                }
                $fecha_inicio_aux = strtotime ( '+1 day' , strtotime ( $fecha_inicio_aux ) ) ;
                $fecha_inicio_aux = date ( 'Y-m-d' , $fecha_inicio_aux );
           }           
                $col7[] = array_merge(array('text' => "",'width' => $anchoinvisible, 'fillcolor' => $col_color),$celda_invisible);
                $col7[] = array_merge(array('text' => "",'width' => $ancho[0], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col7[] = array_merge(array('text' => "TOTALES ", 'width' =>  $ancho[1], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[3], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col7[] = array_merge(array('text' => $suma1, 'width' =>  $ancho[4], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[5], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col7[] = array_merge(array('text' => $suma2, 'width' =>  $ancho[6], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col7[] = array_merge(array('text' => $suma3, 'width' =>  $ancho[7], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[8], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $columnas[] = $col7;
                unset($col7);
            if(!empty($columnas)){
                $pdf=new pdf2();

                $pdf->xheader = 40;
                $pdf->yheader = 8;
                $pdf->AliasNbPages();
                $pdf->AddPage('L','letter');
                $pdf->SetFont('Times','',13);
                $pdf->SetMargins(10,30,25);
                $pdf->SetAutoPageBreak(true,15);
                $pdf->SetY(30);//37

                $pdf->Ln(5);
                $pdf->SetFont('Times','B',16);
                $pdf->Cell(0,0,  utf8_decode("REPORTE DE VALIDACIÓN POR DÍA"),0,0,'C');
                
                $pdf->SetFont('Times','B',14);
                $pdf->Ln(2);
                $pdf->Ln(5);
                $nombre = $nombre_validador;
                $titulo1=  utf8_decode("Validador: ".$nombre); 
               
                $pdf->SetFont('Times','B',14);
                $pdf->Cell(0,0,$titulo1,0,0,'C');

                $fecha_hoy = $pdf->fechacompleta();
                $pdf->Ln(5);
                $pdf->Cell(0,0,"Fecha: ".$fecha_hoy,0,0,'C');
                
                $pdf->Ln(5);
                $pdf->WriteTable($columnas);    
                
                $pdf->Output();
                $dbp->close();
            }else{
                echo "No existen resultados para este reporte";
            }
    }

    public function reportevalidaciondiario()
    {
        $f1 = explode('/',$this->input->get('fecha1'));
        $fecha_inicio = $f1[2].'-'.$f1[1].'-'.$f1[0];
        $fecha_inicio_aux = $fecha_inicio;
        $f2 = explode('/',$this->input->get('fecha2'));
        $fecha_fin = $f2[2].'-'.$f2[1].'-'.$f2[0];
        $idFuncionario = $this->input->get('selValidador');
        $columns = array();

    $col_color = "255,255,255";

    $celda_invisible = array('height' => '0', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '255,255,255', 'drawcolor' => '255,255,255', 'linewidth' => '0', 'linearea' => 'LTBR');
    $celda_invisible2 = array('height' => '8', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '10', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '255,255,255', 'linewidth' => '0', 'linearea' => 'LTBR');
    $tbl_etiqueta = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '9', 'font_style' => 'B', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $tbl_cabecera = array('height' => '5', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '173,173,173', 'textcolor' => '255,255,255', 'drawcolor' => '255,255,255', 'linewidth' => '0.2', 'linearea' => 'LTBR');

    $tbl_cuerpo1 = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
    $tbl_fondoTitulos1 = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '7', 'font_style' => 'b','fillcolor' => '110,110,110', 'textcolor' => '255,255,255', 'drawcolor' => '200,200,200', 'linewidth' => '0.2', 'linearea' => 'LTBR');
    $tbl_cuerpo_totales = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
    $tbl_cuerpo2 = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'BR');
    $tbl_cuerpo3 = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'R');
    $tbl_cuerpo4 = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
    $tbl_cuerpo = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '9', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $tbl_cuerpo_firmas = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2','linearea' => '');

    $ancho = array(30,55,38,25,25,25,25,25,25,25,15,15,15,15);
    $anchoinvisible = 10;
    $anchoinvisible2 = 200;
    $contador = 0;
    $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
    
    $columnas = array();
    $sumTotBienesDeclarados = 0;
    $sumTotBienesValidados = 0;
    $sumTotBienesValidadosDocDef = 0;
    $sumTotBienesValidadosDocInt = 0;
    $sumTotBienesValidadosSinDoc = 0; 
    $sumTotBienesBaja = 0;
    $sumTotBienesValidadosBaja = 0;
    $col1 = array();
    $col2 = array();
    $col3 = array();
    $col4 = array();
    $col5 = array();
    $col6 = array();
    
    $totaldocumentosasignados=0;
    $totaldocumentosvalidados=0;
    
    $col3[] = array_merge(array('text' => "",'width' => $anchoinvisible, 'fillcolor' => $col_color),$celda_invisible);
    $col3[] = array_merge(array('text' => utf8_decode('Fecha de Inicio: '.$fecha_inicio),'width' => $anchoinvisible2, 'fillcolor' => $col_color),$celda_invisible2);
    $col3[] = array_merge(array('text' =>  utf8_decode('Fecha Fin: '.$fecha_fin),'width' => $anchoinvisible2, 'fillcolor' => $col_color),$celda_invisible2);
    $columnas[] = $col3;
    
                $col1[] = array_merge(array('text' => "",'width' => $anchoinvisible, 'fillcolor' => $col_color),$celda_invisible);
                $col1[] = array_merge(array('text' => utf8_decode('Fecha'),'width' => $ancho[0], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col1[] = array_merge(array('text' => utf8_decode('Entidad Públilca'), 'width' =>  $ancho[1], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col1[] = array_merge(array('text' => utf8_decode('Nº Bienes Declarados'), 'width' =>  $ancho[3], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col1[] = array_merge(array('text' => utf8_decode('Nº Bienes Validados'), 'width' =>  $ancho[4], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Declarados'), 'width' =>  $ancho[5], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Validados'), 'width' =>  $ancho[6], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Adicionados'), 'width' =>  $ancho[7], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $col1[] = array_merge(array('text' => utf8_decode('% Avance General'), 'width' =>  $ancho[8], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
                $columnas[] = $col1;
    
    $suma1 = 0;
    $suma2 = 0;
    $suma3 = 0;

        $col7[] = array_merge(array('text' => "",'width' => $anchoinvisible, 'fillcolor' => $col_color),$celda_invisible);
        $col7[] = array_merge(array('text' => "",'width' => $ancho[0], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "TOTALES ", 'width' =>  $ancho[1], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[3], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => $suma1, 'width' =>  $ancho[4], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[5], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => $suma2, 'width' =>  $ancho[6], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => $suma3, 'width' =>  $ancho[7], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[8], 'fillcolor' => $col_color),$tbl_fondoTitulos1);
        $columnas[] = $col7;
        unset($col7);
    $pdf = new Pdf2();
    $fecha_hoy = $pdf->fechacompleta();
    
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 40);
   
    

    
    
 
    $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
    $pdf->SetFont('Arial', 'B', 8);
     $encabezados = array('Nro',
            'Acción',
            'Entidad', 
            'Rubro',
            'Idbien',
            'Iddocumento',
            'Agregado por el Validador',
            'Documento',
            'Nro Documento',
            'Fecha y hora de Validación'
            );
      $w = array(7,17,48,38,12,12,13,57,25,29);         
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 2;
        $pdf->titulo = "REPORTE DE AVANCE DE VALIDACIÓN POR DÍA";
        $pdf->validador = $nombre_validador->nombre;
        $pdf->fechaini = "Fecha de Inicio: ".$fecha_inicio;
        $pdf->fechafin = "Fecha de Fin: ".$fecha_fin;
        $pdf->fecha = "Fecha:  ".$fecha_hoy;
        //$pdf->AddFont('gothic','','gothic.php');
        //$pdf->AddFont('gothicb','B','gothicb.php');
        $pdf->AddPage('L','Letter',null,null);
        $pdf->Header2();
        $datos = $this->adminentidades_model->reportedetalladodocumentos($fecha_inicio,$fecha_fin,$idFuncionario);
       
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0); 
        if(!empty($datos))
        {
             foreach($datos as $valor)
             {
                        $s = array($num,
                            iconv('UTF-8', 'windows-1252', $valor->accion),
                            iconv('UTF-8', 'windows-1252', $valor->entidad) ,
                            iconv('UTF-8', 'windows-1252', $valor->rubro),
                            $valor->idbien,
                            $valor->iddocumento,
                            $valor->adicionado,
                            iconv('UTF-8', 'windows-1252', $valor->documento),
                            $valor->nrodocumento,
                            $valor->fechadocumento);
                       $pdf->Row($s, true, '', 5);
                        $num++;
            }
       
        }
        
        
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 3;
        /*$pdf->AddPage('L','Letter',null,null);
        $pdf->SetMargins(10,30,25);
        $pdf->SetAutoPageBreak(true,15);
        $pdf->SetY(30);//37
        $pdf->Ln(5);
        $pdf->SetFont('Times','B',16);
        $pdf->Cell(0,0,  utf8_decode("REPORTE DE VALIDACIÓN POR DÍA"),0,0,'C');
        $pdf->SetFont('Times','B',14);
        $pdf->Ln(2);
        $pdf->Ln(5);
        $nombre = $nombre_validador->nombre;
        $titulo1=  utf8_decode("Validador: ".$nombre); 
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(0,0,$titulo1,0,0,'C');
        $fecha_hoy = $pdf->fechacompleta();
        $pdf->Ln(5);
        $pdf->Cell(0,0,"Fecha: ".$fecha_hoy,0,0,'C');
        $pdf->Ln(5);
        $pdf->WriteTable($columnas);*/
        
        

        $pdf->Output();
    }

    public function reporteDiario4()
    {
        $f1 = explode('/',$this->input->get('fecha3'));
        $fecha_inicio = $f1[2].'-'.$f1[1].'-'.$f1[0];
        $fecha_inicio_aux = $fecha_inicio;
        $f2 = explode('/',$this->input->get('fecha4'));
        $fecha_fin = $f2[2].'-'.$f2[1].'-'.$f2[0];
        $idFuncionario = $this->input->get('selValidador2');
        $idEntidad = $this->input->get('selEntidad2');
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf2();
        $fecha_hoy = $pdf->fechacompleta();
        $pdf->titulo = "REPORTE AVANCE DE VALIDACIÓN POR DÍA ";
        $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad)->nombre;
        $pdf->validador = $nombre_validador->nombre;
        $pdf->fechaini = "Fecha de Inicio: ".$fecha_inicio;
        $pdf->fechafin = "Fecha de Fin: ".$fecha_fin;
        $pdf->fecha = "Fecha:  ".$fecha_hoy;
        $pdf->xheader = 40;
        $pdf->yheader = 8; 
        $pdf->cabecera = 3;
        /**  ------------------------ inmuebles ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionInmueble($idEntidad,$fecha_inicio,$fecha_fin);
          $datosdoc = $this->adminentidades_model->reporteDetalleValidacionInmueblesindoc($idEntidad,$fecha_inicio,$fecha_fin);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 40); 
        $pdf->SetFont('Arial', 'B', 8);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Id Doc.', 
            'Descripción',
            'Adicionado',
            'Adjunta',
            'Corresponde',
            'Legible',
            'Nro. Documento', 
            'Superficie',
            'Catastro',
            'Denominacion',
            'Direccion', 
            'Obs. General',
            'Cod. Observacion',
            'Fecha Validacion'
        );
        $w = array(7,11,11,20,12,13,18,12,12,12,22,22,22,25,25,17);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->subTituloBotoom = "RUBRO INMUEBLES";
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L','Letter',null,null);
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    $valor->adicionado,
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->csuperficie),
                    iconv('UTF-8', 'windows-1252', $valor->ccatastro),
                    iconv('UTF-8', 'windows-1252', $valor->cdenominacion),
                    iconv('UTF-8', 'windows-1252', $valor->cdireccion),
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgeneral),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        if(!empty($datosdoc))
        { 
            foreach($datosdoc as $valor)
            {
                       $s = array($num,$valor->idbien,'',iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'),'', '','','','','','','','','','',$valor->fecvalidado);
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(1);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }
        /**  ------------------------ vehiculo ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionVehiculo($idEntidad,$fecha_inicio,$fecha_fin);
        $datosdocv = $this->adminentidades_model->reporteDetalleValidacionVehiculosindoc($idEntidad,$fecha_inicio,$fecha_fin);
        $pdf->subTituloBotoom = "RUBRO VEHICULOS";
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Documento',
            'Descripcion',
            'Adicionado',
            'Adjunta',
            'Corresponde',
            'Legible',
            'Nro. Documento',
            'Tipo',
            'Clase',
            'Marca',
            'Placa',
            'N° Motor',
            'N° Chasis',
            'Procedencia',
            'Modelo',
            'Color',
            'Obs. Generales',
            'Cod. Observacion',
            'fecha Validacion'
        );
        $w = array(7,12,12,14,8,8,8,8,14,14,14,14,14,14,14,14,14,12,17,14,14);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L','Letter',null,null);
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    $valor->adicionado,
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->ctipo),
                    iconv('UTF-8', 'windows-1252', $valor->cclase),
                    iconv('UTF-8', 'windows-1252', $valor->cmarca),
                    iconv('UTF-8', 'windows-1252', $valor->cplaca),
                    iconv('UTF-8', 'windows-1252', $valor->cmotor),
                    iconv('UTF-8', 'windows-1252', $valor->cchasis),
                    iconv('UTF-8', 'windows-1252', $valor->cprocedencia),
                    iconv('UTF-8', 'windows-1252', $valor->cmodelo),
                    iconv('UTF-8', 'windows-1252', $valor->ccolor),
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgenerales),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        if(!empty($datosdocv))
        { 
            foreach($datosdocv as $valor)
            {
                $s = array($num,$valor->idbien,'',iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'),'', '','','','','','','','','','','','','','','',$valor->fecvalidado);
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(2);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }
        /**  ------------------------ maquinaria y equipos ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionMaquinariaEq($idEntidad,$fecha_inicio,$fecha_fin);
        $datosdocme = $this->adminentidades_model->reporteDetalleValidacionMaquinariaEqsindoc($idEntidad,$fecha_inicio,$fecha_fin);
        $encabezados_ = [];
        $pdf->subTituloBotoom = "RUBRO MAQUINARIA Y EQUIPOS";
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Documento',
            'Descripcion',
            'Adicionado',
            'Adjunta',
            'Corresponde',
            'Legible',
            'Nro. Documento',
            'Equipo',
            'Marca',
            'Modelo',
            'Serie',
            'Obs. Generales',
            'Cod. Observacion',
            'fecha Validacion'
        );
        $w = array(8,13,13,30,15,15,15,15,20,14,14,14,14,20,20,20);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L','Letter',null,null);
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    $valor->adicionado,
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->cequipo),
                    iconv('UTF-8', 'windows-1252', $valor->cmarca),
                    iconv('UTF-8', 'windows-1252', $valor->cmodelo),
                    iconv('UTF-8', 'windows-1252', $valor->cserie),
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgenerales),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        if(!empty($datosdocme))
        { 
            foreach($datosdocme as $valor)
            {
                $s = array($num,$valor->idbien,'',iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'),'', '','','','','','','','','','',$valor->fecvalidado);
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(4);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }
        /**  ------------------------ maquinaria pesada ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionMaquinariaPe($idEntidad,$fecha_inicio,$fecha_fin);
        $datosdocmp = $this->adminentidades_model->reporteDetalleValidacionMaquinariaPesindoc($idEntidad,$fecha_inicio,$fecha_fin);
        $encabezados_ = [];
        $pdf->subTituloBotoom = "RUBRO MAQUINARIA PESADA";
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Id Documento',
            'Descripcion',
            'Adjunta',
            'Corresponde',
            'Legible',
            'Adicionado',
            'Nro. Documento',//
            'Equipo',
            'Marca',
            'Modelo',
            'Chasis',
            'Motor',
            'Color',
            'Obs. Generales',
            'Cod. Observacion',
            'fecha Validacion'
        );
        $w = array(8,13,13,27,13,14,13,13,15,14,14,14,14,15,15,15,15,15);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L','Letter',null,null);
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->adicionado),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->cdescripcion),
                    iconv('UTF-8', 'windows-1252', $valor->cmarca),
                    iconv('UTF-8', 'windows-1252', $valor->cmodelo),
                    iconv('UTF-8', 'windows-1252', $valor->cchasis),
                    iconv('UTF-8', 'windows-1252', $valor->cmotor),
                    iconv('UTF-8', 'windows-1252', $valor->ccolor),
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgenerales),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
          if(!empty($datosdocmp))
        { 
            foreach($datosdocmp as $valor)
            {
               $s = array($num,$valor->idbien,'',iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'),'', '','','','','','','','','','','','',$valor->fecvalidado);
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(4);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }
        /**  ------------------------ Alquiler Inmueble ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionInmuebleAlquiler($idEntidad,$fecha_inicio,$fecha_fin);
          $datosdocim = $this->adminentidades_model->reporteDetalleValidacionInmuebleAlquilersindoc($idEntidad,$fecha_inicio,$fecha_fin);
        $encabezados_ = [];
        $pdf->subTituloBotoom = "RUBRO ALQUILER INMUEBLE";
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Id Documento',
            'Descripcion',
            'Adicionado',
            'Adjunta',
            'Corresponde',
            'Legible',
            'Nro. Documento',//
            'Departamento',
            'Direccion',
            'Inicio Contrato',
            'Fin contrato',
            'Canon alquiler',
            'Obs. Generales',
            'Cod. Observacion',
            'fecha Validacion'
        );
        $w = array(8,13,13,27,13,14,14,13,19,15,15,15,15,15,17,17,17);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L','Letter',null,null);
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    $valor->adicionado,
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->cdepartamento),
                    iconv('UTF-8', 'windows-1252', $valor->cdireccion),
                    iconv('UTF-8', 'windows-1252', $valor->ciniciocontrato),
                    iconv('UTF-8', 'windows-1252', $valor->cfincontrato),
                    iconv('UTF-8', 'windows-1252', $valor->ccanonalquiler),
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgenerales),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
         if(!empty($datosdocim))
        { 
            foreach($datosdocim as $valor)
            {
               $s = array($num,$valor->idbien,'',iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'),'', '','','','','','','','','','','',$valor->fecvalidado);
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(5);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }
        /**  ------------------------ Alquiler Vehiculo ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionVehiculoalquiler($idEntidad,$fecha_inicio,$fecha_fin);
         $datosdocvm = $this->adminentidades_model->reporteDetalleValidacionVehiculoalquilersindoc($idEntidad,$fecha_inicio,$fecha_fin);
        $encabezados_ = [];
        $pdf->subTituloBotoom = "RUBRO ALQUILER VEHICULO";
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Id Documento',
            'Descripcion',
            'Adicionado',
            'Adjunta',
            'Corresponde',
            'Legible',
            'Nro. Documento',
            'Departamento',
            'Direccion',
            'Inicio Contrato',
            'Fin contrato',
            'Canon alquiler',
            'Obs. Generales',
            'Cod. Observacion',
            'fecha Validacion'
        );
        $w = array(8,13,13,27,13,14,14,13,19,15,15,15,15,15,17,17,17);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L','Letter',null,null);
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    $valor->adicionado,
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->cdepartamento),
                    iconv('UTF-8', 'windows-1252', $valor->cdireccion),
                    iconv('UTF-8', 'windows-1252', $valor->ciniciocontrato),
                    iconv('UTF-8', 'windows-1252', $valor->cfincontrato),
                    iconv('UTF-8', 'windows-1252', $valor->ccanonalquiler),
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgenerales),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
           if(!empty($datosdocvm))
        { 
            foreach($datosdocvm as $valor)
            {
               $s = array($num,$valor->idbien,'',iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'),'', '','','','','','','','','','','',$valor->fecvalidado);
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(7);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }
        $pdf->Output();
    }

    function reporteValidadores() {
        $this->pdf = new Pdf2();
        $this->pdf->AddPage(null,null,null,'VALIDADORES');
        $this->pdf->AliasNbPages();
        $this->pdf->SetTitle("Reporte");
        $this->pdf->SetLeftMargin(7);
        $this->pdf->SetRightMargin(7);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 7, 'Administrador: ', 0, 'C', '1');
        $this->pdf->Cell(105, 7, $this->session->userdata('nombre_completo'), 0, 'C', '1');
        $this->pdf->ln();
//        $this->pdf->SetFillColor(200, 100, 200);

        $this->pdf->SetFont('Arial', '', 14);
        //Table with 20 rows and 4 columns
        $this->pdf->SetWidths(array(10, 50, 17, 17, 17, 17, 17, 17, 17, 15));
        $this->pdf->RowTitle(array(
            '#',
            'Nombre',
            'Entidades',
            'Bienes',
            'Bienes Validados',
            'Bienes Saldo',
            'Documentos',
            'Doc. Validos',
            'Doc. Saldo',
            'Adminis trador'
        ));
        $this->pdf->SetFillColor(255, 255, 255);
        $this->pdf->SetTextColor(0);
        $validadores = $this->users_universo->listaValidadores(2017);
        $cont = 1;
        $totalEntidades = 0;
        $totalBienes = 0;
        $totalBienesVal = 0;
        $totalSaldo = 0;
        $totalDocumentos = 0;
        $totalDocVal = 0;
        $totalSaldoDoc = 0;

        $this->pdf->SetFont('Arial', '', 7);
        foreach ($validadores as $validador) {
            $this->pdf->ln();
            $this->pdf->Cell(10, 7, $cont++, 1, 0, 'L', '1');
            $this->pdf->AjustaCelda(50, 7, utf8_decode($validador->nombre), 1, 0, 'L', '1');
            $this->pdf->AjustaCelda(17, 7, utf8_decode($validador->entidades), 1, 0, 'L', '1');
            $this->pdf->Cell(17, 7, $validador->totalbienes, 1, 0, 'L', '1');
            $this->pdf->Cell(17, 7, $validador->bienesvalidados, 1, 0, 'L', '1');
            $this->pdf->Cell(17, 7, $validador->saldo, 1, 0, 'L', '1');
            $this->pdf->Cell(17, 7, $validador->totaldocumentos, 1, 0, 'L', '1');
            $this->pdf->Cell(17, 7, $validador->totaldocumentos_val, 1, 0, 'L', '1');
            $this->pdf->Cell(17, 7, $validador->saldodoc, 1, 0, 'L', '1');
            $this->pdf->Cell(15, 7, ($validador->administrador == 't') ? 'SI' : 'NO', 1, 0, 'L', '1');
            $totalEntidades = $totalEntidades + $validador->entidades;
            $totalBienes = $totalBienes + $validador->totalbienes;
            $totalBienesVal = $totalBienesVal + $validador->bienesvalidados;
            $totalSaldo = $totalSaldo + $validador->saldo;
            $totalDocumentos = $totalDocumentos + $validador->totaldocumentos;
            $totalDocVal = $totalDocVal + $validador->totaldocumentos_val;
            $totalSaldoDoc = $totalSaldoDoc + $validador->saldodoc;
        }
        $this->pdf->ln();
        $this->pdf->SetFillColor(200, 200, 200);
//        10,50,17,17,17,17,17,17,17,15
        $this->pdf->Cell(10, 7, $cont-1, 'TBL', 0, 'L', '1');
        $this->pdf->Cell(50, 7, 'Total', 'TBL', 0, 'L', '1');
        $this->pdf->Cell(17, 7, $totalEntidades, 'TBL', 0, 'L', '1');
        $this->pdf->Cell(17, 7, $totalBienes, 'TBL', 0, 'L', '1');
        $this->pdf->Cell(17, 7, $totalBienesVal, 'TBL', 0, 'L', '1');
        $this->pdf->Cell(17, 7, $totalSaldo, 'TBL', 0, 'L', '1');
        $this->pdf->Cell(17, 7, $totalDocumentos, 'TBL', 0, 'L', '1');
        $this->pdf->Cell(17, 7, $totalDocVal, 'TBL', 0, 'L', '1');
        $this->pdf->Cell(17, 7, $totalSaldoDoc, 'TBL', 0, 'L', '1');
        $this->pdf->Cell(15, 7, '', 'TBL', 0, 'L', '1');
        $this->pdf->Ln(7);
        $this->pdf->Output("Lista .pdf", 'I');
    }

    function reporteEntidadesAsignar() {
        $pdf = new Pdf2();
        $pdf->titulo = 'ENTIDADES POR ASIGNAR';
        $pdf->subTitulo = 'Administrador: '.$this->session->userdata('nombre_completo');
        $pdf->cabecera = 3;
         $pdf->piepagina = 1;
        $pdf->AliasNbPages();
//        $pdf->SetAutoPageBreak(true, 40);
        $pdf->SetFont('Arial', 'B', 9);
        $encabezados = array(
            '#',
            'Nombre Entidad',
            'Distrito',
            'Total Documentos',
            'Total Bienes'
        );
        $w = array(12, 90, 30, 30, 30);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage(null,null,null,null);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        $entidades = $this->resumenentidades_model->entidadesNoAsignadas();
        $cont = 1;
        $totalBienes = 0;
        $totalDocumentos = 0;
        $pdf->SetFont('Arial', '', 9);
        foreach ($entidades as $lista) {
            $pdf->Cell(12, 7, $cont++, 1, 0, 'L', '1');
            $pdf->AjustaCelda(90, 7, utf8_decode($lista->nombre), 1, 0, 'L', '1');
            $pdf->Cell(30, 7, utf8_decode($lista->departamento), 1, 0, 'L', '1');
            $pdf->Cell(30, 7, $lista->totalbienes, 1, 0, 'L', '1');
            $pdf->Cell(30, 7, $lista->totaldocumentos, 1, 0, 'L', '1');
            $totalBienes = $totalBienes + $lista->totalbienes;
            $totalDocumentos = $totalDocumentos + $lista->totaldocumentos;
            $pdf->ln();
        }
        $pdf->SetFillColor(200, 200, 200);
        $pdf->Cell(12, 7, $cont-1, 'TBL', 0, 'L', '1');
        $pdf->Cell(90, 7, 'Total', 'TBL', 0, 'L', '1');
        $pdf->Cell(30, 7, null, 'TBL', 0, 'L', '1');
        $pdf->Cell(30, 7, $totalDocumentos, 'TBL', 0, 'L', '1');
        $pdf->Cell(30, 7, $totalBienes, 'TBL', 0, 'L', '1');
        $pdf->Ln(7);
        $pdf->Output("Lista de alumnos.pdf", 'I');
    }

    function reporteEntidadesAsignados() {
        $pdf = new Pdf2();
        $pdf->titulo = 'ENTIDADES ASIGNADAS';
        $pdf->subTitulo = 'Administrador: '.$this->session->userdata('nombre_completo');
        $pdf->cabecera = 3;
         $pdf->piepagina = 1;
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', 'B', 9);
        $encabezados = array(
            '#',
            'Nombre Entidad',
            'Validador',
            'Distrito',
            'Total Documentos',
            'Total Bienes'
        );
        $w = array(8, 80,51,20, 16, 16);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage(null,null,null,null);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        $entidades = $this->resumenentidades_model->entidadesAsignadas();
        $cont = 1;
        $totalBienes = 0;
        $totalDocumentos = 0;
        $pdf->SetFont('Arial', '', 9);
        foreach ($entidades as $lista) {
            $pdf->Cell(8, 7, $cont++, 1, 0, 'L', '1');
            $pdf->AjustaCelda(80, 7, utf8_decode($lista->nombre), 1, 0, 'L', '1');
            $pdf->Cell(51, 7, utf8_decode($lista->validador), 1, 0, 'L', '1');
            $pdf->Cell(20, 7, utf8_decode($lista->departamento), 1, 0, 'L', '1');
            $pdf->Cell(16, 7, $lista->totaldocumentos, 1, 0, 'L', '1');
            $pdf->Cell(16, 7, $lista->totalbienes, 1, 0, 'L', '1');
            
            $totalBienes = $totalBienes + $lista->totalbienes;
            $totalDocumentos = $totalDocumentos + $lista->totaldocumentos;
            $pdf->ln();
        }
        $pdf->SetFillColor(200, 200, 200);
        $pdf->Cell(8, 7, $cont-1, 'TBL', 0, 'L', '1');
        $pdf->Cell(80, 7, 'Total', 'TBL', 0, 'L', '1');
        $pdf->Cell(51, 7, null, 'TBL', 0, 'L', '1');
        $pdf->Cell(20, 7, null, 'TBL', 0, 'L', '1');
        $pdf->Cell(16, 7, $totalDocumentos, 'TBL', 0, 'L', '1');
        $pdf->Cell(16, 7, $totalBienes, 'TBL', 0, 'L', '1');
        $pdf->Ln(7);
        $pdf->Output("Lista de alumnos.pdf", 'I');
    }

    function GenerateWord() {
        //Get a random word
        $nb = rand(3, 10);
        $w = '';
        for ($i = 1; $i <= $nb; $i++)
            $w .= chr(rand(ord('a'), ord('z')));
        return $w;
    }

    function GenerateSentence() {
        //Get a random sentence
        $nb = rand(1, 10);
        $s = '';
        for ($i = 1; $i <= $nb; $i++)
            $s .= $this->GenerateWord() . ' ';
        return substr($s, 0, -1);
    }
    function fecha(){
        $GetD = getdate();
        $verd = array(
        1=>"Lunes",2=>"Martes",3=>"Mi&eacute;rcoles",4=>"Jueves",5=>"Viernes",6=>"Sábado",7=>"Domingo"
        );
        $verm = array(
        1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",
            8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre"
        );
        //return $verd[$GetD['wday']].", ".$GetD['mday']." de ".$verm[$GetD['mon']]." del ".$GetD['year'];
        return " ".$GetD['mday']." de ".$verm[$GetD['mon']]." de ".$GetD['year']."  Hora:  ".$GetD['hours'].":".$GetD['minutes'].":".$GetD['seconds'];
    }
public function reporteDiario6()
    {
        
        $idEntidad = $this->input->get('selEntidad4');
        $idFuncionario = $this->input->get('selValidador4');
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf2();
        $fecha_hoy = $pdf->fechacompleta2();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad)->nombre;
       // $pdf->validador = $nombre_validador->nombre;
        $pdf->fecha = "Fecha:  ".$fecha_hoy;
        $pdf->xheader = 40;
        $pdf->yheader = 8; 
        $pdf->cabecera = 5;
        $pdf->piepagina = 1;
        /**  ------------------------ inmuebles ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionInmuebleobservaciones($idEntidad);
       // var_dump($datos);
        $datosdoc = $this->adminentidades_model->reporteDetalleValidacionInmueblesindoc($idEntidad);
       // var_dump($datosdoc);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 40);
        $pdf->SetFont('Arial', 'B', 8);
        $encabezados = array(
            'Nro',
            'Id Bien',
            //'Id Doc.',
            'Descripción',
            //'Adicionado',
            'Adjunta',
            'Corresponde.',
            'Legible',
            'Nro. Documento',
            'Superficie',
            //'Catastro',
            //'Denominación', 
            'Dirección',
            'Obs. General',
            //'Cod. Observación',
            //'Fecha Validación'
        );
        $w = array(7,11,45,13,18,12,16,12,22,100);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO INMUEBLES";
        $pdf->AddPage('L','Letter',null,null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                   // iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    //$valor->adicionado,
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->csuperficie),
                    //iconv('UTF-8', 'windows-1252', $valor->ccatastro),
                    //iconv('UTF-8', 'windows-1252', $valor->cdenominacion),
                    iconv('UTF-8', 'windows-1252', $valor->cdireccion),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                   // iconv('UTF-8', 'windows-1252', $valor->observaciones),
                   // iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }

        if(!empty($datosdoc))
        { 
            foreach($datosdoc as $valor)
            {
                       $s = array($num,$valor->idbien,iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '','','','','','',iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }


       /** $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(1);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }**/
        /**  ------------------------ vehiculo ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionVehiculoobservacion($idEntidad);
        $datosdocv = $this->adminentidades_model->reporteDetalleValidacionVehiculosindoc($idEntidad);
        $pdf->subTituloBotoom = "RUBRO VEHICULOS";
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
           // 'Documento',
            'Descripción',
            //'Adicionado',
            'Adjunta',
            'Corresponde',
            'Legible',
            'Nro. Documento',
            'Tipo',
            'Clase',
            'Marca',
            'Placa',
            'N° Motor',
            'N° Chasis',
            'Procedencia',
            'Modelo',
            'Color',
            'Observaciones',
            //'Cod. Observacion',
            //'fecha Validacion'
        );
        $w = array(7,12,30,14,8,8,8,14,14,14,14,14,14,14,14,14,45);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L','Letter',null,null);
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    //iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    //$valor->adicionado,
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->ctipo),
                    iconv('UTF-8', 'windows-1252', $valor->cclase),
                    iconv('UTF-8', 'windows-1252', $valor->cmarca),
                    iconv('UTF-8', 'windows-1252', $valor->cplaca),
                    iconv('UTF-8', 'windows-1252', $valor->cmotor),
                    iconv('UTF-8', 'windows-1252', $valor->cchasis),
                    iconv('UTF-8', 'windows-1252', $valor->cprocedencia),
                    iconv('UTF-8', 'windows-1252', $valor->cmodelo),
                    iconv('UTF-8', 'windows-1252', $valor->ccolor),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                  //  iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    //iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
       if(!empty($datosdocv))
        { 
            foreach($datosdocv as $valor)
            {
                $s = array($num,$valor->idbien,iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'),'','','','','','','','','','','','','',iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
       /* $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(2);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }/**

        /**  ------------------------ maquinaria y equipos ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionMaquinariaEqobservacion($idEntidad);
        $datosdocme = $this->adminentidades_model->reporteDetalleValidacionMaquinariaEqsindoc($idEntidad);
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            //'Documento',
            'Descripción',
            //'Adicionado',
            'Adjunta',
            'Corresponde',
            'Legible',
            'Nro. Documento',
            'Equipo',
            //'Marca',
            //'Modelo',
            //'Serie',
            'Obs. Generales',
          //  'Cod. Observación',
           // 'fecha Validación'
        );
        $w = array(8,23,55,15,15,18,20,14,85);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO MAQUINARIA Y EQUIPOS";
        $pdf->AddPage('L','Letter',null,null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                   // iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    //$valor->adicionado,
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->cequipo),
                    //iconv('UTF-8', 'windows-1252', $valor->cmarca),
                    //iconv('UTF-8', 'windows-1252', $valor->cmodelo),
                    //iconv('UTF-8', 'windows-1252', $valor->cserie),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                 //   iconv('UTF-8', 'windows-1252', $valor->observaciones),
                   // iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        if(!empty($datosdocme))
        { 
            foreach($datosdocme as $valor)
            {
                $s = array($num,$valor->idbien,iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '','','','','',iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
       /** $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(4);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }**/
        /**  ------------------------ maquinaria pesada ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionMaquinariaPeobservacion($idEntidad);
        $datosdocmp = $this->adminentidades_model->reporteDetalleValidacionMaquinariaPesindoc($idEntidad);
        
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
          //  'Id Documento',
            'Descripción',
            'Adjunta',
            'Corresponde',
            'Legible',
            //'Adicionado',
            'Nro. Documento',//
           // 'Equipo',
           // 'Marca',
           // 'Modelo',
            'Chasis',
           // 'Motor',
           // 'Color',
            'Obs. Generales',
            //'Cod. Observación',
           // 'fecha Validación'
        );
        $w = array(8,18,55,17,17,17,18,15,90);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = utf8_decode("RUBRO MAQUINARIA PESADA MÓVIL");
        $pdf->AddPage('L','Letter',null,null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    //iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    //iconv('UTF-8', 'windows-1252', $valor->adicionado),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                  //  iconv('UTF-8', 'windows-1252', $valor->cdescripcion),
                    //iconv('UTF-8', 'windows-1252', $valor->cmarca),
                   // iconv('UTF-8', 'windows-1252', $valor->cmodelo),
                    iconv('UTF-8', 'windows-1252', $valor->cchasis),
                   // iconv('UTF-8', 'windows-1252', $valor->cmotor),
                    //iconv('UTF-8', 'windows-1252', $valor->ccolor),
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgenerales),
                    //iconv('UTF-8', 'windows-1252', $valor->observaciones),
                   //iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        if(!empty($datosdocmp))
        { 
            foreach($datosdocmp as $valor)
            {
               $s = array($num,$valor->idbien,iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'),'', '','','','',iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
        
       /** $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(4);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }**/
        /**  ------------------------ Alquiler Inmueble ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionInmuebleAlquilerobservacion($idEntidad);
        $datosdocim = $this->adminentidades_model->reporteDetalleValidacionInmuebleAlquilersindoc($idEntidad);
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            //'Id Documento',
            'Descripción',
            //'Adicionado',
            'Adjunta',
            'Corresponde',
            'Legible',
            'Nro. Documento',//
            'Departamento',
            'Dirección',
            'Inicio Contrato',
            'Fin contrato',
            'Canon alquiler',
            'Obs. Generales',
            //'Cod. Observación',
            //'fecha Validación'
        );
        $w = array(8,18,35,14,14,13,19,15,15,15,15,15,60);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO ALQUILER INMUEBLE";
        $pdf->AddPage('L','Letter',null,null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    //iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    //$valor->adicionado,
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->cdepartamento),
                    iconv('UTF-8', 'windows-1252', $valor->cdireccion),
                    iconv('UTF-8', 'windows-1252', $valor->ciniciocontrato),
                    iconv('UTF-8', 'windows-1252', $valor->cfincontrato),
                    iconv('UTF-8', 'windows-1252', $valor->ccanonalquiler),
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgenerales),
                   // iconv('UTF-8', 'windows-1252', $valor->observaciones),
                  //  iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
         if(!empty($datosdocim))
        { 
            foreach($datosdocim as $valor)
            {
               $s = array($num,$valor->idbien,iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '','','','','','','','','','',iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
        /**$pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(5);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }**/
        /**  ------------------------ Alquiler Vehiculo ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionVehiculoalquilerobservacion($idEntidad);
        $datosdocvm = $this->adminentidades_model->reporteDetalleValidacionVehiculoalquilersindoc($idEntidad);
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
           // 'Id Documento',
            'Descripción',
            //'Adicionado',
            'Adjunta',
            'Corresponde.',
            'Legible',
            'Nro. Documento',
            'Departamento',
            'Dirección',
            'Inicio Contrato',
            'Fin contrato',
            'Canon alquiler',
            'Obs. Generales',
           // 'Cod. Observación',
           // 'fecha Validación'
        );
        $w = array(12,15,35,14,18,13,19,18,18,18,15,15,45);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO ALQUILER VEHICULO";
        $pdf->AddPage('L','Letter',null,null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                 //   iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    //$valor->adicionado,
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    iconv('UTF-8', 'windows-1252', $valor->cdocumento),
                    iconv('UTF-8', 'windows-1252', $valor->cdepartamento),
                    iconv('UTF-8', 'windows-1252', $valor->cdireccion),
                    iconv('UTF-8', 'windows-1252', $valor->ciniciocontrato),
                    iconv('UTF-8', 'windows-1252', $valor->cfincontrato),
                    iconv('UTF-8', 'windows-1252', $valor->ccanonalquiler),
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgenerales),
                   // iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    //iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
          if(!empty($datosdocvm))
        { 
            foreach($datosdocvm as $valor)
            {
               $s = array($num,$valor->idbien,iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '','','','','','','','','','',iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
                       $pdf->Row($s, true, '', 5);
                        $num++;
            } 
        }
       /**$pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(7);
        foreach($codigos as $valor)
         {
            $titulo =  utf8_decode("Código: ".$valor->id." = ".$valor->descripcion); 
            $pdf->Cell(0,0,$titulo,0,0,'L');
            $pdf->Ln(3);
         }**/
           $pdf->SetXY(40, 170);
            $pdf->Cell(70, 3, '.........................................................................' , 0,0, 'L');
            $pdf->SetXY(45, 170);
            $pdf->SetXY(58, 172);
            $pdf->Cell(70, 3, 'VALIDADOR' , 0,0, 'L');
            $pdf->SetXY(180, 170);
            $pdf->Cell(70, 3, '.........................................................................' , 0,0, 'L');
            $pdf->SetXY(185, 172);
            $pdf->Cell(70, 3, 'SELLO Y FIRMA SUPERVISOR' , 0,0, 'L');
        $pdf->Output();
    }

    public function reporteDiario4xls()
    {
        $idEntidad = $this->input->get('selEntidad2');
        $idFuncionario = $this->input->get('selValidador2');
        $dato['validador'] = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $dato['titulo'] = 'REPORTE DE VALIDACIÓN GESTIÓN 2019';
        $dato['subtitulo'] = $this->adminentidades_model->getNombreEntidad($idEntidad)->nombre;

        $dato['inmuebles'] = $this->adminentidades_model->reporteDetalleValidacionInmueble($idEntidad);        
        $dato['inmueblesdoc'] = $this->adminentidades_model->reporteDetalleValidacionInmueblesindoc($idEntidad);  
        $dato['codigosinmuebles'] = $this->adminentidades_model->getComboObservaciones(1); 
        
        $dato['vehiculos'] = $this->adminentidades_model->reporteDetalleValidacionVehiculo($idEntidad);        
        $dato['vehiculosdoc'] = $this->adminentidades_model->reporteDetalleValidacionVehiculosindoc($idEntidad);  
        $dato['codigosvehiculos'] = $this->adminentidades_model->getComboObservaciones(2); 

        $dato['maquinariaequipos'] = $this->adminentidades_model->reporteDetalleValidacionMaquinariaEq($idEntidad);        
        $dato['maquinariaequiposdoc'] = $this->adminentidades_model->reporteDetalleValidacionMaquinariaEqsindoc($idEntidad);  
        $dato['codigosmaquinariaequipos'] = $this->adminentidades_model->getComboObservaciones(4); 

        $dato['maquinariapesadas'] = $this->adminentidades_model->reporteDetalleValidacionMaquinariaPe($idEntidad);        
        $dato['maquinariapesadasdoc'] = $this->adminentidades_model->reporteDetalleValidacionMaquinariaPesindoc($idEntidad);  
        $dato['codigosmaquinariapesadas'] = $this->adminentidades_model->getComboObservaciones(4); 
        
        $dato['inmueblesalquiler'] = $this->adminentidades_model->reporteDetalleValidacionInmuebleAlquiler($idEntidad);        
        $dato['inmueblesalquilerdoc'] = $this->adminentidades_model->reporteDetalleValidacionInmuebleAlquilersindoc($idEntidad);  
        $dato['codigosinmueblesalquiler'] = $this->adminentidades_model->getComboObservaciones(5); 

        $dato['vehiculosalquiler'] = $this->adminentidades_model->reporteDetalleValidacionVehiculoalquiler($idEntidad);        
        $dato['vehiculosalquilerdoc'] = $this->adminentidades_model->reporteDetalleValidacionVehiculoalquilersindoc($idEntidad);  
        $dato['codigosvehiculosalquiler'] = $this->adminentidades_model->getComboObservaciones(7); 
        
        $this->load->view("adminreportes/reporteDiario4xls", $dato);
    }

}
