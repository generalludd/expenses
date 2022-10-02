<?php

/*
 * @function format_date @params $date date string @params $format string
 * description: this shouldn't be in this file, but I didn't want to create a
 * new file with general formatting tools yet.
 */
function format_date ($date, $format = "standard")
{
    switch ($format) {
        case "mysql":
					$date = date('Y-m-d',strtotime($date));
            break;
        case "standard":
        		$date = date('m/d/Y',strtotime($date));
            break;
        case "no-year":
					$date = date('m/d',strtotime($date));
            break;
        default:
    }
    return $date;
}

function last_day ($month, $year)
{
    switch ($month) {
        case 2:
            if ($year % 4 == 0) {
                $day = 29;
            } else {
                $day = 28;
            }
            break;
        case 4:
        case 6:
        case 9:
        case 11:
            $day = 30;
        default:
            $day = 31;
    }
    return $day;
}


function get_value ($object, $item, $default = null)
{
    $output = $default;

    if ($default) {
        $output = $default;
    }
    if ($object) {

        $var_list = get_object_vars($object);
        $var_keys = array_keys($var_list);
        if (in_array($item, $var_keys)) {
            $output = $object->$item;
        }
    }
    return $output;
}

function prepare_variables ($object, $variables)
{
    for ($i = 0; $i < count($variables); $i ++) {
        $myVariable = $variables[$i];
        if ($object->input->post($myVariable)) {
            $object->$myVariable = $object->input->post($myVariable);
        }
    }
}


/**
 * @param $list
 * @param $pairs
 * @param $initial_blank
 * @param $other
 *
 * @return array
 */
function get_keyed_pairs ($list, $pairs,  $initial_blank = FALSE,  $other = NULL) {
	$output = [];

    if ($initial_blank) {
        $output[] = "";
    }

    foreach ($list as $item) {
        $key_name = $pairs[0];
        $key_value = $pairs[1];
        $output[$item->$key_name] = $item->$key_value;
    }

    if ($other) {
        $output["other"] = "Other...";
    }

    return $output;
}

function get_account_pairs ($list, $initial_blank = NULL)
{
	$output = [];

	if ($initial_blank) {
		$output[] = "";
	}

	foreach ($list as $item) {
		$display_id = $item->id != $item->parent_id?' --' . $item->id:'' . $item->id;
		$output[$item->id] = $display_id . ' - ' . $item->name ;
	}

	return $output;
}


/**
 * creates a list in proper English list format (lists less than 3
 *            have no comma, list with 3 or more have commas and final
 *            conjunction)
 * @param $glue
 * @param $list
 * @param string $conjunction
 * @return string
 */
function grammatical_list ($glue, $list, $conjunction = "and")
{
    $output = $list;
    if (is_array($list)) {
        if (count($list) == 2) {
            $output = implode(" $conjunction ", $list);
        } else {
            for ($i = 0; $i < count($list); $i ++) {
                $prefix = "";
                if ($i + 1 == count($list)) {
                    $prefix = $conjunction;
                }
                $adjusted_list[] = $prefix . " " . $list[$i];
            }
            $output = implode($glue, $adjusted_list);
        }
    }
    return $output;
}

function get_as_cash ($value)
{
  $number_formatter = new NumberFormatter('en-US', NumberFormatter::CURRENCY);
  if($value === NULL){
    $value = 0;
  }
  return $number_formatter->format($value);
}

function get_as_float ($value)
{
  $number_formatter= new NumberFormatter('en-US', NumberFormatter::CURRENCY );
  if($value === NULL){
    $value = 0;
  }
  return $number_formatter->format($value);
}

function get_status ($status)
{
    $output = "Inactive";
    if ($status == 1) {
        $output = "Active";
    }
    return $output;
}

function get_current_month()
{
    $month = date("n");
    $year = date("Y");

    //if we're past the 15th go to the next month
    if (date('j') > 15) {
        $month = $month + 1;
    }
    //if we're past december, go to january
    if ($month > 12) {
        $month = 1;
    }
    //if it's january go to the next year and the current month is still december
    if ($month == 1 && date("n") == 12) {
        $year = $year + 1;
    }

    return array("month"=>$month, "year"=>$year);
}

function get_next_month ($month, $year)
{
    $new_year = $year;
    $new_month = $month + 1;
    // if the supplied month is december, go to january
    if ($new_month > 12) {
        $new_month = 1;
    }
    // if the month is January, go to the next year.
    if ($new_month == 1){
        $new_year = $year + 1;
    }
    return array("month"=>$new_month, "year"=>$new_year);
}

function get_previous_month($month, $year)
{
    $new_year = $year;
    $new_month = $month -1;

    //if the month is less than January, it's december
    if($new_month == 0){
        $new_month = 12;
    }
    if($new_month == 12){
        $new_year = $year - 1;
    }

    return array("month"=>$new_month, "year"=>$new_year);

}


function print_array($array){
	
	$output[] = '<ul>';
	if(is_array($array) || is_object($array)){
		//for($i=0; $i<count($array);$i++){
		foreach($array as $item){
			if(is_array($item) || is_object($array)){
				$output[] = print_array($item);
			}else{
				$output[] = "<li>" . $item . "</li>";
			}
		}
	}else{
		$output[] = $array; 
	}
	$output[] = "</ul>";
	
	return implode("\r", $output);
}

function cached_base_url($path){
    $output = sprintf("%s?cache=%s", base_url($path), date('U'));
    return $output;
}

function format_month($month, $year){
	if($month < 10){
		$month = '0' . $month;
	}
$date = strtotime($year . '-' . $month . '-01 00:00:00');
return date('M. Y', $date);
}


function get_defaults($source){
	$default_date = get_current_month();
	$default_year = $default_date["year"];
	$default_month = $default_date["month"];

	if ((int) $source->session->userdata("mo") && (int) $source->session->userdata("yr")) {
		$default_year = $source->session->userdata("yr");
		$default_month = $source->session->userdata("mo");
	}
	return [ $default_month, $default_year];
}
