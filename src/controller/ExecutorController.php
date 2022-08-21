<?php
require_once 'config/database.php';

class ExecutorController {

	public function __construct() {
		$this->db = new Database();
	}

	public function doit($sql){
		$con = $this->db->get_connect();
		return array($con->query($sql),$con->insert_id);
	}
}
?>