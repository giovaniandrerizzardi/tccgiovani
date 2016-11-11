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
        $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
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
        $debug = false;
        if (!$debug) {
              
//            $agrupador = $_GET['agrupador'];
//            $tipodata = $_GET['tipodata'];
//            //$periodo = $_GET['periodo'];
//            $data = $_GET['dados'];
//            $dtinicio = $_GET['inicio'];
//            $dtfim = $_GET['fim'];
            
            $agrupador =  filter_input_array(INPUT_POST)['agrupador'];
            $tipodata =  filter_input_array(INPUT_POST)['tipodata'];
            //$periodo = $_GET['periodo'];
            $data =  filter_input_array(INPUT_POST)['dados'];
            $dtinicio =  filter_input_array(INPUT_POST)['inicio'];
            $dtfim =  filter_input_array(INPUT_POST)['fim'];
        } else {
            $dtinicio = '2016-10-01 11:24:26';
            $dtfim = '2016-11-11 02:23:33';
            $agrupador = "MENOR";
            $tipodata = "DIA";
            $periodo = 5;
            $data = $this->monitoramentoPeriodico_model->getMon($dtinicio, $dtfim);
        }


        $cont = 0;
        $somaT = 0;
        $somaC = 0;
        $dt = '1999-01-01 11:24:26';

        $x = 0;
        $resposta['dado'][$x]['TENSAO_RMS'] = 0;
        $resposta['dado'][$x]['CORRENTE_RMS'] = 0;
        $resposta['dado'][$x]['DATAHORA'] = 0;


        // echo '<pre>'. print_r($data);
        // MEDIA
        if ($agrupador === "MEDIA") {
            foreach ($data['dado'] as $value) {
                //echo'<pre>' . $value['DATAHORA'] . '  ' . $somaT . '  ' . $cont;
                
                if ($tipodata == "MINUTO") {
                    $datatabela = date('Y-m-d H:i', strtotime($value['DATAHORA']));
                } elseif ($tipodata == "HORA") {
                    $datatabela = date('Y-m-d H', strtotime($value['DATAHORA']));
                } else {
                    $datatabela = date('Y-m-d', strtotime($value['DATAHORA']));
                }
                //   echo'<pre>'. $datatabela .'  '.$soma .'  '. $cont ;


                if ($datatabela != $dt) {

                    if ($cont != 0) {
                        $mediaT = $somaT / $cont;
                        $mediaC = $somaC / $cont;
                      //  echo ' <pre> data: ' . $dt;
                       // echo ' mediaT: ' . $mediaT;
                       // echo ' mediaC: ' . $mediaC;
                        //guarda a resposta
                        $resposta['dado'][$x]['TENSAO_RMS'] = $mediaT;
                        $resposta['dado'][$x]['CORRENTE_RMS'] = $mediaC;
                        $resposta['dado'][$x]['DATAHORA'] = $dt;
                        $x++;
                        $cont = 1;
                        $somaT = 0;
                        $somaC = 0;
                    } else {
                        $cont++;
                    }
                    $dt = $datatabela;
                } else {
                    $cont++;
                }
                $somaT = $somaT + $value['TENSAO_RMS'];
                $somaC = $somaC + $value['CORRENTE_RMS'];
            }
            //FAZ O ULTIMO!!
            $mediaT = $somaT / $cont;
            $mediaC = $somaC / $cont;
            $resposta['dado'][$x]['TENSAO_RMS'] = $mediaT;
            $resposta['dado'][$x]['CORRENTE_RMS'] = $mediaC;
            $resposta['dado'][$x]['DATAHORA'] = $dt;

           // echo ' <pre> data: ' . $dt;
           // echo ' media: ' . $mediaT;
           // echo ' media: ' . $mediaC;
        }


        //maior
        elseif ($agrupador === "MAIOR") {
            $maiorT = 0;
            $maiorC = 0;

            foreach ($data['dado'] as $value) {
                //  echo'<pre>'. $value['DATAHORA'] .'  '.$soma .'  '. $cont ;

                if ($tipodata == "MINUTO") {
                    $datatabela = date('Y-m-d H:i', strtotime($value['DATAHORA']));
                } elseif ($tipodata == "HORA") {
                    $datatabela = date('Y-m-d H', strtotime($value['DATAHORA']));
                } else {
                    $datatabela = date('Y-m-d', strtotime($value['DATAHORA']));
                }
                //   echo'<pre>'. $datatabela .'  '.$soma .'  '. $cont ;


                if ($datatabela != $dt) {

                  //  echo ' <pre> data: ' . $dt;
                   // echo ' maiorT: ' . $maiorT;
                   // echo ' maiorC: ' . $maiorC;
                    $resposta['dado'][$x]['TENSAO_RMS'] = $maiorT;
                    $resposta['dado'][$x]['CORRENTE_RMS'] = $maiorC;
                    $resposta['dado'][$x]['DATAHORA'] = $dt;
                    $x++;
                    $maiorT = 0;
                    $maiorC = 0;
                    $dt = $datatabela;
                } else {
                    if ($value['CORRENTE_RMS'] >= $maiorC) {
                        $maiorT = $value['TENSAO_RMS'];
                        $maiorC = $value['CORRENTE_RMS'];
                    }
                }
                if ($value['CORRENTE_RMS'] >= $maiorC) {
                    $maiorT = $value['TENSAO_RMS'];
                    $maiorC = $value['CORRENTE_RMS'];
                }
            }
            //FAZ O ULTIMO!!
            if ($value['CORRENTE_RMS'] >= $maiorC) {
                $maiorT = $value['TENSAO_RMS'];
                $maiorC = $value['CORRENTE_RMS'];
            }
            $resposta['dado'][$x]['TENSAO_RMS'] = $maiorT;
            $resposta['dado'][$x]['CORRENTE_RMS'] = $maiorC;
            $resposta['dado'][$x]['DATAHORA'] = $dt;
           // echo ' <pre> data: ' . $dt;
           // echo ' maiorT: ' . $maiorT;
           // echo ' maiorC: ' . $maiorC;
            //print_r($resposta);
       
            
            
            
            //menor
            } else {
             $menorT = 99999;
            $menorC = 99999;

            foreach ($data['dado'] as $value) {
                //  echo'<pre>'. $value['DATAHORA'] .'  '.$soma .'  '. $cont ;

                if ($tipodata == "MINUTO") {
                    $datatabela = date('Y-m-d H:i', strtotime($value['DATAHORA']));
                } elseif ($tipodata == "HORA") {
                    $datatabela = date('Y-m-d H', strtotime($value['DATAHORA']));
                } else {
                    $datatabela = date('Y-m-d', strtotime($value['DATAHORA']));
                }
                 //  echo'<pre>'. $datatabela .'  '.$menorT .'  '. $menorC ;


                if ($datatabela != $dt) {

//                    echo ' <pre> data: ' . $dt;
//                    echo ' menorT: ' . $menorT;
//                    echo ' menorC: ' . $menorC;
                    $resposta['dado'][$x]['TENSAO_RMS'] = $menorT;
                    $resposta['dado'][$x]['CORRENTE_RMS'] = $menorC;
                    $resposta['dado'][$x]['DATAHORA'] = $dt;
                    $x++;
                    $menorT = 99999;
                    $menorC = 99999;
                    $dt = $datatabela;
                } else {
                    if ($value['CORRENTE_RMS'] <= $menorC) {
                        $menorT = $value['TENSAO_RMS'];
                        $menorC = $value['CORRENTE_RMS'];
                    }
                }
                if ($value['CORRENTE_RMS'] <= $menorC) {
                    $menorT = $value['TENSAO_RMS'];
                    $menorC = $value['CORRENTE_RMS'];
                }
            }
            //FAZ O ULTIMO!!
            if ($value['CORRENTE_RMS'] <= $menorC) {
                $menorT = $value['TENSAO_RMS'];
                $menorC = $value['CORRENTE_RMS'];
            }
            $resposta['dado'][$x]['TENSAO_RMS'] = $menorT;
            $resposta['dado'][$x]['CORRENTE_RMS'] = $menorC;
            $resposta['dado'][$x]['DATAHORA'] = $dt;
//            echo ' <pre> data: ' . $dt;
//            echo ' menorT: ' . $menorT;
//            echo ' menorC: ' . $menorC;
            
          //  print_r($resposta);
        }

        // print_r($resposta);
        echo json_encode($resposta);
        exit;
    }

    function attAutomatica() {
        $data = $this->monitoramentoPeriodico_model->attAut();

        echo json_encode($data);
        exit;
    }

    // fazer o esquema do caderno, unico jeito  viavel
}
