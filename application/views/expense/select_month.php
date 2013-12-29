<?php defined('BASEPATH') OR exit('No direct script access allowed');

// select_month.php Chris Dart Dec 29, 2013 5:04:43 PM chrisdart@cerebratorium.com
$buttons[] = array("item"=>"expense", "text"=>"Go", "type"=>"span", "class"=>"button go-to-month");
$buttons[] = array("item" => "expense", "text" => "Current Month", "type" => "span", "class" => "button show-current-month");

?>
<div id="month-selector">
<?=form_dropdown("search-month",$month_list,$default_month,"id='search-month'");?>
&nbsp;<input type="text" size="5" maxlength="4" id="search-year"
		name="search-year" value="<?=$default_year;?>" />
		<?=create_button_bar($buttons);?>
		</div>