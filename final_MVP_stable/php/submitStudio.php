<?php

require 'database.php';

//$user_id= $_SESSION['user_id'];
//$module_id= $_POST['module_id'];
//$studio= $_POST['studio'];

$user_id= 48;
$module_id= "2";
$studio= 1;

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
													 set studio=? 
													 where user_id=? and module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}

	$stmt->bind_param('iis', $studio, $user_id, $module_id);
	$stmt->execute();
	$stmt->close();
}
else{
	$stmt= $mysqli->prepare("insert into submit (user_id, module_id, studio) values (?,?,?)");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}

	$stmt->bind_param('isi', $user_id, $module_id, $studio);
	$stmt->execute();
	$stmt->close();
}
	
?>
