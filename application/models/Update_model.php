<?php


class Update_model extends My_Model {


	function __construct() {
		parent::__construct();
		$this->install_table();
	}

	function install_table() {
			$this->load->dbforge();
			$fields = [
				'id' => [
					'type' => 'INT',
					'constraint' => 9,
					'unsigned' => TRUE,
				],
				'description' => [
					'type' => 'VARCHAR',
					'constraint' => 255,
				],
				'rec_modified' => [
					'type' => 'timestamp',
				],
			];
			$attr = ['engine' => 'InnoDB'];
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table('updates', TRUE, $attr);
	}

	/**
	 * @param array $updates
	 */
	function run_updates(array $updates) {
		foreach ($updates as $update) {
			$update = (object) $update;
			if ($this->update_exists($update->id) === 0) {
				$result = $this->db->query($update->query);
				if ($result) {
					$this->db->insert('updates', [
						'id' => $update->id,
						'description' => $update->description,
					]);
				}
			}

		}
	}

	function update_exists($id) {
		$this->db->from('updates');
		$this->db->where('id', $id);
		return $this->db->get()->num_rows();
	}

}
