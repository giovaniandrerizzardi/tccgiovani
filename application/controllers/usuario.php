<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');

	}  


	public function index()
	{
		
		 $link = $this->input->get('link');
        if ($link == 'cadastro') {
            $data['usuario'] = $link;
            $data['title'] = $this->lang->line('page_title_cadastre_user');
            $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                    "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>";
            $this->load->template('usuario_cadastro', $data);
        } else {
            $data['usuario'] = $this->usuario_model->get_all_usuario();
            
            $data['title'] = $this->lang->line('page_title_consult_user');
            $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                    "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>" .
                    "<script src=" . base_url() . "includes/js/sorttable.js></script>" .
                    "<script src=" . base_url() . "includes/js/funcoesjs.js></script>";
            $this->load->template('usuario_consulta', $data);
        }
		
	}

	// create usuario
	function create_usuario()
	{
		//teste o nível do usuário
		if ($this->session->userdata('nivel') == '1') {
			$data=array(
				'USUARIO_COD'=>$this->input->post('id'),
				'NOME'=>$this->input->post('nome'),
				'CPF'=>$this->input->post('cpf'),
				'EMAIL'=>$this->input->post('email'),
				'SENHA'=>$this->input->post('senha'),
				'NIVEL'=>$this->input->post('nivel')
				);
			print_r($data);
			if($this->usuario_model->add_usuario($data)){
				$this->session->set_flashdata('msg',$this->lang->line('msg_insert'));
				redirect('usuario?link=cadastro');
			}
		} else {
			$this->session->set_flashdata('msg',$this->lang->line('msg_permission_insert'));
			redirect('usuario?link=cadastro');
		}
	}

	//delete usuario
	function apagar_usuario(){
		//testa o nível do usuário
		if ($this->session->userdata('nivel') == '1') {
			if ($this->usuario_model->delete_usuario()) {
				$this->session->set_flashdata('msg',$this->lang->line('msg_delete'));
				redirect('usuario');
			}else{
				die($this->lang->line('msg_error_delete'));
			}
		}else{
			$this->session->set_flashdata('msg',$this->lang->line('msg_permission_delete'));
			redirect('index.php/usuario');
		}
	}

	//update usuario
	function editar_usuario($id){
		//testa o nível do usuário
		if ($this->session->userdata('nivel') == '1') {
			$data['usuario']=$this->usuario_model->get_by_id_usuario($id);
			$this->form_validation->set_rules('nome','nome','trim|required');

			if ($this->form_validation->run()) {
				$_POST['id']=$id;
				if($this->usuario_model->update_usuario($_POST)){
					$this->session->set_flashdata('msg',$this->lang->line('msg_update'));
					redirect('usuario?link=cadastro');
				}
			}
			$this->load->template('usuario_cadastro',$data);
		}else{
			$this->session->set_flashdata('msg',$this->lang->line('msg_permission_update'));
			redirect('index.php/usuario');
		}
	}

	// aletrar senha usuario
	function editar_senha($id){
			$data['usuario']=$this->usuario_model->get_by_id_usuario($id);
			
			if($_POST['novasenha'] == $_POST['confirmnovasenha'] && $data['usuario']->senha == $_POST['senhaatual'] ){
				$this->form_validation->set_rules('novasenha','novasenha','trim|required');
				if ($this->form_validation->run()) {
					$_POST['id']=$id;
					if($this->usuario_model->update_senha($_POST)){
						$this->session->set_flashdata('msg',$this->lang->line('msg_update_password'));
						redirect('usuario?link=cadastro');
					}
				}	
			}else{
				$this->session->set_flashdata('msg',$this->lang->line('msg_password_error'));
				redirect('index.php/usuario?link=cadastro');
			}
			$this->load->view('usuario_cadastro',$data);
	}

	function verifica(){


		if($this->usuario_model->verifica() >= 1){
			$this->session->set_flashdata('msg',$this->lang->line('msg_permission_insert'));
		}
	}

}
