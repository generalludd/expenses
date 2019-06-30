<?php
$display_expense = get_as_cash($expense_total);
if (abs($expense_total) == $expense_total) {
	$display_expense = "-" . get_as_cash($expense_total);
}
?>
<h5>Your Payments</h5>
<?php if ($is_admin || $is_me):
	$nav_buttons["create_payment"] = array("item" => "payment", "text" => "<i class=\"fas fa-plus-circle\"></i>", "title" => "Add a new payment", "href" => site_url("payment/create/" . $user->id), "class" => "btn btn-sm btn-warning edit dialog");
	print create_button_bar($nav_buttons);
endif; ?>
<table id="payment-totals-<?php echo $user->id;?>" class="list table table-sm">

	<?php $this->load->view('payment/list',['payments' => $user->payments,'expense_total'=>$expense_total,'userID' => $user->id]); ?>

</table>
