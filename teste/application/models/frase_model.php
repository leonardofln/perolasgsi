<?php
class Frase_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->model('usuario_model');
		//$this->output->enable_profiler(TRUE);
	}
	
	function busca() {
		$this->db->select('cdFrase, deFrase, (select count(*) from per_frase_votacao where cdFrase = f.cdFrase and flTipo = 1) as nrGostei, (select count(*) from per_frase_votacao where cdFrase = f.cdFrase and flTipo = 2) as nrNaoGostei, cdUsuario, date_format(dtRegistro, \'%d/%m/%Y\') as dtRegistro', false);
		$this->db->order_by('f.dtRegistro desc, f.cdFrase desc');
		$query = $this->db->get('per_frase f');
		$retorno = $query->result();
		
		for ($i=0; $i<count($retorno); $i++) {
			$frase = $retorno[$i];
			
			$this->db->select('fv.cdUsuario, concat(u.deNome, " ", u.deSobrenome) as usuario', false);
			$this->db->from('per_frase_votacao fv');
			$this->db->join('usu_usuario u', 'u.cdUsuario = fv.cdUsuario');
			$this->db->where('fv.cdFrase', $frase->cdFrase);
			$this->db->where('fv.flTipo', 1); // gostei
			$this->db->order_by('deNome');
			$query = $this->db->get();
			$ret = $query->result();
			$retorno[$i]->votantesGostei = $ret;
			
			$this->db->select('fv.cdUsuario, concat(deNome, " ", deSobrenome) as usuario', false);
			$this->db->from('per_frase_votacao fv');
			$this->db->join('usu_usuario u', 'u.cdUsuario = fv.cdUsuario');
			$this->db->where('fv.cdFrase', $frase->cdFrase);
			$this->db->where('fv.flTipo', 2); // não gostei
			$this->db->order_by('deNome');
			$query = $this->db->get();
			$ret = $query->result();
			$retorno[$i]->votantesNaoGostei = $ret;
		}
		
		return $retorno;
	}
	
	function votou($cdFrase, $cdUsuario) {
		$this->db->select('count(*) as qtde', false);
		$query = $this->db->get_where('per_frase_votacao', array('cdFrase' => $cdFrase, 'cdUsuario' => $cdUsuario));
		$retorno = $query->result();
		return $retorno[0]->qtde;
	}
	
	function gostei($cdFrase, $cdUsuario) {
		$dados = new stdClass();
		$dados->cdFrase = $cdFrase;
		$dados->cdUsuario = $cdUsuario;
		$dados->flTipo = 1;
		$retorno = $this->db->insert('per_frase_votacao', $dados);
		if ($retorno) {
			return true;
		} else {
			return false;
		}
	}
	
	function naoGostei($cdFrase, $cdUsuario) {
		$dados = new stdClass();
		$dados->cdFrase = $cdFrase;
		$dados->cdUsuario = $cdUsuario;
		$dados->flTipo = 2;
		$retorno = $this->db->insert('per_frase_votacao', $dados);
		if ($retorno) {
			return true;
		} else {
			return false;
		}
	}
	
	function cadastrar($cdUsuario, $deAcao, $deParaQuem, $deFrase, $dtRegistro) {
		$dados = new stdClass();
		
		$usuario = $this->usuario_model->busca($cdUsuario);
		$dados->deFrase = urldecode($usuario->deNome . ' ' . $deAcao . ' ' . $deParaQuem . ': "' . $deFrase . '"');
		$dados->cdUsuario = $cdUsuario;
		$dados->dtRegistro = substr($dtRegistro, 6, 4) . '-' . substr($dtRegistro, 3, 2) . '-' . substr($dtRegistro, 0, 2);
		
		$retorno = $this->db->insert('per_frase', $dados);
		if ($retorno) {
			return true;
		} else {
			return false;
		}
	}
	
	function excluir($cdFrase) {
		$this->db->where('cdFrase', $cdFrase);
		$this->db->delete(array('per_frase', 'per_frase_votacao'));
		return true;
	}
	
	function top10MaisVotadas() {
		$this->db->select('cdFrase', false);
		$this->db->from('per_frase_votacao');
		$this->db->where('flTipo', 1); // gostei
		$this->db->group_by('cdFrase');
		$this->db->order_by('count(cdUsuario) desc');
		$this->db->limit(10);
		$query = $this->db->get();
		$ret = $query->result();
		
		$aFrases = array();
		foreach ($ret as $frase) {
			$aFrases[] = $this->buscaPorCodigo($frase->cdFrase);
		}
		
		return $aFrases;
	}
	
	function buscaPorCodigo($cdFrase) {
		$this->db->select('cdFrase, deFrase, (select count(*) from per_frase_votacao where cdFrase = f.cdFrase and flTipo = 1) as nrGostei, (select count(*) from per_frase_votacao where cdFrase = f.cdFrase and flTipo = 2) as nrNaoGostei, cdUsuario, date_format(dtRegistro, \'%d/%m/%Y\') as dtRegistro', false);
		$this->db->where('cdFrase', $cdFrase);
		$query = $this->db->get('per_frase f');
		$retorno = $query->result();
		return $retorno[0];
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