<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// payment.php Chris Dart Mar 11, 2012 4:38:55 PM chrisdart@cerebratorium.com

class Payment extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("payment_model","payment");
	}


    function insert()
    {
        $mo = $this->input->get_post("mo");
        $yr = $this->input->get_post("yr");
        $user_id = $this->input->get_post("user_id");
        $id = NULL;
        if($mo && $yr && $user_id){
            $payment = $this->payment->get_for_user($user_id, array("mo"=>$mo, "yr"=>$yr));
            if(!$payment){
                $id = $this->payment->insert();
            }else{
                $id = $this->update($payment->id);
            }
        }

		$this->session->set_flashdata ( "notice", "Item updated" );

        redirect("expense/show_all/$mo/$yr");
    }


    function update($id = NULL)
    {
        if(!isset($id)){
            $id = $this->input->post("id");
        }
		$my_payment = $this->payment->update($id);
		$mo = $my_payment->mo;
		$yr = $my_payment->yr;
        $this->session->set_flashdata ( "notice", "Item updated" );
		redirect("expense/show_all/$mo/$yr");

	}


    function edit()
    {
        $id = $this->input->get("id");
        if($id){

            $payment = $this->payment->get($id);
            if($this->session->userdata("role") == "admin"){
                $this->load->model("user_model", "user");
                $users = $this->user->get_all();
                $data["users"] = get_keyed_pairs($users, array("id","username"));
            }
            $months = $this->variable->get("month");
            $data["user_id"] = $payment->user_id;
            $data["months"] = get_keyed_pairs($months,array("name","value"));
            $data["payment"] = $payment;
            $data["action"] = "update";
            $data["total_due"] = $payment->amt;
            $data['target'] = "payment/edit";
            $data['title'] = "Edit a Payment";
			if($this->input->get("ajax")){
                $this->load->view("page/modal",$data);
            }else{
                $this->load->view("index",$data);
            }
        }
    }

    function create()
    {
        if($this->session->userdata("role") == "admin"){
            $this->load->model("user_model", "user");
            $users = $this->user->get_all();
            $data["users"] = get_keyed_pairs($users, array("id","username"));
        }
        $data["user_id"] = $this->input->get("user_id");
        $data["action"] = "insert";
        $data["payment"] = NULL;
        $months = $this->variable->get("month");
        $data["months"] = get_keyed_pairs($months,array("name","value"));
        $data["total_due"] = $this->input->get("total_due");
        $data['target'] = "payment/edit";
        $data['title'] = "Add a Payment";
        if($this->input->get("ajax")){
            $this->load->view("page/modal",$data);
        }else{
        	$this->load->view("index",$data);
        }
    }



}
