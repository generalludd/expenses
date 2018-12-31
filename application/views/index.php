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
    <?php if(!$print): ?>
        <div id='header'>
            <div id='navigation'><?php  $this->load->view('/page/navigation'); ?>
            </div>
        </div>
    <?php endif; ?>
	<?php if($this->session->flashdata("notice")) :?>
		<div class="alert alert-primary">
			<?php echo $this->session->flashdata("notice");?>
		</div>
	<?php  endif; ?>
	<?php if($this->session->flashdata("alert")) :?>
		<div class="alert alert-danger">
			<?php echo $this->session->flashdata("alert");?>
		</div>
	<?php  endif; ?>
    <!-- main -->
    <div id="main"><!-- content -->
        <div id="content"><?php
            $this->load->view($target);
            ?>
            <!-- end #main /-->
        </div>
        <!-- end content -->
        <div id="sidebar"></div>
        <!-- end sidebar --></div>
    <div id="footer"><?php $this->load->view('page/footer');?></div>
</div>
<div id="popup"></div>
</body>
</html>
