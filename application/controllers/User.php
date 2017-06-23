<?php

class User extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("user_model", "user");
		$this->load->model("variable_model","variable");

	}

	function index($username = NULL, $errors = NULL)
	{
		if(!is_logged_in($this->session->userdata())){
			$data["errors"] = $errors;
			$data["username"] = $username;
			$data["target"] = "auth/login";
			$this->load->view("auth/index", $data);
		}else{
			//users shoudn't be here.
			redirect("");
		}

	}

	function show_all()
	{

		if($this->session->userdata("role") == "admin"){

			if($this->input->get_post("include_inactive")){
				$data["users"] = $this->user->get_all(TRUE);
			}else{
				$data["users"] = $this->user->get_all();
			}

			$data["target"] = "user/list";
			$data["title"] = "Listing All Users";
			$this->load->view("index",$data);
		}

	}


	function create()
	{
		$data["user"] = FALSE;
		$data["roles"] = array("admin"=>"admin","user"=>"user");
		$data["target"] = "user/edit";
		$data["action"] = "insert";
		$data["title"] = "Editing User";
		if($this->input->get_post("ajax")){
			$this->load->view($data["target"],$data);
		}else{
			$this->load->view("index",$data);
		}
	}


	function edit()
	{
		if($this->input->get_post("id")){
			$id = $this->input->get_post("id");
			$data["user"] = $this->user->get($id, "id,username,first_name,last_name,email,is_active,role");
			$data["roles"] = array("admin"=>"admin","user"=>"user");
			$data["target"] = "user/edit";
			$data["action"] = "update";
			$data["title"] = "Editing User";
			if($this->input->get_post("ajax")){
				$this->load->view($data["target"],$data);
			}else{
				$this->load->view("index",$data);
			}
		}
	}


	function insert()
	{
		if($this->session->userdata("role") == "admin"){
			$id = $this->user->insert();
			//@todo this should include a notification email
			redirect("user/show_all");
		}else{
			$data["error"] = "You are not authorized to complete this!";
			$data["title"] = "Unauthorized action";
			$data["target"] = "error";
			$this->load->view("index",$data);
		}
	}

	function update()
	{
		if($this->session->userdata("role") == "admin"){
			if($this->input->post("id")){
				$id = $this->input->post("id");
				$this->user->update($id);
				redirect("user/show_all");
			}
		}else{
			$data["error"] = "You are not authorized to edit users!";
			$data["title"] = "Unauthorized action";
			$data["target"] = "error";
			$this->load->view("index",$data);
		}
	}

	function login()
	{
		$redirect = false;
		if($this->input->post("username") && $this->input->post("password")){
			$username = $this->input->post("username");
			$password =  $this->input->post("password");
			$result = $this->user->validate($username, $password);
			if($result){
				$data["username"] = $username;
				$data["role"] = $result->role;
				$data["userID"] = $result->id;
				$this->session->set_userdata($data);
				$redirect = true;
			}
		}
		if($redirect){
			redirect("");
		}else{
			$this->index($this->input->post("username"), "Your username or password are not correct. Please try again");
		}
	}

	function first_time()
	{
		$data["target"] = "auth/verify";
		$data["errors"] = array();
		$this->load->view("auth/index",$data);
	}

	function start_verify()
	{
		$user_info = $this->input->post("user_info");
		$password = $this->input->post("password");
		$code = $this->user->initialize($user_info, $password);
		$this->send_verification($user_info, $code);

	}


	function verify()
	{
		$id = $this->uri->segment(3);
		$code = $this->uri->segment(4);
		if($this->user->is_verified($id, $code)){
			$user = $this->user->get($id,"username");
			$this->index($user->username, array("Your account has been verified. Please log in with the password you created."));
		}

	}


	function logout()
	{
		$this->session->sess_destroy();
		$this->index("", "You have successfully logged out");
	}


	function edit_password()
	{
		$id = $this->input->post("id");
		$userID = $this->session->userdata("userID");
		if($id == $userID){
			$data["id"] = $id;
			$this->load->view("auth/changepass", $data);
		}
	}



	function change_password()
	{
		$output = "You are not authorized to do this!";
		$id = $this->input->post("id");
		$role = $this->session->userdata("role");
		$userID = $this->session->userdata("userID");

		if($id == $userID || $role == "admin"){
			$output = "The passwords did not match";
			$current_password = $this->input->post("current_password");

			$new_password = $this->input->post("new_password");

			$check_password = $this->input->post("check_password");

			if($new_password === $check_password){
				$result = $this->user->change_password($id, $current_password, $new_password);
				if($result){
					$output = "Your password has been successfully changed";
				}else{
					$output = "Your original password did not match the one in the database";
				}
			}
		}
		echo $output;
	}

	function send_verification($user_info, $code){
		$id = $this->user->get_id($user_info);
		$email = $this->user->get($id,"email");
		$link =  site_url("user/verify/$id/$code");
		$this->email->from("chrisdart@cerebratorium.com");
		$this->email->to($email);
		$this->email->subject("Password Reset");
		$this->email->message("This is a verification message. Please click the link below to verify your account: $link");
		$this->email->send();
		$errors = "An email has been sent to your account with instructions for resetting your password.";
		$this->index("",$errors);

	}

	/****** FORGOTTEN PASSWORD RESETTING FUNCTIONS ******/

	/**
	 *
	 * Begin the process of resetting a user account by displaying
	 * a dialog
	 * @param string or array $errors
	 */
	function start_reset($errors = NULL)
	{
		$data["errors"] = $errors;
		$data["target"] = "auth/request_reset";
		$this->load->view("auth/index", $data);
	}

	/**
	 *
	 * Send the reset hash based on the email address provided.
	 */
	function send_reset()
	{
		$email = trim($this->input->get_post("email"));
		$id = $this->user->email_exists($email);
		if($id){
			$hash = $this->user->set_reset_hash($id);
			$link = site_url("user/show_reset/$id/$hash");
			$this->email->from("chrisdart@cerebratorium.com");
			$this->email->to($email);
			$this->email->subject("Password Reset");
			$this->email->message("Click on the following link to reset your password: $link");
			$this->email->send();
			$errors = "An email has been sent to your account with instructions for resetting your password.";
			$this->index("",$errors);
		}else{
			$this->start_reset("The email address you entered does not exist in the database, please try again");
		}
	}

	/**
	 *
	 * Show the reset dialog
	 * @param string or array $errors
	 */
	function show_reset($errors = NULL)
	{
		$data["id"] = $this->uri->segment(3);
		$data["reset_hash"] = $this->uri->segment(4);
		$data["errors"] = array($errors);
		if($data["id"] != "" && $data["reset_hash"] != ""){
			$data["target"] = "auth/reset_password";
			$this->load->view("auth/index", $data);
		}else{
			$this->logout();
		}
	}

	/**
	 *
	 * finish up the reset process
	 */
	function complete_reset()
	{
		$id = $this->input->post("id");
		$reset_hash = $this->input->post("reset_hash");
		$password = $this->input->post("new_password");
		$check_password = $this->input->post("check_password");
		$result = $this->user->reset_password($id, $reset_hash, $password);
		if($result){
			$this->index("","You can now log in with your new password");
		}else{
			$this->start_reset("An error occurred. Please try again or ask for technical support");
		}
	}

}
