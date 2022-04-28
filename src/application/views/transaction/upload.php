<?php
?>
<?php echo $error;?>
<p>Select the qfx/ofx formatted file you downloaded from your bank or credit card service.</p>
<form action="<?php echo base_url('transaction/import');?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<div class="inline-fields">
	<label for="bank_id">Bank:</label>
	<?php echo form_dropdown('bank_id', $bank_ids);?>
	</div>
	<input type="file" name="transactions" size="20">
	<input type="submit" value="upload">
</form>
