<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logging_Model extends MY_Model {

	var $event_type;

	var $event;

	var $timestamp;

	function __construct() {
		parent::__construct();
		$this->install_table();
	}

	function install_table() {
		$this->load->dbforge();
		$fields = [
			'id' => [
				'type' => 'INT',
				'constraint' => 3,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			],
			'event_type' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
			],
			'event' => [
				'type' => 'text',
				'unsigned' => TRUE,
			],
			'timestamp' => [
				'type' => 'timestamp',
			],
		];
		$attr = ['engine' => 'InnoDB'];
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('log', TRUE, $attr);
	}

	function get_latest($event_type) {
		$this->db->where("event_type", $event_type);
		$this->db->order_by("timestamp", "DESC");
		$this->db->limit(1);
		$this->db->select("UNIX_TIMESTAMP(`timestamp`) as `unix_time`", FALSE);
		$this->db->select("log.*");
		$this->db->from("log");
		$result = $this->db->get()->row();

		return $result;
	}


	function log($event_type, $event) {
		$tables = $this->db->list_tables();
		var_dump($tables);
/*		$this->event_type = $event_type;
		$this->event = $event;
		$this->timestamp = date("Y-m-d H:i:s");
		$this->db->insert("log", $this);*/

	}

}
