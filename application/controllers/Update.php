<?php

class Update extends My_Controller {


	function __construct() {
		parent::__construct();
		$this->load->model('Update_model', 'update');
	}

	function index() {
		/*$updates = [
			[
				'id' => 1,
				'query' => 'CREATE TABLE `logging` CHANGE `id` `id` varchar(128) NOT NULL;',
				'description' => 'CI upgrade from 3.1.1 to 3.1.2',
			],
		];
		$this->update->run_updates($updates);*/
		redirect('home');
	}

}
