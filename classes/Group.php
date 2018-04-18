<?php

/*
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'ListItem.php';

class Group extends ListItem {
	protected $db_table = "groups";
	protected $id_alias = "group_id";
	protected $group_name;
	protected $group_id;
} 