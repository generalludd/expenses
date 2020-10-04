<?php
$adjustments = 0;
$grand_total = $fee_total - $expense_total; ?>

<?php foreach ($payments as $payment): ?>
    <tr id="payment-id-<?php echo $payment->fee_id; ?>-<?php echo $userID; ?>" class="payment-row">
      <?php $clipboard_target = sprintf('#payment-id-%s-%s .amt', $payment->fee_id, $userID);?>
      <?php if ($is_admin || $is_me):
        $nav_button = [
          "item" => "payment",
          "text" => "<i class=\"fas fa-file-invoice-dollar\"></i>",
          "title" => "Pay this amount",
          "href" => site_url("payment/pay/"),
          "class" => "btn btn-sm btn-warning inline ajax edit copy",
          'data_attributes' => [
            'target' => '#payment-totals-' . $userID,
            'field_name' => 'fee_id',
            'value' => $payment->fee_id,
            'user_id' => $userID,
            'clipboard-target' =>$clipboard_target,
          ],
        ];
        $delete_button = [
          'item' => 'payment',
          'href' => base_url('payment/delete'),
          'text' => '<i class="far fa-trash-alt"></i>',
          'title' => 'Delete this payment',
          'class' => 'btn btn-sm btn-danger delete ajax inline',
          'data_attributes' => [
            'target' => '#payment-totals-' . $userID,
            'id' => $payment->payment_id,
          ],

        ];
      endif; ?>
        <td><?php echo $payment->type; ?></td>
        <td><?php echo get_value($payment, 'date_paid') ? format_date($payment->date_paid) : ''; ?></td>
        <td class="amt copy"
            data-toggle="popover"
            data-placement="top"
            data-clipboard-target="<?php print $clipboard_target; ?>"
            data-clipboard-text="<?php echo round($payment->amt,2); ?>">
            -<?php echo get_as_cash($payment->amt); ?>
          <?php if (get_value($payment, 'date_paid')): ?>
            <?php $adjustments += $payment->amt; ?>
            <?php echo create_button($delete_button); ?>
          <?php else: ?>
            <?php echo create_button($nav_button); ?>
          <?php endif; ?>
        </td>
    </tr>

<?php endforeach; ?>
<tr class="total-line">
    <td>Adjustments:</td>
    <td colspan="3" class="amt">-<?php echo get_as_cash($adjustments); ?></td>
</tr>
<tr class="bottom-line">
    <td>Amount Owed:</td>
    <td class="amt"
        colspan="3"><?php echo get_as_cash($grand_total - $adjustments); ?></td>
</tr>
