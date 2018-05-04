<?php
session_start();
require 'database.php';

//$user_id= $_SESSION['user_id'];
$user_id= 36;
$lab_num= $_POST['labName'];

//query submit_labs table in Database
$stmt= $mysqli->prepare("SELECT COUNT(*),score,total FROM submit_labs WHERE user_id=? and lab_num=?");
if (!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('is', $user_id, $lab_num);
$stmt->execute();
$stmt->bind_result($isGraded, $score, $total);
$stmt->fetch();
$stmt->close();

if ($isGraded !=0) {
	printf("your %s score is %d/%d", $lab_num, $score, $total);
	exit;
}
else {
	printf("%s hasn't been graded yet", $lab_num);
	exit;
}
?>
