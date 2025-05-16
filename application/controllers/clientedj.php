<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Clientedj extends CI_Controller
{

	function __construct()
	{

		parent::__construct();
		//$this->load->helper('url');
		//$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('clientedj_functions');
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

		$this->_loadViews($data_header, $data, $data_footer, "home");
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

			$arr_userdata = $this->clientedj_functions->DjLogin($_POST['email'], $_POST['pass']);
			if ($arr_userdata) {
				$this->session->set_userdata($arr_userdata);
				redirect('clientedj', 'location');
			} else {
				$data['msg'] = 'Login o contrase&ntilde;a incorrecto';
			}
		}
		$this->load->view('clientedj/login', $data);
	}
	function clientes($acc = false, $id = false)
	{

		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($acc == 'add') {
			$data['servicios'] = $this->clientedj_functions->GetServicios();
			$data['personas']  = $this->clientedj_functions->GetPersonasContacto();
			if ($_POST) {

				$id = $this->clientedj_functions->InsertCliente($_POST);
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
				redirect('clientedj/clientes/view');
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
					if (isset($_POST['add_observ'])) {
						$this->db->query("INSERT INTO observaciones (id_cliente,comentario) VALUES ({$id}, '" . str_replace("'", "''", $_POST['observaciones']) . "')");
					}
				}

				$data['cliente'] = $this->clientedj_functions->GetCliente($id);
				$arr_servicios = unserialize($data['cliente']['servicios']);
				$arr_serv_keys = array_keys($arr_servicios);

				$data['servicios'] = $this->clientedj_functions->GetServicios(implode(",", $arr_serv_keys));
				$data['personas']  = $this->clientedj_functions->GetPersonasContacto();
				$data['cliente'] = $this->clientedj_functions->GetCliente($id);
				$data['pagos'] = $this->clientedj_functions->GetPagos($id);
				$data['observaciones_cliente'] = $this->clientedj_functions->GetObservaciones($id);
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
				$query = $this->db->query("SELECT id FROM clientes {$str_where}");
				$data['num_rows'] = $query->num_rows();

				$data['rows_page'] = 15;
				$data['last_page'] = ceil($data['num_rows'] / $data['rows_page']);

				$data['page'] = (int)$data['page'];
				if ($data['page'] > $data['last_page']) $data['page'] = $data['last_page'];
				if ($data['page'] < 1) $data['page'] = 1;

				$limit = 'LIMIT ' . ($data['page'] - 1) * $data['rows_page'] . ',' . $data['rows_page'];

				$ord = "fecha";
				if (isset($_GET['ord']) && $_GET['ord'] != '') $ord = $_GET['ord'];

				$data['clientes'] = $this->clientedj_functions->GetClientes($str_where, $ord, $limit);
			}
		}
		if ($acc == 'initsession') {
			//$dj = $this->session->userdata('id');

			$this->load->database();
			$query = $this->db->query("SELECT id, email_novia, email_novio, nombre_novio, nombre_novia, apellidos_novio, apellidos_novia FROM clientes WHERE id = {$id} AND dj = {$this->session->userdata('id')}");
			if ($query->num_rows() > 0) {
				$fila = $query->row();
				$arr_userdata['user_id'] = $fila->id;
				$arr_userdata['nombre_novio'] = $fila->nombre_novio;
				$arr_userdata['nombre_novia'] = $fila->nombre_novia;
				$arr_userdata['apellidos_novio'] = $fila->apellidos_novio;
				$arr_userdata['apellidos_novia'] = $fila->apellidos_novia;
				$arr_userdata['email'] = $fila->email_novio;
				$arr_userdata['email_novia'] = $fila->email_novia;
				$arr_userdata['email_novio'] = $fila->email_novio;
				$this->session->set_userdata($arr_userdata);
				redirect('clientedj/datos/view');
			} else {
				redirect('dj/login');
			}
		}

		$view = "clientes_" . $acc;

		$this->_loadViews($data_header, $data, $data_footer, $view);
	}


	public function chat()
	{
		$data_header = false;
		$data_footer = false;
		$data['email_novia'] = $this->session->userdata('email_novia');
		$data['email_novio'] = $this->session->userdata('email_novio');


		$data['mensajes_contacto'] = $this->clientedj_functions->GetMensajesContacto($this->session->userdata('user_id'));
		if ($_POST) {

			$this->load->database();
			//Datos para los emails			
			$query = $this->db->query("SELECT oficinas.email as email_oficina FROM oficinas JOIN clientes WHERE oficinas.id_oficina=clientes.id_oficina AND clientes.id = " . $this->session->userdata('user_id') . "");
			$fila = $query->row();
			$email_oficina = $fila->email_oficina;

			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$cabeceras .= 'From: ' . $data['email_novio'];
			$header_mail = 'http://www.bilbodj.com/intranetv3/' . $this->config->item('email_header');
			$footer_mail = 'http://www.bilbodj.com/intranetv3/' . $this->config->item('email_footer');

			$local = 'http://' . $_SERVER['HTTP_HOST'] . base_url();

			$mensaje = '<html>
						<head>
						
						</head>
						
						<body>
						<table width="100%">
						<tr>
						  <td>
								<img src="' . $header_mail . '" width="100%">
						  </td>
						</tr>';

			//Mandamos email a los dos novios y a la oficina
			$usuario = 'dj';
			$id_usuario = $this->session->userdata('id');
			$id_cliente = $this->session->userdata('user_id');

			$asunto = 'BilboDJ ha contactado contigo';
			$mensaje_cliente = $mensaje . '<tr><td>
										  <tr><td align="justify">
										  	<div style="padding:50px;">
											' . utf8_decode('BilboDJ ha contactado contigo, por favor accede a la sección <strong>chat</strong> de tu panel de cliente <a href="http://www.bilbodj.com/intranetv3/cliente" target="_blank">AQUÍ</a>.') . '
											</div>
											</td></tr>					 					
										  </td></tr>
                                                                                  <tr>
                                                                                  <td>' . $_POST['mensaje'] . '
                                                                                  </td>
                                                                                  </tr>
								<tr>
									<td align="center"><img src="' . $footer_mail . '" width="100%"></td>
								</tr>
						  </table>
						  </body>
						  </html>';
			$hay_email_novio = strpos($this->session->userdata('email_novio'), '@');
			$hay_email_novia = strpos($this->session->userdata('email_novia'), '@');

			if ($hay_email_novio !== false) {
				//mail($this->session->userdata('email_novio'), $asunto, $mensaje_cliente, $cabeceras);
				$destino[] = $this->session->userdata('email_novio');
			}
			if ($hay_email_novia !== false) {
				//mail($this->session->userdata('email_novia'), $asunto, $mensaje_cliente, $cabeceras);
				$destino[] = $this->session->userdata('email_novia');
			}
			if (!empty($destino)) {
				$this->sendEmail('info@exeleventos.com', $destino, $asunto, $mensaje_cliente);
			}

			$asunto = 'Uno de tus DJS ha contactado con uno de tus clientes';
			$mensaje_oficina = $mensaje . '<tr><td>
										  <tr><td align="justify">
										  	<div style="padding:50px;">' .
				utf8_decode('Uno de tus DJs ha contactado con el cliente <strong>' . $this->session->userdata('nombre_novio') . ' ' . $this->session->userdata('apellidos_novio') . '</strong> (' . $this->session->userdata('email_novio') . ') y <strong>' . $this->session->userdata('nombre_novia') . ' ' . $this->session->userdata('apellidos_novia') . ')</strong> (' . $this->session->userdata('email_novia') . ') te ha escrito: ' . $_POST['mensaje']) . 'Accede a tu panel para ver la conversación completa.
											</div>
										  </td></tr>						
										
										  </td></tr>
								<tr>
									<td align="center"><img src="' . $footer_mail . '" width="100%"></td>
								</tr>
						  </table>
						  </body>
						  </html>';
			//mail($email_oficina, $asunto, utf8_decode($mensaje_oficina), $cabeceras);
			$this->sendEmail('info@exeleventos.com', [$email_oficina], $asunto, utf8_decode($mensaje_oficina));
			$this->db->query("INSERT INTO contacto (id_cliente, usuario, id_usuario, mensaje) VALUES ('" . $id_cliente . "','" . $usuario . "','" . $id_usuario . "','" . str_replace("'", "''", $_POST['mensaje']) . "')");

			redirect('clientedj/chat');
		}

		$this->_loadViews($data_header, $data, $data_footer, "chat");
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
					$this->db->query("UPDATE clientes SET clave = '" . $_POST['clave'] . "' WHERE id = " . $this->session->userdata('user_id') . "");
					$data['msg_clave'] = 'La contrase&ntilde;a ha sido cambiada con &eacute;xito';
				}
				if (isset($_POST['subir_foto']) && $_POST['subir_foto'] != '') {

					$config['upload_path'] = './uploads/foto_perfil/';
					$config['allowed_types'] = 'gif|jpg|png';
					$this->load->library('upload', $config);
					if (! $this->upload->do_upload("foto")) {
						$data['msg_foto'] = $this->upload->display_errors();
					} else {
						$data['upload_data'] = $this->upload->data();
						$this->clientedj_functions->UpdatefotoCliente($this->session->userdata('user_id'), $data['upload_data']['file_name']);
						$data['msg_foto'] = "La imagen se ha subido correctamente";
					}
				}
			}
			$data['cliente'] = $this->clientedj_functions->GetCliente($this->session->userdata('user_id'));
			$arr_servicios = unserialize($data['cliente']['servicios']);
			$arr_serv_keys = array_keys($arr_servicios);

			$data['servicios'] = $this->clientedj_functions->GetServicios(implode(",", $arr_serv_keys));
			$data['pagos'] = $this->clientedj_functions->GetPagos($this->session->userdata('user_id'));
			$data['dj'] = $this->clientedj_functions->GetDjAsignado($this->session->userdata('user_id'));
		}
		$this->_loadViews($data_header, $data, $data_footer, "cliente_details");
	}

	function events($acc = false)
	{

		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($_POST) {

			if (isset($_POST['add']))
				$this->clientedj_functions->InsertEvent($_POST['nombre']);

			if (isset($_POST['delete']))
				$this->clientedj_functions->DeleteEvent($_POST['elem']);
		}

		$data['momentos']  = $this->clientedj_functions->GetEvents();
		$view = "events_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}
	function servicios($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($acc == 'view' && $_POST) {

			$this->clientedj_functions->InsertServicio($_POST);
		}
		$data['servicios'] = $this->clientedj_functions->GetServicios();

		if ($acc == 'edit') {

			if ($_POST) {
				if (isset($_POST['delete'])) {
					$this->clientedj_functions->DeleteServicio($id);
				} else {
					$this->clientedj_functions->UpdateServicio($_POST, $id);
				}
				$data_header['scripts'] = "location.href='" . base_url() . "clientedj/servicios/view';";
			}
			$data['servicio'] = $this->clientedj_functions->GetServicio($id);
		}


		$this->_loadViews($data_header, $data, $data_footer,  "servicios_" . $acc);
	}

	public function canciones()
	{
		$data_header = false;
		$data_footer = false;


		if ($_POST) {

			if (isset($_POST['add_moment']))
				$this->clientedj_functions->InsertEvent($_POST['nombre_moment'], $this->session->userdata('user_id'));

			if (isset($_POST['add_song']))
				$this->clientedj_functions->InsertCancion($_POST, $this->session->userdata('user_id'));

			if (isset($_POST['add_comentario']))
				$this->clientedj_functions->InsertCancionComentario($_POST['momento_id'], $_POST['comentario'], $this->session->userdata('user_id'));
		}
		$data['events'] = $this->clientedj_functions->GetEvents($this->session->userdata('user_id'));
		$data['events_user'] = $this->clientedj_functions->GetmomentosUser($this->session->userdata('user_id'));
		$data['canciones_user'] = $this->clientedj_functions->GetcancionesUser($this->session->userdata('user_id'));
		$data['canciones_observaciones_momesp'] = $this->clientedj_functions->GetObservaciones_momesp($this->session->userdata('user_id'));
		$data['canciones_observaciones_general'] = $this->clientedj_functions->GetObservaciones_general($this->session->userdata('user_id'));
		$data['dj_asignado'] = $this->clientedj_functions->GetDJAsignado($this->session->userdata('user_id'));

		$str_mail = "Lista de canciones de usuario: " . $this->session->userdata('nombre_novia') . "(" . $this->session->userdata('email_novia') . ") & " . $this->session->userdata('nombre_novio') . "(" . $this->session->userdata('email_novio') . ")<br/><br/><br/>";
		if (isset($_POST['send_todj'])) {
			foreach ($data['events_user'] as $eu) {
				$str_mail .= "<h3>" . $eu['nombre'] . "</h3><ul>";
				foreach ($data['canciones_user'] as $c) {
					if ($eu['momento_id'] == $c['momento_id']) {
						$str_mail .= "<li>" . $c['artista'] . "-" . $c['cancion'] . "</li>";
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
			$this->sendEmail('info@exeleventos.com', [$email_dj], "Lista de canciones", $str_mail);
		}

		$this->_loadViews($data_header, $data, $data_footer, "canciones");
	}



	function informes($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($acc == 'view' && $_POST) {

			if (isset($_POST['valoraciones']))
				$this->clientedj_functions->InsertValoraciones($_POST, $this->session->userdata('user_id'));

			if (isset($_POST['incidencias']))
				$this->clientedj_functions->InsertIncidencias($_POST, $this->session->userdata('user_id'));

			if (isset($_POST['canciones']))
				$this->clientedj_functions->InsertCancionesPendientes($_POST, $this->session->userdata('user_id'));
		}
		$data['valoraciones'] = $this->clientedj_functions->GetValoraciones($this->session->userdata('user_id'));
		$data['juegos'] = $this->clientedj_functions->GetJuegos();
		$data['incidencias'] = $this->clientedj_functions->GetIncidencias($this->session->userdata('user_id'));
		$data['canciones_pendientes'] = $this->clientedj_functions->GetCancionesPendientes($this->session->userdata('user_id'));

		$this->_loadViews($data_header, $data, $data_footer,  "informes_" . $acc);
	}



	function persons($acc = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($_POST) {

			if (isset($_POST['add'])) {
				$id = $this->clientedj_functions->InsertPerson($_POST);

				$config['upload_path'] = './uploads/personas_contacto/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width']  = '200';

				$this->load->library('upload', $config);


				if (! $this->upload->do_upload("foto")) {
					$data['msg'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->clientedj_functions->UpdatefotoPerson($id, $data['upload_data']['file_name']);
					$data['msg'] = "La imagen se ha subido correctamente";
				}
			}
			if (isset($_POST['edit'])) {
				$this->clientedj_functions->UpdatePerson($_POST);
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
					$this->clientedj_functions->UpdatefotoPerson($_POST['foto_id'], $data['upload_data']['file_name']);
					$data['msg_change_foto'] = "La imagen se ha subido correctamente";
				}
			}
			if (isset($_POST['delete']))
				$this->clientedj_functions->DeletePerson($_POST['elem']);
		}

		$data['personas']  = $this->clientedj_functions->GetPersonasContacto();
		$view = "persons_" . $acc;
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

		$this->load->view('clientedj/header', $data_header);

		$this->load->view('clientedj/' . $view, $data);

		$this->load->view('clientedj/footer', $data_footer);
	}
	function _loadViewsHome($data_header, $data, $data_footer)

	{

		$this->load->view('clientedj/header', $data_header);

		$this->load->view('clientedj/home', $data);

		$this->load->view('clientedj/footer', $data_footer);
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
