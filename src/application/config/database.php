<?php
$active_group = 'default';
$active_record = TRUE;



if(empty(getenv('MYSQL_HOST'))){
    exit('MYSQL_HOST was not defined');
}
if(empty(getenv('MYSQL_USER'))){
    exit('MYSQL_USER was not defined');
}
if(empty(getenv('MYSQL_PASS'))){
    exit('MYSQL_PASS not defined');
}
if(empty(getenv('MYSQL_DB'))){
    exit('MYSQL_DB not defined');
}
$db['default']['hostname'] = getenv('MYSQL_HOST');
$db['default']['username'] = getenv('MYSQL_USER');
$db['default']['password'] = getenv('MYSQL_PASS');
$db['default']['database'] = getenv('MYSQL_DB');

$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

