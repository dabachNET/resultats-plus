<?php 

/*
    Powered by Résultats PLUS
    Système de gestion des résultats 
    www.dabach.net
    dabach.net@gmail.com
*/

if (version_compare(PHP_VERSION, "5.6.0", "<")) {
  print "Requires PHP 5.6.0 or newer.\n";
  exit;
}


 ?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="DABACH NET">
    <title>Résultats PLUS - installation</title> 

    <link rel="stylesheet" href="../libs/css/bootstrap.css">

        
  </head>
<body>


<div class="content col-md-8 offset-2">


<div class="card mt-5 mb-5">
  <div class="card-header text-white bg-light">
    <h5><img src="../libs/img/logo.png" width="250"></h5>
  </div>
  <div class="card-body">

<?php 

$step = htmlspecialchars(@$_GET['step']);




/*---------------------------------------------------------------------------------------*/

if ($step == "1") {

if (!function_exists('fopen') OR !function_exists('fwrite') ) {
	 $error = 1;
}

if (function_exists('chmod') ) {
	@chmod('../uploads', 0777);
}

if (@$error == 1)  {
  echo "<div class='alert alert-warning' style='margin: auto;'>
      <h3>la création automatique du fichier ne fonctionne pas.</h3>
        <p>création automatique du fichier nécessite les fonctions suivantes : </p>
        fopen - fwrite
      
    </div>";
	 die();
} 


	if (isset($_POST['submit'])) {
   
	  $DB_SERVER =  htmlspecialchars($_POST['db_host']);
	  $DB_USER =  htmlspecialchars($_POST['db_user']);
	  $DB_PASS = htmlspecialchars($_POST['db_pass']);
	  $DB_DATABASE = htmlspecialchars($_POST['db_name']);

    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    $ENCRYPTION_KEY = generateRandomString(32);

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $search = 'install/install.php?step=1' ;
    $SET_BASE_PATH = str_replace($search, '', $actual_link) ;



// check dababase
    try { 
   $connect =  new PDO("mysql:host=$DB_SERVER; dbname=$DB_DATABASE", $DB_USER,$DB_PASS); 
   } 
 
   catch (PDOException $e) { 

    header("location: install.php?step=1&error=Could not open connection to database server. Please check your configuration");
    die();
   }


//---> config file

$filename = '../includes/config.php';

if (!file_exists($filename)) {
   die('config.php not exists!');
} 

	$fh = fopen('../includes/config.php', 'w');

		if ($fh) {
			$s = "<?php \n" 
				  . "\t/** \n" 
				  . "\tConfiguration\n"
          . "\tCopyright © 2019 Résultats PLUS. All Rights Reserved.\n"
				  . "\tDeveloped by DABACH NET - dabach.net@gmail.com - www.dabach.net\n"
				  . "\t*/\n"
          . " \n"
          . "\t// BASE_PATH with / at the end of link  \n"
          . "\t define( 'BASE_PATH', '$SET_BASE_PATH'); \n"
          . "\t define( 'ENCRYPTION_KEY', '$ENCRYPTION_KEY'); \n"

				  . " \n" 
				  . "\t \$DB_SERVER = \"$DB_SERVER\"; \n"
				  . "\t \$DB_USER = \"$DB_USER\"; \n"
				  . "\t \$DB_PASS = \"$DB_PASS\"; \n"
          . "\t \$DB_DATABASE = \"$DB_DATABASE\"; \n"
				  . "\t \$INSTALL = true; \n"
				  . " \n"

				  . "\t try { \n"
				  . "\t \$connect =  new PDO(\"mysql:host=\$DB_SERVER; dbname=\$DB_DATABASE\", \$DB_USER,\$DB_PASS); \n"
				  . "\t } \n"
				  . " \n"

				  . "\t catch (PDOException \$e) { \n"
          . "\t if (\$INSTALL == false) { \n"

          . "\t include 'install/index.php'; \n"
          . "\t die(); \n"

          . "\t } else { \n"
				  . "\t die(\"Database Error..!\"); } \n"
				  . "\t } \n"
				  . " \n"

				  . "\t \$connect->query(\"set charcter_set_server = 'utf8'\"); \n"
				  . "\t \$connect->query(\"set names'utf8' \"); \n"
				  . " \n"
				  
				  . "?>";
			fwrite($fh, $s);
			fclose($fh);
			
		}

//---> tables

require '../includes/config.php';

$tables = $connect->query("CREATE TABLE `classes` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
  `created_at` TIMESTAMP NOT NULL DEFAULT '2019-01-01 01:01:01',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '2019-01-01 01:01:01',
  PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

CREATE TABLE `marks` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_id` INT(11) NULL DEFAULT NULL,
  `subject_id` INT(11) NULL DEFAULT NULL,
  `student_id` INT(11) NULL DEFAULT NULL,
  `mark` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
  `created_at` TIMESTAMP NOT NULL DEFAULT '2019-01-01 01:01:01',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '2019-01-01 01:01:01',
  PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;


CREATE TABLE `settings` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `school_name` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
  `school_email` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
  `school_phone` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
  `school_logo` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
  `created_at` TIMESTAMP NOT NULL DEFAULT '2019-01-01 01:01:01',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '2019-01-01 01:01:01',
  PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=2
;


INSERT INTO `settings` (`id`, `school_name`, `school_email`, `school_phone`, `school_logo`, `created_at`, `updated_at`) VALUES
(1, 'DABACH NET', 'contact@dabach.net', '+212 670 941 992', 'logo.png', '2019-01-01 01:01:01', '2019-08-31 20:05:34');



CREATE TABLE `subjects` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
  `class_id` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT '2019-01-01 01:01:01',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '2019-01-01 01:01:01',
  PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;


CREATE TABLE `users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_admin` TINYINT(1) NOT NULL DEFAULT '0',
  `username` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
  `email` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
  `password` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
  `is_student` TINYINT(1) NOT NULL DEFAULT '0',
  `class_id` INT(11) NULL DEFAULT NULL,
  `fullname` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
  `user_num` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
  `birthday` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
  `address` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
  `image` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `users_username_unique` (`username`)
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=MyISAM
AUTO_INCREMENT=1
;







");


header("location: install.php?step=2");
die();

	
	}

	?>


<div class="row">

<div class="col-md-12">
<h5>Entrez les détails de connexion à votre base de données:</h5>
<hr>  


<?php if(isset($_GET['error'])) { ?>
  <div class='alert alert-danger'>
    <strong><?php echo $_GET['error']; ?></strong>
  </div>
<?php } ?>

<form id="formID" method="post" action="" class="row">


<div class="col-md-6">
  <label>Host (serveur) :</label>
        <div class="form-group">
            <input name="db_host" type="text" placeholder="" class="form-control" value="localhost"/>
        </div>
</div>        

<div class="col-md-6">
  <label>Nom d'utilisateur de la base :</label>
        <div class="form-group">
            <input name="db_user" type="text" class="form-control" />
        </div>
</div>       

<div class="col-md-6">
  <label>Mot de passe de la base :</label>
        <div class="form-group">
            <input name="db_pass" type="text" class="form-control" />
        </div>
</div>        


<div class="col-md-6">
  <label>Nom de la base :</label>
        <div class="form-group">
            <input name="db_name" type="text" class="form-control" />
        </div>
</div>        

<div class="col-md-12">
  <button type="submit" name="submit" class="btn btn-success btn-lg">Suivant</button> 
</div>     


</form>

</div>


</div>

<?php

}

/*----------------------------------------------------------------------------*/


elseif ($step == "2") { 

$filename = '../includes/config.php';

if (!file_exists($filename)) {
   die('install error.. config.php not exists!');
} 
else {
    require '../includes/config.php';
}



?>

  <h3 class="h3">Ajouter un administrator:</h3> <hr>


<div class="col-md-12">

  <form method="post" action="" class="row">

<?php


if (isset($_POST['submit'])) {
   
  $username = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $today = date("Y-m-d H:i:s"); 


  $stmt = $connect->prepare("INSERT INTO `users` (`id`, `is_admin`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES (1, 1, :username, :password, :email, :created_at, :updated_at)");
  $stmt->bindParam (':username' , $username , PDO::PARAM_STR );
  $stmt->bindParam (':email' , $email , PDO::PARAM_STR );
  $stmt->bindParam (':password' , $password , PDO::PARAM_STR );
  $stmt->bindParam (':created_at' , $today , PDO::PARAM_STR );
  $stmt->bindParam (':updated_at' , $today , PDO::PARAM_STR );
  $stmt->execute();

    if (isset($stmt)) {

      $connect = null;
      
      header("location: install.php?step=3");

      die();

    }

    

}


?>
    

        <div class="col-md-6">
          <label>Nom d'utilisateur:</label>
        <div class="form-group">
            <input name="username" type="text" placeholder="" class="form-control" required="required" />
        </div>
        </div>

        <div class="col-md-6">
          <label>Email:</label>
          <div class="form-group">
          <input name="email" type="text" class="form-control" required="required">
          </div>
        </div>


<script type="text/javascript">
var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('confirm_password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Confirme!';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Confirmation..';
  }
}
</script>


        <div class="col-md-6">
          <label>Mot de passe:</label>
        <div class="form-group">
            <input name="password" type="password" id="password" class="form-control" required="required">
        </div>
        </div>

        <div class="col-md-6">
          <label>Confirmez le mot de passe:</label>
        <div class="form-group">
            <input name="confirm_password" id="confirm_password" type="password" class="form-control" onkeyup='check();' required="required">
            <span id='message'></span>
        </div>
        </div>



        <div class="col-md-6">
          <button type="submit" name="submit" class="btn btn-success">Enregistrer</button>
        </div>

        

    </form>
</div>
<?php

}




elseif ($step == "3") { 


?>


<div class="col-md-12 text-center">

<div class="alert alert-info" role="alert">

<h4>Résultats PLUS est installé :</h4>

      <p>Résultats PLUS est installé avec succès. vous pouvez maintenant commencer à gérer votre résultats!</p>
      
      <p><strong>important:</strong> Veuillez supprimer le dossier nommé "install"</p>

      <p><a onclick="return confirm('Veuillez supprimer le dossier nommé /install/')"  class='btn btn-warning' href='../admin/login.php'>Se connecter</a></p>

</div>
      

  
</div>

<?php

}

?>    


<div class="clearfix"></div><hr>
<p class="text-center mt-5">Copyright &copy; 2019 Résultats PLUS v1.0 All Rights Reserved.</p>
<p class="text-center"><a href="https://dabach.net/resultats_plus/"><img src="../libs/img/dabach.png" width="120px" /></a></p>

 
    </div>

</div>



</div>		
                           

  </body>
</html>

