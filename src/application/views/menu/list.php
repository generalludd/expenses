<?php defined('BASEPATH') OR exit('No direct script access allowed');
$userID = $this->session->userdata("userID");?>
<div class='button-bar'><span class='button new menu_item_add'>Add Menu Item</span></div>
<?php $current_menu = "";?>
<?php foreach($menus as $menu):?>

<?php	if($current_menu != $menu->kMenu):?>
		<?php $current_menu = $menu->kMenu; ?>
		<h3>Menu: <?php print $menu->name;?></h3>
<?php endif; ?>
<div class='button-bar'><ul class='menu'>
	<?php $button =  create_button_object($menu,$userID);?>
	<li><?php print $button;?></li>
	<li><a class="button edit" href="<?php print base_url('/menu/edit_item/' . $menu->kItem);?>" id='mie_$menu->kItem'>Edit</a></li>
		</ul></div>
<?php endforeach;
