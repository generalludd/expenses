<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// view.php Chris Dart Mar 11, 2012 5:55:17 PM chrisdart@cerebratorium.com

if($payment != NULL): ?>
	<tr>
	<td>Amount Paid</td>
	<td class="amt"><a href='<?php echo base_url("/payment/edit/?id=$payment->id");?>' class='edit dialog payment-edit' id='pmt_<?php echo $payment->id . "_" . $grand_total;?>' title="Edit this payment">-<?php echo get_as_cash($payment->amt);?></a> </td>
	</tr>
	
<?php else:?>
<td>Amount Due</td>
<td><a href="<?php echo base_url("/payment/create/?user_id=$current_id&total_due=$grand_total");?>" class="edit dialog" title="Add a payment">Add Payment</a></td>
</tr>
<?php endif;
