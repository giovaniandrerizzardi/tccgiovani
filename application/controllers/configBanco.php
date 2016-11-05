<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class configBanco extends MY_Controller {

        public function __construct()
	{
		parent::__construct();
	//	$this->load->model('nome_do_arquivo_pasta_model_sem_extensao');
	}

	public function index()
	{
		if (isset($_POST)) if (isset($_POST['do'])) return $this->doPost();
            $data['title'] = 'Configuração do Banco de Dados';
            $this->load->template('configBanco', $data);
	}

	public function doPost()
	{
		$nmHost = $_POST['nmHost'];
		$nmUsuario = $_POST['nmUsuario'];
		$pwUsuario = $_POST['pwUsuario'];
		$dbName = $_POST['dbName'];
		$configbanco = <<< EOF
	\$userDb = array(
	'hostname' => '$nmHost',
	'username' => '$nmUsuario',
	'password' => '$pwUsuario',
	'database' => '$dbName',
	);

EOF;
		$fp = fopen(APPPATH.'config/user.database.php', 'w');
		fwrite($fp, '<?php ');
		fwrite($fp, $configbanco);
		fflush($fp);
		fclose($fp);

		redirect(base_url('index.php/login'));
	}
}
