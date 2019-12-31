<?php
?>
<h2><?php print $title; ?></h2>
<table>
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
	<?php foreach ($transactions as $transaction): ?>
		<tr class="transaction"
				data-transaction-id="<?php echo $transaction->id; ?>">
			<td class="transaction-account edit ajax inline" data-value="<?php echo $transaction->account_id;?>" data-name="account_id">
				<?php echo $transaction->account_id;?>
			</td>
			<td
				class="transaction-date"><?php echo date('m-d-Y', strtotime($transaction->date)); ?></td>
			<td class="transaction-info">
				<div
					class="transaction-vendor edit ajax inline" data-value="<?php echo $transaction->vendor; ?>" data-name="vendor"><?php echo $transaction->vendor; ?></div>
				<div
					class="transaction-memo edit ajax inline" data-value="<?php echo $transaction->memo; ?>" data-name="memo"><?php echo str_replace($transaction->vendor, '', $transaction->memo); ?></div>
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
