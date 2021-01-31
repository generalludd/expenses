<?php
?>

<form action="<?php echo base_url('account/' . $action);?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<div class="inline-fields">
		<div class="field-set">
	<label for="id">Account ID</label>
	<input type="number" name="id" id="id" value="<?php echo get_value($account, 'id');?>"/>
		</div>
		<div class="field-set">
	<label for="name">Name</label>
	<input type="text" name="name" id="name" value="<?php echo get_value($account, 'name');?>">
		</div>
		<div>
			<label for="description">Description</label>
			<textarea name="description" id="description" class="width-full"><?php echo get_value($account, 'description');?></textarea>
		</div>
	<input type="submit"  class="btn btn-warning" value="<?php echo ucfirst($action);?>">
	</div>
</form>
