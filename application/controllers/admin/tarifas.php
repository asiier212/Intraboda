<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class tarifas extends CI_Controller {   

function __construct()
		{
			parent::__construct();
			$this->load->library('session');
			$this->load->model('admin_functions');
			
			if(!$this->session->userdata('user_id') && $this->router->method != 'login' && $this->router->method != 'recordar_pass' && $this->router->method != 'generar_pass') {
				 redirect('admin/login');
			}
		}         
     }
	