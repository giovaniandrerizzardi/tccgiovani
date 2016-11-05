<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sensor extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sensor_model');
	}  

	public function index()
	{
		
		 $link = $this->input->get('link');
        if ($link == 'cadastro') {
            $data['sensor'] = $link;
            $data['title'] = $this->lang->line('page_title_cadastre_sensor');
            $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                    "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>";
            $this->load->template('sensor_cadastro', $data);
        } else {
            $data['sensor'] = $this->sensor_model->get_all_sensor();
            
            $data['title'] = $this->lang->line('page_title_consult_sensor');
            $data['headerOption'] = "<link rel='stylesheet' href=" . base_url() . "includes/css/estilo.css>" .
                    "<link rel='stylesheet' href=" . base_url() . "includes/css/abas.css>" .
                    "<script src=" . base_url() . "includes/js/sorttable.js></script>" .
                    "<script src=" . base_url() . "includes/js/funcoesjs.js></script>";
            $this->load->template('sensor_consulta', $data);
        }	
	}

	// create tipo de evento
	function create_sensor()
	{
		//teste o nível do usuário
		if ($this->session->userdata('nivel') == '1') {
			$data=array(
				'SENSOR_COD'=>$this->input->post('id'),
				'GANHO'=>$this->input->post('ganho'),
				'MAX_CORRENTE'=>$this->input->post('max_corrente'),
				'MIN_CORRENTE'=>$this->input->post('min_corrente')
				);
			print_r($data);
			if($this->sensor_model->add_sensor($data)){
				$this->session->set_flashdata('msg',$this->lang->line('msg_insert'));
				redirect('sensor?link=cadastro');
			}
		} else {
			$this->session->set_flashdata('msg',$this->lang->line('msg_permission_insert'));
			redirect('sensor?link=cadastro');
		}
	}

	//delete usuario
	function apagar_sensor(){
		//testa o nível do usuário
		if ($this->session->userdata('nivel') == '1') {
			if ($this->sensor_model->delete_sensor()) {
				$this->session->set_flashdata('msg',$this->lang->line('msg_delete'));
				redirect('sensor');
			}else{
				die($this->lang->line('msg_error_delete'));
			}
		}else{
			$this->session->set_flashdata('msg',$this->lang->line('msg_permission_delete'));
			redirect('index.php/sensor');
		}
	}

	//update usuario
	function editar_sensor($id){
		//testa o nível do usuário
		if ($this->session->userdata('nivel') == '1') {
			$data['sensor']=$this->sensor_model->get_by_id_sensor($id);
			$this->form_validation->set_rules('ganho','max_magnitude','trim|required');

			if ($this->form_validation->run()) {
				$_POST['id']=$id;
				if($this->sensor_model->update_sensor($_POST)){
					$this->session->set_flashdata('msg',$this->lang->line('msg_update'));
					redirect('sensor?link=cadastro');
				}
			
			}
			$this->load->template('sensor_cadastro',$data);
			
		}else{
			$this->session->set_flashdata('msg',$this->lang->line('msg_permission_update'));
			redirect('index.php/sensor');
		}
	}



}
