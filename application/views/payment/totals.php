<?php
$display_expense = get_as_cash($expense_total);
if (abs($expense_total) == $expense_total) {
	$display_expense = "-" . get_as_cash($expense_total);
}
?>
<h5>Your Payments</h5>
<table id="payment-totals-<?php echo $user->id; ?>" class="list table table-sm">

	<?php $this->load->view('payment/list', [
		'payments' => $user->payments,
		'fee_total' => $fee_total,
		'expense_total' => $expense_total,
		'userID' => $user->id,
	]); ?>

</table>
