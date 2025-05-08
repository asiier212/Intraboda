<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class Cliente extends CI_Controller
{

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('cliente_functions');
        $this->load->model('Spotify_model');

		if (!$this->session->userdata('user_id') && $this->router->method != 'login' && $this->router->method != 'recordar_pass' && $this->router->method != 'generar_pass') {
			redirect('cliente/login');
		}
	}


	public function login()
	{
		$data = false;

		if ($_POST) {
			$arr_userdata = $this->cliente_functions->ClientLogin($_POST['email'], $_POST['pass']);
			if ($arr_userdata) {
				$this->session->set_userdata($arr_userdata);
				redirect('cliente', 'location');
				///////
			} else {
				$data['msg'] = 'Login o contrase&ntilde;a incorrecto';
			}
		}
		$this->load->view('cliente/login', $data);
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('cliente', 'location');
	}

	public function recordar_pass()
	{
		$data = false;
		if ($_POST) {
			$this->load->database();
			$this->load->library('encrypt');

			//Comprobamos que exista el email en la base de datos
			$query = $this->db->query("SELECT COUNT(clientes.id) as num_emails, clientes.id as id, oficinas.email as email_oficina FROM clientes INNER JOIN oficinas ON clientes.id_oficina=oficinas.id_oficina WHERE email_novio = '" . $_POST['email'] . "' OR email_novia= '" . $_POST['email'] . "'");
			$fila = $query->row();
			$num_emails = 0;
			$num_emails = $fila->num_emails;
			$id_cliente = $fila->id;
			$email_oficina = $fila->email_oficina;

			if ($num_emails == 0) {
				$data['msg'] = 'No existe esa dirección de e-mail en nuestra base de datos';
			} else {


				//Mandamos el email
				$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$cabeceras .= 'From: ' . $email_oficina;

				$asunto = 'E-mail restablecimiento de contraseña Intraboda';
				$header_mail = 'http://www.bilbodj.com/intranetv3/' . $this->config->item('email_header');
				$footer_mail = 'http://www.bilbodj.com/intranetv3/' . $this->config->item('email_footer');

				$mensaje = '<table border="0" width="100%">
				<tr>
					<td>
						<img src="' . $header_mail . '" width="100%">
					</td>
				</tr>
				<tr>
					<td align="justify">
					<div style="padding:50px;">
					
					<p>Para restablecer tu clave haz click <a href="https://intranet.exeleventos.com/cliente/generar_pass/' . $id_cliente . '/' . urlencode($_POST['email']) . '" target="_blank">AQUI</a></p>
					</div>
						 
					</td>
					</tr>
					<tr>
						<td align="center"><img src="' . $footer_mail . '" width="100%"></td>
					</tr>
				</table>';



				$asunto = html_entity_decode(utf8_decode($asunto));
				$mensaje = html_entity_decode(utf8_decode($mensaje));

				//mail($_POST['email'], $asunto, $mensaje, $cabeceras);
				$this->sendEmail('info@exeleventos.com', [$_POST['email']], $asunto, $mensaje);

				$data['msg'] = 'E-mail de restablecimiento de contraseña enviado';
			}
		}

		$this->load->view('cliente/recordar_pass', $data);
	}

	public function generar_pass($id_cliente, $email)
	{
		$data = false;

		$this->load->database();
		$this->load->library('encrypt');
		//Generamos una clave aleatoria de máximo 5 caracteres
		$clave_nueva = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);

		//Comprobamos que el id y el email de alguno de los novios coincide para evitar hackeos
		$email = str_replace("%40", "@", $email);
		$query = $this->db->query("SELECT COUNT(id) as num_emails FROM clientes WHERE id = '" . $id_cliente . "' AND (email_novio = '" . $email . "' OR email_novia= '" . $email . "')");
		$fila = $query->row();
		$num_emails = 0;
		$num_emails = $fila->num_emails;

		//Si coincide actualizamos la clave
		if ($num_emails <> 0) {
			$this->db->query("UPDATE clientes SET clave = '" . $this->encrypt->encode($clave_nueva) . "' WHERE id = '" . $id_cliente . "'");
		}

		$data['msg'] = $clave_nueva;
		//$data['msg']="SELECT COUNT(id) as num_emails FROM clientes WHERE id = '".$id_cliente."' AND (email_novio = '".$email."' OR email_novia= '".$email."')";
		$this->load->view('cliente/generar_pass', $data);
	}

	public function index()
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		$this->load->database();


		//COMPROBAMOS QUE EL CLIENTE HA HECHO LA ENCUESTA AL INICIAR LA SESIÓN///
		$query = $this->db->query("SELECT COUNT(id_respuesta) as respuestas FROM respuestas_encuesta_datos_boda WHERE id_cliente = " . $this->session->userdata('user_id') . "");
		$fila = $query->row();
		$respuestas = 0;
		$respuestas = $fila->respuestas;
		if ($respuestas <> 0) {

			//$this->_loadViews($data_header, $data, $data_footer, "home");
			redirect('cliente/datos/view', 'location'); //ARRANCAMOS INICIALMENTE LA PANTALLA DE DATOS DEL CLIENTE

		} else {

			if ($_POST) {

				$config['upload_path'] = './uploads/foto_perfil/';
				$config['allowed_types'] = 'gif|jpg|png';
				//$config['max_width']  = '600';

				$this->load->library('upload', $config);


				if (! $this->upload->do_upload("foto")) {
					$data['msg'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->cliente_functions->UpdatefotoCliente($this->session->userdata('user_id'), $data['upload_data']['file_name']);
					//$data['msg'] = "La imagen se ha subido correctamente";

				}

				$_POST['mas_importancia'] = implode(",", $_POST['mas_importancia']);
				$_POST['menos_importancia'] = implode(",", $_POST['menos_importancia']);

				$this->db->query("INSERT INTO respuestas_encuesta_datos_boda VALUES('','1','" . $this->session->userdata('user_id') . "','" . $_POST['participativo_dj'] . "')");
				$this->db->query("INSERT INTO respuestas_encuesta_datos_boda VALUES('','2','" . $this->session->userdata('user_id') . "','" . $_POST['participativos_invitados'] . "')");
				$this->db->query("INSERT INTO respuestas_encuesta_datos_boda VALUES('','3','" . $this->session->userdata('user_id') . "','" . $_POST['num_invitados'] . "')");
				$this->db->query("INSERT INTO respuestas_encuesta_datos_boda VALUES('','4','" . $this->session->userdata('user_id') . "','" . $_POST['ampliar_fiesta'] . "')");
				$this->db->query("INSERT INTO respuestas_encuesta_datos_boda VALUES('','5','" . $this->session->userdata('user_id') . "','" . $_POST['flexibilidad_restaurante'] . "')");
				$this->db->query("INSERT INTO respuestas_encuesta_datos_boda VALUES('','6','" . $this->session->userdata('user_id') . "','" . $_POST['hora_ultimo_autobus'] . "')");
				$this->db->query("INSERT INTO respuestas_encuesta_datos_boda VALUES('','7','" . $this->session->userdata('user_id') . "','" . $_POST['mas_importancia'] . "')");
				$this->db->query("INSERT INTO respuestas_encuesta_datos_boda VALUES('','8','" . $this->session->userdata('user_id') . "','" . $_POST['menos_importancia'] . "')");

				//$this->_loadViews($data_header, $data, $data_footer, "home");
				redirect('cliente/datos/view', 'location');
			} else {

				//$data['momentos_especiales'] = $this->cliente_functions->GetMomentos_Especiales();
				//$data['canciones_mas_elegidas'] = $this->cliente_functions->GetCanciones_Mas_Elegidas();

				$data['cliente'] = $this->cliente_functions->GetCliente($this->session->userdata('user_id'));
				$data['preguntas_encuesta_datos_boda'] = $this->cliente_functions->GetPreguntasEncuestaDatosBoda();
				//$this->_loadViews($data_header, $data, $data_footer, "home");
				$this->load->view('cliente/header_en_blanco', $data_header);

				$this->load->view('cliente/encuesta', $data);

				$this->load->view('cliente/footer', $data_footer);
				//$this->_loadViews("header_en_blanco", $data, $data_footer, "encuesta");
			}
		}
	}

	public function invitados()
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		// Capturar filtros desde GET
		$filtro_campo = $this->input->get('filtro_campo');
		$filtro_valor = $this->input->get('filtro_valor');
		$solo_activos = $this->input->get('solo_activos');

		// Pasar filtros al modelo
		$data['invitados'] = $this->cliente_functions->GetInvitados($filtro_campo, $filtro_valor, $solo_activos);

		if (isset($_POST['crear_invitado'])) {
			$username = trim($_POST['nuevo_username']);
			$clave = $_POST['nuevo_clave']; // Se usará para enviar por email
			$email = trim($_POST['nuevo_email']);
			$expiracion = !empty($_POST['nuevo_expiracion']) ? $_POST['nuevo_expiracion'] : null;

			if ($expiracion && strtotime($expiracion) < strtotime(date('Y-m-d'))) {
				$this->session->set_flashdata('msg_invitado', 'La fecha de expiración no puede ser anterior a hoy.');
				redirect($_SERVER['HTTP_REFERER']);
			}

			$id_cliente = $this->session->userdata('user_id');
			$this->load->database();
			$this->load->library('encrypt');

			// Verificar duplicado
			$this->db->where('email', $email);
			$this->db->where('id_cliente', $id_cliente);
			$existe = $this->db->get('invitado')->num_rows();

			if ($existe > 0) {
				$this->session->set_flashdata('msg_invitado', 'Ese email ya está registrado por ti.');
				redirect($_SERVER['HTTP_REFERER']);
			}

			// Cifrar para almacenar de forma reversible
			$clave_encriptada = $this->encrypt->encode($clave);

			$data_insert = array(
				'id_cliente' => $id_cliente,
				'username' => $username,
				'clave' => $clave_encriptada,
				'email' => $email,
				'fecha_expiracion' => $expiracion,
				'valido' => 1
			);

			if ($this->db->insert('invitado', $data_insert)) {

				// Si se pidió enviar email
				if (isset($_POST['enviar_email'])) {
					$from = 'noreply@exeleventos.com';
					$to = [$email];
					$subject = 'Tu acceso como invitado a Exel Eventos';
					$clave_plana = $this->encrypt->decode($clave_encriptada); // Recuperamos

					$message = "
					<div style='font-family:Segoe UI, sans-serif; background-color:#f9f9f9; padding:20px; border-radius:10px; max-width:600px; margin:auto; color:#333;'>
						<div style='background-color:#93CE37; padding:15px 20px; border-radius:8px 8px 0 0; color:white; font-size:18px; font-weight:bold;'>
							¡Bienvenido a Exel Eventos!
						</div>
				
						<div style='padding:20px; background:white; border-radius:0 0 8px 8px; box-shadow:0 2px 8px rgba(0,0,0,0.05);'>
							<p style='font-size:16px; margin-bottom:20px;'>Han creado una cuenta de <strong>invitado</strong> para que puedas acceder al sistema de gestión de eventos.</p>
				
							<table style='width:100%; font-size:15px; margin-bottom:20px;'>
								<tr>
									<td style='padding:8px 0;'><strong>Usuario:</strong></td>
									<td style='padding:8px 0;'>$username</td>
								</tr>
								<tr>
									<td style='padding:8px 0;'><strong>Contraseña:</strong></td>
									<td style='padding:8px 0;'>$clave</td>
								</tr>
							</table>
				
							<p style='font-size:15px; margin-bottom:20px;'>
								Entra ya a tu perfil de invitado de 
								<a href='https://intranet.exeleventos.com/invitado/login' target='_blank' style='color:#93CE37; text-decoration:none; font-weight:bold;'>INTRABODA</a>
							</p>
				
							<p style='font-size:13px; color:#777;'>
								Este acceso podría tener una fecha de expiración establecida. Si tienes dudas, contacta con el organizador del evento.
							</p>
						</div>
					</div>
				";

					$this->sendEmail($from, $to, $subject, $message);
				}

				redirect('cliente/invitados', 'location');
			} else {
				$this->session->set_flashdata('msg_invitado', "Error al guardar el invitado.");
				redirect($_SERVER['HTTP_REFERER']);
			}
		}


		$this->_loadViews($data_header, $data, $data_footer, 'invitados');
	}

	public function eliminar_invitado($id)
	{
		$this->load->database();
		$this->db->where('id', $id);
		$this->db->delete('invitado');
		redirect('cliente/invitados');
	}

	public function accion($accion, $id)
	{
		$this->load->database();
		if ($accion == "activar") {
			$this->db->where('id', $id);
			$this->db->update('invitado', array('valido' => 1));
		} else if ($accion == "desactivar") {
			$this->db->where('id', $id);
			$this->db->update('invitado', array('valido' => 0));
		}
		redirect('cliente/invitados');
	}

	public function topSongs()
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		// Obtener filtros desde la URL
		$fechaDesde = $this->input->get('fecha_desde');
		$fechaHasta = $this->input->get('fecha_hasta');
		$momentoSeleccionado = $this->input->get('momento');

		// Obtener todas las opciones de momentos de la base de datos (sin filtros)
		$momentosDisponibles = $this->cliente_functions->getAllMomentos();

		// Obtener las canciones filtradas
		$topsongs = $this->cliente_functions->getTopSongs($fechaDesde, $fechaHasta, $momentoSeleccionado);

		$data['topsongs'] = $topsongs;
		$data['momentos'] = $momentosDisponibles; // Usar todos los momentos en el select
		$data['momentoSeleccionado'] = $momentoSeleccionado;

		$this->_loadViews($data_header, $data, $data_footer, "topsongs");
	}






	public function canciones_mas_elegidas()
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		$this->load->database();

		$data['momentos_especiales'] = $this->cliente_functions->GetMomentos_Especiales();
		$data['canciones_mas_elegidas'] = $this->cliente_functions->GetCanciones_Mas_Elegidas();

		$data['cliente'] = $this->cliente_functions->GetCliente($this->session->userdata('user_id'));
		// error_log("Los datos a mostrar son " . var_export($data,1),3,"./r");
		$this->_loadViews($data_header, $data, $data_footer, "home");
	}

	public function datos($acc)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		if ($acc == 'view') {
			if ($_POST) {
				if (isset($_POST['clave']) && $_POST['clave'] != '') {
					$this->load->database();
					$this->load->library('encrypt');
					$this->db->query("UPDATE clientes SET clave = '" . $this->encrypt->encode($_POST['clave']) . "' WHERE id = " . $this->session->userdata('user_id') . "");
					$data['msg_clave'] = 'La contrase&ntilde;a ha sido cambiada con &eacute;xito';
				}
				if (isset($_POST['subir_foto']) && $_POST['subir_foto'] != '') {
					$config['upload_path'] = './uploads/foto_perfil/';
					$config['allowed_types'] = 'gif|jpg|png';
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload("foto")) {
						$data['msg_foto'] = $this->upload->display_errors();
					} else {
						$data['upload_data'] = $this->upload->data();
						$this->cliente_functions->UpdatefotoCliente($this->session->userdata('user_id'), $data['upload_data']['file_name']);
						$data['msg_foto'] = "La imagen se ha subido correctamente";
					}
				}
				if (isset($_POST['actualizar_encuesta'])) {
					$this->load->database();

					log_message('debug', 'Respuestas recibidas: ' . print_r($_POST['respuesta'], true));
					log_message('debug', 'Números exactos recibidos: ' . print_r($_POST['numero_exacto'], true));

					foreach ($_POST['respuesta'] as $id_pregunta => $valor_respuesta) {
						$id_cliente = $this->session->userdata('user_id');

						// Comprobamos si hay número exacto introducido
						$numero_exacto = isset($_POST['numero_exacto'][$id_pregunta]) && $_POST['numero_exacto'][$id_pregunta] !== ''
							? trim($_POST['numero_exacto'][$id_pregunta])
							: null;

						// Si hay un número exacto, lo priorizamos sobre cualquier otra respuesta
						if ($numero_exacto !== null) {
							$valor_respuesta = $numero_exacto;
						} elseif (is_array($valor_respuesta)) {
							$valor_respuesta = implode(",", $valor_respuesta); // Para respuestas múltiples
						}

						// Comprobar si ya existe una respuesta en la BD
						$query = $this->db->query(
							"
							SELECT COUNT(*) as total FROM respuestas_encuesta_datos_boda 
							WHERE id_pregunta = ? AND id_cliente = ?",
							array($id_pregunta, $id_cliente)
						);

						$existe = $query->row()->total;

						if ($existe > 0) {
							// Si ya existe, actualizar
							$this->db->query(
								"
								UPDATE respuestas_encuesta_datos_boda 
								SET respuesta = ? 
								WHERE id_pregunta = ? AND id_cliente = ?",
								array($valor_respuesta, $id_pregunta, $id_cliente)
							);
						} else {
							// Si no existe, insertar nueva respuesta
							$this->db->query(
								"
								INSERT INTO respuestas_encuesta_datos_boda (id_pregunta, id_cliente, respuesta) 
								VALUES (?, ?, ?)",
								array($id_pregunta, $id_cliente, $valor_respuesta)
							);
						}
					}

					log_message('debug', 'Última consulta ejecutada: ' . $this->db->last_query());

					// **Enviar notificación por email**
					$query = $this->db->query(
						"
						SELECT nombre_novio, nombre_novia, fecha_boda FROM clientes 
						WHERE id = ?",
						array($id_cliente)
					);

					if ($query->num_rows() > 0) {
						$fila = $query->row();
						$mensaje = '
							<table border="0" width="100%">
								<tr>
									<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/logo_intranet.png" width="200"></td>
									<td align="justify">
										<p>¡¡Hola!!</p>
										<p>Se ha actualizado la encuesta respecto a la boda de ' .
							htmlspecialchars($fila->nombre_novio) . ' y ' .
							htmlspecialchars($fila->nombre_novia) . ' que se casan el día ' .
							htmlspecialchars($fila->fecha_boda) . '.</p>
										<p>Atentamente Administración EXEL Eventos</p>
									</td>
								</tr>
							</table>';

						// **Descomentar si deseas enviar email**
						// $this->enviar_mail("IntraBoda - Actualización de encuesta respecto a la boda", $mensaje);
					}
				}
			}

			// Obtener datos del cliente
			$data['cliente'] = $this->cliente_functions->GetCliente($this->session->userdata('user_id'));

			// Deserializar `servicios` y asegurar compatibilidad con el formato antiguo
			$arr_servicios = !empty($data['cliente']['servicios']) ? unserialize($data['cliente']['servicios']) : [];

			foreach ($arr_servicios as $id => $valor) {
				// Si el formato es antiguo (solo precios), convertirlo a nuevo
				if (!is_array($valor)) {
					$arr_servicios[$id] = array(
						'precio' => floatval($valor),
						'descuento' => 0
					);
				}
			}

			// Guardamos los servicios corregidos en `$data['cliente']['servicios']`
			$data['cliente']['servicios'] = $arr_servicios;

			$arr_serv_keys = array_keys($arr_servicios);

			if (!empty($arr_serv_keys)) {
				$ids = implode(",", array_map('intval', $arr_serv_keys)); // Asegurar que son números

				$data['servicios'] = $this->cliente_functions->GetServicios($ids);

				if (empty($data['servicios'])) {
					$data['servicios'] = []; // Evita el error en la vista
				} else {
				}
			} else {
				$data['servicios'] = [];
			}


			// Cargar otros datos necesarios
			$data['preguntas_encuesta_datos_boda'] = $this->cliente_functions->GetPreguntasEncuestaDatosBoda();
			$data['opciones_respuestas_encuesta_datos_boda'] = $this->cliente_functions->GetOpcionesRespuestasEncuestaDatosBoda();
			$data['respuesta_cliente'] = $this->cliente_functions->GetRespuestasEncuestaDatosBoda($this->session->userdata('user_id'));
			$data['pagos'] = $this->cliente_functions->GetPagos($this->session->userdata('user_id'));
			$data['dj'] = $this->cliente_functions->GetDjAsignado($this->session->userdata('user_id'));
			$cliente_id = $this->session->userdata('user_id');
			$cliente = $this->cliente_functions->GetClientePorID($cliente_id);
			$oficina = $this->cliente_functions->GetNumeroCuentaOficina($cliente['id_oficina']);

			$data['cliente'] = $cliente;
			$data['numero_cuenta'] = $oficina ? $oficina['numero_cuenta'] : '';
		}

		if (isset($_POST['crear_invitado'])) {
			$username = trim($_POST['nuevo_username']);
			$clave = $_POST['nuevo_clave']; // Se usará para enviar por email
			$email = trim($_POST['nuevo_email']);
			$expiracion = !empty($_POST['nuevo_expiracion']) ? $_POST['nuevo_expiracion'] : null;

			if ($expiracion && strtotime($expiracion) < strtotime(date('Y-m-d'))) {
				$this->session->set_flashdata('msg_invitado', 'La fecha de expiración no puede ser anterior a hoy.');
				redirect($_SERVER['HTTP_REFERER']);
			}

			$id_cliente = $this->session->userdata('user_id');
			$this->load->database();
			$this->load->library('encrypt');

			// Verificar duplicado
			$this->db->where('email', $email);
			$this->db->where('id_cliente', $id_cliente);
			$existe = $this->db->get('invitado')->num_rows();

			if ($existe > 0) {
				$this->session->set_flashdata('msg_invitado', 'Ese email ya está registrado por ti.');
				redirect($_SERVER['HTTP_REFERER']);
			}

			// Cifrar para almacenar de forma reversible
			$clave_encriptada = $this->encrypt->encode($clave);

			$data_insert = array(
				'id_cliente' => $id_cliente,
				'username' => $username,
				'clave' => $clave_encriptada,
				'email' => $email,
				'fecha_expiracion' => $expiracion,
				'valido' => 1
			);

			if ($this->db->insert('invitado', $data_insert)) {

				// Si se pidió enviar email
				if (isset($_POST['enviar_email'])) {
					$from = 'noreply@exeleventos.com';
					$to = [$email];
					$subject = 'Tu acceso como invitado a Exel Eventos';
					$clave_plana = $this->encrypt->decode($clave_encriptada); // Recuperamos

					$message = "
					<div style='font-family:Segoe UI, sans-serif; background-color:#f9f9f9; padding:20px; border-radius:10px; max-width:600px; margin:auto; color:#333;'>
						<div style='background-color:#93CE37; padding:15px 20px; border-radius:8px 8px 0 0; color:white; font-size:18px; font-weight:bold;'>
							¡Bienvenido a Exel Eventos!
						</div>
				
						<div style='padding:20px; background:white; border-radius:0 0 8px 8px; box-shadow:0 2px 8px rgba(0,0,0,0.05);'>
							<p style='font-size:16px; margin-bottom:20px;'>Han creado una cuenta de <strong>invitado</strong> para que puedas acceder al sistema de gestión de eventos.</p>
				
							<table style='width:100%; font-size:15px; margin-bottom:20px;'>
								<tr>
									<td style='padding:8px 0;'><strong>Usuario:</strong></td>
									<td style='padding:8px 0;'>$username</td>
								</tr>
								<tr>
									<td style='padding:8px 0;'><strong>Contraseña:</strong></td>
									<td style='padding:8px 0;'>$clave</td>
								</tr>
							</table>
				
							<p style='font-size:15px; margin-bottom:20px;'>
								Entra ya a tu perfil de invitado de 
								<a href='https://intranet.exeleventos.com/invitado/login' target='_blank' style='color:#93CE37; text-decoration:none; font-weight:bold;'>INTRABODA</a>
							</p>
				
							<p style='font-size:13px; color:#777;'>
								Este acceso podría tener una fecha de expiración establecida. Si tienes dudas, contacta con el organizador del evento.
							</p>
						</div>
					</div>
				";

					$this->sendEmail($from, $to, $subject, $message);
				}

				redirect('cliente/invitados', 'location');
			} else {
				$this->session->set_flashdata('msg_invitado', "Error al guardar el invitado.");
				redirect($_SERVER['HTTP_REFERER']);
			}
		}




		// Cargar la vista con los datos
		$this->_loadViews($data_header, $data, $data_footer, "cliente_details");
	}

	public function chat()
	{
		$data_header = false;
		$data_footer = false;
		$data = false;
	
		$this->load->database();
	
		$id_cliente = $this->session->userdata('user_id');
	
		if ($_POST && isset($_POST['mensaje']) && trim($_POST['mensaje']) != '') {
			$mensaje = $this->input->post('mensaje');
	
			// Insertar mensaje en base de datos
			$this->db->query("
				INSERT INTO contacto (id_cliente, usuario, id_usuario, mensaje, fecha)
				VALUES (?, 'cliente', ?, ?, NOW())
			", [$id_cliente, $id_cliente, $mensaje]);
	
			// Recuperar emails de oficina y DJ
			$cliente = $this->db->query("
				SELECT dj, id_oficina 
				FROM clientes 
				WHERE id = ?
			", [$id_cliente])->row();
	
			if ($cliente) {
				$from = 'info@exeleventos.com';
				$subject = "Nuevo mensaje del cliente en el chat de coordinación";
				$mensaje_usuario = $mensaje;
	
				// Enviar email al DJ
				if ($cliente->dj) {
					$dj = $this->db->query("SELECT email FROM djs WHERE id = ?", [$cliente->dj])->row();
					if ($dj && !empty($dj->email)) {
						$boton_url_dj = "https://intranet.exeleventos.com/dj/dj_chat/" . $id_cliente;
						$boton_url_admin = "https://intranet.exeleventos.com/admin/admin_chat/" . $id_cliente;
	
						$mensaje_email_dj = "
	<div style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto;'>
		<h2 style='color: #25d366;'>¡Nuevo mensaje de un cliente!</h2>
		<p>Hola,</p>
		<p>Un cliente ha enviado el siguiente mensaje a través del chat de coordinación:</p>
		<blockquote style='background: #d4edda; padding: 15px; border-left: 5px solid #25d366; margin: 20px 0; font-style: italic;'>
			{$mensaje_usuario}
		</blockquote>
		<p>Podéis responder accediendo a la intranet haciendo clic en el siguiente botón:</p>
		<div style='text-align: center; margin: 30px 0;'>
			<a href='{$boton_url_dj}' style='background-color: #25d366; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold;'>Ir al chat como DJ</a>
			<a href='{$boton_url_admin}' style='background-color:rgb(0, 146, 54); color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold;'>Ir al chat como ADMIN</a>
			</div>
		<p>Un saludo,<br><strong>Equipo de Exel Eventos</strong></p>
	</div>
	";
						$this->sendEmail($from, [$dj->email], $subject, $mensaje_email_dj);
					}
				}
	
				// Enviar email al Coordinador
				if ($cliente->id_oficina) {
					$oficina = $this->db->query("SELECT email FROM oficinas WHERE id_oficina = ?", [$cliente->id_oficina])->row();
					if ($oficina && !empty($oficina->email)) {
						$boton_url_admin = "https://intranet.exeleventos.com/admin/admin_chat/" . $id_cliente;
	
						$mensaje_email_admin = "
	<div style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto;'>
		<h2 style='color: #25d366;'>¡Nuevo mensaje de un cliente!</h2>
		<p>Hola,</p>
		<p>Un cliente ha enviado el siguiente mensaje a través del chat de coordinación:</p>
		<blockquote style='background: #d4edda; padding: 15px; border-left: 5px solid #25d366; margin: 20px 0; font-style: italic;'>
			{$mensaje_usuario}
		</blockquote>
		<p>Podéis responder accediendo a la intranet haciendo clic en el siguiente botón:</p>
		<div style='text-align: center; margin: 30px 0;'>
			<a href='{$boton_url_admin}' style='background-color: #25d366; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold;'>Ir al chat</a>
		</div>
		<p>Un saludo,<br><strong>Equipo de Exel Eventos</strong></p>
	</div>
	";
						$this->sendEmail($from, [$oficina->email], $subject, $mensaje_email_admin);
					}
				}
			}
	
			// Redirigir después de enviar
			redirect('cliente/chat');
		}
	
		// Obtener mensajes
		$data['mensajes_contacto'] = $this->cliente_functions->GetMensajesContacto($id_cliente);
		$data['nombre_chat'] = $this->cliente_functions->GetTituloChat($id_cliente);
	
		// Obtener fotos
		$cliente = $this->db->query("SELECT foto, dj FROM clientes WHERE id = ?", [$id_cliente])->row();
	
		if ($cliente && !empty($cliente->foto)) {
			$data['foto_cliente'] = base_url() . 'uploads/foto_perfil/' . $cliente->foto;
		} else {
			$data['foto_cliente'] = base_url() . 'uploads/desconocido.jpg';
		}
	
		$dj = null;
		if ($cliente && $cliente->dj) {
			$dj = $this->db->query("SELECT nombre, foto FROM djs WHERE id = ?", [$cliente->dj])->row();
		}
	
		if ($dj && !empty($dj->foto)) {
			$data['foto_dj'] = base_url() . 'uploads/djs/' . $dj->foto;
		} else {
			$data['foto_dj'] = base_url() . 'uploads/desconocido.jpg';
		}
	
		$data['foto_coordinador'] = base_url() . 'img/logo.jpg'; // o 'uploads/desconocido.jpg'
	
		// Cargar la vista
		$this->_loadViews($data_header, $data, $data_footer, "chat");
	}
	


	public function canciones()
	{
		$data_header = false;
		$data_footer = false;
	
		if ($_POST) {
			if (isset($_POST['add_moment']))
				$this->cliente_functions->InsertEvent($_POST['nombre_moment'], $this->session->userdata('user_id'));
	
			if (isset($_POST['add_song']))
				$this->cliente_functions->InsertCancion($_POST, $this->session->userdata('user_id'));
	
			if (isset($_POST['add_comentario']))
				$this->cliente_functions->InsertCancionComentario($_POST['momento_id'], $_POST['comentario'], $this->session->userdata('user_id'));

			// 🚀 Manejar formulario de Spotify
			if (!empty($_POST['playlist_id'])) {
				$url = $_POST['playlist_id'];
				$url_sin_params = strtok($url, '?'); // Elimina ?si=...
				
				if (preg_match('/playlist\/([a-zA-Z0-9]+)/', $url_sin_params, $matches)) {
					$playlist_id = $matches[1];
			
					$this->load->model('Spotify_model');
					$data['canciones_spotify'] = $this->Spotify_model->obtener_canciones_playlist($playlist_id);
					$data['playlist_id'] = $url; // Para mostrar en el input si quieres
				} else {
					$data['error_playlist'] = "Enlace de Spotify no válido.";
				}
			}

			if (isset($_POST['accion'])) {
				if ($_POST['accion'] == 'sumar') {

					$this->load->model('Spotify_model');
					$data['sumar'] = $this->Spotify_model->sumar_playList();

				} elseif ($_POST['accion'] == 'restar'){

				}
			}
		}
	
		$data['cliente'] = $this->cliente_functions->GetCliente($this->session->userdata('user_id'));
		$data['events'] = $this->cliente_functions->GetEvents($this->session->userdata('user_id'));
		$data['events_user'] = $this->cliente_functions->GetmomentosUser($this->session->userdata('user_id'));
		$data['canciones_user'] = $this->cliente_functions->GetcancionesUser($this->session->userdata('user_id'));
		$data['canciones_observaciones_momesp'] = $this->cliente_functions->GetObservaciones_momesp($this->session->userdata('user_id'));
		$data['canciones_observaciones_general'] = $this->cliente_functions->GetObservaciones_general($this->session->userdata('user_id'));
		$data['dj_asignado'] = $this->cliente_functions->GetDJAsignado($this->session->userdata('user_id'));

		$str_mail = "Lista de canciones de usuario: " . $this->session->userdata('nombre_novia') . "(" . $this->session->userdata('email_novia') . ") & " . $this->session->userdata('nombre_novio') . "(" . $this->session->userdata('email_novio') . ")<br/><br/><br/>";
		if (isset($_POST['send_todj'])) {
			foreach ($data['events_user'] as $eu) {
				$str_mail .= "<h3>" . $eu['nombre'] . "</h3><ul>";
				foreach ($data['canciones_user'] as $c) {
					if ($eu['momento_id'] == $c['momento_id']) {
						$str_mail .= "<li>" . $c['nombre'] . "</li>";
					}
				}
				$str_mail .= "</ul>";
			}


			$str_mail .= "<br/><br/><h3>Observaciones</h3><br/>";
			if (!$data['canciones_observaciones_general'] && !$data['canciones_observaciones_momesp']) {
				$str_mail .= "<p>No hay observaciones</p>";
			} else {

				if ($data['canciones_observaciones_general']) {
					$str_mail .= "<ul>";
					foreach ($data['canciones_observaciones_general'] as $c) {
						$str_mail .= "<li>" . $c['comentario'] . " (escrito el " . $c['fecha'] . ")</li>";
					}
					$str_mail .= "</ul>";
				}

				if ($data['canciones_observaciones_momesp']) {
					$momentos_ids = array();
					foreach ($data['canciones_observaciones_momesp'] as $c) {
						$momentos_ids[] = $c['momento_id'];
					}


					foreach ($data['events_user'] as $eu) {
						if (in_array($eu['momento_id'], $momentos_ids, true)) {
							$str_mail .= "<h3>" . $eu['nombre'] . "</h3><ul>";
						}
						foreach ($data['canciones_observaciones_momesp'] as $c) {
							if ($eu['momento_id'] == $c['momento_id']) {

								$str_mail .= "<li>" . $c['comentario'] . " (escrito el " . $c['fecha'] . ")</li>";
							}
						}

						if (in_array($eu['momento_id'], $momentos_ids, true)) $str_mail .= "</ul>";
					}
				}
			}

			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$cabeceras .= 'From: info@exeleventos.com';

			foreach ($data['dj_asignado'] as $dj) {
				$email_dj = $dj['email'];
			}

			//$send = mail($email_dj, "Lista de canciones", $str_mail, $cabeceras);
			//$send = mail("info@exeleventos.com", "Lista de canciones", $str_mail, $cabeceras); //Copia del listado para info@exeleventos.com
			$this->sendEmail('info@exeleventos.com', [$email_dj, 'info@exeleventos.com'], "Lista de canciones", $str_mail);
		}

		$this->_loadViews($data_header, $data, $data_footer, "canciones");
	}

	public function galerias()
	{
		$data_header = false;
		$data = false;
		$data_footer = false;



		if ($_POST) {
			$this->load->database();

			/*string para la url de la galeria para que no se pueda ver otras galeria por accidente*/
			$auth_code = "";
			$chars = "abcdefghijklmnopqrstuvwxwz0123456789";
			for ($i = 0; $i <= 10; $i++) {
				$rand_key = mt_rand(0, strlen($chars));
				$auth_code  .= substr($chars, $rand_key, 1);
			}

			$arr = array("client_id" => $this->session->userdata('user_id'), "nombre" => $_POST['nombre'], "auth_code" => $auth_code);
			$this->db->insert('galeria', $arr);
			$id_gallery = $this->db->insert_id();

			mkdir("./uploads/gallery/" . $id_gallery, 0777);
			mkdir("./uploads/gallery/" . $id_gallery . "/orginal", 0777);
			mkdir("./uploads/gallery/" . $id_gallery . "/thumbs", 0777);
		}
		$data['galerias'] =  $this->cliente_functions->GetGaleria($this->session->userdata('user_id'));
		$this->_loadViews($data_header, $data, $data_footer, "galerias");
	}
	public function galeria($id = false, $start = 0)
	{
		$data = array(
			'dir' => array(
				'original' => './uploads/gallery/' . $id . '/orginal/',
				'thumb' => './uploads/gallery/' . $id . '/thumbs/'
			),
			'total' => 0,
			'images' => array(),
			'error' => '',
			'id' => $id
		);

		$data_header = false;

		$data_footer = false;

		if ($this->input->post('btn_upload')) {
			$data['error'] = $this->upload($data);
		}


		$this->load->library('pagination');

		$c_paginate['base_url'] = base_url() . 'cliente/galeria/' . $id;
		$c_paginate['per_page'] = '6';
		$finish = $start + $c_paginate['per_page'];

		if (is_dir($data['dir']['thumb'])) {
			$i = 0;

			if ($dh = opendir($data['dir']['thumb'])) {

				while (($file = readdir($dh)) !== false) {
					if ($file != '.' && $file != '..') {
						//echo $file;
						// get file extension
						$ar_file = explode(".", $file);
						$ext = end($ar_file);
						//$ext = strrev(strstr(strrev($file), ".", TRUE));
						if ($ext == 'jpg' || $ext == 'JPG' || $ext == 'jpeg') {
							if ($start <= $data['total'] && $data['total'] < $finish) {
								$data['images'][$i]['thumb'] = $file;
								$data['images'][$i]['original'] = str_replace('thumb_', '', $file);
								$i++;
							}
							$data['total']++;
						}
					}
				}
				closedir($dh);
			}
		}

		$c_paginate['total_rows'] = $data['total'];

		$this->pagination->initialize($c_paginate);

		$this->_loadViews($data_header, $data, $data_footer, "gallery");
	}
	private function upload($data)
	{
		$error = false;
		$c_upload['upload_path']    = $data['dir']['original'];
		$c_upload['allowed_types']  = 'JPG|jpg|jpeg';
		$c_upload['max_size']       = '3000';
		//$c_upload['max_width']      = '1600';
		//$c_upload['max_height']     = '1200';
		$c_upload['remove_spaces']  = TRUE;

		$this->load->library('upload', $c_upload);

		if ($this->upload->do_upload('userfile')) {

			$img = $this->upload->data();
			// print_r($img);

			/*if($img['image_width'] > '1600'){
				$img_lib = array(
                'image_library'     => 'gd2',
                'source_image'      => $img['full_path'],
               // 'maintain_ratio'    => TRUE,
                'width'             => 1600,
                //'height'            => 1600,
                'new_image'         => $img['full_path']
            	);
				$this->load->library('image_lib', $img_lib);
            	$this->image_lib->resize();	
			}*/


			// create thumbnail
			$new_image = $data['dir']['thumb'] . 'thumb_' . $img['file_name'];

			$c_img_lib = array(
				'image_library'     => 'gd2',
				'source_image'      => $img['full_path'],
				'maintain_ratio'    => TRUE,
				'width'             => 150,
				'height'            => 150,
				'new_image'         => $new_image
			);

			$this->load->library('image_lib', $c_img_lib);
			$this->image_lib->resize();
		} else {
			$error = $this->upload->display_errors();
		}
		return $error;
	}

	public function delete($id, $ori_img)
	{

		unlink('./uploads/gallery/' . $id . '/orginal/' . $ori_img);
		unlink('./uploads/gallery/' . $id . '/thumbs/thumb_' . $ori_img);
		redirect('cliente/galeria/' . $id);
	}
	public function ofertas()
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		if (isset($_POST['servicios'])) {
			////////CON ESTA FUNCION SE ACTUALIZAN LOS SERVICIOS DEL CLIENTE QUE HA SELECCIONADO
			///////EN OFERTAS (NO FUNCIONA PORQUE LOS SERVICIOS ESTÁN SIN SERIALIZAR)
			$this->load->database();
			//COMENTO LA ACTUALIZACION DE LA BASE DE DATOS PORQUE ESTÁ SIN SERIALIZAR
			//$this->db->query("UPDATE clientes SET servicios = CONCAT(servicios, ',', '".implode(",", $_POST['servicios'])."') WHERE id = ".$this->session->userdata('user_id')."");
			$data['msg'] = "Los servicios se han actualizado con &eacute;xito";

			$mensaje = "Usuario " . $this->session->userdata('nombre_novia') . " (" . $this->session->userdata('email_novia') . ") & " . $this->session->userdata('nombre_novio') . " (" . $this->session->userdata('email_novio') . " ha a&ntilde;adido nuevos servicios.";
			//$this->enviar_mail("IntraBoda - Nuevos servicios", $mensaje);

		}
		$data['servicios'] = $this->cliente_functions->GetAvailableServicios($this->session->userdata('user_id'));
		$this->_loadViews($data_header, $data, $data_footer, "ofertas");
	}
	function _loadViews($data_header, $data, $data_footer, $view)

	{

		$this->load->view('cliente/header', $data_header);

		$this->load->view('cliente/' . $view, $data);

		$this->load->view('cliente/footer', $data_footer);
	}
	public function is_logged_in()
	{
		$user = $this->session->userdata('user_id');
		return isset($user);
	}
	function enviar_mail($asunto, $mensaje)
	{
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'From: info@exeleventos.com';
		$this->sendEmail('info@exeleventos.com', ["info@exeleventos.com"], $asunto, $mensaje);
	}

	private function sendEmail($from, $to, $subject, $message)
	{
		try {

			$this->config->load('mailconfig');
			$this->load->library('PHPMailer_Lib');
			$mail = $this->phpmailer_lib->load();
			$mail->isSMTP();
			$mail->Host = $this->config->item('host');
			$mail->SMTPAuth = $this->config->item('smtpauth');
			$mail->Username = $this->config->item('username');
			$mail->Password = $this->config->item('password');
			$mail->SMTPSecure = $this->config->item('smtpsecure');
			$mail->Port = $this->config->item('port');
			$mail->isHTML(true);
			$mail->CharSet = 'UTF-8';
			$mail->setFrom($from, 'Exel Eventos');
			$mail->addReplyTo($from, 'Exel Eventos');
			// Add a recipient
			if (filter_var($to[0], FILTER_VALIDATE_EMAIL)) {
				$mail->addAddress($to[0]);
			} else {
				error_log("Email invalido " . var_export($to, 1), 3, "./r");
			}
			// Add cc or bcc
			for ($i = 1; $i < count($to) - 1; $i++) {
				if (filter_var($to[$i], FILTER_VALIDATE_EMAIL)) {
					$mail->addCC($to[$i]);
				}
			}

			/* $mail->addBCC('bcc@example.com'); */
			error_log("VAmos a enviar un email a " . var_export($to, 1), 3, "./r");
			// Email subject
			$mail->Subject = $subject;
			// Set email format to HTML
			$mail->isHTML(true);
			// Email body content

			$mail->Body = $message;
			// Send email
			if (!$mail->send()) {
				error_log("\r\n Message could not be sent.'Mailer Error: " . $mail->ErrorInfo . "\r\n", 3, "./r");
			}
		} catch (Exception $e) {
			error_log("Algún tipo de error al enviar el correo " . var_export($e, 1), 3, "./r");
		}
	}


}
