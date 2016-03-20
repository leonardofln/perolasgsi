<?php
class Auth_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->model('usuario_model');
	}
	
	function autenticar($login, $senha) {
		if (!empty($login) && !empty($senha)) {
			$senha = md5($senha);
			$query = $this->db->get_where('usu_usuario', array('deEmail' => $login, 'deSenha' => $senha));
			if ($query->num_rows() > 0) {
				$usuario = $query->result();
				$this->session->set_userdata('usuario', $usuario[0]);
				return true;
			}
		}
		return false;
	}
	
	function estahAutenticado() {
		$usuario = $this->session->userdata('usuario');
		
		if (empty($usuario)) {
			return false;
		} else {
			return true;
		}
	}
	
	function sair() {
		$this->session->sess_destroy();
	}
	
}
