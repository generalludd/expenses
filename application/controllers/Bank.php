<?php
/** Bank Updates */

class Bank extends MY_Controller{

	function __construct() {
		parent::__construct();
		$this->load->model('Bank_model','bank');
	}

	function index(){
		$data = [
			'target'=>'bank/view',
			'title'=>'List of Banks',
			'banks' => $this->bank->get_banks(),
		];
		$this->load->view('index',$data);
	}

	function create(){
		$data =[
			'target' => 'bank/edit',
			'title' => 'Add a bank',
			'bank' => FALSE,
			'action' => 'insert',
		];
		if($this->input->get('ajax')){
			$this->load->view('page/modal',$data);
		}
		else{
			$this->load->view('index',$data);
		}
	}


	function insert(){
		$this->bank->insert();
		redirect('bank');
	}

	function edit($id){
		$data = [
			'bank' => $this->bank->get($id),
			'target' => 'bank/edit',
			'action'=> 'update',
			'title' => 'Edit a Bank'
		];
		if($this->input->get('ajax')){
			$this->load->view('page/modal',$data);
		}
		else{
			$this->load->view('index',$data);
		}
	}

	function update(){
		$id = $this->input->post('id');
		$this->bank->update($id);
		redirect('bank');
	}
}
