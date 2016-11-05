<?php

class consumoPorMes_model extends CI_Model {

    function getData($inicio,$fim) {
             $this->db->select("*");
		$this->db->from ('consumomes');
                
                $this->db->where('MES >=', $inicio);
                $this->db->where('MES <=', $fim);
                
                $query = $this->db->get();
             //   $data['harmonica'] = $query;
                return $query->result();
    }

}

?>
