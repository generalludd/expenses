<?php #user/edit.php
$status = "checked";
if(get_value($user,"is_active") == 0){
    $status = "";
} 

?>

<form id="user_editor" name="user_editor" method="post" action="<?=site_url("user/$action");?>">
<input type="hidden" name="id" id="id" value="<?=get_value($user,"id");?>"/>
<p>
<label for="first_name">First Name:</label><br/>
<input type="text" name="first_name" id="first_name" value="<?=get_value($user,"first_name");?>"/>
</p>

<p>
<label for="last_name">Last Name:</label><br/>
<input type="text" name="last_name" id="last_name" value="<?=get_value($user,"last_name");?>"/>
</p>

<p>
<label for="email">Email:</label><br/>
<input type="text" name="email" id="email" value="<?=get_value($user,"email");?>"/>
</p>

<p>
<label for="username">Username:</label><br/>
<input type="text" name="username" id="username" value="<?=get_value($user,"username");?>"/>
</p>
<p>
<label for="role">Role:</label><br/>
<?=form_dropdown("role",$roles,get_value($user,"role","user"),"id='role'");?>
</p>
<p>
<label for="is_active">Is User Active:</label><br/>
<input type="checkbox" id="is_active" name="is_active" value="1" <?=$status;?>/>
</p>
<p>
<input type="submit" class="button" value="<?=ucfirst($action);?>"/>
</p>
</form>