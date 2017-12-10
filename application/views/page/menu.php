<?php 
$userID = $this->session->userdata("userID");
$main_menu = $this->menu_model->get(1);
?>
<div class='button-box'>

<ul>
<?php foreach($main_menu as $item){
	echo "<li>" . create_button_object($item) . "</li>";
}
if($this->uri->segment(2) == "search"): ?>
<li><a class='button' href="<?php echo site_url("asset/export");?>">Export</a></li>
<?php endif; ?>

</ul>
</div>