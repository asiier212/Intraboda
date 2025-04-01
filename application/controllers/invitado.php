<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invitado extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('invitado_functions');

        // Solo permite acceso si está logueado, excepto en login
        if (
            !$this->session->userdata('id') &&
            $this->router->method != 'login' &&
            $this->router->method != 'logout'
        ) {
            redirect('invitado/login');
        }
    }

    public function login()
    {
        $data = [];
    
        if ($_POST) {
            $email = $this->input->post('email');
            $clave = $this->input->post('clave');
    
            $this->load->model('invitado_functions');
            $invitado = $this->invitado_functions->login($email, $clave);
    
            if ($invitado === 'desactivado') {
                $data['msg'] = 'Cuenta desactivada.';
            } elseif ($invitado) {
                $session_data = [
                    'id'       => $invitado->id,
                    'username' => $invitado->username
                ];
                $this->session->set_userdata($session_data);
                redirect('invitado', 'location');;
            } else {
                $data['msg'] = 'Login o contraseña incorrectos.';
            }
        }
    
        $this->load->view('invitado/login', $data);
    }
    

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('invitado/login', 'location');
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

        $this->load->view('invitado/header', $data_header);

        $this->load->view('invitado/' . $view, $data);

        $this->load->view('invitado/footer', $data_footer);
    }

    function _loadViewsHome($data_header, $data, $data_footer)
    {
        $this->load->view('invitado/header', $data_header);

        $this->load->view('invitado/home', $data);

        $this->load->view('invitado/footer', $data_footer);
    }

    function cliente_viewdetails()
	{
        $data_header = false;
        $data = false;
        $data_footer = false;

        $id = $this->invitado_functions->GetIdClienteForIdInvitado($this->session->userdata('id'));
        
        $data['cliente'] = $this->invitado_functions->GetCliente($id);
        $arr_servicios = unserialize($data['cliente']['servicios']);
        $arr_serv_keys = array_keys($arr_servicios);

        $data['servicios'] = $this->invitado_functions->GetServicios(implode(",", $arr_serv_keys));
        $data['cliente'] = $this->invitado_functions->GetCliente($id);
        $data['observaciones_cliente'] = $this->invitado_functions->GetObservaciones($id);


		$view = "cliente_viewdetails";
		$this->_loadViews($data_header, $data, $data_footer, $view);
	}

    public function listado_canciones()
    {
        $data_header = false;
        $data_footer = false;
        $data = false;
    
        // Obtener el ID del cliente asociado al invitado
        $id_invitado = $this->session->userdata('id');
        $id_cliente = $this->invitado_functions->GetIdClienteForIdInvitado($id_invitado);
    
        if (!$id_cliente || !is_numeric($id_cliente)) {
            show_error("ID de cliente no válido", 400);
        }
    
        $cliente = $this->invitado_functions->GetCliente($id_cliente);
        if (!$cliente) {
            show_error("Cliente no encontrado", 404);
        }
    
        // Asignar datos para la vista
        $data['cliente'] = $cliente;
        $data['events'] = $this->invitado_functions->GetEvents($id_cliente);
        $data['events_user'] = $this->invitado_functions->GetmomentosUser($id_cliente);
        $data['canciones_user'] = $this->invitado_functions->GetcancionesUser($id_cliente);
        $data['canciones_observaciones_momesp'] = $this->invitado_functions->GetObservaciones_momesp($id_cliente);
        $data['canciones_observaciones_general'] = $this->invitado_functions->GetObservaciones_general($id_cliente);
    
        $this->_loadViews($data_header, $data, $data_footer, 'listado_canciones');
    }
    
}
