<?php
/*
*/

class Usuarios_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->sicenad = $this->load->database('db_sicenad', TRUE);
	}

	function loguear($username, $password)
	{//hostaddr=192.168.15.100 password=js3QmA9vZ7edF2X
		/*$query = $this->db->query("  
            
            select sub.nombre,sub.apellidopat,apellidomat,sub.usuario,sub.pass,sub.idfuncionario,usu.usuario,usu.corto,usu.administrador from 
            dblink('dbname=sicenad14 hostaddr=192.168.15.100 user=postgres password=js3QmA9vZ7edF2X port=5432',
            'select nombres,paterno,materno,usu_usuario,usu_contrasena,usu_funcionario, estado from seguridad.usuarios seg 
            inner join personal.funcionarios fun on usu_funcionario = idfunc') as 
            sub(nombre varchar(120), apellidopat varchar(100),apellidomat varchar(100),usuario varchar(50), pass varchar(80),idfuncionario integer, estado integer)
            inner join nueva_validacion.usuario usu on usu.id_funcionario = sub.idfuncionario 
          
            where sub.usuario ilike '".$username."' and sub.pass ilike '".$password."' and sub.estado=1");//*/
		/*$query = $this->db->query("  
            
            select sub.nombre,sub.apellidopat,apellidomat,sub.usuario,sub.pass,sub.idfuncionario,usu.usuario,usu.corto,usu.administrador from 
            dblink('dbname=sicenad14 hostaddr=127.0.0.1 user=postgres password=1982',
            'select nombres,paterno,materno,usu_usuario,usu_contrasena,usu_funcionario from seguridad.usuarios seg 
            inner join personal.funcionarios fun on usu_funcionario = idfunc') as 
            sub(nombre varchar(120), apellidopat varchar(100),apellidomat varchar(100),usuario varchar(50), pass varchar(80),idfuncionario integer)
            inner join nueva_validacion.usuario usu on usu.id_funcionario = sub.idfuncionario
          
            where sub.usuario ilike '".$username."' and sub.pass ilike '".$password."'");//*/
      
       //return $query->result();

             $query = $this->sicenad->query("select f.idfunc, 
                                             f.nombres,                                              
                                             f.paterno,
                                             f.materno, 
                                             u.usu_usuario 
                                        from seguridad.usuarios u, 
                                             personal.funcionarios f  
                                       where u.usu_funcionario = f.idfunc 
                                         and usu_usuario ='".$username."' 
                                         and usu_contrasena = '".$password."'");
      $funcionario = $query->result();
      if($funcionario)
      {        
         $query = $this->db->query("select u.administrador
                                      from nueva_validacion.usuario u
                                     where u.id_funcionario = ".$funcionario[0]->idfunc."
                                       and u.activo = true");
         $usuario = $query->result();
         if($usuario)
         {
            $datos = array(                
                    'nombre' => $funcionario[0]->nombres,
                    'apellidopat' => $funcionario[0]->paterno,
                    'apellidomat' =>$funcionario[0]->materno ,                                
                    'idfuncionario' => $funcionario[0]->idfunc,
                    'usuario' => $funcionario[0]->usu_usuario,                    
                    'administrador' => $usuario[0]->administrador
                    );
            return $datos;
         }
         else
         {
            return false;
         }          
      }
      else
      {
        return false;
      }
		
	}
    public function usuarios(){
//        $this->db->distinct("us.nombre");
//        $this->db->select("us.id,us.nombre,us.activo,us.administrador,
//            case when uu.idusuario is not null then 't' else 'f' end");
//        $this->db->from("nueva_validacion.usuario us");
//        $this->db->join("nueva_validacion.users_universo uu","us.id = uu.idusuario","left");
//        $this->db->order_by("us.nombre","ASC");
//        $query = $this->db->get();
//        return $query->result();
        $query = $this->db->query("select sub.nombre,sub.usuario,sub.idfuncionario from
dblink('dbname=sicenad14 hostaddr=192.168.15.100 user =postgres password=js3QmA9vZ7edF2X port=5432',
'select nombres||'' ''||paterno||'' ''||materno nombre,
usu_usuario,usu_funcionario 
from seguridad.usuarios seg
inner join personal.funcionarios fun on usu_funcionario = idfunc
where fun.id_estructura in (12,13,4)and fun.estado = 1') as
sub(nombre varchar(100),usuario varchar(50), idfuncionario integer)
--inner join nueva_validacion.usuario usu on usu.id_funcionario = sub.idfuncionario
where sub.idfuncionario not in(select id_funcionario from nueva_validacion.usuario )
 order by sub.nombre asc
");
       return $query->result();
    }
    public function addUsuario($datos){
        $this->db->insert('nueva_validacion.usuario',$datos);
        return $this->db->insert_id();
    }
    public function getUsuario($idUsuario,$year){
        $this->db->select('us.id,us.nombre,us.usuario,us.email,us.sigla,us.activo,us.administrador,lv.asignado
        ,count(DISTINCT lv.identidad) totalEntidades,count(b.id) totalBienes,count(db.id) totalDocumentos');
        $this->db->from('nueva_validacion.usuario us');
        $this->db->join('nueva_validacion.users_universo lv', 'us.id_funcionario = lv.idusuario and lv.gestion = '.$year,'left');
        $this->db->join('dj_activos.bien b', 'b.identidad = lv.identidad', 'left');
        $this->db->join('dj_activos.documento_bien db', 'db.idbien = b.id', 'left');
        $this->db->where('us.id',$idUsuario);
        $this->db->group_by('us.id,us.nombre,us.usuario,us.email,us.sigla,us.activo,us.administrador,lv.asignado');
//        $this->db->order_by('','ASC');
        $query = $this->db->get();
        return $query->result();

    }
}
?>