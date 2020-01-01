<?php
/** chart of accounts */

class Account_model extends MY_Model {

	function get_accounts() {
		$this->db->from('account');
		$this->db->order_by('account.id');
		// get the parents if any by using the ACCOUNT_MODULO
		$this->db->join('account as parents', ' parents.id = FLOOR(account.id/' . ACCOUNT_MODULO . ') * ' . ACCOUNT_MODULO );
		$this->db->select('account.id, account.name, account.description, FLOOR(account.id/' . ACCOUNT_MODULO . ') * ' . ACCOUNT_MODULO . ' as parent_id, parents.name as parent_name');
		$result = $this->db->get()->result();
		return $result;
	}

	function get($id) {
		$this->db->from('account');
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}

	function update($id, $name) {
		$this->db->update('account', ['name' => $name], 'id = ' . $id);
	}

	function insert($id, $name) {
		$this->db->insert('account', ['id' => $id, 'name' => $name]);
	}

}
