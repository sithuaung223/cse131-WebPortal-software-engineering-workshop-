<?php

require 'database.php';

//$user_id= $_SESSION['user_id'];
//$module_id= $_POST['module_id'];

$user_id= 45;
$module_id= "module2";

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
	$stmt= $mysqli->prepare("select exercise, extension, lab, studio 
													 from submit
													 where user_id=? and module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}

	$stmt->bind_param('is', $user_id, $module_id);
	$stmt->execute();
	$stmt->bind_result($exercise, $extension, $lab, $studio);
	$stmt->fetch();
	$stmt->close();

	echo json_encode(array(
		"exercise"=> $exercise,
		"extension"=> $extension,
		"lab"=> $lab,
		"studio"=> $studio
	));
}
else{
	$exercise=0;
	$extension=0;
	$lab=0;
	$studio=0;

	echo json_encode(array(
		"exercise"=> $exercise,
		"extension"=> $extension,
		"lab"=> $lab,
		"studio"=> $studio
	));
}
	
?>
