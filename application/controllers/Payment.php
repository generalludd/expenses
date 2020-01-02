<?php


class payment extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('payment_model', 'payment');
	}

	function pay() {
		$fee_id = $this->input->post('value');
		$user_id = $this->input->post('user_id');
		$this->payment->insert($fee_id, $user_id);
		$this->load->model('fee_model', 'fee');
		$fee = $this->fee->get($fee_id);
		$payments = $this->payment->get_for_user($user_id, [
			'mo' => $fee->mo,
			'yr' => $fee->yr,
		]);
		$this->load->model('expense_model', 'expense');
		$expense_total = $this->expense->get_user_total($user_id, $fee->mo, $fee->yr);
		$this->load->model('fee_model', 'fee');
		$fee_total = $this->fee->get_totals($fee->mo, $fee->yr) / 2;
		$data = [
			'payments' => $payments,
			'fee_total' => $fee_total,
			'expense_total' => $expense_total,
			'month' => $fee->mo,
			'year' => $fee->yr,
			'userID' => $user_id,
			'is_me' => $user_id == $this->session->userdata("userID") ? TRUE : FALSE,
			'is_admin' => $this->session->userdata("role") == "admin" ? TRUE : FALSE,
		];
		echo $this->load->view('payment/list', $data, TRUE);
	}

	function delete() {
		$id = $this->input->post("id");
		$payment = $this->payment->get($id);
		$this->payment->delete($id);
		$payments = $this->payment->get_for_user($payment->user_id, [
			'mo' => $payment->mo,
			'yr' => $payment->yr,
		]);
		$this->load->model('expense_model', 'expense');
		$expense_total = $this->expense->get_user_total($payment->user_id, $payment->mo, $payment->yr);
		$this->load->model('fee_model', 'fee');
		$fee_total = $this->fee->get_totals($payment->mo, $payment->yr) / 2;
		$data = [
			'payments' => $payments,
			'fee_total' => $fee_total,
			'expense_total' => $expense_total,
			'month' => $payment->mo,
			'year' => $payment->yr,
			'userID' => $payment->user_id,
			'is_me' => $payment->user_id == $this->session->userdata("userID") ? TRUE : FALSE,
			'is_admin' => $this->session->userdata("role") == "admin" ? TRUE : FALSE,
		];
		echo $this->load->view('payment/list', $data, TRUE);
	}
}
