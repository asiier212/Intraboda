<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($a = false)
	{
	      $this->load->library('session');
		//$this->load->model('admin_functions');
		if(!$this->session->userdata('admin') && $this->router->method != 'login') {
			 redirect('admin/login');
		}
		$data_header = false;
		$data = false;
		$data_footer = false;
				
		$this->_loadViews($data_header, $data, $data_footer);
	}
	function admin($a = false)
	{
		$data_header = false;
		$data = false;
		$data_footer = false;
				
		$this->_loadViews($data_header, $data, $data_footer);
	}
	function _loadViews($data_header, $data, $data_footer)

	{

		$this->load->view('admin/header', $data_header);

		$this->load->view('admin/home', $data);

		$this->load->view('admin/footer', $data_footer);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */