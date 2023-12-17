<?php
$fee_total = 0;
$create_button = [
  'item' => 'fee',
  'href' => base_url('fee/create?month=' . $month . '&year=' . $year),
  'text' => '<i class="fas fa-plus-circle"></i>',
  'title' => 'Edit This Fee',
  'class' => 'btn btn-sm btn-warning edit dialog',
];
$previous_button = [
  "item" => "expense",
  "text" => '<i class="fas fa-arrow-left"></i>',
  "href" => site_url("expense/previous_month/$month/$year"),
  "class" => "btn btn-sm btn-secondary show-previous-month",
  'title' => 'Previous Month',
  'enclosure' => [
    'type' => 'span',
  ],
];
$next_button = [
  'item' => 'expense',
  'text' => '<i class="fas fa-arrow-right"></i>',
  'href' => site_url('expense/next_month/'. $month . '/'. $year),
  'class' => 'btn btn-sm btn-secondary show-next-month',
  'title' => 'Next Month',
  'enclosure' => [
    'type' => 'span',
  ],
];
?>
<!-- fee/list -->
<div id="monthly-fees" class='block border'>
    <h3><?php print create_button($previous_button); ?>Fees
        for <?php print format_month($month, $year) ?>

      <?php print  create_button($next_button); ?></h3>

    <p><?php print $is_locked !== 1? create_button($create_button):NULL; ?></p>
    <table class="list table table-sm">
        <thead>
        <tr>
            <th></th>
            <th id="fee-type">Type</th>
            <th id="fee-amount">Amount</th>
            <th id="fee-amount-due">Amount Due</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($fees as $fee): ?>
        <?php if($is_locked !== 1):?>
          <?php
          $edit_button = [
            'item' => 'fee',
            'href' => base_url("fee/edit/$fee->id"),
            'text' => '<i class="fas fa-edit"></i>',
            'title' => 'Edit This Fee',
            'class' => 'btn btn-sm btn-secondary edit dialog',
          ];

          $delete_button = [
            'item' => 'payment',
            'href' => base_url("fee/delete"),
            'text' => '<i class="far fa-trash-alt"></i>',
            'title' => 'Delete this fee',
            'class' => 'btn btn-sm btn-danger delete inline',
            'data_attributes' => [
              'field' => 'id',
              'id' => $fee->id,
              'target' => '#monthly-fees',

            ],

          ]; ?>
        <?php endif; ?>
            <tr data-id="<?php echo $fee->id; ?>">
                <td><?php echo !empty($edit_button)?  create_button($edit_button):''; ?>
                </td>
                <td><?php echo $fee->type; ?></td>
                <td class="amt"
                    data-value="<?php echo $fee->amt; ?>"><?php echo get_as_cash($fee->amt); ?> </td>
                <td
                        class="amt" data-value
                "<?php echo $fee->amt / $user_count; ?>
                "><?php echo get_as_cash($fee->amt / $user_count); ?> </td>
                <td>
                  <?php print !empty($delete_button)? create_button($delete_button):''; ?>
                </td>
            </tr>
          <?php $fee_total += $fee->amt; ?>
        <?php endforeach; ?>
        <tr class="bottom-line">
            <td></td>
            <td>Total:</td>
            <td class="amt"><?php echo get_as_cash($fee_total); ?></td>
            <td class="amt"><?php echo get_as_cash($fee_total / $user_count); ?>
            <td></td>
        </tr>

        </tbody>
    </table>
</div>

<!-- end fee/list.php -->
