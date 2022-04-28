<?php
?>

<form id="transaction-batch" name="transaction-batch" method="post"
			action="<?php print base_url('transaction/batch_complete'); ?>">
	<div class="stacked-fields">
		<input type="hidden" value="<?php print implode(',',$transaction_ids); ?>"
					 name="transaction_ids"/>
		<input type="hidden" value="<?php print $return_path; ?>"
					 name="return_path"/>
		<?php echo form_dropdown('account_id', $accounts, $this->input->get('account_ids'), 'required'); ?>
	</div>
	<input type="submit" value="Batch Apply"
				 title="Warning: this will apply to a number of records"
				 class="btn btn-sm btn-danger"/>
</form>
