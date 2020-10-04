<?php
$fee_total = 0;
$create_button =  [
		'item' => 'fee',
		'href' => base_url('fee/create?month=' . $month . '&year-' . $year),
		'text' => '<i class="fas fa-plus-circle"></i>',
		'title' => 'Edit This Fee',
		'class' => 'btn btn-sm btn-warning edit dialog',
	];

?>
<!-- fee/list -->
<div id="monthly-fees" class='block border'>
	<h3>Monthly Fees for <?php print format_month($month, $year) ?></h3>
	<p><?php print create_button($create_button);?></p>
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
			<?php
			$edit_button = [
				'item' => 'fee',
				'href' => base_url("fee/edit/$fee->id"),
				'text' => '<i class="fas fa-edit"></i>',
				'title' => 'Edit This Fee',
				'class' => 'btn btn-sm btn-secondary edit dialog',
			];

			$delete_button = [
				'item' => 'payment',
				'href' => base_url("fee/delete"),
				'text' => '<i class="far fa-trash-alt"></i>',
				'title' => 'Delete this fee',
				'class' => 'btn btn-sm btn-danger delete inline',
				'data_attributes' => [
					'field' => 'id',
					'id' => $fee->id,
					'target' => '#monthly-fees',

				],

			]; ?>
			<tr data-id="<?php echo $fee->id; ?>">
				<td><?php echo create_button($edit_button); ?>
				</td>
				<td><?php echo $fee->type; ?></td>
				<td class="amt" data-value="<?php echo $fee->amt; ?>"><?php echo get_as_cash($fee->amt); ?> </td>
				<td
					class="amt" data-value"<?php echo $fee->amt / $user_count; ?>"><?php echo get_as_cash($fee->amt / $user_count); ?> </td>
				<td>
					<?php print create_button($delete_button); ?>
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
