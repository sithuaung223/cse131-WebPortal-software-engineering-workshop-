<?php
/*-----Studio------*/
function deleteStudioDB($moduleName,$filename){
	require 'database.php';
	/*-----query studio path from videos table in Database------*/
	$stmt = $mysqli->prepare("SELECT studio_path FROM studios where studio_name=? and module_name=?");

	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	// Bind the parameter
	$stmt->bind_param('ss', $filename, $moduleName);
	$stmt->execute();
	// Bind the results
	$stmt->bind_result($full_path);
	$stmt->fetch();
	$stmt->close();

	/*-----delete studio path in Database------*/
	$stmt= $mysqli->prepare("delete from studios where studio_path=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
}

function deleteStudioFS($moduleId,$filename){
	/*-----delete studio path in FileSystem------*/
	$full_path= sprintf("resources/%s/studios/%s", $moduleId, $filename);
	if (unlink($full_path)){
		$stmt->bind_param('s', $full_path);
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
}


/*-----Lab------*/
function deleteLab($moduleName,$filename){
	require 'database.php';
	/*-----query video path from videos table in Database------*/
	$stmt = $mysqli->prepare("SELECT lab_path FROM labs where lab_name=? and module_name=?");

	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	// Bind the parameter
	$stmt->bind_param('ss', $filename, $moduleName);
	$stmt->execute();
	// Bind the results
	$stmt->bind_result($full_path);
	$stmt->fetch();
	$stmt->close();

	/*-----delete lab path in Database------*/
	$stmt= $mysqli->prepare("delete from labs where lab_path=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	/*-----delete lab path in FileSystem------*/
	if (unlink($full_path)){
		$stmt->bind_param('s', $full_path);
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
}

/*-----Video------*/
function deleteVideo($moduleName,$filename){
	require 'database.php';
	/*-----query video path from videos table in Database------*/
	$stmt = $mysqli->prepare("SELECT video_path FROM videos where video_name=? and module_name=?");

	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	// Bind the parameter
	$stmt->bind_param('ss', $filename, $moduleName);
	$stmt->execute();
	// Bind the results
	$stmt->bind_result($full_path);
	$stmt->fetch();
	$stmt->close();

	/*-----delete video path in Database------*/
	$stmt= $mysqli->prepare("delete from videos where video_path=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	/*-----delete video path in FileSystem------*/
	if (unlink($full_path)){
		$stmt->bind_param('s', $full_path);
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
