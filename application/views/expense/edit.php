<?php
$default_month = date("n");
if($this->session->userdata("mo")){
	$default_month = $this->session->userdata("mo");
}
$default_year = date("Y");
if($this->session->userdata("yr")){
	$default_year = $this->session->userdata("yr");
}

?>
<form id="expense_editor" name="expense_editor" action="<?php echo site_url("expense/$action");?>" method="post">
<input type="hidden" name="id" id="id" value="<?php echo get_value($expense,"id");?>"/>
<input type="hidden" name="action" id="action" value="<?php echo $action;?>"/>
<?if($this->session->userdata("role") == "admin"): ?>
<label for="user_id">User</label>
<?php echo form_dropdown("user_id",$users,get_value($expense,"user_id",$user_id),"id='user_id'");?>
<? else: ?>
<input type="hidden" name="user_id" id="user_id" value="<?php echo get_value($expense,"user_id",$user_id);?>"/>
<? endif; ?>
<p>
<label for="mo">Month</label> 
<?php echo form_dropdown("mo",$months,get_value($expense,"mo",$default_month), "id='mo' required");?>
<label for="yr">Four-Digit Year</label> 
<input type="text" name="yr" id="yr" value="<?php echo get_value($expense,"yr",$default_year);?>" required size="5" maxlength="4"/>
</p>
<p><label for="dt">Date</label><input type="text" required name="dt" id="dt" value="<?php echo format_date(get_value($expense,"dt",date("Y-m-d")));?>" class="datefield"/></p>
<p>
<label for="type">Enter the Type of Fee:</label> 
<span id="type_span"><?php echo form_dropdown("type",$types,get_value($expense,"type"),"id='type' required");?></span>
</p>
<p>
<label for="description">Describe the Purchase</label> 
<input type="text" name="description" id="description" required value="<?php echo get_value($expense,"description");?>"/>
</p>
<p>
<label for="amt">Enter the Amount: $</label> 
<input type="text" name="amt" id="amt" value="<?php echo get_value($expense,"amt");?>" required size="6" maxlength="8"/>
</p>
<div class="button-box">
<input type="submit" value="<?php echo ucfirst($action);?>" class="button"/>
<? if($action == "update"): ?>
<span class="delete button expense-delete">Delete</span>
<? endif; ?>
</div>

</form>