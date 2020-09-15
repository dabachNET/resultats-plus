<?php session_start();


if (!isset($_SESSION ['admin_panel'])) {
  header("location: login.php") ;
  die('Stop using NoRedirect Tools!');
}


$title = 'Les résultats'; include 'header.php'; ?>

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

<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i> Ajouter</button>
<div class="clearfix"></div><br>

<?php if(isset($_GET['alert'])) { ?>

  <?php if($_GET['alert'] == 'error') { ?>

  <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
    <strong><?php echo $_GET['msg']; ?></strong>
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
        <h5 class="modal-title" id="exampleModalLabel">Ajouter</h5>
        <button onclick="refresh();" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form id="myForm" method="POST" action="action_mr.php" accept-charset="UTF-8">

      <input type="hidden" name="_token" value="<?php echo ENCRYPTION_KEY; ?>"> 

      <div class="modal-body">

        
          <div class="form-group to-hide">
            <label>Classe</label>
            <select name="class_id" id="class_id" class="form-control" required="required">
              <option value="" selected>choisir...</option>

<?php $classes = $connect->query("SELECT * FROM classes ORDER BY id DESC"); ?>
<?php while ($class_row = $classes->fetch()) { ?>           
              <option value="<?php echo $class_row['id']; ?>"><?php echo $class_row['name']; ?></option>
<?php } ?>

            </select>
          </div>


          <div class="form-group student to-hide">
            <label class="control-label">étudiant: </label>
              <select name="student_id" id="student" class="form-control input-lg" required>
                <option value="">Tous les étudiants</option>
              </select>
          </div>

          <div class="form-group subject to-hide">
            <label class="control-label">Matière: </label>
              <select name="subject_id" id="subject" class="form-control input-lg" required>
                <option value="">Tous les matières</option>
              </select>
          </div>



<script type="text/javascript">
$(document).ready(function () { 

            $('#class_id').on('change',function(e){
            var class_id = e.target.value;

            $(".student").css ({"display":"block"});
            $(".subject").css ({"display":"block"});

            $.ajax({
            type: "GET",
            url: "<?php echo BASE_PATH; ?>/admin/ajax-class.php?class_id="+class_id,
                success: function(data) {  

                    $('#student').empty();
                    ajax.parseJSON(data);


                }

            });

            var ajax = { 
              parseJSON:function(data)
              { 

                for (var i = 0; i < data.length; i++) {
                      $('#student').append('<option value ="'+data[i].id+'">'+data[i].fullname+'</option>')

                    }
              }
            }


            $.ajax({
            type: "GET",
            url: "<?php echo BASE_PATH; ?>/admin/ajax-class.php?subject_id="+class_id,
                success: function(data2) {  

                    $('#subject').empty();
                    ajax2.parseJSON(data2);

                }

            });

            var ajax2 = { 
              parseJSON:function(data2)
              { 

                for (var i = 0; i < data2.length; i++) {
                      $('#subject').append('<option value ="'+data2[i].id+'">'+data2[i].name+'</option>')

                    }
              }
            }


        });
});
</script>

          <div class="form-group">
            <label class="col-form-label">Le point:</label>
            <input name="mark" type="text" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['mark'])) ? htmlspecialchars($_POST['mark']) : ''?>" required>
          </div>


          <div class="form-group">
            <div id="resultajax" class="text-center"></div>
          </div>

        
      </div>
      <div class="modal-footer">
        <button onclick="refresh();" type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="submit" name="submit" class="btn btn-success">Enregistrer</button>
      </div>
      
      </form>



<script type="text/javascript">
      

        $('#myForm').submit(function(event) {

          event.preventDefault();

          $('#resultajax').append('<img src="../libs/img/loader.gif" alt="please wait ..">');

          $('#myForm .to-hide').hide();

          
           $.ajax({
            type: 'POST',
            url: '<?php echo BASE_PATH; ?>admin/action_mr.php',
            data: $(this).serialize(),

            success: function(data) {
                        
                if(data == 'true') {   
                  $('#resultajax').html("<div class='alert alert-success text-center'><strong>Ajouter avec succès.</strong></div>");
                  $('#myForm .to-hide').show();
                 }

                if(data == 'false') {
                  $('#resultajax').html("<div class='alert alert-danger text-center'><strong>La matières que vous avez ajouté a déjà une moyenne</strong></div>");
                  $('#myForm .to-hide').show();
                }  
                                     
              }

            });
                          
          });

          function refresh() {
            window.location='<?php echo BASE_PATH . 'admin/marks.php'; ?>';
          }

</script>

      

    </div>
  </div>
</div>





<div class="card">
  <h5 class="card-header">Les résultats</h5>
  <div class="card-body">




<div class="table-responsive">
        <table id="example" class="table" style="width:100%">
        <thead class="thead-dark">
            <tr>
                <th>étudiant</th>
                <th>Classe</th>
                <th>Matière</th>
                <th>Point</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

<?php $marks = $connect->query("SELECT * FROM marks ORDER BY id DESC"); ?>

<?php while ($row = $marks->fetch()) { ?>

            <tr>

                <td><?php 

                if (!empty($row['student_id'])) {

                  $stmt_check1 = $connect->prepare("SELECT * FROM users WHERE id=:student_id");
                  $stmt_check1->bindParam (':student_id' , $row['student_id'] , PDO::PARAM_STR );
                  $stmt_check1->execute();

                  if ($stmt_check1->rowCount() == 1) {

                    $rowget1 = $stmt_check1->fetch();

                    echo $rowget1['fullname'];

                  } else { echo '-' ;}
                    
                } else { echo '-';}


                ?></td>


                <td><?php 

                if (!empty($row['class_id'])) {

                  $stmt_check2 = $connect->prepare("SELECT * FROM classes WHERE id=:class_id");
                  $stmt_check2->bindParam (':class_id' , $row['class_id'] , PDO::PARAM_STR );
                  $stmt_check2->execute();

                  if ($stmt_check2->rowCount() == 1) {

                    $rowget2 = $stmt_check2->fetch();

                    echo $rowget2['name'];

                  } else { echo '-' ;}
                    
                } else { echo '-';}


                ?></td>

                <td><?php 

                if (!empty($row['subject_id'])) {

                  $stmt_check3 = $connect->prepare("SELECT * FROM subjects WHERE id=:subject_id");
                  $stmt_check3->bindParam (':subject_id' , $row['subject_id'] , PDO::PARAM_STR );
                  $stmt_check3->execute();

                  if ($stmt_check3->rowCount() == 1) {

                    $rowget3 = $stmt_check3->fetch();

                    echo $rowget3['name'];

                  } else { echo '-' ;}
                    
                } else { echo '-';}


                ?></td>


                <td><?php echo $row['mark']; ?></td>


                <td style="width:15%">
                  <button class="btn btn-danger btn-sm m-1" data-toggle="modal" data-target="#exampleModal_<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></button>

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

<form method="POST" action="action_mr.php" accept-charset="UTF-8">
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