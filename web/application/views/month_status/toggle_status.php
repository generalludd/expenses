<?php

if(empty($month) || empty($year)){
  return;
}
if($is_locked === -1){
  return;
}

$toggle_text = $is_locked?'Unlock':'Lock';
$class = $is_locked?'locked':'unlocked';

  $button = [
    'item' => 'expense',
    'href' => base_url('expense/set_month_status'),
    'text' => $toggle_text,
    'title' =>  'Toggle the editing status for this month',
    'class' => 'btn btn-sm btn-danger  ajax inline ' . $class,
    'id' => 'toggle_month_status',
    'data_attributes' => [
      'month' => $month,
      'year' => $year,
      'status' => $is_locked?0:1,
    ],
  ];

print create_button($button);