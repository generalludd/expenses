<?php
$grand_total = $expense_total;?>
	<tr>
		<td colspan="3">Amounts Paid</td>
	</tr>

<?php foreach ($payments as $payment):
	$amt_paid = get_value($payment, "amt");
	$grand_total = $fee_total / $user_count - $expense_total - $amt_paid; ?>

	<tr data-id="<?php echo $payment->id;?>">
		<td><?php echo format_date($payment->date_paid); ?></td>
		<td class="amt">
			<a href='<?php echo base_url("/payment/edit/?id=$payment->id"); ?>' class='edit dialog payment-edit'
											 id='pmt_<?php echo $payment->id . "_" . $grand_total; ?>'
											 title="Edit this payment">-<?php echo get_as_cash($payment->amt); ?></a>
			<a href="<?php echo base_url("payment/delete"); ?>" data-id="<?php echo $payment->id; ?>" data-parent="tr"
				 class="button btn-sm btn btn-danger delete ajax inline" title="Delete this Payment"><i
					class="far fa-trash-alt"></i></a>
		</td>
	</tr>

<?php endforeach; ?>
<tr>
<td><a href="<?php echo base_url("/payment/create/?user_id=$userID&total_due=$grand_total");?>" class="edit dialog" title="Add a payment">Add Payment</a></td>
</tr>
<tr class="bottom-line">
	<td>Amount Owed:</td>
	<td class="amt"><?php echo get_as_cash($grand_total); ?></td>
</tr>
