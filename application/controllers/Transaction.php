<?php

class Transaction extends MY_Controller {

	public $bank_ids;

	function __construct() {
		parent::__construct();
		$this->load->model('transaction_model', 'transaction');
		$this->load->helper('form', 'url');
		$this->load->model('bank_model', 'bank');
		$this->bank_ids = $this->bank->get_banks(TRUE);
		$this->load->library('OfxParse');
	}

	public function index() {

		$data = [
			'bank_ids' => $this->bank_ids,
			'target' => 'transaction/upload',
			'title' => 'Upload transactions',
			'error' => ' ',
		];
		$this->load->view('index', $data);
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
		$options['date_start'] = $this->input->get('date_start');
		$options['date_end'] = $this->input->get('date_end');
		$options['bank_id'] = $this->input->get('bank_id');
		$options['transactions'] = $this->transaction->get_all($options);
		$this->load->library('table');
		$options['target'] = 'transaction/view';
		$options['title'] = sprintf('Viewing Transactions from %s to %s', date('m-d-Y', strtotime($options['date_start'])),
			date('m-d-Y', strtotime($options['date_end'])));
		$this->load->view('index', $options);

	}

	public function edit_value() {
		$id = $this->input->post('id');
		$field_name = $this->input->post('field_name');

		$result = $this->transaction->get($id);
		if($field_name == 'account_id'){
			$this->load->model('account_model','account');
			$result->input_field = form_dropdown($field_name, $this->account->get_accounts(TRUE));
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
		return json_encode($result);
	}

}
