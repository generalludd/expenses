<?php #fees/list.php
$share_total = 0;
?>
<div id="monthly-fees" class='block border'>
    <h3>Monthly Fees for <?php echo "$month $year";?></h3>
    <p><span class="btn btn-warning btn-sm new fee-create">New Fee</span></p>
    <table class="list table"><thead><tr>
            <th></th><th id="fee-type">Type</th><th id="fee-amount">Amount</th><th id="fee-amount-due">Amount Due</th></tr></thead><tbody>
        <?php
        foreach($fees as $fee){
            echo "<tr><td><span class='btn btn-secondary btn-sm fee-edit' id='fee-edit_$fee->id'>Edit</span></td>";
            echo "<td>$fee->type</td><td class='amt'>". get_as_cash($fee->amt) ."</td>";
            echo "<td class='amt'>" . get_as_cash($fee->amt/$user_count) . "</td><tr>";
            if($fee->type == "Shopping"){
                $share_total = $fee->amt;
            }

        }
        ?>
        <tr class="bottom-line"><td></td><td>Total:</td><td class="amt"><?php echo get_as_cash($fee_total);?></td>
            <td class="amt"><?php echo get_as_cash($fee_total/$user_count);?></tr>

        </tbody>
    </table>
</div>
<div id="budget" class="block border">
    <h3>Budget Summary</h3>
    <table class="list table">
        <?php
        $difference = $share_total - $expense_total;
        if($difference >= 0){
            $difference_label = "Amount Under Budget";
            $difference_class = "";
        }else{
            $difference_label = "Amount Over Budget";
            $difference_class = "over-budget";
        }



        ?>
        <tr class="<?php echo $difference_class;?>">
            <td>Total Expenses:</td><td class="amt"><?php echo get_as_cash($expense_total);?></td>
        </tr>


        <tr class="<?php echo $difference_class;?>">
            <td><?php echo $difference_label;?></td>
            <td class="amt <?php echo $difference_class;?>"><?php echo get_as_cash(abs($difference));?></td>
        </tr>
        <?php
        $ytd_total_difference = $ytd_fee_total - $ytd_expense_total;
        if($ytd_total_difference <= 0){
            $ytd_label = "YTD Amount Under Budget";
            $difference_class = "";
        }else{
            $ytd_label = "YTD Amount Over Budget";
            $difference_class = "over-budget";
        }
        ?>

        <tr class="<?php echo $difference_class;?>">

            <td><?php echo $ytd_label;?></td>
            <td class="amt <?php echo $difference_class;?>"><?php echo get_as_cash($ytd_total_difference);?></td>
        </tr>
        <?php
        $average =$ytd_expense_total/$month_count;
        if($average >= 0){
            $average_label = "Amount Under Budget";
            $difference_class = "";
        }else{
            $average_label = "Amount Over Budget";
            $difference_class = "over-budget";
        }
        ?>
        <tr class="<?php echo $difference_class;?>">

            <td>YTD Monthly Average</td>
            <td class="amt <?php echo $difference_class;?>"><?php echo get_as_cash($average);?></td>
        </tr>

        <td class="amt"><?php //echo get_as_cash($grand_fee_total);?></td>


        <td class="amt"><?php //echo get_as_cash($grand_expense_total);?></td>

    </table>
    <table class="list">
        <thead>
        <tr>
            <th>Budget</th>
            <th>Actual</th>
            <th>Diff</th>
            <th>Percent</th>
        </tr>
        </thead>
        <tr><td>Current Month</td></tr>
        <tr>
            <td>$650.00</td>
            <td><?php echo get_as_cash($expense_total); ?></td>
            <td><?php echo get_as_cash($expense_total - 650);?></td>
            <td><?php echo round(($expense_total-650)/650*100,2); ?>%</td>
        </tr>
        <tr>
            <td colspan="4">
                Year-to-Date
            </td>
        </tr>
        <tr>
            <?php $ytd_budget = 650* $month_count?>
            <td><?php echo get_as_cash($ytd_budget);?></td>
            <td><?php echo get_as_cash($ytd_expense_total);?></td>
            <td><?php echo get_as_cash($ytd_budget - $ytd_expense_total);?></td>
            <td><?php echo round(($ytd_expense_total - $ytd_budget)/$ytd_budget*100,2);?>%</td>
        </tr>
    </table>

</div>

<!-- end fee/list.php -->