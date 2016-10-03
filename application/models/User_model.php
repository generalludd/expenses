<?php


class User_model extends CI_Model
{

	var $username;
	var $first_name;
	var $last_name;
	var $email;
	var $is_active;
	var $role;
	var $start_date;
	var $end_date;

	function __construct()
	{
		parent::__construct();
	}


	function prepare_variables()
	{
		$variables = array("username","first_name","last_name","email","is_active","role","start_date","end_date");
		prepare_variables($this,$variables);
	}



	function get($id,$select = NULL)
	{
		if($select){
			$this->db->select($select);
		}
		$this->db->from('user');
		$this->db->where('id', $id);
		$result = $this->db->get()->row();
		return $result;
	}



	function get_all($include_inactive = FALSE)
	{

		if(!$include_inactive){
			$this->db->where("is_active",1);
		}
		$this->db->from("user");
		$this->db->order_by("is_active,role,username");
		$result = $this->db->get()->result();
		return $result;

	}


	function insert()
	{
		$this->prepare_variables();
		$this->db->insert("user", $this);
		$id = $this->db->insert_id();
	}


	function update($id)
	{

		$this->prepare_variables();
		$this->db->where("id", $id);
		$this->db->update("user", $this);

	}


	function is_user($username)
	{

		$this->db->where("username", $username);
		$this->db->from("user");
		$count = $this->db->get()->num_rows();
		$result = false;

		if($count == 1){
			$result = TRUE;
		}

		return $result;

	}


	function count_active($mo,$yr){
	$prev_mo =  $mo - 1;
		$prev_yr = $yr;
		if($prev_mo > 12){
			$prev_mo = 1;
			$prev_yr = $yr - 1;
		}
		$this->db->where("(user.start_date <= '$yr-$mo-01' AND (user.end_date IS NULL OR user.end_date > '$prev_yr-$prev_mo-31'))");
		
		//$this->db->where("end_date",NULL);
		$this->db->from("user");
		$result = $this->db->get()->num_rows();
		return $result;
	}

	function in_month($month,$year){
		$after = "$year-$month-" . last_day($month,$year);
		$before = "$year-" . ($month + 1) . "-01";
		$this->db->where("(end_date < '$before' OR end_date IS NULL) AND start_date > '$after'");
		$this->db->from("user");
		$result = $this->db->get()->result();
		return $result;
	}


	function validate($username, $password)
	{
		$this->db->where("username", $username);
		$this->db->where("password", $this->encrypt($password));
		$this->db->select("id, role");
		$this->db->from("user");
		$query = $this->db->get();
		$count = $query->num_rows();
		$output = FALSE;
		if($count == 1){
			$output = $query->row();
		}
		return $output;
	}



	function is_verified($id,$reset_hash)
	{
		$this->db->where("id",$id);
		$this->db->where("reset_hash",$reset_hash);
		$this->db->from("user");
		$query = $this->db->get();
		$output = FALSE;
		if($query->num_rows()==1){
			$output = TRUE;
		}
		return $output;
	}



	function initialize($user_info,$password)
	{
		$this->load->helper("string");
		$reset_hash = $this->encrypt(random_string("alnum",32));
		$this->db->where("username", $user_info);
		$this->db->or_where("email", $user_info);
		$data["reset_hash"] = $reset_hash;
		$data["is_verified"] = 0;
		$data["password"] = $this->encrypt($password);
		$this->db->update("user",$data);
		return $reset_hash;
	}



	function end_verify($id, $reset_hash){
		$this->db->where("id", $id);
		$this->db->where("reset_hash", $reset_hash);
		$data["is_verified"] = 1;
		$this->db->update("user",$data);
		return $this->is_verified($id, $reset_hash);
	}


	function get_id($user_info)
	{
		$this->db->where("username",$user_info);
		$this->db->or_where("email", $user_info);
		$this->db->select("id");
		$this->db->from("user");
		$result = $this->db->get()->row();
		return $result->id;

	}



	function get_role($id)
	{
		$this->db->where("id", $id);
		$this->db->select("role");
		$this->db->from("user");
		$result = $this->db->get()->row();
		return $result->role;
	}


	function set_role($id,$role)
	{
		$this->db->where("id", $id);
		$data["role"] = $role;
		$this->db->update("user", $data);
	}




	function change_password($id, $old, $new)
	{
		$result = FALSE;
		$username = $this->get_username($id);
		$is_valid = $this->validate($username, $old);

		if($is_valid){
			$this->db->where("username", $username);
			$this->db->where("password",$this->encrypt($old));
			$data["password"] = $this->encrypt($new);
			$this->db->update("user", $data);
			if($this->validate($username, $new)){
				$result = TRUE;
			}
		}
		return $result;
	}


	function encrypt($text)
	{
		return md5(md5($text));
	}
	
	function email_exists($email){
		$output = FALSE;
		$this->db->where("email",$email);
		$this->db->select("id");
		$this->db->from("user");
		$row = $this->db->get()->row();
		if(!empty($row)){
			$output = $row->id;
		}
		return $output;
	}

	function set_reset_hash($id)
	{
		$hash = $this->encrypt(now());
		$data["reset_hash"] = $hash;
		$this->db->where("id", $id);
		$this->db->update("user",$data);
		return $hash;
	}


	function reset_password($id, $reset_hash, $password)
	{
		$this->db->where("id", $id);
		$this->db->where("reset_hash", $reset_hash);
		$this->db->where("`reset_hash` IS NOT NULL");
		$data["password"] = $this->encrypt($password);
		$data["reset_hash"] = "";
		$this->db->update("user", $data);
		$username = $this->get($id,"username");
		return $this->validate($username->username, $password);
	}


}