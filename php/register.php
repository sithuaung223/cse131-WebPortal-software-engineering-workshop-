<?php
require 'database.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
session_start();

/*register*/
  $username= $_POST['username'];
	$pwd= $_POST['password'];
	$firstName= $_POST['firstName'];
	$lastName=  $_POST['lastName'];

//	$username= 'hello';
//	$pwd= 'pass';
//	$firstName= 'first';
//	$lastName=  'last';
	 
	$pwd_hash= crypt($pwd);

	//check user already register or not
	$stmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE user_name=?");
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($alreadyRegister);
	$stmt->fetch();
	$stmt->close();

	if ($alreadyRegister){
		echo json_encode(array(
			'success' => false,
			'message' => "username is already existed"));
		exit;  	
	}

	//register user in database
	$stmt= $mysqli->prepare("insert into users (user_name, user_pass, first_name, last_name) values (?, ?, ?, ?)");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('ssss', $username, $pwd_hash, $firstName, $lastName);
	$stmt->execute();
	$stmt->close();

	echo json_encode(array(
		'success' => true,
		'message' => "you have been registered"));
	exit;  	
?>
