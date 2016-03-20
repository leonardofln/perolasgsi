<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('frase_model');
		$this->load->model('usuario_model');
	}
	
	function index($cdMsg = null)	{
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$usuario = $this->session->userdata('usuario');
			
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
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$usuario = $this->session->userdata('usuario');
			
			$jaVotou = $this->frase_model->votou($cdFrase, $usuario->cdUsuario);
			
			echo $jaVotou;
		}
	}
	
	function gostei($cdFrase) {
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$usuario = $this->session->userdata('usuario');
			
			$retorno = $this->frase_model->gostei($cdFrase, $usuario->cdUsuario);
			
			echo $retorno;
		}
	}
	
	function naoGostei($cdFrase) {
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$usuario = $this->session->userdata('usuario');
			
			$retorno = $this->frase_model->naoGostei($cdFrase, $usuario->cdUsuario);
				
			echo $retorno;
		}
	}
	
	function cadastrar() {
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$usuario = $this->session->userdata('usuario');
			
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
		if (!$this->auth_model->estahAutenticado()) {
			redirect('/auth/form/');
		} else {
			$usuario = $this->session->userdata('usuario');
			
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