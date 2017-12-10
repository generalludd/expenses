<?php

?>

<meta http-equiv="cache-control" content="no-store" />
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="-1">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport"
    content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title;?></title>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/main.css");?>" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/color.css");?>" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/popup.css");?>" />
<link type="text/css" rel="stylesheet"  media="(max-width: 855px)" href="<?php echo cached_base_url("css/mobile.css");?>" />
<link type="text/css" rel="stylesheet" media="print" href="<?php echo cached_base_url("css/print.css");?>" />
<!-- jquery scripts -->
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
<script type="text/javascript" src="<?php echo cached_base_url("js/jquery.min.js");?>"></script>
<!-- <script type="text/javascript" src="<?php echo cached_base_url("js/jquery.validate.js");?>"></script>-->
<script type="text/javascript" src="<?php echo cached_base_url("js/jquery-ui.min.js");?>"></script>
<!-- <script type="text/javascript" src="<?php echo cached_base_url("js/forms.jquery.js");?>"></script>  
<script type="text/javascript" src="<?php echo cached_base_url("js/cookie.jquery.js");?>"></script> -->

<!-- General Script  -->
<script type="text/javascript" src="<?php echo cached_base_url("js/general.js");?>"></script>
<script type="text/javascript" src="<?php echo cached_base_url("js/fee.js");?>"></script>
<script type="text/javascript" src="<?php echo cached_base_url("js/expense.js");?>"></script>
<?php if($this->session->userdata("role") == "admin"): ?>
<script type="text/javascript" src="<?php echo cached_base_url("js/user.js");?>"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo cached_base_url("js/feedback.js");?>"></script>

<script type="text/javascript" src="<?php echo cached_base_url("js/password.js");?>"></script>

<script type="text/javascript" src="<?php echo cached_base_url("js/payment.js");?>"></script>
