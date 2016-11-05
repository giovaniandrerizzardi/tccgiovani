
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 2015
 * Desenvolvido por: Mateus Perego
 * Email: mateusperego@yahoo.com.br
 * Projeto de conclusão de curso
 * UPF - Ciência da Computação
 */
class Login extends MY_Controller {

    public $infoDb;

    /*
     * Este controller deve estender o CI_Controller
     * Verifica a linguagem do navegador e sugere ao usuário a linguagem, caso não encontre definide a linguagem definida no default
     * Abaixo verifica se o conteúdo da variável logado na sessão é igual a 1, caso seja, não faz nada,
     * caso não seja então redireciona novamente para o controller de login.
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');

        $idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 5);

        switch ($idioma) {
            case 'pt-BR': //Caso seja português
                $this->lang->load("error", "pt-BR");
                $this->lang->load("labels", "pt-BR");
                $this->lang->load("message", "pt-BR");
                break;
            case 'en-US': //Caso seja ingles US
                $this->lang->load("error", "en-US");
                $this->lang->load("labels", "en-US");
                $this->lang->load("message", "en-US");
                break;
            default: // se não for nenhum
                $this->lang->load("error", "pt-BR");
                $this->lang->load("labels", "pt-BR");
                $this->lang->load("message", "pt-BR");
                break;
        }
    }

    // carrega a index
    public function index() {
        include(APPPATH . 'config/database.php');
        $this->infoDb = $db;
        $data['title'] = $this->lang->line('login');
        $data['menuHide'] = 'true'; //LIGA O MENU
        $data['footerHide'] = 'true'; //LIGA O FOOTER
        $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/login.css>";
        $this->load->template('v_login', $data);
    }

    // cria a sessão e armazena os dados do usuário caso email e senha estejam corretos


    public function logar() {
        $this->load->database();
        //Pega usuário e senha vindo do form
        $usuario = $this->input->post("usuario");
        $senha = $this->input->post("senha");
        //pega usuario e senha no banco para testar
        $login = $this->login_model->get_all_login();
        $logado = 0;
        //Se o usuário e senha combinarem, então redireciona para a url base, pois agora o usuário irá passa
        //pela verificação que checa se ele está logado.
        foreach ($login as $dados) {

            if ($usuario == $dados->EMAIL && $senha == $dados->SENHA) {
                $newusuario = array(
                    'nome' => $dados->NOME,
                    'email' => $dados->EMAIL,
                    'nivel' => $dados->NIVEL,
                    'logado' => '1'
                );
                $this->session->set_userdata($newusuario);
                $logado = 1;
                redirect(base_url());
                break;
            }
        }
        if ($logado === 0) {
            include(APPPATH . 'config/database.php');
            $this->infoDb = $db;
            $data['error'] = $this->lang->line('msg_login');
            //caso a senha/usuário estejam incorretos, então mando o usuário novamente para a tela de login com uma mensagem de erro.
            $data['error'] = $this->lang->line('msg_login');
            $data['title'] = $this->lang->line('login');
            $data['menuHide'] = 'true';
            $data['footerHide'] = 'true';
            $this->load->template("v_login", $data);
        }
    }

    /*
     * Aqui eu destruo a sessão e redireciono para a url base.
     * Assim o usuário será direcionado novamente para a tela de login.
     */

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

}
