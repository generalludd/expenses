<?php if(isset($print)){
	$print = TRUE;
}else{
	$print = FALSE;
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<? $this->load->view('page/head');?>
</head>
<body>
<div id="page">
<?php if(!$print): ?>
<div id='header'>

<div id='navigation'><?  $this->load->view('/page/navigation'); ?>
</div>
</div>
<?php endif; ?>
<!-- main -->
<div id="main"><!-- content -->
<div id="content"><? 
$this->load->view($target);
?></div>
<!-- end content -->
<div id="sidebar"></div>
<!-- end sidebar --></div>
<div id="searchList"></div>

<div id="footer"><?// $this->load->view('/template/footer');?></div>
</div>
</body>
</html>
