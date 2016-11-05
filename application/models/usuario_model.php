<?php
class usuario_model extends CI_Model{
	//pega todos os registros
	function get_all_usuario(){

		$query = $this->db->get('usuario');
		return $query->result();
	}
	//create 
	function add_usuario($options=array()){

		$this->db->insert('usuario', $options);
		return $this->db->affected_rows();
	}
	//delete 
	function delete_usuario(){
		$this->db->where('USUARIO_COD',$this->uri->segment(3));
		$this->db->delete('usuario');
		return $this->db->affected_rows();
	}
	//update usuário
	function update_usuario($options=array()){
		if(isset($options['id']))
			$this->db->set('USUARIO_COD',$options['id']);
		if(isset($options['nome']))
			$this->db->set('NOME',$options['nome']);
		if(isset($options['cpf']))
			$this->db->set('CPF',$options['cpf']);
		if(isset($options['email']))
			$this->db->set('EMAIL',$options['email']);
		if(isset($options['senha']))
			$this->db->set('SENHA',$options['senha']);
		if(isset($options['nivel']))
			$this->db->set('NIVEL',$options['nivel']);

		$this->db->where('USUARIO_COD',$options['id']);
		$this->db->update('usuario');
		return $this->db->affected_rows();
	}
	//update password
	function update_senha($options=array()){
		$this->db->set('SENHA', $options['novasenha']);
		$this->db->where('USUARIO_COD',$options['id']);
		$this->db->update('usuario');
		return $this->db->affected_rows();
	}

	//get by id
	function get_by_id_usuario($id){
		$this->db->where('USUARIO_COD',$id);
		$query=$this->db->get('usuario');
		return $query->row(0);
	}
} 
?>