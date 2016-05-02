<?php
session_start();

require 'database.php';

//get fileName and moduleName from Ajax
$user_id= $_SESSION['user_id'];
//$user_id= 1;

$module_name= $_POST['moduleName'];
$video_name = $_POST['videoName'];
$video_path = sprintf("/home/sithuaung/public_html/131website/resources/%s/%s", $module_name, $video_name);
 
//query Videos table in Database
$stmt= $mysqli->prepare("SELECT COUNT(*) FROM watch WHERE user_id=? and video_path=?");
if (!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array(
		"success" => false
	));
	exit;
}

$stmt->bind_param('is', $user_id, $video_path);
$stmt->execute();
$stmt->bind_result($isWatched);
$stmt->fetch();
$stmt->close();

if ($isWatched !=0) {
	echo json_encode(array(
		"success" => 'Already Watched'
	));
	exit;
}
else {
	$q2= $mysqli->prepare("INSERT INTO watch (user_id, video_path) values (?,?)");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
	$q2->bind_param('is',$user_id,$video_path);
	$q2->execute();
	echo json_encode(array(
		"success" => 'Just Watched'
	));
	exit;
}
?>
