<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {


	function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('acesso_model');
 		$this->load->helper('cookie');
	}
	
	function index()	{
		
	}
	
	function form() {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'    => date('Y-m-d H:i:s'),
			'deLink'      => current_url(),
			'deAcao'      => 'Tela de login',
			'deIp'        => $this->session->userdata('ip_address'),
			'deSession'   => $this->session->userdata('session_id'),
			'cdUsuario'   => (empty($usuario->cdUsuario))?null:$usuario->cdUsuario,
			'deNome'      => (empty($usuario->deNome))?null:$usuario->deNome,
			'deSobrenome' => (empty($usuario->deSobrenome))?null:$usuario->deSobrenome,
			'deEmail'     => (empty($usuario->deEmail))?null:$usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		$dados['login'] = get_cookie('login');
		$this->load->view('auth_form', $dados);
	}
	
	function autenticar() {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'  => date('Y-m-d H:i:s'),
			'deLink'    => current_url(),
			'deAcao'    => 'Validando dados de acesso',
			'deIp'      => $this->session->userdata('ip_address'),
			'deSession' => $this->session->userdata('session_id'),
			'cdUsuario'   => $usuario->cdUsuario,
			'deNome'      => $usuario->deNome,
			'deSobrenome' => $usuario->deSobrenome,
			'deEmail'     => $usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		$login = $this->input->post('login');
		$senha = $this->input->post('senha');
		$retorno = $this->auth_model->autenticar($login, $senha);
		if ($retorno) {
			set_cookie('login', $login, 86400*365);
			redirect('/');
		} else {
			redirect('/auth/form/');
		}
	}
	
	function sair() {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'  => date('Y-m-d H:i:s'),
			'deLink'    => current_url(),
			'deAcao'    => 'Saindo do sistema',
			'deIp'      => $this->session->userdata('ip_address'),
			'deSession' => $this->session->userdata('session_id'),
			'cdUsuario'   => $usuario->cdUsuario,
			'deNome'      => $usuario->deNome,
			'deSobrenome' => $usuario->deSobrenome,
			'deEmail'     => $usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		$this->auth_model->sair();
		
		redirect('/');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */