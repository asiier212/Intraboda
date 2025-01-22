<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prueba extends CI_Controller {

	function __construct()
		{
			parent::__construct();
			
		}
	public function index()
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

