<?php

function mysql_timestamp ()
{
    return date('Y-m-d H:i:s');
}

/*
 * @function format_date @params $date date string @params $format string
 * description: this shouldn't be in this file, but I didn't want to create a
 * new file with general formatting tools yet.
 */
function format_date ($date, $format = "standard")
{
    // $format=mysql//yyyy-mm-dd
    // $format=standard//mm/dd/yyyy
    $date = str_replace("/", "-", $date);
    switch ($format) {
        case "mysql":
            $parts = explode("-", $date);
            $month = $parts[0];
            $day = $parts[1];
            $year = $parts[2];
            $date = "$year-$month-$day";
            break;
        case "standard":
            $parts = explode("-", $date);
            $year = $parts[0];
            $month = $parts[1];
            $day = $parts[2];
            $date = "$month/$day/$year";
            break;
        case "no-year":
            $parts = explode("-", $date);
            $year = $parts[0];
            $month = $parts[1];
            $day = $parts[2];
            $date = "$month/$day";
            break;
        default:
            $date = $date;
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

function format_time ($time, $showSeconds = false)
{
    $pm = substr_count($time, "PM");
    $am = substr_count($time, "AM");
    if ($pm || $am) {
        $outputFormat = 24;
    } else {
        $outputFormat = 12;
    }
    $time = str_ireplace("PM", "", $time);
    $time = str_ireplace("AM", "", $time);
    $parts = explode(":", trim($time));
    $hour = $parts[0];
    $minute = $parts[1];
    $seconds = $parts[2];

    if ($outputFormat == 12) {
        if ($hour > 12) {
            $hour = $hour - 12;
            $meridian = "PM";
        } else {
            $meridian = "AM";
        }
        $output = "$hour:$minute";
        if ($showSeconds) {
            $output .= ":$seconds";
        }
        $output .= " $meridian";
    } elseif ($outputFormat == 24) {
        if ($pm) {
            $hour += 12;
        }
        $output = "$hour:$minute";
        if ($showSeconds) {
            $output .= ":$seconds";
        }
    }

    return $output;
}

function format_timestamp ($timeStamp)
{
    $items = explode(" ", $timeStamp);
    $date = format_date($items[0], 'standard');
    $time = $items[1];
    if (count($items) > 2) {
        $time .= " " . $items[2];
    }
    $time = format_time($time);
    $output = "$date, $time";
    return $output;
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

/*
 * @params $table varchar table name @params $data array consisting of "where"
 * string or array, and "select" comma-delimited string @returns an array of
 * key-value pairs reflecting a Database primary key and human-meaningful string
 */
function get_keyed_pairs ($list, $pairs, $initialBlank = NULL, $other = NULL)
{
    $output = false;

    if ($initialBlank) {
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

/**
 *
 * @param string $glue
 * @param array $list
 * @param string $conjunction
 *            creates a list in proper English list format (lists less than 3
 *            have no comma, list with 3 or more have commas and final
 *            conjunction)
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
    return sprintf("$%s", number_format($value,2));
}

function get_as_float ($value)
{
    return money_format('#0n', $value);
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