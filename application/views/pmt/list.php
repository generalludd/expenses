<?php
$adjustments = 0;
$grand_total = $expense_total;?>
<?php foreach ($payments as $payment):
	$amt_paid = get_value($payment, "amt");
	$grand_total = $fee_total / $user_count - $expense_total - $amt_paid; ?>

	<tr data-id="<?php echo $payment->id;?>">
<?php var_dump($payment); ?>
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
