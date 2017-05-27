<?php

class Validar_Usuarios extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
   $this->load->database();
  }


  public function validar_usuario($usuario='', $clave='')
  {
    $this->db->select('*');
    $this->db->where('usuario',$usuario);
    $this->db->where('clave',$clave);
    $query = $this->db->get('usuarios');
    return $query->row_array();
  }


  public function registra_fecha_session($fecha_sesion='')
  {
    $this->db->insert('sesiones',$fecha_sesion);
  }

  public function extraer_fecha_sesion($id='')
  {
    $this->db->select('fecha,hora');
    $this->db->where('usuarios_id',$id);
    $this->db->order_by('fecha,hora','desc');
    $this->db->limit(1);
    $query = $this->db->get('sesiones');
    return $query->result_array();

  }

}

 ?>
