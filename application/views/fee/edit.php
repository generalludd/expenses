<?php

?>

<form id="fee_editor" name="fee_editor" action="<?=site_url("fee/$action");?>" method="post">
<input type="hidden" name="id" id="id" value="<?=get_value($fee,"id");?>"/>
<p>
<label for="mo">Month</label> 
<?=form_dropdown("mo",$months,get_value($fee,"mo",date("m")), "id='mo' required");?>
<label for="yr">Four-Digit Year</label> 
<input type="text" name="yr" id="yr" required value="<?=get_value($fee,"yr",date("Y"));?>" size="5" maxlength="4"/>
</p>
<p>
<label for="type">Enter the Type of Fee:</label> 
<span id="type_span"><?=form_dropdown("type",$types,get_value($fee,"type"),"id='type' required");?></span>
</p>
<p>
<label for="amt">Enter the Amount: $</label> 
<input type="text" name="amt" id="amt" value="<?=get_value($fee,"amt","0.00");?>" required size="6" maxlength="8"/>
</p>
<p>
<input type="submit" value="<?=ucfirst($action);?>" class="button"/></p>

</form>