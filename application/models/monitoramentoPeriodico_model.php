<?php

class monitoramentoPeriodico_model extends CI_Model {
 function getMon($inicio,$fim) {
             $this->db->select("*");
		$this->db->from ('COLETAPERIODICA');
                
                $this->db->where('DATAHORA >=', $inicio);
                $this->db->where('DATAHORA <=', $fim);
                
                $query = $this->db->get();
           
                return $query->result();
    }
    
    
    
     function getUltimoMon() {
       
       		$this->db->select("*");
		$this->db->from ('COLETAPERIODICA');
		$this->db->order_by('DATAHORA','desc');
                $this->db->limit(1);
		$query = $this->db->get()->result_array();

               
                  $data['grafico'] = $query;
                  
        return $data;
    }
    
     function attAut() {
       
       		$this->db->select("*");
		$this->db->from ('coletaperiodica');
		$this->db->order_by('DATAHORA','desc');
                $this->db->limit(1);
		$query = $this->db->get()->result_array();

                  $data['grafico'] = $query;
                    return $data;
    }

}

?>

