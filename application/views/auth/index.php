<?php #authentication index ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>Red House Expense Tracking System</title>
<link href="<?=base_url();?>/css/main.css" type="text/css" rel="stylesheet" media="all" />
<script type="text/javascript" src="<?=base_url();?>/js/password.js"></script>
</head>
<body class="not-logged-in">
<div id="main">
<?php 
$this->load->view($target);
?>
</div>
</body>
</html>
