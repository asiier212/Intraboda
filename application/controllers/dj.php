<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Dj extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//$this->load->helper('url');
		//$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('dj_functions');
		if (!$this->session->userdata('id') && $this->router->method != 'login') {
			redirect('dj/login');
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

		//$this->_loadViews($data_header, $data, $data_footer, "home");
		$this->clientes('view');
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('dj', 'location');
	}
	/*public function login()
	{
		$data = false;
		
		if($_POST) {
			if($_POST['email'] == "dj" && $_POST['pass'] == "secreto" ) {
				$this->session->set_userdata(array("dj" => true));
				redirect('dj','location');
			} else {
				$data['msg'] = 'Login o contrase&ntilde;a incorrecto';
			}
			
			
		}
		$this->load->view('dj/login', $data);
	}*/
	public function login()
	{
		$data = false;

		if ($_POST) {
			$arr_userdata = $this->dj_functions->DjLogin($_POST['email'], $_POST['pass']);
			if ($arr_userdata) {
				$this->session->set_userdata($arr_userdata);
				redirect('dj', 'location');
			} else {
				$data['msg'] = 'Login o contrase&ntilde;a incorrecto';
			}
		}
		$this->load->view('dj/login', $data);
	}
	function clientes($acc = false, $id = false)
	{

		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($acc == 'add') {
			$data['servicios'] = $this->dj_functions->GetServicios();
			$data['personas']  = $this->dj_functions->GetPersonasContacto();
			if ($_POST) {

				$id = $this->dj_functions->InsertCliente($_POST);
				$config['upload_path'] = './uploads/foto_perfil/';
				$config['allowed_types'] = 'gif|jpg|png';
				//$config['max_width']  = '600';

				$this->load->library('upload', $config);


				if (! $this->upload->do_upload("foto")) {
					$data['msg'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->dj_functions->UpdatefotoCliente($id, $data['upload_data']['file_name']);
					//$data['msg'] = "La imagen se ha subido correctamente";

				}
				//redirect(base_url().'admin/clientes/view');
				redirect('dj/clientes/view');
			}
		}
		if ($acc == 'view') {
			$this->load->database();
			if ($id) {
				if ($_POST) {

					//$this->load->database();

					if (isset($_POST['personas'])) {
						$_POST['personas_contacto'] = implode(",", $_POST['personas_contacto']);

						$this->db->query("UPDATE clientes SET personas_contacto = '" . $_POST['personas_contacto'] . "' WHERE id = {$id}");
					}

					if (isset($_POST['add_presupuesto'])) {

						$config['upload_path'] = './uploads/pdf/';
						$config['allowed_types'] = 'pdf';
						$this->load->library('upload', $config);

						if (! $this->upload->do_upload("presupuesto")) {
							$data['msg_pdf'] = $this->upload->display_errors();
						} else {
							$data['upload_data'] = $this->upload->data();


							$data['msg_pdf'] = "El PDF se ha subido correctamente";
							$this->db->query("UPDATE clientes SET presupuesto_pdf  = '" . $data['upload_data']['file_name'] . "' WHERE id = {$id}");
						}
					}
					if (isset($_POST['add_contrato'])) {

						$config['upload_path'] = './uploads/pdf/';
						$config['allowed_types'] = 'pdf';
						$this->load->library('upload', $config);

						if (! $this->upload->do_upload("contrato")) {
							$data['msg_pdf'] = $this->upload->display_errors();
						} else {
							$data['upload_data'] = $this->upload->data();


							$data['msg_pdf'] = "El PDF se ha subido correctamente";
							$this->db->query("UPDATE clientes SET contrato_pdf  = '" . $data['upload_data']['file_name'] . "' WHERE id = {$id}");
						}
					}
					if (isset($_POST['update_descuento'])) {
						$this->db->query("UPDATE clientes SET descuento = '" . $_POST['descuento'] . "' WHERE id = {$id}");
					}
					if (isset($_POST['add_pago'])) {
						$this->db->query("INSERT INTO pagos (cliente_id, valor) VALUES ({$id}, '" . $_POST['valor'] . "')");
					}
					if (isset($_POST['update_servicios'])) {
						$servicios = implode(",", $_POST['servicios']);
						$this->db->query("UPDATE clientes SET servicios = '" . $servicios . "' WHERE id = {$id}");
					}
					if (isset($_POST['add_observ']) && !empty($_POST['observaciones']) && $id) {
						$data_insert = array(
							'id_cliente' => $id,
							'comentario' => $_POST['observaciones'],
							'link' => $_POST['link']
						);

						if ($this->db->insert('observaciones', $data_insert)) {
							$this->session->set_flashdata('msg', 'Se ha añadido con éxito');
						} else {
							$this->session->set_flashdata('msg', 'Error al añadir la observación.');
						}

						redirect("dj/clientes/view/{$id}");
					}
				}

				if (isset($_POST['asignar'])) {
					$tipo_equipo = $_POST['tipo_equipo']; // por ejemplo: "Equipo 1", "Equipo 2", ...
					$id_grupo = $_POST['id_grupo'];       // valor del <select>

					// Verifica si ya existe una asignación previa
					$query = $this->db->query("
						SELECT * FROM clientes_equipos 
						WHERE id_cliente = ? AND tipo_equipo = ?
						LIMIT 1
					", array($id, $tipo_equipo));

					if ($query->num_rows() > 0) {
						// Actualizar grupo existente
						$this->db->query("
							UPDATE clientes_equipos 
							SET id_grupo = ? 
							WHERE id_cliente = ? AND tipo_equipo = ?
						", array($id_grupo, $id, $tipo_equipo));
					} else {
						// Insertar nueva asignación
						$this->db->query("
							INSERT INTO clientes_equipos (id_cliente, id_grupo, tipo_equipo) 
							VALUES (?, ?, ?)
						", array($id, $id_grupo, $tipo_equipo));
					}

					$this->session->set_flashdata('msg', "Asignación guardada correctamente.");
					redirect("dj/clientes/view/{$id}");
				}

				if (isset($_POST['eliminar_equipo'])) {
					$tipo_equipo = $_POST['tipo_equipo'];

					$this->db->query("
						DELETE FROM clientes_equipos 
						WHERE id_cliente = ? AND tipo_equipo = ?
					", array($id, $tipo_equipo));

					$this->session->set_flashdata('msg', "Asignación de {$tipo_equipo} eliminada correctamente.");
					redirect("dj/clientes/view/{$id}");
				}

				if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_revisiones'])) {

					$revision_salida = isset($_POST['revision_salida']) ? array_keys($_POST['revision_salida']) : array();
					$revision_fin = isset($_POST['revision_fin']) ? array_keys($_POST['revision_fin']) : array();
					$revision_pabellon = isset($_POST['revision_pabellon']) ? array_keys($_POST['revision_pabellon']) : array();
					$tipo_equipo = $_POST['tipo_equipo_revision']; // Debes enviar este hidden desde el formulario del popup
					$id_cliente = $id; // Ya lo deberías tener

					$this->dj_functions->GuardarRevisionesEquipo($id_cliente, $tipo_equipo, $revision_salida, $revision_fin, $revision_pabellon);

					// Redirigir para evitar reenvío
					redirect(current_url());
				}

				$data['revisiones_guardadas'] = $this->dj_functions->GetRevisionesGuardadas($id);
				$data['equipos_disponibles'] = $this->dj_functions->GetEquiposDisponibles($id);
				$data['equipos_asignados'] = $this->dj_functions->GetEquiposAsignados($id);

				$data['equipos_detalles'] = [];
				foreach ($data['equipos_asignados'] as $tipo => $info) {
					if ($info !== null) {
						$data['equipos_detalles'][$tipo] = $this->dj_functions->GetDetallesEquipoAsignado($id, $tipo);
					}
				}

				$data['cliente'] = $this->dj_functions->GetCliente($id);
				$arr_servicios = unserialize($data['cliente']['servicios']);
				$arr_serv_keys = array_keys($arr_servicios);

				$data['servicios'] = $this->dj_functions->GetServicios(implode(",", $arr_serv_keys));

				$data['preguntas_encuesta_datos_boda'] = $this->dj_functions->GetPreguntasEncuestaDatosBoda();
				$data['opciones_respuestas_encuesta_datos_boda'] = $this->dj_functions->GetOpcionesRespuestasEncuestaDatosBoda();
				$data['respuesta_cliente'] = $this->dj_functions->GetRespuestasEncuestaDatosBoda($id);
				$data['componentes'] = $this->dj_functions->GetComponentes();
				$data['reparaciones_totales'] = $this->dj_functions->GetReparacionesTotales();
				$data['personas']  = $this->dj_functions->GetPersonasContacto();
				$data['cliente'] = $this->dj_functions->GetCliente($id);
				$data['horas_dj'] = $this->dj_functions->GetHorasCliente($id);
				$data['pagos'] = $this->dj_functions->GetPagos($id);
				$data['observaciones_cliente'] = $this->dj_functions->GetObservaciones($id);
				$acc = "viewdetails";
			} else {
				if ($_POST) {

					$this->db->query("DELETE FROM clientes WHERE id = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM canciones WHERE client_id = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM canciones_observaciones WHERE client_id  = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM momentos_espec WHERE cliente_id  = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM pagos WHERE cliente_id = " . $_POST['id'] . "");

					$this->db->query("DELETE FROM galeria WHERE client_id   = " . $_POST['id'] . "");

					$dir = exec("pwd");

					system("rm -rf $dir/uploads/gallery/" . $_POST['id']);
				}

				$str_where = "";
				$dj = $this->session->userdata('id'); //Mirar si realmente fundiona este dato


				if (isset($_GET['p']))
					$data['page'] = $_GET['p'];
				else
					$data['page'] = 1;

				if (isset($_GET['q'])) {
					if ($_GET['f'] == 'fecha_boda') {
						$date = strtotime($_GET['q']);
						$str_where = "WHERE DATE(" . $_GET['f'] . ") = '" . date('Y-m-d', $date) . "' AND DJ = '$dj'"; //Coge el id del DJ de la session
					} else {
						$str_where = "WHERE " . $_GET['f'] . " LIKE '%" . $_GET['q'] . "%' AND DJ = '$dj'"; //Coge el id del DJ de la session
					}
				}
				if ($str_where == "") {
					$str_where = "WHERE DJ = '$dj'";
				}
				$query = $this->db->query("SELECT clientes.id FROM clientes INNER JOIN restaurantes ON clientes.id_restaurante=restaurantes.id_restaurante {$str_where}");
				$data['num_rows'] = $query->num_rows();

				$data['rows_page'] = 15;
				$data['last_page'] = ceil($data['num_rows'] / $data['rows_page']);

				$data['page'] = (int)$data['page'];
				if ($data['page'] > $data['last_page']) $data['page'] = $data['last_page'];
				if ($data['page'] < 1) $data['page'] = 1;

				$limit = 'LIMIT ' . ($data['page'] - 1) * $data['rows_page'] . ',' . $data['rows_page'];

				$ord = "fecha_boda DESC";
				if (isset($_GET['ord']) && $_GET['ord'] != '') $ord = $_GET['ord'];

				$data['clientes'] = $this->dj_functions->GetClientes($str_where, $ord, $limit);
			}
		}
		if ($acc == 'initsession') {

			$this->load->database();

			$query = $this->db->query("SELECT id, email_novia, email_novio, nombre_novio, nombre_novia FROM clientes WHERE id = {$id}");

			if ($query->num_rows() > 0) {
				$fila = $query->row();
				$arr_userdata['user_id'] = $fila->id;
				$arr_userdata['nombre_novio'] = $fila->nombre_novio;
				$arr_userdata['nombre_novia'] = $fila->nombre_novia;
				$arr_userdata['email'] = $fila->email_novio;
				$arr_userdata['email_novia'] = $fila->email_novia;
				$arr_userdata['email_novio'] = $fila->email_novio;
				$this->session->set_userdata($arr_userdata);
				redirect('cliente/datos/view');
			}
		}
		$view = "clientes_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}
	function events($acc = false)
	{

		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($_POST) {

			if (isset($_POST['add']))
				$this->dj_functions->InsertEvent($_POST['nombre']);

			if (isset($_POST['delete']))
				$this->dj_functions->DeleteEvent($_POST['elem']);
		}

		$data['momentos']  = $this->dj_functions->GetEvents();
		$view = "events_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}
	function servicios($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($acc == 'view' && $_POST) {

			$this->dj_functions->InsertServicio($_POST);
		}
		$data['servicios'] = $this->dj_functions->GetServicios();

		if ($acc == 'edit') {

			if ($_POST) {
				if (isset($_POST['delete'])) {
					$this->dj_functions->DeleteServicio($id);
				} else {
					$this->dj_functions->UpdateServicio($_POST, $id);
				}
				$data_header['scripts'] = "location.href='" . base_url() . "dj/servicios/view';";
			}
			$data['servicio'] = $this->dj_functions->GetServicio($id);
		}


		$this->_loadViews($data_header, $data, $data_footer,  "servicios_" . $acc);
	}

	public function dj_chat($id)
	{
		$data_header = false;
		$data_footer = false;
		$data = false;

		$this->load->database();

		if ($_POST && isset($_POST['mensaje']) && trim($_POST['mensaje']) != '') {
			$mensaje = $this->input->post('mensaje');

			// Insertar mensaje en la base de datos
			$this->db->query("
				INSERT INTO contacto (id_cliente, usuario, id_usuario, mensaje, fecha)
				VALUES (?, 'dj', ?, ?, NOW())
			", [$id, $this->session->userdata('user_id'), $mensaje]);

			// NOTIFICACIONES PARA ADMIN
			$clienteNombres = $this->db->query("
				SELECT nombre_novio, nombre_novia 
				FROM clientes 
				WHERE id = ?
			", [$id])->row();

			$nombreCompleto = $clienteNombres->nombre_novio . " & " . $clienteNombres->nombre_novia;

			$this->db->query("
				INSERT INTO notificaciones_admin (id_cliente, mensaje, fecha, leido)
				VALUES (?, ?, NOW(), 0)
				", [$id, "Nuevo mensaje de <strong>DJ</strong> de $nombreCompleto: " . $mensaje]);
			//--------------

			// NOTIFICACIONES PARA CLIENTE
			$djNombre = $this->db->query("
				SELECT d.nombre 
				FROM djs d
				INNER JOIN clientes c ON c.dj = d.id
				WHERE c.id = ?
			", [$id])->row();

			$this->db->query("
				INSERT INTO notificaciones_cliente (id_cliente, mensaje, fecha, leido)
				VALUES (?, ?, NOW(), 0)
				", [$id, "Nuevo mensaje de DJ $djNombre->nombre: " . $mensaje]);

			//--------------

			// --- Recuperar emails necesarios ---
			$cliente = $this->db->query("
				SELECT email_novio, email_novia, id_oficina 
				FROM clientes 
				WHERE id = ?
			", [$id])->row();

			$oficina = $cliente ? $this->db->query("SELECT email FROM oficinas WHERE id_oficina = ?", [$cliente->id_oficina])->row() : null;

			if ($cliente) {
				$from = 'info@exeleventos.com';
				$subject = "Nuevo mensaje de vuestro DJ en el chat de coordinación";
				$mensaje_usuario = $mensaje;

				// --- Enviar a Novio ---
				if (!empty($cliente->email_novio)) {
					$boton_url_cliente = "https://intranet.exeleventos.com/cliente/chat";
					$mensaje_email_novio = "
					<div style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto;'>
						<h2 style='color: #6a1b9a;'>¡Nuevo mensaje del DJ!</h2>
						<p>Hola pareja,</p>
						<p>El DJ que os acompañará en vuestro gran día os ha enviado el siguiente mensaje:</p>
						<blockquote style='background: #e6ccff; padding: 15px; border-left: 5px solid #6a1b9a; margin: 20px 0; font-style: italic;'>
							{$mensaje_usuario}
						</blockquote>
						<p>Podéis responder accediendo al área privada de vuestra boda haciendo clic en el siguiente botón:</p>
						<div style='text-align: center; margin: 30px 0;'>
							<a href='{$boton_url_cliente}' style='background-color: #6a1b9a; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold;'>Ir al chat</a>
						</div>
						<p>Un saludo,<br><strong>Equipo de Exel Eventos</strong></p>
					</div>
					";
					$this->sendEmail($from, [$cliente->email_novio], $subject, $mensaje_email_novio);
				}

				// --- Enviar a Novia ---
				if (!empty($cliente->email_novia)) {
					$boton_url_cliente = "https://intranet.exeleventos.com/cliente/chat";
					$mensaje_email_novia = "
					<div style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto;'>
						<h2 style='color: #6a1b9a;'>¡Nuevo mensaje del DJ!</h2>
						<p>Hola pareja,</p>
						<p>El DJ que os acompañará en vuestro gran día os ha enviado el siguiente mensaje:</p>
						<blockquote style='background: #e6ccff; padding: 15px; border-left: 5px solid #6a1b9a; margin: 20px 0; font-style: italic;'>
							{$mensaje_usuario}
						</blockquote>
						<p>Podéis responder accediendo al área privada de vuestra boda haciendo clic en el siguiente botón:</p>
						<div style='text-align: center; margin: 30px 0;'>
							<a href='{$boton_url_cliente}' style='background-color: #6a1b9a; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold;'>Ir al chat</a>
						</div>
						<p>Un saludo,<br><strong>Equipo de Exel Eventos</strong></p>
					</div>
					";
					$this->sendEmail($from, [$cliente->email_novia], $subject, $mensaje_email_novia);
				}

				// --- Enviar a Coordinador (oficina) ---
				if ($oficina && !empty($oficina->email)) {
					$boton_url_oficina = "https://intranet.exeleventos.com/admin/admin_chat/" . $id;
					$mensaje_email_oficina = "
					<div style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto;'>
						<h2 style='color: #6a1b9a;'>¡Nuevo mensaje del DJ!</h2>
						<p>Hola,</p>
						<p>Un DJ ha enviado el siguiente mensaje en el chat de coordinación:</p>
						<blockquote style='background: #e6ccff; padding: 15px; border-left: 5px solid #6a1b9a; margin: 20px 0; font-style: italic;'>
							{$mensaje_usuario}
						</blockquote>
						<p>Podéis ver y responder al mensaje accediendo al área privada de coordinación haciendo clic en el siguiente botón:</p>
						<div style='text-align: center; margin: 30px 0;'>
							<a href='{$boton_url_oficina}' style='background-color: #6a1b9a; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold;'>Ir al chat</a>
						</div>
						<p>Un saludo,<br><strong>Equipo de Exel Eventos</strong></p>
					</div>
					";
					$this->sendEmail($from, [$oficina->email], $subject, $mensaje_email_oficina);
				}
			}

			// 🔥 Ahora sí haces el redirect, después de insertar + enviar correo
			redirect("dj/dj_chat/$id");
		}

		// Si no es un post, o después del post, carga la vista
		$data['mensajes_contacto'] = $this->dj_functions->GetMensajesContacto($id);
		$data['nombre_chat'] = $this->dj_functions->GetTituloChat($id);
		$data['id_cliente'] = $id;

		$cliente = $this->db->query("SELECT foto, dj FROM clientes WHERE id = ?", [$id])->row();

		$dj = $cliente && $cliente->dj ? $this->db->query("SELECT nombre, foto FROM djs WHERE id = ?", [$cliente->dj])->row() : null;

		$data['foto_cliente'] = base_url() . 'uploads/foto_perfil/' . $cliente->foto;
		$data['foto_dj'] = base_url() . 'uploads/djs/' . $dj->foto;
		$data['foto_coordinador'] = base_url() . 'img/logo.jpg';


		$this->_loadViews($data_header, $data, $data_footer, "dj_chat");
	}



	public function notificaciones_ajax($tipo = 'no_leidas')
	{
		$this->load->database();
		header('Content-Type: application/json');
		$dj_id = $this->session->userdata('id');

		switch ($tipo) {
			case 'leidas':
				$notificaciones = $this->dj_functions->getNotificacionesPorEstado(1, $dj_id);
				break;
			case 'todas':
				$notificaciones = $this->dj_functions->getNotificacionesPorEstado(null, $dj_id);
				break;
			case 'no_leidas':
			default:
				$notificaciones = $this->dj_functions->getNotificacionesPorEstado(0, $dj_id);
				break;
		}

		echo json_encode($notificaciones);
	}

	public function borrar_todas_notificaciones()
	{

		$this->load->database();
		// Aquí deberías filtrar por usuario si aplica
		$this->db->empty_table('notificaciones_dj'); // o usa delete() si necesitas condiciones
		echo json_encode(['success' => true]);
	}

	public function contadores_notificaciones()
	{
		$this->load->model('dj_functions');
		$dj_id = $this->session->userdata('id');

		$data = [
			'todas' => $this->dj_functions->contar_todas($dj_id),
			'leidas' => $this->dj_functions->contar_leidas($dj_id),
			'no_leidas' => $this->dj_functions->contar_no_leidas($dj_id)
		];
		echo json_encode($data);
	}

	public function notificaciones()
	{
		$this->load->database();
		$this->load->model('dj_functions');
		$dj_id = $this->session->userdata('id');

		try {
			$notificaciones = $this->dj_functions->getNotificaciones($dj);
			$data['notificaciones'] = $notificaciones;
			$data['data_header'] = false;
			$data['data_footer'] = false;

			$this->_loadViews($data['data_header'], $data, $data['data_footer'], "notifica_dj");
		} catch (Exception $e) {
			echo "Error al obtener notificaciones. Consulta el log.";
		}
	}


	public function borrar_notificacion()
	{
		$this->load->database();


		// Obtener el ID de la notificación desde el POST
		$id_notificacion = $this->input->post('id_notificacion');

		// Validar que el ID no esté vacío
		if (empty($id_notificacion)) {
			echo json_encode(['success' => false, 'message' => 'ID de notificación inválido']);
			return;
		}

		// Intentar borrar la notificación
		$this->db->where('id', $id_notificacion);
		$this->db->delete('notificaciones_dj');

		// Verificar si la eliminación fue exitosa
		if ($this->db->affected_rows() > 0) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'No se pudo eliminar la notificación']);
		}
	}

	public function marcar_leida()
	{
		$id = $this->input->post('id');
		$this->load->model('dj_functions'); // cambia 'TuModelo' por el nombre real
		$success = $this->dj_functions->marcarNotificacionLeida($id);
		echo json_encode(['success' => $success]);
	}

	function persons($acc = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($_POST) {

			if (isset($_POST['add'])) {
				$id = $this->dj_functions->InsertPerson($_POST);

				$config['upload_path'] = './uploads/personas_contacto/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width']  = '200';

				$this->load->library('upload', $config);


				if (! $this->upload->do_upload("foto")) {
					$data['msg'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->dj_functions->UpdatefotoPerson($id, $data['upload_data']['file_name']);
					$data['msg'] = "La imagen se ha subido correctamente";
				}
			}
			if (isset($_POST['edit'])) {
				$this->dj_functions->UpdatePerson($_POST);
			}
			if (isset($_POST['change_foto'])) {

				$config['upload_path'] = './uploads/personas_contacto/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width']  = '200';

				$this->load->library('upload', $config);


				if (! $this->upload->do_upload("foto_edit")) {
					$data['msg_change_foto'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->dj_functions->UpdatefotoPerson($_POST['foto_id'], $data['upload_data']['file_name']);
					$data['msg_change_foto'] = "La imagen se ha subido correctamente";
				}
			}
			if (isset($_POST['delete']))
				$this->dj_functions->DeletePerson($_POST['elem']);
		}

		$data['personas']  = $this->dj_functions->GetPersonasContacto();
		$view = "persons_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	function contratos_nominas($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		$ano_contrato = date("Y");
		$ano_nomina = date("Y");

		if (isset($_POST['buscar_contrato'])) {
			unset($_POST['buscar_contrato']);
			$ano_contrato = $_POST['ano_contrato'];
		}

		if (isset($_POST['buscar_nomina'])) {
			unset($_POST['buscar_nomina']);
			$ano_nomina = $_POST['ano_nomina'];
		}

		$data['dj'] = $this->dj_functions->GetDJ($this->session->userdata('id'));
		$data['contratos'] = $this->dj_functions->GetDJContratos($this->session->userdata('id'), $ano_contrato);
		$data['nominas'] = $this->dj_functions->GetDJNominas($this->session->userdata('id'), $ano_nomina);

		$view = "contratos_nominas";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	/*function _loadViews($data_header, $data, $data_footer, $view)

	{

		$this->load->view('dj/header', $data_header);

		$this->load->view("dj/$view", $data);

		$this->load->view('dj/footer', $data_footer);

	}*/
	function _loadViews($data_header, $data, $data_footer, $view)

	{

		$this->load->view('dj/header', $data_header);

		$this->load->view('dj/' . $view, $data);

		$this->load->view('dj/footer', $data_footer);
	}
	function _loadViewsHome($data_header, $data, $data_footer)

	{

		$this->load->view('dj/header', $data_header);

		$this->load->view('dj/home', $data);

		$this->load->view('dj/footer', $data_footer);
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

			// Email subject
			$mail->Subject = $subject;
			// Set email format to HTML
			$mail->isHTML(true);
			// Email body content

			$mail->Body = $message;
			error_log("Vamos a enviar correo a " . var_export($to, 1), 3, "./r");
			// Send email
			if (!$mail->send()) {
				error_log("\r\n Message could not be sent.'Mailer Error: " . $mail->ErrorInfo . "\r\n", 3, "./r");
			}
		} catch (Exception $e) {
			error_log("Algún tipo de error al enviar el correo " . var_export($e, 1), 3, "./r");
		}
	}


	function Disponibilidad()
	{
		$this->load->database();

		error_reporting(0); // para evitar que se impriman warnings que rompan el JSON

		$this->load->model('dj_functions');

		// ---- CARGA DE EVENTOS (AJAX GET) ----
		if ($this->input->get('load') == '1') {
			$dj_id = $this->session->userdata('id');
			$datos = $this->dj_functions->get_disponibilidad($dj_id);

			$eventos = array();
			foreach ($datos as $row) {
				$eventos[] = array(
					'id' => $row['id'],
					'start' => $row['fecha'] . 'T' . $row['hora_inicio'],
					'end' => $row['fecha'] . 'T' . $row['hora_fin'],
					'title' => $row['nombre'] . ' (' . $row['hora_inicio'] . ' - ' . $row['hora_fin'] . ')',
					'extendedProps' => array(
						'validacion' => $row['validacion']
					)
				);
			}

			echo json_encode($eventos);
			return;
		}

		// ---- GUARDAR O ACTUALIZAR DISPONIBILIDAD (AJAX POST) ----
		if ($this->input->post('guardar') == '1') {
			$dj_id = $this->session->userdata('id');
			$fecha = $this->input->post('fecha');
			$hora_inicio = $this->input->post('hora_inicio');
			$hora_fin = $this->input->post('hora_fin');
			$id = $this->input->post('id');

			echo $this->dj_functions->guardar($dj_id, $fecha, $hora_inicio, $hora_fin, $id);
			return; // <- ¡MUY IMPORTANTE!
		}


		// ---- ELIMINAR DISPONIBILIDAD (AJAX POST) ----
		if ($this->input->post('eliminar') == '1') {
			$id = intval($this->input->post('id'));
			$this->dj_functions->eliminar($id);
			return;
		}

		// ---- CARGA NORMAL DE VISTA ----
		$data_header = false;
		$data_footer = false;
		$data['dj'] = $this->dj_functions->GetDJ($this->session->userdata('id'));
		$view = "disponibilidad_view";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}
}
