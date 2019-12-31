<?php

class Transaction extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('transaction_model', 'transaction');
		$this->load->helper('form', 'url');
	}

	public function index() {
		$this->load->view('index', [
			'target' => 'transaction/upload',
			'title' => 'Upload transactions',
			'error' => ' '
		]);
	}

	public function upload() {
		$config['upload_path'] = '/tmp';
		$config['allowed_types'] = ['csv'];
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('transactions')) {
			$data['error'] = $this->upload->display_errors();
			$data['target'] = 'transaction/upload';
			$data['title'] = 'Upload transactions';

			$this->load->view('transaction/upload', $data);
		}
		else {
			$csv = $this->upload->data();
			$file = $csv['full_path'];
			$row = 1;
				$csv = array_map('str_getcsv', file($file));
				array_walk($csv, function(&$a) use ($csv) {
					$a = array_combine($csv[0], $a);
				});
				array_shift($csv); # remove column header
foreach($csv as $transaction){
	$values  = [];
	$values['date'] = $date = date('Y-m-d', strtotime(str_replace('-', '/', $transaction['Date'])));
$values['amount'] = $transaction['Amount'];
$values['vendor'] = $transaction['Name'];
$this->transaction->insert($values);
}

		}


	}
}
