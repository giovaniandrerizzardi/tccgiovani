<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class monitoramentoPeriodico extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('monitoramentoPeriodico_model');
    }

    public function index() {

        // $data['tipoevento'] = $this->monitoramentoPeriodico_model->getMon();

        $data['title'] = $this->lang->line('page_title_consume');
        $data['headerOption'] =
                
                
                
                "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>" .
                "<link rel='stylesheet' href=" . base_url() . "includes/bootstrapTable/bootstrap-table.min.css>" .
                "<script src=" . base_url() . "includes/js/sorttable.js></script>" .
                "<script src=" . base_url() . "includes/js/funcoesjs.js></script>" .
                "<script src=" . base_url() . "includes/js/highcharts.js></script>";

        $this->load->template('monitoramentoPeriodico_view', $data);
    }

    function getData() {
//    $dtinicio = '2016-09-25';
//     $dtfim = '2016-10-30';
        $dtinicio = $_GET['inicio'];
        $dtfim = $_GET['fim'];


        $retorno['dado'] = $this->monitoramentoPeriodico_model->getMon($dtinicio, $dtfim);





        echo json_encode($retorno);
        exit;
    }

    function calcula() {
        $debug = true;
        if (!$debug) {
            $agrupador = $_GET['agrupador'];
            $tipodata = $_GET['tipodata'];
            $periodo = $_GET['periodo'];
            $data = $_GET['dados'];
            $dtinicio = $_GET['inicio'];
            $dtfim = $_GET['fim'];
        } else {
            $dtinicio = '2016-10-01 11:24:26';
            $dtfim = '2016-11-02 02:23:33';
            $agrupador = "MAIOR";
            $tipodata = "HORA";
            $periodo = 5;
            $data = $this->monitoramentoPeriodico_model->getMon($dtinicio, $dtfim);
        }
        if ($tipodata == "MINUTO") {
            $tipodate = "minutes";
        } elseif ($tipodata == "HORA") {
            $tipodate = "hours";
        } else {
            $tipodate = "days";
        }
       

        //
        //
        //
        //echo 'tipo data = ' . $tipodate;
        $inicio = date('Y/m/d H:i:s', strtotime($dtinicio));
        $fim = date('Y/m/d H:i:s', strtotime($dtinicio . " +{$periodo} {$tipodate}"));

            
        $cont =0;
        $soma = 0;
        $dt = '2013-10-01 11:24:26';
        
        
        // isso e pra fazer a media em minutos. agora tem que fazer em horas e dias
        foreach ($data as $value) {
          //  echo'<pre>'. $value->DATAHORA .'  '.$soma .'  '. $cont ;
             $datatabela = date('Y-m-d H:i',  strtotime($value->DATAHORA));
           //   echo'<pre>'. $datatabela .'  '.$soma .'  '. $cont ;
             if($datatabela != $dt){
                 
             
                 if($cont!= 0){
                     $media = $soma /$cont;
                     echo ' <pre> data: '.$dt;
                     echo ' media: '.$media;
                     
                     $cont = 1;
                     $soma = 0;
                 }else{
                     $cont++;
                 }
                 $dt=$datatabela;

             }else{
                 $cont++;
             }
             $soma = $soma+ $value->CORRENTE_RMS;
             
            
        }
        $media = $soma /$cont;
                    echo ' <pre> data: '.$dt;
                     echo ' media: '.$media;
       // echo json_encode($resp);
        exit;
    }

    
    
    
    
    function attAutomatica() {
        $data = $this->monitoramentoPeriodico_model->attAut();

        echo json_encode($data);
        exit;
    }

    // fazer o esquema do caderno, unico jeito  viavel
}
