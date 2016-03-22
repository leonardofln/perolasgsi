<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estatisticas extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('frase_model');
		$this->load->model('acesso_model');
	}
	
	function index() {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'    => date('Y-m-d H:i:s'),
			'deLink'      => current_url(),
			'deAcao'      => 'Tela de estatisticas',
			'deIp'        => $this->session->userdata('ip_address'),
			'deSession'   => $this->session->userdata('session_id'),
			'cdUsuario'   => (empty($usuario->cdUsuario))?null:$usuario->cdUsuario,
			'deNome'      => (empty($usuario->deNome))?null:$usuario->deNome,
			'deSobrenome' => (empty($usuario->deSobrenome))?null:$usuario->deSobrenome,
			'deEmail'     => (empty($usuario->deEmail))?null:$usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$frases = $this->frase_model->top10MaisVotadas();
			
			$dados['dadosUsuarioLogado'] = $usuario;
			$dados['frases'] = $frases;
			$this->load->view('estatisticas', $dados);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */