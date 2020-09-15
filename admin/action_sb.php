<?php 
if (isset($_POST['submit'])) {

require_once '../includes/config.php';
require_once '../includes/display_errors.php';

	$_token = htmlspecialchars($_POST['_token']);
  	$name = htmlspecialchars($_POST['name']);
  	$class_id = htmlspecialchars($_POST['class_id']);
  	$today = date("Y-m-d H:i:s"); 

	if ($_token == ENCRYPTION_KEY) {
		
		$stmt_subjects = $connect->prepare("INSERT INTO subjects (name, class_id, created_at, updated_at) VALUES (:name, :class_id, :created_at, :updated_at)");
	    $stmt_subjects->bindParam (':name' , $name , PDO::PARAM_STR );
	    $stmt_subjects->bindParam (':class_id' , $class_id , PDO::PARAM_STR );
	    $stmt_subjects->bindParam (':created_at' , $today , PDO::PARAM_STR );
	    $stmt_subjects->bindParam (':updated_at' , $today , PDO::PARAM_STR );
	    $stmt_subjects->execute();

	     if (isset($stmt_subjects)) {  
	         header("location: subjects.php?alert=success") ;
	     }
	} else {
		die();
	}
}


if (isset($_POST['delete'])) {

require_once '../includes/config.php';
require_once '../includes/display_errors.php';

	$_token = htmlspecialchars($_POST['_token']);
  	$id_delete = htmlspecialchars($_POST['id_delete']);


  	


	if ($_token == ENCRYPTION_KEY) {

		//--> delete marks 
    	$stmt_delete1 = $connect->prepare("DELETE FROM marks WHERE subject_id=:subject_id");
    	$stmt_delete1->bindParam (':subject_id' , $id_delete , PDO::PARAM_STR );
    	$stmt_delete1->execute();
		
		$stmt_delete = $connect->prepare("DELETE FROM subjects WHERE id=:id");
      	$stmt_delete->bindParam (':id' , $id_delete , PDO::PARAM_STR );
      	$stmt_delete->execute();

	     if (isset($stmt_delete)) {  
	         header("location: subjects.php?alert=delete") ;
	     }
	} else {
		die();
	}
}



?>