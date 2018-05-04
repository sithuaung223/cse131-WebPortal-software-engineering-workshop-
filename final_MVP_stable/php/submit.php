<?php

require 'database.php';

//TODO
$username= $_POST['username'];
$module_id= $_POST['module_id'];
$exercise= stringToBool($_POST['exercise']);
$extension= stringToBool($_POST['extension']);
$lab= stringToBool($_POST['lab']);
$studio= stringToBool($_POST['studio']);
//
//$username= 'oceanwool';
//$module_id= "1";
//$exercise= stringToBool('true');
//$extension= stringToBool('true');
//$lab = stringToBool('true');
//$studio= stringToBool('true');

$stmt= $mysqli->prepare("SELECT user_id  FROM users WHERE user_name=?");
if (!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array(
		"success" => false
	));
	exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

$stmt= $mysqli->prepare("SELECT COUNT(*)  FROM submit WHERE user_id=? and module_id=?");
if (!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array(
		"success" => false
	));
	exit;
}

$stmt->bind_param('ii', $user_id, $module_id);
$stmt->execute();
$stmt->bind_result($exists);
$stmt->fetch();
$stmt->close();

if ($exists >0){
	$stmt= $mysqli->prepare("update submit 
													 set exercise=?, extension=?, lab=?, studio=?
													 where user_id=? and module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}

	$stmt->bind_param('iiiiii', $exercise,$extension, $lab, $studio,  $user_id, $module_id);
	$stmt->execute();
	$stmt->close();

	echo json_encode(array(
		"success" => true,
		"message" => $exercise.$extension.$lab.$studio
	));
	exit;
}
else{
	$stmt= $mysqli->prepare("insert into submit 
													(user_id, module_id, exercise, extension, lab, studio) 
													values (?,?,?,?,?,?)");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}

	$stmt->bind_param('iiiiii', $user_id, $module_id, $exercise, $extension, $lab, $studio );
	$stmt->execute();
	$stmt->close();
	echo json_encode(array(
		"success" => true,
		"message" => $exercise.$extension.$lab.$studio
	));
	exit;
}
function stringToBool($string){
$bool= false;
if($string == 'true'){
$bool= true;
}

return $bool;
}
	
?>
