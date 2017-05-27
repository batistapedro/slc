<?php

class SalirSesion extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Validar_Usuarios');
  }

  public function index()
  {
    $fecha_sesion = array(
              'idsesion'=>'',
							'usuarios_id'=>$this->session->userdata('id'),
							'fecha'=>date('Y-m-d'),
							'hora'=>date('G:ia')
						);

		$this->Validar_Usuarios->registra_fecha_session($fecha_sesion);


    $this->session->sess_destroy();
    redirect(base_url('Inicio'));
  }
}


 ?>
