<?php
$person = $expense->first_name;
$class = "";
if($expense->userID == $this->session->userdata("userID")): $class="you"; endif;
?>
<div class='column <?=$class;?>'>
<? 
if($expense->userID == $this->session->userdata("userID")):?>
<h3>Your Expenses</h3>
<? else: ?>
<h3><?=$person;?></h3>
<? endif;



if($this->session->userdata("role") == "admin"|| $this->session->userdata("userID") == $expense->userID ):?>
<p><span class="button expense-create" id="ec_<?=$expense->userID;?>">New
Expense</span></p>
<? endif; 
?>
<table class="list">
	<thead>
		<tr>
			<th>Type</th>
			<th>Date</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>


	<? 
	$expense_total;
	foreach($expenses as $item):
	if($item->user_id == $current_id): ?>
		<tr>
			<td><span class='link expense-edit'
				id='expense-edit_<?=$item->id;?>' title='<?=$item->description;?>'><?=$item->type;?></span></td>
			<td><?=format_date($item->dt,"no-year");?></td>
			<td class='amt'><?=get_as_cash($item->amt);?></td>
			
			<?
			$expense_total += $item->amt; 
			?>
		</tr>

		<? endif;
		endforeach;?>
		      <tr class="bottom-line">
            <td></td>
            <td class="amt">Total:</td>
            <td class="amt"><?=get_as_cash($expense_total);?></td>
        </tr>
	</tbody>
</table>
		<?
		$display_expense = get_as_cash($expense_total);
		if(abs($expense_total) == $expense_total){
			$display_expense = "-" . get_as_cash($expense_total);

		}
		?>
<h5>Totals</h5>
<? 
$amt_paid = get_value($payment,"amt");
$grand_total = $fee_total/$user_count - $expense_total - $amt_paid;?>
<table class="list totals">
	<tr>
		<td>Amount Due:</td>
		<td class="amt"><?=get_as_cash($fee_total/$user_count);?></td>
	</tr>
	<tr>
		<td>Adjustment:</td>
		<td class="amt"><?=$display_expense;?></td>
	</tr>
	<?
	$payment_data["payment"] = $payment;
	$payment_data["payment_key"] = $grand_total . "_" . $month . "_" . $year . "_" . $current_id;
	$payment_data["grand_total"] = $grand_total;
	
	$this->load->view("payment/view",$payment_data);
	?>
	<tr class="bottom-line">
		<td>Amount Owed:</td>
		<td class="amt"><?=get_as_cash($grand_total);?></td>
	</tr>
	
</table>
</div>
