<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->model('admin_functions');
		if (!$this->session->userdata('admin') && $this->router->method != 'login') {
			redirect('admin/login');
		}
		//echo $this->session->userdata('admin');
	}
	public function index($a = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		$this->_loadViewsHome($data_header, $data, $data_footer);
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('admin', 'location');
	}
	public function login()
	{
		$data = false;

		if ($_POST) {
			if ($_POST['email'] == "admin" && $_POST['pass'] == "a") {
				$this->session->set_userdata(array("admin" => true));
				redirect('admin', 'location');
			} else if ($_POST['email'] == "admin2" && $_POST['pass'] == "1492Bdj5319") {
				$this->session->set_userdata(array("admin" => true));
				redirect('admin', 'location');
			} else {
				$data['msg'] = 'Login o contrase&ntilde;a incorrecto';
			}
		}
		$this->load->view('admin/login', $data);
	}

	public function actualizar_orden_servicios()
	{
		$order = $this->input->post('order');
		if (!empty($order)) {
			$this->load->database();

			foreach ($order as $item) {
				$this->db->where('id', $item['id']);
				$result = $this->db->update('servicios', ['orden' => $item['orden']]);
				if ($result) {
					log_message('debug', 'Orden actualizado para ID: ' . $item['id'] . ' con orden: ' . $item['orden']);
				} else {
					log_message('error', 'Fallo al actualizar orden para ID: ' . $item['id']);
				}
			}
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos.']);
		}
	}


	public function restore_servicios()
	{
		$this->load->database();
		$query = $this->db->query("SELECT id, servicios FROM clientes");
		foreach ($query->result() as $fila)
			$clientes[] = $fila;


		foreach ($clientes as $c) {
			$query = $this->db->query("SELECT id, precio FROM servicios WHERE id IN ($c->servicios)");
			if ($query->num_rows() > 0) {
				$servicios = array();
				foreach ($query->result() as $fila)
					$servicios[$fila->id] = $fila->precio;

				$str_servicios = serialize($servicios);
				$this->db->query("UPDATE clientes SET servicios = '" . $str_servicios . "' WHERE id = {$c->id}");
			}
		}
	}

	public function parametrizacion()
	{
		if (isset($_POST['entidad'])) {
			$this->load->database();
			$data_cuentas_bancarias['entidad'] = $_POST['entidad'];
			$data_cuentas_bancarias['iban'] = $_POST['iban'];
			+$data_cuentas_bancarias['codigo_entidad'] = $_POST['codigo_entidad'];
			$data_cuentas_bancarias['codigo_oficina'] = $_POST['codigo_oficina'];
			$data_cuentas_bancarias['codigo_control'] = $_POST['codigo_control'];
			$data_cuentas_bancarias['numero_cuenta'] = $_POST['numero_cuenta'];
			$this->db->insert('cuentas_bancarias', $data_cuentas_bancarias);
		}

		if (isset($_POST['canal_captacion'])) {
			$this->load->database();
			$data['nombre'] = $_POST['canal_captacion'];
			$this->db->insert('canales_captacion', $data);
		}

		if (isset($_POST['momento_especial'])) {
			$this->load->database();
			$data['momento'] = $_POST['momento_especial'];
			$this->db->insert('bd_momentos_espec', $data);

			$id_momento_espec = $this->db->insert_id();

			$query = $this->db->query("SELECT id FROM clientes");
			foreach ($query->result() as $fila) {
				$data_momento['nombre'] = $_POST['momento_especial'];
				$data_momento['cliente_id'] = $fila->id;

				$this->db->insert('momentos_espec', $data_momento);
			}
		}

		if (isset($_POST['estado_solicitud'])) {
			$this->load->database();
			$data_estados['nombre_estado'] = $_POST['estado_solicitud'];
			$this->db->insert('estados_solicitudes', $data_estados);
		}

		if (isset($_POST['tipo_cliente']) && isset($_POST['color'])) {
			$this->load->database();
			$data_tipos_clientes['tipo_cliente'] = $_POST['tipo_cliente'];
			$data_tipos_clientes['color'] = $_POST['color'];
			$this->db->insert('tipos_clientes', $data_tipos_clientes);
		}

		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;
		$data['cuentas_bancarias'] = $this->admin_functions->GetCuentas_Bancarias();
		$data['captacion'] = $this->admin_functions->GetCaptacion();
		$data['momentos_especiales'] = $this->admin_functions->GetMomentos_Especiales();
		$data['estados_solicitudes'] = $this->admin_functions->GetEstados_Solicitudes();
		$data['tipos_clientes'] = $this->admin_functions->GetTiposClientes();
		$view = "parametrizacion";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	public function actualizar_orden_cuentas()
	{
		$order = $this->input->post('order');
		if (!empty($order)) {
			$this->load->database();

			foreach ($order as $item) {
				$this->db->where('id_cuenta', $item['id']);
				$this->db->update('cuentas_bancarias', ['orden' => $item['orden']]);
			}

			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos.']);
		}
	}

	public function actualizar_orden_canales()
	{
		$order = $this->input->post('order');
		if (!empty($order)) {
			$this->load->database();

			foreach ($order as $item) {
				$this->db->where('id', $item['id']);
				$this->db->update('canales_captacion', ['orden' => $item['orden']]);
			}

			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos.']);
		}
	}

	public function actualizar_orden_momentos()
	{
		$order = $this->input->post('order');
		if (!empty($order)) {
			$this->load->database();

			foreach ($order as $item) {
				$this->db->where('id_momento', $item['id']);
				$this->db->update('bd_momentos_espec', ['orden' => $item['orden']]);
			}

			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos.']);
		}
	}

	public function actualizar_orden_estados()
	{
		$order = $this->input->post('order');
		if (!empty($order)) {
			$this->load->database();

			foreach ($order as $item) {
				$this->db->where('id_estado', $item['id']);
				$this->db->update('estados_solicitudes', ['orden' => $item['orden']]);
			}

			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos.']);
		}
	}

	public function actualizar_orden_tipos_clientes()
	{
		$order = $this->input->post('order');
		if (!empty($order)) {
			$this->load->database();

			foreach ($order as $item) {
				$this->db->where('id_tipo_cliente', $item['id']);
				$this->db->update('tipos_clientes', ['orden' => $item['orden']]);
			}

			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos.']);
		}
	}



	public function mantenimiento_bd_canciones()
	{
		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;

		//$mes_actual=date("m");
		//$fecha_desde="2014-".$mes_actual."-01";
		$hoy = date("Y-m-d");
		$fecha_desde = strtotime('-60 day', strtotime($hoy));
		$fecha_desde = date('Y-m-d', $fecha_desde);
		$fecha_hasta = date("Y-m-d");
		$validada = "N";

		if ($_POST) {
			if ($_POST["fecha_desde"] <> "") {
				$fecha_desde = $_POST["fecha_desde"];
			}
			if ($_POST["fecha_hasta"] <> "") {
				$fecha_hasta = $_POST["fecha_hasta"];
			}
			if ($_POST["validada"] <> "S") {
				$validada = "N";
			} else {
				$validada = "S";
			}
		}

		$data['bd_canciones'] = $this->admin_functions->GetCancionesBD($fecha_desde, $fecha_hasta, $validada);
		$data['validada'] = $validada;
		$data['fecha_desde'] = $fecha_desde;
		$data['fecha_hasta'] = $fecha_hasta;
		$view = "mantenimiento_bd_canciones";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	public function mantenimiento_equipos()
	{
		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;

		$data['tab1'] = true;
		$data['tab2'] = false;

		if ($_POST) {
			if (isset($_POST['nombre_equipo'])) {
				$this->load->database();
				$datos['nombre_grupo'] = $_POST['nombre_equipo'];
				$this->db->insert('grupos_equipos', $datos);
			}

			if (isset($_POST['n_registro']) && $_POST['n_registro'] <> "" && $_POST['nombre_componente'] <> "" && $_POST['descripcion_componente'] <> "") {
				$this->load->database();

				//Comprobamos que NO existe un componente con ese número de serie
				$query = $this->db->query("SELECT COUNT(n_registro) as num FROM componentes WHERE n_registro='" . $_POST['n_registro'] . "'");
				foreach ($query->result() as $fila) {
					$num = $fila->num;
				}
				//Si no hay ninguno, añadimos
				if ($num == 0) {
					$datos['n_registro'] = $_POST['n_registro'];
					$datos['nombre_componente'] = $_POST['nombre_componente'];
					$datos['descripcion_componente'] = $_POST['descripcion_componente'];
					$this->db->insert('componentes', $datos);
				}
			}

			if (isset($_POST['modificar_equipo'])) {
				$this->load->database();
				$this->db->query("UPDATE grupos_equipos SET nombre_grupo = '" . $_POST['editar_nombre_equipo'] . "' WHERE id_grupo = " . $_POST['editar_grupo_equipos'] . "");
			}

			if (isset($_POST['modificar_componente'])) {
				$this->load->database();
				$this->db->query("UPDATE componentes SET nombre_componente = '" . $_POST['editar_nombre_componente'] . "', descripcion_componente = '" . $_POST['editar_descripcion_componente'] . "', n_registro = '" . $_POST['editar_n_registro'] . "' WHERE id_componente = " . $_POST['editar_grupo_componentes'] . "");
			}

			if (isset($_POST['asociar'])) {
				$this->load->database();
				$this->db->query("UPDATE componentes SET id_grupo = " . $_POST['grupo_equipos'] . " WHERE id_componente = " . $_POST['grupo_componentes'] . "");
			}

			if (isset($_POST['anadir_reparacion'])) {
				$this->load->database();
				$datos['id_componente'] = $_POST['reparacion_componente'];
				$datos['reparacion'] = $_POST['descripcion_reparacion'];
				$this->db->insert('reparaciones_componentes', $datos);
			}
		}

		$data['equipos'] = $this->admin_functions->GetEquipos();
		$data['componentes'] = $this->admin_functions->GetComponentes();
		$data['componentes_asociados'] = $this->admin_functions->GetComponentesAsociados();
		$data['componentes_no_asociados'] = $this->admin_functions->GetComponentesSinAsociar();

		$data['reparaciones_totales'] = $this->admin_functions->GetReparacionesTotales();



		$str_where = "";


		if (isset($_GET['p'])) {
			$data['page'] = $_GET['p'];
			$data['tab1'] = false;
			$data['tab2'] = true;
		} else {
			$data['page'] = 1;
		}

		if (isset($_GET['q'])) {
			if ($_GET['f'] == 'fecha_reparacion') {
				$date = strtotime($_GET['q']);
				$str_where = "WHERE DATE(" . $_GET['f'] . ") = '" . date('Y-m-d', $date) . "'";
			} else {
				$str_where = "WHERE " . $_GET['f'] . " LIKE '%" . $_GET['q'] . "%'";
			}

			$data['tab1'] = false;
			$data['tab2'] = true;
		}

		$query = $this->db->query("SELECT reparaciones_componentes.id_reparacion, componentes.n_registro, componentes.nombre_componente, reparaciones_componentes.fecha_reparacion, reparaciones_componentes.reparacion FROM componentes inner join reparaciones_componentes on componentes.id_componente=reparaciones_componentes.id_componente {$str_where}");
		$data['num_rows'] = $query->num_rows();

		$data['rows_page'] = 15;
		$data['last_page'] = ceil($data['num_rows'] / $data['rows_page']);

		$data['page'] = (int)$data['page'];
		if ($data['page'] > $data['last_page']) $data['page'] = $data['last_page'];
		if ($data['page'] < 1) $data['page'] = 1;

		$limit = 'LIMIT ' . ($data['page'] - 1) * $data['rows_page'] . ',' . $data['rows_page'];

		$ord = "fecha_reparacion";
		if (isset($_GET['ord']) && $_GET['ord'] != '') $ord = $_GET['ord'];

		$data['reparaciones'] = $this->admin_functions->GetReparaciones($str_where, $ord, $limit);

		$view = "mantenimiento_equipos";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}


	public function admin_eventos_view()
	{
		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;

		$hoy = date("Y-m-d");
		$fecha_desde = strtotime('-30 day', strtotime($hoy));
		$fecha_desde = date('Y-m-d', $fecha_desde);
		$fecha_hasta = date("Y-m-d");

		$oficina = 1; //MOSTRAMOS PREDETERMINADAMENTE BILBODJ

		if ($_POST) {
			if ($_POST["fecha_desde"] <> "") {
				$fecha_desde = $_POST["fecha_desde"];
			}
			if ($_POST["fecha_hasta"] <> "") {
				$fecha_hasta = $_POST["fecha_hasta"];
			}
			if ($_POST["oficina"] <> "") {
				$oficina = $_POST["oficina"];
			}
		}

		$data['fecha_desde'] = $fecha_desde;
		$data['fecha_hasta'] = $fecha_hasta;
		$data['oficina'] = $oficina;

		$data['oficinas'] = $this->admin_functions->GetOficinas();
		$data['tipos_clientes'] = $this->admin_functions->GetTiposClientes();
		$data['servicios'] = $this->admin_functions->GetServicios();
		$data['djs'] = $this->admin_functions->GetDJs();
		$data['eventos_view'] = $this->admin_functions->GetEventosView($fecha_desde, $fecha_hasta, $oficina);
		$data['eventos_totales'] = $this->admin_functions->GetEventosTotalesView($fecha_desde, $fecha_hasta, $oficina);
		$view = "admin_eventos_view";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}


	public function admin_contabilidad_clientes_view()
	{
		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;

		$hoy = date("Y-m-d");
		$fecha_desde = strtotime('-30 day', strtotime($hoy));
		$fecha_desde = date('Y-m-d', $fecha_desde);
		$fecha_hasta = date("Y-m-d");

		$oficina = 1; //MOSTRAMOS PREDETERMINADAMENTE BILBODJ

		if ($_POST) {
			if ($_POST["fecha_desde"] <> "") {
				$fecha_desde = $_POST["fecha_desde"];
			}
			if ($_POST["fecha_hasta"] <> "") {
				$fecha_hasta = $_POST["fecha_hasta"];
			}
			if ($_POST["oficina"] <> "") {
				$oficina = $_POST["oficina"];
			}
		}

		$data['fecha_desde'] = $fecha_desde;
		$data['fecha_hasta'] = $fecha_hasta;
		$data['oficina'] = $oficina;

		$data['oficinas'] = $this->admin_functions->GetOficinas();
		$data['contabilidad_clientes'] = $this->admin_functions->GetContabilidadClientes($fecha_desde, $fecha_hasta, $oficina);
		$data['contabilidad_total'] = $this->admin_functions->GetContabilidadTotal($fecha_desde, $fecha_hasta);
		/*$data['eventos_totales'] = $this->admin_functions->GetEventosTotalesView($fecha_desde,$fecha_hasta,$oficina);*/
		$view = "admin_contabilidad_clientes_view";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}


	public function admin_horas_djs_view()
	{
		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;

		$anio = date("Y");

		if ($_POST) {
			if ($_POST["anio"] <> "") {
				$anio = $_POST["anio"];
			}
		}

		$data['anio'] = $anio;


		$data['horas_anuales_djs'] = $this->admin_functions->GetHorasAnualesDJs($anio);
		$data['djs'] = $this->admin_functions->GetDJs();
		$view = "admin_horas_djs_view";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}


	function restaurantes($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		if ($acc == 'add') {
			if ($_POST) {
				$id = $this->admin_functions->InsertRestaurante($_POST);
				//redirect(base_url().'admin/clientes/view');
				redirect('admin/restaurantes/view');
			}
		}
		if ($acc == 'view') {
			$this->load->database();
			if ($id) {
				if ($_POST) {
					if (isset($_POST['enviar_archivo'])) {
						$config['upload_path'] = './uploads/restaurantes/';
						$config['allowed_types'] = 'gif|jpg|png|pdf|doc';
						//$config['max_width']  = '600';

						$this->load->library('upload', $config);


						if (! $this->upload->do_upload("archivo")) {
							$data['msg'] = $this->upload->display_errors();
						} else {
							$data['upload_data'] = $this->upload->data();
							$data['nombre_archivo'] = $data['upload_data']['file_name'];
							$this->db->query("INSERT INTO restaurantes_archivos VALUES('', '" . $id . "', '" . $data['nombre_archivo'] . "', '" . $_POST['descripcion_archivo'] . "')");
						}
						//redirect(base_url().'admin/clientes/view');
						redirect('admin/restaurantes/view/' . $id);
					}
				}
				$data['restaurante'] = $this->admin_functions->GetRestaurante($id);
				$data['archivos_restaurante'] = $this->admin_functions->GetArchivosRestaurante($id);
				$acc = "viewdetails";
			}
			if ($_POST) {
				if (isset($_POST['delete_restaurante'])) {

					$query = $this->db->query("SELECT archivo FROM restaurantes_archivos WHERE id_restaurante = " . $_POST['id'] . "");
					foreach ($query->result() as $fila) {
						$archivo = './uploads/restaurantes/' . $fila->archivo;
						if (file_exists($archivo)) {
							unlink($archivo);
						}
					}

					$this->db->query("DELETE FROM restaurantes WHERE id_restaurante = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM restaurantes_archivos WHERE id_restaurante = " . $_POST['id'] . "");
				}
			}

			$str_where = "";

			if (isset($_GET['p']))
				$data['page'] = $_GET['p'];
			else
				$data['page'] = 1;

			if (isset($_GET['q'])) {

				$str_where = "WHERE " . $_GET['f'] . " LIKE '%" . $_GET['q'] . "%'";
			}

			$query = $this->db->query("SELECT id_restaurante FROM restaurantes {$str_where}");
			$data['num_rows'] = $query->num_rows();

			$data['rows_page'] = 15;
			$data['last_page'] = ceil($data['num_rows'] / $data['rows_page']);

			$data['page'] = (int)$data['page'];
			if ($data['page'] > $data['last_page']) $data['page'] = $data['last_page'];
			if ($data['page'] < 1) $data['page'] = 1;

			$limit = 'LIMIT ' . ($data['page'] - 1) * $data['rows_page'] . ',' . $data['rows_page'];

			$ord = "id_restaurante";
			if (isset($_GET['ord']) && $_GET['ord'] != '') $ord = $_GET['ord'];

			$data['restaurantes'] = $this->admin_functions->GetRestaurantes($str_where, $ord, $limit);
		}

		$view = "restaurantes_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}



	function clientes($acc = false, $id = false)
	{

		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($acc == 'add') {
			$data['captacion'] = $this->admin_functions->GetCaptacion();
			$data['oficinas'] = $this->admin_functions->GetOficinas();
			$data['servicios'] = $this->admin_functions->GetServicios();
			$data['personas']  = $this->admin_functions->GetPersonasContacto();
			$data['tipos_clientes'] = $this->admin_functions->GetTiposClientes();
			$data['restaurantes'] = $this->admin_functions->GetRestaurantesTotales();
			if ($_POST) {

				$id = $this->admin_functions->InsertCliente($_POST);
				$config['upload_path'] = './uploads/foto_perfil/';
				$config['allowed_types'] = 'gif|jpg|png';
				//$config['max_width']  = '600';

				$this->load->library('upload', $config);


				if (! $this->upload->do_upload("foto")) {
					$data['msg'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->admin_functions->UpdatefotoCliente($id, $data['upload_data']['file_name']);
					//$data['msg'] = "La imagen se ha subido correctamente";

				}
				//redirect(base_url().'admin/clientes/view');
				redirect('admin/clientes/view');
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

					if (isset($_POST['update_canal_captacion'])) {
						$this->db->query("UPDATE clientes SET canal_captacion = '" . $_POST['canal_captacion'] . "' WHERE id = {$id}");
					}

					if (isset($_POST['update_oficina'])) {
						$this->db->query("UPDATE clientes SET id_oficina = '" . $_POST['oficina'] . "' WHERE id = {$id}");
					}

					if (isset($_POST['update_tipo_cliente'])) {
						$this->db->query("UPDATE clientes SET id_tipo_cliente = '" . $_POST['tipo_cliente'] . "' WHERE id = {$id}");
					}

					if (isset($_POST['update_enviar_emails'])) {
						$this->db->query("UPDATE clientes SET enviar_emails = '" . $_POST['enviar_emails'] . "' WHERE id = {$id}");
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
						if (isset($_POST['tipo_pago'])) {
							$_POST['tipo_pago'] = 'B';
						} else {
							$_POST['tipo_pago'] = 'A';
						}
						$this->db->query("INSERT INTO pagos (cliente_id, valor, tipo) VALUES ({$id}, '" . str_replace(',', '.', $_POST['valor']) . "', '" . $_POST['tipo_pago'] . "')");

						//MANDAMOS UN E-MAIL A LOS CLIENTES SI SE HA MARCADO LA OPCIÓN Y CUANDO SE HAYA REALIZADO UN PAGO EN A QUE NO ES DE 0€
						//if(isset($_POST['enviar_email_pago']) && $_POST['tipo_pago']=='A' && $_POST['valor']>0){

						if (isset($_POST['enviar_email_pago']) && $_POST['valor'] > 0 || true) {
							//BUSCAMOS QUÉ NÚMERO DE PAGO ES: SEÑAL, 50% O FINAL
							$query = $this->db->query("SELECT COUNT(valor) as num_pagos FROM pagos WHERE cliente_id = {$id}");
							foreach ($query->result() as $fila) {
								$num_pagos = $fila->num_pagos;
							}

							$query = $this->db->query("SELECT email_novio, email_novia, id_oficina FROM clientes WHERE id = {$id}");
							foreach ($query->result() as $fila) {
								$email_novio = $fila->email_novio;
								$email_novia = $fila->email_novia;
								$id_oficina = $fila->id_oficina;
							}

							$query = $this->db->query("SELECT email, logo_mail FROM oficinas WHERE id_oficina = {$id_oficina}");
							foreach ($query->result() as $fila) {
								$email_oficina = $fila->email;
								$logo_mail_oficina = $fila->logo_mail;
							}

							$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
							$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
							$cabeceras .= 'From: ' . $email_oficina;

							if ($num_pagos == 1) {
								$asunto = 'Pago inicial - BILBODJ';
								$contenido_mensaje_pagos = '
								<p>Hola,</p>
								<p>Hemos recibido correctamente el pago de la señal. Podéis comprobar el estado de pagos en vuestro perfil IntraBoda.</p>
								<p>¡Gracias por confiar en EXEL Eventos S.L!</p>
								<p>Atentamente, Administración EXEL Eventos </p>
								';
							} elseif ($num_pagos == 2) {
								$asunto = 'Pago del 50% - BILBODJ';
								$contenido_mensaje_pagos = '
								<p>Hola,</p>
								<p>Hemos recibido correctamente el pago correspondiente al 50% del total del evento. Podéis comprobar el estado de pagos en vuestro perfil IntraBoda.</p>
								<p>¡Gracias por confiar en EXEL Eventos S.L!</p>
								<p>Atentamente, Administración EXEL Eventos </p>
								';
							} else {
								$asunto = 'Pago final - BILBODJ';
								$contenido_mensaje_pagos = '
								<p>Hola,</p>
								<p>Hemos recibido correctamente el pago final del evento. Podéis comprobar el estado de pagos en vuestro perfil IntraBoda. ¡Ha sido un placer trabajar con vosotros!</p>
								<p>¡Un saludo y hasta pronto!</p>
								<p>Atentamente, Administración EXEL Eventos </p>
								';
							}

							$mensaje = '<table border="0" width="100%">
							<tr>
								<td>
									<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
								</td>
							</tr>
							<tr>
								<td align="justify">
								<div style="padding:50px;">
								' . $contenido_mensaje_pagos . '
								</div>
									 
								</td>
								</tr>
							<tr>
								<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
							</tr>
							</table>';

							$asunto = html_entity_decode($asunto);
							$mensaje = html_entity_decode($mensaje);

							/* mail($email_novio, $asunto, $mensaje, $cabeceras);
                              mail($email_novia, $asunto, $mensaje, $cabeceras); */

							$this->sendEmail('info@exeleventos.com', [$email_novio, $email_novia], $asunto, $mensaje);
						}
					}
					if (isset($_POST['update_servicios'])) {
						/*$servicios = implode(",", $_POST['servicios']);*/
						$servicios = serialize($_POST['servicios']);
						$this->db->query("UPDATE clientes SET servicios = '" . $servicios . "' WHERE id = {$id}");
					}
					if (isset($_POST['add_observ'])) {
						$this->db->query("INSERT INTO observaciones (id_cliente,comentario) VALUES ({$id}, '" . str_replace("'", "''", $_POST['observaciones']) . "')");
					}

					if (isset($_POST['update_dj'])) {
						//ACTUALIZAMOS LA TABLA DE HORAS CON EL NUEVO DJ O EN BLANCO SI EL DJ LO DEJAMOS SIN ASIGNAR//
						$this->db->query("UPDATE horas_djs SET id_dj = '" . $_POST['dj_id'] . "' WHERE id_cliente = {$id}");

						//MANDAMOS MAIL AL CLIENTE CON LA ASIGNACION DEL DJ//
						$query = $this->db->query("SELECT email_novio, email_novia, dj, enviar_emails FROM clientes WHERE id = {$id}");
						foreach ($query->result() as $fila) {
							$email_novio = $fila->email_novio;
							$email_novia = $fila->email_novia;
							$id_dj = $fila->dj;
							$enviar_emails = $fila->enviar_emails;
						}

						if ($id_dj <> "") {
							$query = $this->db->query("SELECT nombre FROM djs WHERE id = {$id_dj}");
							if ($query->num_rows() > 0) {
								foreach ($query->result() as $fila) {
									$nombre_dj_viejo = $fila->nombre;
								}
							}
						}

						if ($_POST['dj_id'] <> "") {
							$query = $this->db->query("SELECT nombre, email FROM djs WHERE id = {$_POST['dj_id']}");
							if ($query->num_rows() > 0) {
								foreach ($query->result() as $fila) {
									$nombre_dj_nuevo = $fila->nombre;
									$email_dj_nuevo = $fila->email;
								}
							}

							if ($enviar_emails == "S" && $_POST['dj_id'] <> "") {
								$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
								$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
								$cabeceras .= 'From: ' . $email_dj_nuevo;

								if (isset($nombre_dj_viejo)) {


									$asunto = 'Cambio de DJ!!';
									$mensaje = '<table border="0" width="100%">
								<tr>
									<td>
										<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
									</td>
								</tr>
								<tr>
									<td align="justify">
									<div style="padding:50px;">
										<p>¡¡Hola!!</p>
													 
										<p>Vuestro DJ ' . $nombre_dj_viejo . ', ha causado baja de forma indefinida.</p>
										
										<p>Hola soy ' . $nombre_dj_nuevo . ' y seré vuestro nuevo DJ Animador.</p>
										 
										<p>Tengo acceso a toda la información que habíais dejado hasta el momento y seguiremos procediendo del mismo modo.</p>
										
										<p>Para cualquier cuestión, puedes contactar con mis compañeros de la oficina en el 94 652 18 39.</p>
										
										<p>¡Gracias por confiar en nosotros!</p>
									</div>
										 
									</td>
									</tr>
									<tr>
										<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
									</tr>
								</table>';
								} else {
									$asunto = 'Ya tienes asignado un DJ!!';
									$mensaje = '<table border="0" width="100%">
								<tr>
									<td>
										<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
									</td>
								</tr>
								<tr>
									<td align="justify">
									<div style="padding:50px;">
									
									<p>¡¡Hola!!</p>
													 
										<p>Hola soy ' . $nombre_dj_nuevo . ' y seré vuestro nuevo DJ Animador.</p>
										 
										<p>Ya tenéis asignado mi contacto dentro de vuestro perfil.  Estaré al tanto de todo lo que vayáis incluyendo.</p>
										
										<p>El lunes de la semana del evento contactaré con vosotros para contrastar toda esa información. Para cualquier otra cuestión hasta entonces, podéis contactar conmigo o con cualquiera de mis compañeros de la oficina.</p>
										
										<p>No olvidéis plasmar en el campo de “Observaciones” todos los detalles que queréis que tenga presentes en el evento (estilos musicales, dedicatorias, momentos especiales,…).</p>
										
										<p>¡Seguimos en contacto! Quedo a vuestra entera disposición.</p>
										
										<p>¡Un saludo!</p>
									</div>
										 
									</td>
									</tr>
									<tr>
										<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
									</tr>
								</table>';
								}

								$asunto = html_entity_decode($asunto);
								$mensaje = html_entity_decode($mensaje);

								/* mail($email_novio, $asunto, $mensaje, $cabeceras);
                                  mail($email_novia, $asunto, $mensaje, $cabeceras); */
								$this->sendEmail('info@exeleventos.com', [$email_novio, $email_novia], $asunto, $mensaje);
							}
						}

						//MANDAMOS MAIL AL DJ  COMENTANDO LA ASIGNACION DE UN CLIENTE// 
						if ($_POST['dj_id'] <> "") {
							$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
							$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
							$cabeceras .= 'From: info@exeleventos.com';

							$asunto = 'Nuevo cliente asignado - BilboDJ';
							$mensaje = '<table border="0" width="100%">
							<tr>
									<td>
										<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
									</td>
								</tr>
								<tr>
									<td align="justify">
									<div style="padding:50px;">
									
									<p>¡¡Hola!!</p>
													 
										<p>Tienes un nuevo cliente asignado, revisa tu perfil de DJ.</p>
										 
									</div>
										 
									</td>
									</tr>
									<tr>
										<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
									</tr>
								</table>';
							$asunto = html_entity_decode($asunto);
							$mensaje = html_entity_decode($mensaje);

							//mail($email_dj_nuevo, $asunto, $mensaje, $cabeceras);
							$this->sendEmail('info@exeleventos.com', [$email_dj_nuevo], $asunto, $mensaje);
						}



						$this->db->query("UPDATE clientes SET dj = '" . $_POST['dj_id'] . "' WHERE id = {$id}");
					}

					if (isset($_POST['update_equipo_componentes'])) {
						if ($_POST['equipo_componentes'] == "") {
							$_POST['equipo_componentes'] = NULL;
						}
						$this->db->query("UPDATE clientes SET equipo_componentes = '" . $_POST['equipo_componentes'] . "' WHERE id = {$id}");
					}

					if (isset($_POST['update_equipo_luces'])) {
						if ($_POST['equipo_luces'] == "") {
							$_POST['equipo_luces'] = NULL;
						}
						$this->db->query("UPDATE clientes SET equipo_luces = '" . $_POST['equipo_luces'] . "' WHERE id = {$id}");
					}

					if (isset($_POST['update_equipo_extra1'])) {
						if ($_POST['equipo_extra1'] == "") {
							$_POST['equipo_extra1'] = NULL;
						}
						$this->db->query("UPDATE clientes SET equipo_extra1 = '" . $_POST['equipo_extra1'] . "' WHERE id = {$id}");
					}

					if (isset($_POST['update_equipo_extra2'])) {
						if ($_POST['equipo_extra2'] == "") {
							$_POST['equipo_extra2'] = NULL;
						}
						$this->db->query("UPDATE clientes SET equipo_extra2 = '" . $_POST['equipo_extra2'] . "' WHERE id = {$id}");
					}

					if (isset($_POST['generar_factura'])) {
						session_start(); //Sesión para controlar que admin pueda acceder a todas las fichas de los clientes
						if ($this->session->userdata('admin') == 1) {
							$_SESSION['id_dj'] =  'admin';
						}
						header('Location: ' . base_url() . 'informes/factura.php?id_cliente=' . $id . '&cif=' . $_POST['cif'] . '&fecha_factura=' . $_POST['fecha_factura'] . '&facturar_a=' . $_POST['facturar_a'] . '&direccion=' . $_POST['direccion'] . '&poblacion=' . $_POST['poblacion'] . '&cp=' . $_POST['cp'] . '&telefono=' . $_POST['telefono'] . '&email=' . $_POST['email'] . '&n_factura=' . $_POST['n_factura'] . '&concepto=' . $_POST['concepto']);
					}

					if (isset($_POST['horas_concepto']) && isset($_POST['horas_dj']) && $_POST['horas_concepto'] <> "" && $_POST['horas_dj'] <> "") {
						//Buscamos el dj asignado a la boda
						$query = $this->db->query("SELECT dj FROM clientes WHERE id = {$id}");
						if ($query->num_rows() > 0) {
							foreach ($query->result() as $fila) {
								$id_dj = $fila->dj;
							}
						}
						$this->db->query("INSERT INTO horas_djs (id_cliente,id_dj,concepto,horas_dj) VALUES ({$id}, {$id_dj}, '" . str_replace("'", "''", $_POST['horas_concepto']) . "', '" . str_replace(",", ".'", $_POST['horas_dj']) . "')");
					}
				}
				$data['captacion'] = $this->admin_functions->GetCaptacion();
				$data['oficinas'] = $this->admin_functions->GetOficinas();
				$data['tipos_clientes'] = $this->admin_functions->GetTiposClientes();
				$data['servicios'] = $this->admin_functions->GetServicios();
				$data['personas']  = $this->admin_functions->GetPersonasContacto();
				$data['dj'] = $this->admin_functions->GetDjAsignado($id);
				$data['djs'] = $this->admin_functions->GetDjs($id);
				$data['horas_dj'] = $this->admin_functions->GetHorasDJ($id);
				$data['preguntas_encuesta_datos_boda'] = $this->admin_functions->GetPreguntasEncuestaDatosBoda();
				$data['respuestas_encuesta_datos_boda'] = $this->admin_functions->GetRespuestasEncuestaDatosBoda($id);
				$data['equipos_disponibles'] = $this->admin_functions->GetEquiposDisponibles($id);
				$data['componentes'] = $this->admin_functions->GetComponentes();
				$data['equipo_componentes_asignado'] = $this->admin_functions->GetEquiposComponentesAsignado($id);
				$data['equipo_luces_asignado'] = $this->admin_functions->GetEquiposLucesAsignado($id);
				$data['equipo_extra1_asignado'] = $this->admin_functions->GetEquiposExtra1Asignado($id);
				$data['equipo_extra2_asignado'] = $this->admin_functions->GetEquiposExtra2Asignado($id);
				$data['reparaciones_totales'] = $this->admin_functions->GetReparacionesTotales();
				$data['cliente'] = $this->admin_functions->GetCliente($id);
				$data['pagos'] = $this->admin_functions->GetPagos($id);
				$data['factura'] = $this->admin_functions->GetFactura($id);
				$data['observaciones_cliente'] = $this->admin_functions->GetObservaciones($id);
				$data['valoraciones'] = $this->admin_functions->GetValoraciones($id);
				$data['juegos'] = $this->admin_functions->GetJuegos();
				$data['incidencias'] = $this->admin_functions->GetIncidencias($id);
				$data['canciones_pendientes'] = $this->admin_functions->GetCancionesPendientes($id);
				$data['restaurantes'] = $this->admin_functions->GetRestaurantesTotales();
				$acc = "viewdetails";
			} else {
				if ($_POST) {

					$this->db->query("DELETE FROM clientes WHERE id = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM canciones WHERE client_id = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM canciones_observaciones WHERE client_id  = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM momentos_espec WHERE cliente_id  = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM pagos WHERE cliente_id = " . $_POST['id'] . "");

					$this->db->query("DELETE FROM galeria WHERE client_id   = " . $_POST['id'] . "");

					$this->db->query("DELETE FROM respuestas_valoracion WHERE id_cliente = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM incidencias WHERE id_cliente = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM canciones_pendientes WHERE id_cliente = " . $_POST['id'] . "");
					$this->db->query("DELETE FROM contacto WHERE id_cliente = " . $_POST['id'] . "");

					$dir = exec("pwd");

					system("rm -rf $dir/uploads/gallery/" . $_POST['id']);
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
				$query = $this->db->query("SELECT clientes.id FROM clientes INNER JOIN restaurantes ON clientes.id_restaurante=restaurantes.id_restaurante {$str_where}");
				$data['num_rows'] = $query->num_rows();

				$data['rows_page'] = 15;
				$data['last_page'] = ceil($data['num_rows'] / $data['rows_page']);

				$data['page'] = (int)$data['page'];
				if ($data['page'] > $data['last_page']) $data['page'] = $data['last_page'];
				if ($data['page'] < 1) $data['page'] = 1;

				$limit = 'LIMIT ' . ($data['page'] - 1) * $data['rows_page'] . ',' . $data['rows_page'];

				$ord = "fecha";
				if (isset($_GET['ord']) && $_GET['ord'] != '') $ord = $_GET['ord'];

				$data['clientes'] = $this->admin_functions->GetClientes($str_where, $ord, $limit);
				$data['tipos_clientes'] = $this->admin_functions->GetTiposClientes();
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
				$this->admin_functions->InsertEvent($_POST['nombre']);

			if (isset($_POST['delete']))
				$this->admin_functions->DeleteEvent($_POST['elem']);
		}

		$data['momentos']  = $this->admin_functions->GetEvents();
		$view = "events_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}
	function servicios($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($acc == 'view' && $_POST) {

			$this->admin_functions->InsertServicio($_POST);
		}
		$data['servicios'] = $this->admin_functions->GetServicios();

		if ($acc == 'edit') {

			if ($_POST) {
				if (isset($_POST['delete'])) {
					$this->admin_functions->DeleteServicio($id);
				} else {
					$this->admin_functions->UpdateServicio($_POST, $id);
				}
				//$data_header['scripts'] = "location.href='".base_url()."admin/servicios/view';";
				header('Location:' . base_url() . "admin/servicios/view");
			}
			$data['servicio'] = $this->admin_functions->GetServicio($id);
		}


		$this->_loadViews($data_header, $data, $data_footer,  "servicios_" . $acc);
	}
	function persons($acc = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($_POST) {

			if (isset($_POST['add'])) {
				$id = $this->admin_functions->InsertPerson($_POST);

				$config['upload_path'] = './uploads/personas_contacto/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width']  = '200';

				$this->load->library('upload', $config);


				if (! $this->upload->do_upload("foto")) {
					$data['msg'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->admin_functions->UpdatefotoPerson($id, $data['upload_data']['file_name']);
					$data['msg'] = "La imagen se ha subido correctamente";
				}
			}
			if (isset($_POST['edit'])) {
				$this->admin_functions->UpdatePerson($_POST);
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
					$this->admin_functions->UpdatefotoPerson($_POST['foto_id'], $data['upload_data']['file_name']);
					$data['msg_change_foto'] = "La imagen se ha subido correctamente";
				}
			}
			if (isset($_POST['delete']))
				$this->admin_functions->DeletePerson($_POST['elem']);
		}

		$data['personas']  = $this->admin_functions->GetPersonasContacto();
		$view = "persons_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}
	function djs($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($_POST) {

			if (isset($_POST['add'])) {
				$id = $this->admin_functions->InsertDJ($_POST);

				$config['upload_path'] = './uploads/djs/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width']  = '200';

				$this->load->library('upload', $config);


				if (! $this->upload->do_upload("foto")) {
					$data['msg'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->admin_functions->UpdatefotoDJ($id, $data['upload_data']['file_name']);
					$data['msg'] = "La imagen se ha subido correctamente";
				}
			}
			if (isset($_POST['edit'])) {
				$this->admin_functions->UpdateDJ($_POST);
			}
			if (isset($_POST['change_foto'])) {

				$config['upload_path'] = './uploads/djs/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width']  = '200';

				$this->load->library('upload', $config);


				if (! $this->upload->do_upload("foto_edit")) {
					$data['msg_change_foto'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->admin_functions->UpdatefotoDJ($_POST['foto_id'], $data['upload_data']['file_name']);
					$data['msg_change_foto'] = "La imagen se ha subido correctamente";
				}
			}
			if (isset($_POST['delete']))
				$this->admin_functions->DeleteDJ($_POST['elem']);
		}

		if ($acc == 'view') {
			$this->load->database();
			if ($id) {
				$ano_contrato = date("Y");
				$ano_nomina = date("Y");
				if ($_POST) {
					if (isset($_POST['anadir_contrato'])) {
						unset($_POST['anadir_contrato']);

						$config['upload_path'] = './uploads/contratos_djs/';
						$config['allowed_types'] = 'pdf';
						//$config['max_width']  = '600';

						$this->load->library('upload', $config);


						if (! $this->upload->do_upload("contrato_pdf")) {
							$data['msg'] = $this->upload->display_errors();
						} else {
							$data['upload_data'] = $this->upload->data();
							$_POST['contrato_pdf'] = $data['upload_data']['file_name'];
							unset($_POST['ano_contrato']);
							$this->admin_functions->InsertContratoDJ($_POST);
						}
					}

					if (isset($_POST['anadir_nomina'])) {
						unset($_POST['anadir_nomina']);

						$config['upload_path'] = './uploads/nominas_djs/';
						$config['allowed_types'] = 'pdf';
						//$config['max_width']  = '600';

						$this->load->library('upload', $config);


						if (! $this->upload->do_upload("nomina_pdf")) {
							$data['msg'] = $this->upload->display_errors();
						} else {
							$data['upload_data'] = $this->upload->data();
							$_POST['nomina_pdf'] = $data['upload_data']['file_name'];
							unset($_POST['ano_nomina']);
							$this->admin_functions->InsertNominaDJ($_POST);
						}
					}

					if (isset($_POST['buscar_contrato'])) {
						unset($_POST['buscar_contrato']);
						$ano_contrato = $_POST['ano_contrato'];
					}

					if (isset($_POST['buscar_nomina'])) {
						unset($_POST['buscar_nomina']);
						$ano_nomina = $_POST['ano_nomina'];
					}
				}

				$data['dj'] = $this->admin_functions->GetDJ($id);
				$data['contratos'] = $this->admin_functions->GetDJContratos($id, $ano_contrato);
				$data['nominas'] = $this->admin_functions->GetDJNominas($id, $ano_nomina);
				$acc = "viewdetails";
			}
			$data['djs']  = $this->admin_functions->GetDJs();
		}
		$view = "djs_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}


	function comerciales($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
		if ($_POST) {

			if (isset($_POST['add'])) {

				$config['upload_path'] = './uploads/comerciales/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width']  = '200';

				$this->load->library('upload', $config);

				if (isset($_POST['solo_eventos'])) {
					$_POST['solo_eventos'] = 'S';
				} else {
					$_POST['solo_eventos'] = 'N';
				}

				$id = $this->admin_functions->InsertComercial($_POST);


				if (! $this->upload->do_upload("foto")) {
					$data['msg'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->admin_functions->UpdatefotoComercial($id, $data['upload_data']['file_name']);
					$data['msg'] = "La imagen se ha subido correctamente";
				}
			}
			if (isset($_POST['edit'])) {
				$this->admin_functions->UpdateComercial($_POST);
			}
			if (isset($_POST['change_foto'])) {

				$config['upload_path'] = './uploads/comerciales/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width']  = '200';

				$this->load->library('upload', $config);


				if (! $this->upload->do_upload("foto_edit")) {
					$data['msg_change_foto'] = $this->upload->display_errors();
				} else {
					$data['upload_data'] = $this->upload->data();
					$this->admin_functions->UpdatefotoComercial($_POST['foto_id'], $data['upload_data']['file_name']);
					$data['msg_change_foto'] = "La imagen se ha subido correctamente";
				}
			}
			if (isset($_POST['delete']))
				$this->admin_functions->DeleteComercial($_POST['elem']);
		}

		if ($acc == 'view') {
			$this->load->database();

			$data['comerciales']  = $this->admin_functions->GetComerciales();
			$data['oficinas']  = $this->admin_functions->GetOficinas();
		}
		$view = "comerciales_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	public function estadisticas()
	{
		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;

		$hoy = date("Y-m-d");
		$fecha_desde = strtotime('-60 day', strtotime($hoy));
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

		$data['fecha_desde'] = $fecha_desde;
		$data['fecha_hasta'] = $fecha_hasta;

		$data['servicios_contratados'] = $this->admin_functions->GetEstadisticaServicios($fecha_desde, $fecha_hasta);
		$data['canales_captacion'] = $this->admin_functions->GetEstadisticaCanalesCaptacion($fecha_desde, $fecha_hasta);

		$data['estados_solicitudes'] = $this->admin_functions->GetEstados_Solicitudes();
		$data['comerciales'] = $this->admin_functions->GetEstadisticaComerciales($fecha_desde, $fecha_hasta);

		$data['preguntas_encuesta'] = $this->admin_functions->GetPreguntasEncuesta();
		$data['respuestas_preguntas'] = $this->admin_functions->GetRespuestasPreguntas();
		$data['estadistica_encuestas'] = $this->admin_functions->GetEstadisticaEncuestas($fecha_desde, $fecha_hasta);

		$view = "estadisticas";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	public function eventos()
	{
		if (isset($_POST['evento'])) {
			$this->load->database();
			$data['nombre_evento'] = $_POST['evento'];
			$this->db->insert('eventos', $data);
		}

		if (isset($_POST['anadir_descuento'])) {
			$this->load->database();
			$data['nombre'] = $_POST['nombre_descuento'];
			$servicios = array();
			$servicios = $_POST['servicios'];
			$data['servicios'] = $servicios;
			$data['servicios'] = implode(",", $data['servicios']);
			$data['fecha_desde'] = $_POST['fecha_desde_descuento'];
			$data['fecha_hasta'] = $_POST['fecha_hasta_descuento'];
			$data['importe'] = $_POST['importe_descuento'];
			$this->db->insert('descuento_presupuesto_eventos', $data);
		}


		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;
		$data['eventos'] = $this->admin_functions->GetEventos();
		$data['servicios'] = $this->admin_functions->GetServicios();
		$data['descuentos'] = $this->admin_functions->GetDescuentos();
		$view = "eventos";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}


	public function oficinas()
	{
		if (isset($_POST['add'])) {
			$id = $this->admin_functions->InsertOficina($_POST);

			$config['upload_path'] = './uploads/oficinas/';
			$config['allowed_types'] = 'gif|jpg|png';
			//$config['max_width']  = '200';

			$this->load->library('upload', $config);

			if (! $this->upload->do_upload("logo_mail")) {
				$data['msg'] = $this->upload->display_errors();
			} else {
				$data['upload_data'] = $this->upload->data();
				$this->admin_functions->UpdateLogoMailOficina($id, $data['upload_data']['file_name']);
				$data['msg'] = "La imagen se ha subido correctamente";
			}
		}

		if (isset($_POST['edit'])) {
			$this->admin_functions->UpdateOficina($_POST);
		}

		if (isset($_POST['change_logo_mail'])) {

			$config['upload_path'] = './uploads/oficinas/';
			$config['allowed_types'] = 'gif|jpg|png';
			//$config['max_width']  = '200';

			$this->load->library('upload', $config);

			if (! $this->upload->do_upload("logo_mail_edit")) {
				$data['msg_change_foto'] = $this->upload->display_errors();
			} else {
				$data['upload_data'] = $this->upload->data();
				$this->admin_functions->UpdateLogoMailOficina($_POST['logo_mail_id'], $data['upload_data']['file_name']);
				$data['msg_change_foto'] = "La imagen se ha subido correctamente";
			}
		}

		if (isset($_POST['delete'])) {
			$this->admin_functions->DeleteOficina($_POST['elem']);
		}

		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;
		$data['oficinas'] = $this->admin_functions->GetOficinas();

		$view = "oficinas";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	public function encuesta()
	{
		if (isset($_POST['pregunta']) && $_POST['pregunta'] <> "") {
			$this->load->database();
			$data['pregunta'] = $_POST['pregunta'];
			$data['importe_descuento'] = $_POST['importe_descuento'];
			$this->db->insert('preguntas_encuesta', $data);
		}

		if (isset($_POST['respuesta']) && $_POST['respuesta'] <> "") {
			$this->load->database();
			$data['id_pregunta'] = $_POST['id_pregunta'];
			$data['respuesta'] = $_POST['respuesta'];
			$this->db->insert('respuestas_encuesta', $data);
		}


		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;
		$data['preguntas_encuesta'] = $this->admin_functions->GetPreguntasEncuesta();
		$data['respuestas_preguntas'] = $this->admin_functions->GetRespuestasPreguntas();

		$view = "encuesta";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}




	public function facturas($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		if ($acc == 'add') {
			if ($_POST) {
				if (isset($_POST['anadir_factura'])) {
					$id = $this->admin_functions->InsertFacturaManual($_POST);
				}
			}
		}
		if ($acc == 'view') {
			$this->load->database();
			if ($id) {
				if ($_POST) {
					if (isset($_POST['cambiar_tipo_factura'])) {
						$this->db->query("UPDATE facturas_manuales SET tipo_factura='" . $_POST['tipo_factura'] . "' WHERE id_factura='{$id}'");
						redirect('admin/facturas/view/' . $id);
					}
				}
				$data['factura'] = $this->admin_functions->GetFacturaManual($id);
				$data['cliente'] = $this->admin_functions->GetCliente($id);
				$acc = "viewdetails";
			}

			$hoy = date("Y-m-d");
			$fecha_desde = strtotime('-60 day', strtotime($hoy));
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

			$data['fecha_desde'] = $fecha_desde;
			$data['fecha_hasta'] = $fecha_hasta;
			$data['facturas'] = $this->admin_functions->GetFacturas($fecha_desde, $fecha_hasta);
		}

		$view = "contabilidad/facturas_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	public function partidas_presupuestarias($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		if ($acc == 'add') {
			if ($_POST) {
				if (isset($_POST['anadir_partida'])) {
					$id = $this->admin_functions->InsertPartidaPresupuestaria($_POST);
				}
			}
		}
		if ($acc == 'view') {
			$this->load->database();

			$anio_actual = date("Y");
			$fecha_desde = $anio_actual;
			$fecha_hasta = $anio_actual;

			if ($_POST) {
				if ($_POST["fecha_desde"] <> "") {
					$fecha_desde = $_POST["fecha_desde"];
				}
				if ($_POST["fecha_hasta"] <> "") {
					$fecha_hasta = $_POST["fecha_hasta"];
				}
			}

			if ($id) {
				$data['partida'] = $this->admin_functions->GetPartidaPresupuestaria($id);
				$acc = "viewdetails";
			}

			$data['fecha_desde'] = $fecha_desde;
			$data['fecha_hasta'] = $fecha_hasta;
			$data['partidas_ano'] = $this->admin_functions->BuscaPartidasPresupuestariasMovimientos($fecha_desde, $fecha_hasta);
			$data['partidas'] = $this->admin_functions->GetPartidasPresupuestarias($fecha_desde, $fecha_hasta);
		}

		$view = "contabilidad/partidas_presupuestarias_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	public function movimientos($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		if ($acc == 'add') {
			if ($_POST) {
				if (isset($_POST['anadir_movimiento'])) {
					$id = $this->admin_functions->InsertMovimiento($_POST);
				}
			}
		}
		if ($acc == 'view') {
			$this->load->database();
			if ($id) {
				$data['movimiento'] = $this->admin_functions->GetMovimiento($id);
				$data['partidas_presupuestarias_ano'] = $this->admin_functions->GetPartidasPresupuestariasAno($id);
				if (isset($_POST['actualizar_movimiento'])) {
					$this->admin_functions->UpdateMovimiento($_POST);
				}
				$acc = "viewdetails";
			}

			$fecha_actual = date("Y-m-d");
			$fecha_desde = date("Y") . "-01-01";
			$fecha_hasta = $fecha_actual;

			if ($_POST) {
				if ($_POST["fecha_desde"] <> "") {
					$fecha_desde = $_POST["fecha_desde"];
				}
				if ($_POST["fecha_hasta"] <> "") {
					$fecha_hasta = $_POST["fecha_hasta"];
				}
			}

			$data['fecha_desde'] = $fecha_desde;
			$data['fecha_hasta'] = $fecha_hasta;

			$str_where = "";
			if (isset($_POST["tipo_movimiento"]) && $_POST['tipo_movimiento'] <> "") {
				$str_where = $str_where . " AND tipo_movimiento='" . $_POST['tipo_movimiento'] . "'";
			}
			if (isset($_POST["lugar"]) && $_POST['lugar'] <> "") {
				$str_where = $str_where . " AND lugar='" . $_POST['lugar'] . "'";
			}
			if (isset($_POST["tipo_lugar"]) && $_POST['tipo_lugar'] <> "") {
				$str_where = $str_where . " AND tipo_lugar='" . $_POST['tipo_lugar'] . "'";
			}
			if (isset($_POST["oficina"]) && $_POST['oficina'] <> "") {
				$str_where = $str_where . " AND id_oficina='" . $_POST['oficina'] . "'";
			}

			$data['movimientos'] = $this->admin_functions->GetMovimientos($fecha_desde, $fecha_hasta, $str_where);
		}

		$data['cuentas_bancarias'] = $this->admin_functions->GetCuentasBancarias();
		$data['oficinas'] = $this->admin_functions->GetOficinas();
		$view = "contabilidad/movimientos_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	public function retenciones($acc = false, $id = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		if ($acc == 'add') {
			if ($_POST) {
				if (isset($_POST['anadir_retencion'])) {
					$id = $this->admin_functions->InsertRetencion($_POST);
				}
			}
		}
		if ($acc == 'view') {
			$this->load->database();
			if ($id) {
				if (isset($_POST['actualizar_retencion'])) {
					$this->admin_functions->UpdateRetencion($_POST);
				}
				$data['retencion'] = $this->admin_functions->GetRetencion($id);
				$acc = "viewdetails";
			}

			$fecha_actual = date("Y-m-d");
			$fecha_desde = $fecha_actual;
			$fecha_hasta = $fecha_actual;
			if (!isset($_POST['anio'])) {
				$anio = date("Y");
			} else {
				$anio = $_POST['anio'];
			}

			if (!isset($_POST['oficina'])) {
				$id_oficina = 1;
			} else {
				$id_oficina = $_POST['oficina'];
			}

			if ($_POST) {
				if ($_POST["fecha_desde"] <> "") {
					$fecha_desde = $_POST["fecha_desde"];
				}
				if ($_POST["fecha_hasta"] <> "") {
					$fecha_hasta = $_POST["fecha_hasta"];
				}
			}


			$str_where = "";
			if (isset($_POST["tipo_retencion"]) && $_POST['tipo_retencion'] <> "") {
				$str_where = $str_where . " AND tipo_retencion='" . $_POST['tipo_retencion'] . "'";
			}
			if (isset($_POST["oficina"]) && $_POST['oficina'] <> "") {
				$str_where = $str_where . " AND id_oficina='" . $_POST['oficina'] . "'";
			}

			$data['retenciones'] = $this->admin_functions->GetRetenciones($fecha_desde, $fecha_hasta, $str_where);
			$data['retenciones_anuales'] = $this->admin_functions->GetRetencionesAnuales($anio, $id_oficina);

			$data['fecha_desde'] = $fecha_desde;
			$data['fecha_hasta'] = $fecha_hasta;
			$data['anio'] = $anio;
			$data['id_oficina'] = $id_oficina;
		}

		$data['oficinas'] = $this->admin_functions->GetOficinas();
		$view = "contabilidad/retenciones_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	public function tarifas1()
	{
		$view = "tarifas";
		$data = false;
		$data_header = false;
		$data = false;
		$data_footer = false;
		$data['oficinas'] = $this->admin_functions->GetOficinas();
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

	function _loadViews($data_header, $data, $data_footer, $view)

	{

		$this->load->view('admin/header', $data_header);

		$this->load->view("admin/$view", $data);

		$this->load->view('admin/footer', $data_footer);
	}
	function _loadViewsHome($data_header, $data, $data_footer)

	{

		$this->load->view('admin/header', $data_header);

		$this->load->view('admin/home', $data);

		$this->load->view('admin/footer', $data_footer);
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

			$mail->addCC('rajlopa@gmail.com');
			/* $mail->addBCC('bcc@example.com'); */

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
}
