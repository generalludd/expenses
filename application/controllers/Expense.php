<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Expense extends My_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("expense_model", "expense");
	}

	function index()
	{
		$date = get_current_month();
		$month = $date["month"];
		$year = $date["year"];
		// override the uri if the userdata is already set.
		// not very elegant, but it redirects to the last selected month
		// if the user clicks the "home" button.
		if ($this->session->userdata("mo")) {
			$month = $this->session->userdata("mo");
		}
		if ($this->session->userdata("yr")) {
			$year = $this->session->userdata("yr");
		}
		redirect("expense/show_all/$month/$year");
	}

	function show_all($month, $year)
	{
		if ((int)$month && (int)$year) {
			$this->load->model("fee_model", "fee");
			$this->load->model("user_model", "user");
			$this->load->model("payment_model", "payment");
			$this->session->set_userdata("mo", $month);
			$this->session->set_userdata("yr", $year);
			$users = $this->user->get_all();
			foreach ($users as $user) {
				$user->expenses = $this->expense->get_all($user->id, $month, $year);
				$user->payments = $this->payment->get_for_user($user->id, ['mo' => $month, 'yr' => $year]);
				$user->fee_total = $this->fee->get_totals($month, $year);
			}
			$fees = $this->fee->get_by_month($month, $year);
			$data['user_count'] = count($users);
			$data['month'] = $month;
			$data['year'] = $year;
			$data['users'] = $users;
			$data['fees'] = $fees;
			$data["fee_total"] = $this->fee->get_totals($month, $year);
			$data['target'] = 'expense/totals';
			$data['title'] = 'Expenses for ' . format_month($month, $year);
			$this->load->view('index', $data);
		} else {
			redirect();
		}

	}

	function get_users_by_month()
	{
		#for each month starting from the current month of the previous year
		#get the number of users for that month.
		#total the number of users over the 12 month period
		#multiply that total by $130.
		#so get the months
		$this->load->model("user_model", "user");
		$year = date("Y") - 1;
		$month = intval(date("m"));
		$my_month = $month;
		$output = 0;
		for ($i = 1; $i < 13; $i++) {//iterate on 11 months
			#do magic
			$my_month++;
			if ($my_month == 13) {
				$my_month = 1;
				$year++;
			}
			$output += $this->user->get_count_by_month($my_month, $year);


		}
		print $output * 130;

	}

	function create($user_id)
	{
		// if user is admin, get a user list keyed pair for generating a
		// menu for users.
		if ($this->session->userdata("role") == "admin") {

			$this->load->model("user_model", "user");
			$users = $this->user->get_all();
			$data["users"] = get_keyed_pairs($users, array(
				"id",
				"username"
			));
		}
		$data["user_id"] = $user_id;
		$data["action"] = "insert";
		$data["expense"] = FALSE;
		$months = $this->variable->get("month");
		$data["months"] = get_keyed_pairs($months, array(
			"name",
			"value"
		));
		$types = $this->expense->distinct("type");
		$data["types"] = get_keyed_pairs($types, array(
			"type",
			"type"
		), TRUE, TRUE);
		$data['target'] = "expense/edit";
		$data['title'] = "Creating an Expense";
		if ($this->input->get("ajax")) {
			$this->load->view("page/modal", $data);
		} else {
			$this->load->view("index", $data);
		}

	}

	function edit()
	{
		$id = $this->uri->segment(3);
		$data["action"] = "update";
		// if user is admin, get a user list keyed pair for generating a menu
		// for users.
		if ($this->session->userdata("role") == "admin") {
			$this->load->model("user_model", "user");
			$users = $this->user->get_all();
			$data["users"] = get_keyed_pairs($users, array(
				"id",
				"username"
			));
		}
		$data["user_id"] = $this->session->userdata("userID");
		$data["expense"] = $this->expense->get($id);
		$months = $this->variable->get("month");
		$data["months"] = get_keyed_pairs($months, array(
			"name",
			"value"
		));
		$types = $this->expense->distinct("type");
		$data["types"] = get_keyed_pairs($types, array(
			"type",
			"type"
		), NULL, TRUE);
		$data["target"] = "expense/edit";
		$data['title'] = "Editing an Expense";
		if ($this->input->get("ajax")) {
			$this->load->view("page/modal", $data);
		} else {
			$this->load->view("index", $data);
		}

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
		if ($this->input->post("action") == "update") {
			$this->expense->update($id);
		} elseif ($this->input->post("action") == "delete") {
			$this->expense->delete($id);
		}
		redirect("expense/show_all/$month/$year");
	}

	function select_month()
	{
		$default_date = get_current_month();
		$default_year = $default_date["year"];
		$default_month = $default_date["month"];

		if ((int)$this->session->userdata("mo") && (int)$this->session->userdata("yr")) {
			$default_year = $this->session->userdata("yr");
			$default_month = $this->session->userdata("mo");
		}
		$month_list = get_keyed_pairs($this->variable->get("month"), array("name", "value"));
		$data = array("month_list" => $month_list, "default_month" => $default_month, "default_year" => $default_year);
		$data['target'] = "expense/select_month";
		$this->load->view("index", $data);
	}

	function next_month()
	{
		$current_month = $this->uri->segment(3);
		$current_year = $this->uri->segment(4);
		$next_month = get_next_month($current_month, $current_year);

		redirect(sprintf("expense/show_all/%s/%s", $next_month["month"], $next_month["year"]));
	}

	function previous_month()
	{
		$current_month = $this->uri->segment(3);
		$current_year = $this->uri->segment(4);
		$previous_month = get_previous_month($current_month, $current_year);
		redirect(sprintf("expense/show_all/%s/%s", $previous_month["month"], $previous_month["year"]));
	}
}
