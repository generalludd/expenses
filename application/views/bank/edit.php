<?php
?>
<form id="bank_editor" name="bank_editor" action="<?php echo site_url("bank/$action");?>" method="post">
	<input type="hidden" value="<?php print get_value($bank, 'id');?>" name="id"/>
	<div class="inline-fields">

	<div class="field-set">
	<label for="bank">Bank</label>
	<input type="text" name="bank" value="<?php print get_value($bank,"bank");?>"/>
</div>
	<div class="field-set">
	<label for="bank">Website</label>
	<input type="text" name="website" value="<?php print get_value($bank,"website");?>"/>
	</div>
	<div class="field-set">
	<label for="bank">Bank Type</label>
	<input type="text" name="bank_type" value="<?php print get_value($bank,"bank_type");?>"/>
	</div>
	<div class="field-set">
	<input type="submit" value="<?php echo ucfirst($action);?>" class="btn btn-warning btn-sm"/>
	</div>
	</div>
</form>
