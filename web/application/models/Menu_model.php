<?php defined('BASEPATH') OR exit('No direct script access allowed');


class menu_model extends CI_Model
{
	
	var $name;
	var $rank;
	
	function get($kMenu = FALSE)
	{
		$this->db->from("menu_item");
		//$this->db->where("menu_item.kMenu",$kMenu);
		$this->db->join("menu","menu.kMenu = menu_item.kMenu");
		$this->db->order_by("menu_item.rank","ASC");
		$result = $this->db->get()->result();
		return $result;
	}
	
	function get_all($select = FALSE)
	{
		$this->db->from("menu");
		if($select){
			$this->db->select($select);
		}
		$this->db->order_by("rank");
		$result = $this->db->get()->result();
		return $result;
	}
	
	
	function insert()
	{
		$this->name = $this->input->post("name");
		$this->rank = $this->input->post("rank");
		$kMenu = $this->db->insert("menu",$this);
		return $kMenu;
	}
	
	
	function update($kMenu)
	{
		$this->name = $this->input->post("name");
		$this->rank = $this->input->post("rank");
		$this->db->where("kMenu",$kMenu);
		$this->db->update("menu",$this);
	}
	
	
}