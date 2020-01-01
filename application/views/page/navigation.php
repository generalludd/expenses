<?php

$default_date = get_current_month();
$default_year = $default_date["year"];
$default_month = $default_date["month"];

if ((int) $this->session->userdata("mo") && (int) $this->session->userdata("yr")) {
	$default_year = $this->session->userdata("yr");
	$default_month = $this->session->userdata("mo");
}

$month_list = get_keyed_pairs($this->variable->get("month"), ["name", "value"]);

$nav_buttons["home"] = [
	"item" => "expense",
	"text" => "Home",
	"href" => base_url(),
	"class" => "btn btn-sm btn-secondary home",
];
$nav_buttons["previous_month"] = [
	"item" => "expense",
	"text" => '<i class="fas fa-arrow-left"></i> Previous',
	"href" => site_url("expense/previous_month/$default_month/$default_year"),
	"class" => "btn btn-sm btn-secondary show-previous-month",
];
$nav_buttons["next_month"] = [
	"item" => "expense",
	"text" => 'Next <i class="fas fa-arrow-right"></i>',
	"href" => site_url("expense/next_month/$default_month/$default_year"),
	"class" => "btn btn-sm btn-secondary show-next-month",
];
$nav_buttons["show_month"] = [
	"item" => "expense",
	"text" => "Select Month",
	"href" => site_url("expense/select_month"),
	"class" => "btn btn-sm btn-secondary",
];
if ($this->session->userdata("role") == "admin") {
	$nav_buttons["copy_month"] = [
		"item" => "fee",
		"text" => "New Month",
		"href" => site_url("fee/copy_month"),
		"class" => "btn btn-sm btn-warning new new-month",
	];
	$nav_buttons['transactions'] = [
		"text" => "Transactions",
		"href" => site_url('transaction'),
		'class' => 'btn btn-sm btn-secondary'
	];
	$user_buttons['chart_of_accounts'] = [
		"item" => "account",
		"text" => "Accounts",
		"title" => "Chart of Accounts",
		"href" => site_url('account'),
		'class' => "btn btn-sm btn-secondary",
	];
	$user_buttons["user_list"] = [
		"item" => "user",
		"text" => "User List",
		"href" => site_url("user/show_all"),
		"class" => "btn btn-sm btn-secondary show-user-list",
	];
}

$user_buttons["preferences"] = [
	"item" => "preference",
	"text" => "Preferences",
	"title" => "Change Your Settings",
	"href" => site_url("preference/view/" . $this->session->userdata("userID")),
	"class" => "btn btn-sm btn-secondary",
];
$user_buttons["feedback"] = [
	"item" => "preference",
	"text" => "Feedback",
	"class" => "btn btn-sm btn-secondary",
	"href" => site_url("feedback/create"),
	"title" => "Send Feedback for Improvements or Problems",
];
$user_buttons["log_out"] = [
	"item" => "user",
	"text" => "Log Out",
	"class" => "btn btn-sm btn-secondary logout",
	"href" => site_url("user/logout"),
];

?>

<?php echo create_button_bar($nav_buttons, [
	"id" => "nav_buttons",
	"class" => "nav-buttons",
]); ?>
<?php echo create_button_bar($user_buttons, [
	"id" => "user_menu",
	"class" => "user-menu",
]); ?>

