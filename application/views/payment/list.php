<?php
$adjustments = 0;
$grand_total = $expense_total;?>
<?php foreach ($payments as $payment):
	$amt_paid = get_value($payment, "amt");
	$grand_total = $fee_total / $user_count - $expense_total - $amt_paid; ?>
	<tr data-id="<?php echo $payment->fee_id;?>">
		<?php if ($is_admin || $is_me):
$pay_button = sprintf('<a href="%s">Pay Now</a>', base_url("pmt/pay/$payment->fee_id/$userID"));
		endif; ?>
		<td><?php echo get_value($payment, 'date_paid')? format_date($payment->date_paid):$pay_button; ?></td>
		<td class="amt">
			-<?php echo get_as_cash($payment->amt); ?>
			<?php if(get_value($payment, 'date_paid')):?>
			<a href="<?php echo base_url("pmt/delete"); ?>" data-id="<?php echo $payment->pmt_id; ?>" data-parent="payment-totals-<?php echo $userID;?>"
				 class="button btn-sm btn btn-danger delete ajax inline" title="Delete this Payment"><i
					class="far fa-trash-alt"></i></a>
					<?php endif;?>
		</td>
	</tr>
<?php $adjustments += $amt_paid;?>
<?php endforeach; ?>
<tr class="total-line">
	<td >Adjustments:</td>
	<td colspan="2" class="amt">-<?php echo get_as_cash($adjustments); ?></td>
</tr>
<tr class="bottom-line">
	<td>Amount Owed:</td>
	<td class="amt" colspan="2"><?php echo get_as_cash($grand_total); ?></td>
</tr>
