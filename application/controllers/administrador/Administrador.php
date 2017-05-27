<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller
{


	 public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form','security','file','download'));
    $this->load->library(array('form_validation','Pdf'));
	$this->load->model(array('Administrador_model','Validar_Usuarios'));

  }

  public function index()
  {
    if($this->session->userdata('tipo_usuario')=='0')
    {
		$fecha['fecha'] = $this->Validar_Usuarios->extraer_fecha_sesion($this->session->userdata('id'));
		$this->load->view('administrador/inicio',$fecha);
    }
  }

	public function form_registrar_operador()
	{
		if($this->session->userdata('tipo_usuario')==0)
		{
			if($this->input->is_ajax_request())
			{
				$this->load->view('administrador/form_registrar_operador');
			}
			else
			{
				show_404();
			}
		}
	}


	public function registrar_operador()
	{
		if($this->session->userdata('tipo_usuario')==0)
		{
			if($this->input->is_ajax_request())
			{
				$this->form_validation->set_rules('nombre','Nombre Usuario','trim|required|min_length[3]|max_length[25]|regex_match[/^[a-zA-zñ-Ñ]+$/]');
				$this->form_validation->set_rules('apellido','Apellido Usuario','trim|required|min_length[3]|max_length[25]|regex_match[/^[a-zA-zñ-Ñ]+$/]');
				$this->form_validation->set_rules('usuario','Usuario','trim|required|min_length[3]|max_length[26]|regex_match[/^[a-zA-zñ-Ñ]+$/]|is_unique[usuarios.usuario]');
				$this->form_validation->set_rules('cedula','Cedula Usuario','trim|required|min_length[7]|max_length[8]|regex_match[/^[0-9]+$/]|is_unique[usuarios.cedula]');

				$this->form_validation->set_message('required','El campo %s es requerido');
				$this->form_validation->set_message('min_length','El campo %s debe ser mayor o igual a %s caracteres');
				$this->form_validation->set_message('max_length','El campo %s debe ser menor o igual a %s caracteres');
				$this->form_validation->set_message('regex_match','Formato no permitido para el campo %s');
				$this->form_validation->set_message('is_unique','Error en el campo %s , ya se encuentra registrado en la base de datos');

				if($this->form_validation->run()===FALSE)
				{
					$mensaje = array(
						'respuesta'=>'error',
						'error_nombre'=>form_error('nombre'),
						'error_apellido'=>form_error('apellido'),
						'error_usuario'=>form_error('usuario'),
						'error_cedula'=>form_error('cedula')
					);
				}
				else
				{
						$operador = array(
							'nombre'=>ucwords(xss_clean($this->input->post('nombre'))),
							'apellido'=>ucwords(xss_clean($this->input->post('apellido'))),
							'cedula'=>xss_clean($this->input->post('cedula')),
							'usuario'=>xss_clean($this->input->post('usuario')),
							'clave'=>do_hash($this->input->post('cedula'),'md5'),
							'estado'=>1,
							'tipo_usuario'=>1
						);

						$dato = $this->Administrador_model->registrar_operador($operador);
						if($dato ==TRUE)
						{
							$mensaje = array(
								'respuesta'=>'exito',
								'exito'=>'Operador Registrado Con Exito'
							);
						}
						else
						{
							$mensaje = array(
								'respuesta'=>'error',
								'error_db'=>'oop ocurrio un error al registrar el operador'
							);
						}

					

				}
				echo json_encode($mensaje);

			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}

	}

	public function editar_dato_operador()
	{
		if($this->session->userdata('tipo_usuario')==0)
		{
			$campo = xss_clean($this->input->post('campo'));
			$id = intval($this->input->post('id'));

			switch ($campo)
			{
				case 'nombre':
						$this->form_validation->set_rules('nuevovalor','Nombre Operador','trim|required|min_length[3]|max_length[15]|regex_match[/^[a-zA-zñ-Ñ]+$/]');

						$this->form_validation->set_message('required','El campo %s es requerido');
						$this->form_validation->set_message('min_length','El campo %s debe ser mayor o igual a %s caracteres');
						$this->form_validation->set_message('max_length','El campo %s debe ser menor o igual a %s caracteres');
						$this->form_validation->set_message('regex_match','Formato no permitido para el campo %s');

						if($this->form_validation->run()==FALSE)
						{
							$mensaje = array(

								'respuesta'=>'error',
								'error'=>form_error('nuevovalor')
							);
						}
						else
						{
							$nuevovalor =ucwords(xss_clean($this->input->post('nuevovalor')));
							$data = $this->Administrador_model->editar_datos_operador($id,$campo,$nuevovalor);
							if($data==TRUE)
							{
								$mensaje = array(

									'respuesta'=>'exito',
									'exito'=>'Dato nombre actualizado con exito'
								);
							}
							else
							{
								$mensaje = array(

									'respuesta'=>'error',
									'error'=>'Error en base datos'
								);
							}
						}
						echo json_encode($mensaje);
				break;

				case 'apellido':
				$this->form_validation->set_rules('nuevovalor','Apellido Operador','trim|required|min_length[3]|max_length[15]|regex_match[/^[a-zA-zñ-Ñ]+$/]');

				$this->form_validation->set_message('required','El campo %s es requerido');
				$this->form_validation->set_message('min_length','El campo %s debe ser mayor o igual a %s caracteres');
				$this->form_validation->set_message('max_length','El campo %s debe ser menor o igual a %s caracteres');
				$this->form_validation->set_message('regex_match','Formato no permitido para el campo %s');

				if($this->form_validation->run()==FALSE)
				{
					$mensaje = array(

						'respuesta'=>'error',
						'error'=>form_error('nuevovalor')
					);
				}
				else
				{
					$nuevovalor =ucwords(xss_clean($this->input->post('nuevovalor')));
					$data = $this->Administrador_model->editar_datos_operador($id,$campo,$nuevovalor);
					if($data==TRUE)
					{
						$mensaje = array(

							'respuesta'=>'exito',
							'exito'=>'Dato apellido actualizado con exito'
						);
					}
					else
					{
						$mensaje = array(

							'respuesta'=>'error',
							'error'=>'Error en base datos'
						);
					}
				}
				echo json_encode($mensaje);
				break;

				case 'cedula':
				$this->form_validation->set_rules('nuevovalor','Cedula','trim|required|min_length[7]|max_length[8]|regex_match[/^[0-9]+$/]|is_unique[usuarios.cedula]');

				$this->form_validation->set_message('required','El campo %s es requerido');
				$this->form_validation->set_message('min_length','El campo %s debe ser mayor o igual a %s caracteres');
				$this->form_validation->set_message('max_length','El campo %s debe ser menor o igual a %s caracteres');
				$this->form_validation->set_message('regex_match','Formato no permitido para el campo %s');
				$this->form_validation->set_message('is_unique','Error en dato %s ya se encuetra registrado en el sistema');

				if($this->form_validation->run()==FALSE)
				{
					$mensaje = array(

						'respuesta'=>'error',
						'error'=>form_error('nuevovalor')
					);
				}
				else
				{
					$nuevovalor =xss_clean($this->input->post('nuevovalor'));
					$data = $this->Administrador_model->editar_datos_operador($id,$campo,$nuevovalor);
					if($data==TRUE)
					{
						$mensaje = array(

							'respuesta'=>'exito',
							'exito'=>'Dato nombre actualizado con exito'
						);
					}
					else
					{
						$mensaje = array(

							'respuesta'=>'error',
							'error'=>'Error en base datos'
						);
					}
				}
				echo json_encode($mensaje);
				break;

				case 'usuario':
				$this->form_validation->set_rules('nuevovalor','Usuario','trim|required|min_length[3]|max_length[15]|regex_match[/^[a-zA-zñ-Ñ]+$/]|is_unique[usuarios.usuario]');

				$this->form_validation->set_message('required','El campo %s es requerido');
				$this->form_validation->set_message('min_length','El campo %s debe ser mayor o igual a %s caracteres');
				$this->form_validation->set_message('max_length','El campo %s debe ser menor o igual a %s caracteres');
				$this->form_validation->set_message('regex_match','Formato no permitido para el campo %s');
				$this->form_validation->set_message('is_unique','Error el dato %s ya esta registrado en el sistema');

				if($this->form_validation->run()==FALSE)
				{
					$mensaje = array(

						'respuesta'=>'error',
						'error'=>form_error('nuevovalor')
					);
				}
				else
				{
					$nuevovalor =xss_clean($this->input->post('nuevovalor'));
					$data = $this->Administrador_model->editar_datos_operador($id,$campo,$nuevovalor);
					if($data==TRUE)
					{
						$mensaje = array(

							'respuesta'=>'exito',
							'exito'=>'Dato nombre actualizado con exito'
						);
					}
					else
					{
						$mensaje = array(

							'respuesta'=>'error',
							'error'=>'Error en base datos'
						);
					}
				}
				echo json_encode($mensaje);
				break;

				case 'clave':
				$this->form_validation->set_rules('nuevovalor','clave Operador','trim|required|min_length[6]|max_length[12]');

				$this->form_validation->set_message('required','El campo %s es requerido');
				$this->form_validation->set_message('min_length','El campo %s debe ser mayor o igual a %s caracteres');
				$this->form_validation->set_message('max_length','El campo %s debe ser menor o igual a %s caracteres');

				if($this->form_validation->run()==FALSE)
				{
					$mensaje = array(

						'respuesta'=>'error',
						'error'=>form_error('nuevovalor')
					);
				}
				else
				{
					$nuevovalor = do_hash(xss_clean($this->input->post('nuevovalor')),'md5');
					$data = $this->Administrador_model->editar_datos_operador($id,$campo,$nuevovalor);
					if($data==TRUE)
					{
						$mensaje = array(
							'respuesta'=>'exito',
							'exito'=>'Dato clave actualizado con exito'
						);
					}
					else
					{
						$mensaje = array(

							'respuesta'=>'error',
							'error'=>'Error en base datos'
						);
					}
				}
				echo json_encode($mensaje);
				break;

			
				case 'estado':
				$this->form_validation->set_rules('nuevovalor','Estado Operador','trim|required|in_list[0,1]');

				$this->form_validation->set_message('required','El campo %s es requerido');
				$this->form_validation->set_message('in_list','El campo %s formato no valido');

				if($this->form_validation->run()==FALSE)
				{
					$mensaje = array(

						'respuesta'=>'error',
						'error'=>form_error('nuevovalor')
					);
				}
				else
				{
					$nuevovalor =xss_clean($this->input->post('nuevovalor'));
					$data = $this->Administrador_model->editar_datos_operador($id,$campo,$nuevovalor);
					if($data==TRUE)
					{
						$mensaje = array(

							'respuesta'=>'exito',
							'exito'=>'Dato estado actualizado con exito'
						);
					}
					else
					{
						$mensaje = array(

							'respuesta'=>'error',
							'error'=>'Error en base datos'
						);
					}
				}
				echo json_encode($mensaje);
			break;


				default:
					# code...
					break;
			}
		}
		else
		{
			show_404();
		}
	}



	public function extraer_operador()
	{
		if($this->session->userdata('tipo_usuario')==0)
		{
			if($this->input->is_ajax_request())
			{
				$operador['operador'] = $this->Administrador_model->extraer_operador();
				$operador['cantida_operador'] = count($operador['operador']);
				$this->load->view('administrador/ver_operador',$operador);
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
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

	

	

	public function respaldar_bd()
 {
	 if($this->session->userdata('tipo_usuario')=='0')
		{
		$this->load->dbutil();
			$backup = $this->dbutil->backup();

			write_file('./respaldo_DB/SLC'.date('d-m-Y').' .gz', $backup);

			force_download('SLC'.date('d-m-Y').' .gz', $backup);


		}else
		{
			show_404();
		}
 }

 public function buscarOperador()
 {
	 if($this->input->is_ajax_request())
	 {
		 $this->form_validation->set_rules('buscarOperador','Buscar Usuario','trim|regex_match[/^[a-zA-Zñ-Ñ]+$/]');

		 $this->form_validation->set_message('regex_match','Error en el campo %s solo se permiten letras');

		 if($this->form_validation->run()===FALSE)
		 {
			 $mensaje = array(
				 'respuesta'=>'error',
				 'error'=>form_error('buscarOperador')
			 );
		 }
		 else
		 {
			  $operador = $this->input->post('buscarOperador');
				$respuesta = $this->Administrador_model->buscar_operador($operador);
				if(count($respuesta)>=1)
				{

					$mensaje = array(
						'respuesta'=>'exito',
						'operador'=>$respuesta
					);

				}
				else
				{
					$mensaje = array(
						'respuesta'=>'error',
						'error_operador'=>'usuario no encontrado'
					);
				}
		 }

		 echo json_encode($mensaje);

	 }
	 else
	 {
		 show_404();
	 }
 }

 public function form_resgistrar_area_solicitante()
 {
	 if($this->input->is_ajax_request())
	 {
		$this->load->view('administrador/form_registrar_area_solicitante');
	 }
	 else
	 {
		 show_404();
	 }
 }

 public function form_registrar_licitaciones()
 {
	 if($this->input->is_ajax_request())
	 {
		 $areas['areas'] = $this->Administrador_model->extraer_areas();
		$this->load->view('administrador/form_registrar_licitaciones',$areas);
	 }
	 else
	 {
		 show_404();
	 }
	 
 }

 public function registrar_licitaciones()
 {
	 if($this->input->is_ajax_request())
	 {
		 $this->form_validation->set_rules('fecha_recibido','Fecha Recibido','trim|required|regex_match[/^[0-9]{4}[\/]{1}[0-9]{2}[\/]{1}[0-9]{2}+$/]');
		 $this->form_validation->set_rules('solicitud_pedido','Solicitud Pedido','trim|required|is_natural_no_zero|is_unique[licitaciones.solicitud_pedido]|min_length[3]|max_length[12]');
		 $this->form_validation->set_rules('area_solicitante','Area Solicitante','trim|required');
		 $this->form_validation->set_rules('descripcion_licitaciones','Descripcion','trim');
		 $this->form_validation->set_rules('observacion_licitaciones','Observacion','trim');
		 $this->form_validation->set_rules('estado_licitaciones','Estado Licitaciones','trim|required|in_list[0,1]');

		 $this->form_validation->set_message('required','El dato %s es requerido');
		 $this->form_validation->set_message('in_list','El dato %s no es valido');
		 $this->form_validation->set_message('regex_match','Error en dato %s formato no valido');
		 $this->form_validation->set_message('is_natural_no_zero','Error en dato %s formato no permitido');
		 $this->form_validation->set_message('is_unique','Error el dato %s ya esta registrado en el sistema');
		 $this->form_validation->set_message('min_length','Error el dato %s, debe ser mayor o igual a %s caracteres');
		 $this->form_validation->set_message('max_length','Error el dato %s, debe ser menor o igual a %s caracteres');


		 if($this->form_validation->run()===FALSE)
		 {
			$mensaje = array(
				'respuesta'=>'error',
				'error_fecha_recibido'=>form_error('fecha_recibido'),
				'error_solicitud_pedido'=>form_error('solicitud_pedido'),
				'error_area_solicitante'=>form_error('area_solicitante'),
				'error_descripcion_licitaciones'=>form_error('descripcion_licitaciones'),
				'error_observacion_licitaciones'=>form_error('observacion_licitaciones'),
				'error_estado_licitaciones'=>form_error('estado_licitaciones')

			);
		 }
		 else
		 {

				$fecha_recibido=xss_clean($this->input->post('fecha_recibido'));
				$solicitud=xss_clean($this->input->post('solicitud_pedido'));
				$area = xss_clean($this->input->post('area_solicitante'));
				$descripcion = strip_tags(xss_clean($this->input->post('descripcion_licitaciones')));
				$observacion = strip_tags(xss_clean($this->input->post('observacion_licitaciones')));
				$estado = xss_Clean($this->input->post('estado_licitaciones'));


			 $registro = array(
				'idlicitaciones'=>'',
				'fecha_recibido'=>$fecha_recibido,
				'solicitud_pedido'=> $solicitud,
				'area_solicitante_idarea'=>$area,
				'descripcion'=>($descripcion=='')?'N/A':$descripcion,
				'observacion'=>($observacion=='')?'N/A':$observacion,
				'estado'=>$estado,
				'fecha_terminado'=>'0000/00/00',
				'duracion'=>'0'

			 );
			 
			

			 $resultado = $this->Administrador_model->registrar_licitaciones($registro);
			 if($resultado===TRUE)
			 {
				$mensaje = array(

					'respuesta'=>'exito',
					'exito'=>'Datos registrado con exito'
				);
			 }
			 else
			 {
				 $mensaje= array(

					 'respuesta'=>'error',
					 'error'=>'Ohh error no se pudo guardar los datos'
				 );

			 }

		 }


		 echo json_encode($mensaje);
				 
		 

	 }
	 else
	 {
		 show_404();
	 }
 }

 public function form_buscar_licitaciones()
 {
	 if($this->input->is_ajax_request())
	 {
		 $areas['areas'] = $this->Administrador_model->extraer_areas();
		$this->load->view('administrador/form_buscar_licitaciones',$areas);
	 }
	 else
	 {
		 show_404();
	 }
 }


 public function registrar_area_solicitante()
 {
	 if($this->input->is_ajax_request())
	 {
		 $this->form_validation->set_rules('nombre_area_solicitante','Nombre Area Solicitante','trim|required|max_length[100]|min_length[13]|is_unique[area_solicitante.nombre_area]');

		 $this->form_validation->set_message('required','Error el dato %s es requerido');
		 $this->form_validation->set_message('max_length','Error el dato %s debe ser menor o igual a %s caracteres');
		 $this->form_validation->set_message('min_length','Error el dato %s debe ser mayor o igual a %s caracteres');
		 $this->form_validation->set_message('is_unique','Error el dato %s ya se encuentra registrado en el sistema');

		 if($this->form_validation->run()===FALSE)
		 {
			 $mensaje = array(
				'respuesta'=>'error',
				'error'=>form_error('nombre_area_solicitante')
			 );

		 }
		 else
		 {

			 $validar_nombre = substr(strtoupper($this->input->post('nombre_area_solicitante')),0,8);
			 
			 if($validar_nombre=='AREA DE ')
			 {
				 $nombre_area = strtoupper(xss_clean($this->input->post('nombre_area_solicitante')));
				 $validacion = $this->Administrador_model->registrar_area_solicitante($nombre_area);

				if($validacion===TRUE)
				{
					$mensaje = array(
						'respuesta'=>'exito',
						'exito'=>'Datos registrado con exito'
					);
				}
				else
				{
					$mensaje = array(
						'respuesta'=>'error',
						'error'=>'ohh ocurrio un error datos no guardado en la base de datos'
					);

				}

			 }
			 else
			 {
				 $mensaje = array(
					'respuesta'=>'error',
					'error'=>'error en nombre, el nombre debe iniciar con area de, seguido del nombre del area que desea registrar'
				);
			 }

			

		 }

		 echo json_encode($mensaje);

	 }
	 else
	 {
		 show_404();
	 }
 }


 public function editar_dato_area_solicitante()
 {
	 if($this->input->is_ajax_request())
	 {
		$this->form_validation->set_rules('nuevovalor','Nombre Area','trim|required|min_length[13]|max_length[100]|regex_match[/^[a-zA-Zñ-Ñ\s]+$/]');

		$this->form_validation->set_message('required','El dato %s es requerido');
		$this->form_validation->set_message('regex_match','Error en dato %s formato no permitido');
		$this->form_validation->set_message('min_length','Error dato %s debe ser mayor o igual a %s caracteres');
		$this->form_validation->set_message('max_length','Error dato %s debe ser menor o igual a %s caracteres');

		if($this->form_validation->run()===FALSE)
		{
			$mensaje = array(

				'respuesta'=>'error',
				'error'=>form_error('nuevovalor')
			);

		}
		else
		{
			$nombre_area= strtoupper(substr($this->input->post('nuevovalor'),0,8));
			if($nombre_area=='AREA DE ')
			{
				$nombre= strtoupper(xss_clean($this->input->post('nuevovalor')));
				$idarea = $this->input->post('id');
				$consulta = $this->Administrador_model->editar_dato_nombre_area($nombre,$idarea);

				if($consulta===TRUE)
				{
					$mensaje = array(
					'respuesta'=>'exito',
					'exito'=>'Datos actualizado con exito'
					);
				}
				else
				{
					$mensaje = array(
					'respuesta'=>'error',
					'error'=>'a ocurrido un error datos no se pudo resgistra en la base de datos'
				);
				}
			}
			else
			{
				$mensaje = array(
					'respuesta'=>'error',
					'error'=>'error en nombre, el nombre debe iniciar con area de, seguido del nombre del area que desea registrar'
				);
			}
			

		}

		echo json_encode($mensaje);

	 }
	 else
	 {
		 show_404();
	 }
 }

 public function extraer_area_solicitante()
 {
	if($this->input->is_ajax_request())
	{
		$areas['areas'] = $this->Administrador_model->extraer_areas();
		$areas['cantida'] = count($areas['areas']);

		$this->load->view('administrador/resportes_areas_solicitantes',$areas);


	}
	else
	{
		show_404();
	}
 }

 public function pdf_area_solicitante()
 {
	 $this->pdf = new Pdf();
	 //agregamos una pagina
	 $this->pdf->addPage();
	 //header o cabecera de la pagina
	 $this->pdf->Cell(200,9,$this->pdf->Image('http://localhost/slc/public/img/banner.jpg',7,7,200),0,1,'C');
     $this->pdf->Ln();
	 $this->pdf->SetFont('Arial','B',14);
     $this->pdf->SetTextColor(0,0,0);
	 $this->pdf->Cell(190,9,'REGISTRO DE AREAS SOLICITANTES','LTRB',1,'C');
     $this->pdf->Ln(2);
	 //fin de la cabecere de la pagina
	 $this->pdf->SetFillColor(153,255,100);
	 $this->pdf->SetFont('arial','B',8);
	 $this->pdf->Cell(10,8,'ITEM',1,0,'C');
	 $this->pdf->Cell(180,8,'NOMBRES DE AREAS SOLICITANTES',1,1,'C');

	 
	 $data = $this->Administrador_model->extraer_areas();
	 $i=1;

	 foreach($data as $dato)
	 {
		 $this->pdf->Cell(10,5,$i++,1,0,'C');
		 $this->pdf->Cell(180,5,utf8_decode($dato['nombre_area']),1,1,'L');

	 }
	 //footer o pie de la pagina
	 $this->SetY(-10);
     $this->SetFont('Arial','',8);
     $this->Cell(180,10,'Pagina '.$this->PageNo(),0,1,'R');

	 $this->pdf->Output('Reportes de Areas Solicitantes','I');

 }

 public function buscar_reportes_licitaciones()
 {

	 if($this->input->is_ajax_request())
	 {
			$this->form_validation->set_rules('fecha_desde_licitaciones','Fecha Desde','trim|required|regex_match[/^[0-9]{4}[\/]{1}[0-9]{2}[\/]{1}[0-9]+$/]|exact_length[10]');
			$this->form_validation->set_rules('fecha_hasta_licitaciones','Fecha Hasta','trim|required|regex_match[/^[0-9]{4}[\/]{1}[0-9]{2}[\/]{1}[0-9]+$/]|exact_length[10]');

			$this->form_validation->set_message('regex_match','<h3 class="text-center text-danger">Error en campo %s, formato no valido</h3>');
			$this->form_validation->set_message('exact_length','<h3 class="text-danger text-center">Error en campo %s debe tener %s caracteres exactos</h3>');

			if($this->form_validation->run()===FALSE)
			{
				echo form_error('fecha_desde_licitaciones').' '.form_error('fecha_hasta_licitaciones');
			}
			else
			{
				$filtrado_licitaciones = $this->input->post('filtrado_licitaciones');
				$estado_licitaciones = $this->input->post('buscar_estado_licitaciones');
				$fecha_desde = $this->input->post('fecha_desde_licitaciones');
				$fecha_hasta = $this->input->post('fecha_hasta_licitaciones');
				if($fecha_desde > $fecha_hasta)
				{
					echo '<h3 class="text-danger text-center">Error Fecha Desde no puede ser mayor a Fecha Hasta</h3>';
				}
				else
				{
					
					switch($filtrado_licitaciones)
					{
						case 'todos':

								if($estado_licitaciones=='todos')
								{
									$estado='si';
									$todas_licitaciones['todas_licitaciones'] = $this->Administrador_model->extraer_todas_licitaciones($fecha_desde,$fecha_hasta,$estado,$estado_licitaciones);
									$todas_licitaciones['cantida'] = count($todas_licitaciones['todas_licitaciones']);
									$todas_licitaciones['titulo'] ='Reportes de todas las Licitaciones';
									$todas_licitaciones['boton_pdf'] ="<a href='administrador/Administrador/pdf_todas_licitaciones/{$fecha_desde}/{$fecha_hasta}/{$estado}/{$estado_licitaciones}' title='Generar Pdf' class='btn btn-success' id='generar_pdf_todas_licitaciones'><span class='glyphicon glyphicon-save-file' ></span> Generar Pdf </a>";
									$todas_licitaciones['todas_filtrado']='todas';
									$this->load->view('administrador/ver_todas_licitaciones',$todas_licitaciones);
								}
								else if(($estado_licitaciones=='abierto') || ($estado_licitaciones=='cerrado'))
								{

									if($estado_licitaciones=='abierto'):
										$estado=1; 
										$todas_licitaciones['titulo'] ='Reportes de Licitaciones de Concursos Abiertos';
										$todas_licitaciones['boton_pdf'] ="<a href='administrador/Administrador/pdf_todas_licitaciones/{$fecha_desde}/{$fecha_hasta}/{$estado}/{$estado_licitaciones}' title='Generar Pdf' class='btn btn-success' id='generar_pdf_todas_licitaciones'><span class='glyphicon glyphicon-save-file'></span> Generar Pdf </a>";
										
									else :
										$estado=0;
										$todas_licitaciones['titulo'] ='Reportes de Licitaciones de Concursos Cerrados';
										$todas_licitaciones['boton_pdf'] ="<a href='administrador/Administrador/pdf_todas_licitaciones/{$fecha_desde}/{$fecha_hasta}/{$estado}/{$estado_licitaciones}' title='Generar Pdf' class='btn btn-success' id='generar_pdf_todas_licitaciones'><span class='glyphicon glyphicon-save-file'></span> Generar Pdf </a>"; 
									endif;
										$todas_licitaciones['todas_licitaciones'] = $this->Administrador_model->extraer_todas_licitaciones($fecha_desde,$fecha_hasta,$estado,$estado_licitaciones);
										$todas_licitaciones['cantida'] = count($todas_licitaciones['todas_licitaciones']);
										$this->load->view('administrador/ver_todas_licitaciones',$todas_licitaciones);
								}
								else
								{
									echo '<h3 class="text-center text-danger">Error Dato de busqueda de concurso no permitido</h3>';
								}


						break;
							//filtrar por areas
						case 'areas':

								$areas = $this->input->post('filtrado_licitaciones_areas');

								if($estado_licitaciones=='todos')
								{
									$estado='si';
									$todas_licitaciones['todas_licitaciones'] = $this->Administrador_model->extraer_todas_licitaciones_areas($fecha_desde,$fecha_hasta,$estado,$estado_licitaciones,$areas);
									$todas_licitaciones['cantida'] = count($todas_licitaciones['todas_licitaciones']);
									$todas_licitaciones['boton_pdf'] ="<a href='administrador/Administrador/pdf_todas_licitaciones_areas/{$fecha_desde}/{$fecha_hasta}/{$estado}/{$estado_licitaciones}/{$areas}' id='generar_pdf_todas_licitaciones_areas' title='Generar Pdf' class='btn btn-success'><span class='glyphicon glyphicon-save-file'></span> Generar Pdf </a>";
									if(count($todas_licitaciones['todas_licitaciones'])>0){
										$todas_licitaciones['titulo'] ='REPORTES LICITACIONES DEL '.$todas_licitaciones['todas_licitaciones'][0]['nombre_area'];
									}else{
										$todas_licitaciones['titulo']='';
									}
									$this->load->view('administrador/ver_todas_licitaciones',$todas_licitaciones);
								}
								else if(($estado_licitaciones=='abierto') || ($estado_licitaciones=='cerrado'))
								{

									if($estado_licitaciones=='abierto'):
										$titulo ='REPORTES DE LICITACIONES DE CONCURSOS ABIERTOS DEL ';
										$estado=1; 
										$todas_licitaciones['boton_pdf'] ="<a href='administrador/Administrador/pdf_todas_licitaciones_areas/{$fecha_desde}/{$fecha_hasta}/{$estado}/{$estado_licitaciones}/{$areas}' id='generar_pdf_todas_licitaciones_areas' title='Generar Pdf' class='btn btn-success'><span class='glyphicon glyphicon-save-file'></span> Generar Pdf </a>";
									else :
										$estado=0;
										$titulo ='REPORTES DE LICITACIONES DE CONCURSOS CERRADOS DEL ';
										$todas_licitaciones['boton_pdf'] ="<a href='administrador/Administrador/pdf_todas_licitaciones_areas/{$fecha_desde}/{$fecha_hasta}/{$estado}/{$estado_licitaciones}/{$areas}' id='generar_pdf_todas_licitaciones_areas' title='Generar Pdf' class='btn btn-success'><span class='glyphicon glyphicon-save-file'></span> Generar Pdf </a>";
									endif;
									$todas_licitaciones['todas_licitaciones'] = $this->Administrador_model->extraer_todas_licitaciones_areas($fecha_desde,$fecha_hasta,$estado,$estado_licitaciones,$areas);
									$todas_licitaciones['cantida'] = count($todas_licitaciones['todas_licitaciones']);
									

									if(count($todas_licitaciones['todas_licitaciones'])>0){
										$todas_licitaciones['titulo'] = $titulo.$todas_licitaciones['todas_licitaciones'][0]['nombre_area'];
									}else{
										$todas_licitaciones['titulo']='';
									}

									$this->load->view('administrador/ver_todas_licitaciones',$todas_licitaciones);
								}
								else
								{
									echo '<h3 class="text-center text-danger">Error Dato de busqueda de concurso no permitido</h3>';
								}


						break;

						default :
							echo "<h3 class='text-center text-danger'>Error en busqueda de licitaciones</h3>";
						break;

						
					}
					
				}
			}
	 }
	 else
	 {
		 show_404();
	 }


 }


 public function editar_datos_licitaciones()
 {
	 if($this->input->is_ajax_request())
	 {
		 $campo = $this->input->post('campo');
		 $id= $this->input->post('id');

		 switch ($campo) {
			 case 'fecha_recibido':

			 		$this->form_validation->set_rules('nuevovalor','Fecha Recibido','trim|required|regex_match[/^[0-9]{4}[\/\-]{1}[0-9]{2}[\/\-]{1}[0-9]+$/]|exact_length[10]');
					
					$this->form_validation->set_message('required','El dato %s, es requerido');
					$this->form_validation->set_message('regex_match','Error en dato %s, formato invalido');
					$this->form_validation->set_message('exact_length','Error en dato %s, formato solo puede tener %s caracteres');

					if($this->form_validation->run()===FALSE)
					{
						$mensaje = array(

							'respuesta'=>'error',
							'error'=>form_error('nuevovalor')
						);
					}
					else
					{
						$nuevovalor = xss_clean($this->input->post('nuevovalor'));

						if($nuevovalor>date('Y-m-d'))
						{
							$mensaje= array(
								'respuesta'=>'error',
								'error'=>'error fecha recibido no puede ser mayor a la fecha actual'
							);
						}
						else
						{
							$validar = $this->Administrador_model->editar_datos_licitaciones($id,$campo,$nuevovalor);

							if($validar)
							{
								$mensaje = array(
									'respuesta'=>'exito',
									'exito'=>'Datos actualizado con exito'

								);
							}
							else
							{
								$mensaje = array(

									'respuesta'=>'error',
									'error'=>'ohh, ha ocurrido un error'
								);
							}

						}
						
					}

					echo json_encode($mensaje);
				
				 break;

			case 'solicitud_pedido':
				 
				 	$this->form_validation->set_rules('nuevovalor','Numero Solicitud','trim|required|is_natural_no_zero|min_length[3]|max_length[12]|is_unique[licitaciones.solicitud_pedido]');

					$this->form_validation->set_message('required','dato %s, es requerido');
					$this->form_validation->set_message('is_natural_no_zero','Error en dato %s, formato no permitido');
					$this->form_validation->set_message('min_length','Error el dato %s, debe ser mayor o igual a %s caracteres');
					$this->form_validation->set_message('max_length','Error el dato %s, debe ser menor o igual a %s caracteres');
					$this->form_validation->set_message('is_unique','Error el dato %s, ya se encuentra registrado en el sistema');


					if($this->form_validation->run()===FALSE)
					{
						$mensaje = array(
							'respuesta'=>'error',
							'error'=>form_error('nuevovalor')
						);
					}
					else
					{	

						$nuevovalor = xss_clean($this->input->post('nuevovalor'));

						$validar = $this->Administrador_model->editar_datos_licitaciones($id,$campo,$nuevovalor);

						if($validar)
						{
								$mensaje = array(
									'respuesta'=>'exito',
									'exito'=>'Datos actualizado con exito'

								);
						}
						else
						{
								$mensaje = array(

									'respuesta'=>'error',
									'error'=>'ohh, ha ocurrido un error'
								);
						}						

					}

					echo json_encode($mensaje);

				 break;

			case 'descripcion':
				 	$this->form_validation->set_rules('nuevovalor','Descripcion','trim|required|min_length[3]');

					$this->form_validation->set_message('required','El dato %s, es requerido');
					$this->form_validation->set_message('min_length','Error el dato %s, debe ser mayor o igual a %s caracteres');

					if($this->form_validation->run()===FALSE)
					{
						$mensaje= array(

							'respuesta'=>'error',
							'error'=>form_error('nuevovalor')
						);
					}
					else
					{
						$nuevovalor= strip_tags(xss_clean($this->input->post('nuevovalor')));
						
							$validar = $this->Administrador_model->editar_datos_licitaciones($id,$campo,$nuevovalor);

							if($validar)
							{
									$mensaje = array(
										'respuesta'=>'exito',
										'exito'=>'Datos actualizado con exito'

									);
							}
							else
							{
									$mensaje = array(

										'respuesta'=>'error',
										'error'=>'ohh, ha ocurrido un error'
									);
							}						

					}

					echo json_encode($mensaje);


					
				 break;

			case 'observacion':

				 	$this->form_validation->set_rules('nuevovalor','Descripcion','trim|required|min_length[3]');

					$this->form_validation->set_message('required','El dato %s, es requerido');
					$this->form_validation->set_message('min_length','Error el dato %s, debe ser mayor o igual a %s caracteres');

					if($this->form_validation->run()===FALSE)
					{
						$mensaje= array(

							'respuesta'=>'error',
							'error'=>form_error('nuevovalor')
						);
					}
					else
					{
						$nuevovalor= strip_tags(xss_clean($this->input->post('nuevovalor')));
						
							$validar = $this->Administrador_model->editar_datos_licitaciones($id,$campo,$nuevovalor);

							if($validar)
							{
									$mensaje = array(
										'respuesta'=>'exito',
										'exito'=>'Datos actualizado con exito'

									);
							}
							else
							{
									$mensaje = array(

										'respuesta'=>'error',
										'error'=>'ohh, ha ocurrido un error'
									);
							}						

					}

					echo json_encode($mensaje);
				 break;

			case 'estado':
				 $this->form_validation->set_rules('nuevovalor','Estado','trim|required|in_list[0,1]');

				 $this->form_validation->set_message('required','El dato %s, es requerido');
				 $this->form_validation->set_message('in_list','Error en dato %s, formato no valido');

				 if($this->form_validation->run()===FALSE)
				 {
					$mensaje = array(
						'respuesta'=>'error',
						'error'=>form_error('nuevovalor')

					);
				 }
				 else
				 {
					$nuevovalor = xss_clean($this->input->post('nuevovalor'));
					$validar = $this->Administrador_model->editar_datos_licitaciones($id,$campo,$nuevovalor);

					if($validar)
					{
						$mensaje = array(
							'respuesta'=>'exito',
							'exito'=>'Datos guardados con exito'
						);
					}
					else
					{
						$mensaje = array(
							'respuesta'=>'error',
							'error'=>'ohh, ha ocurrido un error en el sistema'
						);

					}
				 }

				 echo json_encode($mensaje);

				 break;
			 
			 default:
				 $mensaje= array(
					 'respuesta'=>'error',
					 'error'=>'Error al capturar valores del sistema'
				 );

				 echo json_encode($mensaje);
				 break;
		 }

	 }
	 else
	 {
		 show_404();
	 }
 }


	public function pdf_todas_licitaciones($ano_desde,$mes_desde,$dia_desde,$ano_hasta,$mes_hasta,$dia_hasta,$estado,$estado_licitaciones)
	{
		$fecha_desde = $ano_desde.'/'.$mes_desde.'/'.$dia_desde;
		$fecha_hasta = $ano_hasta.'/'.$mes_hasta.'/'.$dia_hasta;
		$this->pdf = new Pdf();
	 	//agregamos una pagina
	 	$this->pdf->addPage('L','A4');
		//$this->pdf->SetMargins(3,3,3);
		 //header o cabecera de la pagina
	 	$this->pdf->Cell(400,9,$this->pdf->Image('http://localhost/slc/public/img/banner.jpg',7,7,280),0,1,'C');
     	$this->pdf->Ln();

	 //fin de la cabecere de la pagina
	 	$this->pdf->SetFillColor(153,255,100);
	 	$this->pdf->SetFont('arial','B',12);

		 if($estado=='si'){
	 		$this->pdf->Cell(280,8,'REPORTES DE TODAS LAS LICITACIONES',0,1,'C');
		 }else
		 {
			 if($estado==1):
			 	$this->pdf->Cell(280,8,'REPORTES DE TODAS LAS LICITACIONES DE CONCURSOS ABIERTOS',0,1,'C');
			 else :
			 	$this->pdf->Cell(280,8,'REPORTES DE TODAS LAS LICITACIONES DE CONCURSOS CERRADOS',0,1,'C');
			 endif;
		 }
		$this->pdf->SetFillColor(153,255,100);
		$this->pdf->SetFont('arial','B',10);
	 	$this->pdf->Cell(46,8,'Fecha Recibido',1,0,'C');
		$this->pdf->Cell(46,8,utf8_decode('N° Solicitud'),1,0,'C');
		$this->pdf->Cell(46,8,'Area Solicitante',1,0,'C');
		$this->pdf->Cell(46,8,'Estado',1,0,'C');
		$this->pdf->Cell(46,8,'Fecha Terminado',1,0,'C');
		$this->pdf->Cell(46,8,'Duracion',1,1,'C');

		$data = $this->Administrador_model->extraer_todas_licitaciones($fecha_desde,$fecha_hasta,$estado,$estado_licitaciones);

		$this->pdf->SetFillColor(153,255,100);
		$this->pdf->SetFont('arial','',8);
		foreach($data as $dato)
		{
			//MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
			$this->pdf->Cell(46,8,utf8_decode($dato['fecha_recibido']),1,0,'C');
			$this->pdf->Cell(46,8,utf8_decode($dato['solicitud_pedido']),1,0,'C');
			$this->pdf->Cell(46,8,utf8_decode($dato['nombre_area']),1,0,'C');
			if($dato['estado']==1)
			{
				$this->pdf->Cell(46,8,utf8_decode('Abierto'),1,0,'C');
			}
			else
			{
				$this->pdf->Cell(46,8,utf8_decode('Cerrado'),1,0,'C');
			}
			
			$this->pdf->Cell(46,8,utf8_decode($dato['fecha_terminado']),1,0,'C');
			$this->pdf->Cell(46,8,utf8_decode($dato['duracion']),1,1,'C');

			$this->pdf->Cell(280,8,utf8_decode('Descripción'),1,1,'L');
			$this->pdf->MultiCell(280,8,utf8_decode(str_replace('<br />','',$dato['descripcion'])),1,'L',false);

			$this->pdf->Cell(280,8,utf8_decode('Observación'),1,1,'L');
			$this->pdf->MultiCell(280,8,utf8_decode($dato['observacion']),1,'L',false);
		}

	   $this->pdf->SetY(1);
       $this->pdf->SetFont('Arial','',7);
       $this->pdf->Cell(280,10,'Pagina '.$this->pdf->PageNo(),0,1,'R');

	 	$this->pdf->Output('Reportes de todas la licitaciones por fecha desde {$fecha_desde} hasta {$fecha_hasta}','I');

	}

	public function pdf_todas_licitaciones_areas($ano_desde,$mes_desde,$dia_desde,$ano_hasta,$mes_hasta,$dia_hasta,$estado,$estado_licitaciones,$area)
	{


		$area_nombre = $this->Administrador_model->extraer_areas_id($area);

		$fecha_desde = $ano_desde.'/'.$mes_desde.'/'.$dia_desde;
		$fecha_hasta = $ano_hasta.'/'.$mes_hasta.'/'.$dia_hasta;
		$this->pdf = new Pdf();
	 	//agregamos una pagina
	 	$this->pdf->addPage('L','A4');
		//$this->pdf->SetMargins(3,3,3);
		 //header o cabecera de la pagina
	 	$this->pdf->Cell(400,9,$this->pdf->Image('http://localhost/slc/public/img/banner.jpg',7,7,280),0,1,'C');
     	$this->pdf->Ln();

	 //fin de la cabecere de la pagina
	 	$this->pdf->SetFillColor(153,255,100);
	 	$this->pdf->SetFont('arial','B',12);

		 if($estado=='si') {
		 $this->pdf->Cell(280,8,'REPORTES DE LICITACIONES DEL '.strtoupper($area_nombre[0]['nombre_area'].' TODOS LOS CONCURSO'),0,1,'C');
		 }else
		 {
			  if($estado==1):
		 	  	$this->pdf->Cell(280,8,'REPORTES DE LICITACIONES DEL '.strtoupper($area_nombre[0]['nombre_area'].' TODOS LOS CONCURSO ABIERTOS'),0,1,'C');

		 	 else:
		 	  	$this->pdf->Cell(280,8,'REPORTES DE LICITACIONES DEL '.strtoupper($area_nombre[0]['nombre_area'].' TODOS LOS CONCURSO CERRADO'),0,1,'C');
		     endif;


		 }

		

		$this->pdf->SetFillColor(153,255,100);
		$this->pdf->SetFont('arial','B',10);
	 	$this->pdf->Cell(46,8,'Fecha Recibido',1,0,'C');
		$this->pdf->Cell(46,8,utf8_decode('N° Solicitud'),1,0,'C');
		$this->pdf->Cell(46,8,'Area Solicitante',1,0,'C');
		$this->pdf->Cell(46,8,'Estado',1,0,'C');
		$this->pdf->Cell(46,8,'Fecha Terminado',1,0,'C');
		$this->pdf->Cell(46,8,'Duracion',1,1,'C');

		$data = $this->Administrador_model->extraer_todas_licitaciones_areas($fecha_desde,$fecha_hasta,$estado,$estado_licitaciones,$area);

		$this->pdf->SetFillColor(153,255,100);
		$this->pdf->SetFont('arial','',8);
		foreach($data as $dato)
		{
			//MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
			$this->pdf->Cell(46,8,utf8_decode($dato['fecha_recibido']),1,0,'C');
			$this->pdf->Cell(46,8,utf8_decode($dato['solicitud_pedido']),1,0,'C');
			$this->pdf->Cell(46,8,utf8_decode($dato['nombre_area']),1,0,'C');
			if($dato['estado']==1)
			{
				$this->pdf->Cell(46,8,utf8_decode('Abierto'),1,0,'C');
			}
			else
			{
				$this->pdf->Cell(46,8,utf8_decode('Cerrado'),1,0,'C');
			}
			
			$this->pdf->Cell(46,8,utf8_decode($dato['fecha_terminado']),1,0,'C');
			$this->pdf->Cell(46,8,utf8_decode($dato['duracion']),1,1,'C');

			$this->pdf->Cell(280,8,utf8_decode('Descripción'),1,1,'L');
			$this->pdf->MultiCell(280,8,utf8_decode(str_replace('<br />','',$dato['descripcion'])),1,'L',false);

			$this->pdf->Cell(280,8,utf8_decode('Observación'),1,1,'L');
			$this->pdf->MultiCell(280,8,utf8_decode($dato['observacion']),1,'L',false);
		}

	   $this->pdf->SetY(1);
       $this->pdf->SetFont('Arial','',7);
       $this->pdf->Cell(280,10,'Pagina '.$this->pdf->PageNo(),0,1,'R');

	 	$this->pdf->Output('Reportes de todas la licitaciones por fecha desde {$fecha_desde} hasta {$fecha_hasta}','I');



	}

	public function form_buscar_solicitud_licitaciones()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->view('administrador/form_buscar_solicitud_licitaciones');
			
		}
		else
		{
			show_404();
		}
	}

	public function buscar_solicitud_licitaciones_solicitud()
	{
		if($this->input->is_ajax_request())
		{
			$solicitud = $this->input->post('solicitud');

			$resultado = $this->Administrador_model->buscar_solicitud_licitaciones_solicitud($solicitud);

			if(count($resultado)>0)
			{
				$datos = array();
				$i=0;
				foreach($resultado as $result)
				{
					//echo json_encode($result['solicitud_pedido']);
					$datos[$i] = $result['solicitud_pedido'];
					$i++;
				}
				
				echo json_encode($datos);
			}
			else
			{
				$mensaje = array('datos'=>'no existe el numero de licitacion en el sistema');
				echo json_encode($mensaje);
			}
			
		}
		else
		{
			show_404();
		}
	}

	//funcion que busca la licitaciones solo por el numero de buscar_solicitud_licitaciones_solicitud
	public function bus_sol_licitaciones()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('solicitud','Numero Solicitud','trim|required|is_natural');

			$this->form_validation->set_message('required','<h3 class="text-danger text-center">el dato %s, es requerido</h3>');
			$this->form_validation->set_message('is_natural','<h3 class="text-danger text-center">Error en dato %s, formato no permitido</h3>');

			if($this->form_validation->run()===FALSE)
			{
				
					
				echo form_error('solicitud');
				
			}
			else
			{
				$solicitud = xss_clean($this->input->post('solicitud'));
				$resultado['solicitud'] = $this->Administrador_model->bus_sol_licitaciones($solicitud);
				$resultado['boton_pdf'] ="<a href='administrador/Administrador/pdf_licitaciones_solicitud/{$solicitud}' id='generar_pdf_licitaciones_solicitud' title='Generar Pdf' class='btn btn-success'><span class='glyphicon glyphicon-save-file'></span> Generar Pdf </a>";
				$this->load->view('administrador/ver_licitaciones',$resultado);

			}

			
		}
		else
		{
			show_404();
		}
	}

	public function pdf_licitaciones_solicitud($solicitud)
	{
		$this->pdf = new Pdf();
	 	//agregamos una pagina
	 	$this->pdf->addPage('L','A4');
		//$this->pdf->SetMargins(3,3,3);
		 //header o cabecera de la pagina
	 	$this->pdf->Cell(400,9,$this->pdf->Image('http://localhost/slc/public/img/banner.jpg',7,7,280),0,1,'C');
     	$this->pdf->Ln();

		 //fin de la cabecere de la pagina
	 	$this->pdf->SetFillColor(153,255,100);
	 	$this->pdf->SetFont('arial','B',12);

	 	$this->pdf->Cell(280,8,'REPORTES DE LICITACIONES POR NUMERO DE SOLICITUD',0,1,'C');
		
		$this->pdf->SetFillColor(153,255,100);
		$this->pdf->SetFont('arial','B',10);
	 	$this->pdf->Cell(46,8,'Fecha Recibido',1,0,'C');
		$this->pdf->Cell(46,8,utf8_decode('N° Solicitud'),1,0,'C');
		$this->pdf->Cell(46,8,'Area Solicitante',1,0,'C');
		$this->pdf->Cell(46,8,'Estado',1,0,'C');
		$this->pdf->Cell(46,8,'Fecha Terminado',1,0,'C');
		$this->pdf->Cell(46,8,'Duracion',1,1,'C');

		$data = $this->Administrador_model->bus_sol_licitaciones($solicitud);

		$this->pdf->SetFillColor(153,255,100);
		$this->pdf->SetFont('arial','',8);
		foreach($data as $dato)
		{
			//MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
			$this->pdf->Cell(46,8,utf8_decode($dato['fecha_recibido']),1,0,'C');
			$this->pdf->Cell(46,8,utf8_decode($dato['solicitud_pedido']),1,0,'C');
			$this->pdf->Cell(46,8,utf8_decode($dato['nombre_area']),1,0,'C');
			if($dato['estado']==1)
			{
				$this->pdf->Cell(46,8,utf8_decode('Abierto'),1,0,'C');
			}
			else
			{
				$this->pdf->Cell(46,8,utf8_decode('Cerrado'),1,0,'C');
			}
			
			$this->pdf->Cell(46,8,utf8_decode($dato['fecha_terminado']),1,0,'C');
			$this->pdf->Cell(46,8,utf8_decode($dato['duracion']),1,1,'C');

			$this->pdf->Cell(280,8,utf8_decode('Descripción'),1,1,'L');
			$this->pdf->MultiCell(280,8,utf8_decode(str_replace('<br />','',$dato['descripcion'])),1,'L',false);

			$this->pdf->Cell(280,8,utf8_decode('Observación'),1,1,'L');
			$this->pdf->MultiCell(280,8,utf8_decode($dato['observacion']),1,'L',false);
		}

	   $this->pdf->SetY(1);
       $this->pdf->SetFont('Arial','',7);
       $this->pdf->Cell(280,10,'Pagina '.$this->pdf->PageNo(),0,1,'R');

	   $this->pdf->Output('Reportes de licitaciones por numero de solicitud {$solicitud}','I');

	}

}

?>
