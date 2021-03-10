<?php
class Reportes extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->_is_logued_in();
        $this->load->model('usuarios_model');
        $this->load->model('reportes_model');
        $this->load->model('entidades_model');
        $this->load->model('adminusuario_model');
        $this->load->model('adminusersuniverso_model');
        $this->load->model('adminentidades_model');
        $this->load->model('adminclase_model');
        $this->load->library('pdf2');
        $this->load->library('pdf4');
        $this->load->helper('date');
        $this->load->helper('validacion_helper');
        $this->load->helper(array('form', 'url'));
    }
    function _is_logued_in()
    {
        $is_logued_in = $this->session->userdata('is_logued_in');
        $tipo_user = $this->session->userdata('tipo_user');
        if ($is_logued_in != TRUE) {
            redirect('usuarios');
        }
    }

    function index()
    {

        $menu = $this->session->userdata('menu');
        $id = $this->session->userdata('idfuncionario');
        $dato['nombre_completo'] = $this->session->userdata('nombre_completo');
        $dato['id'] = $id;
        $dato['identidad'] = 0;
        //$dato ['persona'] =$this->persona_model->selec_persona($id);  
        $dato['tipo_user'] = $this->session->userdata('tipo_user');
        $dato['title'] = "Pagina de Inicio";

        $dato["getuser"] = $this->adminusuario_model->get();
        $dato["getclase"] = $this->adminclase_model->get();
        $dato["hoy"] = date('d/m/Y');

        $this->load->view("inicio/cabecera", $dato);
        $this->load->view("reportes/reportes", $dato);
        $this->load->view("inicio/pie");
    }
    function getentidadesAsignadas()
    {

        $options = '';
        $id = $this->session->userdata('idfuncionario');
        $filas = $this->entidades_model->select_validar2($id);
        foreach ($filas as $fila) {
            $options .= "<option value='" . $fila->id . "'>" . $fila->entidad . "</option>";
        }
        echo $options;
    }

    public function reportevalidaciondiario()
    {
        $f1 = explode('/', $this->input->post('fecha1'));
        $fecha_inicio = $f1[2] . '-' . $f1[1] . '-' . $f1[0];
        $fecha_inicio_aux = $fecha_inicio;
        $f2 = explode('/', $this->input->post('fecha2'));
        $fecha_fin = $f2[2] . '-' . $f2[1] . '-' . $f2[0];

        $idFuncionario = $this->session->userdata('idfuncionario');
        $columns = array();

        $col_color = "255,255,255";

        $celda_invisible = array('height' => '0', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '255,255,255', 'drawcolor' => '255,255,255', 'linewidth' => '0', 'linearea' => 'LTBR');
        $celda_invisible2 = array('height' => '8', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '10', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '255,255,255', 'linewidth' => '0', 'linearea' => 'LTBR');
        $tbl_etiqueta = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '9', 'font_style' => 'B', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
        $tbl_cabecera = array('height' => '5', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '173,173,173', 'textcolor' => '255,255,255', 'drawcolor' => '255,255,255', 'linewidth' => '0.2', 'linearea' => 'LTBR');

        $tbl_cuerpo1 = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
        $tbl_fondoTitulos1 = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '7', 'font_style' => 'b', 'fillcolor' => '110,110,110', 'textcolor' => '255,255,255', 'drawcolor' => '200,200,200', 'linewidth' => '0.2', 'linearea' => 'LTBR');
        $tbl_cuerpo_totales = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
        $tbl_cuerpo2 = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'BR');
        $tbl_cuerpo3 = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'R');
        $tbl_cuerpo4 = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
        $tbl_cuerpo = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '9', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
        $tbl_cuerpo_firmas = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');

        $ancho = array(30, 55, 38, 25, 25, 25, 25, 25, 25, 25, 15, 15, 15, 15);
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

        $totaldocumentosasignados = 0;
        $totaldocumentosvalidados = 0;

        $col3[] = array_merge(array('text' => "", 'width' => $anchoinvisible, 'fillcolor' => $col_color), $celda_invisible);
        $col3[] = array_merge(array('text' => utf8_decode('Fecha de Inicio: ' . $fecha_inicio), 'width' => $anchoinvisible2, 'fillcolor' => $col_color), $celda_invisible2);
        $col3[] = array_merge(array('text' =>  utf8_decode('Fecha Fin: ' . $fecha_fin), 'width' => $anchoinvisible2, 'fillcolor' => $col_color), $celda_invisible2);
        $columnas[] = $col3;

        $col1[] = array_merge(array('text' => "", 'width' => $anchoinvisible, 'fillcolor' => $col_color), $celda_invisible);
        $col1[] = array_merge(array('text' => utf8_decode('Fecha'), 'width' => $ancho[0], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Entidad Públilca'), 'width' =>  $ancho[1], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Nº Bienes Declarados'), 'width' =>  $ancho[3], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Nº Bienes Validados'), 'width' =>  $ancho[4], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Declarados'), 'width' =>  $ancho[5], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Validados'), 'width' =>  $ancho[6], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Adicionados'), 'width' =>  $ancho[7], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('% Avance General'), 'width' =>  $ancho[8], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $columnas[] = $col1;

        $suma1 = 0;
        $suma2 = 0;
        $suma3 = 0;

        $col7[] = array_merge(array('text' => "", 'width' => $anchoinvisible, 'fillcolor' => $col_color), $celda_invisible);
        $col7[] = array_merge(array('text' => "", 'width' => $ancho[0], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "TOTALES ", 'width' =>  $ancho[1], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[3], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => $suma1, 'width' =>  $ancho[4], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[5], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => $suma2, 'width' =>  $ancho[6], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => $suma3, 'width' =>  $ancho[7], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[8], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $columnas[] = $col7;
        unset($col7);
        $pdf = new Pdf2();
        $fecha_hoy = $pdf->fechacompleta();

        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 40);






        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf->SetFont('Arial', 'B', 8);
        $encabezados = array(
            'Nro',
            'Acción',
            'Entidad',
            'Rubro',
            'Idbien',
            'Iddocumento',
            //'Agregado por el Validador',
            'Documento',
            'Nro Documento',
            'Fecha y hora de Validación'
        );
        $w = array(7, 17, 48, 38, 12, 12, 57, 25, 29);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 2;
        $pdf->titulo = "REPORTE DE AVANCE DE VALIDACIÓN POR DÍA";
        $pdf->validador = $nombre_validador->nombre;
        $pdf->fechaini = "Fecha de Inicio: " . $fecha_inicio;
        $pdf->fechafin = "Fecha de Fin: " . $fecha_fin;
        $pdf->fecha = "Fecha:  " . $fecha_hoy;
        //$pdf->AddFont('gothic','','gothic.php');
        //$pdf->AddFont('gothicb','B','gothicb.php');
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $datos = $this->adminentidades_model->reportedetalladodocumentos($fecha_inicio, $fecha_fin, $idFuncionario);

        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->accion),
                    iconv('UTF-8', 'windows-1252', $valor->entidad),
                    iconv('UTF-8', 'windows-1252', $valor->rubro),
                    $valor->idbien,
                    $valor->iddocumento,
                    //$valor->adicionado,
                    iconv('UTF-8', 'windows-1252', $valor->documento),
                    $valor->nrodocumento,
                    $valor->fechadocumento
                );
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
        $f1 = explode('/', $this->input->post('fecha3'));
        $fecha_inicio = $f1[2] . '-' . $f1[1] . '-' . $f1[0];
        $fecha_inicio_aux = $fecha_inicio;
        $f2 = explode('/', $this->input->post('fecha4'));
        $fecha_fin = $f2[2] . '-' . $f2[1] . '-' . $f2[0];
        $idFuncionario = $this->session->userdata('idfuncionario');
        $idEntidad = $this->input->post('selEntidad2');
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf2();
        $fecha_hoy = $pdf->fechacompleta2();
        $pdf->titulo = "REPORTESSSS ";
        $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad)->nombre;
        $pdf->validador = $nombre_validador->nombre;
        $pdf->fechaini = "Fecha de Inicio: " . $fecha_inicio;
        $pdf->fechafin = "Fecha de Fin: " . $fecha_fin;
        $pdf->fecha = "Fecha:  " . $fecha_hoy;
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 3;
        $pdf->piepagina = 1;
        /**  ------------------------ inmuebles ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionInmueble($idEntidad, $fecha_inicio, $fecha_fin);
        // var_dump($datos);
        $datosdoc = $this->adminentidades_model->reporteDetalleValidacionInmueblesindoc($idEntidad, $fecha_inicio, $fecha_fin);
        // var_dump($datosdoc);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 40);
        $pdf->SetFont('Arial', 'B', 8);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Id Doc.',
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
            'Cod. Observación',
            'Fecha Validación'
        );
        $w = array(7, 11, 11, 45, 13, 18, 12, 12, 12, 22, 25, 25, 17);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO INMUEBLES";
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
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
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgeneral),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }

        if (!empty($datosdoc)) {
            foreach ($datosdoc as $valor) {
                $s = array($num, $valor->idbien, '', iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', '', '', '', $valor->fecvalidado);
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }


        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(1);
        foreach ($codigos as $valor) {
            $titulo =  utf8_decode("Código: " . $valor->id . " = " . $valor->descripcion);
            $pdf->Cell(0, 0, $titulo, 0, 0, 'L');
            $pdf->Ln(3);
        }
        /**  ------------------------ vehiculo ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionVehiculo($idEntidad, $fecha_inicio, $fecha_fin);
        $datosdocv = $this->adminentidades_model->reporteDetalleValidacionVehiculosindoc($idEntidad, $fecha_inicio, $fecha_fin);
        $pdf->subTituloBotoom = "RUBRO VEHICULOS";
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Documento',
            'Descripcion',
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
            'Obs. Generales',
            'Cod. Observacion',
            'fecha Validacion'
        );
        $w = array(7, 12, 12, 14, 8, 8, 8, 14, 14, 14, 14, 14, 14, 14, 14, 14, 12, 17, 14, 14);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L', 'Letter', null, null);
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
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
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgenerales),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        if (!empty($datosdocv)) {
            foreach ($datosdocv as $valor) {
                $s = array($num, $valor->idbien, '', iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $valor->fecvalidado);
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(2);
        foreach ($codigos as $valor) {
            $titulo =  utf8_decode("Código: " . $valor->id . " = " . $valor->descripcion);
            $pdf->Cell(0, 0, $titulo, 0, 0, 'L');
            $pdf->Ln(3);
        }

        /**  ------------------------ maquinaria y equipos ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionMaquinariaEq($idEntidad, $fecha_inicio, $fecha_fin);
        $datosdocme = $this->adminentidades_model->reporteDetalleValidacionMaquinariaEqsindoc($idEntidad, $fecha_inicio, $fecha_fin);
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Documento',
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
            'Cod. Observación',
            'fecha Validación'
        );
        $w = array(8, 13, 23, 50, 15, 15, 15, 20, 14, 20, 20, 20);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO MAQUINARIA Y EQUIPOS";
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
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
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgenerales),
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        if (!empty($datosdocme)) {
            foreach ($datosdocme as $valor) {
                $s = array($num, $valor->idbien, '', iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', '', '', $valor->fecvalidado);
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(4);
        foreach ($codigos as $valor) {
            $titulo =  utf8_decode("Código: " . $valor->id . " = " . $valor->descripcion);
            $pdf->Cell(0, 0, $titulo, 0, 0, 'L');
            $pdf->Ln(3);
        }
        /**  ------------------------ maquinaria pesada ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionMaquinariaPe($idEntidad, $fecha_inicio, $fecha_fin);
        $datosdocmp = $this->adminentidades_model->reporteDetalleValidacionMaquinariaPesindoc($idEntidad, $fecha_inicio, $fecha_fin);

        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Id Documento',
            'Descripción',
            'Adjunta',
            'Corresponde',
            'Legible',
            //'Adicionado',
            'Nro. Documento', //
            'Equipo',
            'Marca',
            'Modelo',
            'Chasis',
            'Motor',
            'Color',
            'Obs. Generales',
            'Cod. Observación',
            'fecha Validación'
        );
        $w = array(8, 13, 13, 27, 13, 14, 13, 15, 14, 14, 14, 14, 15, 15, 15, 15, 15);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = utf8_decode("RUBRO MAQUINARIA PESADA MÓVIL");
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    $valor->adjunta,
                    $valor->idcorrespondencia,
                    iconv('UTF-8', 'windows-1252', $valor->legible),
                    //iconv('UTF-8', 'windows-1252', $valor->adicionado),
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
        if (!empty($datosdocmp)) {
            foreach ($datosdocmp as $valor) {
                $s = array($num, $valor->idbien, '', iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', '', '', '', '', '', '', '', $valor->fecvalidado);
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }

        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(4);
        foreach ($codigos as $valor) {
            $titulo =  utf8_decode("Código: " . $valor->id . " = " . $valor->descripcion);
            $pdf->Cell(0, 0, $titulo, 0, 0, 'L');
            $pdf->Ln(3);
        }
        /**  ------------------------ Alquiler Inmueble ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionInmuebleAlquiler($idEntidad, $fecha_inicio, $fecha_fin);
        $datosdocim = $this->adminentidades_model->reporteDetalleValidacionInmuebleAlquilersindoc($idEntidad, $fecha_inicio, $fecha_fin);
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Id Documento',
            'Descripción',
            //'Adicionado',
            'Adjunta',
            'Corresponde',
            'Legible',
            'Nro. Documento', //
            'Departamento',
            'Dirección',
            'Inicio Contrato',
            'Fin contrato',
            'Canon alquiler',
            'Obs. Generales',
            'Cod. Observación',
            'fecha Validación'
        );
        $w = array(8, 13, 13, 27, 14, 14, 13, 19, 15, 15, 15, 15, 15, 17, 17, 17);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO ALQUILER INMUEBLE";
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
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
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        if (!empty($datosdocim)) {
            foreach ($datosdocim as $valor) {
                $s = array($num, $valor->idbien, '', iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', '', '', '', '', '', '', $valor->fecvalidado);
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(5);
        foreach ($codigos as $valor) {
            $titulo =  utf8_decode("Código: " . $valor->id . " = " . $valor->descripcion);
            $pdf->Cell(0, 0, $titulo, 0, 0, 'L');
            $pdf->Ln(3);
        }
        /**  ------------------------ Alquiler Vehiculo ----------------- **/
        $datos = $this->adminentidades_model->reporteDetalleValidacionVehiculoalquiler($idEntidad, $fecha_inicio, $fecha_fin);
        $datosdocvm = $this->adminentidades_model->reporteDetalleValidacionVehiculoalquilersindoc($idEntidad, $fecha_inicio, $fecha_fin);
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Id Documento',
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
            'Cod. Observación',
            'fecha Validación'
        );
        $w = array(8, 13, 13, 27, 14, 14, 13, 19, 15, 15, 15, 15, 15, 17, 17, 17);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO ALQUILER VEHICULO";
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->iddoc),
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
                    iconv('UTF-8', 'windows-1252', $valor->observaciones),
                    iconv('UTF-8', 'windows-1252', $valor->fecvalidado),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        if (!empty($datosdocvm)) {
            foreach ($datosdocvm as $valor) {
                $s = array($num, $valor->idbien, '', iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', '', '', '', '', '', '', $valor->fecvalidado);
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }
        $pdf->Ln(5);
        $codigos = $this->adminentidades_model->getComboObservaciones(7);
        foreach ($codigos as $valor) {
            $titulo =  utf8_decode("Código: " . $valor->id . " = " . $valor->descripcion);
            $pdf->Cell(0, 0, $titulo, 0, 0, 'L');
            $pdf->Ln(3);
        }
        $titulo1 =  utf8_decode($pdf->validador);
        $pdf->SetXY(40, 166);
        $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
        $pdf->SetXY(45, 170);
        $pdf->Cell(70, 3, ($titulo1), 0, 0, 'L');
        $pdf->SetXY(58, 168);
        $pdf->Cell(70, 3, 'VALIDADOR', 0, 0, 'L');
        $pdf->SetXY(180, 168);
        $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
        $pdf->SetXY(185, 170);
        $pdf->Cell(70, 3, 'SELLO Y FIRMA SUPERVISOR', 0, 0, 'L');
        $pdf->Output();
    }

    public function reportediario5() //2019
    {
        //$f1 = explode('/',$this->input->post('fecha1'));
        //$fecha_inicio = $f1[2].'-'.$f1[1].'-'.$f1[0];
        //$fecha_inicio_aux = $fecha_inicio;
        //$f2 = explode('/',$this->input->post('fecha2'));
        //$fecha_fin = $f2[2].'-'.$f2[1].'-'.$f2[0];
        $idEntidad = $this->input->post('selEntidad3');
        $idFuncionario = $this->session->userdata('idfuncionario');
        $columns = array();

        $col_color = "255,255,255";

        $celda_invisible = array('height' => '0', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '255,255,255', 'drawcolor' => '255,255,255', 'linewidth' => '0', 'linearea' => 'LTBR');
        $celda_invisible2 = array('height' => '8', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '10', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '255,255,255', 'linewidth' => '0', 'linearea' => 'LTBR');
        $tbl_etiqueta = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '9', 'font_style' => 'B', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
        $tbl_cabecera = array('height' => '5', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '173,173,173', 'textcolor' => '255,255,255', 'drawcolor' => '255,255,255', 'linewidth' => '0.2', 'linearea' => 'LTBR');

        $tbl_cuerpo1 = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
        $tbl_fondoTitulos1 = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '7', 'font_style' => 'b', 'fillcolor' => '110,110,110', 'textcolor' => '255,255,255', 'drawcolor' => '200,200,200', 'linewidth' => '0.2', 'linearea' => 'LTBR');
        $tbl_cuerpo_totales = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
        $tbl_cuerpo2 = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'BR');
        $tbl_cuerpo3 = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'R');
        $tbl_cuerpo4 = array('height' => '4', 'align' => 'R', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
        $tbl_cuerpo = array('height' => '4', 'align' => 'J', 'font_name' => 'Times', 'font_size' => '9', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
        $tbl_cuerpo_firmas = array('height' => '4', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '8', 'font_style' => '', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');

        $ancho = array(30, 55, 38, 25, 25, 25, 25, 25, 25, 25, 15, 15, 15, 15);
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

        $totaldocumentosasignados = 0;
        $totaldocumentosvalidados = 0;

        $col3[] = array_merge(array('text' => "", 'width' => $anchoinvisible, 'fillcolor' => $col_color), $celda_invisible);
        //$col3[] = array_merge(array('text' => utf8_decode('Fecha de Inicio: '.$fecha_inicio),'width' => $anchoinvisible2, 'fillcolor' => $col_color),$celda_invisible2);
        //$col3[] = array_merge(array('text' =>  utf8_decode('Fecha Fin: '.$fecha_fin),'width' => $anchoinvisible2, 'fillcolor' => $col_color),$celda_invisible2);
        $columnas[] = $col3;

        $col1[] = array_merge(array('text' => "", 'width' => $anchoinvisible, 'fillcolor' => $col_color), $celda_invisible);
        $col1[] = array_merge(array('text' => utf8_decode('Fecha'), 'width' => $ancho[0], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Entidad Públilca'), 'width' =>  $ancho[1], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Nº Bienes Declarados'), 'width' =>  $ancho[3], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Nº Bienes Validados'), 'width' =>  $ancho[4], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Declarados'), 'width' =>  $ancho[5], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Validados'), 'width' =>  $ancho[6], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('Nº Documentos Adicionados'), 'width' =>  $ancho[7], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col1[] = array_merge(array('text' => utf8_decode('% Avance General'), 'width' =>  $ancho[8], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $columnas[] = $col1;

        $suma1 = 0;
        $suma2 = 0;
        $suma3 = 0;

        $col7[] = array_merge(array('text' => "", 'width' => $anchoinvisible, 'fillcolor' => $col_color), $celda_invisible);
        $col7[] = array_merge(array('text' => "", 'width' => $ancho[0], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "TOTALES ", 'width' =>  $ancho[1], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[3], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => $suma1, 'width' =>  $ancho[4], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[5], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => $suma2, 'width' =>  $ancho[6], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => $suma3, 'width' =>  $ancho[7], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $col7[] = array_merge(array('text' => "", 'width' =>  $ancho[8], 'fillcolor' => $col_color), $tbl_fondoTitulos1);
        $columnas[] = $col7;
        unset($col7);
        $pdf = new Pdf2();
        $fecha_hoy = $pdf->fechacompleta();

        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 40);






        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf->SetFont('Arial', 'B', 8);
        $encabezados = array(
            'Nro',
            'Rubro',
            'Entidad',
            'Idbien',
            'Documento',
            'Observaciones Generales',
            'Tipo de observacion'

        );
        $w = array(7, 30, 60, 20, 30, 30, 30);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 2;
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->validador = $nombre_validador->nombre;
        //$pdf->fechaini = "Fecha de Inicio: ".$fecha_inicio;
        //$pdf->fechafin = "Fecha de Fin: ".$fecha_fin;
        $pdf->fecha = "Fecha:  " . $fecha_hoy;
        //$pdf->AddFont('gothic','','gothic.php');
        //$pdf->AddFont('gothicb','B','gothicb.php');
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $datos = $this->adminentidades_model->reporteDetalleObservaciones($idEntidad);

        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->rubro),
                    iconv('UTF-8', 'windows-1252', $valor->entidad),
                    //iconv('UTF-8', 'windows-1252', $valor->rubro),
                    $valor->idbien,
                    iconv('UTF-8', 'windows-1252', $valor->documento),
                    //$valor->adicionado,
                    iconv('UTF-8', 'windows-1252', $valor->observacionesgeneral),
                    iconv('UTF-8', 'windows-1252', $valor->observacion)

                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }


        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 3;



        $pdf->Output();
    }
    public function reporteDiario6()
    {
        $f1 = explode('/', $this->input->post('fecha3'));
        $fecha_inicio = $f1[2] . '-' . $f1[1] . '-' . $f1[0];
        $fecha_inicio_aux = $fecha_inicio;
        $f2 = explode('/', $this->input->post('fecha4'));
        $fecha_fin = $f2[2] . '-' . $f2[1] . '-' . $f2[0];
        $idFuncionario = $this->session->userdata('idfuncionario');
        $idEntidad = $this->input->post('selEntidad4');
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf2();
        $fecha_hoy = $pdf->fechacompleta2();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad)->nombre;
        // $pdf->validador = $nombre_validador->nombre;
        $pdf->fechaini = "Fecha de Inicio: " . $fecha_inicio;
        $pdf->fechafin = "Fecha de Fin: " . $fecha_fin;
        $pdf->fecha = "Fecha:  " . $fecha_hoy;
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 5;

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
        $w = array(7, 11, 45, 13, 18, 12, 16, 12, 22, 100);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO INMUEBLES";
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
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

        if (!empty($datosdoc)) {
            foreach ($datosdoc as $valor) {
                $s = array($num, $valor->idbien, iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', '', iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
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
        $datosdocv = $this->adminentidades_model->reporteDetalleValidacionVehiculosindoc($idEntidad, $fecha_inicio, $fecha_fin);
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
        $w = array(7, 12, 30, 14, 8, 8, 8, 14, 14, 14, 14, 14, 14, 14, 14, 14, 45);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L', 'Letter', null, null);
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
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
        if (!empty($datosdocv)) {
            foreach ($datosdocv as $valor) {
                $s = array($num, $valor->idbien, iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', '', '', '', '', '', '', '', '', iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
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
        $datos = $this->adminentidades_model->reporteDetalleValidacionMaquinariaEqobservacion($idEntidad, $fecha_inicio, $fecha_fin);
        $datosdocme = $this->adminentidades_model->reporteDetalleValidacionMaquinariaEqsindoc($idEntidad, $fecha_inicio, $fecha_fin);
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
        $w = array(8, 23, 55, 15, 15, 18, 20, 14, 85);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO MAQUINARIA Y EQUIPOS";
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
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
        if (!empty($datosdocme)) {
            foreach ($datosdocme as $valor) {
                $s = array($num, $valor->idbien, iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
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
        $datosdocmp = $this->adminentidades_model->reporteDetalleValidacionMaquinariaPesindoc($idEntidad, $fecha_inicio, $fecha_fin);

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
            'Nro. Documento', //
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
        $w = array(8, 18, 55, 17, 17, 17, 18, 15, 90);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = utf8_decode("RUBRO MAQUINARIA PESADA MÓVIL");
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
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
        if (!empty($datosdocmp)) {
            foreach ($datosdocmp as $valor) {
                $s = array($num, $valor->idbien, iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
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
        $datosdocim = $this->adminentidades_model->reporteDetalleValidacionInmuebleAlquilersindoc($idEntidad, $fecha_inicio, $fecha_fin);
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
            'Nro. Documento', //
            'Departamento',
            'Dirección',
            'Inicio Contrato',
            'Fin contrato',
            'Canon alquiler',
            'Obs. Generales',
            //'Cod. Observación',
            //'fecha Validación'
        );
        $w = array(8, 18, 35, 14, 14, 13, 19, 15, 15, 15, 15, 15, 60);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO ALQUILER INMUEBLE";
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
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
        if (!empty($datosdocim)) {
            foreach ($datosdocim as $valor) {
                $s = array($num, $valor->idbien, iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', '', '', '', '', iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
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
        $datosdocvm = $this->adminentidades_model->reporteDetalleValidacionVehiculoalquilersindoc($idEntidad, $fecha_inicio, $fecha_fin);
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
        $w = array(12, 15, 35, 14, 18, 13, 19, 18, 18, 18, 15, 15, 45);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO ALQUILER VEHICULO";
        $pdf->AddPage('L', 'Letter', null, null);
        $pdf->Header2();
        $num = 1;
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
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
        if (!empty($datosdocvm)) {
            foreach ($datosdocvm as $valor) {
                $s = array($num, $valor->idbien, iconv('UTF-8', 'windows-1252', 'SIN DOCUMENTACIÓN'), '', '', '', '', '', '', '', '', '', '', iconv('UTF-8', 'windows-1252', 'Sin  documentación'));
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
        $pdf->Output();
    }
    // reporte 2020//
    public function reportetitularidad()
    {
        $idFuncionario = $this->session->userdata('idfuncionario');
        $idEntidad = $this->input->post('selEntidad5');
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf4();
        $fecha_hoy = $pdf->fechacompleta2();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad)->nombre;
        // $pdf->validador = $nombre_validador->nombre;
        $pdf->fecha = "Fecha:  " . $fecha_hoy;
        $pdf->xheader = 28;
        $pdf->yheader = 8;
        $pdf->cabecera = 6;
        $pdf->piepagina = 1;
        /**  ------------------------ inmuebles ----------------- **/
        $datos = $this->adminentidades_model->reportetitularidadInmueble($idEntidad);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 40);
        $pdf->SetFont('Arial', 'B', 8);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Descripción',
            'Nro. De Documento.',
            //   'Obs. General',

        );
        $w = array(15, 30, 85, 65);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }

        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->subTituloBotoom = "RUBRO INMUEBLES";

        $pdf->AddPage('P', 'Letter', null, null);
        $pdf->HeaderT();




        $num = 1;
        $pdf->SetXY(10, 68);
        $pdf->Header2();
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {

                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    iconv('UTF-8', 'windows-1252', $valor->nrodocumento),
                    //  iconv('UTF-8', 'windows-1252', $valor->observaciones),
                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }



        /**  ------------------------ vehiculo ----------------- **/
        $datos = $this->adminentidades_model->reportetitularidadvevhiculo($idEntidad);
        $pdf->subTituloBotoom = "RUBRO VEHICULOS";
        $pdf->SetFont('Arial', 'B', 8);
        $encabezados_ = [];
        $pdf->setEncabezadoG($encabezados_);
        $encabezados = array(
            'Nro',
            'Id Bien',
            'Descripción',
            'Nro. De Documento.',

            //'Cod. Observacion',
            //'fecha Validacion'
        );
        $w = array(15, 30, 85, 65);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('P', 'Letter', null, null);
        $pdf->HeaderV();
        $pdf->SetXY(10, 68);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(0);
        $num = 1;
        $pdf->SetTextColor(0);
        if (!empty($datos)) {
            foreach ($datos as $valor) {
                $s = array(
                    $num,
                    iconv('UTF-8', 'windows-1252', $valor->idbien),
                    iconv('UTF-8', 'windows-1252', $valor->descripcion),
                    iconv('UTF-8', 'windows-1252', $valor->nrodocumento),


                );
                $pdf->Row($s, true, '', 5);
                $num++;
            }
        }

        $pdf->Output();
    }

    public function reportevalidaciondocumentacion()
    {
        $idFuncionario = $this->session->userdata('idfuncionario');
        $idEntidad = $this->input->post('selEntidad9');
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf4();
        $fecha_hoy = $pdf->fechacompleta2();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad)->nombre;
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 9;
        $pdf->piepagina = 1;
        $datos = $this->adminentidades_model->reporteresumenrubros($idEntidad);
        $datosalquiler = $this->adminentidades_model->reporteresumenalquiler($idEntidad);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 40);
        $pdf->SetFont('Arial', 'B', 9);
        $encabezados = array(
            'Rubro de bien',
            'Bienes registrados',
            'Bienes validados',
            'Documentación definitiva',
            'Documentación intermedia',
            'Sin documentación',
            'N° Total de Bienes sin Observaciones',
            'N° Total de Bienes con Observaciones'
        );
        $w = array(54, 30, 30, 30, 30, 30, 30, 30);
        foreach ($encabezados as $val) {
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L', 'Letter', null, null);
        $num = 1;
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        $total_registrados = 0;
        $total_validados = 0;
        $total_definitiva = 0;
        $total_intermedia = 0;
        $total_sin_documentacion = 0;
        $total_sin_observacion = 0;
        $total_con_observacion = 0;
        if (!empty($datos)) {
            foreach ($datos as $valor) {

                $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                $pdf->ln();
                $num++;
                $total_registrados = $total_registrados + $valor->cantidad;
                $total_validados = $total_validados + $valor->validados;
                $total_definitiva = $total_definitiva + $valor->definitivo;
                $total_intermedia = $total_intermedia + $valor->intermedio;
                $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                $total_con_observacion = $total_con_observacion + $valor->observado;
            }
        }
        if (!empty($datosalquiler)) {
            foreach ($datosalquiler as $valor) {

                $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                $pdf->ln();
                $num++;
                $total_registrados = $total_registrados + $valor->cantidad;
                $total_validados = $total_validados + $valor->validados;
                $total_definitiva = $total_definitiva + $valor->definitivo;
                $total_intermedia = $total_intermedia + $valor->intermedio;
                $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                $total_con_observacion = $total_con_observacion + $valor->observado;
            }
        }

        $pdf->SetFillColor(200, 200, 200);
        $pdf->Cell(54, 7, 'TOTALES', 1, 0, 'C', '1');
        $pdf->Cell(30, 7, $total_registrados, 1, 0, 'C', '1');
        $pdf->Cell(30, 7, $total_validados, 1, 0, 'C', '1');
        $pdf->Cell(30, 7, $total_definitiva, 1, 0, 'C', '1');
        $pdf->Cell(30, 7, $total_intermedia, 1, 0, 'C', '1');
        $pdf->Cell(30, 7, $total_sin_documentacion, 1, 0, 'C', '1');
        $pdf->Cell(30, 7, $total_sin_observacion, 1, 0, 'C', '1');
        $pdf->Cell(30, 7, $total_con_observacion, 1, 0, 'C', '1');
        $pdf->ln();
        $pdf->Cell(70, 7, utf8_decode('Resumen de datos validados obtenidos mediante el Sistema de Validación Documental.'), 0, 0, 'L');
        $pdf->ln();
        $pdf->Cell(70, 7, utf8_decode('* Para revisión, control y fines de auditoría, el reporte de los bienes validados por Entidad y Rubro a detalle se encuentra en el CD adjunto y en el Sistema de Validación Documental.'), 0, 0, 'L');
        $pdf->SetFillColor(255, 255, 255);

        $pdf->SetTextColor(0);
        $pdf->SetXY(40, 163);
        $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
        $pdf->SetXY(58, 167);
        $pdf->Cell(70, 3, 'Responsable de Validacion ', 0, 0, 'L');
        $pdf->SetXY(65, 170);
        $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');
        $pdf->SetXY(180, 163);
        $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
        $pdf->SetXY(195, 167);
        $pdf->Cell(70, 3, 'Responsable de Supervisor ', 0, 0, 'L');
        $pdf->SetXY(210, 170);
        $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');
        $pdf->Output();
    }

    public function reportevalidaciondocumentacionxls()
    {
        $idFuncionario = $this->session->userdata('idfuncionario');
        $idEntidad = $this->input->post('selEntidad9');
        $dato['nombre_validador'] = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $dato['fecha_hoy'] = date('d-m-Y');
        $dato['titulo'] = "REPORTE DE VALIDACIÓN DOCUMENTAL 2018 Y 2019";
        $dato['subtitulo'] = $this->adminentidades_model->getNombreEntidad($idEntidad)->nombre;
        $dato['datos'] = $this->adminentidades_model->reporteresumenrubros($idEntidad);
        $dato['datosalquiler'] = $this->adminentidades_model->reporteresumenalquiler($idEntidad);
        $this->load->view("reportes/reportevalidaciondocumentacionxls", $dato);
    }

    public function reporteDiario4xls()
    {
        $idEntidad = $this->input->post('selEntidad2');
        $idFuncionario = $this->session->userdata('idfuncionario');
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

        $this->load->view("reportes/reporteDiario4xls", $dato);
    }

    public function reportevalidaciondocumentaciontodo()
    {
        $idFuncionario = $this->session->userdata('idfuncionario');
        $idsentidades = $this->entidades_model->select_validarTodo();
        // $idEntidad = 20;
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf4();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 9;
        $pdf->piepagina = 1;

        foreach ($idsentidades as $idEntidad) {
            $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad->id)->nombre;
            $datos = $this->adminentidades_model->reporteresumenrubros($idEntidad->id);
            $datosalquiler = $this->adminentidades_model->reporteresumenalquiler($idEntidad->id);
            $pdf->AliasNbPages();
            $pdf->SetAutoPageBreak(true, 40);
            $pdf->SetFont('Arial', 'B', 9);


            $pdf->AddPage('L', 'Letter', null, null);
            $pdf->SetFillColor(31, 73, 125);
            $pdf->SetTextColor(0);
            $pdf->tablewidths = array(54, 30, 30, 30, 30, 30, 30, 30);
            $data = [];
            $data[] = array(utf8_decode('Rubro de bien'), utf8_decode('Bienes registrados'), utf8_decode('Bienes validados'), utf8_decode('Documentación definitiva'), utf8_decode('Documentación intermedia'), utf8_decode('Sin documentación'), utf8_decode('N° Total de Bienes sin Observaciones'), utf8_decode('N° Total de Bienes con Observaciones'));

            $pdf->morepagestable($data, 3);



            $num = 1;
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0);
            $total_registrados = 0;
            $total_validados = 0;
            $total_definitiva = 0;
            $total_intermedia = 0;
            $total_sin_documentacion = 0;
            $total_sin_observacion = 0;
            $total_con_observacion = 0;
            if (!empty($datos)) {
                foreach ($datos as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }
            if (!empty($datosalquiler)) {
                foreach ($datosalquiler as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }

            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(54, 7, 'TOTALES', 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_registrados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_validados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_definitiva, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_intermedia, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_documentacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_observacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_con_observacion, 1, 0, 'C', '1');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('Resumen de datos validados obtenidos mediante el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('* Para revisión, control y fines de auditoría, el reporte de los bienes validados por Entidad y Rubro a detalle se encuentra en el CD adjunto y en el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetTextColor(0);
            $pdf->SetXY(40, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(58, 167);
            $pdf->Cell(70, 3, 'Responsable de Validacion ', 0, 0, 'L');
            $pdf->SetXY(65, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');
            $pdf->SetXY(180, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(195, 167);
            $pdf->Cell(70, 3, 'Responsable de Supervisor ', 0, 0, 'L');
            $pdf->SetXY(210, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');

        }
        $pdf->Output();
    }
/////////////////////////////////////////////////////////////7
    public function reportevalidaciondocumentaciontodo1()
    {
        $idFuncionario = $this->session->userdata('idfuncionario');
        $idsentidades = $this->entidades_model->select_validarTodo1();
        // $idEntidad = 20;
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf4();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 9;
        $pdf->piepagina = 1;

        foreach ($idsentidades as $idEntidad) {
            $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad->id)->nombre;
            $datos = $this->adminentidades_model->reporteresumenrubros($idEntidad->id);
            $datosalquiler = $this->adminentidades_model->reporteresumenalquiler($idEntidad->id);
            $pdf->AliasNbPages();
            $pdf->SetAutoPageBreak(true, 40);
            $pdf->SetFont('Arial', 'B', 9);


            $pdf->AddPage('L', 'Letter', null, null);
            $pdf->SetFillColor(31, 73, 125);
            $pdf->SetTextColor(0);
            $pdf->tablewidths = array(54, 30, 30, 30, 30, 30, 30, 30);
            $data = [];
            $data[] = array(utf8_decode('Rubro de bien'), utf8_decode('Bienes registrados'), utf8_decode('Bienes validados'), utf8_decode('Documentación definitiva'), utf8_decode('Documentación intermedia'), utf8_decode('Sin documentación'), utf8_decode('N° Total de Bienes sin Observaciones'), utf8_decode('N° Total de Bienes con Observaciones'));

            $pdf->morepagestable($data, 3);



            $num = 1;
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0);
            $total_registrados = 0;
            $total_validados = 0;
            $total_definitiva = 0;
            $total_intermedia = 0;
            $total_sin_documentacion = 0;
            $total_sin_observacion = 0;
            $total_con_observacion = 0;
            if (!empty($datos)) {
                foreach ($datos as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }
            if (!empty($datosalquiler)) {
                foreach ($datosalquiler as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }

            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(54, 7, 'TOTALES', 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_registrados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_validados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_definitiva, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_intermedia, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_documentacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_observacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_con_observacion, 1, 0, 'C', '1');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('Resumen de datos validados obtenidos mediante el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('* Para revisión, control y fines de auditoría, el reporte de los bienes validados por Entidad y Rubro a detalle se encuentra en el CD adjunto y en el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetTextColor(0);
            $pdf->SetXY(40, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(58, 167);
            $pdf->Cell(70, 3, 'Responsable de Validacion ', 0, 0, 'L');
            $pdf->SetXY(65, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');
            $pdf->SetXY(180, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(195, 167);
            $pdf->Cell(70, 3, 'Responsable de Supervisor ', 0, 0, 'L');
            $pdf->SetXY(210, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');

        }
        $pdf->Output();
    }
    public function reportevalidaciondocumentaciontodo2()
    {
        $idFuncionario = $this->session->userdata('idfuncionario');
        $idsentidades = $this->entidades_model->select_validarTodo2();
        // $idEntidad = 20;
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf4();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 9;
        $pdf->piepagina = 1;

        foreach ($idsentidades as $idEntidad) {
            $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad->id)->nombre;
            $datos = $this->adminentidades_model->reporteresumenrubros($idEntidad->id);
            $datosalquiler = $this->adminentidades_model->reporteresumenalquiler($idEntidad->id);
            $pdf->AliasNbPages();
            $pdf->SetAutoPageBreak(true, 40);
            $pdf->SetFont('Arial', 'B', 9);


            $pdf->AddPage('L', 'Letter', null, null);
            $pdf->SetFillColor(31, 73, 125);
            $pdf->SetTextColor(0);
            $pdf->tablewidths = array(54, 30, 30, 30, 30, 30, 30, 30);
            $data = [];
            $data[] = array(utf8_decode('Rubro de bien'), utf8_decode('Bienes registrados'), utf8_decode('Bienes validados'), utf8_decode('Documentación definitiva'), utf8_decode('Documentación intermedia'), utf8_decode('Sin documentación'), utf8_decode('N° Total de Bienes sin Observaciones'), utf8_decode('N° Total de Bienes con Observaciones'));

            $pdf->morepagestable($data, 3);



            $num = 1;
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0);
            $total_registrados = 0;
            $total_validados = 0;
            $total_definitiva = 0;
            $total_intermedia = 0;
            $total_sin_documentacion = 0;
            $total_sin_observacion = 0;
            $total_con_observacion = 0;
            if (!empty($datos)) {
                foreach ($datos as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }
            if (!empty($datosalquiler)) {
                foreach ($datosalquiler as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }

            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(54, 7, 'TOTALES', 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_registrados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_validados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_definitiva, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_intermedia, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_documentacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_observacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_con_observacion, 1, 0, 'C', '1');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('Resumen de datos validados obtenidos mediante el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('* Para revisión, control y fines de auditoría, el reporte de los bienes validados por Entidad y Rubro a detalle se encuentra en el CD adjunto y en el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetTextColor(0);
            $pdf->SetXY(40, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(58, 167);
            $pdf->Cell(70, 3, 'Responsable de Validacion ', 0, 0, 'L');
            $pdf->SetXY(65, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');
            $pdf->SetXY(180, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(195, 167);
            $pdf->Cell(70, 3, 'Responsable de Supervisor ', 0, 0, 'L');
            $pdf->SetXY(210, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');

        }
        $pdf->Output();
    }
    public function reportevalidaciondocumentaciontodo3()
    {
        // $idFuncionario = $this->session->userdata('idfuncionario');
        $idsentidades = $this->entidades_model->select_validarTodo3();
        // $idEntidad = 20;
        // $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf4();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 9;
        $pdf->piepagina = 1;

        foreach ($idsentidades as $idEntidad) {
            $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad->id)->nombre;
            $datos = $this->adminentidades_model->reporteresumenrubros($idEntidad->id);
            $datosalquiler = $this->adminentidades_model->reporteresumenalquiler($idEntidad->id);
            $pdf->AliasNbPages();
            $pdf->SetAutoPageBreak(true, 40);
            $pdf->SetFont('Arial', 'B', 9);


            $pdf->AddPage('L', 'Letter', null, null);
            $pdf->SetFillColor(31, 73, 125);
            $pdf->SetTextColor(0);
            $pdf->tablewidths = array(54, 30, 30, 30, 30, 30, 30, 30);
            $data = [];
            $data[] = array(utf8_decode('Rubro de bien'), utf8_decode('Bienes registrados'), utf8_decode('Bienes validados'), utf8_decode('Documentación definitiva'), utf8_decode('Documentación intermedia'), utf8_decode('Sin documentación'), utf8_decode('N° Total de Bienes sin Observaciones'), utf8_decode('N° Total de Bienes con Observaciones'));

            $pdf->morepagestable($data, 3);



            $num = 1;
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0);
            $total_registrados = 0;
            $total_validados = 0;
            $total_definitiva = 0;
            $total_intermedia = 0;
            $total_sin_documentacion = 0;
            $total_sin_observacion = 0;
            $total_con_observacion = 0;
            if (!empty($datos)) {
                foreach ($datos as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }
            if (!empty($datosalquiler)) {
                foreach ($datosalquiler as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }

            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(54, 7, 'TOTALES', 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_registrados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_validados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_definitiva, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_intermedia, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_documentacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_observacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_con_observacion, 1, 0, 'C', '1');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('Resumen de datos validados obtenidos mediante el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('* Para revisión, control y fines de auditoría, el reporte de los bienes validados por Entidad y Rubro a detalle se encuentra en el CD adjunto y en el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetTextColor(0);
            $pdf->SetXY(40, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(58, 167);
            $pdf->Cell(70, 3, 'Responsable de Validacion ', 0, 0, 'L');
            $pdf->SetXY(65, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');
            $pdf->SetXY(180, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(195, 167);
            $pdf->Cell(70, 3, 'Responsable de Supervisor ', 0, 0, 'L');
            $pdf->SetXY(210, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');

        }
        $pdf->Output(); 
    }
    public function reportevalidaciondocumentaciontodo4()
    {
        // $idFuncionario = $this->session->userdata('idfuncionario');
        $idsentidades = $this->entidades_model->select_validarTodo4();
        // $idEntidad = 20;
        // $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf4();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 9;
        $pdf->piepagina = 1;

        foreach ($idsentidades as $idEntidad) {
            $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad->id)->nombre;
            $datos = $this->adminentidades_model->reporteresumenrubros($idEntidad->id);
            $datosalquiler = $this->adminentidades_model->reporteresumenalquiler($idEntidad->id);
            $pdf->AliasNbPages();
            $pdf->SetAutoPageBreak(true, 40);
            $pdf->SetFont('Arial', 'B', 9);


            $pdf->AddPage('L', 'Letter', null, null);
            $pdf->SetFillColor(31, 73, 125);
            $pdf->SetTextColor(0);
            $pdf->tablewidths = array(54, 30, 30, 30, 30, 30, 30, 30);
            $data = [];
            $data[] = array(utf8_decode('Rubro de bien'), utf8_decode('Bienes registrados'), utf8_decode('Bienes validados'), utf8_decode('Documentación definitiva'), utf8_decode('Documentación intermedia'), utf8_decode('Sin documentación'), utf8_decode('N° Total de Bienes sin Observaciones'), utf8_decode('N° Total de Bienes con Observaciones'));

            $pdf->morepagestable($data, 3);



            $num = 1;
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0);
            $total_registrados = 0;
            $total_validados = 0;
            $total_definitiva = 0;
            $total_intermedia = 0;
            $total_sin_documentacion = 0;
            $total_sin_observacion = 0;
            $total_con_observacion = 0;
            if (!empty($datos)) {
                foreach ($datos as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }
            if (!empty($datosalquiler)) {
                foreach ($datosalquiler as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }

            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(54, 7, 'TOTALES', 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_registrados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_validados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_definitiva, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_intermedia, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_documentacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_observacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_con_observacion, 1, 0, 'C', '1');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('Resumen de datos validados obtenidos mediante el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('* Para revisión, control y fines de auditoría, el reporte de los bienes validados por Entidad y Rubro a detalle se encuentra en el CD adjunto y en el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetTextColor(0);
            $pdf->SetXY(40, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(58, 167);
            $pdf->Cell(70, 3, 'Responsable de Validacion ', 0, 0, 'L');
            $pdf->SetXY(65, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');
            $pdf->SetXY(180, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(195, 167);
            $pdf->Cell(70, 3, 'Responsable de Supervisor ', 0, 0, 'L');
            $pdf->SetXY(210, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');

        }
        $pdf->Output();
    }
    public function reportevalidaciondocumentaciontodo5()
    {
        // $idFuncionario = $this->session->userdata('idfuncionario');
        $idsentidades = $this->entidades_model->select_validarTodo5();
        // $idEntidad = 20;
        // $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf4();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 9;
        $pdf->piepagina = 1;

        foreach ($idsentidades as $idEntidad) {
            $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad->id)->nombre;
            $datos = $this->adminentidades_model->reporteresumenrubros($idEntidad->id);
            $datosalquiler = $this->adminentidades_model->reporteresumenalquiler($idEntidad->id);
            $pdf->AliasNbPages();
            $pdf->SetAutoPageBreak(true, 40);
            $pdf->SetFont('Arial', 'B', 9);


            $pdf->AddPage('L', 'Letter', null, null);
            $pdf->SetFillColor(31, 73, 125);
            $pdf->SetTextColor(0);
            $pdf->tablewidths = array(54, 30, 30, 30, 30, 30, 30, 30);
            $data = [];
            $data[] = array(utf8_decode('Rubro de bien'), utf8_decode('Bienes registrados'), utf8_decode('Bienes validados'), utf8_decode('Documentación definitiva'), utf8_decode('Documentación intermedia'), utf8_decode('Sin documentación'), utf8_decode('N° Total de Bienes sin Observaciones'), utf8_decode('N° Total de Bienes con Observaciones'));

            $pdf->morepagestable($data, 3);



            $num = 1;
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0);
            $total_registrados = 0;
            $total_validados = 0;
            $total_definitiva = 0;
            $total_intermedia = 0;
            $total_sin_documentacion = 0;
            $total_sin_observacion = 0;
            $total_con_observacion = 0;
            if (!empty($datos)) {
                foreach ($datos as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }
            if (!empty($datosalquiler)) {
                foreach ($datosalquiler as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }

            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(54, 7, 'TOTALES', 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_registrados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_validados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_definitiva, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_intermedia, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_documentacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_observacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_con_observacion, 1, 0, 'C', '1');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('Resumen de datos validados obtenidos mediante el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('* Para revisión, control y fines de auditoría, el reporte de los bienes validados por Entidad y Rubro a detalle se encuentra en el CD adjunto y en el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetTextColor(0);
            $pdf->SetXY(40, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(58, 167);
            $pdf->Cell(70, 3, 'Responsable de Validacion ', 0, 0, 'L');
            $pdf->SetXY(65, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');
            $pdf->SetXY(180, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(195, 167);
            $pdf->Cell(70, 3, 'Responsable de Supervisor ', 0, 0, 'L');
            $pdf->SetXY(210, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');

        }
        $pdf->Output();
    }
    public function reportevalidaciondocumentaciontodo6()
    {
        // $idFuncionario = $this->session->userdata('idfuncionario');
        $idsentidades = $this->entidades_model->select_validarTodo6();
        // $idEntidad = 20;
        // $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf4();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 9;
        $pdf->piepagina = 1;

        foreach ($idsentidades as $idEntidad) {
            $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad->id)->nombre;
            $datos = $this->adminentidades_model->reporteresumenrubros($idEntidad->id);
            $datosalquiler = $this->adminentidades_model->reporteresumenalquiler($idEntidad->id);
            $pdf->AliasNbPages();
            $pdf->SetAutoPageBreak(true, 40);
            $pdf->SetFont('Arial', 'B', 9);


            $pdf->AddPage('L', 'Letter', null, null);
            $pdf->SetFillColor(31, 73, 125);
            $pdf->SetTextColor(0);
            $pdf->tablewidths = array(54, 30, 30, 30, 30, 30, 30, 30);
            $data = [];
            $data[] = array(utf8_decode('Rubro de bien'), utf8_decode('Bienes registrados'), utf8_decode('Bienes validados'), utf8_decode('Documentación definitiva'), utf8_decode('Documentación intermedia'), utf8_decode('Sin documentación'), utf8_decode('N° Total de Bienes sin Observaciones'), utf8_decode('N° Total de Bienes con Observaciones'));

            $pdf->morepagestable($data, 3);



            $num = 1;
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0);
            $total_registrados = 0;
            $total_validados = 0;
            $total_definitiva = 0;
            $total_intermedia = 0;
            $total_sin_documentacion = 0;
            $total_sin_observacion = 0;
            $total_con_observacion = 0;
            if (!empty($datos)) {
                foreach ($datos as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }
            if (!empty($datosalquiler)) {
                foreach ($datosalquiler as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }

            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(54, 7, 'TOTALES', 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_registrados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_validados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_definitiva, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_intermedia, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_documentacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_observacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_con_observacion, 1, 0, 'C', '1');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('Resumen de datos validados obtenidos mediante el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('* Para revisión, control y fines de auditoría, el reporte de los bienes validados por Entidad y Rubro a detalle se encuentra en el CD adjunto y en el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetTextColor(0);
            $pdf->SetXY(40, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(58, 167);
            $pdf->Cell(70, 3, 'Responsable de Validacion ', 0, 0, 'L');
            $pdf->SetXY(65, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');
            $pdf->SetXY(180, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(195, 167);
            $pdf->Cell(70, 3, 'Responsable de Supervisor ', 0, 0, 'L');
            $pdf->SetXY(210, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');

        }
        $pdf->Output();
    }

    public function reportevalidaciondocumentaciontodo7($desde, $hasta)
    {
        // $idFuncionario = $this->session->userdata('idfuncionario');
        $idsentidades = $this->entidades_model->select_validarTodo7($desde, $hasta);
        // $idEntidad = 20;
        // $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf4();
        $pdf->titulo = "REPORTE DE TIPOS DE OBSERVACION";
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 9;
        $pdf->piepagina = 1;

        foreach ($idsentidades as $idEntidad) {
            $pdf->subTitulo = $this->adminentidades_model->getNombreEntidad($idEntidad->id)->nombre;
            $datos = $this->adminentidades_model->reporteresumenrubros($idEntidad->id);
            $datosalquiler = $this->adminentidades_model->reporteresumenalquiler($idEntidad->id);
            $pdf->AliasNbPages();
            $pdf->SetAutoPageBreak(true, 40);
            $pdf->SetFont('Arial', 'B', 9);


            $pdf->AddPage('L', 'Letter', null, null);
            $pdf->SetFillColor(31, 73, 125);
            $pdf->SetTextColor(0);
            $pdf->tablewidths = array(54, 30, 30, 30, 30, 30, 30, 30);
            $data = [];
            $data[] = array(utf8_decode('Rubro de bien'), utf8_decode('Bienes registrados'), utf8_decode('Bienes validados'), utf8_decode('Documentación definitiva'), utf8_decode('Documentación intermedia'), utf8_decode('Sin documentación'), utf8_decode('N° Total de Bienes sin Observaciones'), utf8_decode('N° Total de Bienes con Observaciones'));

            $pdf->morepagestable($data, 3);



            $num = 1;
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0);
            $total_registrados = 0;
            $total_validados = 0;
            $total_definitiva = 0;
            $total_intermedia = 0;
            $total_sin_documentacion = 0;
            $total_sin_observacion = 0;
            $total_con_observacion = 0;
            if (!empty($datos)) {
                foreach ($datos as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }
            if (!empty($datosalquiler)) {
                foreach ($datosalquiler as $valor) {

                    $pdf->AjustaCelda(54, 7, $valor->clase, 1, 0, 'L', '1');
                    $pdf->Cell(30, 7, $valor->cantidad, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->validados, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->definitivo, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->intermedio, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->sindoc, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->nobservado, 1, 0, 'C', '1');
                    $pdf->Cell(30, 7, $valor->observado, 1, 0, 'C', '1');

                    $pdf->ln();
                    $num++;
                    $total_registrados = $total_registrados + $valor->cantidad;
                    $total_validados = $total_validados + $valor->validados;
                    $total_definitiva = $total_definitiva + $valor->definitivo;
                    $total_intermedia = $total_intermedia + $valor->intermedio;
                    $total_sin_documentacion = $total_sin_documentacion + $valor->sindoc;
                    $total_sin_observacion = $total_sin_observacion + $valor->nobservado;
                    $total_con_observacion = $total_con_observacion + $valor->observado;
                }
            }

            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(54, 7, 'TOTALES', 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_registrados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_validados, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_definitiva, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_intermedia, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_documentacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_sin_observacion, 1, 0, 'C', '1');
            $pdf->Cell(30, 7, $total_con_observacion, 1, 0, 'C', '1');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('Resumen de datos validados obtenidos mediante el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->ln();
            $pdf->Cell(70, 7, utf8_decode('* Para revisión, control y fines de auditoría, el reporte de los bienes validados por Entidad y Rubro a detalle se encuentra en el CD adjunto y en el Sistema de Validación Documental.'), 0, 0, 'L');
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetTextColor(0);
            $pdf->SetXY(40, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(58, 167);
            $pdf->Cell(70, 3, 'Responsable de Validacion ', 0, 0, 'L');
            $pdf->SetXY(65, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');
            $pdf->SetXY(180, 163);
            $pdf->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $pdf->SetXY(195, 167);
            $pdf->Cell(70, 3, 'Responsable de Supervisor ', 0, 0, 'L');
            $pdf->SetXY(210, 170);
            $pdf->Cell(70, 3, 'Firma y Sello', 0, 0, 'L');

        }
        $pdf->Output('I');
    }
}
