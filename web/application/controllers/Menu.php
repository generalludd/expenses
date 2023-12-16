<?php defined('BASEPATH') OR exit('No direct script access allowed');

class menu extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("menu_model","menu");
		$this->load->model("menu_item_model","item");
	}


	function index()
	{
		$data["menus"] = $this->menu->get();
		$data["target"] = "menu/list";
		$data["title"] = "Menu List Editor";
		$this->load->view("index",$data);
	}

	function edit_item()
	{
		$kItem = $this->uri->segment(3);
		$data["item"] = $this->item->get($kItem);
		$menus = $this->menu->get_all("kMenu,name");
		$data["menus"] = get_keyed_pairs($menus, array("kMenu","name"));
		$data["action"] = "update_item";
		$this->load->view("menu_item/edit",$data);
	}

	function update_item()
	{
		$kItem = $this->input->post("kItem");
		$this->item->update($kItem);
		redirect("menu");
	}
	
	function insert_item()
	{
		$this->item->insert();
		redirect("menu");
	}
	
	function create_item()
	{
		$data["item"] = NULL;
		
		$menus =  $this->menu->get_all("kMenu,name");
		$data["menus"] = get_keyed_pairs($menus, array("kMenu","name"));
		$data["action"] = "insert_item";
		$this->load->view("menu_item/edit",$data);
	}
}