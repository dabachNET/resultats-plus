<?php 
if (isset($_POST['submit'])) {

require_once '../includes/config.php';
require_once '../includes/display_errors.php';

	$_token = htmlspecialchars($_POST['_token']);
  	$name = htmlspecialchars($_POST['name']);
  	$today = date("Y-m-d H:i:s"); 

	if ($_token == ENCRYPTION_KEY) {
		
		$stmt_classes = $connect->prepare("INSERT INTO classes (name, created_at, updated_at) VALUES (:name, :created_at, :updated_at)");
	    $stmt_classes->bindParam (':name' , $name , PDO::PARAM_STR );
	    $stmt_classes->bindParam (':created_at' , $today , PDO::PARAM_STR );
	    $stmt_classes->bindParam (':updated_at' , $today , PDO::PARAM_STR );
	    $stmt_classes->execute();

	     if (isset($stmt_classes)) {  
	         header("location: classes.php?alert=success") ;
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
	    $stmt_delete1 = $connect->prepare("DELETE FROM marks WHERE class_id=:class_id");
	    $stmt_delete1->bindParam (':class_id' , $id_delete , PDO::PARAM_STR );
	    $stmt_delete1->execute();

	    //--> delete subjects 
	    $stmt_delete2 = $connect->prepare("DELETE FROM subjects WHERE class_id=:class_id");
	    $stmt_delete2->bindParam (':class_id' , $id_delete , PDO::PARAM_STR );
	    $stmt_delete2->execute();

	    //--> delete users class_id
	    $stmt_delete3 = $connect->prepare("UPDATE users SET class_id=null WHERE class_id=:class_id");
	    $stmt_delete3->bindParam (':class_id' , $id_delete , PDO::PARAM_STR );
	    $stmt_delete3->execute();
		
		$stmt_delete = $connect->prepare("DELETE FROM classes WHERE id=:id");
      	$stmt_delete->bindParam (':id' , $id_delete , PDO::PARAM_STR );
      	$stmt_delete->execute();

	     if (isset($stmt_delete)) {  
	         header("location: classes.php?alert=delete") ;
	     }
	} else {
		die();
	}
}



?>