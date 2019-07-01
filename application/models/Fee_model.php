<?php

class Fee_model extends CI_Model
{

	var $type = "";
	var $amt = "";
	var $mo = "";
	var $yr = "";

	function __construct()
	{
		parent::__construct();
	}


	function prepare_variables()
	{
		$variables = array("type","amt","mo","yr");
		prepare_variables($this, $variables);
	}



	function get($id)
	{
		$this->db->where("id", $id);
		$this->db->from("fee");
		$result = $this->db->get()->row();
		return $result;
	}



	function distinct($field){
		$this->db->select($field);
		$this->db->distinct();
		$this->db->from("fee");
		$result = $this->db->get()->result();
		return $result;
	}


	function get_by_month($mo,$yr, $type = NULL)
	{

		$this->db->where("mo", $mo);
		$this->db->where("yr", $yr);
		if(isset($type)){
			$this->db->where("type", $type);
		}
		$this->db->select("fee.amt, fee.mo,fee.yr, fee.type, fee.id");
		$this->db->from("fee");
		//$this->db->order_by("(CASE WHEN `type` = 'Rent' THEN 1 WHEN `type` = 'Shopping' THEN 2 ELSE 3 END)", TRUE);
		$this->db->order_by("type");
		$result = $this->db->get()->result();
		return $result;
	}

	function get_totals($mo= NULL,$yr = NULL, $type = NULL)
	{
		if($mo){
			$this->db->where("mo",$mo);
		}
		if($yr){
			$this->db->where("yr",$yr);
		}
		if($type){
			$this->db->where("type",$type);
		}
		$this->db->select("sum(amt) as total");
		$this->db->from("fee");
		$result = $this->db->get()->row();
		return $result->total;
	}


	function count_months($yr = NULL)
	{
		if($yr){
			$this->db->select("count(distinct(`mo`)) as count", false);
		}else{
			$this->db->select("count(distinct(concat(`mo`,`yr`))) as count",false);
		}
		$this->db->from("fee");
		$result = $this->db->get()->row();
		return $result->count;
	}


	function insert()
	{
		$this->prepare_variables();
		$this->db->insert("fee", $this);
		$id = $this->db->insert_id();

		return $id;


	}


	function update($id)
	{

		$this->db->where("id", $id);
		$this->prepare_variables();
		$this->db->update("fee", $this);

	}

	function get_current_month()
	{
		$this->db->order_by("yr","DESC");
		$this->db->order_by("mo","DESC");
		$this->db->limit(1);
		$this->db->from("fee");
		$this->db->select("mo,yr");
		$result = $this->db->get()->row();
		return $result;
	}

	function copy_month($mo,$yr,$target_mo = NULL, $target_yr = NULL)
	{
		if(($target_mo == $mo || $target_mo == NULL ) AND ($target_yr == NULL)){
			switch($mo){
				case 12:
					$month = 1;
					$year = $yr +1;
					break;
				default:
					$month = $mo + 1;
					$year = $yr;
			}
		}else{
			$year = $target_yr;
			$month = $target_mo;
		}
		$values = $this->get_by_month($mo, $yr);
		foreach($values as $value){
			$query = "INSERT INTO `fee` (`type`,`amt`,`mo`,`yr`) VALUES(" .
			$this->db->escape($value->type) . "," .
			$this->db->escape($value->amt) . "," .
			$this->db->escape($month) . "," .
			$this->db->escape($year) . ")";
			$this->db->query($query);
		}


	}

	function delete($id){
	    $this->db->where("id",$id);
	    $this->db->delete("fee");
    }

}
