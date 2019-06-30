<?php
$class = "";
$is_me = $user->id == $this->session->userdata("userID") ? TRUE : FALSE;
$is_admin = $this->session->userdata("role") == "admin" ? TRUE : FALSE;
if ($is_me) {
	$class = "you";
}
?>
<div class='column block border <?php echo $class; ?>'>
	<?php
	if ($is_me):?>
		<h3>Your Expenses</h3>
	<?php else: ?>
		<h3><?php echo $user->first_name; ?></h3>
	<?php endif;
	if ($is_admin || $is_me):
		$nav_buttons["create_expense"] = array("item" => "expense", "text" => "<i class=\"fas fa-plus-circle\"></i>", "title" => "Add a new expense", "href" => site_url("expense/create/" . $user->id), "class" => "btn btn-sm btn-warning edit dialog");
		print create_button_bar($nav_buttons);
	endif;
	?>
	<table class="list table">
		<thead>
		<tr>
			<th>Type</th>
			<th>Date</th>
			<th>Amount</th>
		</tr>
		</thead>
		<tbody>


		<?php
		$expense_total = 0;
		foreach ($user->expenses as $expense): ?>
			<tr>
				<td><a class=' expense dialog <?php echo $is_me || $is_admin ? 'edit' : ''; ?>'
							 href="<?php echo site_url("expense/edit/$expense->id"); ?>"
							 title='<?php echo $expense->description; ?>'><?php echo $expense->type; ?></a></td>
				<td><?php echo format_date($expense->dt, "no-year"); ?></td>
				<td class='amt'><?php echo get_as_cash($expense->amt); ?></td>

				<?php
				$expense_total += $expense->amt;
				?>
			</tr>

		<?php endforeach; ?>
		<tr class="bottom-line">
			<td></td>
			<td class="amt">Total:</td>
			<td class="amt"><?php echo get_as_cash($expense_total); ?></td>
		</tr>
		</tbody>
	</table>
	<?php
	$display_expense = get_as_cash($expense_total);
	if (abs($expense_total) == $expense_total) {
		$display_expense = "-" . get_as_cash($expense_total);
	}
	?>
	<h5>Totals</h5>
	<table class="list totals table table-sm">
		<tr>
			<td>Amount Due:</td>
			<td class="amt"><?php echo get_as_cash($fee_total / $user_count); ?></td>
		</tr>
		<tr>
			<td>Adjustment:</td>
			<td class="amt"><?php echo $display_expense; ?></td>
		</tr>
<?php $this->load->view('payment/list',['payments' => $user->payments,'expense_total'=>$expense_total,'userID' => $user->id]); ?>

	</table>
</div>
<!-- all done here /-->
