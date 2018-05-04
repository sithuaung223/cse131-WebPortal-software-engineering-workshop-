<?php
/*populate all files data to Database*/

	//get moudles from resoures directory
	$dir= sprintf("/home/sithuaung/public_html/131website/resources/");
	$dh= opendir($dir);

	//store all modules in modules array
	while (false !== ($moduleId = readdir($dh))) {
		$modules[] = $moduleId;
	}
	sort($modules);

	//loop through each module
	for ($i= 2; $i< count($modules); $i++){
		filesToDatabase($modules[$i]);
	}

	echo json_encode(array(
		"success" => true
	));
	exit;

//input: module name
//output: populate all files data of module to Database
function filesToDatabase ($moduleId){
	require 'database.php';

/*--------extensions----------*/
	//get Labs files from moudule directory
	$Extensiondir= sprintf("/home/sithuaung/public_html/131website/resources/%s/extensions",$moduleId);
	$Extensiondh= opendir($Extensiondir);

	// store all Labs files in an array
	while (false !== ($filename = readdir($Extensiondh))) {
		$Extensionfiles[] = $filename;
	}
	sort($Extensionfiles);

	//loop through Labs files array and update each Labs file data to Database 
	for ($i= 2; $i< count($Extensionfiles); $i++){
		$stmt= $mysqli->prepare("insert into extensions (extension_name, extension_path, module_id) values (?, ?, ?)");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
	  $extension_path= sprintf("resources/%s/extensions/%s",$moduleId,$Extensionfiles[$i]);
		$stmt->bind_param('sss', $Extensionfiles[$i], $extension_path, $moduleId);
		$stmt->execute();
		$stmt->close();
	}

/*--------goals----------*/
	//get Labs files from moudule directory
	$Goaldir= sprintf("/home/sithuaung/public_html/131website/resources/%s/goals",$moduleId);
	$Goaldh= opendir($Goaldir);

	// store all Labs files in an array
	while (false !== ($filename = readdir($Goaldh))) {
		$Goalfiles[] = $filename;
	}
	sort($Goalfiles);

	//loop through Labs files array and update each Labs file data to Database 
	for ($i= 2; $i< count($Goalfiles); $i++){
		$stmt= $mysqli->prepare("insert into goals (goal_name, goal_path, module_id) values (?, ?, ?)");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
	  $goal_path= sprintf("resources/%s/goals/%s",$moduleId,$Goalfiles[$i]);
		$stmt->bind_param('sss', $Goalfiles[$i], $goal_path, $moduleId);
		$stmt->execute();
		$stmt->close();
	}

/*--------exericses----------*/
	//get Labs files from moudule directory
	$Exercisedir= sprintf("/home/sithuaung/public_html/131website/resources/%s/exercises",$moduleId);
	$Exercisedh= opendir($Exercisedir);

	// store all Labs files in an array
	while (false !== ($filename = readdir($Exercisedh))) {
		$Exercisefiles[] = $filename;
	}
	sort($Exercisefiles);

	//loop through Labs files array and update each Labs file data to Database 
	for ($i= 2; $i< count($Exercisefiles); $i++){
		$stmt= $mysqli->prepare("insert into exercises (exercise_name, exercise_path, module_id) values (?, ?, ?)");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
	  $exercise_path= sprintf("resources/%s/exercises/%s",$moduleId,$Exercisefiles[$i]);
		$stmt->bind_param('sss', $Exercisefiles[$i], $exercise_path, $moduleId);
		$stmt->execute();
		$stmt->close();
	}

/*--------studios----------*/
	//get Labs files from moudule directory
	$Studiodir= sprintf("/home/sithuaung/public_html/131website/resources/%s/studios",$moduleId);
	$Studiodh= opendir($Studiodir);

	// store all Labs files in an array
	while (false !== ($filename = readdir($Studiodh))) {
		$Studiofiles[] = $filename;
	}
	sort($Studiofiles);

	//loop through Labs files array and update each Labs file data to Database 
	for ($i= 2; $i< count($Studiofiles); $i++){
		$stmt= $mysqli->prepare("insert into studios (studio_name, studio_path, module_id) values (?, ?, ?)");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
	  $studio_path= sprintf("resources/%s/studios/%s",$moduleId,$Studiofiles[$i]);
		$stmt->bind_param('sss', $Studiofiles[$i], $studio_path, $moduleId);
		$stmt->execute();
		$stmt->close();
	}

/*--------Labs----------*/
	//get Labs files from moudule directory
	$Labdir= sprintf("/home/sithuaung/public_html/131website/resources/%s/labs",$moduleId);
	$Labdh= opendir($Labdir);

	// store all Labs files in an array
	while (false !== ($filename = readdir($Labdh))) {
		$Labfiles[] = $filename;
	}
	sort($Labfiles);

	//loop through Labs files array and update each Labs file data to Database 
	for ($i= 2; $i< count($Labfiles); $i++){
		$stmt= $mysqli->prepare("insert into labs (lab_name, lab_path, module_id) values (?, ?, ?)");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
	  $lab_path= sprintf("resources/%s/labs/%s",$moduleId,$Labfiles[$i]);
		$stmt->bind_param('sss', $Labfiles[$i], $lab_path, $moduleId);
		$stmt->execute();
		$stmt->close();
	}

/*--------Videos----------*/
	//get Video files from moudule directory
	$Videodir= sprintf("/home/sithuaung/public_html/131website/resources/%s/videos",$moduleId);
	$Videodh= opendir($Videodir);

	// store all Video files in an array
	while (false !== ($Videoname = readdir($Videodh))) {
		$Videofiles[] = $Videoname;
	}
	sort($Videofiles);

	//loop through Video files array and update each Video file data to Database 
	for ($i= 2; $i< count($Videofiles); $i++){
		$stmt= $mysqli->prepare("insert into videos (video_name, video_path,module_id) values (?, ?, ?)");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
	  $video_path= sprintf("resources/%s/videos/%s",$moduleId,$Videofiles[$i]);
		$stmt->bind_param('sss', substr($Videofiles[$i], 0, -4), $video_path, $moduleId);
		$stmt->execute();
		$stmt->close();
	}
}
?>
