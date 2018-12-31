<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// edit.php Chris Dart Mar 11, 2012 5:32:35 PM chrisdart@cerebratorium.com


$default_month = date("n");
if($this->session->userdata("mo")){
	$default_month = $this->session->userdata("mo");
}
$default_year = date("Y");
if($this->session->userdata("yr")){
	$default_year = $this->session->userdata("yr");
}
?>

<form name="payment_editor" id="payment_editor" method="post" action="<?php echo site_url("payment/$action");?>">
<input type="hidden" id="id" name="id" value="<?php echo get_value($payment, "id");?>"/>

<?php if($this->session->userdata("role") == "admin"): ?>
<p>
<label for="user_id">User</label>
<?php echo form_dropdown("user_id",$users,get_value($payment,"user_id",$user_id),"id='user_id'");?>
</p>
<?php else: ?>
<input type="hidden" name="user_id" id="user_id" value="<?php echo get_value($payment,"user_id",$user_id);?>"/>
<?php endif; ?>
<p>
<label for="mo">Month</label>
<?php echo form_dropdown("mo",$months,get_value($payment,"mo",$default_month), "id='mo'");?>
<label for="yr">Year</label>
<input type="text" id="yr" name="yr" value="<?php echo get_value($payment, "yr",$default_year);?>"/>
<p>
<label for="amt">Amount Paid</label>
<input type="text" id="amt" name="amt" value="<?php echo round(get_value($payment, "amt", $total_due),2);?>"/>
</p>
<p>
<label for="date_paid">Date Paid</label>
<input type="text" id="date_paid" name="date_paid" value="<?php echo format_date(get_value($payment,"date_paid", date("Y-m-j")));?>" class="datefield"/>
</p>
<p>
<input type="submit" class="button" value="Save"/>
</p>
</form>
