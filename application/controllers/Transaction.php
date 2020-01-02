<?php

class Transaction extends MY_Controller {

	public $bank_ids;

	function __construct() {
		parent::__construct();
		$this->load->model('transaction_model', 'transaction');
		$this->load->helper('form', 'url');
		$this->load->model('bank_model', 'bank');
		$this->bank_ids = get_keyed_pairs($this->bank->get_banks(), [
			'id',
			'bank',
		], TRUE);
		$this->load->library('OfxParse');
	}

	public function index() {
		$this->view();
	}

	public function search() {

		$this->load->model('account_model', 'account');
		$data = [
			'target' => 'transaction/search',
			'title' => 'Search Transactions',
			'banks' => $this->bank_ids,
			'accounts' => get_account_pairs($this->account->get_accounts(), TRUE),
		];
		if ($this->input->get('ajax')) {
			$this->load->view('page/modal', $data);
		}
		else {
			$this->load->view('index', $data);
		}
	}

	public function upload() {
		$data = [
			'bank_ids' => $this->bank_ids,
			'target' => 'transaction/upload',
			'title' => 'Upload transactions',
			'error' => ' ',
		];
		if ($this->input->get('ajax') == 1) {
			$this->load->view('page/modal', $data);
		}
		else {
			$this->load->view('index', $data);
		}
	}

	public function import() {
		$config['upload_path'] = '/tmp';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('transactions')) {
			$data['error'] = $this->upload->display_errors();
			$data['target'] = 'transaction/upload';
			$data['title'] = 'Upload transactions';
			$data['bank_ids'] = $this->bank_ids;

			$this->load->view('index', $data);
		}
		else {
			$upload = $this->upload->data();
			$file = $upload['full_path'];
			$transactions = $this->ofxparse->parseOFX($file);

			//prepare data array for values
			$data = [
				'bank_id' => $this->input->post('bank_id'),
			];
			$iterator = 1;
			foreach ($transactions as $transaction) {
				$values = [];
				$values['date'] = $transaction->date->format('Y-m-d H:i:s');
				if (!array_key_exists('start_date', $data)) {
					$data['date_start'] = $transaction->date->format('Y-m-d');
				}
				if ($iterator == count($transactions)) {
					$data['date_end'] = $transaction->date->format('Y-m-d');
				}
				$values['amount'] = $transaction->amount;
				$values['vendor'] = $transaction->name;
				$values['memo'] = $transaction->memo;
				$values['check_number'] = $transaction->checknumber;
				$values['bank_id'] = $this->input->post('bank_id');
				$values['transaction_id'] = $transaction->uniqueId;
				$this->transaction->insert($values);
				$iterator++;

			}
			$data['transaction_count'] = count($transactions);
			$data['target'] = 'transaction/result';
			$data['title'] = 'Result of import';

			$this->load->view('index', $data);
		}
	}

	public function view() {

		$options = [
			'date_start' => date('Y-m-d', strtotime($this->input->get('date_start'))),
			'date_end' => date('Y-m-d', strtotime($this->input->get('date_end'))),
			'bank_ids' => $this->input->get('bank_ids'),
			'account_ids' => $this->input->get('account_ids'),
			'bank_id' => $this->input->get('bank_id'),
			'vendor' => $this->input->get('vendor'),

		];
		if ($this->input->get('no_account_sort') != 1) {
			$options['order_by'] = (object) [
				'field' => 'account_id',
				'direction' => 'ASC',
			];
		}
		$this->load->model('account_model', 'account');
		$transactions = $this->transaction->get_all($options);
		$grand_total = 0;
		foreach ($transactions as $transaction) {
			$grand_total += $transaction->amount;
		}
		$data = [
			'target' => 'transaction/list',
			'banks' => $this->bank_ids,
			'title' => 'Viewing Transactions',
			'accounts' => get_account_pairs($this->account->get_accounts(), TRUE),
			'transactions' => $transactions,
			'grand_total' => $grand_total,
			'account_subs' => 0,
		];
		$data = array_merge($options, $data);


		$this->load->view('index', $data);

	}

	public function edit_value() {
		$id = $this->input->post('id');
		$field_name = $this->input->post('field_name');

		$result = $this->transaction->get($id);
		if ($field_name == 'account_id') {
			$this->load->model('account_model', 'account');
			$result->input_field = form_dropdown($field_name, get_account_pairs($this->account->get_accounts(), TRUE));
		}
		else {
			$result->input_field = sprintf('<input type="text" name="%s" value="%s"/>', $field_name, $result->{$field_name});
		}
		if ($this->input->post('ajax')) {
			echo json_encode($result);
		}
	}

	/**
	 * @return false|string
	 */
	public function update_value() {
		$field_name = $this->input->post('field_name');
		$id = $this->input->post('id');
		$value = $this->input->post('value');
		$this->transaction->update_value($id, $field_name, $value);
		$result = $this->transaction->get($id);
		echo json_encode($result);
	}

	public function batch_start() {
		$this->load->model('account_model', 'account');

		$data = [
			'transaction_ids' => $this->input->post('transaction_ids'),
			'accounts' => get_account_pairs($this->account->get_accounts(), TRUE),
			'target' => 'transaction/batch',
			'title' => 'Batch update transactions',
			'return_path' => $this->input->post('return_path'),
		];
		if ($this->input->post('ajax')) {
			$this->load->view('page/modal', $data);
		}
		else {
			$this->load->view('index', $data);
		}
	}

	public function batch_complete() {
		$transaction_ids = explode(',',$this->input->post('transaction_ids'));
		if (count($transaction_ids) > 0) {
			$account_id = $this->input->post('account_id');
			$this->transaction->batch_update_account_ids($transaction_ids, $account_id);
		}
		$return_path = $this->input->post('return_path');

		redirect($return_path);
	}

}
