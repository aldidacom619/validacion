
<?php

class Adminvalidadores extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->_is_logued_in();
        $this->load->model('usuarios_model');
        $this->load->model('entidades_model');
        $this->load->model('reportes_model');
        $this->load->model('users_universo');
        $this->load->model('model');
        $this->load->model('adminusuario_model');
        $this->load->model('adminusersuniverso_model');
        $this->load->model('adminentidades_model');
        $this->load->model('adminfuncionario_model');
        $this->load->helper('validacion_helper');
        $this->load->helper('fechas_helper');
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
        $data["get"] = $this->adminusuario_model->get();
        $this->load->view("layout/cabecera", $this->usuario);
        $this->load->view("adminvalidadores/index", $data);
        $this->load->view("layout/pie");
    }

    public function validadores() {
        $this->load->view("layout/cabecera", $this->usuario);
        $data['datos'] = $this->usuarios_model->usuarios();
        $data['get'] = $this->users_universo->listaValidadores(getCurrentYear());
        $this->load->view("administrador/validadores", $data);
        $this->load->view("layout/pie");
    }

    public function refrescarListaValidador() {
//        $this->load->view("layout/cabecera",$this->usuario);
        $data['datos'] = $this->usuarios_model->usuarios();
        $data['get'] = $this->users_universo->listaValidadores(getCurrentYear());
        $this->load->view("administrador/validadores", $data);
//        $this->load->view("layout/pie");
    }

    public function activoValidador() {
        $this->adminusuario_model->activo($this->input->post('id'));
    }

    public function adminValidador() {
        $this->adminusuario_model->admin($this->input->post('id'));
    }

    public function entidades($id) {
        $data['get'] = $this->model->lista('a.id iduu,*', 'nueva_validacion.users_universo a', 'INNER JOIN nueva_validacion.entidades_nbienes_nvalidados_ndocumentos b ON a.identidad=b.id', 'AND a.idusuario=' . $id);
        $data["validador"] = $this->adminusuario_model->getValidador($id);
        $data['idvalidador'] = $id;
        $totales = $this->model->fila('SUM(totalbienes) tbien, SUM(bienesvalidados) tval,SUM(totaldocumentos) tdoc', 'nueva_validacion.users_universo a', 'INNER JOIN nueva_validacion.entidades_nbienes_nvalidados_ndocumentos b ON a.identidad=b.id', 'AND idusuario=' . $id . '
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
                $data['fecha_asignacion'] = date('d-m-Y');
                $data['gestion'] = GESTION;
                $data['asignado'] = true;
                $data['estadoentidad'] = 1;

                $this->adminentidades_model->registrar($data);
                echo "<script>alert('Se registro correctamente.');</script>";
                redirect(base_url('adminvalidadores/entidades/' . $idvalidador), 'refresh');
            } else {
                echo "<script>alert('Esta entidad ya se registro.');</script>";
                redirect(base_url('adminvalidadores/entidades/' . $idvalidador), 'refresh');
            }
        }
    }

    public function asignadoestadoValidador() {
        $this->adminusuario_model->asignadoestado($this->input->post('id'));
    }

    public function getdocumentosEntidades() {
        $html = '';
        $documentos = $this->entidades_model->entidadrubro($this->input->post('id'));
        foreach ($documentos as $documento) {
            $html .= '<tr>';
            $html .= '<td>' . $documento->rubro . '</td>';
            $html .= '<td>' . $documento->documentos . '</td>';
        }
        echo $html;
    }

}
