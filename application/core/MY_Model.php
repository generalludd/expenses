<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class MY_Model extends CI_Model
	{

		function __construct ()
		{
			parent::__construct ();
		}

		function _log ( $element = "alert" )
		{
			$last_query = $this->db->last_query ();
				$this->session->set_flashdata ( $element, $last_query );
		}
	}
