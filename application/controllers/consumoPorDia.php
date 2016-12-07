<?php

/**
 * 2016
 * Desenvolvido por: Giovani André Rizzardi
 * Email: giovanirizzardi@gmail.com
 * Projeto de conclusão de curso
 * UPF - Ciência da Computação
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class consumoPorDia extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('consumoPorDia_model');
    }

    public function index() {

        // $data['usuario'] = $this->usuario_model->get_all_usuario();

        $data['title'] = $this->lang->line('page_title_consume');
        $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>" .
                "<script src=" . base_url() . "includes/js/sorttable.js></script>" .
                "<script src=" . base_url() . "includes/js/funcoesjs.js></script>" .
                "<script src=" . base_url() . "includes/js/highcharts.js></script>";

        $this->load->template('consumoPorDia_view', $data);
    }

    function getData() {
//        $dtinicio = '2016-09-01';
//        $dtfim = '2016-10-18';
        $dtinicio = $_GET['inicio'];
        $dtfim = $_GET['fim'];


        $retorno['dado'] = $this->consumoPorDia_model->getData($dtinicio, $dtfim);
        $retorno['dados']['maiorcorrente'] = 0;
        $retorno['dados']['menorcorrente'] = 999999;
        $retorno['dados']['maiortensao'] = 0;
        $retorno['dados']['menortensao'] = 9999999;
        foreach ($retorno['dado'] as $value) {
            if ($value->KW >= $retorno['dados']['maiorcorrente'])
                $retorno['dados']['maiorcorrente'] = $value->KW;
            if ($value->KW < $retorno['dados']['menorcorrente'])
                $retorno['dados']['menorcorrente'] = $value->KW;
            if ($value->DELTA_T >= $retorno['dados']['maiortensao'])
                $retorno['dados']['maiortensao'] = $value->DELTA_T;
            if ($value->DELTA_T < $retorno['dados']['menortensao'])
                $retorno['dados']['menortensao'] = $value->DELTA_T;
        }


        echo json_encode($retorno);
        exit;
    }

}
