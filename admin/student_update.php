<?php session_start();


if (!isset($_SESSION ['admin_panel'])) {
  header("location: login.php") ;
  die('Stop using NoRedirect Tools!');
}


if (isset($_GET['id'])) {  

$title = 'Les étudiants'; include 'header.php'; 


require_once '../includes/config.php';
require_once '../includes/display_errors.php';

$user_id = htmlspecialchars($_GET['id']);

$stmt_for_check = $connect->prepare("SELECT * FROM users WHERE id=:id");
$stmt_for_check->bindParam (':id' , $user_id , PDO::PARAM_STR );
$stmt_for_check->execute();

if ($stmt_for_check->rowCount() == 1) {

$row = $stmt_for_check->fetch();


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
  <h5 class="card-header"><?php echo $row['fullname']; ?></h5>
  <div class="card-body col-md-12">

<form method="POST" action="action_st_update.php" class="row" enctype="multipart/form-data">

  <input type="hidden" name="_token" value="<?php echo ENCRYPTION_KEY; ?>"> 
  <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>"> 


        <div class="col-md-6">
          <div class="form-group">
            <label class="col-form-label">Nom et prénom:</label>
            <input name="fullname" type="text" class="form-control" value="<?php echo $row['fullname']; ?>" required>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label class="col-form-label">Numéro d'inscription:</label>
            <input name="user_num" type="text" class="form-control" value="<?php echo $row['user_num']; ?>" required>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label class="col-form-label">Date de naissance:</label>
            <input name="birthday" type="text" class="form-control" value="<?php echo $row['birthday']; ?>" data-provide="datepicker" data-date-format="dd/mm/yyyy" >
          </div>
        </div>

        
        <div class="col-md-6">
          <div class="form-group">
            <label for="forclass_id">Classe</label>
            <select name="class_id" id="forclass_id" class="form-control" required="required">

              <?php 

                if (!empty($row['class_id'])) {

                  $stmt_check = $connect->prepare("SELECT * FROM classes WHERE id=:class_id");
                  $stmt_check->bindParam (':class_id' , $row['class_id'] , PDO::PARAM_STR );
                  $stmt_check->execute();

                  if ($stmt_check->rowCount() == 1) {

                    $rowget = $stmt_check->fetch();

                    echo '<option  style="background-color: #c9c9c9; font-weight: bold; color: #c55" value="' . $rowget['id'] . '" selected>' . $rowget['name'] . '</option>';

                  } else { echo '<option value="" selected>Choisir...</option>' ;}
                    
                } else { echo '<option value="" selected>Choisir...</option>';}


                ?>

<?php $classes = $connect->query("SELECT * FROM classes ORDER BY id DESC"); ?>
<?php while ($class_row = $classes->fetch()) { ?>           
              <option value="<?php echo $class_row['id']; ?>"><?php echo $class_row['name']; ?></option>
<?php } ?>

            </select>
          </div>
        </div>


        <div class="col-md-12">
          <div class="form-group">
            <label class="col-form-label">Adresse:</label>
            <input name="address" type="text" class="form-control" value="<?php echo $row['address']; ?>">
          </div>
        </div>
          


         <div class="col-md-6">
           <div class="form-group">
            <label for="forImage">Image</label>
              <div class="custom-file">
                <input type="file" name="image" class="custom-file-input" id="forImage">
                <label class="custom-file-label" for="customFile">Choose image</label>
              </div>
          </div>

<?php 
    if (!empty($row['image'])) {
      echo '<div class="from-group mb-30"><img src="'.BASE_PATH.'uploads/'.$row['image'].'" class="img-thumbnail img-responsive" width="200px" ></div>';
    } 
?>

         </div> 


        <div class="col-md-12">
          <div class="form-group">
            <button type="submit" name="submit" class="btn btn-success">Mise à jour</button>
          </div>
        </div>    

          
</form>

  </div>
</div>


<?php include 'footer.php'; ?>


<?php } else echo 'étudiant non trouvé.'; } ?>