<?php


class Preference extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("preference_model");

	}

	function view()
	{
		$user_id = $this->uri->segment(3);
		$data["preferences"] = $this->preference_model->get_all($user_id);
		$data["user_id"] = $user_id;
		$data["title"] = "View and Change Preferences";
		$data["target"] = "preference/view";
		$this->load->view("index.php", $data);

	}

	function update()
	{
		if($this->input->post("user_id")){
			$user_id = $this->input->post("user_id");
			if($user_id == $this->session->userdata("userID") || $this->session->userdata("userID") == 1000){
				$type = $this->input->post("type");
				$value = $this->input->post("value");
				$output = $this->preference_model->update($user_id, $type, $value);
				if($output){
					echo OK;
				}else{
					echo $output;// "The preference update did not work because of an error";
				}
			}
		}
	}
	



}