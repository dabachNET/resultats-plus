<?php 
require 'includes/config.php';
include 'includes/display_errors.php';

if (file_exists('install/install.php')) {
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
		<meta name="description" content="Découvre les résultats des examens">
		<meta name="keywords" content="résultats, examens, résultats en ligne">
		<meta charset="UTF-8">
		
		<title><?php echo $info_row['school_name']; ?> - Découvre les résultats des examens </title>

			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/css/linearicons.css">
			<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/css/font-awesome.min.css">
			<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/css/bootstrap.css">
			<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/css/style.min.css">


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
				          <li class="menu-active"><a href="<?php echo BASE_PATH; ?>">Accueil</a></li>
				          <li><a href="mailto:<?php echo $info_row['school_email']; ?>">Contact</a></li>
				          
				        </ul>
				      </nav><!-- #nav-menu-container -->		    		
			    	</div>
			    </div>
			  </header><!-- #header -->


			<section class="section-gap relative mt-20">
				<div class=" overlay-bg"></div>
				<div class="container">
					<div class="row justify-content-between align-items-center">


<?php 

if (isset($_POST['submit'])) {

  $numbre = htmlspecialchars($_POST['numbre']);

  $stmt_check = $connect->prepare("SELECT * FROM users WHERE user_num=:user_num");
  $stmt_check->bindParam (':user_num' , $numbre , PDO::PARAM_STR );
  $stmt_check->execute();

  if ($stmt_check->rowCount() == 1) {
        
    $row = $stmt_check->fetch() ;
    $user_id = $row ['id'];
    $fullname = $row ['fullname'];
    $birthday = $row ['birthday'];
    $address = $row ['address'];
    $image = $row ['image'];
    $class_id = $row ['class_id'];



?>

<a href="index.php" class="btn btn-warning mb-10"><i class="fa fa-arrow-circle-left"></i> Nouvelle recherche</a>
<div class="clearfix"></div>


<div class="col-md-12 bk-right">


<div class="container-fluid" id="body-container-fluid">
				<div class="container">
					<!---- for body container ---->
					<div class="row">
						 

					<div class="col-lg-4">
						<div class="card" style="width:100%">
							
<?php 

if (!empty($image)) {
      echo '<img src="'.BASE_PATH.'uploads/'.$image.'" class="" style="width:100%">';
    } else {
      echo '<img src="'.BASE_PATH.'uploads/default.png" class="" style="width:100%">';
    } 
?>

							<div class="card-body">
							  <h4 class="card-title"><?php echo $fullname; ?></h4>
							  	<ul class="list-inline">

									<li class="list-inline-item">
										<i class="fa fa-barcode"></i> <?php echo $numbre; ?>
									</li><br>
									<li class="list-inline-item">
										<i class="fa fa-book"></i> <?php 

                if (!empty($row['class_id'])) {

                  $stmt_check2 = $connect->prepare("SELECT * FROM classes WHERE id=:class_id");
                  $stmt_check2->bindParam (':class_id' , $row['class_id'] , PDO::PARAM_STR );
                  $stmt_check2->execute();

                  if ($stmt_check2->rowCount() == 1) {

                    $rowget = $stmt_check2->fetch();

                    echo $rowget['name'] ;

                  } else { echo '-' ;}
                    
                } else { echo '-';}


                ?>
									</li><br>
									<li class="list-inline-item">
										<i class="fa fa-calendar"></i> <?php echo $birthday; ?>
									</li><br>
									<li class="list-inline-item">
										<i class="fa fa-globe"></i> <?php echo $address; ?>
									</li><br>

									
								</ul>
							</div>
  
						</div>	
					</div>


			<div class="col-lg-8">

				<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="">La matière</th>
                            <th class="">Point</th>
                        </tr>
                    </thead>
                    <tbody>


<?php 

$marks = $connect->prepare("SELECT * FROM marks WHERE student_id=:student_id ORDER BY id DESC");
$marks->bindParam (':student_id' , $user_id , PDO::PARAM_STR );
$marks->execute();


 while ($rowmarks = $marks->fetch()) { ?>

                        <tr>
              				<td><?php 

                if (!empty($rowmarks['subject_id'])) {

                  $stmt_check3 = $connect->prepare("SELECT * FROM subjects WHERE id=:subject_id");
                  $stmt_check3->bindParam (':subject_id' , $rowmarks['subject_id'] , PDO::PARAM_STR );
                  $stmt_check3->execute();

                  if ($stmt_check3->rowCount() == 1) {

                    $rowget3 = $stmt_check3->fetch();

                    echo $rowget3['name'];

                  } else { echo '-' ;}
                    
                } else { echo '-';}


                ?></td>
              				<td><?php echo $rowmarks['mark']; ?></td>

                        </tr>
<?php } ?>

                    </tbody>
                </table>

						
			</div>


				</div>
			</div>
				

</div>



</div>




<?php } 


else { ?>

      <div class="col-md-8 offset-md-2 bk-right">
								<h4 class="mb-40 text-center">Découvre les résultats des examens</h4>

								<div class='alert alert-danger text-center alert-1'>le numéro d'inscription incorrect</div>

								<form method="POST" action="" accept-charset="UTF-8">
          
									<input class="form-control" type="text" name="numbre" placeholder="le numéro d'inscription" required>
									<button type="submit" name="submit" class="btn btn-default btn-lg btn-block text-center">Consultez vos résultat</button>
								</form>
						</div>

<?php  }


} else { ?>       
						<div class="col-md-8 offset-md-2 bk-right">
								<h4 class="mb-40 text-center">Découvre les résultats des examens</h4>
								<form method="POST" action="" accept-charset="UTF-8">
          
									<input class="form-control" type="text" name="numbre" placeholder="le numéro d'inscription" required>
									<button type="submit" name="submit" class="btn btn-default btn-lg btn-block text-center">Consultez vos résultat</button>
								</form>
						</div>
<?php } ?>

					</div>
				</div>	
			</section>

			

			
			<!-- start footer Area -->		
			<footer class="footer-area mt-40" >
				<div class="container">
					
					<div class="footer-bottom row">
						<p class="footer-text m-0 col-md-12 pb-30 ">
Copyright &copy; 2019 All rights reserved <a href="<?php echo BASE_PATH; ?>" target="_blank"><?php echo $info_row['school_name']; ?></a> | Powered by <a href="https://dabach.net/resultats_plus/" target="_blank">Résultats PLUS</a>
						</p>
					</div>
				</div>
			</footer>	
			<!-- End footer Area -->
<!--
    Powered by Résultats PLUS
    Système de gestion des résultats 
    www.dabach.net
    dabach.net@gmail.com
-->

			<script src="<?php echo BASE_PATH; ?>libs/js/jquery-2.2.4.min.js"></script>

			<script src="<?php echo BASE_PATH; ?>libs/js/bootstrap.min.js"></script>			

  			<script src="<?php echo BASE_PATH; ?>libs/js/easing.min.js"></script>			
			
			<script src="<?php echo BASE_PATH; ?>libs/js/superfish.min.js"></script>	
			
			<script src="<?php echo BASE_PATH; ?>libs/js/jquery.magnific-popup.min.js"></script>	
			
			<script src="<?php echo BASE_PATH; ?>libs/js/jquery.counterup.min.js"></script>			
				
			<script src="<?php echo BASE_PATH; ?>libs/js/main.js"></script>	
			
	</body>
</html>