<?php
/** chart of accounts */

class Account_model extends MY_Model {

	function get_accounts() {
		$this->db->from('account');
		$this->db->order_by('account.id');
		// get the parents if any by using the ACCOUNT_MODULO
		$this->db->join('account as parents', ' parents.id = FLOOR(account.id/' . ACCOUNT_MODULO . ') * ' . ACCOUNT_MODULO);
		$this->db->select('account.id, account.name, account.description, account.is_default, FLOOR(account.id/' . ACCOUNT_MODULO . ') * ' . ACCOUNT_MODULO . ' as parent_id, parents.name as parent_name');
		$result = $this->db->get()->result();
		return $result;
	}

	function get($id) {
		$this->db->from('account');
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}

	function update($id, $name, $description, $is_default) {
		if($is_default == 1){
			$this->reset_default();
		}
		$this->db->set( ['name' => $name,'description'=>$description,'is_default'=>$is_default]);
		$this->db->where( 'id', $id);
		$this->db->update('account');

	}

	function insert( $values) {
		if(!empty($values['is_default'] && $values['is_default'] == 1)){
			$this->reset_default();
		}
		$this->db->insert('account',$values);
	}

	function get_category_totals(array $options) {
		$this->db->from('transaction');
		$this->db->join('account', 'transaction.account_id= account.id');
		$this->db->select('SUM(transaction.amount) as total');
		$this->db->select('account.id, account.name');
		if (array_key_exists('date_range', $options) && is_array($options['date_range'])) {
			$date_range = $options['date_range'];
			if (array_key_exists('start', $date_range)) {
				$this->db->where('date  >=', $date_range['start']);
			}
			if (array_key_exists('end', $date_range)) {
				$this->db->where('date <=', $date_range['end']);
			}
		}
		if (array_key_exists('account_range', $options) && is_array($options['account_range'])) {
			$account_range = $options['account_range'];
			if (array_key_exists('start', $account_range)) {
				$this->db->where('account_id >=', $account_range['start']);
			}
			if (array_key_exists('end', $account_range)) {
				$this->db->where('account_id <=', $account_range['end']);
			}
		}
		elseif(array_key_exists('accounts',$options)){
			$this->db->where_in('account_id',$options['accounts']);
		}
		$this->db->group_by('account_id');
		$result =  $this->db->get()->result();
		return $result;
	}

	function reset_default() {
		$this->db->set(['is_default'=>0]);
		$this->db->update('account');

	}

	function get_default(){
		$this->db->from('account');
		$this->db->where('is_default',1);
		$result = $this->db->get()->row();
		return $result->id;
	}

}
