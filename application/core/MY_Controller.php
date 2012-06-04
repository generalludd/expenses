<?php
class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if(!is_logged_in($this->session->all_userdata())){
			redirect("user");
			die();
		}
		$this->load->model("variable_model","variable");
	}



}