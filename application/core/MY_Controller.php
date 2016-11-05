<?php

class MY_Controller extends CI_Controller {
    /*
     * Este controller deve estender o CI_Controller
     * Verifica a linguagem do navegador e sugere ao usuário a linguagem, caso não encontre definide a linguagem definida no default
     * Abaixo verifica se o conteúdo da variável logado na sessão é igual a 1, caso seja, não faz nada,
     * caso não seja então redireciona novamente para o controller de login.
     */

    public function __construct() {
        parent::__construct();
	$idioma = $this->session->userdata("lang");
	if (!(isset($idioma))) $idioma = "en-US";


        switch ($idioma) {
            case 'pt-BR': //Caso seja português
                $this->lang->load("error", "pt-BR");
                $this->lang->load("labels", "pt-BR");
                $this->lang->load("message", "pt-BR");
                break;
            default:
                $this->lang->load("error", "en-US");
                $this->lang->load("labels", "en-US");
                $this->lang->load("message", "en-US");
                break;
        }

        $logado = $this->session->userdata("logado");

	if (get_class($this) == 'configBanco') { } // do nothing
	else {
		if (get_class($this) == 'Login') { } // do nothing
		else {
			if ($logado != 1)
				redirect(base_url('index.php/login'));
			else
				$this->load->database();
		}
	}

    }

}
