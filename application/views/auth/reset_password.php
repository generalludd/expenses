<?php #reset_password 
$output = "";
if($errors):
	if(is_array($errors)){
		foreach($errors as $msg){
			$output =  " -$msg<br/>\n";
		}
	}else{
		$output =  "$errors";
	}
endif;
?>
<div class="login resetter">
<div class="login-title">Password Reset</div>
<form id="password-resetter" name="password-resetter" action="<?php echo site_url("user/complete_reset")?>" method="post" >

<div id='password_note' class='notice error-text' style="display:none"><?php echo $output;?></div>
<input type="hidden" name="reset_hash" id="reset_hash" value="<?php echo $reset_hash;?>"/>
<input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
<div class="reset-fields">
<p><label for="new_password">New Password: </label><br/>
<input type="password" id="new_password" name="new_password" value=""/></p>
<p><label for="check_password">Re-enter New Password: </label><br/>
<input type="password" id="check_password" name="check_password" value=""/>
</p>
</div>
<p><input type="submit" name="submit" id="change-password" class="button" style="" value="Reset" /></p>

</form>
</div>
