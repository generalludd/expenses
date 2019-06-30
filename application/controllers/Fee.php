<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fee extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("fee_model", "fee");
		$this->load->model("user_model", "user");


	}

	function index()
	{
		//print_r($this->user->in_month(02,1998));
		//print $this->db->last_query();
		redirect();
	}


	function show_all()
	{

		$month = $this->uri->segment(3);
		$year = $this->uri->segment(4);
		if ((int)$month && (int)$year) {
			$this->load->model("user_model", "user");
			$data["user_count"] = $this->user->count_active();
			$data["fee_total"] = $this->fee->get_totals_by_month($month, $year);
			$data["fees"] = $this->fee->get_by_month($month, $year);
			$month_name = $this->variable->get_value("month", $month);
			$data["month"] = $month_name;
			$data["year"] = $year;
			$data["title"] = "Expenses for $month_name $year";
			$data["target"] = "fee/list";
			$this->load->view("index", $data);

		}

	}


	function create()
	{
		if ($this->session->userdata("role") == "admin") {
			$data["action"] = "insert";
			$data["fee"] = FALSE;
			$months = $this->variable->get("month");
			$data["months"] = get_keyed_pairs($months, array("name", "value"));
			$types = $this->fee->distinct("type");
			$data["types"] = get_keyed_pairs($types, array("type", "type"), NULL, TRUE);
			$data["target"] = "fee/edit";
			$data['title'] = "Create a Fee";
			if ($this->input->get("ajax")) {
				$this->load->view("page/modal", $data);
			} else {
				$this->load->view("index", $data);
			}
		} else {
			$data["message"] = "You are not authorized to create fee entries";
			$this->load->view("error", $data);
		}
	}


	function edit()
	{
		if ($this->session->userdata("role") == "admin") {
			$id = $this->uri->segment(3);
			$data["action"] = "update";
			$data["fee"] = $this->fee->get($id);
			$months = $this->variable->get("month");
			$data["months"] = get_keyed_pairs($months, array("name", "value"));
			$types = $this->fee->distinct("type");
			$data["types"] = get_keyed_pairs($types, array("type", "type"), NULL, TRUE);
			$data["target"] = "fee/edit";
			$data['title'] = "Edit a Fee";
			if ($this->input->get("ajax")) {
				$this->load->view("page/modal", $data);
			} else {
				$this->load->view("index", $data);
			}
		} else {
			$data["message"] = "You are not authorized to create fee entries";
			$this->load->view("error", $data);
		}
	}


	function insert()
	{
		if ($this->session->userdata("role") == "admin") {
			$month = $this->input->post("mo");
			$year = $this->input->post("yr");
			$id = $this->fee->insert();
			redirect("expense/show_all/$month/$year");
		} else {
			$data["message"] = "You are not authorized to create fee entries";
			$this->load->view("error", $data);
		}

	}


	function update()
	{
		if ($this->session->userdata("role") == "admin") {
			$month = $this->input->post("mo");
			$year = $this->input->post("yr");
			$id = $this->input->post("id");
			$this->fee->update($id);
			redirect("expense/show_all/$month/$year");
		} else {
			$data["message"] = "You are not authorized to create fee entries";
			$this->load->view("error", $data);
		}
	}

	function copy_month()
	{

		$current = $this->fee->get_current_month();

		$this->fee->copy_month($current->mo, $current->yr);
		if ($current->mo < 10) {
			$current->mo = "0$current->mo";
		}
		redirect("expense/show_all/$current->mo/$current->yr");

	}

	function delete()
	{
		//if($id = $this->input->post("id")){
		$id = $this->input->post("id");
		$fee = $this->fee->get($id);
		$this->fee->delete($id);
		echo json_encode($fee);

		//}
	}

}
