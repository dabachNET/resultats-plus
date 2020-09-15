<?php session_start();


if (!isset($_SESSION ['admin_panel'])) {
  header("location: login.php") ;
  die('Stop using NoRedirect Tools!');
}

$title = 'Les matières'; include 'header.php'; ?>

<link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/js/datatables/dataTables.bootstrap4.min.css">
<script src="<?php echo BASE_PATH; ?>libs/js/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_PATH; ?>libs/js/datatables/dataTables.bootstrap4.min.js"></script>

  <script type="text/javascript" class="init">
  $(document).ready(function() {
    $("#example").dataTable({ "language": { "url": "<?php echo BASE_PATH; ?>libs/js/datatables/lang/fr.json" }
    });
  });
  </script>


 
<div class="col-md-12">

<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-plus"></i> Nouvelle matière</button>
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
    <strong>Supprimer avec succès</strong>
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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nouvelle matière</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="action_sb.php" accept-charset="UTF-8">

      <input type="hidden" name="_token" value="<?php echo ENCRYPTION_KEY; ?>"> 

      <div class="modal-body">

          <div class="form-group">
            <label for="forclass_id">Classe</label>
            <select name="class_id" id="forclass_id" class="form-control" required="required">
              <option value="" selected>choisir...</option>

<?php $classes = $connect->query("SELECT * FROM classes ORDER BY id DESC"); ?>
<?php while ($class_row = $classes->fetch()) { ?>           
              <option value="<?php echo $class_row['id']; ?>"><?php echo $class_row['name']; ?></option>
<?php } ?>

            </select>
          </div>

          <div class="form-group">
            <label for="name" class="col-form-label">Nom de la matière:</label>
            <input name="name" type="text" class="form-control" id="name" value="<?php echo htmlspecialchars(!empty($_POST['name'])) ? htmlspecialchars($_POST['name']) : ''?>" required>
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
  <h5 class="card-header">matières</h5>
  <div class="card-body">




<div class="table-responsive">
        <table id="example" class="table" style="width:100%">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nom de la matière</th>
                <th>Classe</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

<?php $subjects = $connect->query("SELECT * FROM subjects ORDER BY id DESC"); ?>

<?php while ($row = $subjects->fetch()) { ?>

            <tr>
                <td style="width:5%"><?php echo $row['id']; ?></td>

                <td><?php echo $row['name']; ?></td>

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

                <td style="width:15%"><button class="btn btn-danger btn-sm m-1" data-toggle="modal" data-target="#exampleModal_<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></button></td>
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

<form method="POST" action="action_sb.php" accept-charset="UTF-8">
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