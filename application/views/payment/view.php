<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// view.php Chris Dart Mar 11, 2012 5:55:17 PM chrisdart@cerebratorium.com

if($payment): ?>
	<tr>
	<td>Amount Paid</td>
	<td class="amt"><a href='#' class='payment-edit' id='pmt_<?=$payment->id . "_" . $grand_total;?>'>-<?=get_as_cash($payment->amt);?></a> </td>
	</tr>
	
<? else:?>
<tr>
<td>Amount Due</td>
<td><a href="#" class="payment-create" id="pmt_<?=$payment_key;?>" title="add a payment">Add Payment</a></td>
</tr>


<? endif; ?>