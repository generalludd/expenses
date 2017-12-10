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
	<?php foreach($users as $user):?>
		<tr>
			<td><span class="button user-edit" id="ue_<?php echo $user->id;?>">Edit</span></td>
			<td><?php echo $user->first_name;?></td>
			<td><?php echo $user->last_name; ?></td>
			<td><?php echo $user->username;?></td>
			<td><?php echo $user->email;?></td>
			<td><?php echo ucfirst($user->role);?></td>
			<td><?php echo get_status($user->is_active);?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
