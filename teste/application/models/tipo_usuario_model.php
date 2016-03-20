<?php
class Tipo_Usuario_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function busca($cdTipo) {
		$query = $this->db->get_where('usu_usuario_tipo', array('cdTipo' => $cdTipo));
		$retorno = $query->result();
		return $retorno[0];
	}
	
	function lista() {
		$this->db->order_by('deTipo');
		$query = $this->db->get('usu_usuario_tipo');
		$retorno = $query->result();
		return $retorno;
	}
	
	/* function insere($dados) {
		//$this->db->where('cdUsuario', $cdUsuario);
		//$this->db->update('au_usuario', $dados);
	}
	
	function atualiza($cdUsuario, $dados) {
		$this->db->where('cdUsuario', $cdUsuario);
		$this->db->update('au_usuario', $dados);
	}
	
	function deleta($cdUsuario) {
		//$this->db->where('cdUsuario', $cdUsuario);
		//$this->db->update('au_usuario', $dados);
	} */
}