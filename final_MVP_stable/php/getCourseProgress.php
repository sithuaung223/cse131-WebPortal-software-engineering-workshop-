<?php

require 'database.php';

//$user_id= $_SESSION['user_id'];
//$module_id= $_POST['module_id'];

$user_id= 45;

// get names of all modules with id
$stmt = $mysqli->prepare("SELECT module_id FROM modules");
$stmt->execute();
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array(
		"success" => false
	));
	exit;
}
$stmt->bind_result($id);
$modules= array();
while ($stmt->fetch()){
	$module= array(
		"module_id" => $id,
		"complete"=> 0
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

$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($module_id);

while ($stmt->fetch()){
	echo $module_id;
	for($i=0; $i< count($modules); $i++){
		if($modules[$i]["module_id"] == $module_id){
			$modules[$i]["complete"] = 1;
		}
	}
}
$stmt->close();

echo json_encode($modules);
	
?>
