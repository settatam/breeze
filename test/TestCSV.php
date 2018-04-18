<?php

include '../vendor/autoload.php';
include '../helpers/functions.php';

class TestCSV extends PHPUnit_Framework_TestCase {

	public $file_name = 'test.csv';

	public function testVerifyCSV() {

		 $valid = verifyCSVFile($this->file_name);

		$this->assertTrue($valid, "The file has to have a csv extension");
	}

	public function testCheckValidHeader() {

		$group_header = ['group_id', 'group_name'];
		$type = "group";

		$valid = checkValidHeader($group_header, $type);

		$this->assertTrue($valid, "The header is not valid");
	}

	public function testCheckInteger() {

		$value = 5;
		
		$valid = checkInteger($value);
		
		$this->assertTrue($valid, "Value is not an integer");
	}
}