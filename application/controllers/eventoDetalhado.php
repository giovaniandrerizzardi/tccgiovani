<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class eventoDetalhado extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('eventoDetalhado_model');
    }

    public function index() {

        $data['tipoevento'] = $this->eventoDetalhado_model->get_evt();

        $data['title'] = $this->lang->line('page_title_consume');
        $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>" .
                "<link rel='stylesheet' href=" . base_url() . "includes/bootstrapTable/bootstrap-table.min.css>" .
                "<script src=" . base_url() . "includes/js/sorttable.js></script>" .
                "<script src=" . base_url() . "includes/js/funcoesjs.js></script>" .
                "<script src=" . base_url() . "includes/js/highcharts.js></script>";

        $this->load->template('eventoDetalhado_view', $data);
    }

    function getData() {
        $dtinicio = '2016-09-25';
        $dtfim = '2016-10-29';
//        $dtinicio = $_GET['inicio'];
//        $dtfim = $_GET['fim'];


        $retorno['dado'] = $this->eventoDetalhado_model->getDados($dtinicio, $dtfim);
        $retorno['tipos'] = $this->eventoDetalhado_model->getTiposTotal($dtinicio, $dtfim);
        $retorno['dados']['totalcorrente'] = 0;
        $retorno['dados']['totaltensao'] = 0;
        $retorno['dados']['maiorcorrente'] = 0;
        $retorno['dados']['menorcorrente'] = 0;
        $retorno['dados']['maiortensao'] = 0;
        $retorno['dados']['menortensao'] = 0;
        foreach ($retorno['dado'] as $value) {
            $retorno['dados']['totalcorrente']+=$value->CORRENTE_RMS;
            $retorno['dados']['totaltensao']+=$value->TENSAO_RMS;
            if ($value->CORRENTE_RMS >= $retorno['dados']['maiorcorrente'])
                $retorno['dados']['maiorcorrente'] = $value->CORRENTE_RMS;
            if ($value->CORRENTE_RMS < $retorno['dados']['menorcorrente'])
                $retorno['dados']['menorcorrente'] = $value->CORRENTE_RMS;
            if ($value->TENSAO_RMS >= $retorno['dados']['maiortensao'])
                $retorno['dados']['maiortensao'] = $value->TENSAO_RMS;
            if ($value->TENSAO_RMS < $retorno['dados']['menortensao'])
                $retorno['dados']['menortensao'] = $value->TENSAO_RMS;

            echo json_encode($retorno);
            exit;
        }


    }
}