<?php
$share_total = $user_count * 130;
?>
<!-- fee/list -->
<!-- <?php echo $month_count; ?> -->
<div id="monthly-fees" class='block border'>
    <h3>Monthly Fees for <?php echo "$month $year"; ?></h3>
    <p><a class="btn btn-warning btn-sm dialog edit"
          href="<?php echo site_url("fee/create"); ?>">New Fee</a></p>
    <table class="list table">
        <thead>
        <tr>
            <th></th>
            <th id="fee-type">Type</th>
            <th id="fee-amount">Amount</th>
            <th id="fee-amount-due">Amount Due</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach ($fees  as $fee): ?>
        <tr data-id="<?php echo $fee->id;?>">
            <td><a class='btn btn-secondary btn-sm edit dialog'
                   href='<?php echo site_url("fee/edit/$fee->id"); ?>'>Edit</a>
                <a href="<?php echo base_url("fee/delete");?>" data-id="<?php echo $fee->id;?>" data-parent="tr" class="button btn-sm btn delete ajax">Delete</a>

            </td>
            <td><?php echo $fee->type; ?></td>
            <td class='amt'><?php echo get_as_cash($fee->amt); ?> </td>
            <td class='amt'><?php echo get_as_cash($fee->amt / $user_count); ?> </td>
        <tr>
            <?php if ($fee->type == "Shopping"): endif; ?>

            <?php endforeach;
            ?>
        <tr class="bottom-line">
            <td></td>
            <td>Total:</td>
            <td class="amt"><?php echo get_as_cash($fee_total); ?></td>
            <td class="amt"><?php echo get_as_cash($fee_total / $user_count); ?>
        </tr>

        </tbody>
    </table>
</div>
<div id="budget" class="block border">
    <h3>Budget Summary</h3>
    <table class="list table">
        <thead>
        <tr>
            <th>Budget</th>
            <th>Actual</th>
            <th>Diff</th>
            <th>Percent</th>
        </tr>
        </thead>
        <tr>
            <td>Current Month</td>
        </tr>
        <tr>
            <td><?php echo get_as_cash ($share_total);?></td>
            <td><?php echo get_as_cash($expense_total); ?></td>
            <td><?php echo get_as_cash($expense_total - $share_total); ?></td>
            <td><?php echo round(($expense_total - $share_total) / $share_total * 100, 2); ?>%
            </td>
        </tr>
        <tr>
            <td colspan="4">
                Year-to-Date
            </td>
        </tr>
        <tr>
            <?php $ytd_budget = $share_total * $month_count ?>
            <td><?php echo get_as_cash($ytd_budget); ?></td>
            <td><?php echo get_as_cash($ytd_expense_total); ?></td>
            <td><?php echo get_as_cash($ytd_budget - $ytd_expense_total); ?></td>
            <td><?php echo round(($ytd_expense_total - $ytd_budget) / $ytd_budget * 100, 2); ?>
                %
            </td>
        </tr>
    </table>

</div>

<!-- end fee/list.php -->