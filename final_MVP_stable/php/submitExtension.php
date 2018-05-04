<?php

require 'database.php';

//$user_id= $_SESSION['user_id'];
//$module_id= $_POST['module_id'];
//$extension= $_POST['extension'];

$user_id= 48;
$module_id= "2";
$extension= 1;

$stmt= $mysqli->prepare("SELECT COUNT(*) FROM submit WHERE user_id=? and module_id=?");
if (!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array(
		"success" => false
	));
	exit;
}

$stmt->bind_param('is', $user_id, $module_id);
$stmt->execute();
$stmt->bind_result($exists);
$stmt->fetch();
$stmt->close();

if ($exists >0){
	$stmt= $mysqli->prepare("update submit 
													 set extension=? 
													 where user_id=? and module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}

	$stmt->bind_param('iis', $extension, $user_id, $module_id);
	$stmt->execute();
	$stmt->close();
}
else{
	$stmt= $mysqli->prepare("insert into submit (user_id, module_id, extension) values (?,?,?)");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}

	$stmt->bind_param('isi', $user_id, $module_id, $extension);
	$stmt->execute();
	$stmt->close();
}
	
?>
