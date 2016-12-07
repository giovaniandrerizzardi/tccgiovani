<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 2016
 * Desenvolvido por: Giovani André Rizzardi
 * Email: giovanirizzardi@gmail.com
 * Projeto de conclusão de curso
 * UPF - Ciência da Computação
 */
class inicio extends MY_Controller {
	
	//Como este controller estende o MY_Controller, que é onde está a verificação de login e senha, então aqui você não precisa
	//fazer nenhuma verifição se o usuário está logado.
	//Lembre-se: os controllers que você deseja proteger, devem estender o MY_Controller. 
	//O controller Login não pode estender o MY_Controller, caso contrário o código entra em loop, e também não tem sentido proteger
	//a tela de login. :)
	public function __construct()
	{
		parent::__construct();
	} 
	//carrega a home Página de boas vindas
	//carrega a home Página de boas vindas
    public function index() {
        $data['title'] = $this->lang->line('page_title_v_home');
             $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                    "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>" .
                    "<script src=" . base_url() . "includes/js/highcharts.js></script>".
                    "<script src=" . base_url() . "includes/js/graficosdetalhes.js></script>" .
                    "<script src=" . base_url() . "includes/js/funcoesjs.js></script>";
                    
                    
            $this->load->template('grafico_view', $data);
    }
}