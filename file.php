<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'helpers/functions.php';
include 'classes/Person.php';
include 'classes/Group.php';

$target_dir = "uploads/";
$target_file = $target_dir . time().".csv";

$type = $_GET['type'];

if(verifyCSVFile($_FILES["uploadFile"]["name"])) {
	$heading = [];
	if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) {
		$row = 1;
	if (($handle = fopen($target_file, "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	    	if($row == 1) {
	    		if(checkValidHeader($data, $type))  {
	    			$heading = $data;
	    		}else{
	    			$error[] = "The header is not valid";
	    			$row++;
	    			continue;
	    		}
	    	}else{
	    		$input = processData($heading, $data);
	    		$object = $type == "groups" ? new Group($input) : new Person($input);	    		
	    		if($object->firstOrNew($input)) {

	    			//Successful enrty
	    		}else{
	    			//Log Failure
	    			$error[] = "Insert was not successful";
	    		}
	    	}
	        
	        $num = count($data);
	        $row++;
	    }
	    fclose($handle);
	 }
       
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}else{
	die("Please upload a csv file");
}

include 'user_data.php';
