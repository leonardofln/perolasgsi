<?php
class Acesso_model extends CI_Model {

	function __construct() {
		parent::__construct();
		
		//$this->load->library('email');
		
		//$config['mailtype'] = 'html';
		//$this->email->initialize($config);
	}
	
	function busca($cdUsuario) {
		$query = $this->db->get_where('usu_usuario', array('cdUsuario' => $cdUsuario));
		$retorno = $query->result();
		return $retorno[0];
	}
	
	function lista() {
		$this->db->order_by('deNome');
		$query = $this->db->get('usu_usuario');
		$retorno = $query->result();
		return $retorno;
	}
	
	function insere($dados) {
		$this->db->insert('est_acesso', $dados);
	}
	
	function atualiza($cdUsuario, $dados) {
		$this->db->where('cdUsuario', $cdUsuario);
		$this->db->update('usu_usuario', $dados);
	}
	
	function deleta($cdUsuario) {
		//$this->db->where('cdUsuario', $cdUsuario);
		//$this->db->update('au_usuario', $dados);
	}
	
	function buscaUsuarioPorEmail($deEmail) {
		$query = $this->db->get_where('usu_usuario', array('deEmail' => $deEmail));
		$retorno = $query->result();
		if ($retorno) {
		    return $retorno[0];
		} else {
		    return null;
		}
	}
}
