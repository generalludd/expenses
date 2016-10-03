<?php ?>
<h2>Set Preferences for your Account</h2>
<input
	type='hidden' id='user_id' name='user_id' value='<?php echo $user_id;?>' />
<p class='notice'>Note that this is a beta testing area. Changes you make will probably not do anything.</p>
<?php
foreach($preferences as $preference){
	if($preference->format=='menu'){
		$list = explode(",",$preference->options);
		$output = displayMenu($list,$preference->type,$preference->value,'edit_preference');
	}elseif($preference->format=="radio"){
		$data = array("name" => $preference->type, "id" => $preference->type, "value" => TRUE, "checked"=> $preference->value);
		$output = form_radio($data, "class='edit_peference'");
	}else{
		$output="<input type='text' name='$preference->type' id='$preference->type' class='edit_preference' size='24' value='$preference->value'>";
	}
	print "<h4>$preference->name</h4><p>$preference->description<br/>$output <span id='stat$preference->type'></span></p>";
}

function displayMenu($list,$id,$value,$class=null){
	if($class!=null){
		$classText="class='$class'";
	}
	$output="<select id='$id' name='$id' $classText>";
	for($i=0;$i<count($list);$i++){
		$row=$list[$i];
		$output.="<option value='$row'";
		if($value==$row){
			$output.="selected";
		}
		$output.=">$row</option>";
	}
	$output.="</select>";
	return $output;
}

