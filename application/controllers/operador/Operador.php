<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operador extends CI_Controller
{


	 public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form','security'));
    $this->load->library('form_validation');
	$this->load->model('Validar_Usuarios');

  }

  public function index()
  {
	if($this->session->userdata('tipo_usuario')=='1')
    {
		$fecha['fecha'] = $this->Validar_Usuarios->extraer_fecha_sesion($this->session->userdata('id'));
		$this->load->view('operador/inicio',$fecha);
    }

  }


	public function form_cambiar_clave()
	{
		if($this->input->is_ajax_request())
		{
			redirect(base_url('ConfigClave'));
		}
		else
		{
			show_404();
		}
	}



}
?>
