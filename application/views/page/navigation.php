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
$main_menu = $this->menu_model->get(2);

?>
<ul class="nav_buttons menu">
	<li><a class='button home' href='<?=base_url();?>'>Home</a></li>
	<li><?=form_dropdown("search-month",$month_list,$default_month,"id='search-month'");?>
	</li>
	<li><input type="text" size="5" maxlength="4" id="search-year"
		name="search-year" value="<?=$default_year;?>" /></li>
	<li><span class="button expense-create"
		id="ec_<?=$this->session->userdata("userID");?>">New Expense</span></li>
		<? if($this->session->userdata("role") == "admin" ): ?>
	<li><a class="button" href="<?=site_url("fee/copy_month");?>">New Month</a>
	</li>

	<? endif; ?>
</ul>

<ul class="user_menu menu">
<? foreach($main_menu as $item){
	$button = create_button_object($item, $this->session->userdata("role"));
	if($button){
		eval("\$button = \"$button\";");
		echo "<li>$button</li>";
	}

}
?>

</ul>
