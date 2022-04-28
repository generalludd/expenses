<?php ?>
<div id='fees' class='row'>
<?php $this->load->view("fee/list"); ?>
</div>
<?php
$expense_total = 0;
$current_id = 0;
?>
<div id='expenses' class='row'>

	<?php foreach($users as $user): ?>
<?php $this->load->view('expense/list', ['user' => $user, 'month'=>$month, 'year' => $year ]);?>
	<?php endforeach; ?>
</div>
