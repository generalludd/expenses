<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// payment_model.php Chris Dart Mar 11, 2012 4:23:41 PM chrisdart@cerebratorium.com

class Payment_model extends MY_Model
{

	var $user_id;
	var $mo;
	var $yr;
	var $amt;
	var $date_paid;
	var $rec_modifier;
	var $rec_modified;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("user_id","mo","yr","amt","date_paid");
		prepare_variables($this, $variables);
		$this->rec_modified = mysql_timestamp();
		$this->rec_modifier = $this->session->userdata('userID');
		if($this->date_paid){
			$this->date_paid = format_date($this->date_paid, "mysql");
		}
	}


	function update($id)
	{

		$this->db->where("id", $id);
		$this->prepare_variables();
		$this->db->update("payment", $this);
		return $this->get($id);
	}

	function insert()
	{
		$this->prepare_variables();
		$this->db->insert("payment", $this);
		$id = $this->db->insert_id();
		return $id;
	}




	function get($id)
	{
		$this->db->where("id",$id);
		$this->db->from("payment");
		$result = $this->db->get()->row();
		return $result;
	}



	function get_by_month($mo,$yr)
	{

		$this->db->where("user.is_active", 1);
		$this->db->select("payment.*,user.id as userID, user.first_name");
		$this->db->join("user","user.id = payment.user_id  AND `payment`.`mo` = '$mo' AND `payment`.`yr` = '$yr'", "right");
		$this->db->from("payment");
		$this->db->order_by("userID");
		$this->db->order_by("date_paid");
		$query = $this->db->get();
		$result = $query->result();
		return $result;

	}

	function get_for_user($user_id, $param = array())
	{
		if(array_key_exists( "mo", $param)){
			$this->db->where("mo",$param["mo"]);
		}

		if(array_key_exists( "yr",$param)){
			$this->db->where("yr", $param["yr"]);
		}
		$this->db->where("user_id", $user_id);
		$this->db->order_by("mo","DESC");
		$this->db->order_by("yr","DESC");
		$this->db->from("payment");
		$result = $this->db->get()->row();
		return $result;
	}
}
