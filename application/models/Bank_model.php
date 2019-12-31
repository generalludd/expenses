<?php

class Bank_model extends MY_Model{
	var $id;
	var $bank;
	var $website;
	var $bank_type;
	var $field_map;

	function get_banks(){
		$this->db->from('bank');
		$this->db->order_by('bank');
		$this->db->select('*');
		$result = $this->db->get()->result();
		$list = get_keyed_pairs($result, ['id','bank'],TRUE,TRUE);
		return $list;
	}

	function get($id){
		$this->db->from('bank');
		$this->db->select('field_map');
		$this->db->where('id',$id);
		$json = $this->db->get()->row();
		$output = FALSE;
		if($json->field_map){
			$output = json_decode($json->field_map);
		}
		return $output;
	}

	function insert($values){
		$id = $this->db->insert('bank',$values);
		return $id;
	}

	function add_field_map($id, $field_map_json){
		$this->db->where('id', $id);
		$this->db->update('bank', ['field_map' => $field_map_json]);
	}
}
