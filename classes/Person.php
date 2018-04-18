<?php

/*
*/

require_once 'ListItem.php';

class Person extends ListItem {

	protected $db_table = "persons";
	protected $id_alias = "person_id";
	protected $first_name;
	protected $last_name;
	protected $email_address;
	protected $group_id;
	protected $state;
	protected $person_id;

	public static function getAllActive() {
		$query = "SELECT * FROM persons p INNER JOIN groups  g ON p.group_id = g.group_id AND p.state = 'active' ORDER BY p.first_name ASC";

		$dbh = Database::Init();
		$result = $dbh->pdo->query($query);
		//$result = $dbh->fetchAll();
		return $result->fetchAll();
	}

} 