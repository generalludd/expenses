<?php #user/list.php
$status = NULL;
$role = NULL;
?>
<h3>List of Users</h3>
<p><span class="button user-create">Add User</span></p>
<table>
	<thead>
		<tr>
			<th></th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Username</th>
			<th>Email Address</th>
			<th>Role</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($users as $user):?>
		<tr>
			<td><span class="button user-edit" id="ue_<?=$user->id;?>">Edit</span></td>
			<td><?=$user->first_name;?></td>
			<td><?=$user->last_name; ?></td>
			<td><?=$user->username;?></td>
			<td><?=$user->email;?></td>
			<td><?=ucfirst($user->role);?></td>
			<td><?=get_status($user->is_active);?></td>
		</tr>
		<? endforeach; ?>
	</tbody>
</table>
