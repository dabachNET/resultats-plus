<?php 
require '../includes/config.php';
include '../includes/display_errors.php';

if (file_exists('../install/install.php')) {
   die('<p>Vous ne pouvez pas naviguer sur votre site ou votre interface d\'administration avant de supprimer le fichier d\'installation.</p> <p>Pour supprimer manuellement votre dossier d\'installation, il suffit d\'utiliser un client FTP et d\'opérer un clic droit sur le dossier nommé "install", puis d\'appuyer sur "Supprimer".</p>');
}

$stmt_get_info = $connect->prepare("SELECT * FROM settings WHERE id=1");
$stmt_get_info->execute();
$info_row = $stmt_get_info->fetch();

?>
<!DOCTYPE html>
<html lang="fr" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="<?php echo BASE_PATH; ?>libs/img/fav.png">
		<meta name="author" content="DABACH NET">
		<meta charset="UTF-8">
		<title><?php echo $title; ?></title>

			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/css/linearicons.css">
			<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/css/font-awesome.min.css">
			<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/css/bootstrap.css">

			<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/css/style.min.css">

			<script src="<?php echo BASE_PATH; ?>libs/js/jquery-2.2.4.min.js"></script>
			
		</head>
		<body>

			  <header id="header" id="home">
			    <div class="container">
			    	<div class="row header-top align-items-center">
			    		<div class="col-lg-8 menu-top-left d-flex">
							<a href="<?php echo BASE_PATH; ?>">
								<img class="img-fluid" src="<?php echo BASE_PATH; ?>libs/img/<?php echo $info_row['school_logo']; ?>" alt="" width="240">	
							</a>			   			
			    		</div>
			    		<div class="col-lg-4 col-sm-4 menu-top-right">
			    			<a class="tel" href="tel:<?php echo $info_row['school_phone']; ?>"><?php echo $info_row['school_phone']; ?></a>
			    			<a href="tel:<?php echo $info_row['school_phone']; ?>"><span class="lnr lnr-phone-handset"></span></a>
			    		</div>
			    	</div>
			    </div>	
			    	<hr>
			    <div class="container">	
			    	<div class="row align-items-center justify-content-center d-flex">
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
				          <li class="menu-active"><a href="index.php">Accueil</a></li>
				          
<?php if (isset($_SESSION ["admin_panel"])) { ?>
				          <li><a href="students.php">Les étudiants</a></li>
				          <li><a href="classes.php">Les classes</a></li>
				          <li><a href="subjects.php">Les matières</a></li>
				          <li><a href="marks.php">Les résultats</a></li>				          
				          <li><a href="settings.php">Paramètres</a></li>
				          <li><a href="logout.php">Déconnecter</a></li>
<?php } ?>
				        </ul>
				      </nav><!-- #nav-menu-container -->

			    	</div>
			    </div>
			  </header><!-- #header -->


<section class="mt-30">
<div class="container-fluid">	