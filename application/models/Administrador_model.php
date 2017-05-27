<?php

class Administrador_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }


  public function buscar_operador($operador='')
{
  $this->db->select('*');
  $this->db->like('usuario',$operador);
  $this->db->where('tipo_usuario',1);
  $query = $this->db->get('usuarios');
  return $query->result_array();
}

  public function registrar_operador($operador='')
  {
    if($this->db->insert('usuarios',$operador))
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }
  }



  public function extraer_operador()
  {

    $this->db->select('*');
    $this->db->where('tipo_usuario',1);
    $query = $this->db->get('usuarios');
    return $query->result_array();
  }

  public function editar_datos_operador($id='',$campo='',$nuevovalor='')
  {
    $this->db->where('idusuario',$id);
    if($this->db->update('usuarios',array($campo=>$nuevovalor)))
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }
  }

  public function cambiar_clave($id='',$clave='',$tipoUsuario='',$nclave='')
  {
    $this->db->where('id',$id);
    $this->db->where('clave',$clave);
    $this->db->where('tipo_usuario',$tipoUsuario);
    if($this->db->update('usuarios',array('clave'=>$nclave)))
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }

  }

  public function extraer_areas()
  {
    $query = $this->db->get('area_solicitante');

    return $query->result_array();
  }

  public function extraer_areas_id($id='')
  {
    $this->db->select('nombre_area');
    $this->db->where('idarea',$id);
    $query = $this->db->get('area_solicitante');
    return $query->result_array();

  }

  public function buscar_solicitud_licitaciones_solicitud($solicitud='')
  {
    $this->db->select('solicitud_pedido');
    $this->db->like('solicitud_pedido',$solicitud);
    $query = $this->db->get('licitaciones');
    return $query->result_array();
  }

  public function bus_sol_licitaciones($solicitud='')
  {
    $this->db->select('l.idlicitaciones,l.fecha_recibido,l.solicitud_pedido,l.descripcion,l.observacion,l.estado,l.fecha_terminado,l.duracion,a.nombre_area');
    $this->db->where('l.solicitud_pedido',$solicitud);
    $this->db->from('licitaciones as l');
    $this->db->join('area_solicitante as a','a.idarea = l.area_solicitante_idarea');
    $query = $this->db->get();

    return $query->result_array();
    
  }

  public function registrar_licitaciones($registro='')
  {
    if($this->db->insert('licitaciones',$registro))
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }
    
  }

  public function registrar_area_solicitante($nombre_area='')
  {
    if($this->db->insert('area_solicitante',array('nombre_area'=>$nombre_area)))
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }
  }

  public function editar_dato_nombre_area($nombre='',$idarea='')
  {
    $campo='nombre_area';
    $this->db->where('idarea',$idarea);
    if($this->db->update('area_solicitante',array($campo=>$nombre)))
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }
  }


  public function extraer_todas_licitaciones($fecha_desde='',$fecha_hasta='',$estado='',$estado_licitaciones='')
  {
    if($estado_licitaciones=='todos'){
    $this->db->select('l.idlicitaciones,l.fecha_recibido,l.solicitud_pedido,l.descripcion,l.observacion,l.estado,l.fecha_terminado,l.duracion,a.nombre_area');
    $this->db->where('l.fecha_recibido >=',$fecha_desde);
    $this->db->where('l.fecha_recibido <=',$fecha_hasta);
    $this->db->from('licitaciones as l');
    $this->db->join('area_solicitante as a','a.idarea = l.area_solicitante_idarea');
    $query = $this->db->get();
    }
    else
    {
    $this->db->select('l.idlicitaciones,l.fecha_recibido,l.solicitud_pedido,l.descripcion,l.observacion,l.estado,l.fecha_terminado,l.duracion,a.nombre_area');
    $this->db->where('l.fecha_recibido >=',$fecha_desde);
    $this->db->where('l.fecha_recibido <=',$fecha_hasta);
    $this->db->where('l.estado',$estado);
    $this->db->from('licitaciones as l');
    $this->db->join('area_solicitante as a','a.idarea = l.area_solicitante_idarea');
    $query = $this->db->get();

    }

    return $query->result_array();
  }


  public function extraer_todas_licitaciones_areas($fecha_desde='',$fecha_hasta='',$estado='',$estado_licitaciones='',$areas='')
  {

    if($estado_licitaciones=='todos'){
    $this->db->select('l.idlicitaciones,l.fecha_recibido,l.solicitud_pedido,l.descripcion,l.observacion,l.estado,l.fecha_terminado,l.duracion,a.nombre_area');
    $this->db->where('l.fecha_recibido >=',$fecha_desde);
    $this->db->where('l.fecha_recibido <=',$fecha_hasta);
    $this->db->where('l.area_solicitante_idarea',$areas);
    $this->db->from('licitaciones as l');
    $this->db->join('area_solicitante as a','a.idarea = l.area_solicitante_idarea');
    $query = $this->db->get();
    }
    else
    {
    $this->db->select('l.idlicitaciones,l.fecha_recibido,l.solicitud_pedido,l.descripcion,l.observacion,l.estado,l.fecha_terminado,l.duracion,a.nombre_area');
    $this->db->where('l.fecha_recibido >=',$fecha_desde);
    $this->db->where('l.fecha_recibido <=',$fecha_hasta);
    $this->db->where('l.area_solicitante_idarea',$areas);
    $this->db->where('l.estado',$estado);
    $this->db->from('licitaciones as l');
    $this->db->join('area_solicitante as a','a.idarea = l.area_solicitante_idarea');
    $query = $this->db->get();

    }

    return $query->result_array();

  }

  public function editar_datos_licitaciones($id='',$campo='',$nuevovalor='')
  {

    $this->db->where('idlicitaciones',$id);
    if($this->db->update('licitaciones',array($campo=>$nuevovalor)))
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }

  }

/*
  public function procesar_solicitud_pendiente($id='',$fecha_respuesta='')
  {
    $this->db->where('idsolicitud',$id);
    if($this->db->update('solicitudes',array('fecha_respuesta'=>$fecha_respuesta,'estado_solicitud'=>1)))
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }

  }

public function extraer_solicitudes_pendiente()
{
	$this->db->select('u.idusuario,u.nombre,u.apellido,u.usuario,u.cargo,s.idsolicitud,s.motivo,s.fecha_solicitud,s.descripcion,g.gerencia,c.coordinacion');
	$this->db->where('u.tipo_usuario',1);
	$this->db->where('s.estado_solicitud',0);
	$this->db->from('usuarios as u');
	$this->db->join('solicitudes as s', 's.usuarios_idusuario = u.idusuario');
  $this->db->join('gerencias_departamentos as g', 'g.idgerencia = u.gerencias_departamentos_idgerencia');
  $this->db->join('coordinaciones as c','c.idcoordinacion= u.coordinaciones_idcoordinacion');
	$query = $this->db->get();
	return $query->result_array();
}

public function extraer_solicitud_reportes_todas($fecha_desde='',$fecha_hasta='')
{
      $this->db->select('u.nombre,u.apellido,u.cargo,s.fecha_solicitud,s.fecha_respuesta,s.motivo,s.via_solicitud,g.gerencia,c.coordinacion');
      $this->db->where('s.fecha_solicitud >=',$fecha_desde);
      $this->db->where('s.fecha_solicitud <=',$fecha_hasta);
      $this->db->order_by('s.fecha_solicitud','ASC');
      $this->db->from('usuarios as u');
      $this->db->join('solicitudes as s','s.usuarios_idusuario = u.idusuario');
      $this->db->join('gerencias_departamentos as g','g.idgerencia = u.gerencias_departamentos_idgerencia');
      $this->db->join('coordinaciones as c','c.idcoordinacion = u.coordinaciones_idcoordinacion');
      //$this->db->join('encuestas','encuestas.solicitudes_idsolicitud = solicitudes.idsolicitud');
      $query = $this->db->get();
      return $query->result_array();

}

public function extraer_solicitud_reportes_gerencias($gerencias='',$fecha_desde='',$fecha_hasta='')
{
  $this->db->select('u.nombre,u.apellido,u.cargo,s.fecha_solicitud,s.fecha_respuesta,s.motivo,s.via_solicitud,g.gerencia,c.coordinacion');
  $this->db->where('g.idgerencia',$gerencias);
  $this->db->where('s.fecha_solicitud >=',$fecha_desde);
  $this->db->where('s.fecha_solicitud <=',$fecha_hasta);
  $this->db->order_by('s.fecha_solicitud','ASC');
  $this->db->from('usuarios as u');
  $this->db->join('solicitudes as s','s.usuarios_idusuario = u.idusuario');
  $this->db->join('gerencias_departamentos as g','g.idgerencia = u.gerencias_departamentos_idgerencia');
  $this->db->join('coordinaciones as c','c.idcoordinacion = u.coordinaciones_idcoordinacion');
  $query = $this->db->get();
  return $query->result_array();
}


public function extraer_encuesta_todas($fecha_desde='',$fecha_hasta='')
{
  $this->db->select('u.nombre,u.apellido,u.cargo,s.fecha_solicitud,s.fecha_respuesta,s.motivo,g.gerencia,c.coordinacion,e.r1,e.r2,e.r3,e.r4,e.fecha_encuesta,e.observacion,e.calificacion');
  $this->db->where('e.fecha_encuesta >=',$fecha_desde);
  $this->db->where('e.fecha_encuesta <=',$fecha_hasta);
  $this->db->order_by('s.fecha_solicitud','ASC');
  $this->db->from('usuarios as u');
  $this->db->join('solicitudes as s','s.usuarios_idusuario = u.idusuario');
  $this->db->join('gerencias_departamentos as g','g.idgerencia = u.gerencias_departamentos_idgerencia');
  $this->db->join('coordinaciones as c','c.idcoordinacion = u.coordinaciones_idcoordinacion');
  $this->db->join('encuestas as e','e.solicitudes_idsolicitud = s.idsolicitud');
  $query = $this->db->get();
  return $query->result_array();
}

public function encuestas_porcentajes($fecha_desde,$fecha_hasta)
{
  $query = $this->db->query("SELECT encuestas.calificacion , COUNT( encuestas.idencuesta ) AS cantidad FROM encuestas where encuestas.fecha_encuesta between '$fecha_desde' and '$fecha_hasta' GROUP BY encuestas.calificacion ORDER BY encuestas.calificacion;");
  return $query->result_array();
}

public function extraer_encuesta_pendiente_todas($fecha_desde='',$fecha_hasta='')
{
  $this->db->select('u.nombre,u.apellido,u.cargo,s.fecha_solicitud,s.fecha_respuesta,s.motivo,g.gerencia,c.coordinacion');
  $this->db->where('s.estado_encuesta',0);
  $this->db->where('s.fecha_solicitud >=',$fecha_desde);
  $this->db->where('s.fecha_solicitud <=',$fecha_hasta);
  $this->db->order_by('s.fecha_solicitud','ASC');
  $this->db->from('usuarios as u');
  $this->db->join('solicitudes as s','s.usuarios_idusuario = u.idusuario');
  $this->db->join('gerencias_departamentos as g','g.idgerencia = u.gerencias_departamentos_idgerencia');
  $this->db->join('coordinaciones as c','c.idcoordinacion = u.coordinaciones_idcoordinacion');
  //$this->db->join('encuestas as e','e.solicitudes_idsolicitud = s.idsolicitud');
  $query = $this->db->get();
  return $query->result_array();
}



*/


}




 ?>
