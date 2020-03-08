<?php

?>

<meta http-equiv="cache-control" content="no-store" />
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="-1">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport"
    content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title;?></title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

<link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/main.css");?>" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">


<link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/color.css");?>" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/popup.css");?>" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo cached_base_url("css/mobile.css");?>" />
<link type="text/css" rel="stylesheet" media="print" href="<?php echo cached_base_url("css/print.css");?>" />
<link type="text/css" rel="stylesheet" media="all" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"/>
<?php if(isset($styles)):?>
<?php foreach($styles as $style):?>
<link type="text/css" rel="stylesheet" media="<?php print $style->media;?>" href="<?php print $style->url;?>"/>
<?php endforeach; ?>
<?php endif; ?>
<!-- jquery scripts -->
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php print base_url("js/highcharts/highcharts.js");?>"></script>
<!-- General Script  -->
<script type="text/javascript" src="<?php echo cached_base_url("js/general.js");?>"></script>
<script type="text/javascript" src="<?php echo cached_base_url("js/expense.js");?>"></script>
<?php if($this->session->userdata("role") == "admin"): ?>
<script type="text/javascript" src="<?php echo cached_base_url("js/user.js");?>"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo cached_base_url("js/feedback.js");?>"></script>

<script type="text/javascript" src="<?php echo cached_base_url("js/password.js");?>"></script>
<?php if(isset($scripts)):?>
<?php foreach($scripts as $script):?>
	<?php if($script->url):?>
<script type="text/javascript" src="<?php print $script->url;?>"></script>
	<?php else: ?>
	<script type="text/javascript"><?php print $script->code; ?></script>
	<?php endif;?>
<?php endforeach;?>
<?php endif; ?>
