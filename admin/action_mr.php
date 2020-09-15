<?php 

if (!empty($_POST)) {


require_once '../includes/config.php';
require_once '../includes/display_errors.php';

	$_token = htmlspecialchars($_POST['_token']) ;
  	$class_id = htmlspecialchars($_POST['class_id']);
  	$student_id = htmlspecialchars($_POST['student_id']);
  	$subject_id = htmlspecialchars($_POST['subject_id']);
  	$mark = htmlspecialchars($_POST['mark']);
  	$today = date("Y-m-d H:i:s"); 

	if ($_token == ENCRYPTION_KEY) {

		// check
		$stmt_for_check = $connect->prepare("SELECT * FROM marks WHERE student_id=:student_id AND subject_id=:subject_id");
      	$stmt_for_check->bindParam (':student_id' , $student_id , PDO::PARAM_STR );
      	$stmt_for_check->bindParam (':subject_id' , $subject_id , PDO::PARAM_STR );
      	$stmt_for_check->execute();

      	if ($stmt_for_check->rowCount() == 0) {

		
			$stmt_marks = $connect->prepare("INSERT INTO marks (class_id, student_id, subject_id, mark, created_at, updated_at) VALUES (:class_id, :student_id, :subject_id, :mark, :created_at, :updated_at)");
		    $stmt_marks->bindParam (':class_id' , $class_id , PDO::PARAM_STR );
		    $stmt_marks->bindParam (':student_id' , $student_id , PDO::PARAM_STR );
		    $stmt_marks->bindParam (':subject_id' , $subject_id , PDO::PARAM_STR );
		    $stmt_marks->bindParam (':mark' , $mark , PDO::PARAM_STR );
		    $stmt_marks->bindParam (':created_at' , $today , PDO::PARAM_STR );
		    $stmt_marks->bindParam (':updated_at' , $today , PDO::PARAM_STR );
		    $stmt_marks->execute();

		     if (isset($stmt_marks)) {  

		     	echo 'true';

		        // header("location: marks.php?alert=success") ;
		     }

		 } else { 

		 	echo 'false';

		  //  header("location: marks.php?alert=error&msg=La matières que vous avez ajouté a déjà une moyenne") ;
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
		
		$stmt_delete = $connect->prepare("DELETE FROM marks WHERE id=:id");
      	$stmt_delete->bindParam (':id' , $id_delete , PDO::PARAM_STR );
      	$stmt_delete->execute();

	     if (isset($stmt_delete)) {  
	         header("location: marks.php?alert=delete") ;
	     }
	} else {
		die();
	}
}



?>