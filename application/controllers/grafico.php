<?php 
$codColeta = 0;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class grafico extends MY_Controller {
   
    public function __construct()
	{
		parent::__construct();
		$this->load->model('grafico_model');
                
	}  

         
        public function index(){
           
            global $codColeta;
            $data['grafico'] = $this->grafico_model->get_coleta();
           
           $codColeta = $data['grafico']['grafico'][0]['COLETA_COD'];
           //  $data['valtensao'] = explode(';', $data['grafico']);
            
            
            $data['title'] = $this->lang->line('page_title_consult_sensor');
            $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                    "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>" .
                    "<script src=" . base_url() . "includes/js/highcharts.js></script>".
                    "<script src=" . base_url() . "includes/js/graficosdetalhes.js></script>" .
                    "<script src=" . base_url() . "includes/js/funcoesjs.js></script>";
                    
                    
            $this->load->template('grafico_view', $data);
            
        }
        
        function atualizagrafico() {
            global $codColeta;
            
            //echo $codColeta;
            $retorno['rgrafico'] = $this->grafico_model->get_coleta();
            $cod = $retorno['rgrafico']['grafico'][0]['COLETA_COD'];
            //$retorno['rgrafico']['harmonica'] = $this->grafico_model->get_harmonicas($cod);
           //$i = 0;
           //print_r($retorno['rgrafico']['harmonica']);
        
        if($codColeta == $cod){
            exit;
        }  else{
          // print_r($retorno['rgrafico']['harmonica']->HAMONICA[2]);exit;
            $retorno['rgrafico']['tensao'] = explode(';', $retorno['rgrafico']['grafico'][0]['VAL_TENSAO']); 
            $retorno['rgrafico']['corrente'] = explode(';', $retorno['rgrafico']['grafico'][0]['VAL_CORRENTE']); 
            $retorno['harmonicat'] = $this->getharmonicatensao($cod);
            $retorno['harmonicac'] = $this->getharmonicacorrente($cod);
            
            //$codColeta = $cod;
            $codColeta = $cod;
            //echo $codColeta;
//echo '<pre>';            print_r($retorno['rgrafico'] );exit;
            echo json_encode($retorno); exit;
        }
        }
        function getharmonicatensao($codColeta) {
             
            $data= $this->grafico_model->get_harmonicatensao($codColeta);
            $i = 0;
            foreach ($data as $value) {
            $dados[$i]= $value->HARMONICA;
               // echo ' **** '.$value->HARMONICA;
                $i++;
            }
            
          //  print_r($data);
            return $dados;
            //  $retorno['rgrafico']['harmonica']
        }
    
        
         function getharmonicacorrente($codColeta) {
             
            $data= $this->grafico_model->get_harmonicacorrente($codColeta);
            $i = 0;
            foreach ($data as $value) {
            $dados[$i]= $value->HARMONICA;
               // echo ' **** '.$value->HARMONICA;
                $i++;
            }
            
          //  print_r($data);
            return $dados;
            //  $retorno['rgrafico']['harmonica']
        }
    
}

?>
