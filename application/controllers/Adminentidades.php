<?php

class Adminentidades extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->_is_logued_in();
        $this->load->model('usuarios_model');
        $this->load->model('entidades_model');
        $this->load->model('reportes_model');

        $this->load->model('adminusuario_model');
        $this->load->model('adminusersuniverso_model');
        $this->load->model('adminentidades_model');
        $this->load->model('adminclase_model');
        $this->load->model('entidades_model');
        $this->load->model('adminusuario_model');
        $this->load->model('model');

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
        $data["get"] = $this->adminentidades_model->getAll();
        $this->load->view("layout/cabecera", $this->usuario);
        $this->load->view("adminentidades/index", $data);
        $this->load->view("layout/pie");
    }

    public function entidades($id) {
        $data['get'] = $this->model->lista('a.id iduu,*'
                , 'nueva_validacion.users_universo a'
                , 'INNER JOIN nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di b ON a.identidad=b.id'
                , 'AND a.idusuario=' . $id . ' AND a.asignado=true');

        $data['entidades'] = $this->model->lista('a.id identidad, a.nombre entidad,c.id_funcionario idvalidador, c.nombre validador,b.asignado asignado'
                , 'nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di a'
                , 'LEFT JOIN nueva_validacion.users_universo b ON a.id=b.identidad AND b.asignado=true
                    LEFT JOIN nueva_validacion.usuario c ON b.idusuario=c.id_funcionario'
                , '');
        $data["validador"] = $this->adminusuario_model->getValidador($id);
        $data['idvalidador'] = $id;
        $totales = $this->model->fila('SUM(totalbienes) tbien, SUM(bienesvalidados) tval,SUM(totaldocumentos) tdoc'
                , 'nueva_validacion.users_universo a'
                , 'INNER JOIN nueva_validacion.entidades_nbienes_nvalidados_ndocumentos_di b ON a.identidad=b.id'
                , 'AND idusuario=' . $id . '
                    AND a.asignado=true
                    GROUP BY idusuario');
        if ($totales) {
            if ($totales->tbien == 0) {
                $data['porcentajeval'] = 0;
            } else {
                if ($totales->tval == 0) {
                    $data['porcentajeval'] = 0;
                } else {
                    $data['porcentajeval'] = round($totales->tval * 100 / $totales->tbien, 2);
                }
            }
        } else {
            $data['porcentajeval'] = 0;
        }
        $data['totales'] = $totales;
        $this->load->view("layout/cabecera", $this->usuario);
        $this->load->view("adminvalidadores/entidades", $data);
        $this->load->view("layout/pie");
    }


    public function activarentidaduniverso() {

        $this->adminentidades_model->activarentidades($this->input->post('id'));
    }

    public function autocompletar() {
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $abuscar = $this->security->xss_clean($this->input->post('term'));
            $search = $this->adminentidades_model->buscador($abuscar);
            if ($search !== FALSE) {
                foreach ($search as $fila) {
                    if ($fila->validador) {
                        $row_set[] = $fila;
                    } else {
                        $row_set[] = $fila;
                    }
                }
            } else {
                $row_set[] = ['entidad' => ''];
            }
            echo json_encode($row_set);
        }
    }

    public function asignarentidad() {
        if ($this->input->post()) {
            $identidad = $this->input->post('identidad');
            $idvalidador = $this->input->post('idvalidador');
            $search = $this->model->fila('*'
                    , 'nueva_validacion.users_universo'
                    , ''
                    , 'AND identidad=' . $identidad . ' AND asignado=true');

            if (!$search) {
                $data['idusuario'] = $idvalidador;
                $data['identidad'] = $identidad;
                $data['fecha_asignacion'] = date('d-m-Y h:i:s');
                $data['gestion'] = GESTION;
                $data['asignado'] = true;
                $data['estadoentidad'] = 0;

                $this->adminentidades_model->registrar($data);
                echo "<script>alert('Se registro correctamente.');</script>";
                redirect(base_url('adminentidades/entidades/' . $idvalidador), 'refresh');
            } else {
                echo "<script>alert('Esta entidad ya se registro.');</script>";
                redirect(base_url('adminentidades/entidades/' . $idvalidador), 'refresh');
            }
        }
    }

    public function asignadoestadoValidador() {
        $this->adminusuario_model->asignadoestado($this->input->post('id')); 
    }

    public function getdocumentosEntidades() {
        $html = '';
        $total1 = 0;
        $total2 = 0;
        $documentos = $this->entidades_model->entidadrubro($this->input->post('id'));
        foreach ($documentos as $documento) {
            $html .= '<tr>';
            $html .= '<td>' . $documento->rubro . '</td>';
            $html .= '<td>' . $documento->bien . '</td>';
            $html .= '<td>' . $documento->validado . '</td>';
            $html .= '</tr>';
            $total1 = $total1 + $documento->bien;
            $total2 = $total2 + $documento->validado;
        }
        $html .= '<tr>';
            $html .= '<th>TOTALES</th>';
            $html .= '<td>' . $total1 . '</td>';
            $html .= '<td>' . $total2 . '</td>';
            $html .= '</tr>';
        echo $html;
    }

}
 