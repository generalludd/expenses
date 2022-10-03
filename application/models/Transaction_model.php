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
			$bank_ids = [$options['bank_id']];
		}
		if(array_key_exists('bank_ids', $options)){
			$bank_ids =  $options['bank_ids'];
		}
		if(!empty($bank_ids)){
			$this->db->where_in('bank_id',$bank_ids);
		}
		if(array_key_exists('account_ids', $options)){
			$this->db->where_in('account_id', $options['account_ids']);
		}
		if(array_key_exists('vendor',$options ) && !empty($options['vendor'])){
			$this->db->like('vendor',$options['vendor']);
		}
		$this->db->join('bank','transaction.bank_id = bank.id');
		if(array_key_exists('order_by',$options)){
			$this->db->order_by($options['order_by']->field,$options['order_by']->direction);
		}
		$this->db->order_by('bank.bank','ASC');
		$this->db->order_by('date','ASC');
		$this->db->select('transaction.*, bank.bank, bank.website');
		$result =  $this->db->get()->result();
		return $result;
	}

	function update_value($id, $field, $value){
		$this->db->where('id', $id);
		$this->db->update('transaction', [$field=>$value]);
	}

	function batch_update_account_ids($ids, $account_id){
		$this->db->where_in('id',$ids);
		$this->db->update('transaction', ['account_id'=>$account_id]);
	}
}
