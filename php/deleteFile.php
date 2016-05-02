<?php
session_start();

require 'database.php';

$moduleId = $_POST['moduleId'];
$fileName = $_POST['fileName'];
$category = $_POST['category']; 
//$moduleId = 3;
//$fileName = "Login";
//$category = "exercise";

 
if($category== "" || $moduleId =="" || $fileName==""){
		echo json_encode(array(
			"success" => false
		));
		exit;
}
	// Use a prepared statement
		$stmt = $mysqli->prepare("SELECT ".$category."_path FROM ".$category."s where ".$category."_name=? and module_id=?");
		$stmt->bind_param('si', $fileName, $moduleId);
		$stmt->execute();
		$stmt->bind_result($relative_path);
		$stmt->fetch();
		$stmt->close();

	/*-----delete studio path in FileSystem------*/
	$full_path= "/home/sithuaung/public_html/131website/".$relative_path;
	
	if (unlink($full_path)){
		$stmt= $mysqli->prepare("delete from ".$category."s where ".$category."_name=? and module_id=?");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->bind_param('si', $fileName, $moduleId);
		$stmt->execute();
		$stmt->close();
		echo json_encode(array(
			"success" => true
		));
		exit;
	}
	else{
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
?>
