<?php
$display_expense = get_as_cash($expense_total);
if (abs($expense_total) == $expense_total) {
	$display_expense = "-" . get_as_cash($expense_total);
}
?>
<?php if($is_me):?>
<h5>Your Payments</h5>
<?php else: ?>
<h5><?php print $user->first_name; ?>'s Payments</h5>
<?php endif; ?>
<table id="payment-totals-<?php echo $user->id; ?>" class="list table table-sm">

	<?php $this->load->view('payment/list', [
		'payments' => $user->payments,
		'fee_total' => $fee_total,
		'expense_total' => $expense_total,
		'userID' => $user->id,
	]); ?>

</table>
