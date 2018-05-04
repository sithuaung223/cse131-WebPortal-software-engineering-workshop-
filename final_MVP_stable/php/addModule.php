<?php
session_start();

require 'database.php';
$moduleName = $_POST['moduleName'];
$moduleId = $_POST['moduleId'];
$assign_date = $_POST['assign_date'];
$due_date = $_POST['due_date'];
//$moduleName= 'fifty';
//$moduleId= 51;
//$assign_date = '04/05/2016';
//$due_date = '04/05/2016';

/*----------------modules---------------*/
$full_path = sprintf("/home/sithuaung/public_html/131website/resources/%s", $moduleId);
$relative_path= sprintf("resources/%s",$moduleId);
 
/*--------------module---------------*/
//query module table in Database
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM modules where module_id=?");
$stmt->bind_param('s', $moduleId);
$stmt->execute();
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array(
		"success" => false
	));
	exit;
}
$stmt->bind_result($exits);
$stmt->fetch();
$stmt->close();

if($exits){
	echo json_encode(array(
		"success" => false,
		"message" => "Module is already exits"
	));
	exit;
}
//insert module table in Database
$stmt= $mysqli->prepare("insert into modules (module_name, module_path, assign_date, due_date, module_id) values (?, ?, ?, ?, ?)");
if (!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

// upload file to File System and data to Database
$oldmask= umask(0);
if(mkdir($full_path,0777)){
	mkdir($full_path.'/labs');
	mkdir($full_path.'/videos');
	mkdir($full_path.'/studios');
	mkdir($full_path.'/extensions');
	mkdir($full_path.'/exercises');
	mkdir($full_path.'/goals');

	$stmt->bind_param('sssss', $moduleName, $relative_path, $assign_date, $due_date, $moduleId);
	$stmt->execute();
	$stmt->close();
	echo json_encode(array(
		"success" => true
	));
	umask($oldmask);
	exit;
}
else{
	echo json_encode(array(
		"success" => false
	));
	umask($oldmask);
	exit;
}
 
?>
