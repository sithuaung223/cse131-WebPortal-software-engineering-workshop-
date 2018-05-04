<?php
require 'database.php';
header("Content-Type: application/json");  
session_start();

/*logout*/ 
	if (isset($_POST['logout'])){ 
		$_SESSION= array(); 
		if (session_destroy()){
			echo json_encode(array(
				"success" => true
			));
			exit; 				
		}
		else {
			echo json_encode(array(
				"success" => false,
				"message" => "Cannot logout"
			));
			exit;
		}

	}
?>
