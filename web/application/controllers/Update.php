<?php

class Update extends My_Controller {


	function __construct() {
		parent::__construct();
		$this->load->model('Update_model', 'update');
	}

	function index() {
    $updates = [
			[
				'id' => 1,
				'query' => 'CREATE TABLE `month_status` (
  `mo` int(11) NOT NULL,
  `yr` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;',
				'description' => 'add a month_status table',
			],
      [
        'id' => 2,
        'query' => 'ALTER TABLE `month_status`
  ADD UNIQUE KEY `mo_yr` (`mo`,`yr`);',
        'description' => 'require unique month and year in table.'
      ]
		];
		$this->update->run_updates($updates);
		redirect('expense');
	}

}
