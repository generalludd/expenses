<?php
$config["mailpath"] = getenv('EXP_MAILPATH');
$config['protocol'] = 'smtp';
$config['smtp_host'] = getenv('EXP_EMAIL_HOST');
$config['smtp_port'] = getenv('EXP_EMAIL_PORT');
$config['smtp_crypto'] = '';
$config['smtp_user'] = getenv('EXP_EMAIL_USER');
$config['smtp_pass'] = getenv('EXP_EMAIL_PASS');
$config["newline"] = "\r\n";
$config["charset"] = "utf-8";