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
}
