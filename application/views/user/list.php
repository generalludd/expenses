<?php #user/list.php
$status = NULL;
$role = NULL;
?>
<h3>List of Users</h3>
<p><?php print create_button([
		'href' => base_url('user/create'),
		'class' => 'btn btn-sm btn-warning edit dialog',
		'text' => '<i class="fa fa-plus-circle"></i>',
		'title' => 'Add User',
	]); ?></p>
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
	<?php foreach ($users as $user): ?>
		<?php $edit_button = [
			'href' => base_url('user/edit/' . $user->id),
			'text' => '<i class="fas fa-edit"></i>',
			'class' => 'btn btn-sm btn-secondary dialog edit',
			'title' => 'Edit ' . $user->first_name,
		]; ?>
		<tr>
			<td><?php echo create_button($edit_button); ?></td>
			<td><?php echo $user->first_name; ?></td>
			<td><?php echo $user->last_name; ?></td>
			<td><?php echo $user->username; ?></td>
			<td><?php echo $user->email; ?></td>
			<td><?php echo ucfirst($user->role); ?></td>
			<td><?php echo get_status($user->is_active); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
