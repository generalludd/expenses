<?php #fees/list.php
$share_total = 0;
?>
<div id="monthly-fees">
<h3>Monthly Fees for <?="$month $year";?></h3>
<p><span class="button new fee-create">New Fee</span></p>
<table class="list"><thead><tr>
<th></th><th id="fee-type">Type</th><th id="fee-amount">Amount</th><th id="fee-amount-due">Amount Due</th></tr></thead><tbody>
<?
foreach($fees as $fee){
	echo "<tr><td><span class='button fee-edit' id='fee-edit_$fee->id'>Edit</span></td>";
	echo "<td>$fee->type</td><td class='amt'>". get_as_cash($fee->amt) ."</td>";
	echo "<td class='amt'>" . get_as_cash($fee->amt/$user_count) . "</td><tr>";
	if($fee->type == "Shopping"){
		$share_total = $fee->amt;
	}

}
?>
<tr class="bottom-line"><td></td><td>Total:</td><td class="amt"><?=get_as_cash($fee_total);?></td>
<td class="amt"><?=get_as_cash($fee_total/$user_count);?></tr>

</tbody>
</table>
</div>
<div id="budget">
<h3>Budget Summary</h3>
<table class="list">
<?
$difference = $share_total - $expense_total;
if($difference > 0){
    $difference_label = "Amount Under Budget";
    $difference_class = "";
}else{
    $difference_label = "Amount Over Budget";
    $difference_class = "over-budget";
}



?>
<tr class="<?=$difference_class;?>">
<td>Total Expenses:</td><td class="amt"><?=get_as_cash($expense_total);?></td>
</tr>


<tr class="<?=$difference_class;?>">
<td><?=$difference_label;?></td>
<td class="amt <?=$difference_class;?>"><?=get_as_cash(abs($difference));?></td>
</tr>
<?
$grand_total_difference = $global_fee_total - $global_expense_total;
if($grand_total_difference > 0){
    $grand_label = "Amount Under Budget";
    $difference_class = "";
}else{
    $grand_label = "Amount Over Budget";
    $difference_class = "over-budget";
}
?>
<tr>

<td>Grand Total Fees</td>
<td class="amt"><?=get_as_cash($global_fee_total);?></td>

</tr>

<tr>
<td>Grand Total Expenses</td>
<td class="amt"><?=get_as_cash($global_expense_total);?></td>
</tr>
<tr class="<?=$difference_class;?>">

<td><?=$grand_label;?></td>
<td class="amt <?=$difference_class;?>"><?=get_as_cash($grand_total_difference);?></td>
</tr>
<?

$average =$global_fee_total/$month_count - $global_expense_total/$month_count;
if($average > 0){
    $average_label = "Amount Under Budget";
    $difference_class = "";
}else{
    $average_label = "Amount Over Budget";
    $difference_class = "over-budget";
}
?>
<tr class="<?=$difference_class;?>">

<td>Average over <?=$month_count;?> Months</td>
<td class="amt <?=$difference_class;?>"><?=get_as_cash($average);?></td>
</tr>
</table>
</div>

