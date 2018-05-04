<?php
session_start();
require 'database.php';

$moduleId = $_POST['moduleId'];
$date= $_POST['date'];
$dateType= $_POST['dateType'];
//$moduleId= '9';
//$dateType= 'assign';
//$date= '04/05/2016';

//query Videos table in Database
$stmt= $mysqli->prepare("update modules set ".$dateType."_date=? where module_id=?");
if (!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

	$stmt->bind_param('si', $date, $moduleId);
	$stmt->execute();
	$stmt->close();
	echo json_encode(array(
		"success" => true
	));
	exit;
 
?>
