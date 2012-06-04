<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expense extends My_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("expense_model","expense");

	}


	function index()
	{
		$month = date("n");
		$year = date("Y");
		
		if(date('j') > 15){
			$month =  $month + 1;
		}
		if($this->session->userdata("mo")){
			$month = $this->session->userdata("mo");
		}
		if($this->session->userdata("yr")){
			$year = $this->session->userdata("yr");
		}
		redirect("expense/show_all/$month/$year");

	}


	function show_all()
	{

		$month = $this->uri->segment(3);
		$year = $this->uri->segment(4);
		if($month == NULL){
			$this->session->set_userdata("mo", date("n"));
		}else{
			$this->session->set_userdata("mo",$month);
		}
		if($year == NULL){
			$this->session->set_userdata("yr", date("Y"));
		}else{
			$this->session->set_userdata("yr",$year);
		}
		if((int)$month && (int)$year){

			$this->load->model("fee_model","fee");
			$this->load->model("user_model","user");
			$this->load->model("payment_model","payment");
			$data["user_count"] = $this->user->count_active();
			$data["fee_total"] = $this->fee->get_totals($month,$year);
			$data["expenses"] = $this->expense->get_by_month($month,$year);
			$data["payments"] = $this->payment->get_by_month($month, $year);
			$data["expense_total"] = $this->expense->get_total($month,$year);
			$data["global_fee_total"] = $this->fee->get_totals(NULL,NULL,"Shopping");
			$data["global_expense_total"] = $this->expense->get_total();
			$data["month_count"] = $this->fee->count_months();
			$data["fees"] = $this->fee->get_by_month($month,$year);
			$month_name = $this->variable->get_value("month",$month);
			$data["month"] = $month_name;
			$data["year"] = $year;
			$data["title"] = "Expenses for $month_name $year";
			$data["target"] = "expense/totals";
			if($this->input->get_post("ajax")){
				$this->load->view($data["target"], $data);
			}else{
				$this->load->view("index", $data);
			}

		}else{
			redirect();
		}

	}


	function create()
	{
		if($this->input->get_post("user_id")){
			//if user is admin, get a user list keyed pair for generating a menu for users.
			if($this->session->userdata("role") == "admin"){
					
				$this->load->model("user_model", "user");
				$users = $this->user->get_all();
				$data["users"] = get_keyed_pairs($users, array("id","username"));
			}
			$data["user_id"] = $this->input->get_post("user_id");
			$data["action"] = "insert";
			$data["expense"] = FALSE;
			$months = $this->variable->get("month");
			$data["months"] = get_keyed_pairs($months,array("name","value"));
			$types = $this->expense->distinct("type");
			$data["types"] = get_keyed_pairs($types,array("type","type"),TRUE,TRUE);
			$data["target"] = "expense/edit";
			$this->load->view($data["target"], $data);
		}else{
			$data["error"] = "Something went wrong here and your user id did not get passed to the script. Does that make any sense?";
			$this->load->view("error",$data);
		}
	}


	function edit()
	{

		$id = $this->uri->segment(3);
		$data["action"] = "update";
		//if user is admin, get a user list keyed pair for generating a menu for users.
		if($this->session->userdata("role") == "admin"){
			$this->load->model("user_model", "user");
			$users = $this->user->get_all();
			$data["users"] = get_keyed_pairs($users, array("id","username"));
		}
		$data["user_id"] = $this->session->userdata("userID");
		$data["expense"] = $this->expense->get($id);
		$months = $this->variable->get("month");
		$data["months"] = get_keyed_pairs($months,array("name","value"));
		$types = $this->expense->distinct("type");
		$data["types"] = get_keyed_pairs($types,array("type","type"),NULL,TRUE);
		$data["target"] = "expense/edit";
		$this->load->view($data["target"],$data);
	}


	function insert()
	{
		$month = $this->input->post("mo");
		$year = $this->input->post("yr");
		$id = $this->expense->insert();
		redirect("expense/show_all/$month/$year");

	}

	function update()
	{
		$id = $this->input->post("id");
		$month = $this->input->post("mo");
		$year = $this->input->post("yr");
		if($this->input->post("action") == "update"){
			$this->expense->update($id);
		}elseif($this->input->post("action") == "delete"){
			$this->expense->delete($id);
		}
		redirect("expense/show_all/$month/$year");

	}


}