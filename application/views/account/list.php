<?php
$buttons['add'] = array("account" => "account","text"=>"Add an account","href"=>base_url('account/create'), "class"=>"btn btn-warning btn-sm dialog edit"); ?>

<h2><?php echo $title; ?></h2>
<?php echo create_button_bar($buttons);?>
<table class="chart-of-accounts table">
	<thead>
	<tr>
		<th>Id</th>
		<th>Name</th>
		<th></th>
	</tr>
	</thead>
	<tbody>

<?php foreach($accounts as $account):?>
<?php $is_child = $account->parent_id != $account->id;?>
	<tr class="account <?php echo $is_child?'child':'parent';?>" data-id="<?php echo $account->id;?>">
		<td class="account-id"><?php echo $account->id;?></td>
		<td class="account-name">
			<?php echo $is_child? $account->parent_name . ' - ' .  $account->name: $account->name;?></td>
		<td><?php echo create_button(['text' =>'Edit','class'=>'btn btn-secondary btn-sm edit dialog', 'href'=>base_url('account/edit/' . $account->id)]);?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
