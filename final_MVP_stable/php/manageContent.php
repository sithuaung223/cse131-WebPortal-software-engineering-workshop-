<?php
session_start();
	require 'database.php';
	//$userId= $_SESSION['user_id'];
  $userId= 45;

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

	// get all module_id
	$stmt = $mysqli->prepare("SELECT module_id, module_name FROM modules");
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($module_id, $name);
	$modules= array();
	while ($stmt->fetch()){
		$module= array(
			"module_id" => $module_id,
			"module_name" => $name
		);
		array_push($modules, $module);

	}
	$stmt->close();


	for ($i=0; $i< count($modules); $i++){
		$moduleId= $modules[$i]["module_id"];

		/*--------------Video---------------*/
		$stmt = $mysqli->prepare("SELECT video_name, video_path FROM videos where module_id=?");
		$stmt->bind_param('s', $moduleId);
		$stmt->execute();
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			echo json_encode(array(
				"success" => false
			));
			exit;
		}
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
		$stmt = $mysqli->prepare("SELECT studio_path, studio_name FROM studios where module_id=?");
		$stmt->bind_param('s', $moduleId);
		$stmt->execute();
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			echo json_encode(array(
				"success" => false
			));
			exit;
		}
		$stmt->bind_result($studioPath, $studioName);
		$stmt->fetch();
		$stmt->close();

		/*--------------lab---------------*/
		$stmt = $mysqli->prepare("SELECT lab_path, lab_name FROM labs where module_id=?");
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
		$stmt->bind_result($labPath, $labName);
		$stmt->fetch();
		$stmt->close();

		/*--------------goal---------------*/
		$stmt = $mysqli->prepare("SELECT goal_path, goal_name FROM goals where module_id=?");
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
		$stmt->bind_result($goalPath, $goalName);
		$stmt->fetch();
		$stmt->close();

		/*--------------exercise---------------*/
		$stmt = $mysqli->prepare("SELECT exercise_path, exercise_name FROM exercises where module_id=?");
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
		$stmt->bind_result($exercisePath, $exerciseName);
		$stmt->fetch();
		$stmt->close();

		/*--------------extension---------------*/
		$stmt = $mysqli->prepare("SELECT extension_path, extension_name FROM extensions where module_id=?");
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
		$stmt->bind_result($extensionPath, $extensionName);
		$stmt->fetch();
		$stmt->close();

		$modules[$i]["goals_and_resources"]= $goalName;
		$modules[$i]["exercises"]= $exerciseName;
		$modules[$i]["studios"]= $studioName;
		$modules[$i]["labs"]= $labName;
		$modules[$i]["extensions"]= $extensionName;
		$modules[$i]["videos"]= $videos;
	}


	/* ===============================================================*/

	// spit the results in json format
	echo json_encode(array(
		"success"=> true,
		"username"=> $username,
		"modules"=> $modules,
	));
?>
