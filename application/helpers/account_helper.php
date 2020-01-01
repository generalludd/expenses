<?php


function get_account_parent($id, $parents){
	$output = 0;
	foreach($parents as $parent){
		if($id > $parent){
			$output = $parent;
		}
	}
	return $output;
}
