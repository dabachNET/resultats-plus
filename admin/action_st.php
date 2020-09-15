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
                  	header("location: students.php?alert=error") ;
                  }
                  else {

                    $image_name = round(microtime(true)) . '.' . end($temp);

                 	move_uploaded_file($_FILES["image"]["tmp_name"], $target . $image_name);

                    $stmt_users = $connect->prepare("INSERT INTO users (is_student, fullname, user_num, class_id, birthday, address, image, created_at, updated_at) VALUES (1, :fullname, :user_num, :class_id, :birthday, :address, :image, :created_at, :updated_at)");
                    $stmt_users->bindParam (':fullname' , $fullname , PDO::PARAM_STR );
                    $stmt_users->bindParam (':user_num' , $user_num , PDO::PARAM_STR );
                    $stmt_users->bindParam (':class_id' , $class_id , PDO::PARAM_STR );
                    $stmt_users->bindParam (':birthday' , $birthday , PDO::PARAM_STR );
                    $stmt_users->bindParam (':address' , $address , PDO::PARAM_STR );
                    $stmt_users->bindParam (':image' , $image_name , PDO::PARAM_STR );
                    $stmt_users->bindParam (':created_at' , $today , PDO::PARAM_STR );
	    			$stmt_users->bindParam (':updated_at' , $today , PDO::PARAM_STR );
                    $stmt_users->execute();

				     if (isset($stmt_users)) {  
				         header("location: students.php?alert=success") ;
				     }


                  }
                }
                 else {
                  header("location: students.php?alert=error") ;
                }
            
   	 	}

    	else {

	    	$stmt_users = $connect->prepare("INSERT INTO users (is_student, fullname, user_num, class_id, birthday, address, created_at, updated_at) VALUES (1, :fullname, :user_num, :class_id, :birthday, :address, :created_at, :updated_at)");
            $stmt_users->bindParam (':fullname' , $fullname , PDO::PARAM_STR );
            $stmt_users->bindParam (':user_num' , $user_num , PDO::PARAM_STR );
            $stmt_users->bindParam (':class_id' , $class_id , PDO::PARAM_STR );
            $stmt_users->bindParam (':birthday' , $birthday , PDO::PARAM_STR );
            $stmt_users->bindParam (':address' , $address , PDO::PARAM_STR );
            $stmt_users->bindParam (':created_at' , $today , PDO::PARAM_STR );
	    	$stmt_users->bindParam (':updated_at' , $today , PDO::PARAM_STR );
            $stmt_users->execute();

			if (isset($stmt_users)) {  
				header("location: students.php?alert=success") ;
			}

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

		$stmt_for_img = $connect->prepare("SELECT * FROM users WHERE id=:id");
    $stmt_for_img->bindParam (':id' , $id_delete , PDO::PARAM_STR );
    $stmt_for_img->execute();
    $img_row = $stmt_for_img->fetch();

    //--> delete marks 
    $stmt_delete1 = $connect->prepare("DELETE FROM marks WHERE student_id=:student_id");
    $stmt_delete1->bindParam (':student_id' , $id_delete , PDO::PARAM_STR );
    $stmt_delete1->execute();

		
		$stmt_delete = $connect->prepare("DELETE FROM users WHERE id=:id");
    $stmt_delete->bindParam (':id' , $id_delete , PDO::PARAM_STR );
    $stmt_delete->execute();

      	

	     if (isset($stmt_delete)) {  

	     	// delete image
	     	if (!empty($img_row ['image'])) {
          		unlink("../uploads/".$img_row ['image']);
        }

	        header("location: students.php?alert=delete") ;
	     }
	} else {
		die();
	}
}



?>