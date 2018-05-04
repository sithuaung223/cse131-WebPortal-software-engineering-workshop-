<?php
session_start();
require 'database.php';

//get fileName and moduleName from Ajax
$filename = $_FILES['SelectedFile']['name'];

$moduleId = $_POST['moduleId'];
$category=$_POST['category'];
//$category= 'video';
//$moduleId =1;

/*Studio, Extension, Lab and  Exercise*/
$full_path = sprintf("/home/sithuaung/public_html/131website/resources/%s/".$category."s/%s", $moduleId, $filename);
$relative_path = sprintf("resources/%s/".$category."s/%s", $moduleId, $filename);
 
//query Videos table in Database
$stmt= $mysqli->prepare("insert into ".$category."s (".$category."_name, ".$category."_path, module_id) values (?, ?, ?)");
if (!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

// upload file to File System and data to Database
if( move_uploaded_file($_FILES['SelectedFile']['tmp_name'], $full_path) ){
	$stmt->bind_param('sss', substr($filename, 0, strpos($filename,'.')), $relative_path, $moduleId);
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
