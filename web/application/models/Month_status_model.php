<?php

class Month_status_model extends CI_Model {

  var string $table_name = 'month_status';


  public function __construct() {
    if ($this->db->table_exists($this->table_name) && $this->db->from($this->table_name)->get()->num_rows() === 0) {
      $data = [];
      for ($yr = 2018; $yr < 2024; $yr++) {
        for ($mo = 1; $mo < 13; $mo++) {
          $data[] = [
            'mo' => $mo,
            'yr' => $yr,
            'status' => 1,
          ];
        }
      }
      $this->db->insert_batch($this->table_name, $data);
    }
    parent::__construct();
  }


  function get_status(int $month, int $year): bool {
    $result = $this->db->from($this->table_name)
      ->where('mo', $month)
      ->where('yr', $year)
      ->get()
      ->row();
    if ($result) {
      return $result->status;
    }
    else {
      return 0;
    }
  }

  function set_status(int $month, int $year, bool $status): void {
    $this->db->replace($this->table_name, ['mo'=>$month, 'yr'=>$year, 'status'=>$status]);

  }

}