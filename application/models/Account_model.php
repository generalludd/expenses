<?php
/** chart of accounts */

class Account_model extends MY_Model {

	function get_accounts($get_as_list = FALSE){
		$this->db->from('account');
		$this->db->order_by('id');
		$this->db->select('id, concat(`id`,"-", `name`) as name');
		$list = $this->db->get()->result();
		if($get_as_list) {
			$result = get_keyed_pairs($list, ['id', 'id-name'], TRUE, TRUE);
		}
		else{
			$result = $list;
		}
		return $result;
	}
function get($id){
		$this->db->from('account');
		$this->db->where('id',$id);
		return $this->db->get()->row();
}

function update($id, $name){
		$this->db->update('account', [ 'name'=>$name],'id = '. $id);
}

	function insert($id, $name){
		$this->db->insert('account',['id'=>$id, 'name'=>$name]);
	}

}
