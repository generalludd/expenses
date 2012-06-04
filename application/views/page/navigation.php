<?php
$default_year = date("Y");
$default_month = date("n");
if(date("j") > 15){
	$default_month = $default_month + 1;
}
if((int)$this->session->userdata("mo") && (int)$this->session->userdata("yr")){
	$default_year = $this->session->userdata("yr");
	$default_month = $this->session->userdata("mo");
}

$month_list = get_keyed_pairs($this->variable->get("month"),array("name","value"));
?>

<ul class="nav_buttons">
	<li><a class='button home' href='<?=base_url();?>'>Home</a></li>
	<li><?=form_dropdown("search-month",$month_list,$default_month,"id='search-month'");?>
	</li>
	<li><input type="text" size="5" maxlength="4" id="search-year"
		name="search-year" value="<?=$default_year;?>" /></li>
	<li><span class="button expense-create"
		id="ec_<?=$this->session->userdata("userID");?>">New Expense</span></li>
		<? if($this->session->userdata("role") == "admin" ): ?>
	<li><a class="button" href="<?=site_url("fee/copy_month");?>">New Month</a></li>
	
			<? endif; ?>
</ul>

<ul class="user_menu">
<? if($this->session->userdata("role") == "admin" ): ?>
<li><a class="button user-list" href="<?=site_url("user/show_all");?>">User
			List</a></li>
				<? endif; ?>
	<li><a class="button" title="Change your settings"
		href="<?=site_url("preference/view/" . $this->session->userdata("userID"));?>">Preferences</a>
	</li>
	<li><span class="button create_feedback">Feedback</span></li>
	<li><a class="button" href='<?=site_url("user/logout");?>'>Log Out</a>
	</li>
</ul>

