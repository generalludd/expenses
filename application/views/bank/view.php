<?php
$buttons['add-bank'] = ['text'=>'Add Bank','href'=>base_url('bank/create'),'class'=>'btn btn-warning dialog add'];
print create_button_bar($buttons);

?>
<table class="bank-list">
	<thead>
	<tr>
		<th>Bank</th>
		<th>Type</th>
		<th>Url</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($banks as $bank):?>
	<tr class="bank" data-id="<?php print $bank->id; ?>">
		<td class="bank-name" data-name="bank">
			<?php print $bank->bank;?>
		</td>
		<td class="bank-url" data-name="website">
			<?php print $bank->website;?>

		</td>
		<td class="bank-type" data-name="bank_type">
<?php print $bank->bank_type;?>
		</td>
		<td>
			<a href="<?php echo base_url('bank/edit/' . $bank->id);?>" title="Edit this bank" class="btn btn-sm btn-success dialog edit">Edit</a>
		</td>
	</tr>
	<?php endforeach;?>
	</tbody>
</table>
