<?php


class payment extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('payment_model', 'payment');
	}

	function get($id) {
		$payment = $this->payment->get($id);
		var_dump($payment);
	}


	function pay($fee_id, $user_id){

		$this->payment->insert($fee_id, $user_id);
		$this->load->model('fee_model','fee');
		$fee = $this->fee->get($fee_id);
		redirect("expense/show_all/$fee->mo/$fee->yr");
	}

	function delete(){
		$id = $this->input->post("id");
		$payment = $this->payment->get($id);
		$this->payment->delete($id);
		$payments = $this->payment->get_for_user($payment->user_id, ['mo'=>$payment->mo, 'yr' => $payment->yr]);
		$this->load->model('user_model', 'user');
		$this->load->model('expense_model','expense');
		$data = array(
			'payments' => $payments,
			'month' => $payment->mo,
			'year' => $payment->yr,
			'userID' => $payment->user_id,
		);
		echo $this->load->view('payment/list', $data, TRUE);
	}
}
