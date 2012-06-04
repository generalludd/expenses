<?php
echo "<div id='fees'>";
$this->load->view("fee/list");
echo "</div>";
$expense_total = 0;
$current_id = 0;
echo "<div id='expenses'>";
foreach($expenses as $expense){
	if($current_id != $expense->userID){

		$expense_total = 0;
		$current_id = $expense->userID;
		$data["payment"] = NULL;
		foreach($payments as $payment){
				
				
			if($payment->user_id == $expense->userID){
				$data["payment"] = $payment;
			}
		}


		$data["current_id"] = $current_id;
		$data["fee_total"] = $fee_total;
		$data["expense_total"] = $expense_total;
		$data["month"] = $month;
		$data["year"] = $year;
		$data["expense"] = $expense;
		$data["expenses"] = $expenses;
		$this->load->view("expense/list", $data);
	}


}//end foreach

echo "</div>";