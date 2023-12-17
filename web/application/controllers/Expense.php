<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Expense extends My_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model("expense_model", "expense");
    $this->load->model('month_status_model', 'month_status');
  }

  function index() {
    [$month, $year] = get_defaults($this);
    $this->show($month, $year);
  }

  function show($month, $year) {

    if ((int) $month && (int) $year) {
      $this->load->model("fee_model", "fee");
      $this->load->model("user_model", "user");
      $this->load->model("payment_model", "payment");
      $this->session->set_userdata("mo", $month);
      $this->session->set_userdata("yr", $year);
      $users = $this->user->get_all();
      foreach ($users as $user) {
        $user->expenses = $this->expense->get_all($user->id, $month, $year);
        $user->payments = $this->payment->get_for_user($user->id, [
          'mo' => $month,
          'yr' => $year,
        ]);
        $user->fee_total = $this->fee->get_totals($month, $year);
        $expense_total = $this->expense->get_user_total($user->id, $month, $year);
        $user->expense_total = $expense_total === NULL ? 0 : $expense_total;
      }

      $month_is_locked = $this->month_status->get_status($month, $year);
      if ($month_is_locked) {
        $this->session->set_flashdata('alert', 'This month is locked for editing');
      } elseif(!$this->fee->month_has_payments($month, $year)){
        $month_is_locked = -1;
      }
      $fees = $this->fee->get_by_month($month, $year);
      $data['is_locked'] = $month_is_locked;
      $data['user_count'] = count($users);
      $data['month'] = $month;
      $data['year'] = $year;
      $data['users'] = $users;
      $data['fees'] = $fees;
      $data["fee_total"] = $this->fee->get_totals($month, $year) / 2;
      $data['target'] = 'expense/totals';
      $data['title'] = 'Expenses for ' . format_month($month, $year);
      $this->load->view('index', $data);
    }
    else {
      redirect();
    }

  }

  function get_users_by_month() {
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

  function create($user_id) {
    // if user is admin, get a user list keyed pair for generating a
    // menu for users.
    if ($this->session->userdata("role") == "admin") {

      $this->load->model("user_model", "user");
      $users = $this->user->get_all();
      $data["users"] = get_keyed_pairs($users, [
        "id",
        "username",
      ]);
    }
    $data["user_id"] = $user_id;
    $data["action"] = "insert";
    $data["expense"] = FALSE;
    $months = $this->variable->get("month");
    $data["months"] = get_keyed_pairs($months, [
      "name",
      "value",
    ]);
    $types = $this->expense->distinct("type");
    $data["types"] = get_keyed_pairs($types, [
      "type",
      "type",
    ], TRUE, TRUE);
    $data['target'] = "expense/edit";
    $data['title'] = "Creating an Expense";
    if ($this->input->get("ajax")) {
      $this->load->view("page/modal", $data);
    }
    else {
      $this->load->view("index", $data);
    }

  }

  function edit($id) {
    $data["action"] = "update";
    // if user is admin, get a user list keyed pair for generating a menu
    // for users.
    if ($this->session->userdata("role") == "admin") {
      $this->load->model("user_model", "user");
      $users = $this->user->get_all();
      $data["users"] = get_keyed_pairs($users, [
        "id",
        "username",
      ]);
    }
    $data["user_id"] = $this->session->userdata("userID");
    $data["expense"] = $this->expense->get($id);
    $months = $this->variable->get("month");
    $data["months"] = get_keyed_pairs($months, [
      "name",
      "value",
    ]);
    $types = $this->expense->distinct("type");
    $data["types"] = get_keyed_pairs($types, [
      "type",
      "type",
    ], NULL, TRUE);
    $data["target"] = "expense/edit";
    $data['title'] = "Editing an Expense";
    if ($this->input->get("ajax")) {
      $this->load->view("page/modal", $data);
    }
    else {
      $this->load->view("index", $data);
    }

  }

  function insert() {
    $month = $this->input->post("mo");
    $year = $this->input->post("yr");
    $id = $this->expense->insert();
    redirect("expense/show/$month/$year");
  }

  function update() {
    $id = $this->input->post("id");
    $month = $this->input->post("mo");
    $year = $this->input->post("yr");
    $this->expense->update($id);
    redirect("expense/show/$month/$year");
  }

  function delete() {
    $id = $this->input->post('id');
    $this->expense->delete($id);
    if ($this->input->post('ajax')) {

    }

  }

  function select() {
    if ($month = $this->input->get('month') && $year = $this->input->get('year')) {
      redirect('expense/show/' . $month . '/' . $year);
    }
    else {
      [$default_month, $default_year] = get_defaults($this);
      $month_list = get_keyed_pairs($this->variable->get("month"), [
        "name",
        "value",
      ]);
      $data = [
        "month_list" => $month_list,
        "default_month" => $default_month,
        "default_year" => $default_year,
      ];
      $data['target'] = "expense/select";
      $data['title'] = 'Select a month';
      if ($this->input->get('ajax')) {
        $this->load->view('page/modal', $data);
      }
      else {
        $this->load->view("index", $data);
      }
    }
  }

  function next_month($month, $year) {
    $next_month = get_next_month($month, $year);
    redirect(sprintf("expense/show/%s/%s", $next_month["month"], $next_month["year"]));
  }

  function previous_month($month, $year) {
    $previous_month = get_previous_month($month, $year);
    redirect(sprintf("expense/show/%s/%s", $previous_month["month"], $previous_month["year"]));
  }

  function set_month_status(): void {
    $month = $this->input->post('month');
    $year = $this->input->post('year');
    $status = $this->input->post('status');
    $this->month_status->set_status($month, $year, $status);
    echo base_url('/expense/show/'. $month . '/' . $year);
  }


}
