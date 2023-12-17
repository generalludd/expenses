<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Backup extends MY_Controller{
	
	
	function __construct(){
		parent::__construct();
		$this->load->model('logging_model','logging');
	}
	
	function index(){
		// Load the DB utility class
		$this->load->dbutil();
		$dbs = $this->dbutil->list_databases();
		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup();
		$filename = sprintf('%s-%s.sql.gz',gethostname(), date('Y-m-d-H-i-s'));
		$path = sprintf('/tmp/');
		$temp_file = $path . $filename;
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file($temp_file, $backup);
		$this->logging->log('backup','success');
		$this->session->set_flashdata('notice','Move the file backup file from your downloads folder to your backups folder.');
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
	  force_download($filename, $backup);
		redirect('home');
	}
	
	
}
