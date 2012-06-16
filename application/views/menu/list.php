<?php defined('BASEPATH') OR exit('No direct script access allowed');
$userID = $this->session->userdata("userID");
echo "<div class='button-bar'><span class='button new menu_item_add'>Add Menu Item</span></div>";
$current_menu = "";
foreach($menus as $menu){

	if($current_menu != $menu->kMenu){
		$current_menu = $menu->kMenu;
		
		echo "<h3>Menu: $menu->name</h3>";
	} //endif
echo "<div class='button-bar'><ul class='menu'>";
	$button =  create_button_object($menu,$userID);
	call_user_func('form_dropdown',eval("\$button = \"$button\";"));
	echo "<li>$button</li>";
	echo "<li><span class='button edit menu_item_edit' id='mie_$menu->kItem'>Edit</span></li>";
		echo "</ul></div>";
	

} //end foreach

