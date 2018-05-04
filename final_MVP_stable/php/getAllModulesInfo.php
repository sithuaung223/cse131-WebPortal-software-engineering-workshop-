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


	// get names of all modules with id
	$stmt = $mysqli->prepare("SELECT assign_date, due_date, module_id, module_name, module_path FROM modules");
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($assign_date, $due_date, $id, $name, $path);
	$modules= array();

	while ($stmt->fetch()){
			$module= array(
				"module_id" => $id,
				"module_name" => $name,
				"module_path" => $path,
				"assign_date" => $assign_date,
				"due_date" => $due_date,
				"complete" => false
			);	
		array_push($modules, $module);
	}
	$stmt->close();

	//get course progress 
	$stmt= $mysqli->prepare("select module_id   
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
	$stmt->bind_result($module_id);

	while ($stmt->fetch()){
		for($i=0; $i< count($modules); $i++){
			if($modules[$i]["module_id"] == $module_id){
				$modules[$i]["complete"] = true;
			}
		}
	}
	$stmt->close();

	/* ===============================================================*/
	/* get current module info + progress */
	//TODO: implement progress
	$stmt = $mysqli->prepare("SELECT module_id FROM modules where current=1");
	$stmt->execute();
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$stmt->bind_result($moduleId);
	$stmt->fetch();
	$stmt->close();
	
	$stmt = $mysqli->prepare("SELECT module_name FROM modules where module_id=?");
	$stmt->bind_param('s', $moduleId); $stmt->execute();
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
	$stmt = $mysqli->prepare("SELECT video_name, video_path FROM videos where module_id=?");
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

	$currentModule= array(
		"module_name" => $moduleName, //change this
	  "goals_and_resources" => nullpathToPlaceholder($goalPath), //change this	
		"exercises" =>nullpathToPlaceholder($exercisePath), //change this
		"studios" => nullpathToPlaceholder($studioPath),
		"labs" =>nullpathToPlaceholder($labPath),
		"extensions" => nullpathToPlaceholder($extensionPath), //change this
		"videos" => $videos
	);
	/* ===============================================================*/

	// get current moudle progress
	$stmt= $mysqli->prepare("SELECT COUNT(*) FROM submit WHERE user_id=? and module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}

	$stmt->bind_param('is', $userId, $moduleId);
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

		$stmt->bind_param('is', $userId, $moduleId);
		$stmt->execute();
		$stmt->bind_result($exercise, $extension, $lab, $studio);
		$stmt->fetch();
		$stmt->close();
	}
	else {
		$exercise=0;
		$extension=0;
		$lab=0;
		$studio=0;
	}
	$progress= array(
		"exercise"=> $exercise,
		"extension"=> $extension,
		"lab"=> $lab,
		"studio" => $studio);
	$currentModule["progress"]= $progress;
	

	// spit the results in json format
	echo json_encode(array(
		"success"=> true,
		"student"=> $username,
		"modules"=> $modules,
		"currentModule" => 	$currentModule,
		"goals_and_resources" => "use an abstract data type such a list understand how to generate equals and (to some extent) hashCodebecome more comfortable with designing objects based on stories"
	));
function nullpathToPlaceholder($path){
	if($path== null){
		$path= 'resources/placeholder.html';
	}
return $path;
}
?>
