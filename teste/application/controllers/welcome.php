<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('frase_model');
		$this->load->model('usuario_model');
		$this->load->model('acesso_model');
	}
	
	function index($cdMsg = null)	{
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'  => date('Y-m-d H:i:s'),
			'deLink'    => current_url(),
			'deAcao'    => 'Tela inicial',
			'deIp'      => $this->session->userdata('ip_address'),
			'deSession' => $this->session->userdata('session_id'),
			'cdUsuario' => $usuario->cdUsuario,
			'deNome' => $usuario->deNome,
			'deSobrenome' => $usuario->deSobrenome,
			'deEmail' => $usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$frases = $this->frase_model->busca();
			
			$frasesTemp = array();
			foreach ($frases as $frase) {
				$frasesTemp[$frase->dtRegistro][] = $frase;
			}
			
			$listaUsuarios = $this->usuario_model->lista();
			
			$dados['listaUsuarios'] = $listaUsuarios;
			$dados['dadosUsuarioLogado'] = $usuario;
			$dados['frases'] = $frasesTemp;
			$dados['msg'] = $cdMsg;
			$this->load->view('welcome_message', $dados);
		}
	}
	
	function votou($cdFrase) {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'  => date('Y-m-d H:i:s'),
			'deLink'    => current_url(),
			'deAcao'    => 'Verificando se ja votou',
			'deIp'      => $this->session->userdata('ip_address'),
			'deSession' => $this->session->userdata('session_id'),
			'cdUsuario' => $usuario->cdUsuario,
			'deNome' => $usuario->deNome,
			'deSobrenome' => $usuario->deSobrenome,
			'deEmail' => $usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$jaVotou = $this->frase_model->votou($cdFrase, $usuario->cdUsuario);
			
			echo $jaVotou;
		}
	}
	
	function gostei($cdFrase) {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'  => date('Y-m-d H:i:s'),
			'deLink'    => current_url(),
			'deAcao'    => 'Votando gostei',
			'deIp'      => $this->session->userdata('ip_address'),
			'deSession' => $this->session->userdata('session_id'),
			'cdUsuario' => $usuario->cdUsuario,
			'deNome' => $usuario->deNome,
			'deSobrenome' => $usuario->deSobrenome,
			'deEmail' => $usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$retorno = $this->frase_model->gostei($cdFrase, $usuario->cdUsuario);
			echo $retorno;
		}
	}
	
	function naoGostei($cdFrase) {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'  => date('Y-m-d H:i:s'),
			'deLink'    => current_url(),
			'deAcao'    => 'Votando nao gostei',
			'deIp'      => $this->session->userdata('ip_address'),
			'deSession' => $this->session->userdata('session_id'),
			'cdUsuario' => $usuario->cdUsuario,
			'deNome' => $usuario->deNome,
			'deSobrenome' => $usuario->deSobrenome,
			'deEmail' => $usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$retorno = $this->frase_model->naoGostei($cdFrase, $usuario->cdUsuario);
			echo $retorno;
		}
	}
	
	function cadastrar() {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'  => date('Y-m-d H:i:s'),
			'deLink'    => current_url(),
			'deAcao'    => 'Tela de cadastro de frases',
			'deIp'      => $this->session->userdata('ip_address'),
			'deSession' => $this->session->userdata('session_id'),
			'cdUsuario' => $usuario->cdUsuario,
			'deNome' => $usuario->deNome,
			'deSobrenome' => $usuario->deSobrenome,
			'deEmail' => $usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			if ($usuario->cdTipo == 2) {
				$cdUsuario = $this->input->post('cdUsuario');
				$deAcao = $this->input->post('deAcao');
				$deParaQuem = $this->input->post('deParaQuem');
				$deFrase = $this->input->post('deFrase');
				$dtRegistro = $this->input->post('dtRegistro');
				
				$retorno = $this->frase_model->cadastrar($cdUsuario, $deAcao, $deParaQuem, $deFrase, $dtRegistro);
	
				if ($retorno) {
					
					// avisa a raça que tem frase nova
					$this->usuario_model->avisaUsuarios();
					
					redirect('/welcome/index/1'); // frase cadastrada com sucesso
				} else {
					redirect('/welcome/index/2'); // falha ao tentar cadastrar frase
				}
			} else {
				redirect('/welcome/index/6'); // sem permissão para cadastrar
			}
		}
	}
	
	function excluir($cdFrase) {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'    => date('Y-m-d H:i:s'),
			'deLink'      => current_url(),
			'deAcao'      => 'Exclusao de frase',
			'deIp'        => $this->session->userdata('ip_address'),
			'deSession'   => $this->session->userdata('session_id'),
			'cdUsuario'   => $usuario->cdUsuario,
			'deNome'      => $usuario->deNome,
			'deSobrenome' => $usuario->deSobrenome,
			'deEmail'     => $usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			if ($usuario->cdTipo == 2) {
				$retorno = $this->frase_model->excluir($cdFrase);
		
				if ($retorno) {
					redirect('/welcome/index/4'); // frase excluida com sucesso
				} else {
					redirect('/welcome/index/5'); // falha ao tentar excluir frase
				}
			} else {
				redirect('/welcome/index/3'); // sem permissão para excluir
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */