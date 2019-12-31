<?php ?>
<form action="<?php echo base_url('transaction/import'); ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">
<input type="hidden" name="bank_id" size="20" value="<?php echo $bank_id;?>">
	<?php foreach($source_fields as $source_field):?>
	<p>
		<?php print $source_field;?>
	</p>
	<?php endforeach;?>
<input type="submit" value="Continue">

</form>


