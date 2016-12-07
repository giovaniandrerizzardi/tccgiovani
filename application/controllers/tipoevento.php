<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 2016
 * Desenvolvido por: Giovani André Rizzardi
 * Email: giovanirizzardi@gmail.com
 * Projeto de conclusão de curso
 * UPF - Ciência da Computação
 */
class tipoevento extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('tipoevento_model');
	}  

	public function index()
	{
		$link = $this->input->get('link');
        if ($link == 'cadastro') {
            $data['tipoevento'] = $link;
            $data['title'] = $this->lang->line('page_title_cadastre_te');
            $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                    "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>";
            $this->load->template('tipoevento_cadastro', $data);
        } else {
            $data['tipoevento'] = $this->tipoevento_model->get_all_tipoevento();
            
            $data['title'] = $this->lang->line('page_title_consult_te');
            $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                    "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>" .
                    "<script src=" . base_url() . "includes/js/sorttable.js></script>" .
                    "<script src=" . base_url() . "includes/js/funcoesjs.js></script>";
            $this->load->template('tipoevento_consulta', $data);
        }
		

	}

	// create tipo de evento
	function create_tipoevento()
	{
		//teste o nível do usuário
		if ($this->session->userdata('nivel') == '1') {
			$data=array(
				'CODIGO_EVT'=>$this->input->post('id'),
				'DESCRICAO'=>$this->input->post('descricao')
				);
			print_r($data);
			if($this->tipoevento_model->add_tipoevento($data)){
				$this->session->set_flashdata('msg',$this->lang->line('msg_insert'));
				redirect('tipoevento?link=cadastro');
			}
		} else {
			$this->session->set_flashdata('msg',$this->lang->line('msg_permission_insert'));
			redirect('tipoevento?link=cadastro');
		}
	}

	//delete usuario
	function apagar_tipoevento(){
		//testa o nível do usuário
		if ($this->session->userdata('nivel') == '1') {
			if ($this->tipoevento_model->delete_tipoevento()) {
				$this->session->set_flashdata('msg',$this->lang->line('msg_delete'));
				redirect('tipoevento');
			}else{
				die($this->lang->line('msg_error_delete'));
			}
		}else{
			$this->session->set_flashdata('msg',$this->lang->line('msg_permission_delete'));
			redirect('index.php/tipoevento');
		}
	}

	//update usuario
	function editar_tipoevento($id){
		//testa o nível do usuário
		if ($this->session->userdata('nivel') == '1') {
			$data['tipoevento']=$this->tipoevento_model->get_by_id_tipoevento($id);
			$this->form_validation->set_rules('descricao','descricao','trim|required');

			if ($this->form_validation->run()) {
				$_POST['id']=$id;
				if($this->tipoevento_model->update_tipoevento($_POST)){
					$this->session->set_flashdata('msg',$this->lang->line('msg_update'));
					redirect('tipoevento?link=cadastro');
				}
			
			}
			$this->load->template('tipoevento_cadastro',$data);
			
		}else{
			$this->session->set_flashdata('msg',$this->lang->line('msg_permission_update'));
			redirect('index.php/tipoevento');
		}
	}



}
