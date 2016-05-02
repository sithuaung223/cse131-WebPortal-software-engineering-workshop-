<?php
session_start();

require 'database.php';

$moduleId = $_POST['moduleId'];
$moduleName = $_POST['moduleName'];
//$moduleId = 2;
//$moduleName ="changed";
 
//query Videos table in Database
$stmt= $mysqli->prepare("update modules set module_name=? where module_id=?");
if (!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

	$stmt->bind_param('ss', $moduleName, $moduleId);
	$stmt->execute();
	$stmt->close();
	echo json_encode(array(
		"success" => true
	));
	exit;
 
?>
