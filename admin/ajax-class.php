<?php 

if (isset($_GET['class_id'])) {

header("content-type:application/json");

require_once '../includes/config.php';
require_once '../includes/display_errors.php';


  	$class_id = htmlspecialchars($_GET['class_id']);

  	$stmt_check = $connect->prepare("SELECT id, fullname FROM users WHERE class_id=:class_id");
  	$stmt_check->bindParam (':class_id' , $class_id , PDO::PARAM_STR );
  	$stmt_check->execute();

  	$resultJSON = json_encode($stmt_check->fetchAll(PDO::FETCH_ASSOC));

  	echo $resultJSON;

}


if (isset($_GET['subject_id'])) {

header("content-type:application/json");

require_once '../includes/config.php';
require_once '../includes/display_errors.php';


  	$class_id = htmlspecialchars($_GET['subject_id']);

  	$stmt_check2 = $connect->prepare("SELECT id, name FROM subjects WHERE class_id=:class_id");
  	$stmt_check2->bindParam (':class_id' , $class_id , PDO::PARAM_STR );
  	$stmt_check2->execute();

  	$resultJSON2 = json_encode($stmt_check2->fetchAll(PDO::FETCH_ASSOC));

  	echo $resultJSON2;

}



 ?>