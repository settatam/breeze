<?php

require_once 'Database.php';

abstract class ListItem implements arrayaccess {

	protected $db_table;
	protected $id;
	protected $result;

	public function __construct($memberArray =array(), $load=false) {
		if(is_array($memberArray)) {
			foreach($this as $key => $value) {
				if($key == 'db_table') continue;
				if($key == 'result') continue;

			}
		}else{
			$this->id = $memberArray;
		}

		if($load && isset($this->id)) {
			$this->load();
		}
	}

	public function load() {
		$query = "SELECT * FROM $this->db_table where id = $1";
	}
}
