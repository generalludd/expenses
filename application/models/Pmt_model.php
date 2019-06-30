<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// payment_model.php Chris Dart Mar 11, 2012 4:23:41 PM chrisdart@cerebratorium.com

class Pmt_model extends MY_Model
{

	var $user_id;
	var $fee_id;
	var $date_paid;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array('user_id','fee_id','date_paid');
		prepare_variables($this, $variables);
		if($this->date_paid){
			$this->date_paid = format_date($this->date_paid, 'mysql');
		}
	}


	function update($id)
	{

		$this->db->where('id', $id);
		$this->prepare_variables();
		$this->db->update('pmt', $this);
		return $this->get($id);
	}

	function insert()
	{
		$this->prepare_variables();
		$this->db->insert('pmt', $this);
		$id = $this->db->insert_id();
		return $id;
	}

	function delete($id){
		$this->db->where('id',$id);
		$this->db->delete('pmt');
	}

	function get($id)
	{
		$this->db->where('id',$id);
		$this->db->from('pmt');
		$this->db->join('fee','pmt.fee_id = fee.id');
		$result = $this->db->get()->row();
		$this->_log();
		return $result;
	}

	function get_for_user($user_id, $param = array())
	{
		if(array_key_exists( 'mo', $param)){
			$this->db->where('fee.mo',$param['mo']);
		}
		if(array_key_exists( 'yr',$param)){
			$this->db->where('fee.yr', $param['yr']);
		}
		$this->db->where('user_id', $user_id);
		$this->db->join('fee','fee.id = pmt.fee_id');
		$this->db->order_by('mo','DESC');
		$this->db->order_by('yr','DESC');
		$this->db->from('pmt');
		$result = $this->db->get()->result();
		return $result;
	}
}
