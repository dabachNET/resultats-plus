<?php session_start();


if (!isset($_SESSION ['admin_panel'])) {
  header("location: login.php") ;
  die('Stop using NoRedirect Tools!');
}

$title = 'Paramètres'; include 'header.php'; ?>

<?php 

$stmt_get_info = $connect->prepare("SELECT * FROM settings WHERE id=1");
$stmt_get_info->execute();
$info_row = $stmt_get_info->fetch();


$stmt_get_admin = $connect->prepare("SELECT * FROM users WHERE is_admin=1");
$stmt_get_admin->execute();
$admin_row = $stmt_get_admin->fetch();



?>




<?php if(isset($_GET['alert'])) { ?>

  <?php if($_GET['alert'] == 'error') { ?>

  <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
    <strong><?php echo $_GET['msg']; ?></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

  <?php } ?>


  <?php if($_GET['alert'] == 'success') { ?>
  <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
    <strong>Modifié avec succèss.</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <?php } ?>



<?php } ?>





<div class="card">
  <h5 class="card-header">Paramètres</h5>
  <div class="card-body col-md-12">

<form method="POST" action="action_sg.php" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="<?php echo ENCRYPTION_KEY; ?>"> 

  <h4 class="text-dark">Réglages généraux:</h4>
  <div class="clearfix"></div><hr>

  <div class="form-group">
    <label class="col-form-label">Nom de l'école:</label>
    <input name="school_name" type="text" class="form-control" value="<?php echo $info_row['school_name']; ?>">
  </div>

  <div class="form-group">
    <label class="col-form-label">Courriel de l'école:</label>
    <input name="school_email" type="text" class="form-control" value="<?php echo $info_row['school_email']; ?>">
  </div>

  <div class="form-group">
    <label class="col-form-label">Téléphone:</label>
    <input name="school_phone" type="text" class="form-control" value="<?php echo $info_row['school_phone']; ?>">
  </div>

  <div class="form-group">
    <label for="forImage">Logo de l'école</label>
    <div class="custom-file">
      <input type="file" name="school_logo" class="custom-file-input" id="forImage">
      <label class="custom-file-label" for="customFile">Choisissez le logo</label>
    </div>
  </div>

  

<?php 
    if (!empty($info_row['school_logo'])) {
      echo '<div class="from-group mb-30"><img src="'.BASE_PATH.'libs/img/'.$info_row['school_logo'].'" class="img-thumbnail img-responsive" width="200px" ></div>';
    } 
?>

    



  <div class="form-group">
    <button type="submit" name="submit" class="btn btn-success">Mise à jour</button>
  </div><div class="clearfix"></div>

  <h4 class="text-dark mt-40">Paramètres d'administration:</h4>
  <div class="clearfix"></div><hr>

  <div class="form-group">
    <label class="col-form-label">Ancien mot de passe:</label>
    <input name="admin_oldpassword" type="password" class="form-control" value="">
  </div>

  <div class="form-group">
    <label class="col-form-label">Email:</label>
    <input name="admin_email" type="text" class="form-control" value="<?php echo $admin_row['email']; ?>" >
  </div>

  <div class="form-group">
    <label class="col-form-label">Nouveau mot de passe:</label>
    <input name="admin_password" type="password" class="form-control" >
  </div>

  <div class="form-group">
    <button type="submit"  name="submit" class="btn btn-danger">Mise à jour</button>
  </div>


</form>

  </div>
</div>


<?php include 'footer.php'; ?>