<?php

/* search transactions  by bank, date range, accounts, @//todo account-range */

?>

	<div class="search-block">
		<form name="search-accounts" id="search-accounts"
					action="<?php echo base_url('transaction/view'); ?>" method="get">
			<div class="stacked-fields">
				<label for="bank_ids">Bank</label>
				<?php if (count($banks) == 1): ?>
					<span>It looks like you haven't set up your bank list yet. Do that first by <a
							href="<?php echo base_url('bank'); ?>">clicking here</a></span>
				<?php endif; ?>
				<?php echo form_multiselect('bank_ids[]', $banks, $this->input->get('bank_ids'), ['class' => 'chosen-select']); ?>
			</div>
			<div class="inline-fields">
				<label for="date_start">Date Range</label>
				<input type="date" name="date_start" class="datefield" required
							 value="<?php echo $this->input->get('date_start'); ?>"/> to
				<input type="date" name="date_end" required
							 value="<?php echo $this->input->get('date_end'); ?>"/>
			</div>
			<div class="inline-fields">
				<label for="vendor">Search the vendor field</label>
				<input type="text" name="vendor"
							 value="<?php echo $this->input->get("vendor"); ?>"/>
			</div>
			<div class="stacked-fields">
				<label for="account_ids">
					Account(s)
				</label>
				<?php if (count($accounts) == 1): ?>
					<span>It looks like you haven't set up your chart of accounts list. Do that first by <a
							href="<?php echo base_url('account'); ?>">clicking here</a></span>
				<?php endif; ?>
				<?php echo form_multiselect('account_ids[]', $accounts, $this->input->get('account_ids'), ['class' => 'chosen-select']); ?>
			</div>
			<div class="inline-fields">
				<label for="no_account_sort">Do NOT sort by account:
					<input type="checkbox" name="no_account_sort"
								 value="1" <?php echo $this->input->get('no_account_sort') == 1 ? 'checked' : ''; ?>/>
				</label>
			</div>
			<?php
		$buttons[] = [
			'type'=>'pass-through',
			'text'=> '	<input type="submit" class="btn btn-sm btn-secondary" value="Search"
						 title="Search transactions"/>'
		];
		$buttons[] = [
			'text' => 'Upload',
			'href' => base_url('transaction/upload'),
			'title' => 'Upload new transactions',
			'class' => 'btn btn-sm btn-warning edit dialog',
		];
		$buttons[] = [
			'text' => 'Batch Update',
			'href' => base_url('transaction/batch_start'),
			'title' => 'Warning: batch alter the found transactions',
			'class' =>'btn btn-sm btn-danger batch-update',
			'data_attributes' => ['uri'=>$_SERVER['REQUEST_URI']],
		];
		print create_button_bar($buttons);
		?>

		</form>

	</div>


<script type="text/javascript">$(".chosen-select").chosen();</script>
