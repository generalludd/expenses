<?php
$person = $expense->first_name;
$class = "";
$is_me = $expense->userID == $this->session->userdata("userID")?TRUE:FALSE;
$is_admin = $this->session->userdata("role") == "admin"?TRUE:FALSE;
if($is_me){
    $class = "you";
}
?>
<div class='column block border <?php echo $class;?>'>
    <?php
    if($is_me):?>
        <h3>Your Expenses</h3>
    <?php else: ?>
        <h3><?php echo $person;?></h3>
    <?php endif;
    if($is_admin || $is_me ):
        $nav_buttons["create_expense"] = array("item" => "expense", "text" => "New Expense", "href"=>site_url("expense/create/" . $expense->userID), "class" => "btn btn-sm btn-warning edit dialog");
        print create_button_bar($nav_buttons);
    endif;
    ?>
    <table class="list table">
        <thead>
        <tr>
            <th>Type</th>
            <th>Date</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>


        <?php
        $expense_total;
        foreach($expenses as $item):
            if($item->user_id == $current_id): ?>
                <tr>
                    <td><a class=' expense dialog <?php echo $is_me || $is_admin?'edit':'';?>' href="<?php echo site_url("expense/edit/$item->id");?>"
                              title='<?php echo $item->description;?>'><?php echo $item->type;?></a></td>
                    <td><?php echo format_date($item->dt,"no-year");?></td>
                    <td class='amt'><?php echo get_as_cash($item->amt);?></td>

                    <?php
                    $expense_total += $item->amt;
                    ?>
                </tr>

            <?php endif;
        endforeach;?>
        <tr class="bottom-line">
            <td></td>
            <td class="amt">Total:</td>
            <td class="amt"><?php echo get_as_cash($expense_total);?></td>
        </tr>
        </tbody>
    </table>
    <?php
    $display_expense = get_as_cash($expense_total);
    if(abs($expense_total) == $expense_total){
        $display_expense = "-" . get_as_cash($expense_total);
    }
    ?>
    <h5>Totals</h5>
    <?php
    $amt_paid = get_value($payment,"amt");
    $grand_total = $fee_total/$user_count - $expense_total - $amt_paid;?>
    <table class="list totals table">
        <tr>
            <td>Amount Due:</td>
            <td class="amt"><?php echo get_as_cash($fee_total/$user_count);?></td>
        </tr>
        <tr>
            <td>Adjustment:</td>
            <td class="amt"><?php echo $display_expense;?></td>
        </tr>
        <?php
        $payment_data["payment"] = $payment;
        $payment_data["payment_key"] = $grand_total . "_" . $month . "_" . $year . "_" . $current_id;
        $payment_data["grand_total"] = $grand_total;

        $this->load->view("payment/view",$payment_data);
        ?>
        <tr class="bottom-line">
            <td>Amount Owed:</td>
            <td class="amt"><?php echo get_as_cash($grand_total);?></td>
        </tr>

    </table>
</div>
<!-- all done here /-->