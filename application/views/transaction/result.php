<?php ?>
<h2><?php echo $title;?></h2>

<p>
	You have successfully uploaded <?php echo $transaction_count; ?> transactions.
</p>
<p>
	<a href="<?php echo base_url('transaction/view/?bank_id=' . $bank_id . '&start_date=' . $start_date . '&end_date=' . $end_date );?>" title="View transactions">View your transactions.</a>
</p>
