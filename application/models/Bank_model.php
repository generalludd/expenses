<?php

class Bank_model extends MY_Model{
	var $id;
	var $bank;
	var $website;
	var $bank_type;

	function prepare_values(){
		$fields = ['bank','website','bank_type'];
		foreach($fields as $field){
			$data[$field] = $this->input->post($field);
		}
		return $data;
	}

	function get_banks($get_list = FALSE){
		$this->db->from('bank');
		$this->db->order_by('bank');
		$this->db->select('*');
		$result = $this->db->get()->result();
		if($get_list) {
			$list = get_keyed_pairs($result, ['id', 'bank'], TRUE, TRUE);
		}
		else {
			$list = $result;
		}
		return $result;
	}

	function get($id){
		$this->db->from('bank');
		$this->db->where('id',$id);
		return  $this->db->get()->row();
	}

	function insert(){
		$data = $this->prepare_values();
		$id = $this->db->insert('bank', $data);
		return $id;
	}

	function update($id){
		$data = $this->prepare_values();
		$this->db->where('id',$id);
		$this->db->update('bank',$data);
	}
}
