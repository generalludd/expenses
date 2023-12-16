<?php #authentication index
#
if (!isset($target)) {
    $target = 'errors/html/error_404.php';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="viewport"
    content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>Cerebratorium Expense Tracking System</title>
<link type="text/css" rel="stylesheet" media="all"  href="<?php echo base_url("css/main.css");?>" />
<link type="text/css" rel="stylesheet"  media="only screen 
and (min-device-width : 320px) 
and (max-device-width : 568px)" href="<?php echo base_url("css/mobile.css")?>" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("js/password.js");?>"></script>
</head>
<body class="not-logged-in">
<div id="main">
<?php 
$this->load->view($target);
?>
</div>
</body>
</html>
