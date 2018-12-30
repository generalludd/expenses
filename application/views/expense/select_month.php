<?php

defined('BASEPATH') or exit('No direct script access allowed');

// select_month.php Chris Dart Dec 29, 2013 5:04:43 PM
// chrisdart@cerebratorium.com
$buttons[] = array(
        "item" => "expense",
        "text" => "Go",
        "type" => "span",
        "class" => "button btn btn-sm btn-primary go-to-month"
);
$buttons[] = array(
        "item" => "expense",
        "text" => "Current Month",
        "type" => "span",
        "class" => "button btn btn-sm btn-primary show-current-month"
);

?>
<div id="month-selector">
	<p>
<?php echo form_dropdown("search-month",$month_list,$default_month,"id='search-month'");?>
&nbsp;<input
			type="text"
			size="5"
			maxlength="4"
			id="search-year"
			name="search-year"
			value="<?php echo $default_year;?>" />
	</p>
		<?php echo create_button_bar($buttons);?>
		</div>
