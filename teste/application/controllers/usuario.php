<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('usuario_model');
		$this->load->model('tipo_usuario_model');
		$this->load->model('acesso_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">x</button>', '</div>');
	}
	
	function editar() {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'    => date('Y-m-d H:i:s'),
			'deLink'      => current_url(),
			'deAcao'      => 'Tela de edicao de usuario',
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
			$dadosUsuario = $this->usuario_model->busca($usuario->cdUsuario);
			$tipoUsuario = $this->tipo_usuario_model->lista();
			
			$dados['dadosUsuarioLogado'] = $usuario;
			$dados['dadosUsuarioBanco'] = $dadosUsuario;
			$dados['tipoUsuario'] = $tipoUsuario;
			$this->load->view('usuario_editar', $dados);
		}
	}
	
	function atualizar() {
		$usuario = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'    => date('Y-m-d H:i:s'),
			'deLink'      => current_url(),
			'deAcao'      => 'Modificando dados do usuario no BD',
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
			// faz a validação dos dados do form
			$this->form_validation->set_rules('deNome', 'Nome', 'trim|required|xss_clean');
			$this->form_validation->set_rules('deSobrenome', 'Sobrenome', 'trim|required|xss_clean');
			$this->form_validation->set_rules('deEmail', 'E-mail', 'trim|required|valid_email|callback_email_unico');
			if ($usuario->cdTipo == 2) {
				$this->form_validation->set_rules('cdTipo', 'Tipo de usu&aacute;rio', 'trim|required|numeric');
			}
			
			if ($this->form_validation->run() == FALSE) {
				$dadosUsuario = new stdClass();
				$dadosUsuario->deNome = $this->input->post('deNome');
				$dadosUsuario->deSobrenome = $this->input->post('deSobrenome');
				$dadosUsuario->deEmail = $this->input->post('deEmail');
				$dadosUsuario->cdTipo = $this->input->post('cdTipo');
				$tipoUsuario = $this->tipo_usuario_model->lista();
				
				$dados['dadosUsuarioLogado'] = $usuario;
				$dados['dadosUsuarioBanco'] = $dadosUsuario;
				$dados['tipoUsuario'] = $tipoUsuario;
				$this->load->view('usuario_editar', $dados);
			} else {
				$dadosUsuario = new stdClass();
				$dadosUsuario->cdUsuario = $usuario->cdUsuario;
				$dadosUsuario->deNome = $this->input->post('deNome');
				$dadosUsuario->deSobrenome = $this->input->post('deSobrenome');
				$dadosUsuario->deEmail = $this->input->post('deEmail');
				if ($this->input->post('deSenha') != '') {
					$dadosUsuario->deSenha = md5($this->input->post('deSenha'));
				}
				if ($usuario->cdTipo == 2) {
					$dadosUsuario->cdTipo = $this->input->post('cdTipo');
				}
				
				// salva no banco de dados
				$this->usuario_model->atualiza($dadosUsuario->cdUsuario, $dadosUsuario);
					
				// redireciona para a tela
				redirect('/usuario/editar/');
			}
		}
	}
	
	function email_unico($str) {
		$dadosUsuarioLogado = $this->session->userdata('usuario');
		
		$dados = array(
			'dtAcesso'    => date('Y-m-d H:i:s'),
			'deLink'      => current_url(),
			'deAcao'      => 'Verificando e-mail unico',
			'deIp'        => $this->session->userdata('ip_address'),
			'deSession'   => $this->session->userdata('session_id'),
			'cdUsuario'   => (empty($usuario->cdUsuario))?null:$usuario->cdUsuario,
			'deNome'      => (empty($usuario->deNome))?null:$usuario->deNome,
			'deSobrenome' => (empty($usuario->deSobrenome))?null:$usuario->deSobrenome,
			'deEmail'     => (empty($usuario->deEmail))?null:$usuario->deEmail
		);
		$this->acesso_model->insere($dados);
		
		$usuario = $this->usuario_model->buscaUsuarioPorEmail($str);
		
		if (!empty($usuario) && $usuario->cdUsuario != $dadosUsuarioLogado->cdUsuario)	{
			$this->form_validation->set_message('email_unico', 'O endere&ccedil;o informado no campo %s j&aacute; est&aacute; em uso, por favor escolha outro');
			return false;
		} else {
			return true;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */