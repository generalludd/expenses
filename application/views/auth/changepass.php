<?php #login_changepass.inc ?>
<div id="password_form">
<form id="password_editor" name="password_editor" action="<?php echo site_url("auth/change_password")?>" method="post" >
<input type="hidden" name="valid_password" id="valid_password" value=false/>
<input type="hidden" name="kTeach" id="kTeach" value="<?php echo $kTeach;?>"/>
<p><label for="current_password">Current Password: </label>
<input type="password" id="current_password" name="current_password" value=""/><br/>
<label for="new_password">New Password: </label>
<input type="password" id="new_password" name="new_password" value=""/><br/>
<label for="check_password">Re-enter New Password: </label>
<input type="password" id="check_password" name="check_password" value=""/>
</p>
<p><span id='password_note' class='notice' style="display:none"></span></p>

<p><span class='btn btn-sm btn-danger change_password'>Change Password</span></p>
</form>

</div>
