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

	function insert($fee_id, $user_id)
	{
		$values = [
			'fee_id'=>$fee_id,
			'user_id'=>$user_id,
			'date_paid' => mysql_timestamp(),
		];
		$this->db->insert('pmt', $values);
		$id = $this->db->insert_id();
		return $id;
	}

	function delete($id){
		$this->db->where('id',$id);
		$this->db->delete('pmt');
	}

	function get($id)
	{
		$this->db->where('pmt.id',$id);
		$this->db->from('pmt');
		$this->db->join('fee','pmt.fee_id = fee.id');
		$result = $this->db->get()->row();
		$this->_log();
		return $result;
	}

	function get_for_user($user_id, $param = array())
	{
		$user_count = 2;
		if(array_key_exists( 'mo', $param)){
			$month = $param['mo'];
			$this->db->where('fee.mo',$month);
		}
		if(array_key_exists( 'yr',$param)){
			$year = $param['yr'];
			$this->db->where('fee.yr', $year);
		}

		$this->db->join('pmt','fee.id = pmt.fee_id AND pmt.user_id = ' . $user_id,'LEFT OUTER');
		$this->db->order_by('mo','DESC');
		$this->db->order_by('yr','DESC');
		$this->db->select('pmt.date_paid, fee.mo, fee.yr, fee.id as fee_id, pmt.id as pmt_id');
		$this->db->select('`fee`.`amt`/' . $user_count . ' as amt',FALSE);
		$this->db->from('fee');
		$result = $this->db->get()->result();
		return $result;
	}
}
