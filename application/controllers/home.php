<?php

class Home extends MY_Controller
{


	function __construct()
	{
		parent::__construct();
		 
	}


	function index()
	{
		$this->notify("rent_reminder");
		redirect("expense");

	}
	function notify($notice_type)
	{
		//@TODO set preferences for notification dates.
		$default_date = 28;
		$today = date('j');
		if($default_date >= $today && $today <= 5){
			$this->load->model("user_model","user");
			$this->load->model("preference_model", "preference");
			$preferences = $this->preference->get_users_for_type($notice_type);
			if($preferences){
				foreach($preferences as $preference){
					$text = "$preference->first_name,\r\n\r\nThis is just a reminder that payment for rent, utilities and food money is due by the 5th of the month.\r\n\r\nPlease visit " . site_url() . " for details.\r\n\r\nThanks, The management";
					$subject = "Rent is Due";
					$this->send($preference,$subject, $text );

				}
			}
		}
	}

	function send($user,$subject, $text){

		$this->email->from("chrisdart@cerebratorium.com");
		$this->email->to($user->email);
		$this->email->subject($subject);
		$this->email->message($text);
		$this->email->send();
		$errors = "An email has been sent to your account with instructions for resetting your password.";

	}
	
}