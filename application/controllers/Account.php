<?php
/** manage a chart of accounts */

class Account extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('account_model', 'account');

	}

	function index() {
		$data['accounts'] = $this->account->get_accounts();
		$data['target'] = 'account/list';
		$data['title'] = 'Chart of Accounts';
		$data['action'] = 'insert';
		$this->load->view('index', $data);
	}

	function create() {
		$data = [
			'target' => 'account/edit',
			'action' => 'insert',
			'title' => 'Create an Account',
			'account' => FALSE,
		];
		if ($this->input->get('ajax')) {
			$this->load->view('page/modal', $data);
		}
		else {
			$this->load->view('index', $data);
		}
	}


	function insert() {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$this->account->insert($id, $name);
		redirect('account/index');
	}

	function edit($id) {
		$data = [
			'target'=>'account/edit',
			'title' => 'Edit an Account',
			'account' => $this->account->get($id),
			'action' => 'update',
		];
		if($this->input->get('ajax')){
			$this->load->view('page/modal',$data);
		}
		else{
			$this->load->view('index',$data);
		}
	}

	function update() {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$this->account->update($id, $name);
		redirect('account/index');
	}

}
