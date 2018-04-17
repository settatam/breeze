<?php
$target_dir = "uploads/";
$target_file = $target_dir . time().".csv";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if($imageFileType =="csv") {
	if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) {

		$row = 1;
	if (($handle = fopen($target_file, "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	    	if($row == "") $heading = $data; 
	        $num = count($data);
	        //get count of data
	        //form array 
	        //persist array
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
