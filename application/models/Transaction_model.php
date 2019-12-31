<?php

class Transaction_model extends My_Model {

	var $id;

	var $date;

	var $vendor;

	var $amount;

	var $account_id;

	function insert($values = []){
		if($values){
			foreach($values as $key => $value){
				$this->{$key}= $value;
			}
		}
		$this->db->insert('transaction', $this);
	}

}
