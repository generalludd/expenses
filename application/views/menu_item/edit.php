<?php defined('BASEPATH') OR exit('No direct script access allowed');

?>

<form name="menu_item_editor" id="menu_item_editor" action="<?=site_url("menu/$action");?>" method="post">
<input type="hidden" name="kItem" id="kItem" value="<?=get_value($item,"kItem");?>"/>
<p>
<label for="kMenu">Parent Menu: </label>
<?=form_dropdown("kMenu",$menus,get_value($item,"kMenu"),"id='kMenu'");?>
</p>
<p>
<label for="text">Label: </label><br/>
<input type="text" name="label" id="label" value="<?=get_value($item, "label");?>"/>
</p>
<p>
<label for="type">Type: </label>
<?=form_dropdown("type",array("a"=>"a","span"=>"span","passthrough"=>"passthrough"),get_value($item,"type"),"id='type'");?>
</p>
<p>
<label for="user_role">User Role</label>
<?=form_dropdown("user_role",array("all"=>"all","admin"=>"admin","user"=>"user"),get_value($item,"user_role"));?>
</p>
<p id="href_field">
<label for="href">Link: </label>
<input type="text" name="href" id="href" value="<?=get_value($item, "href");?>"/>
<p>
<label for="class">Class: </label>
<input type="text" name="class" id="class" value="<?=get_value($item, "class","button");?>"/>
</p>
<p>
<label for="id">ID: </label>
<input type="text" name="id" id="id" value="<?=get_value($item, "id");?>"/>
</p>
<p>
<label for="id">ID Prefix: </label>
<input type="text" name="id_prefix" id="id_prefix" value="<?=get_value($item, "id_prefix");?>"/>
</p>
<p>
<label for="enclosure">Enclosure: </label>
<input type="text" name="enclosure" id="enclosure" value="<?=get_value($item, "enclosure");?>"/>
</p>
<p>
<label for="rank">Rank: </label>
<input type="text" name="rank" id="rank" value="<?=get_value($item, "rank");?>"/>
</p>
<p>
<input type="submit" class="button" value="Save"/>
</form>