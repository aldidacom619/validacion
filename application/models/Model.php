<?php
/**
 * autor: William Ramos
 * Modelo generico para interaccion con la base de datos
 */
class Model extends CI_Model 
{
    function __construct() 
    {
        parent::__construct();
//        $this->load->database();
//        $this->load->dbutil();
    }
    /* Metodo listar
     * Lista los datos de una tabla de la base de datos 
     * @table nombre de la tabla
     * @strAtributos columnas
     * @strInner relaciones con otras tablas
     * @strConsulta condiciones
     * @return retorna array de los datos
    */
    function lista($strAtributos, $tabla, $strInner, $strConsulta) {
        $query = $this->db->query("select " . $strAtributos . " from " . $tabla . " " . $strInner . " where 1=1 " . $strConsulta);
        return $query->result();
    }
    /* Metodo fila
     * Lista una fila de una tabla de la base de datos 
     * @table nombre de la tabla
     * @strAtributos columnas
     * @strInner relaciones con otras tablas
     * @strConsulta condiciones
     * @return retorna objeto de los datos
    */
    function fila($strAtributos, $tabla, $strInner, $strConsulta){
        $query = $this->db->query("select " . $strAtributos . " from " . $tabla . " " . $strInner . " where 1=1 " . $strConsulta);
        return $query->row();
    }	
    /* Metodo registrarActivos
     * Registra una fila en una tabla de la base de datos 
     * @table nombre de la tabla
     * @data datos a insertar
    */
    function registrar($tabla, $data) {
        $this->db->insert($tabla, $data);
    }
    /* Metodo actualizarActivos
     * Actualiza una fila en una tabla de la base de datos 
     * @table nombre de la tabla
     * @strid nombre id de la fila a modificar
     * @id valor de id a modificar
     * @data datos a modificar
    */
    function actualizar($tabla, $strId, $id, $data) {
        $this->db->where($strId, $id);
        $this->db->update($tabla, $data);
    }    
    /* Metodo eliminarActivos
     * elimina una fila de una tabla de la base de datos 
     * @table nombre de la tabla
     * @strid nombre id de la fila a modificar
     * @id valor de id a modificar
    */
    function eliminar($tabla, $strId, $id) {
        $this->db->where($strId, $id);
        return $this->db->delete($tabla);
    }
}
?>