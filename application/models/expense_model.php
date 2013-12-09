<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expense_model extends CI_Model
{

	var $user_id;
	var $type;
	var $amt;
	var $mo;
	var $yr;
	var $dt;
	var $description;

	function __construct()
	{

		parent::__construct();

	}


	function prepare_variables()
	{
		$variables = array("user_id","type","amt","mo","yr","description");
		prepare_variables($this, $variables);
		if($this->input->post("dt")){
			$this->dt = format_date($this->input->post("dt"),"mysql");
		}
	}


	function get($id)
	{
		$this->db->where("id", $id);
		$this->db->from("expense");
		$result = $this->db->get()->row();
		return $result;
	}



	function distinct($field){
		$this->db->select($field);
		$this->db->distinct();
		$this->db->from("expense");
		$result = $this->db->get()->result();
		return $result;
	}


	function get_all($user_id,$mo = NULL, $yr = NULL)
	{
		$this->db->where("user_id", $user_id);
		if(isset($mo)){
			$this->db->where("mo",$mo);
		}

		if(isset($yr)){
			$this->db->where("yr",$yr);

		}

		$this->db->order_by("yr","DESC");
		$this->db->order_by("mo","DESC");
		$this->db->order_by("dt","ASC");
		$this->db->from("expense");
		$result = $this->db->get()->result();
		return $result;

	}


	function get_by_month($mo,$yr, $type = NULL)
	{
		//$this->db->where("expense.mo", $mo);
		//$this->db->where("expense.yr", $yr);
		//$this->db->where("user.is_active", 1);
		$prev_mo =  $mo - 1;
		$prev_yr = $yr;
		if($prev_mo > 12){
			$prev_mo = 1;
			$prev_yr = $yr - 1;
		}
		$this->db->where("(user.start_date <= '$yr-$mo-01' AND (user.end_date IS NULL OR user.end_date > '$prev_yr-$prev_mo-31'))");
		if(isset($type)){
			$this->db->where("expense.type", $type);
		}
		$this->db->select("expense.*,user.id as userID, user.first_name");
		$this->db->join("user","user.id = expense.user_id  AND `expense`.`mo` = '$mo' AND `expense`.`yr` = '$yr'", "right");
		$this->db->from("expense");
		$this->db->order_by("userID");
		$this->db->order_by("dt");
		

		//SELECT * FROM (`expense`) RIGHT JOIN `user` ON `user`.`id` = `expense`.`user_id` AND `expense`.`mo` = '1' AND `expense`.`yr` = '2012' WHERE `user`.`is_active` = 1 ORDER BY `user_id`, `dt`		
		//SELECT * FROM (`expense`) RIGHT JOIN `user` ON `user`.`id` = `expense`.`user_id` AND `expense`.`mo` = '1' AND `expense`.`yr` = '2012' WHERE `user`.`is_active` = 1 
		$result = $this->db->get()->result();
		return $result;
	}
	
	
	function get_total($mo = NULL,$yr = NULL)
	{
		$this->db->select("sum(amt) as total");
		if($mo){
			$this->db->where("mo",$mo);
		}
		if($yr){
			$this->db->where("yr",$yr);
		}
		$this->db->where("type","Shopping");
		$this->db->from("expense");
		$result = $this->db->get()->row();
		return $result->total;
	}


	function insert()
	{
		$this->prepare_variables();
		$id = $this->db->insert("expense", $this);
		return $id;

	}


	function update($id)
	{

		$this->db->where("id", $id);
		$this->prepare_variables();
		$this->db->update("expense", $this);

	}
	
	
	function delete($id)
	{
		$this->db->where("id",$id);
		$this->db->delete("expense");
	}


}