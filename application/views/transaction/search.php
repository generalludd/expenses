<?php

/* search transactions  by bank, date range, accounts, @//todo account-range */

?>
<div class="search-block">
	<form name="search-accounts" id="search-accounts"
				action="<?php echo base_url('transaction/view'); ?>" method="get">
		<div class="stacked-fields">
			<label for="bank_ids">Bank</label>
			<?php if(count($banks)==1):?>
			<span>It looks like you haven't set up your bank list yet. Do that first by <a href="<?php echo base_url('bank');?>">clicking here</a></span>
			<?php endif;?>
			<?php echo form_multiselect('bank_ids[]', $banks, $this->input->get('bank_ids')); ?>
		</div>
		<div class="inline-fields">
			<label for="date_start">Date Range</label>
			<input type="date" name="date_start" class="datefield" required value="<?php echo $this->input->get('date_start');?>"/> to
			<input type="date" name="date_end" required value="<?php echo $this->input->get('date_end');?>"/>
		</div>
		<div class="stacked-fields">
			<label for="account_ids">
				Account(s)
			</label>
			<?php if(count($accounts)==1):?>
			<span>It looks like you haven't set up your chart of accounts list. Do that first by <a href="<?php echo base_url('account');?>">clicking here</a></span>
			<?php endif;?>
			<?php echo form_multiselect('account_ids[]', $accounts, $this->input->get('account_ids')); ?>
		</div>
		<div class="inline-fields">
			<label for="subtotal">Subtotal by account and bank:
				<input type="checkbox" name="subtotal" value="1" <?php echo $this->input->get('subtotal') == 1?'checked':'';?>/>
			</label>
		</div>

		<input type="submit" class="btn btn-small btn-secondary" value="Search" title="Search transactions"/>
	</form>
</div>
