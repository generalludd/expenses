<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// view.php Chris Dart Mar 11, 2012 5:55:17 PM chrisdart@cerebratorium.com
if(!empty($payments)):
	$this->load->view('payment/list',$payments);
else:?>
<td>Amount Due</td>
<td><a href="<?php echo base_url("/payment/create/?user_id=$current_id&total_due=$grand_total");?>" class="edit dialog" title="Add a payment">Add Payment</a></td>
</tr>
<?php endif;
