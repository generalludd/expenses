<?php
$adjustments = 0;
$grand_total = $fee_total - $expense_total; ?>

<?php foreach ($payments as $payment):?>
	<tr data-id="<?php echo $payment->fee_id; ?>">
		<?php if ($is_admin || $is_me):
			$nav_button = [
				"item" => "payment",
				"text" => "<i class=\"fas fa-file-invoice-dollar\"></i>",
				"title" => "Pay this amount",
				"href" => site_url("payment/pay/$payment->fee_id/$userID"),
				"class" => "btn btn-sm btn-warning edit dialog",
			];
		endif; ?>
		<td><?php echo $payment->type; ?></td>
		<td><?php echo get_value($payment, 'date_paid') ? format_date($payment->date_paid):''; ?></td>
		<td class="amt">
			-<?php echo get_as_cash($payment->amt); ?>
			<?php if (get_value($payment, 'date_paid')): ?>
				<?php $adjustments += $payment->amt; ?>
				<a href="<?php echo base_url("payment/delete"); ?>"
					 data-id="<?php echo $payment->payment_id; ?>"
					 data-parent="payment-totals-<?php echo $userID; ?>"
					 class="button btn-sm btn btn-danger delete ajax inline"
					 title="Delete this Payment"><i
						class="far fa-trash-alt"></i></a>
			<?php else: ?>
				<?php echo create_button($nav_button); ?>
			<?php endif; ?>
		</td>
	</tr>

<?php endforeach; ?>
<tr class="total-line">
	<td>Adjustments:</td>
	<td colspan="3" class="amt">-<?php echo get_as_cash($adjustments); ?></td>
</tr>
<tr class="bottom-line">
	<td>Amount Owed:</td>
	<td class="amt" colspan="3"><?php echo get_as_cash($grand_total-$adjustments); ?></td>
</tr>
