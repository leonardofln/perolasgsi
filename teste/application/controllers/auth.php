<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {


	function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
	}
	
	function index()	{
		
	}
	
	function form() {
		$this->load->view('auth_form');
	}
	
	function autenticar() {
		$login = $this->input->post('login');
		$senha = $this->input->post('senha');
		$retorno = $this->auth_model->autenticar($login, $senha);
		if ($retorno) {
			redirect('/');
		} else {
			redirect('/auth/form/');
		}
	}
	
	function sair() {
		$this->auth_model->sair();
		
		redirect('/');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */