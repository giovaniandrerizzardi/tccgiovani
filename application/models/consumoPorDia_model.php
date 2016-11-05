<?php

class consumoPorDia_model extends CI_Model {

    function getData($inicio,$fim) {
             $this->db->select("*");
		$this->db->from ('consumodia');
                
                $this->db->where('DIA >=', $inicio);
                $this->db->where('DIA <=', $fim);
                
                $query = $this->db->get();
             //   $data['harmonica'] = $query;
                return $query->result();
    }

}

?>


