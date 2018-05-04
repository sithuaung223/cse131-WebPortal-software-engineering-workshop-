<?php
	require 'database.php';
	$module_id = $_POST['moduleId'];
	//$module_id = '4';

		//set a new current_module 
		$stmt= $mysqli->prepare("update modules as module1 
														 join modules as module2 
														 on (module1.current= 1 and module2.module_id= ?) 
														 set module1.current = 0, module2.current = 1;");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			echo json_encode(array(
				"success" => false,
				"message" => "failed to set current module"
			));
			exit;
		}
		$stmt->bind_param('s', $module_id);
		$stmt->execute();
		$stmt->close();
		echo json_encode(array(
			"success" => true
		));
		exit;
?>
