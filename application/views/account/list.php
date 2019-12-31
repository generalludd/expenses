<?php
$buttons['add'] = array("account" => "account","text"=>"Add an account","href"=>base_url('account/create'), "class"=>"btn btn-warning btn-sm dialog edit"); ?>

<h2><?php echo $title; ?></h2>
<?php echo create_button_bar($buttons);?>
<table class="chart-of-accounts">
	<thead>
	<tr>
		<th>Id</th>
		<th>Name</th>
		<th></th>
	</tr>
	</thead>
	<tbody>

<?php foreach($accounts as $account):?>
	<tr class="account" data-id="<?php echo $account->id;?>">
		<td class="account-id"><?php echo $account->id;?></td>
		<td class="account-name"><?php echo $account->name;?></td>
		<td><?php echo create_button(['text' =>'Edit','class'=>'btn btn-secondary btn-sm edit dialog', 'href'=>base_url('account/edit/' . $account->id)]);?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
