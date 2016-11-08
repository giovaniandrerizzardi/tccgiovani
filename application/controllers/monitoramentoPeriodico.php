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
        $total = sizeof($data);

        $inicio = new DateTime($dtinicio);

        //echo 'tipo data = ' . $tipodate;
        $inicio = date('Y/m/d H:i:s', strtotime($dtinicio));
        $fim = date('Y/m/d H:i:s', strtotime($dtinicio . " +{$periodo} {$tipodate}"));



        //echo 'data inicio:' . $inicio;

        //echo 'data fim antiga:' . $fim;
        $x = 0;
        $contador = 0;

        $respostaCorrente[0] = 0;
        $respostaTensao[0] = 0;
        $resposta['data'][0] = 0;


        if ($agrupador === "MEDIA") {



            foreach ($data['dado'] as $key => $value) {
                //auxdata vai pega  a data do dado e testa se ele ta dentro do limite(flag true), ai vai fazer a media
                $auxdata = new DateTime($value['DATAHORA']);
                $auxdata = $auxdata->format("Y/m/d H:i:s");
                $flag = FALSE;
//                echo '<br>  valor do auxdata= ' . $auxdata;
//                echo '  valor de inicio= ' . $inicio;
//                echo '  valor de fim= ' . $fim;
                
                if ($auxdata >= $inicio && $auxdata < $fim)
                    $flag = TRUE;
                if ($flag == TRUE) {
                    if ($contador == 0)
                        $resposta['data'][$x] = $value['DATAHORA'];

                    $respostaTensao[$x] = $respostaTensao[$x] + $value['TENSAO_RMS'];
                    $respostaCorrente[$x] = $respostaCorrente[$x] + $value['CORRENTE_RMS'];
                    $contador++;
                    if ($value == end($data) && $flag == TRUE) {
                        //ultima key
                        echo 'lastkey';
                        $respostaCorrente[$x] = $respostaCorrente[$x] / $contador;
                        $respostaTensao[$x] = $respostaTensao[$x] / $contador;
                        break;
                    }
//                    echo '   esta dentro do limite com contador = ' . $contador;
                } else {
                    while ($auxdata < $inicio || $auxdata > $fim) {
                        $inicio = date('Y/m/d H:i:s', strtotime($fim));
                        $fim = date('Y/m/d H:i:s', strtotime($fim . " +{$periodo} {$tipodate}"));
                    }

//                    echo '    esta fora do limite';
                    if ($contador != 0) {
//                        echo '  dassads contador = ' . $contador;
                        $respostaCorrente[$x] = $respostaCorrente[$x] / $contador;
                        $respostaTensao[$x] = $respostaTensao[$x] / $contador;
                        $contador = 0;
                        $x++;
                        $respostaTensao[$x] = 0;
                        $respostaCorrente[$x] = 0;
                    }


//                    echo 'contador e zero';
                }
            }
        } elseif ($agrupador == "MAIOR") {

            foreach ($data as $key => $value) {
                //auxdata vai pega  a data do dado e testa se ele ta dentro do limite(flag true), ai vai fazer a media
                $auxdata = new DateTime($value['DATAHORA']);
                $auxdata = $auxdata->format("Y/m/d H:i:s");
                $flag = FALSE;
//                echo '<br>  valor do auxdata= ' . $auxdata;
//                echo '  valor de inicio= ' . $inicio;
//                echo '  valor de fim= ' . $fim;

                if ($auxdata >= $inicio && $auxdata < $fim)
                    $flag = TRUE;
                if ($flag == TRUE) {

                    if ($value['TENSAO_RMS'] > $respostaTensao[$x]) {
                        $respostaTensao[$x] = $value['TENSAO_RMS'];
                        $respostaCorrente[$x] = $value['CORRENTE_RMS'];
                        $resposta['data'][$x] = $value['DATAHORA'];
                        echo '  ***temos um novo maior: ' . $respostaTensao[$x];
                    }

//                    echo '   esta dentro do limite com contador = ' . $contador;
                } else {
                    while ($auxdata < $inicio || $auxdata > $fim) {
                        $inicio = date('Y/m/d H:i:s', strtotime($fim));
                        $fim = date('Y/m/d H:i:s', strtotime($fim . " +{$periodo} {$tipodate}"));
                    }

//                    echo '    esta fora do limite';
                    $x++;
                    $respostaTensao[$x] = 0;
                    $respostaCorrente[$x] = 0;
                }
            }
        } else {
            foreach ($data as $key => $value) {
                //auxdata vai pega  a data do dado e testa se ele ta dentro do limite(flag true), ai vai fazer a media
                $auxdata = new DateTime($value['DATAHORA']);
                $auxdata = $auxdata->format("Y/m/d H:i:s");
                $flag = FALSE;
//                echo '<br>  valor do auxdata= ' . $auxdata;
//                echo '  valor de inicio= ' . $inicio;
//                echo '  valor de fim= ' . $fim;

                if ($auxdata >= $inicio && $auxdata < $fim)
                    $flag = TRUE;
                if ($flag == TRUE) {

                    if ($value['TENSAO_RMS'] < $respostaTensao[$x]) {
                        $respostaTensao[$x] = $value['TENSAO_RMS'];
                        $respostaCorrente[$x] = $value['CORRENTE_RMS'];
                        $resposta['data'][$x] = $value['DATAHORA'];
//                        echo '  ***temos um novo maior: ' . $respostaTensao[$x];
                    }

//                    echo '   esta dentro do limite com contador = ' . $contador;
                } elseif ($agrupador == "MENOR") {
                    while ($auxdata < $inicio || $auxdata > $fim) {
                        $inicio = date('Y/m/d H:i:s', strtotime($fim));
                        $fim = date('Y/m/d H:i:s', strtotime($fim . " +{$periodo} {$tipodate}"));
                    }

//                    echo '    esta fora do limite';
                    $x++;
                    $respostaTensao[$x] = 0;
                    $respostaCorrente[$x] = 0;
                }
            }
        }


        $resposta['tensao'] = $respostaTensao;
        $resposta['corrente'] = $respostaCorrente;
       // print_r($resposta);
        echo json_encode($resposta);
        exit;
    }

      
    // fazer o esquema do caderno, unico jeito  viavel
}
