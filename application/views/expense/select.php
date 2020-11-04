<?php

defined('BASEPATH') or exit('No direct script access allowed');

// select_month.php Chris Dart Dec 29, 2013 5:04:43 PM
// chrisdart@cerebratorium.com
if(!empty($month_list) && !empty($default_month) && !empty($default_year)):
?>
<form id="select_month" name="select_month"
			action="<?php echo base_url('expense/select'); ?>" method="get">
	<p>
		<?php echo form_dropdown("month", $month_list, $default_month); ?>
		&nbsp;<input
			type="text"
			size="5"
			maxlength="4"
			name="year"
			value="<?php echo $default_year; ?>"/>
	</p>
	<p><input type="submit" class="btn btn-sm btn-secondary" value="Go"/>
		<?php print create_button([
			'item' => 'expense',
			'text' => 'Current Month',
			'class' => 'btn btn-sm btn-secondary',
			'href' => base_url(),
		]); ?>
	</p>
</form>
<?php endif;