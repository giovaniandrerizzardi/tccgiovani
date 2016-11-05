<?php
/**
	* 2015
	* Desenvolvido por: Mateus Perego
	* Email: mateusperego@yahoo.com.br
	* Projeto de conclusão de curso
	* UPF - Ciência da Computação
	*/	

class login_model extends CI_Model{
	
	function get_all_login(){

		$query = $this->db->get('usuario');
		return $query->result();
	}	


	function get_by_id_login($id){
		$this->db->where('USUARIO_COD',$id);
		$query=$this->db->get('usuario');
		return $query->row(0);
	}

	function get_login($email, $senha){
		$this->db->where('EMAIL',$email);
		$this->db->where('SENHA',$senha);
		$query=$this->db->get('usuario');
		return $query->row(0);
	}

} 

?>