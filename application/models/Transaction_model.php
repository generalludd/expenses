<?php

class Transaction_model extends My_Model {

	var $id;

	var $date;

	var $vendor;

	var $amount;

	var $account_id;

	function insert($values) {
		if (!$this->get_by_transaction_id($values['bank_id'], $values['transaction_id'])) {
			$this->db->insert('transaction', $values);
		}
	}

	function get($id){
		$this->db->from('transaction');
		$this->db->where('id', $id);
		$this->db->select('*');
		return $this->db->get()->row();
	}

	function get_by_transaction_id($bank_id, $transaction_id) {
		$this->db->from('transaction');
		$this->db->where('bank_id', $bank_id);
		$this->db->where('transaction_id', $transaction_id);
		$result = $this->db->get()->row();
		if ($result) {
			return $result;
		}
		else {
			return FALSE;
		}
	}

	/**
	 * @param array $options
	 *
	 * @return
	 */
	function get_all($options = []) {
		$this->db->from('transaction');
		if (array_key_exists('date_start', $options)) {
			$this->db->where('date >=', $options['date_start']);
		}
		if (array_key_exists('date_end', $options)) {
			$this->db->where('date <=', $options['date_end']);
		}
		if(array_key_exists('bank_id', $options)){
			$this->db->where('bank_id', $options['bank_id']);
		}
		$this->db->join('bank','transaction.bank_id = bank.id');
		$this->db->order_by('bank.bank','ASC');
		$this->db->order_by('date','ASC');
		$this->db->select('*');
		return $this->db->get()->result();
	}


	function update_value($id, $field, $value){
		$this->db->update($id, [$field=>$value]);
	}
}
