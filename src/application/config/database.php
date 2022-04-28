<?php
$active_group = 'default';
$active_record = TRUE;



if(empty(getenv('EXP_HOST'))){
    exit('EXP_HOST was not defined');
}
if(empty(getenv('EXP_USER'))){
    exit('EXP_USER was not defined');
}
if(empty(getenv('EXP_PASS'))){
    exit('EXP_PASS not defined');
}
if(empty(getenv('EXP_DB'))){
    exit('EXP_DB not defined');
}
$db['default']['hostname'] = getenv('EXP_HOST');
$db['default']['username'] = getenv('EXP_USER');
$db['default']['password'] = getenv('EXP_PASS');
$db['default']['database'] = getenv('EXP_DB');

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

