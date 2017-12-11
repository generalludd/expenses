<?php

$default_date = get_current_month();
$default_year = $default_date["year"];
$default_month = $default_date["month"];

if((int)$this->session->userdata("mo") && (int)$this->session->userdata("yr")){
	$default_year = $this->session->userdata("yr");
	$default_month = $this->session->userdata("mo");
}

$month_list = get_keyed_pairs($this->variable->get("month"),array("name","value"));

$nav_buttons["home"] = array("item" => "expense","text"=>"Home","href"=>base_url(), "class"=>"btn btn-primary home");
$nav_buttons["previous_month"] = array("item" =>"expense", "text"=>"Previous Month", "href"=>site_url("expense/previous_month/$default_month/$default_year"), "class" => "btn btn-primary show-previous-month" );
$nav_buttons["next_month"] = array("item" =>"expense", "text"=>"Next Month", "href"=>site_url("expense/next_month/$default_month/$default_year"), "class" => "btn btn-primary show-next-month" );
$nav_buttons["show_month"] = array("item" => "expense", "text" => "Select Month", "type"=>"span","class" => "btn btn-primary select-month");
 if($this->session->userdata("role") == "admin" ){
$nav_buttons["create_expense"] = array("item" => "expense", "text" => "New Expense", "type" =>"span", "class" => "btn btn-warning new expense create", "id"=>sprintf("ec_%s",$this->session->userdata("userID")));
$nav_buttons["copy_month"] = array("item" => "fee", "text" => "New Month", "href" => site_url("fee/copy_month"), "class"=>"btn btn-warning new new-month" );
$user_buttons["user_list"] = array("item" => "user", "text" => "User List", "href" => site_url("user/show_all"), "class" => "btn btn-primary show-user-list");
 }

 $user_buttons["preferences"] = array("item" => "preference", "text"=> "Preferences", "title"=>"Change Your Settings", "href"=>site_url("preference/view/" . $this->session->userdata("userID")),"class"=>"btn btn-primary show-preferences");
 $user_buttons["feedback"] = array("item" => "preference","text"=>"Feedback","class"=>"btn btn-primary create_feedback create-feedback","title"=>"Send Feedback for Improvements or Problems");
 $user_buttons["log_out"] = array("item" => "user","text"=>"Log Out","class"=>"btn btn-primary logout","href"=>site_url("user/logout"));

 ?>

 <?php echo create_button_bar($nav_buttons, array("id"=>"nav_buttons","class"=>"nav-buttons"));?>
 <?php echo create_button_bar($user_buttons, array("id"=>"user_menu","class"=>"user-menu"));?>
