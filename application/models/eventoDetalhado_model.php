<?php

class eventoDetalhado_model extends CI_Model {

    function get_evt() {
             $query = $this->db->get('TIPO_EVENTO');
		return $query->result();
    }

    
     function getDados($inicio,$fim) {
             $this->db->select("C.DATAHORA,T.DESCRICAO,C.TENSAO_RMS,C.CORRENTE_RMS,C.FI");
		$this->db->from ('COLETA C, TIPO_EVENTO T');
                $this->db->where('C.TIPO_EVENTO_CODIGO_EVT = T.CODIGO_EVT');
                $this->db->where('DATAHORA >=', $inicio);
                $this->db->where('DATAHORA <=', $fim);
                 $this->db->order_by("DATAHORA","desc");
                $query = $this->db->get();
             //   $data['harmonica'] = $query;
                return $query->result();
    }
    function getTiposTotal($inicio,$fim) {
                   $this->db->select('T.DESCRICAO,count(C.TIPO_EVENTO_CODIGO_EVT) as quantidade');
		$this->db->from ('TIPO_EVENTO T');
                $this->db->join('COLETA C ','C.TIPO_EVENTO_CODIGO_EVT = T.CODIGO_EVT');
                $this->db->where('DATAHORA >=', $inicio);
                $this->db->where('DATAHORA <=', $fim);
                 $this->db->group_by('T.DESCRICAO');
                $query = $this->db->get();
             
                return $query->result();
    }
}

?>
