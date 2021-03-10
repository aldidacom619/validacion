<?php

/**
 * Created by PhpStorm.
 * User: framos
 * Date: 13/9/2017
 * Time: 3:58 PM
 */
class Adminreportes2 extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->_is_logued_in();
        $this->load->model('model');
        $this->load->model('adminentidades_model');
        $this->load->model('adminreporte_model');
        $this->load->library('pdf2');
        $this->load->helper('validacion_helper');
        $this->load->helper(array('form', 'url'));
        $this->usuario['usuario'] = $this->session->userdata('nombre_completo');
    }
    function _is_logued_in() {
        $is_logued_in = $this->session->userdata('is_logued_in');
        $tipo_user = $this->session->userdata('administrador');
        if ($is_logued_in != TRUE && $tipo_user == 'f') {
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

    /**
     * description: Reporte de avance general de validacion documental
     * @param $idFuncionario
     */
    public function reporteAvanceGeneral($idFuncionario)
    {
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf2();
        $fecha_hoy = $pdf->fechacompleta();
        $pdf->titulo = "REPORTE DE AVANCE GENERAL DE VALIDACION DOCUMENTAL";
        $pdf->subTitulo = "Usuario: ".$nombre_validador->nombre;
        $pdf->fecha = "Fecha:  ".$fecha_hoy;
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 3;
        $pdf->piepagina = 1;
        $datos = $this->adminreporte_model->reporteGeneralValidacion();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 40);
        $pdf->SetFont('Arial', 'B', 9);
        $encabezados = array(
            'Descripción',
            'Inmueble',
            'Vehículos',
            'Maquinaria y Equipo',
            'Maquinaria Pesada Móvil',
            'Inmuebles en Alquiler',
            'Vehículos en Alquiler',
            'Porcentaje',
            'Total'
        );
        $w = array(74,23,23,23,23,23,23,23,23);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L','Letter',null,null);
        $num = 1;
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                switch($num){
                    case 1:
                        $pdf->AjustaCelda(74, 7, utf8_decode('Nº de Bienes Declarados'), 1, 0, 'L', '1');
                        $pdf->Cell(23, 7, $valor->inmuebles, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculos, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria_pesada, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->inmueble_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculo_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, '100%', 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->total, 1, 0, 'C', '1');
                        $pdf->ln();
                        $inmuebles = $valor->inmuebles;
                        $vehiculo = $valor->vehiculos;
                        $maquinaria = $valor->maquinaria;
                        $maquinaria_pesada = $valor->maquinaria_pesada;
                        $inmueble_alquiler = $valor->inmueble_alquiler;
                        $vehiculo_alquiler = $valor->vehiculo_alquiler;
                        $total = $valor->total;
                        $num++;
                        break;
                    case 2:
                        $pdf->AjustaCelda(74, 7, utf8_decode('Nº de Bienes Validados'), 1, 0, 'L', '1');
                        $pdf->Cell(23, 7, $valor->inmuebles, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculos, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria_pesada, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->inmueble_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculo_alquiler, 1, 0, 'C', '1');
                        ($total == 0)? $porcentaje = utf8_decode('Ø'): $porcentaje = ceil((100*$valor->total)/$total);
                        $pdf->Cell(23, 7, $porcentaje.'%', 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->total, 1, 0, 'C', '1');
                        $pdf->ln();
                        $inmuebles = $inmuebles - $valor->inmuebles;
                        $vehiculo = $vehiculo - $valor->vehiculos;
                        $maquinaria = $maquinaria - $valor->maquinaria;
                        $maquinaria_pesada = $maquinaria_pesada - $valor->maquinaria_pesada;
                        $inmueble_alquiler = $inmueble_alquiler - $valor->inmueble_alquiler;
                        $vehiculo_alquiler = $vehiculo_alquiler - $valor->vehiculo_alquiler;
                        $total = $total - $valor->total;
                        $pdf->SetFillColor(200,200,200);
                        $pdf->AjustaCelda(74, 7, utf8_decode('Nº de Bienes a Validar'), 1, 0, 'L', '1');
                        $pdf->Cell(23, 7, $inmuebles, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $vehiculo, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $maquinaria, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $maquinaria_pesada, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $inmueble_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $vehiculo_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, 100-$porcentaje.'%', 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $total, 1, 0, 'C', '1');
                        $pdf->ln();
                        $num++;
                        break;
                    case 3:
                        $pdf->SetFillColor(255,255,255);
                        $pdf->AjustaCelda(74, 7, utf8_decode('Nº de Documentos Declarados'), 1, 0, 'L', '1');
                        $pdf->Cell(23, 7, $valor->inmuebles, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculos, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria_pesada, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->inmueble_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculo_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, '100%', 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->total, 1, 0, 'C', '1');
                        $pdf->ln();
                        $inmuebles = $valor->inmuebles;
                        $vehiculo = $valor->vehiculos;
                        $maquinaria = $valor->maquinaria;
                        $maquinaria_pesada = $valor->maquinaria_pesada;
                        $inmueble_alquiler = $valor->inmueble_alquiler;
                        $vehiculo_alquiler = $valor->vehiculo_alquiler;
                        $total = $valor->total;
                        $num++;
                        break;
                    case 4:
                        $pdf->AjustaCelda(74, 7, utf8_decode('Nº de Documentos Validados'), 1, 0, 'L', '1');
                        $pdf->Cell(23, 7, $valor->inmuebles, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculos, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria_pesada, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->inmueble_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculo_alquiler, 1, 0, 'C', '1');
                        ($total == 0)? $porcentaje = utf8_decode('Ø'): $porcentaje = ceil((100*$valor->total)/$total);
                        $pdf->Cell(23, 7, $porcentaje.'%', 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->total, 1, 0, 'C', '1');
                        $pdf->ln();
                        $inmuebles = $inmuebles - $valor->inmuebles;
                        $vehiculo = $vehiculo - $valor->vehiculos;
                        $maquinaria = $maquinaria - $valor->maquinaria;
                        $maquinaria_pesada = $maquinaria_pesada - $valor->maquinaria_pesada;
                        $inmueble_alquiler = $inmueble_alquiler - $valor->inmueble_alquiler;
                        $vehiculo_alquiler = $vehiculo_alquiler - $valor->vehiculo_alquiler;
                        $total = $total - $valor->total;
                        $pdf->SetFillColor(200,200,200);
                        $pdf->AjustaCelda(74, 7, utf8_decode('Nº de Documentos a Validar'), 1, 0, 'L', '1');
                        $pdf->Cell(23, 7, $inmuebles, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $vehiculo, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $maquinaria, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $maquinaria_pesada, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $inmueble_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $vehiculo_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, 100-$porcentaje.'%', 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $total, 1, 0, 'C', '1');
                        $pdf->ln();
                        $num++;
                        break;
                    case 5:
                        $pdf->SetFillColor(255,255,255);
                        $pdf->AjustaCelda(74, 7, utf8_decode('Nº de Documentos Agregados por Validador'), 1, 0, 'L', '1');
                        $pdf->Cell(23, 7, $valor->inmuebles, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculos, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria_pesada, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->inmueble_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculo_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, '100%', 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->total, 1, 0, 'C', '1');
                        $pdf->ln();
                        $inmuebles = $valor->inmuebles;
                        $vehiculo = $valor->vehiculos;
                        $maquinaria = $valor->maquinaria;
                        $maquinaria_pesada = $valor->maquinaria_pesada;
                        $inmueble_alquiler = $valor->inmueble_alquiler;
                        $vehiculo_alquiler = $valor->vehiculo_alquiler;
                        $total = $valor->total;
                        $num++;
                        break;
                    case 6:
                        $pdf->AjustaCelda(74, 7, utf8_decode('Nº de Documentos Agregados y Validados'), 1, 0, 'L', '1');
                        $pdf->Cell(23, 7, $valor->inmuebles, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculos, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->maquinaria_pesada, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->inmueble_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->vehiculo_alquiler, 1, 0, 'C', '1');
                        ($total == 0)? $porcentaje = utf8_decode('Ø'): $porcentaje = ceil((100*$valor->total)/$total);
                        $pdf->Cell(23, 7, $porcentaje.'%', 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $valor->total, 1, 0, 'C', '1');
                        $pdf->ln();
                        $inmuebles = $inmuebles - $valor->inmuebles;
                        $vehiculo = $vehiculo - $valor->vehiculos;
                        $maquinaria = $maquinaria - $valor->maquinaria;
                        $maquinaria_pesada = $maquinaria_pesada - $valor->maquinaria_pesada;
                        $inmueble_alquiler = $inmueble_alquiler - $valor->inmueble_alquiler;
                        $vehiculo_alquiler = $vehiculo_alquiler - $valor->vehiculo_alquiler;
                        $total = $total - $valor->total;
                        $pdf->SetFillColor(200,200,200);
                        $pdf->AjustaCelda(74, 7, utf8_decode('Nº de Documentos Agregados y Eliminados'), 1, 0, 'L', '1');
                        $pdf->Cell(23, 7, $inmuebles, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $vehiculo, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $maquinaria, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $maquinaria_pesada, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $inmueble_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $vehiculo_alquiler, 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, (100 - $porcentaje).'%', 1, 0, 'C', '1');
                        $pdf->Cell(23, 7, $total, 1, 0, 'C', '1');
                        $pdf->ln();
                        $num++;
                        break;
                    default:
                }
            }
        }
        $pdf->Output();
    }

    /**
     * description: reporte de validacion por departamento
     * @param $idFuncionario
     */
    public function reporteValidacionDepartamento($idFuncionario)
    {
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf2();
        $fecha_hoy = $pdf->fechacompleta();
        $pdf->titulo = "REPORTE DE VALIDACION POR DEPARTAMENTO";
        $pdf->subTitulo = "Usuario: ".$nombre_validador->nombre;
        $pdf->fecha = "Fecha:  ".$fecha_hoy;
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 3;
        $pdf->piepagina = 1;
        $datos = $this->adminreporte_model->reporteValidacionDepartamento();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 40);
        $pdf->SetFont('Arial', 'B', 8);
        $encabezados = array(
            'Nro',
            'Departamento',
            'Nº Entidades Públicas',
            'Nº Bienes Declarados',
            'Nº Bienes Validados',
            'Nº Bienes a Validar',
            'Nº Documentos Declarados',
            'Nº Documentos Validados',
            'Nº Documentos a Validar',
            'Nº Doc. Agregados Por Validador',
            'Nº Doc. Agregados y Validados',
            'Nº Doc. Agregados y Eliminados',
            '% Avance de Acuerdo a Documentación ',
            '% Avance de Acuerdo a los Bienes',
        );
        $w = array(7,35,18,18,18,18,19,19,18,18,18,18,18,18);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L','Letter',null,null);
        $pdf->subTituloBotoom = "RUBRO INMUEBLES";
        $num = 1;
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            $a = 0;$b = 0;$c = 0;$d = 0;$e = 0;$f = 0;$g = 0;$h = 0;$i = 0;$j = 0;
            foreach($datos as $valor)
            {
                $pdf->Cell(7, 7, $num, 1, 0, 'C', '1');
                $pdf->AjustaCelda(35, 7, utf8_decode($valor->descripcion), 1, 0, 'L', '1');
                $pdf->Cell(18, 7, $valor->departamento, 1, 0, 'C', '1');
                $pdf->Cell(18, 7, $valor->totalbienes, 1, 0, 'C', '1');
                $pdf->Cell(18, 7, $valor->bienesvalidados, 1, 0, 'C', '1');
                $pdf->Cell(18, 7, $valor->saldobienes, 1, 0, 'C', '1');
                $pdf->Cell(19, 7, $valor->totaldocumentos, 1, 0, 'C', '1');
                $pdf->Cell(19, 7, $valor->totaldocumentos_val, 1, 0, 'C', '1');
                $pdf->Cell(18, 7, $valor->totaldocumentos_noval, 1, 0, 'C', '1');
                $pdf->Cell(18, 7, $valor->totaldocumentos_adicionado, 1, 0, 'C', '1');
                $pdf->Cell(18, 7, $valor->totaldocumentos_adicionado_val, 1, 0, 'C', '1');
                $pdf->Cell(18, 7, $valor->totaldocumentos_adicionado_noval, 1, 0, 'C', '1');
                (($valor->totaldocumentos+$valor->totaldocumentos_adicionado) == 0)?
                    $porcentaje = utf8_decode('Ø'):
                    $porcentaje = ceil((100*($valor->totaldocumentos_val+$valor->totaldocumentos_adicionado_val))/($valor->totaldocumentos+$valor->totaldocumentos_adicionado)).'%';
                $pdf->Cell(18, 7, $porcentaje, 1, 0, 'C', '1');
                ($valor->totalbienes == 0)?
                    $porcentaje = utf8_decode('Ø'):
                    $porcentaje = ceil((100*$valor->bienesvalidados)/$valor->totalbienes).'%';
                $pdf->Cell(18, 7, $porcentaje, 1, 0, 'C', '1');
                $pdf->ln();
                $a = $a + $valor->departamento;
                $b = $b + $valor->totalbienes;
                $c = $c + $valor->bienesvalidados;
                $d = $d + $valor->saldobienes;
                $e = $e + $valor->totaldocumentos;
                $f = $f + $valor->totaldocumentos_val;
                $g = $g + $valor->totaldocumentos_noval;
                $h = $h + $valor->totaldocumentos_adicionado;
                $i = $i + $valor->totaldocumentos_adicionado_val;
                $j = $j + $valor->totaldocumentos_adicionado_noval;
                $num++;
            }
            $pdf->SetFillColor(200,200,200);
            $pdf->Cell(7, 7, $num, 1, 0, 'C', '1');
            $pdf->AjustaCelda(35, 7, 'Total', 1, 0, 'L', '1');
            $pdf->Cell(18, 7, $a, 1, 0, 'C', '1');
            $pdf->Cell(18, 7, $b, 1, 0, 'C', '1');
            $pdf->Cell(18, 7, $c, 1, 0, 'C', '1');
            $pdf->Cell(18, 7, $d, 1, 0, 'C', '1');
            $pdf->Cell(19, 7, $e, 1, 0, 'C', '1');
            $pdf->Cell(19, 7, $f, 1, 0, 'C', '1');
            $pdf->Cell(18, 7, $g, 1, 0, 'C', '1');
            $pdf->Cell(18, 7, $h, 1, 0, 'C', '1');
            $pdf->Cell(18, 7, $i, 1, 0, 'C', '1');
            $pdf->Cell(18, 7, $j, 1, 0, 'C', '1');
            $pdf->Cell(18, 7, '', 1, 0, 'C', '1');
            $pdf->Cell(18, 7, '', 1, 0, 'C', '1');
            $pdf->ln();
        }


        $pdf->Output();
    }

    /**
     * description: reporte de avance de validacion por servidor publico
     * @param $idFuncionario
     */
    public function reporteAvanceServidor($idFuncionario)
    {
        $nombre_validador = $this->adminentidades_model->getNombreValidador($idFuncionario);
        $pdf = new Pdf2();
        $fecha_hoy = $pdf->fechacompleta();
        $pdf->titulo = "REPORTE GENERAL DE AVANCE DE VALIDACION POR SERVIDOR PUBLICO";
        $pdf->subTitulo = "Usuario: ".$nombre_validador->nombre;
        $pdf->fecha = "Fecha:  ".$fecha_hoy;
        $pdf->xheader = 40;
        $pdf->yheader = 8;
        $pdf->cabecera = 3;
        $pdf->piepagina = 1;
        $datos = $this->adminreporte_model->reporteGeneralAvance();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 40);
        $pdf->SetFont('Arial', 'B', 8);
        $encabezados = array(
            'Nro',
            'Validador',
            'Nº Entidades Asignadas',
            'Nº Bienes Declarados',
            'Nº Bienes Validados',
            'Nº Bienes a Validar',
            'Nº Documentos Declarados',
            'Nº Documentos Validados',
            'Nº Documentos a Validar',
            'Nº Documentos Agregados',
            '% Avance Por Documentos',
            '% Avance Por Bienes'
        );
        $w = array(8,55,18,20,20,20,20,20,20,20,20,18);
        foreach ($encabezados as $val){
            $encabezados_[] = iconv('UTF-8', 'windows-1252', $val);
        }
        $pdf->setEncabezadoG($encabezados_);
        $pdf->setWidthsG($w);
        $pdf->AddPage('L','Letter',null,null);
        $num = 1;
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        if(!empty($datos))
        {
            foreach($datos as $valor)
            {
                $pdf->Cell(8, 7, $num, 1, 0, 'C', '1');
                $pdf->AjustaCelda(55, 7, utf8_decode($valor->nombre), 1, 0, 'L', '1');
                $pdf->Cell(18, 7, $valor->entidades, 1, 0, 'C', '1');
                $pdf->Cell(20, 7, $valor->totalbienes, 1, 0, 'C', '1');
                $pdf->Cell(20, 7, $valor->bienesvalidados, 1, 0, 'C', '1');
                $pdf->Cell(20, 7, $valor->saldo, 1, 0, 'C', '1');
                $pdf->Cell(20, 7, $valor->totaldocumentos, 1, 0, 'C', '1');
                $pdf->Cell(20, 7, $valor->totaldocumentos_val, 1, 0, 'C', '1');
                $pdf->Cell(20, 7, $valor->saldodoc, 1, 0, 'C', '1');
                $pdf->Cell(20, 7, $valor->docadicionado, 1, 0, 'C', '1');
                $pdf->Cell(20, 7, ($valor->totaldocumentos == 0)? utf8_decode('Ø'): ceil((100*$valor->totaldocumentos_val)/$valor->totaldocumentos).'%', 1, 0, 'C', '1');
                $pdf->Cell(18, 7, ($valor->totalbienes == 0)? utf8_decode('Ø'): ceil((100*$valor->bienesvalidados)/$valor->totalbienes).'%', 1, 0, 'C', '1');
                $pdf->ln();
                $num++;
            }
        }
        $pdf->Output();
    }

}