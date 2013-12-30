<?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");
/*********************************************************************
This is a sample email default. 
you can add your own information and comment out the fields as needed. 
then copy the file and rename "email.php"
*********************************************************************/


$config["mailpath"] = "sendmail";
//$config["protocol"] = "smtp";
//$config["smtp_host"] = "";
$config["smtp_auth"] = FALSE;
$config["smtp_port"] = 25;
//$config["smtp_user"] = "";
//$config["smtp_pass"] = "";
$config["newline"] = "\r\n";
$config["charset"] = "utf-8";