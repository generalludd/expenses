<?php

switch($_SERVER['HTTP_HOST']){
	case 'docker.test':
	case 'backoffice.test':
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'mailhog';
	$config['smtp_port'] = '1024';
	$config['smtp_crypto'] = '';
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		break;
	default:

		break;
}
