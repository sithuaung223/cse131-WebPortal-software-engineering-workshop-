<?php
session_start();

require 'database.php';
//TODO get module_id from session &&  module_name from ajax
$moduleId = $_POST['moduleId'];
//$moduleId = 4;

//check moduleId exit or not
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM modules WHERE module_id=?");
$stmt->bind_param('s', $moduleId);
$stmt->execute();
$stmt->bind_result($exist);
$stmt->fetch();
$stmt->close();

//module does not exit
//TODO check module exit or not
if($exist==0){
	echo json_encode(array(
		"success"=>false,
		"message"=> 'module does not exit in Database'
	));
	exit;
}

/*----------------modules---------------*/
$full_path = sprintf("/home/sithuaung/public_html/131website/resources/%s", $moduleId);
 
//query Videos table in Database
$stmt= $mysqli->prepare("delete from modules where module_id=?");
if (!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 

if(deleteDirectory($full_path)){

	$stmt->bind_param('s', $moduleId);
	$stmt->execute();
	$stmt->close();
	deleteStuffDB($moduleId);
	
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

function deleteStuffDB($module_id){
	require 'database.php';
	/*-----delete studio path in Database------*/
	$stmt= $mysqli->prepare("delete from studios where module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $module_id);
	$stmt->execute();
	$stmt->close();

	/*-----delete labs in Database------*/
	$stmt= $mysqli->prepare("delete from labs where module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $module_id);
	$stmt->execute();
	$stmt->close();

	/*-----delete videos in Database------*/
	$stmt= $mysqli->prepare("delete from videos where module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $module_id);
	$stmt->execute();
	$stmt->close();

	/*-----delete exercises in Database------*/
	$stmt= $mysqli->prepare("delete from exercises where module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $module_id);
	$stmt->execute();
	$stmt->close();

	/*-----delete extensions in Database------*/
	$stmt= $mysqli->prepare("delete from extensions where module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $module_id);
	$stmt->execute();
	$stmt->close();

	/*-----delete extensions in Database------*/
	$stmt= $mysqli->prepare("delete from goals where module_id=?");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $module_id);
	$stmt->execute();
	$stmt->close();
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
?>
