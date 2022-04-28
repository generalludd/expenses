<?php

class Preference_model extends CI_Model
{


	function __construct()
	{
		parent::__construct();
	}


	function get($user_id, $type)
	{
		$value = FALSE;
		$this->db->where('user_id', $user_id);
		$this->db->where('type', $type);
		$this->db->select('value');
		$this->db->from('preference');
		$result = $this->db->get()->row();

		if($result){
			$value = $result->value;
		}
			
		return $value;
	}

	function get_all($user_id)
	{
		$this->db->select("preference_type.*, preference.value,preference.user_id");
		$this->db->order_by("preference_type.sort_order");
		
		$this->db->from("preference_type");
		$this->db->join("preference", "preference_type.type=preference.type AND preference.user_id = $user_id", "left");
		$this->db->distinct("preference.type");
		$result = $this->db->get()->result();
		return $result;
	}

	function update($user_id, $type, $value)
	{
		$output = FALSE;
		$exists = $this->get($user_id, $type);
		if($exists){
			if(empty($value)){
				$output = $this->delete($user_id, $type);
			}else{
				$this->db->where("user_id", $user_id);
				$this->db->where("type", $type);
				$data["type"] = $type;
				$data["value"] = $value;
				$this->db->update("preference", $data);
				$verification = $this->get($user_id, $type);
				if($verification == $value){
					$output = TRUE;
				}
			}
		}else{
			$output = $this->insert($user_id, $type, $value);
		}
		return $output;

	}
	
	function get_users_for_type($type)
	{
		
		$this->db->select("user.id, user.first_name, user.last_name, user.email, preference.type");
		$this->db->where("user.id = preference.user_id");
		$this->db->where("user.is_active", 1);
		$this->db->where("preference.type", $type);
		$this->db->from("preference, user");
		$result = $this->db->get()->result();
		return $result; 
		
	}


	function insert($user_id, $type, $value)
	{
		$output = FALSE;
		$data["user_id"] = $user_id;
		$data["type"] = $type;
		$data["value"] = $value;
		$this->db->insert("preference", $data);
		$verification = $this->get($user_id, $type);
		if($verification == $value){
			$output = TRUE;
		}
		return $output;
	}

	function delete($user_id, $type)
	{
		$output = FALSE;
		$this->db->where("user_id", $user_id);
		$this->db->where("type", $type);
		$this->db->delete("preference");
		$exists = $this->get($user_id, $type);
		if(!$exists){
			$output = TRUE;
		}
		return $output;
	}


}