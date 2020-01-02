<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class MY_Model extends CI_Model
	{

		function __construct ()
		{
			parent::__construct ();
		}

		function _log ( $element = "alert" ) {
			if ($this->config->item('base_url') == 'http://docker.test' || $this->input->get('debug')){
				$last_query = $this->db->last_query();
				$this->session->set_flashdata($element, $last_query);
			}
		}
	}
