<?php
?>
<?php echo $error;?>
<h2>Select the csv you downloaded from your bank or credit card service.</h2>
<form action="<?php echo base_url('transaction/import');?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<label for="bank_id">Enter the name of the bank acount</label>
	<div class="select-block">
	<?php echo form_dropdown('bank_id', $bank_ids);?>
	</div>
	<input type="file" name="transactions" size="20">
	<input type="submit" value="upload">
</form>
