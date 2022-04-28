<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

// Load the envelope file for secrets if the file exists. 

$hook['pre_system'] = function () {
    $env_path = __DIR__.'/../../../../.env';
    if(file_exists($env_path)){
        $dotenv = new Symfony\Component\Dotenv\Dotenv();
        $dotenv->load($env_path);
    }
};


/* End of file hooks.php */
/* Location: ./application/config/hooks.php */