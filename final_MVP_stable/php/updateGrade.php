<?php
	$dir= sprintf("/home/sithuaung/public_html/131website/svn/");
	$dh= opendir($dir);
	$lab= "lab0";
	
	//Get all usernames and sort them
	while (($dirName= readdir($dh)) != false){
		if (strcmp($dirName,".")!= 0 && strcmp($dirName, "..")!= 0) {
			$usernames[]= $dirName;
		}
	}
	sort($usernames);
	
	for ($i=0; $i<count($usernames); $i++){
		$gradeFile= sprintf("/home/sithuaung/public_html/131website/svn/%s/%s/grade.txt", $usernames[$i], $lab);
		$handle= fopen($gradeFile,"r");
		if ($handle) {
			while (($line= fgets($handle)) != false) {
				$matches= array();
				$pattern= '#([0-9]+)/([0-9]+)#';
				preg_match($pattern, $line, $matches);
				$score= $matches[1];
				$total= $matches[2]; 
				printf($usernames[$i]. " got " . $score."/".$total."\n");
				//TODO: update the grade in the database
				updateGradeToDatabase($usernames[$i], $lab, $score, $total);
				break; //only takes 1 line
			}
		}
		else{
			//TODO: handle file open exceptions
		}
		fclose($handle);	
	}
exit;

//input: module name
//output: populate all files data of module to Database
function updateGradeToDatabase($username, $lab_num, $score,$total){
	require 'database.php';
		//query users table in Database
		$stmt= $mysqli->prepare("SELECT user_id FROM users WHERE user_name=?");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			printf('Fail to get user_id from users table'."\n");
			exit;
		}
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($user_id);
		$stmt->fetch();
		$stmt->close();


		//query submit_labs table in Database
		$stmt= $mysqli->prepare("SELECT COUNT(*) FROM submit_labs WHERE user_id=? and lab_num=?");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			printf( 'Fail to get lab data from table'."\n");
			exit;
		}
		$stmt->bind_param('is', $user_id, $lab_num);
		$stmt->execute();
		$stmt->bind_result($isGraded);
		$stmt->fetch();
		$stmt->close();
		if($user_id == NULL){
			printf( "user does not exit in users Table"."\n");
			return;
		}
		else{
			printf($user_id);
		}

		//if lab is already graded
		if ($isGraded !=0) {
			//overwrite the grade into submit_labs Table in Database
			$stmt= $mysqli->prepare("UPDATE submit_labs set score=?,total=? WHERE user_id=? and lab_num=?");
			if (!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				printf( 'Fail to overwrite the Grade'."\n");
				exit;
			}
			$stmt->bind_param('iiis',$score,$total, $user_id, $lab_num);
			$stmt->execute();
			$stmt->close();
			printf( 'update the new Grade'."\n");
			return;
		}

		//insert the gade into submit_labs Table in Database
		$stmt= $mysqli->prepare("insert into submit_labs (user_id, lab_num, score, total) values (?, ?, ?,?)");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			printf( 'Fail to insert the Grade'."\n");
			exit;
		}
		$stmt->bind_param('isii', $user_id, $lab_num, $score, $total);
		$stmt->execute();
		$stmt->close();
		printf( 'insert the Grade'."\n");

}
?>
