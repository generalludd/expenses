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
		$nav_buttons["create_expense"] = [
			"item" => "expense",
			"text" => "<i class=\"fas fa-plus-circle\"></i>",
			"title" => "Add a new expense",
			"href" => site_url("expense/create/" . $user->id),
			"class" => "btn btn-sm btn-warning edit dialog",
		];
		print create_button_bar($nav_buttons);
	endif;
	?>
	<table id="expense-list-<?php echo $user->id; ?>" class="list table">
		<thead>
		<tr>
			<th>Type</th>
			<th>Date</th>
			<th class="amt">Amount</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($user->expenses as $expense): ?>
			<?php $edit_button = [
				'item' => 'expense',
				'text'=>'<i class="fas fa-edit"></i>',
				'href' => base_url('expense/edit/' . $expense->id),
				'class' => 'edit dialog btn btn-sm btn-secondary',
				'title' => 'Edit ' . $expense->description,
			];
			$delete_button = [
				'item' => 'payment',
				'href' => base_url("expense/delete"),
				'text' => '<i class="far fa-trash-alt"></i>',
				'title' => 'Delete this fee',
				'class' => 'btn-sm btn btn-danger delete inline',
				'data_attributes' => [
					'field' => 'id',
					'id' => $expense->id,
					'target' => '#expense-list-' . $user->id,

				],

			];
			?>
			<tr>
				<td>
					<?php print ($is_me || $is_admin)?create_button($edit_button):NULL; ?>
				<?php echo $expense->type . ': ' . $expense->description; ?>
				</td>
				<td><?php echo format_date($expense->dt, "no-year"); ?></td>
				<td class='amt'><?php echo get_as_cash($expense->amt); ?>
					<?php print create_button($delete_button);
					?></td>
			</tr>

		<?php endforeach; ?>
		<tr class="total-line">
			<td colspan="2">Total:</td>
			<td class="amt"><?php echo get_as_cash($user->expense_total); ?></td>
		</tr>
		</tbody>
	</table>
	<?php $this->load->view('payment/totals', [
		'expense_total' => $user->expense_total,
		'fee_total' => $fee_total,
		'user' => $user,
		'user_count' => $user_count,
		'payments' => $user->payments,
		'is_me' => $is_me,
		'is_admin' => $is_admin,
	]); ?>
</div>
<!-- all done here /-->
