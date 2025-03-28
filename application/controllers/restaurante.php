<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Restaurante extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('restaurante_functions');

		// Solo permite acceso si está logueado, excepto en login
		if (
			!$this->session->userdata('restaurante_id') &&
			$this->router->method != 'login' &&
			$this->router->method != 'logout'
		) {
			redirect('restaurante/login');
		}
	}

	public function login()
	{
		$data = [];

		if ($_POST) {
			$email = $this->input->post('email');
			$clave = $this->input->post('clave');

			$restaurante = $this->restaurante_functions->login($email, $clave);

			if ($restaurante) {
				// Guardar datos en sesión
				$session_data = [
					'restaurante_id'     => $restaurante->id_restaurante,
					'restaurante_nombre' => $restaurante->nombre
				];
				$this->session->set_userdata($session_data);


				redirect('restaurante', 'location');
			} else {
				$data['msg'] = 'Login o contraseña incorrectos';
			}
		}

		$this->load->view('restaurante/login', $data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('restaurante/login', 'location');
	}

	public function index()
	{
		$data_header = false;
		$data = false;
		$data_footer = false;

		$this->_loadViews($data_header, $data, $data_footer, "home");
	}
	function _loadViews($data_header, $data, $data_footer, $view)
	{

		$this->load->view('restaurante/header', $data_header);

		$this->load->view('restaurante/' . $view, $data);

		$this->load->view('restaurante/footer', $data_footer);
	}

	function _loadViewsHome($data_header, $data, $data_footer)
	{
		$this->load->view('restaurante/header', $data_header);

		$this->load->view('restaurante/home', $data);

		$this->load->view('restaurante/footer', $data_footer);
	}

	function clientes($acc = false, $id = false)
	{

		$data_header = false;
		$data = false;
		$data_footer = false;

		if ($acc == 'view') {
			$this->load->database();
			if ($id) {
				if ($_POST) {

					$this->load->database();

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

						redirect("restaurante/clientes/view/{$id}");
					}
				}

				$data['cliente'] = $this->restaurante_functions->GetCliente($id);
				$arr_servicios = unserialize($data['cliente']['servicios']);
				$arr_serv_keys = array_keys($arr_servicios);

				$data['servicios'] = $this->restaurante_functions->GetServicios(implode(",", $arr_serv_keys));
				$data['cliente'] = $this->restaurante_functions->GetCliente($id);
				$data['observaciones_cliente'] = $this->restaurante_functions->GetObservaciones($id);
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
				$restaurante_id = $this->session->userdata('restaurante_id');
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

				$ord = "fecha_boda DESC";
				if (isset($_GET['ord']) && $_GET['ord'] != '') $ord = $_GET['ord'];

				$data['clientes'] = $this->restaurante_functions->GetClientes($str_where, $ord, $limit);
			}
		}

		$view = "clientes_" . $acc;
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}


	public function listado_canciones($id = false)
	{
		$data_header = false;
		$data_footer = false;
		$data = false;

		if (!$id || !is_numeric($id)) {
			show_error("ID de cliente no válido", 400);
		}
		
		$cliente = $this->restaurante_functions->GetCliente($id);
		if (!$cliente) {
			show_error("Cliente no encontrado", 404);
		}

		if ($id) {
			$cliente = $this->restaurante_functions->GetCliente($id);

			if ($cliente) {
				// Asignar datos
				$data['cliente'] = $cliente;
				$data['events'] = $this->restaurante_functions->GetEvents($id);
				$data['events_user'] = $this->restaurante_functions->GetmomentosUser($id);
				$data['canciones_user'] = $this->restaurante_functions->GetcancionesUser($id);
				$data['canciones_observaciones_momesp'] = $this->restaurante_functions->GetObservaciones_momesp($id);
				$data['canciones_observaciones_general'] = $this->restaurante_functions->GetObservaciones_general($id);

				$this->_loadViews($data_header, $data, $data_footer, 'listado_canciones');
			} else {
				show_error('Cliente no encontrado.');
			}
		} else {
			show_error('ID de cliente no proporcionado.');
		}
	}
}
