<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// view.php Chris Dart Mar 11, 2012 5:55:17 PM chrisdart@cerebratorium.com

if($payment): ?>
	<tr>
	<td>Amount Paid</td>
	<td class="amt"><a href='<?php echo base_url("/payment/create/?id=$payment->id");?>' class='payment-edit' id='pmt_<?php echo $payment->id . "_" . $grand_total;?>'>-<?php echo get_as_cash($payment->amt);?></a> </td>
	</tr>
	
<?php else:?>
<tr>
<td>Amount Due</td>

<td><a href="<?php echo base_url("/payment/create/?user_id=$current_id&total_due=$grand_total");?>" class="edit dialog" title="add a payment">Add Payment</a></td>
</tr>


<?php endif; ?>