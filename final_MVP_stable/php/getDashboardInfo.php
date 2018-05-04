<?php
session_start();
require 'database.php';
	$userId= $_SESSION['user_id'];

	$stmt = $mysqli->prepare("SELECT user_name FROM users where user_id=?");
	$stmt->bind_param('s', $userId);
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($username);
	$stmt->fetch();
	$stmt->close();

	// get names of all modules with id
	$stmt = $mysqli->prepare("SELECT module_id, module_name, module_path FROM modules");
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($id, $name, $path);
	$modules= array();
	while ($stmt->fetch()){
			$module= array(
				"module_id" => $id,
				"module_name" => $name,
				"module_path" => $path,
			);	
		array_push($modules, $module);
	}

	$stmt->close();

	//get course progress 
	$stmt= $mysqli->prepare("select count(*)   
													 from submit
													 where user_id=? and exercise=1 and lab=1 and studio=1");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}

	$stmt->bind_param('i', $userId);
	$stmt->execute();
	$stmt->bind_result($progress);
	$stmt->fetch();
	$stmt->close();

	$percentage = $progress*10;
	//TODO make percentage,student_level and picture dynamic	
	echo json_encode(array(
		"success"=> true,
		"student"=> $username,
		"percentage"=> $percentage,
		"student_level"=> getLevel($percentage),
		"pic"=>"https://upload.wikimedia.org/wikipedia/commons/f/ff/JAA_3538-2.jpg"	,
		"modules" => $modules
	));

function getLevel($percent){
	if($percent == 0){
		$level= 'beginner';
	}else if($percent <40){
		$level= 'journey man';
	}else if($percent <70){
		$level= 'mega man';
	}else{
		$level= 'master';
	}

return $level;
}
?>
