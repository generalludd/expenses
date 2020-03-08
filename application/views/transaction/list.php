<h2><?php print $title; ?></h2>
<div class="info-block">
<?php
$this->load->view('transaction/search');
print $chart;
?>
</div>
<table class="table">
	<thead>
	<tr>
		<th>Account</th>
		<th>Date</th>
		<th>Vendor</th>
		<th>Amount</th>
		<th>Check Number</th>
		<th>Bank</th>
	</tr>
	</thead>
	<tbody>
	<tr class="totals">
		<td colspan="2"></td>
		<td>Grand Total</td>
		<td colspan="3"><?php echo get_as_cash($grand_total);?>
		</td>
	</tr>
	<?php foreach ($transactions as $transaction):?>
		<tr class="transaction"
				data-id="<?php echo $transaction->id; ?>">
			<td class="transaction-account ajax inline"
					data-id="<?php echo $transaction->id; ?>"
					data-value="<?php echo $transaction->account_id; ?>"
					data-name="account_id">
				<?php echo form_dropdown('account_id', $accounts, $transaction->account_id, sprintf('data-id="%s" data-value="%s" data-name="%s"', $transaction->id, $transaction->account_id, 'account_id')); ?>
			</td>
			<td
				class="transaction-date"><?php echo date('m-d-Y', strtotime($transaction->date)); ?></td>
			<td class="transaction-info">
				<div
					class="transaction-vendor ajax inline"
					data-id="<?php echo $transaction->id; ?>"
					data-value="<?php echo $transaction->vendor; ?>"
					data-name="vendor">
					<label for="vendor" class="mobile-only">Vendor:</label>
					<input type="text" name="vendor"
								 value="<?php echo $transaction->vendor; ?>"
								 data-id="<?php echo $transaction->id; ?>"
								 data-value="<?php echo $transaction->vendor; ?>"
								 data-name="vendor" size="50"/></div>
				<div
					class="transaction-memo ajax inline"
					data-id="<?php echo $transaction->id; ?>"
					data-value="<?php echo $transaction->memo; ?>"
					data-name="memo">
					<input type="text" name="memo"
								 data-id="<?php echo $transaction->id; ?>"
								 data-value="<?php echo $transaction->memo; ?>"
								 data-name="memo"
								 value="<?php echo str_replace($transaction->vendor, '', $transaction->memo); ?>"
								 size="50"/></div>
			</td>
			<td class="transaction-amount">
				<?php echo get_as_cash($transaction->amount); ?>
			</td>
			<td class="transaction-check_number">
				<?php if ($transaction->check_number > 0): ?>
					<?php echo $transaction->check_number; ?>
				<?php endif; ?>
			</td>
			<td class="transaction-bank"
					data-bank-id="<?php echo $transaction->bank_id; ?>">
				<?php if ($transaction->website != ''): ?>
					<a href="<?php echo $transaction->website; ?>"
						 target="_blank"><?php echo $transaction->bank; ?></a>
				<?php else: ?>
					<?php echo $transaction->bank; ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>

</table>
