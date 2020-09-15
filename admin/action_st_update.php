<?php 
if (isset($_POST['submit'])) {

require_once '../includes/config.php';
require_once '../includes/display_errors.php';


  $_token = htmlspecialchars($_POST['_token']);
  $fullname = htmlspecialchars($_POST['fullname']);
  $user_num = htmlspecialchars($_POST['user_num']);
  $class_id = htmlspecialchars($_POST['class_id']);
  $birthday = htmlspecialchars($_POST['birthday']);
  $address = htmlspecialchars($_POST['address']);
  $today = date("Y-m-d H:i:s");

  $user_id = htmlspecialchars($_POST['user_id']);

//---> info fetch
$stmt_for_check = $connect->prepare("SELECT * FROM users WHERE id=:id");
$stmt_for_check->bindParam (':id' , $user_id , PDO::PARAM_STR );
$stmt_for_check->execute();

$row = $stmt_for_check->fetch();

$id_row = $row['id'];
	


	if ($_token == ENCRYPTION_KEY) {


		if(!empty($_FILES['image']['name'])) {

              $size = 1000 * 1024;
              $target = "../uploads/";
              // an array of allowed extensions
              $allowedExts = array("gif", "jpeg", "jpg", "png","GIF","JPEG","JPG","PNG");
              $temp = explode(".", $_FILES["image"]["name"]);
              $extension = end($temp);

              if ((($_FILES["image"]["type"] == "image/gif")
                || ($_FILES["image"]["type"] == "image/jpeg")
                || ($_FILES["image"]["type"] == "image/jpg")
                || ($_FILES["image"]["type"] == "image/pjpeg")
                || ($_FILES["image"]["type"] == "image/x-png")
                || ($_FILES["image"]["type"] == "image/png"))
                && ($_FILES["image"]["size"] < $size ) && in_array($extension, $allowedExts)) {

                  if ($_FILES["image"]["error"] > 0) {
                  	header("location: student_update.php?id=". $id_row ."&alert=error&msg=images only") ;
                  }
                  else {

                    $image_name = round(microtime(true)) . '.' . end($temp);

                    // delete old logo
                    if (!empty($row['image'])) {
                        unlink("../uploads/".$row ['image']);
                    }

                 	  move_uploaded_file($_FILES["image"]["tmp_name"], $target . $image_name);


$stmt_update = $connect->prepare("UPDATE users SET fullname=:fullname, user_num=:user_num, birthday=:birthday, class_id=:class_id, address=:address, image=:image, updated_at=:updated_at WHERE id=$id_row");
$stmt_update->bindParam (':fullname' , $fullname , PDO::PARAM_STR );
$stmt_update->bindParam (':user_num' , $user_num , PDO::PARAM_STR );
$stmt_update->bindParam (':birthday' , $birthday , PDO::PARAM_STR );
$stmt_update->bindParam (':class_id' , $class_id , PDO::PARAM_STR );
$stmt_update->bindParam (':address' , $address , PDO::PARAM_STR );
$stmt_update->bindParam (':image' , $image_name , PDO::PARAM_STR );
$stmt_update->bindParam (':updated_at' , $today , PDO::PARAM_STR );
$stmt_update->execute();


				     if (isset($stmt_update)) {  
				      header("location: student_update.php?id=". $id_row ."&alert=success") ;
				     }


                  }
                }
                 else {
                  header("location: student_update.php?id=". $id_row ."&alert=error&msg=Images seulement") ;
                }
            
   	 	}


    	else {



$stmt_update = $connect->prepare("UPDATE users SET fullname=:fullname, user_num=:user_num, birthday=:birthday, class_id=:class_id, address=:address, updated_at=:updated_at WHERE id=$id_row");
$stmt_update->bindParam (':fullname' , $fullname , PDO::PARAM_STR );
$stmt_update->bindParam (':user_num' , $user_num , PDO::PARAM_STR );
$stmt_update->bindParam (':birthday' , $birthday , PDO::PARAM_STR );
$stmt_update->bindParam (':class_id' , $class_id , PDO::PARAM_STR );
$stmt_update->bindParam (':address' , $address , PDO::PARAM_STR );
$stmt_update->bindParam (':updated_at' , $today , PDO::PARAM_STR );
$stmt_update->execute();

			if (isset($stmt_update)) { 

     // echo $stmt_update->errorInfo();
			   header("location: student_update.php?id=". $id_row ."&alert=success") ;
			}



     	}
		
	} else {
		die();
	}
}





?>