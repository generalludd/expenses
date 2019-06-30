<?php
$fee_total = 0;
?>
<!-- fee/list -->
<div id="monthly-fees" class='block border'>
	<h3>Monthly Fees for <?php print format_month($month, $year)?></h3>
	<p><a class="btn btn-warning btn-sm dialog edit" title="Add a new fee"
				href="<?php echo site_url("fee/create"); ?>"><i class="fas fa-plus-circle"></i></a></p>
	<table class="list table table-sm">
		<thead>
		<tr>
			<th></th>
			<th id="fee-type">Type</th>
			<th id="fee-amount">Amount</th>
			<th id="fee-amount-due">Amount Due</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($fees as $fee): ?>
			<tr data-id="<?php echo $fee->id; ?>">
				<td><a class='btn btn-secondary btn-sm edit dialog' title='Edit this fee'
							 href='<?php echo site_url("fee/edit/$fee->id"); ?>'><i class="fas fa-edit"></i></a>

				</td>
				<td><?php echo $fee->type; ?></td>
				<td class='amt'><?php echo get_as_cash($fee->amt); ?> </td>
				<td class='amt'><?php echo get_as_cash($fee->amt / $user_count); ?> </td>
				<td>
					<a href="<?php echo base_url("fee/delete"); ?>" data-id="<?php echo $fee->id; ?>" data-parent="tr"
						 class="button btn-sm btn btn-danger delete ajax inline" title="Delete this fee"><i
							class="far fa-trash-alt"></i></a>
				</td>
			</tr>
			<?php $fee_total += $fee->amt; ?>
		<?php endforeach; ?>
		<tr class="bottom-line">
			<td></td>
			<td>Total:</td>
			<td class="amt"><?php echo get_as_cash($fee_total); ?></td>
			<td class="amt"><?php echo get_as_cash($fee_total / $user_count); ?>
			<td></td>
		</tr>

		</tbody>
	</table>
</div>

<!-- end fee/list.php -->
