<?php session_start();


if (!isset($_SESSION ['admin_panel'])) {
  header("location: login.php") ;
  die('Stop using NoRedirect Tools!');
}

$title = 'Les étudiants'; include 'header.php'; ?>

<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/js/datatables/dataTables.bootstrap4.min.css">
<script src="<?php echo BASE_PATH; ?>libs/js/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_PATH; ?>libs/js/datatables/dataTables.bootstrap4.min.js"></script>

  <script type="text/javascript" class="init">
  $(document).ready(function() {
    $("#example").dataTable({ "language": { "url": "<?php echo BASE_PATH; ?>libs/js/datatables/lang/fr.json" }
    });
  });
  </script>

<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/js/datepicker/css/bootstrap-datepicker.css">
<script src="<?php echo BASE_PATH; ?>libs/js/datepicker/js/bootstrap-datepicker.js"></script>


<script type="text/javascript">
$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    startDate: '-3d'
});
</script>

 
<div class="col-md-12">

<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i> Nouvel étudiant</button>
<div class="clearfix"></div><br>

<?php if(isset($_GET['alert'])) { ?>

  <?php if($_GET['alert'] == 'error') { ?>

  <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
    <strong>Erreur! réessayer..</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

  <?php } ?>

  <?php if($_GET['alert'] == 'delete') { ?>

  <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
    <strong>Supprimer avec succès.</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

  <?php } ?>

  <?php if($_GET['alert'] == 'success') { ?>
  <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
    <strong>Ajouter avec succès.</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <?php } ?>



<?php } ?>





<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nouvel étudiant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form method="POST" action="action_st.php" enctype="multipart/form-data">

      <input type="hidden" name="_token" value="<?php echo ENCRYPTION_KEY; ?>"> 

      <div class="modal-body">

          <div class="form-group">
            <label class="col-form-label">Nom et prénom:</label>
            <input name="fullname" type="text" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['fullname'])) ? htmlspecialchars($_POST['fullname']) : ''?>" required>
          </div>

          <div class="form-group">
            <label class="col-form-label">Numéro d'inscription:</label>
            <input name="user_num" type="text" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['user_num'])) ? htmlspecialchars($_POST['user_num']) : ''?>" required>
          </div>

          <div class="form-group">
            <label for="forclass_id">Classe</label>
            <select name="class_id" id="forclass_id" class="form-control" required="required">
              <option value="" selected>Choisir...</option>

<?php $classes = $connect->query("SELECT * FROM classes ORDER BY id DESC"); ?>
<?php while ($class_row = $classes->fetch()) { ?>           
              <option value="<?php echo $class_row['id']; ?>"><?php echo $class_row['name']; ?></option>
<?php } ?>

            </select>
          </div>


          <div class="form-group">
            <label class="col-form-label">Date de naissance:</label>
            <input name="birthday" type="text" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['birthday'])) ? htmlspecialchars($_POST['birthday']) : ''?>" data-provide="datepicker" data-date-format="dd/mm/yyyy" >
          </div>


          <div class="form-group">
            <label class="col-form-label">Adresse:</label>
            <input name="address" type="text" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['address'])) ? htmlspecialchars($_POST['address']) : ''?>">
          </div>

          <div class="form-group">
            <label for="forImage">Image</label>
              <div class="custom-file">
                <input type="file" name="image" class="custom-file-input" id="forImage">
                <label class="custom-file-label" for="customFile">Choose image</label>
              </div>
          </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="submit" name="submit" class="btn btn-success">Enregistrer</button>
      </div>
      
      </form>
      

    </div>
  </div>
</div>





<div class="card">
  <h5 class="card-header">Les étudiants</h5>
  <div class="card-body">




<div class="table-responsive">
        <table id="example" class="table" style="width:100%">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nom et prénom</th>
                <th>Numéro d'inscription</th>
                <th>Classe</th>
                <th>Bulletin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

<?php $students = $connect->query("SELECT * FROM users where is_student=1 ORDER BY id DESC"); ?>

<?php while ($row = $students->fetch()) { ?>

            <tr>

<td ><?php 

    if (!empty($row['image'])) {
      echo '<img src="'.BASE_PATH.'uploads/'.$row['image'].'" class="img-circle" width="35px" height="35px">';
    } else {
      echo '<img src="'.BASE_PATH.'uploads/default.png" class="img-circle" width="35px" height="35px">';
    } 
?></td>

                <td><?php echo $row['fullname']; ?></td>

                <td><?php echo $row['user_num']; ?></td>

                <td><?php 

                if (!empty($row['class_id'])) {

                  $stmt_check = $connect->prepare("SELECT * FROM classes WHERE id=:class_id");
                  $stmt_check->bindParam (':class_id' , $row['class_id'] , PDO::PARAM_STR );
                  $stmt_check->execute();

                  if ($stmt_check->rowCount() == 1) {

                    $rowget = $stmt_check->fetch();

                    echo '<span class="badge badge-primary">' . $rowget['name'] . '</span>';

                  } else { echo '-' ;}
                    
                } else { echo '-';}


                ?></td>

                <td style="width:15%">
                  <a class="btn btn-primary btn-sm m-1" href="student_mark.php?id=<?php echo $row['id'];  ?>" onclick="window.open('student_mark.php?id=<?php echo $row['id'];  ?>', 'newwindow', 'width=980,height=720'); return false;" ><i class="fa fa-file-o"></i></a>

                </td>

                <td style="width:15%">
                  <a class="btn btn-success btn-sm m-1" href="student_update.php?id=<?php echo $row['id'];  ?>"><i class="fa fa-edit"></i></a><button class="btn btn-danger btn-sm m-1" data-toggle="modal" data-target="#exampleModal_<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></button>

                </td>
            </tr>


<!-- Modal -->
<div class="modal fade" id="exampleModal_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Supprimer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

<form method="POST" action="action_st.php" accept-charset="UTF-8">
<input type="hidden" name="_token" value="<?php echo ENCRYPTION_KEY; ?>">
<input type="hidden" name="id_delete" value="<?php echo $row['id']; ?>">

       <button type="submit" name="delete" class="btn btn-danger btn-block" ><i class="fa fa-trash"></i> Supprimer</button>

</form>

      </div>
    </div>
  </div>
</div>


<?php } ?>

        </tbody>

    </table>
</div>
    




  </div>
</div>
        
</div> 




<?php include 'footer.php'; ?>