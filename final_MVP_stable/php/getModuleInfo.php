<?php
session_start();
	require 'database.php';

	$userId= $_SESSION['user_id'];
	//$userId= 45;

	// get username
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

	$moduleId= $_POST['modulename'];
	/*--------------module---------------*/
	$stmt = $mysqli->prepare("SELECT module_name FROM modules where module_id=?");
	$stmt->bind_param('s', $moduleId);
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($moduleName);
	$stmt->fetch();
	$stmt->close();

	/*--------------Video---------------*/
	$stmt = $mysqli->prepare("SELECT video_name, video_path FROM videos where module_id=? order by video_id asc");
	// Bind the parameter
	$stmt->bind_param('s', $moduleId);
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	// Bind the results
	$stmt->bind_result($videoName, $videoPath);
	$videos= array();
	while($stmt->fetch()){
	  $video= array(
		"name" => $videoName,
		"url" => $videoPath,
		);
		array_push($videos, $video);
	 }
	$stmt->close();

	/*--------------Studio---------------*/
	$stmt = $mysqli->prepare("SELECT studio_path FROM studios where module_id=?");
	$stmt->bind_param('s', $moduleId);
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($studioPath);
	$stmt->fetch();
	$stmt->close();

	/*--------------lab---------------*/
	$stmt = $mysqli->prepare("SELECT lab_path FROM labs where module_id=?");
	// Bind the parameter
	$stmt->bind_param('s', $moduleId);
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($labPath);
	$stmt->fetch();
	$stmt->close();

	/*--------------goal---------------*/
	$stmt = $mysqli->prepare("SELECT goal_path FROM goals where module_id=?");
	// Bind the parameter
	$stmt->bind_param('s', $moduleId);
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($goalPath);
	$stmt->fetch();
	$stmt->close();

	/*--------------exercise---------------*/
	$stmt = $mysqli->prepare("SELECT exercise_path FROM exercises where module_id=?");
	// Bind the parameter
	$stmt->bind_param('s', $moduleId);
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($exercisePath);
	$stmt->fetch();
	$stmt->close();

	/*--------------extension---------------*/
	$stmt = $mysqli->prepare("SELECT extension_path FROM extensions where module_id=?");
	// Bind the parameter
	$stmt->bind_param('s', $moduleId);
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($extensionPath);
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

	/*-send all data(videos, studios and labs) back with json-*/
	echo json_encode(array(
		"success" => true,
		"student" => $username,
		"module_name" => $moduleName, //change this
	  "goals_and_resources" => nullpathToPlaceholder($goalPath), //change this	
		"exercises" => nullpathToPlaceholder($exercisePath), //change this
		"studios" => nullpathToPlaceholder($studioPath),
		"labs" => nullpathToPlaceholder($labPath),
		"extensions" => nullpathToPlaceholder($extensionPath), //change this
		"videos" => $videos,
		"modules" => $modules
	));
	exit;
function nullpathToPlaceholder($path){
if($path == null){
	$path= 'resources/placeholder.html';
}
return $path;
}
 
?>
