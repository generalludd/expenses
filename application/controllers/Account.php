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
			'target' => 'account/edit',
			'title' => 'Edit an Account',
			'account' => $this->account->get($id),
			'action' => 'update',
		];
		if ($this->input->get('ajax')) {
			$this->load->view('page/modal', $data);
		}
		else {
			$this->load->view('index', $data);
		}
	}

	function update() {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$this->account->update($id, $name);
		redirect('account/index');
	}

	function chart() {
		$start_date = $this->input->get('start_date') ?
			$this->input->get('start_date') :
			date('Y-01-01');
		$end_date = $this->input->get('end_date') ?
			$this->input->get('end_date') :
			date('Y-m-d');
		$start_account = $this->input->get('start_account')?
		$this->input->get('start_account'):
		500;
		$end_account = $this->input->get('end_account');
		$account_ids = $this->input->get('account_ids');
		var_dump($account_ids);
		$options = [
			'date_range' => [
				'start' => $start_date,
			],
			'account_range' => [
				'start' => 500,
			],
		];
		$totals = $this->account->get_category_totals($options);
		$data = [
			'title' => 'Chart',
			'target' => 'account/chart',
			'totals' => $totals,
			'label' => 'Accounts',
		];
		$this->load->view('index', $data);
	}
}
