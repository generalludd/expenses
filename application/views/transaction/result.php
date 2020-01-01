<?php ?>
<h2><?php echo $title;?></h2>

<p>
	You have successfully uploaded <?php echo $transaction_count; ?> transactions.
</p>
<p>
	<a href="<?php echo base_url('transaction/view/?bank_id=' . $bank_id . '&date_start=' . $date_start . '&date_end=' . $date_end );?>" title="View transactions">View your transactions.</a>
</p>
