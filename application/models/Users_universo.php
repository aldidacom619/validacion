<?php

/**
 * Created by PhpStorm.
 * User: framos
 * Date: 3/8/2017
 * Time: 11:28 AM
 */
class Users_universo extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    //obtenemos las entradas de todos o un usuario, dependiendo
    // si le pasamos le id como argument o no
    public function users_entrys($id = false)
    {
        if($id === false)
        {
            $this->db->select('u.username,u.fname,u.lname,u.register_date,e.titulo,e.entrada,e.publish_date');
            $this->db->from('users u');
            $this->db->join('entradas e', 'u.id = e.id_user');
        }else{
            $this->db->select('u.username,u.fname,u.lname,u.register_date,e.titulo,e.entrada,e.publish_date');
            $this->db->from('users u');
            $this->db->join('entradas e', 'u.id = e.id_user');
            $this->db->where('u.id',$id);
        }
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    //obtenemos todos los comentarios de un usuario y sus datos si le pasamos
    //un id como argumento, y si no los cogemos todos
    public function users_coments($id = false)
    {
        if($id === false)
        {
            $this->db->select('u.username,c.titulo_comentario,c.comentario,c.comment_date');
            $this->db->from('comentarios c');
            $this->db->join('users u', 'c.id_user = u.id');
        }else{
            $this->db->select('u.username,c.titulo_comentario,c.comentario,c.comment_date');
            $this->db->from('comentarios c');
            $this->db->join('users u', 'c.id_user = u.id');
            $this->db->where('u.id',$id);
        }
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function consulta_encadendada($id)
    {
        $this->db->select('username')->from('users')->where('id >=', $id)->limit(0, 10);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function search_users($string,$pos_comodin)
    {
        $this->db->like('username', $string, $pos_comodin);
        $query = $this->db->get('users');
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    //contamos todos los resultados de la tabla
    //que pasemos como argumento
    public function count_results($table)
    {
        return $this->db->count_all_results($table);
    }

    //obtenemos un usuario dependiendo del id que le pasemos
    public function consulta_get_where($id)
    {
        $query = $this->db->get_where('users',array('id' => $id));
        if($query->num_rows() > 0 )
        {
            //veamos que sólo retornamos una fila con row(), no result()
            return $query->row();
        }
    }

    //insertamos un nuevo usuario en la tabla users
    public function insert_user()
    {
        $data = array(
            'username'       =>   'Juan68',
            'fname'          =>   'Juan',
            'lname'          =>   'Pérez',
            'register_date'  =>    '2013-01-19 10:00:00'
        );
        $this->db->insert('users',$data);
    }

    //eliminamos al usuario con id = 1
    public function delete_user()
    {
        $this->db->delete('users', array('id' => 1));
    }

    //actualizamos los datos del usuario con id = 3
    public function update_user()
    {
        $data = array(
            'username' => 'silvia',
            'fname' => 'madrejo',
            'lname' => 'sánchez'
        );
        $this->db->where('id', 3);
        $this->db->update('users', $data);
    }
    public function listaValidadores($year){
//        $this->db->select('us.id,us.id_funcionario,us.nombre,us.usuario,us.email,us.sigla,us.activo,us.administrador,lv.asignado
//        ,count(DISTINCT b.identidad) totalEntidades,count(DISTINCT b.id) totalBienes,count(DISTINCT bi.id) totalDocumentos');
//        $this->db->from('nueva_validacion.usuario us');
//        $this->db->join('nueva_validacion.users_universo lv', 'us.id_funcionario = lv.idusuario','left');
//        $this->db->join('nueva_validacion.bien b', 'b.identidad = lv.identidad and b.idgestion = '.$year, 'left');
//        $this->db->join('nueva_validacion.bitacora bi', 'bi.identidad = b.identidad', 'left');
//        $this->db->group_by('us.id,us.id_funcionario,us.nombre,us.usuario,us.email,us.sigla,us.activo,us.administrador,lv.asignado');
//        $this->db->order_by('us.id','DESC');
//        select * from
//nueva_validacion.ztotalbienes_documento_validador_di

        $this->db->select('*');
        $this->db->from('nueva_validacion.ztotalbienes_documento_validador_di');
        $query = $this->db->get();
        return $query->result();
    }

}