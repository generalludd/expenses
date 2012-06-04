<?php
class Variable_model extends CI_Model
{

	var $class = "";
	var $name = "";
	var $value = "";
	var $type = "";


	function __construct()
	{
		parent::__construct();

	}


	function prepare_variables()
	{
		$variables = array("class","name","value","type");
		prepare_variables($this, $variables);
	}



	function get($class, $order = NULL)
	{
		$this->db->where("class", $class);
		$this->db->from("variable");
		if ($order){
			$this->db->order_by($order);
		}
		$result = $this->db->get()->result();
		return $result;

	}

	function get_value($class, $name)
	{
		$this->db->where("class",$class);
		$this->db->where("name", $name);
		$this->db->from("variable");
		$result = $this->db->get()->row();
		return $result->value;
	}


}