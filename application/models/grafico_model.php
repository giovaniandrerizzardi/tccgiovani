<?php

class grafico_model extends CI_Model {

    function get_coleta7() {
        $query = $this->db->get('coleta');
        return $query->result();
    }

    function get_coleta() {
       
       		$this->db->select("*");
		$this->db->from ('coleta');
		$this->db->order_by('COLETA_COD','desc');
                $this->db->limit(1);
		$query = $this->db->get()->result_array();

                //$row = $query->last_row();
                  
                 // $data['tensao'] = explode(';',$query[0]['VAL_TENSAO']); 
                  //$data['corrente'] = explode(';',$query[0]['VAL_CORRENTE']);
                  $data['grafico'] = $query;
                  
        return $data;
    }
    function get_harmonicatensao($codColeta) {
                $this->db->select("HARMONICA");
		$this->db->from ('magnitudetensao');
                $this->db->where('COLETA_COLETA_COD = ', $codColeta);
                
                $query = $this->db->get();
             //   $data['harmonica'] = $query;
                return $query->result();
        
                
    }
    function get_harmonicacorrente($codColeta) {
                $this->db->select("HARMONICA");
		$this->db->from ('magnitudecorrente');
                $this->db->where('COLETA_COLETA_COD = ', $codColeta);
                
                $query = $this->db->get();
             //   $data['harmonica'] = $query;
                return $query->result();
        
                
    }

}

?>
