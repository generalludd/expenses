<?php

?>

<meta http-equiv="cache-control" content="no-store" />
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="-1">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport"
    content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title;?></title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" media="screen">

<!-- Bootstrap theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css" media="screen"><link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/main.css");?>" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">


<link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/color.css");?>" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/popup.css");?>" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/mobile.css");?>" />
<link type="text/css" rel="stylesheet" media="print" href="<?php echo cached_base_url("css/print.css");?>" />
<!-- jquery scripts -->
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- General Script  -->
<script type="text/javascript" src="<?php echo cached_base_url("js/general.js");?>"></script>
<script type="text/javascript" src="<?php echo cached_base_url("js/fee.js");?>"></script>
<script type="text/javascript" src="<?php echo cached_base_url("js/expense.js");?>"></script>
<?php if($this->session->userdata("role") == "admin"): ?>
<script type="text/javascript" src="<?php echo cached_base_url("js/user.js");?>"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo cached_base_url("js/feedback.js");?>"></script>

<script type="text/javascript" src="<?php echo cached_base_url("js/password.js");?>"></script>

