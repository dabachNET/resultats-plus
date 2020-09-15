<?php 
if (isset($_POST['submit'])) {

require_once '../includes/config.php';
require_once '../includes/display_errors.php';


//---> info fetch
$stmt_get_info = $connect->prepare("SELECT * FROM settings WHERE id=1");
$stmt_get_info->execute();
$info_row = $stmt_get_info->fetch();

//--> admin fetch
$stmt_get_admin = $connect->prepare("SELECT * FROM users WHERE is_admin=1");
$stmt_get_admin->execute();
$admin_row = $stmt_get_admin->fetch();


	$_token = htmlspecialchars($_POST['_token']);
  $school_name = htmlspecialchars($_POST['school_name']);
  $school_email = htmlspecialchars($_POST['school_email']);
  $school_phone = htmlspecialchars($_POST['school_phone']);

  $admin_oldpassword = htmlspecialchars($_POST['admin_oldpassword']);
  $admin_email = htmlspecialchars($_POST['admin_email']);
  $admin_password = htmlspecialchars($_POST['admin_password']);

  $today = date("Y-m-d H:i:s"); 

	if ($_token == ENCRYPTION_KEY) {


		if(!empty($_FILES['school_logo']['name'])) {

              $size = 1000 * 1024;
              $target = "../libs/img/";
              // an array of allowed extensions
              $allowedExts = array("gif", "jpeg", "jpg", "png","GIF","JPEG","JPG","PNG");
              $temp = explode(".", $_FILES["school_logo"]["name"]);
              $extension = end($temp);

              if ((($_FILES["school_logo"]["type"] == "image/gif")
                || ($_FILES["school_logo"]["type"] == "image/jpeg")
                || ($_FILES["school_logo"]["type"] == "image/jpg")
                || ($_FILES["school_logo"]["type"] == "image/pjpeg")
                || ($_FILES["school_logo"]["type"] == "image/x-png")
                || ($_FILES["school_logo"]["type"] == "image/png"))
                && ($_FILES["school_logo"]["size"] < $size ) && in_array($extension, $allowedExts)) {

                  if ($_FILES["school_logo"]["error"] > 0) {
                  	header("location: settings.php?alert=error") ;
                  }
                  else {

                    $image_name = round(microtime(true)) . '.' . end($temp);

                    // delete old logo
                    if (!empty($info_row['school_logo'])) {
                        unlink("../libs/img/".$info_row ['school_logo']);
                    }

                 	  move_uploaded_file($_FILES["school_logo"]["tmp_name"], $target . $image_name);


$stmt_update = $connect->prepare("UPDATE settings SET school_name=:school_name, school_email=:school_email, school_phone=:school_phone, school_logo=:school_logo, updated_at=:updated_at WHERE id=1");
$stmt_update->bindParam (':school_name' , $school_name , PDO::PARAM_STR );
$stmt_update->bindParam (':school_email' , $school_email , PDO::PARAM_STR );
$stmt_update->bindParam (':school_phone' , $school_phone , PDO::PARAM_STR );
$stmt_update->bindParam (':school_logo' , $image_name , PDO::PARAM_STR );
$stmt_update->bindParam (':updated_at' , $today , PDO::PARAM_STR );
$stmt_update->execute();


				     if (isset($stmt_update)) {  
				      header("location: settings.php?alert=success") ;
				     }


                  }
                }
                 else {
                  header("location: settings.php?alert=error") ;
                }
            
   	 	}


    	else {

//--> update email + password
if (!empty($admin_oldpassword) AND !empty($admin_password)) {

    $admin_id = $admin_row['id'];
    $newHash = password_hash($admin_password, PASSWORD_DEFAULT);

    if (password_verify($admin_oldpassword, $admin_row['password'])) {

      $stmt_update_ad = $connect->prepare("UPDATE users SET password=:password, email=:email, updated_at=:updated_at WHERE id='$admin_id'");
      $stmt_update_ad->bindParam (':password' , $newHash , PDO::PARAM_STR );
      $stmt_update_ad->bindParam (':email' , $admin_email , PDO::PARAM_STR );
      $stmt_update_ad->bindParam (':updated_at' , $today , PDO::PARAM_STR );
      $stmt_update_ad->execute();

    } else {
        header("location: settings.php?alert=error&msg=Mot de passe incorrect");
        die();
    }
    
}


//--> update only email
if (!empty($admin_oldpassword) AND empty($admin_password)) {

    $admin_id = $admin_row['id'];

    if (password_verify($admin_oldpassword, $admin_row['password'])) {

      $stmt_update_ad = $connect->prepare("UPDATE users SET email=:email, updated_at=:updated_at WHERE id='$admin_id'");
      $stmt_update_ad->bindParam (':email' , $admin_email , PDO::PARAM_STR );
      $stmt_update_ad->bindParam (':updated_at' , $today , PDO::PARAM_STR );
      $stmt_update_ad->execute();

    } else {
        header("location: settings.php?alert=error&msg=Mot de passe incorrect");
        die();
    }
    
}


$stmt_update = $connect->prepare("UPDATE settings SET school_name=:school_name, school_email=:school_email, school_phone=:school_phone, updated_at=:updated_at WHERE id=1");
$stmt_update->bindParam (':school_name' , $school_name , PDO::PARAM_STR );
$stmt_update->bindParam (':school_email' , $school_email , PDO::PARAM_STR );
$stmt_update->bindParam (':school_phone' , $school_phone , PDO::PARAM_STR );
$stmt_update->bindParam (':updated_at' , $today , PDO::PARAM_STR );
$stmt_update->execute();


			if (isset($stmt_update)) {  
			   header("location: settings.php?alert=success") ;
			}



     	}
		
	} else {
		die();
	}
}





?>