<?php
class tipoevento_model extends CI_Model{
	//pega todos os registros
	function get_all_tipoevento(){

		$query = $this->db->get('tipo_evento');
		return $query->result();
	}
	//create 
	function add_tipoevento($options=array()){

		$this->db->insert('tipo_evento', $options);
		return $this->db->affected_rows();
	}
	//delete 
	function delete_tipoevento(){
		$this->db->where('CODIGO_EVT',$this->uri->segment(3));
		$this->db->delete('tipo_evento');
		return $this->db->affected_rows();
	}
	//update usuário
	function update_tipoevento($options=array()){
		if(isset($options['id']))
			$this->db->set('CODIGO_EVT',$options['id']);
		if(isset($options['descricao']))
			$this->db->set('DESCRICAO',$options['descricao']);
		print ($options['id']);
		print ($options['descricao']);
		// O  ALTERAR NAO ESTA FUNCIONANDO, PROVAVELMENTE É ALGO  NO UPDATE AKI ,  REVER O USUARIO  NO ALTERAR,  QUE DEVE TER ALGO QUE EU EXCLUI QUE NAO ERA PRA ECLUIR"
		$this->db->where('CODIGO_EVT',$options['id']);
		$this->db->update('tipo_evento');
		return $this->db->affected_rows();
	}

	
	//get by id
	function get_by_id_tipoevento($id){
		$this->db->where('CODIGO_EVT',$id);
		$query=$this->db->get('tipo_evento');
		return $query->row(0);
	}
} 
?>