<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Comercial extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		//$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('comercial_functions');
		$this->load->database(); // Ensure the database library is loaded
		if (!$this->session->userdata('id') && $this->router->method != 'login') {
			redirect('comercial/login');
		}
		//echo $this->session->userdata('admin');
	}
	/*public function index($a = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
				
		$this->_loadViewsHome($data_header, $data, $data_footer);
	}*/
	public function index()
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		$this->_loadViews($data_header, $data, $data_footer, "home");
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('comercial', 'location');
	}

	public function login()
	{
		$data = false;

		if ($_POST) {
			$arr_userdata = $this->comercial_functions->ComercialLogin($_POST['email'], $_POST['pass']);
			if ($arr_userdata) {
				$this->session->set_userdata($arr_userdata);
				redirect('comercial', 'location');
			} else {
				$data['msg'] = 'Login o contrase&ntilde;a incorrecto';
			}
		}
		$this->load->view('comercial/login', $data);
	}

	public function CrearNumeroPresupuesto()
	{
		//$anio_actual = "26";
		$anio_actual = date('y');

		$this->load->database();
		$query = $this->db->query("SELECT n_presupuesto FROM solicitudes WHERE n_presupuesto LIKE '$anio_actual/%' ORDER BY CAST(SUBSTRING_INDEX(n_presupuesto, '/', -1) AS UNSIGNED) DESC LIMIT 1");

		$ultimo_presupuesto = null;

		if ($query->num_rows() > 0) {
			$row = $query->row();
			$ultimo_presupuesto = $row->n_presupuesto;
		}

		if (!$ultimo_presupuesto) {
			$n_presupuesto = $anio_actual . "/0001";
		} else {
			list(, $ultimo_numero) = explode("/", $ultimo_presupuesto);
			$ultimo_numero++;
			$n_presupuesto = $anio_actual . "/" . str_pad($ultimo_numero, 4, "0", STR_PAD_LEFT);
		}

		return $n_presupuesto;
	}




	function solicitudes($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		if ($acc == 'add') {
			$data['captacion'] = $this->comercial_functions->GetCaptacion();
			$data['estados_solicitudes'] = $this->comercial_functions->GetEstados_Solicitudes();
			$data['n_presupuesto'] = $this->CrearNumeroPresupuesto();

			if ($_POST) {
				$data['n_presupuesto'] = $_POST['n_presupuesto'];
				$data['email'] = $_POST['email'];
				$data['nombre'] = $_POST['nombre'];
				$data['apellidos'] = $_POST['apellidos'];
				$data['direccion'] = $_POST['direccion'];
				$data['cp'] = $_POST['cp'];
				$data['poblacion'] = $_POST['poblacion'];
				$data['telefono'] = $_POST['telefono'];
				$data['fecha_boda'] = $_POST['fecha_boda'] . " " . $_POST["hora_boda"];
				$data['restaurante'] = $_POST['restaurante'];
				$data['canal_captacion'] = $_POST['canal_captacion'];
				$data['estado_solicitud'] = $_POST['estado_solicitud'];
				$data['id_comercial'] = $this->session->userdata('id');

				$data['importe'] = str_replace(',', '.', $_POST['importe']);
				$data['descuento'] = str_replace(',', '.', $_POST['descuento']);

				$id_solicitud = $this->comercial_functions->InsertSolicitud($data);

				if ($_POST['enviar_encuesta'] == "S") {
					$this->enviar_email_encuesta($data['id_comercial'], $id_solicitud, html_entity_decode($_POST['email']));
				}

				redirect('comercial/solicitudes/view');
			}
		}

		if ($acc == 'view') {
			$this->load->database();
			if ($id) {
				if ($_POST) {
					if (isset($_POST['update_canal_captacion'])) {
						$this->db->query("UPDATE solicitudes SET canal_captacion = '" . $_POST['canal_captacion'] . "' WHERE id_solicitud = {$id}");
					}

					if (isset($_POST['update_estado_solicitud'])) {
						$this->db->query("UPDATE solicitudes SET estado_solicitud = '" . $_POST['estado_solicitud'] . "' WHERE id_solicitud = {$id}");
					}

					if (isset($_POST['add_observ'])) {
						$this->db->query("INSERT INTO observaciones_solicitudes (id_solicitud, id_comercial, comentario) VALUES ({$id}, " . $this->session->userdata('id') . ", '" . str_replace("'", "''", $_POST['observaciones']) . "')");
					}

					if (isset($_POST['mandar_encuesta']) && $_POST['mandar_encuesta'] == 'S') {
						$this->enviar_email_encuesta($this->session->userdata('id'), $id, html_entity_decode($_POST['email']));
					}

					if (isset($_POST['add_llamada'])) {
						$this->db->query("INSERT INTO llamadas_solicitudes (id_solicitud, id_comercial, observaciones, proxima_llamada) VALUES ({$id}, " . $this->session->userdata('id') . ", '" . str_replace("'", "''", $_POST['observaciones_llamada']) . "', '" . $_POST['fecha_prox_llamada'] . "')");
					}
				}
				$data['captacion'] = $this->comercial_functions->GetCaptacion();
				$data['estados_solicitudes'] = $this->comercial_functions->GetEstados_Solicitudes();
				$data['solicitud'] = $this->comercial_functions->GetSolicitud($id);
				$data['observaciones_solicitud'] = $this->comercial_functions->GetObservaciones_Solicitud($id);
				$data['encuesta_solicitud'] = $this->comercial_functions->GetEncuesta_Solicitud($id);
				$data['llamadas_solicitud'] = $this->comercial_functions->GetLLamadas_Solicitud($id);
				$acc = "viewdetails";
			} else {
				$str_where = "";

				if (isset($_GET['p']))
					$data['page'] = $_GET['p'];
				else
					$data['page'] = 1;

				if (isset($_GET['q'])) {
					if ($_GET['f'] == 'fecha_boda') {
						$date = strtotime($_GET['q']);
						$str_where = "WHERE DATE(" . $_GET['f'] . ") = '" . date('Y-m-d', $date) . "'";
					} else {
						$str_where = "WHERE " . $_GET['f'] . " LIKE '%" . $_GET['q'] . "%'";
					}
				}

				if (isset($_GET['estado_solicitud']) && $_GET['estado_solicitud'] <> "") {
					$str_where .= $str_where == "" ? " WHERE estado_solicitud = " . $_GET['estado_solicitud'] : " AND estado_solicitud = " . $_GET['estado_solicitud'];
				}

				$query = $this->db->query("SELECT id_solicitud FROM solicitudes {$str_where}");
				$data['num_rows'] = $query->num_rows();

				$data['rows_page'] = 15;
				$data['last_page'] = ceil($data['num_rows'] / $data['rows_page']);

				$data['page'] = (int)$data['page'];
				if ($data['page'] > $data['last_page']) $data['page'] = $data['last_page'];
				if ($data['page'] < 1) $data['page'] = 1;

				$limit = 'LIMIT ' . ($data['page'] - 1) * $data['rows_page'] . ',' . $data['rows_page'];

				$ord = "fecha";
				if (isset($_GET['ord']) && $_GET['ord'] != '') $ord = $_GET['ord'];

				$data['solicitudes'] = $this->comercial_functions->GetSolicitudes($str_where, $ord, $limit);
				$data['estados_solicitudes'] = $this->comercial_functions->GetEstados_Solicitudes();
			}
		}

		$view = "solicitudes_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}



	public function enviar_email_encuesta($id_comercial, $id_solicitud, $email)
	{
		$query2 = $this->db->query("SELECT id_oficina, nombre FROM comerciales WHERE id = " . $id_comercial . "");
		foreach ($query2->result() as $fila2) {
			$nombre_comercial = $fila2->nombre;
			$id_oficina_comercial = $fila2->id_oficina;
		}

		$query3 = $this->db->query("SELECT nombre, direccion, poblacion, cp, telefono, movil, email, web, logo_mail FROM oficinas WHERE id_oficina = '" . $id_oficina_comercial . "'");
		foreach ($query3->result() as $fila3) {
			$nombre_oficina_comercial = $fila3->nombre;
			$direccion_oficina_comercial = $fila3->direccion;
			$poblacion_oficina_comercial = $fila3->poblacion;
			$cp_oficina_comercial = $fila3->cp;
			$telefono_oficina_comercial = $fila3->telefono;
			$movil_oficina_comercial = $fila3->movil;
			$email_oficina_comercial = $fila3->email;
			$web_oficina_comercial = $fila3->web;
			$logo_mail_oficina_comercial = $fila3->logo_mail;
		}

		$query3 = $this->db->query("SELECT SUM(importe_descuento) as descuento FROM preguntas_encuesta");
		foreach ($query3->result() as $fila3) {
			$descuento = $fila3->descuento;
		}


		$local = 'http://' . $_SERVER['HTTP_HOST'] . base_url();

		$html = '<html>
						<head>
						<link href="' . $local . 'css/style.css" rel="stylesheet" type="text/css" />
						</head>
						
						<body>
						<table width="100%">
						<tr>
							<td colspan="2">
								<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
							</td>
						</tr>
										  <tr>
											<td width="40%">
												<table width="100%" border="0" style="border-collapse:collapse;">
														<tr><td><strong>&#161;Haz tu día el día de todos&#33;</strong></td>
														</tr>
														<tr>
														  <td>&nbsp;</td>
												  </tr>
														<tr>
														  <td>Comercial: ' . $nombre_comercial . '</td>
												  </tr>
														<tr>
														  <td>
														' . $direccion_oficina_comercial . '</td>
														</tr>
														<tr><td>
														' . $cp_oficina_comercial . ', ' . $poblacion_oficina_comercial . '
														</tr>
														<tr>
														  <td>Teléfono oficina: ' . $telefono_oficina_comercial . '</td>
														</tr>
														<tr>
														  <td>Teléfono móvil: ' . $movil_oficina_comercial . '</td>
														</tr>
														<tr><td>
														<a href="' . $web_oficina_comercial . '" target="_blank">' . $web_oficina_comercial . '</a></td>
														</tr>
														<tr>
														  <td><a href="mailto:' . $email_oficina_comercial . '" target="_blank">' . $email_oficina_comercial . '</a></td>
														</tr>
												</table>
											 </td>
											 <td align="justify">
											 	<b>¡Gracias por solicitar presupuesto! Consigue hasta <font color="#0000FF"><b>' . $descuento . '&euro;</b></font> de descuento adicional en tu presupuesto rellenando esta sencilla encuesta. Sólo te llevará unos minutos:</b><br><br>
											<center><a href="' . $local . '/informes/encuesta.php?id_solicitud=' . $id_solicitud . '&email=' . $email . '"><img src="' . $local . '/img/logos_mail/btn_realizar_encuesta.jpg" alt="Realizar encuesta"></a></center>
											 </td>									 
										
										  </tr>
							<tr>
								<td align="center" colspan="2"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
							</tr>
						  </table></body></html>';


		$asunto = 'Encuesta para descuento sobre el presupuesto de ' . $nombre_oficina_comercial;

		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$cabeceras .= 'From: ' . $email_oficina_comercial . '';
		//mail($email, $asunto, $html, $cabeceras);
		$this->sendEmail('info@exeleventos.com', [$email], $asunto, $html);
	}

	public function estadisticas()
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		$hoy = date("Y-m-d");
		$fecha_desde = strtotime('-30 day', strtotime($hoy));
		$fecha_desde = date('Y-m-d', $fecha_desde);
		$fecha_hasta = date("Y-m-d");

		if ($_POST) {
			if ($_POST["fecha_desde"] <> "") {
				$fecha_desde = $_POST["fecha_desde"];
			}
			if ($_POST["fecha_hasta"] <> "") {
				$fecha_hasta = $_POST["fecha_hasta"];
			}
		}

		$data['porcentaje_contratacion'] = $this->comercial_functions->GetPorcentajeContratacion($fecha_desde, $fecha_hasta, $this->session->userdata('id'));
		$data['fecha_desde'] = $fecha_desde;
		$data['fecha_hasta'] = $fecha_hasta;


		$data['charts'] = $this->comercial_functions->GraficoPorcentajeContratacion($fecha_desde, $fecha_hasta, $this->session->userdata('id'));
		$data['charts'] = $this->highcharts->render();
		//$this->load->view('charts', $data);



		$view = "estadisticas";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}


	function emails_enviados($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		$this->load->database();

		$this->db->select('
        emails_enviados.id,
		emails_automaticos.id AS id_email,
        emails_automaticos.asunto AS asunto_email,
        solicitudes.nombre AS nombre_solicitante,
        solicitudes.apellidos AS apellido_solicitante,
        comerciales.nombre AS nombre_comercial,
        emails_enviados.fecha_envio
    ');
		$this->db->from('emails_enviados');
		$this->db->join('emails_automaticos', 'emails_enviados.id_email = emails_automaticos.id', 'left');
		$this->db->join('solicitudes', 'emails_enviados.id_solicitud = solicitudes.id_solicitud', 'left');
		$this->db->join('comerciales', 'emails_enviados.id_comercial = comerciales.id', 'left');

		$query = $this->db->get();
		$data['emails_enviados'] = $query->result();

		// Cargar la vista con los datos
		$this->_loadViews($data_header, $data, $data_footer, "emails_enviados");
	}


	function emails($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		if ($acc == 'add' && $_POST) {
			$this->add_email();
			return;
		}

		if ($acc == 'delete') {
			$this->drop_email($id);
			return;
		}

		if ($acc == 'edit') {
			$this->edit_email($id);
			return;
		}

		if ($acc == '' || $acc == 'view') {
			$id_comercial = $this->session->userdata('id');
			log_message('info', "ID Comercial: " . $id_comercial);
			$this->load->database();
			$this->db->where('id_comercial', $id_comercial);
			$data['emails'] = $this->db->get('emails_automaticos')->result();
		}

		$this->_loadViews($data_header, $data, $data_footer, "emails");
	}

	private function add_email()
	{
		$this->load->database();

		if (empty($_POST['asunto']) || empty($_POST['cuerpo']) || empty($_POST['fecha_envio'])) {
			echo "Error: Todos los campos son obligatorios.";
			return;
		}

		$asunto = $this->input->post('asunto');
		$cuerpo = $this->input->post('cuerpo', false);
		$fecha_envio = $this->input->post('fecha_envio');
		$email_prueba = $this->input->post('email_prueba');
		$id_comercial = $this->session->userdata('id');


		// Manejo de la firma (JPG)
		$firma_nombre = "";
		if (!empty($_FILES['firma']['name'])) {
			$config['upload_path'] = './uploads/comerciales/firmas/';
			$config['allowed_types'] = 'jpg';
			$config['max_size'] = 2048; // 2MB máximo
			$config['file_name'] = time() . '_' . $_FILES['firma']['name'];

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('firma')) {
				$upload_data = $this->upload->data();
				$firma_nombre = $upload_data['file_name'];
			} else {
				echo "Error al subir la firma: " . $this->upload->display_errors();
				return;
			}
		}

		// Insertar en la base de datos
		$data_insert = array(
			'asunto' => $asunto,
			'cuerpo' => $cuerpo,
			'fecha_envio' => $fecha_envio,
			'firma' => $firma_nombre,
			'email_prueba' => $email_prueba,
			'id_comercial' => $id_comercial,
			'estado' => 'activo'
		);

		if ($this->db->insert('emails_automaticos', $data_insert)) {
			redirect('comercial/emails/view');
		} else {
			echo "Error al insertar el email.";
		}
	}

	function drop_email($id)
	{
		$this->load->database();
		$this->db->where('id', $id);
		$this->db->delete('emails_automaticos');
		redirect('comercial/emails/view');
	}

	function edit_email($id)
	{
		$this->load->database();

		// Si se envió el formulario (método POST), procesamos la actualización
		if ($_POST) {
			// Validar datos obligatorios
			if (empty($_POST['asunto']) || empty($_POST['cuerpo']) || empty($_POST['fecha_envio'])) {
				echo "Error: Todos los campos son obligatorios.";
				return;
			}

			$asunto = $this->input->post('asunto');
			$cuerpo = $this->input->post('cuerpo');
			$fecha_envio = $this->input->post('fecha_envio');

			// Obtener datos actuales para no perder la firma si no se sube una nueva
			$email_actual = $this->db->get_where('emails_automaticos', ['id' => $id])->row();
			$firma_nombre = $email_actual->firma;
			$email_prueba = $this->input->post('email_prueba');

			// Manejo de la firma (si se sube una nueva)
			if (!empty($_FILES['firma']['name'])) {
				$config['upload_path'] = './uploads/comerciales/firmas/';
				$config['allowed_types'] = 'jpg';
				$config['max_size'] = 2048; // 2MB máximo
				$config['file_name'] = time() . '_' . $_FILES['firma']['name'];

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('firma')) {
					$upload_data = $this->upload->data();
					$firma_nombre = $upload_data['file_name']; // Guardamos el nuevo nombre de la firma
				} else {
					echo "Error al subir la firma: " . $this->upload->display_errors();
					return;
				}
			}

			// Actualizar en la base de datos
			$data_update = array(
				'asunto' => $asunto,
				'cuerpo' => $cuerpo,
				'fecha_envio' => $fecha_envio,
				'firma' => $firma_nombre,
				'email_prueba' => $email_prueba
			);

			$this->db->where('id', $id);
			if ($this->db->update('emails_automaticos', $data_update)) {
				redirect('comercial/emails/view');
			} else {
				echo "Error al actualizar el email.";
			}
			return;
		}

		// Si no se envió el formulario, mostramos la vista con los datos actuales
		$data['email'] = $this->db->get_where('emails_automaticos', ['id' => $id])->row();
		$this->_loadViews($data_header, $data, $data_footer, "edit_email");
	}


	public function update_email_status()
	{
		$this->load->database();

		// REGISTRA LO QUE SE ESTÁ RECIBIENDO
		log_message('error', 'POST DATA: ' . json_encode($_POST));

		$id = $this->input->post('id');
		$estado = $this->input->post('estado');

		if (!isset($id) || !isset($estado)) {
			log_message('error', 'Faltan datos: ID=' . $id . ', Estado=' . $estado);
			echo json_encode(['success' => false, 'message' => 'Datos incorrectos']);
			return;
		}

		$this->db->where('id', $id);
		$success = $this->db->update('emails_automaticos', ["estado" => $estado]);

		if (!$success) {
			log_message('error', 'SQL ERROR: ' . $this->db->error()['message']);
		}

		echo json_encode(['success' => $success]);
	}

	public function enviarEmailsPendientes()
	{
		// Obtener los emails automáticos activos que deben enviarse hoy
		$emails = $this->comercial_functions->getEmailsParaEnviar();
		log_message('info', "Emails automáticos a enviar hoy: " . json_encode($emails));

		foreach ($emails as $email) {
			// Si tiene un email de prueba, enviar solo a ese email
			if (!empty($email->email_prueba)) {
				$this->enviarEmailAutomatico($email->email_prueba, $email, null);
				continue; // Pasar al siguiente email automático
			}

			// Si no tiene email de prueba, buscar clientes que deban recibirlo
			$clientes = $this->comercial_functions->getClientesPendientes($email->fecha_envio);
			log_message('info', "Clientes a los que enviar el email: " . json_encode($clientes));

			if (!empty($clientes)) {
				foreach ($clientes as $cliente) {
					$this->enviarEmailAutomatico($cliente->email, $email, $cliente);
					log_message('info', "Email enviado a {$cliente->email}");
				}
			}
		}
	}

	private function enviarEmailAutomatico($destinatario, $email, $cliente)
	{
		$from = $this->session->userdata('email_comercial');  // Email del comercial desde la sesión
		$id_comercial = $this->session->userdata('id');

		if (empty($from)) {
			log_message('error', "No se pudo obtener el email del comercial.");
			return;
		}

		log_message('info', "Email del comercial obtenido: " . $from);

		$subject = $email->asunto;
		$message = "<p>{$email->cuerpo}</p>";

		// Adjuntar la firma si existe
		$firma_path = "";
		if (!empty($email->firma)) {
			$firma_path = FCPATH . "uploads/comerciales/firmas/{$email->firma}";
		}

		// Enviar email y pasar la ruta de la firma
		if ($this->sendEmailAutomatico($from, $destinatario, $subject, $message, $firma_path)) {
			log_message('info', "Email automático enviado correctamente.");
			$this->comercial_functions->registrarEmailEnviado($email->id, $cliente->id_solicitud, $id_comercial);
		} else {
			log_message('error', "Fallo en el envío del email automático.");
		}
	}




	private function sendEmailAutomatico($from, $to, $subject, $message, $firma_path = "")
	{
		try {
			$this->load->library('PHPMailer_Lib');
			$mail = $this->phpmailer_lib->load();
			$mail->isSMTP();

			// Usamos la configuración de mailconfig.php
			$this->config->load('mailconfig');
			$mail->Host = $this->config->item('host');
			$mail->SMTPAuth = $this->config->item('smtpauth');
			$mail->Username = $this->config->item('username');
			$mail->Password = $this->config->item('password');
			$mail->SMTPSecure = $this->config->item('smtpsecure');
			$mail->Port = $this->config->item('port');
			$mail->isHTML(true);
			$mail->CharSet = 'UTF-8';

			// Enviar email desde la cuenta centralizada
			$mail->setFrom($this->config->item('username'), 'Exel Eventos');
			$mail->addReplyTo($from, 'Exel Eventos');

			// Validar destinatario
			if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
				$mail->addAddress($to);
			} else {
				log_message('error', "Email inválido: " . var_export($to, true));
				return false;
			}

			// Adjuntar imagen de la firma si existe
			if (!empty($firma_path) && file_exists($firma_path)) {
				$cid = $mail->addEmbeddedImage($firma_path, 'firma_img', basename($firma_path));
				$message .= "<br><img src='cid:firma_img' alt='Firma' style='max-width: 200px;'>";
			}

			// Asunto y cuerpo del email
			$mail->Subject = $subject;
			$mail->Body = $message;

			// Enviar email
			if (!$mail->send()) {
				log_message('error', "Error al enviar email automático desde {$from}: " . $mail->ErrorInfo);
				return false;
			}

			log_message('info', "Email automático enviado desde {$this->config->item('username')} a {$to} con asunto: {$subject}. Responderán a: {$from}");
			return true;
		} catch (Exception $e) {
			log_message('error', "Error en sendEmailAutomatico: " . $e->getMessage());
			return false;
		}
	}



	function presupuestos_eventos($acc = false, $id = false)
	{

		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($acc == 'add') {
			$data['estados_solicitudes'] = $this->comercial_functions->GetEstados_Solicitudes();
			$data['eventos'] = $this->comercial_functions->GetEventos();
			$data['servicios'] = $this->comercial_functions->GetServicios();

			if ($_POST) {
				$data = false;

				$data['nombre'] = $_POST['nombre'];
				$data['apellidos'] = $_POST['apellidos'];
				$data['email'] = $_POST['email'];
				$data['telefono'] = $_POST['telefono'];
				$data['restaurante'] = $_POST['restaurante'];
				$data['fecha_boda'] = $_POST['fecha_boda'] . " " . $_POST["hora_boda"];
				$data['evento'] = $_POST['evento'];

				//AÑADIMOS LOS SERVICIOS
				$servicios = array();
				$servicios = $_POST['serviciosid'];
				$data['servicios'] = $servicios;
				$data['servicios'] = implode(",", $data['servicios']);


				$data['importe'] = str_replace(',', '.', $_POST['importe']);
				$data['descuento'] = str_replace(',', '.', $_POST['descuento']);
				$data['total'] = str_replace(',', '.', $_POST['total']);
				$data['id_comercial'] = $this->session->userdata('id');
				$data['fecha_alta'] = date("Y-m-d");
				$data['estado_solicitud'] = $_POST['estado_solicitud'];

				$id_presupuesto = $this->comercial_functions->InsertPresupuestoEvento($data);
				//redirect(base_url().'admin/clientes/view');
				redirect('comercial/presupuestos_eventos/view/' . $id_presupuesto);
			}
		}
		if ($acc == 'view') {
			$this->load->database();
			if ($id) {
				if ($_POST) {

					//$this->load->database();

					if (isset($_POST['update_evento'])) {
						$this->db->query("UPDATE presupuesto_eventos SET evento = '" . $_POST['evento'] . "' WHERE id_presupuesto = {$id}");
					}

					if (isset($_POST['update_estado_solicitud'])) {
						$this->db->query("UPDATE presupuesto_eventos SET estado_solicitud = '" . $_POST['estado_solicitud'] . "' WHERE id_presupuesto = {$id}");
					}

					if (isset($_POST['update_servicios'])) {
						$servicios = array();
						$servicios = $_POST['serviciosid'];
						$data['servicios'] = $servicios;
						$data['servicios'] = implode(",", $data['servicios']);
						$data['importe'] = $_POST['importe'];
						$data['descuento'] = $_POST['descuento'];
						$data['total'] = $_POST['total'];
						$this->db->query("UPDATE presupuesto_eventos SET servicios = '" . $data['servicios'] . "', importe= '" . $data['importe'] . "', descuento= '" . $data['descuento'] . "', total= '" . $data['total'] . "' WHERE id_presupuesto = {$id}");
					}


					if (isset($_POST['enviar_email'])) {
						$id = $_POST['id_presupuesto'];

						$query = $this->db->query("SELECT nombre, apellidos, email, telefono, restaurante, DATE_FORMAT(fecha_boda,'%d-%m-%Y %H:%i:%s') as fecha_boda, evento, servicios, importe, descuento, total, id_comercial, DATE_FORMAT(fecha_alta,'%d-%m-%Y') as fecha_alta FROM presupuesto_eventos WHERE id_presupuesto = " . $id . "");
						foreach ($query->result() as $fila) {
							$nombre = $fila->nombre;
							$apellidos = $fila->apellidos;
							$fecha_boda = $fila->fecha_boda;
							$telefono = $fila->telefono;
							$email = $fila->email;
							$restaurante = $fila->restaurante;
							$importe = $fila->importe;
							$descuento = $fila->descuento;
							$total = $fila->total;
							$fecha_alta = $fila->fecha_alta;
							$servicios_contratados = $fila->servicios;
							$arr_servicios = explode(",", $servicios_contratados);

							$query2 = $this->db->query("SELECT nombre, id_oficina FROM comerciales WHERE id = " . $fila->id_comercial . "");
							foreach ($query2->result() as $fila2) {
								$nombre_comercial = $fila2->nombre;
								$id_oficina_comercial = $fila2->id_oficina;
							}

							$query3 = $this->db->query("SELECT nombre, direccion, poblacion, cp, telefono, movil, email, web, logo_mail FROM oficinas WHERE id_oficina = '" . $id_oficina_comercial . "'");
							foreach ($query3->result() as $fila3) {
								$nombre_oficina_comercial = $fila3->nombre;
								$direccion_oficina_comercial = $fila3->direccion;
								$poblacion_oficina_comercial = $fila3->poblacion;
								$cp_oficina_comercial = $fila3->cp;
								$telefono_oficina_comercial = $fila3->telefono;
								$movil_oficina_comercial = $fila3->movil;
								$email_oficina_comercial = $fila3->email;
								$web_oficina_comercial = $fila3->web;
								$logo_mail_oficina_comercial = $fila3->logo_mail;
							}
						}

						$local = 'http://' . $_SERVER['HTTP_HOST'] . base_url();



						$html = '<html>
						<head>
						<link href="' . $local . 'css/style.css" rel="stylesheet" type="text/css" />
						</head>
						
						<body>
						<table width="100%">
							<tr>
							  <td colspan="2">
									<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
							  </td>
							</tr>
						<tr><td align="center"><font size="+3"><b>PRESUPUESTO</b></font></td>
						  <td align="center"><font size="+3"><b><img src="' . $local . '/uploads/oficinas/' . $logo_mail_oficina_comercial . '" width="286" alt=""/></b></font></td>
						</tr>
										  <tr>
											<td width="40%">
												<table width="100%" border="0" style="border-collapse:collapse;">
														<tr><td><strong>&#161;Haz tu día el día de todos&#33;</strong></td>
														</tr>
														<tr>
														  <td>&nbsp;</td>
												  </tr>
														<tr>
														  <td>Comercial: ' . $nombre_comercial . '</td>
												  </tr>
														<tr>
														  <td>
														' . $direccion_oficina_comercial . '</td>
														</tr>
														<tr><td>
														' . $cp_oficina_comercial . ', ' . $poblacion_oficina_comercial . '
														</tr>
														<tr>
														  <td>Teléfono oficina: ' . $telefono_oficina_comercial . '</td>
														</tr>
														<tr>
														  <td>Teléfono móvil: ' . $movil_oficina_comercial . '</td>
														</tr>
														<tr><td>
														<a href="' . $web_oficina_comercial . '" target="_blank">' . $web_oficina_comercial . '</a></td>
														</tr>
														<tr>
														  <td><a href="mailto:' . $email_oficina_comercial . '" target="_blank">' . $email_oficina_comercial . '</a></td>
														</tr>
												</table>
											 </td>
											 <td valign="top">
											 <table width="100%">
											 <tr>
											   <td width="27%">Fecha del presupuesto:</td>
											   <td width="73%">' . $fecha_alta . '</td>
											   </tr>
											 <tr>
											 <tr>
											   <td width="27%"><strong>Fecha del evento:</strong></td>
											   <td width="73%">' . $fecha_boda . '</td>
											   </tr>
											 <tr>
												<td><font>Presupuestado a:</font></td>
												<td><font>' . $nombre . ' ' . $apellidos . '</font></td>
												</tr>
											  <tr>
												<td><font>Tel&#233;fono:</font></td>
												<td><font>' . $telefono . '</font></td>
												</tr>
											  <tr>
												<td><font>Correo electr&#243;nico:</font></td>
												<td><font><a href="mailto:' . $email . '" target="_blank">' . $email . '</a></font></td>
											   </tr>
											  <tr>
												<td>Restaurante Boda:</td>
												<td>' . $restaurante . '</td>
											   </tr>
											  <tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											  </tr>
											 
											 </table>
										
										  </tr>
										  <tr>
											<td colspan="2"><p><strong>Gracias por confiar en ' . $nombre_oficina_comercial . '</strong></p>
											A continuación les detallamos el presupuesto solicitado:</td>
						  </tr>
										  <tr>
											<td colspan="2"><table width="100%" border="1">
											  <tr>
												<td width="77%" style="background-color:#631268; color:#fff; border:#000 1px solid"><strong>Descripción</strong></td>';
						//$html=$html+'<td width="23%" style="background-color:#631268; color:#fff; border:#000 1px solid"><strong>Importe</strong></td>';
						$html = $html . '</tr>';

						$query2 = $this->db->query("SELECT id, nombre, precio FROM servicios");
						foreach ($query2->result() as $fila2) {
							if (in_array($fila2->id, $arr_servicios)) {
								$html = $html . '<tr>
														<td style="background-color: #EBEBEB; color: #000; border:#000 1px solid">' . $fila2->nombre . '</td>';

								//$html=$html.'<td align="right" style="background-color: #EBEBEB; color: #000; border:#000 1px solid">'.$fila2->precio.' €</td>';
								$html = $html . '</tr>';
							}
						}



						$html = $html . '
											  </table></td>
						  </tr>
										  <tr>
											<td colspan="2" align="right"><table width="25%" border="0">';
						//$html=$html+'<tr>											<td width="46%" style="background-color:#631268; color:#fff; border:#000 1px solid">Subtotal</td>												<td width="54%" align="right" style="background-color: #EBEBEB; color: #000; border:#000 1px solid">'.$importe.' €</td>											  </tr>											  <tr>											<td style="background-color:#631268; color:#fff; border:#000 1px solid">Descuento</td>												<td align="right" style="background-color: #EBEBEB; color: #000; border:#000 1px solid">'.$descuento.' €</td>											  </tr>';
						$html = $html . '<tr>
												<td style="background-color:#631268; color:#fff; border:#000 1px solid">Impuestos</td>
												<td align="right" style="background-color: #EBEBEB; color: #000; border:#000 1px solid">IVA incluído</td>
											  </tr>
											  <tr>
												<td style="background-color:#631268; color:#fff; border:#000 1px solid">TOTAL</td>
												<td align="right" style="background-color: #EBEBEB; color: #000; border:#000 1px solid">' . $total . ' €</td>
											  </tr>
											</table>
											  <div align="right"></div>
											<div align="right"></div></td>
						  </tr>
										  <tr>
											<td colspan="2" align="center">
												<font size="2" color="#999999">En este presupuesto están incluídos los costes de personal técnico, desplazamientos (dentro de la provincia), IVA, equipos profesionales y gestión<br>
												Destinos fuera de la provincia: 20€ por cada 100km entre ida y vuelta más gastos de peaje<br>
												Exel Eventos S.L. - B95773495 ' . $direccion_oficina_comercial . ' ' . strtoupper($poblacion_oficina_comercial) . ' ' . $cp_oficina_comercial . ' ' . $telefono_oficina_comercial . ' <br>
												Horario: Lunes a jueves (10:00 h. - 18:30 h.) Viernes (10:00 h. - 15:00 h.)</font>
											</td>
						  </tr>
						  <tr>
									<td align="center" colspan="2"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
						  </tr>
										  
							</table>
						</body>
						</html>';








						$asunto = 'Presupuesto ' . $nombre_oficina_comercial . '';

						$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
						$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
						$cabeceras .= 'From: ' . $email_oficina_comercial . '';
						//mail($email, $asunto, $html, $cabeceras);
						$this->sendEmail('info@exeleventos.com', [$email], $asunto, $html);
					}
				}

				if (isset($_POST['add_observ'])) {
					$this->db->query("INSERT INTO observaciones_presupuesto_eventos (id_presupuesto, id_comercial, comentario) VALUES ({$id}, " . $this->session->userdata('id') . ", '" . str_replace("'", "''", $_POST['observaciones']) . "')");
				}

				$data['estados_solicitudes'] = $this->comercial_functions->GetEstados_Solicitudes();
				$data['eventos'] = $this->comercial_functions->GetEventos();
				$data['presupuesto_evento'] = $this->comercial_functions->GetPresupuestoEvento($id);
				$data['servicios'] = $this->comercial_functions->GetServicios();
				$data['observaciones_presupuesto_eventos'] = $this->comercial_functions->GetObservaciones_Presupuesto_Eventos($id);
				$acc = "viewdetails";
			} else {
				if ($_POST) {
					$this->load->database();

					$this->db->query("DELETE FROM presupuesto_eventos WHERE id_presupuesto = " . $_POST['id'] . "");
				}

				$str_where = "";


				if (isset($_GET['p']))
					$data['page'] = $_GET['p'];
				else
					$data['page'] = 1;

				if (isset($_GET['q'])) {
					if ($_GET['f'] == 'fecha_boda') {
						$date = strtotime($_GET['q']);
						$str_where = "WHERE DATE(" . $_GET['f'] . ") = '" . date('Y-m-d', $date) . "'";
					} else {
						$str_where = "WHERE " . $_GET['f'] . " LIKE '%" . $_GET['q'] . "%'";
					}
				}

				if (isset($_GET['evento']) and $_GET['evento'] <> "") {
					$str_where = $str_where . " AND evento = " . $_GET['evento'];
				}
				if (isset($_GET['estado_solicitud']) and $_GET['estado_solicitud'] <> "") {
					$str_where = $str_where . " AND estado_solicitud = " . $_GET['estado_solicitud'];
				}

				$query = $this->db->query("SELECT id_presupuesto FROM presupuesto_eventos {$str_where}");
				$data['num_rows'] = $query->num_rows();

				$data['rows_page'] = 15;
				$data['last_page'] = ceil($data['num_rows'] / $data['rows_page']);

				$data['page'] = (int)$data['page'];
				if ($data['page'] > $data['last_page']) $data['page'] = $data['last_page'];
				if ($data['page'] < 1) $data['page'] = 1;

				$limit = 'LIMIT ' . ($data['page'] - 1) * $data['rows_page'] . ',' . $data['rows_page'];

				$ord = "fecha_boda";
				if (isset($_GET['ord']) && $_GET['ord'] != '') $ord = $_GET['ord'];

				$data['presupuestos_eventos'] = $this->comercial_functions->GetPresupuestosEventos($str_where, $ord, $limit);
				$data['eventos'] = $this->comercial_functions->GetEventos();
				$data['estados_solicitudes'] = $this->comercial_functions->GetEstados_Solicitudes();
			}
		}

		$view = "presupuestos_eventos_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	function seguimiento_llamadas($acc = false, $id = false)
	{

		$data_header = false;
		$data = false;
		$data_footer = false;

		if ($acc == 'view') {
			$this->load->database();


			$str_where = "";


			/*if(isset($_GET['p']))
    				$data['page'] = $_GET['p'];
				else
       				$data['page'] = 1;

				if(isset($_GET['q'])) {
					if($_GET['f'] == 'fecha_boda') {
						$date = strtotime($_GET['q']);
    					$str_where = "WHERE DATE(".$_GET['f'].") = '".date('Y-m-d', $date)."'";
					} else {
						$str_where = "WHERE ".$_GET['f']." LIKE '%".$_GET['q']."%'";
					}
					
	  
					
				}
				
				if(isset($_GET['estado_solicitud']) and $_GET['estado_solicitud']<>"")
				{
					if($str_where=="")
					{
						$str_where=$str_where." WHERE estado_solicitud = ".$_GET['estado_solicitud'];
					}else{
						$str_where=$str_where." AND estado_solicitud = ".$_GET['estado_solicitud'];
					}
				}
				
				$query = $this->db->query("SELECT id_solicitud FROM solicitudes {$str_where}");
				$data['num_rows'] = $query->num_rows();
				
				$data['rows_page'] = 15;
				$data['last_page'] = ceil($data['num_rows'] / $data['rows_page']);
				
				$data['page'] = (int)$data['page'];
 				if($data['page'] > $data['last_page']) $data['page'] = $data['last_page'];
				if($data['page'] < 1) $data['page']=1;
				
				$limit = 'LIMIT '. ($data['page'] -1) * $data['rows_page'] . ',' .$data['rows_page'];
 				
				$ord = "fecha";
				if(isset($_GET['ord']) && $_GET['ord'] != '') $ord = $_GET['ord'];*/

			$data['llamadas_solicitudes'] = $this->comercial_functions->GetLLamadas_Solicitudes();
			//$data['estados_solicitudes'] = $this->comercial_functions->GetEstados_Solicitudes();
		}
		$view = "seguimiento_llamadas_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	function _loadViews($data_header, $data, $data_footer, $view)

	{

		$this->load->view('comercial/header', $data_header);

		$this->load->view('comercial/' . $view, $data);

		$this->load->view('comercial/footer', $data_footer);
	}
	function _loadViewsHome($data_header, $data, $data_footer)

	{

		$this->load->view('comercial/header', $data_header);

		$this->load->view('comercial/home', $data);

		$this->load->view('comercial/footer', $data_footer);
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

			$mail->Subject = $subject;
			$mail->isHTML(true);

			$mail->Body = $message;
			// Send email
			if (!$mail->send()) {
				error_log("\r\n Message could not be sent.'Mailer Error: " . $mail->ErrorInfo . "\r\n", 3, "./r");
			}
		} catch (Exception $e) {
			error_log("Algún tipo de error al enviar el correo " . var_export($e, 1), 3, "./r");
		}
	}

	public function borrarFirma()
	{
		$id = $this->input->post('id');

		if ($id) {
			$this->comercial_functions->vaciarFirma($id);
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'ID no válido']);
		}
	}
}
