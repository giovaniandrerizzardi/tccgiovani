<?php
class sensor_model extends CI_Model{
	//pega todos os registros
	function get_all_sensor(){

		$query = $this->db->get('sensor');
		return $query->result();
	}
	//create SENSOR
	function add_sensor($options=array()){

		$this->db->insert('sensor', $options);
		return $this->db->affected_rows();
	}
	//delete SENSOR
	function delete_sensor(){
		$this->db->where('SENSOR_COD',$this->uri->segment(3));
		$this->db->delete('sensor');
		return $this->db->affected_rows();
	}
	//update SENSOR
	function update_sensor($options=array()){
		if(isset($options['id']))
			$this->db->set('SENSOR_COD',$options['id']);
		if(isset($options['ganho']))
			$this->db->set('GANHO',$options['ganho']);
		if(isset($options['max_corrente']))
			$this->db->set('MAX_CORRENTE',$options['max_corrente']);
		if(isset($options['min_corrente']))
			$this->db->set('MIN_CORRENTE',$options['min_corrente']);

		$this->db->where('SENSOR_COD',$options['id']);
		$this->db->update('sensor');
		return $this->db->affected_rows();
	}

	
	//get by id
	function get_by_id_sensor($id){
		$this->db->where('SENSOR_COD',$id);
		$query=$this->db->get('sensor');
		return $query->row(0);
	}
} 
?>