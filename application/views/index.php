<?php if(isset($print)){
	$print = TRUE;
}else{
	$print = FALSE;
}?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->load->view('page/head');?>
</head>
<body>
<div id="page">
<?php if($this->session->flashdata("notice")) :?>
<div class="message">
<?php echo $this->session->flashdata("notice");?>
</div>
<?php  endif; ?>
<?php if(!$print): ?>
<div id='header'>
<div class="mobile-only show-navigation-box block">
<span class="button mobile-only show-navigation">Show Navigation</span>
</div>
<div id='navigation'><?php  $this->load->view('/page/navigation'); ?>
</div>
</div>
<?php endif; ?>
<!-- main -->
<div id="main"><!-- content -->
<div id="content"><?php
$this->load->view($target);
?></div>
<!-- end content -->
<div id="sidebar"></div>
<!-- end sidebar --></div>
<div id="searchList"></div>

<div id="footer"><?php $this->load->view('page/footer');?></div>
</div>
</body>
</html>
