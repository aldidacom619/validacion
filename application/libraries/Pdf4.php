<?php
ini_set("allow_url_fopen", 1);

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . "/libraries/fpdf/fpdf.php";

class Pdf4 extends FPDF
{

    public $xheader;
    public $yheader;
    public $anchoheader = 185;
    public $cabecera;
    public $validador;
    public $titulo;
    public $subTitulo;
    public $subTituloBotoom;
    public $entidad;
    public $fecha;
    public $fechaini;
    public $fechafin;
    public $piepagina;
    private $encabezado;
    private $encabezadot;
    private $wi;
    private $cds220;
    private $rubro;

    public function __construct()
    {
        parent::__construct();
        $this->mes = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
    }
    function setEncabezadoG($e)
    {
        $this->encabezado = $e;
    }

    function setWidthsG($w)
    {
        $this->wi = $w;
    }
    public function HeaderT()
    {


        //$datos= utf8_decode("Observaciones: ".$this->observaciones);
        $this->SetXY(10, 50);
        $this->MultiCell(195, 5, utf8_decode('De acuerdo a lo establecido en la Ley de Autonomias N° 031 de fecha 19 de julio de 2010, se recomienda la actualización en oficinas de Derechos Reales del documento FOLIO REAL, en el inciso (A.- TITULARIDAD SOBRE EL DOMINIO))'), 1);
    }

    public function HeaderV()
    {


        //$datos= utf8_decode("Observaciones: ".$this->observaciones);
        $this->SetXY(10, 48);
        $this->MultiCell(195, 6, utf8_decode('De acuerdo a lo establecido en la Ley de Autonomias N° 031 de fecha 19 de julio de 2010, se recomienda la actualización en las oficinas que corresponda del documento RUAT,  en el inciso (D.- DATOS PROPIETARIO))'), 1, 'B');
    }
    public function Header()
    {
        $this->SetFont('Arial', 'B', 8);
        $this->Image(base_url() . 'assets/img/logo.png', 10, 5, 22);
        $this->Cell(90);
        $this->Cell(0, -5, 'SERVICIO NACIONAL DE PATRIMONIO DEL ESTADO', 0, 0, 'R');
        $this->ln(0);
        $this->Cell(25);
        $this->Cell(0, 10, '', 'T');
        $this->ln(0);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(90);
        $this->Cell(0, 5, utf8_decode('Ministerio de Economía y Finanzas Públicas'), 0, 0, 'R');
        $this->ln(3);
        $this->Cell(90);
        $this->Cell(0, 5, utf8_decode('Viceministerio de Tesoro y Crédito Público'), 0, 0, 'R');
        $this->SetFont('Arial', 'B', 13);
        $this->ln(10);
    }
    public function Header2()
    {
    }
    public function HeaderTitle($title)
    {
        $this->SetFont('Arial', 'B', 8);
        $this->Image(base_url() . 'assets/img/logo.png', 10, 5, 22);
        $this->Cell(90);
        $this->Cell(0, -5, 'SERVICIO NACIONAL DE PATRIMONIO DEL ESTADO', 0, 0, 'R');
        $this->ln(0);
        $this->Cell(25);
        $this->Cell(0, 10, '', 'T');
        $this->ln(0);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(90);
        $this->Cell(0, 5, utf8_decode('Ministerio de Economía y Finanzas Públicas'), 0, 0, 'R');
        $this->ln(3);
        $this->Cell(90);
        $this->Cell(0, 5, utf8_decode('Viceministerio de Tesoro y Crédito Público'), 0, 0, 'R');
        $this->SetFont('Arial', 'B', 13);
        $this->ln(5);
        $this->Cell(0, 10, $title, 0, 0, 'C');
        $this->Ln(5);

        $this->SetFont('Times', 'B', 13);

        /** cabecera 2020*/
        if ($this->cabecera == 9) {
            $this->SetFont('Times', 'B', 10);
            $this->SetY(15); //-16
            //$this->Cell(10);
            $titulo =  utf8_decode($this->titulo);
            $this->Ln(5); //2019
            $this->Cell(0, 0, utf8_decode('REPORTE DE VALIDACION DOCUMENTAL 2018 Y 2019'), 0, 0, 'C'); //2019
            // $this->Cell(0,0,$titulo,0,0,'C');
            if (!is_null($this->subTitulo)) {
                $this->Ln(5);
                $subtitulo =  utf8_decode($this->subTitulo);
                //$this->Cell(0,0, '', 0);
                $this->Cell(0, 0, $subtitulo, 0, 0, 'C');
            }
            $this->SetFont('Times', 'B', 10);
            if (!is_null($this->validador)) {
                $this->Ln(5);
                $titulo1 =  utf8_decode("Validador: " . $this->validador);
                $this->Cell(0, 0, $titulo1, 0, 0, 'C');
            }
            if (!is_null($this->fecha)) {
                $this->SetFont('Times', 'B', 12);
                $this->Ln(5);
                $this->Cell(0, 0, $this->fecha, 0, 0, 'C');
            }
            if (!is_null($this->fechaini)) {
                // $this->Ln(5);
                // $this->Cell(0,0,$this->fechaini." al ".$this->fechafin,0,0,'C');
            }
            if (is_null($this->subTituloBotoom)) {
                $this->Ln(3);
            } else {
                $this->Ln(5);
                $this->SetFont('Times', 'B', 10);
                $this->Cell(0, 0, $this->subTituloBotoom, 0, 0, 'C');
                $this->Ln(3);
            }

            //encabezado grilla
            $this->Ln(22);
            $this->SetFillColor(31, 73, 125);
            $this->SetTextColor(255);
            //$pdf->SetDrawColor(128,0,0);
            $this->SetLineWidth(.2);
            $this->SetFont('Arial', 'B', 8);

            //Cabecera
            $this->SetWidths($this->wi);
            $this->RowHeader($this->encabezado, false, 'FD', 8);
        }
        if ($this->cabecera == 5) {
            $this->SetFont('Times', 'B', 12);
            $this->SetY(15); //-16
            //$this->Cell(10);
            $titulo =  utf8_decode($this->titulo);
            $this->Ln(5); //2019
            $this->Cell(0, 0, utf8_decode('REPORTE DE OBSERVACIONES DE LA VALIDACION DOCUMENTAL'), 0, 0, 'C'); //2019
            // $this->Cell(0,0,$titulo,0,0,'C');
            if (!is_null($this->subTitulo)) {
                $this->Ln(5);
                $subtitulo =  utf8_decode($this->subTitulo);
                $this->Cell(0, 0, $subtitulo, 0, 0, 'C');
            }
            $this->SetFont('Times', 'B', 12);
            if (!is_null($this->validador)) {
                $this->Ln(5);
                $titulo1 =  utf8_decode("Validador: " . $this->validador);
                $this->Cell(0, 0, $titulo1, 0, 0, 'C');
            }
            if (!is_null($this->fecha)) {
                $this->SetFont('Times', 'B', 12);
                $this->Ln(5);
                $this->Cell(0, 0, $this->fecha, 0, 0, 'C');
            }
            if (!is_null($this->fechaini)) {
                // $this->Ln(5);
                // $this->Cell(0,0,$this->fechaini." al ".$this->fechafin,0,0,'C');
            }
            if (is_null($this->subTituloBotoom)) {
                $this->Ln(3);
            } else {
                $this->Ln(5);
                $this->SetFont('Times', 'B', 12);
                $this->Cell(0, 0, $this->subTituloBotoom, 0, 0, 'C');
                $this->Ln(3);
            }

            //encabezado grilla
            $this->SetFillColor(31, 73, 125);
            $this->SetTextColor(255);
            //$pdf->SetDrawColor(128,0,0);
            $this->SetLineWidth(.2);
            $this->SetFont('Arial', 'B', 8);
            //Cabecera
            $this->SetWidths($this->wi);
            $this->RowHeader($this->encabezado, false, 'FD', 8);
        }
    }

    public function Footer()
    {

        if ($this->piepagina != 1) {


            $titulo1 =  utf8_decode($this->validador);
            $this->SetXY(40, 189);
            $this->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $this->SetXY(45, 192);
            $this->Cell(70, 3, ($titulo1), 0, 0, 'L');
            $this->SetXY(58, 195);
            $this->Cell(70, 3, 'VALIDADOR', 0, 0, 'L');

            $this->SetXY(180, 189);
            $this->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $this->SetXY(185, 192);
            $this->Cell(70, 3, 'SELLO Y FIRMA SUPERVISOR', 0, 0, 'L');

            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        } else {


            $titulo1 =  utf8_decode($this->validador);
            $this->SetXY(40, 252);
            $this->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $this->SetXY(45, 252);
            $this->Cell(70, 3, ($titulo1), 0, 0, 'L');
            $this->SetXY(58, 255);
            $this->Cell(70, 3, 'VALIDADOR', 0, 0, 'L');

            $this->SetXY(120, 252);
            $this->Cell(70, 3, '.........................................................................', 0, 0, 'L');
            $this->SetXY(125, 255);
            $this->Cell(70, 3, 'SELLO Y FIRMA SUPERVISOR', 0, 0, 'L');

            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            // $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }

    public function Footer2()
    {

        if ($this->piepagina != 1) {


            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }

    function AjustaCelda($ancho, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $scale = false, $force = true)
    {
        $TamanoInicial = $this->FontSizePt;
        $TamanoLetra = $this->FontSizePt;
        $Decremento = 0.5;
        while ($this->GetStringWidth($txt) > $ancho)
            $this->SetFontSize($TamanoLetra -= $Decremento);
        $this->Cell($ancho, $h, $txt, $border, $ln, $align, $fill, $link, $scale, $force);
        $this->SetFontSize($TamanoInicial);
    }

    function SetFontSize($size)
    {
        if ($this->FontSizePt == $size)
            return;
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        if ($this->page > 0)
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
    }

    /** @var fransc  * */
    var $widths;
    var $aligns;
    var $ah;
    var $aw;
    var $ax;
    var $ay;
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Get_x()
    {
        return $this->ax;
    }
    function Get_y()
    {
        return $this->ay;
    }
    function Get_w()
    {
        return $this->aw;
    }
    function Get_h()
    {
        return $this->ah;
    }
    function WriteTable($tcolums)
    {
        // go through all colums
        for ($i = 0; $i < sizeof($tcolums); $i++) {
            //para centra un poco la tabla
            $this->Cell(2); //10
            $current_col = $tcolums[$i];
            $height = 0;

            // get max height of current col
            $nb = 0;
            for ($b = 0; $b < sizeof($current_col); $b++) {
                // set style
                $this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetFillColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['textcolor']);
                $this->SetTextColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);
                $this->SetLineWidth($current_col[$b]['linewidth']);

                $nb = max($nb, $this->NbLines($current_col[$b]['width'], $current_col[$b]['text']));
                $height = $current_col[$b]['height'];
            }
            $h = $height * $nb;


            // Issue a page break first if needed
            $this->CheckPageBreak($h);

            // Draw the cells of the row
            for ($b = 0; $b < sizeof($current_col); $b++) {
                $w = $current_col[$b]['width'];
                $a = $current_col[$b]['align'];

                // Save the current position
                $x = $this->GetX();
                $y = $this->GetY();

                // set style
                $this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetFillColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['textcolor']);
                $this->SetTextColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);
                $this->SetLineWidth($current_col[$b]['linewidth']);

                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);


                // Draw Cell Background
                $this->Rect($x, $y, $w, $h, 'FD');

                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);

                // Draw Cell Border
                if (substr_count($current_col[$b]['linearea'], "T") > 0) {
                    $this->Line($x, $y, $x + $w, $y);
                }

                if (substr_count($current_col[$b]['linearea'], "B") > 0) {
                    $this->Line($x, $y + $h, $x + $w, $y + $h);
                }

                if (substr_count($current_col[$b]['linearea'], "L") > 0) {
                    $this->Line($x, $y, $x, $y + $h);
                }

                if (substr_count($current_col[$b]['linearea'], "R") > 0) {
                    $this->Line($x + $w, $y, $x + $w, $y + $h);
                }


                // Print the text
                $this->MultiCell($w, $current_col[$b]['height'], $current_col[$b]['text'], 0, $a, 0);

                // Put the position to the right of the cell
                $this->SetXY($x + $w, $y);
            }

            // Go to the next line
            $this->Ln($h);
        }
    }
    function Row($data, $code = false, $fills = '', $fh = '')
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        if ($fh == "") {
            $h = 3.5 * $nb;
        } else {
            $h = 3.5 * $nb;
            if ($h < $fh)
                $h = $fh;
        }
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $ax = $x;
            $ay = $y;
            $aw = $w;
            $ah = $h;
            $this->Rect($x, $y, $w, $h, $fills);
            //Print the text
            $this->MultiCell($w, 3.5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowHeader($data, $code = false, $fills = '', $fh = '')
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        if ($fh == "") {
            $h = 3 * $nb;
        } else {
            $h = 3 * $nb;
            if ($h < $fh)
                $h = $fh;
        }
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $ax = $x;
            $ay = $y;
            $aw = $w;
            $ah = $h;
            $this->Rect($x, $y, $w, $h, $fills);
            //Print the text
            $this->MultiCell($w, 3, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }


    function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));

        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }

    function fecha()
    {
        $mes = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        return;
    }
    function fechacompleta()
    {
        $GetD = getdate();
        $verd = array(
            1 => "Lunes", 2 => "Martes", 3 => "Mi&eacute;rcoles", 4 => "Jueves", 5 => "Viernes", 6 => "Sábado", 7 => "Domingo"
        );
        $verm = array(
            1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio",
            8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
        );
        //return $verd[$GetD['wday']].", ".$GetD['mday']." de ".$verm[$GetD['mon']]." del ".$GetD['year'];
        return " " . $GetD['mday'] . " de " . $verm[$GetD['mon']] . " de " . $GetD['year'] . "  Hora:  " . $GetD['hours'] . ":" . $GetD['minutes'] . ":" . $GetD['seconds'];
    }
    function fechacompleta2()
    {
        $GetD = getdate();
        $verd = array(
            1 => "Lunes", 2 => "Martes", 3 => "Mi&eacute;rcoles", 4 => "Jueves", 5 => "Viernes", 6 => "Sábado", 7 => "Domingo"
        );
        $verm = array(
            1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio",
            8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
        );
        //return $verd[$GetD['wday']].", ".$GetD['mday']." de ".$verm[$GetD['mon']]." del ".$GetD['year'];
        return " " . $GetD['mday'] . " de " . $verm[$GetD['mon']] . " de " . $GetD['year'];
    }
    function RowTitle($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 2.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        $this->SetFillColor(31, 73, 125);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 8);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h, 'FD');
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, 'C');
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h - 5);
    }
    function Row2($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 2.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', 'B', 8);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h, 'FD');
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, 'C');
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h - 5);
    }

    function RowWell($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 2.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 7);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h, 'FD');
            //Print the text
            $this->MultiCell($w, 2.5, $data[$i], 0, 'C');
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h + 1);
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public $tablewidths;
    public $footerset;

    function _beginpage($orientation, $size, $rotation)
    {
        $this->page++;
        if (!isset($this->pages[$this->page])) // solves the problem of overwriting a page if it already exists
            $this->pages[$this->page] = '';
        $this->state = 2;
        $this->x = $this->lMargin;
        $this->y = $this->tMargin;
        $this->FontFamily = '';
        // Check page size and orientation
        if ($orientation == '')
            $orientation = $this->DefOrientation;
        else
            $orientation = strtoupper($orientation[0]);
        if ($size == '')
            $size = $this->DefPageSize;
        else
            $size = $this->_getpagesize($size);
        if ($orientation != $this->CurOrientation || $size[0] != $this->CurPageSize[0] || $size[1] != $this->CurPageSize[1]) {
            // New size or orientation
            if ($orientation == 'P') {
                $this->w = $size[0];
                $this->h = $size[1];
            } else {
                $this->w = $size[1];
                $this->h = $size[0];
            }
            $this->wPt = $this->w * $this->k;
            $this->hPt = $this->h * $this->k;
            $this->PageBreakTrigger = $this->h - $this->bMargin;
            $this->CurOrientation = $orientation;
            $this->CurPageSize = $size;
        }
        if ($orientation != $this->DefOrientation || $size[0] != $this->DefPageSize[0] || $size[1] != $this->DefPageSize[1])
            $this->PageInfo[$this->page]['size'] = array($this->wPt, $this->hPt);
        if ($rotation != 0) {
            if ($rotation % 90 != 0)
                $this->Error('Incorrect rotation value: ' . $rotation);
            $this->CurRotation = $rotation;
            $this->PageInfo[$this->page]['rotation'] = $rotation;
        }
    }
    function morepagestable($datas, $lineheight = 8)
    {
        // some things to set and 'remember'
        $l = $this->lMargin;
        $startheight = $h = $this->GetY();
        $startpage = $currpage = $maxpage = $this->page;

        // calculate the whole width
        $fullwidth = 0;
        foreach ($this->tablewidths as $width) {
            $fullwidth += $width;
        }

        // Now let's start to write the table
        foreach ($datas as $row => $data) {
            $this->page = $currpage;
            // write the horizontal borders
            $this->Line($l, $h, $fullwidth + $l, $h);
            // write the content and remember the height of the highest col
            foreach ($data as $col => $txt) {
                $this->page = $currpage;
                $this->SetXY($l, $h);
                $this->MultiCell($this->tablewidths[$col], $lineheight, $txt);
                $l += $this->tablewidths[$col];

                if (!isset($tmpheight[$row . '-' . $this->page]))
                    $tmpheight[$row . '-' . $this->page] = 0;
                if ($tmpheight[$row . '-' . $this->page] < $this->GetY()) {
                    $tmpheight[$row . '-' . $this->page] = $this->GetY();
                }
                if ($this->page > $maxpage)
                    $maxpage = $this->page;
            }

            // get the height we were in the last used page
            $h = $tmpheight[$row . '-' . $maxpage];
            // set the "pointer" to the left margin
            $l = $this->lMargin;
            // set the $currpage to the last page
            $currpage = $maxpage;
        }
        // draw the borders
        // we start adding a horizontal line on the last page
        $this->page = $maxpage;
        $this->Line($l, $h, $fullwidth + $l, $h);
        // now we start at the top of the document and walk down
        for ($i = $startpage; $i <= $maxpage; $i++) {
            $this->page = $i;
            $l = $this->lMargin;
            $t  = ($i == $startpage) ? $startheight : $this->tMargin;
            $lh = ($i == $maxpage)   ? $h : $this->h - $this->bMargin;
            $this->Line($l, $t, $l, $lh);
            foreach ($this->tablewidths as $width) {
                $l += $width;
                $this->Line($l, $t, $l, $lh);
            }
        }
        // set it to the last page, if not it'll cause some problems
        $this->page = $maxpage;
    }
}
