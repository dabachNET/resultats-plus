<?php session_start();


if (!isset($_SESSION ['admin_panel'])) {
  header("location: login.php") ;
  die('Stop using NoRedirect Tools!');
}

if (isset($_GET['id'])) { 

require_once '../includes/config.php';
require_once '../includes/display_errors.php';


$user_id = htmlspecialchars($_GET['id']);

$stmt_for_check = $connect->prepare("SELECT * FROM users WHERE id=:id");
$stmt_for_check->bindParam (':id' , $user_id , PDO::PARAM_STR );
$stmt_for_check->execute();

if ($stmt_for_check->rowCount() == 1) {


$row1 = $stmt_for_check->fetch();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
   
    <title>Bulletin</title>
  

  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>libs/css/bootstrap.css">


</head>
<body onload="window.print(); ">



<style type="text/css">

.print {margin-bottom: 0; padding-bottom: 0;}


body {
    background-color: #FFFFFF;
  margin:0;
}



@media print {
   body {
     /*  display: table;*/
    /*   table-layout: fixed; */
       padding-top: 0cm;
       padding-bottom: 0cm;
       height: auto;
   }

   img.img-thumbnail { width: 20%; margin-left: 1%; overflow: all;}

   btt.table {
    width: 80%;
    }


}


@page {
    size: auto;   /* auto is the initial value */
    margin: 1mm;  /* this affects the margin in the printer settings */
}



table { page-break-inside:auto }
tr    { page-break-inside:avoid; page-break-after:auto }
thead { display:table-header-group }
tfoot { display:table-footer-group }


</style>





<div class="col-md-12">
    
    <div class="table-responsive">

          <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
                <h2>
                    <small>Nom et prénom: <?php echo $row1['fullname']; ?></small><br>
                    <small>Date de naissance: <?php echo $row1['birthday']; ?></small><br>
                </h2>
            </div><!-- /.col -->

            <div class="col-md-6">
                <h2>
                    <small>Numéro d'inscription: <?php echo $row1['user_num']; ?></small><br>
                    <small>Classe: <?php 

                if (!empty($row1['class_id'])) {

                  $stmt_check = $connect->prepare("SELECT * FROM classes WHERE id=:class_id");
                  $stmt_check->bindParam (':class_id' , $row1['class_id'] , PDO::PARAM_STR );
                  $stmt_check->execute();

                  if ($stmt_check->rowCount() == 1) {

                    $rowget = $stmt_check->fetch();

                    echo '<span class="badge badge-primary">' . $rowget['name'] . '</span>';

                  } else { echo '-' ;}
                    
                } else { echo '-';}


                ?></small>
                </h2>
            </div><!-- /.col -->
          </div>
          </div>


 <div class="clear"></div><hr>

 <h3>Bulletin de notes:</h3>

            <div class="col-xs-12 table-responsive">

<?php 

$marks = $connect->prepare("SELECT * FROM marks WHERE student_id=:student_id ORDER BY id DESC");
$marks->bindParam (':student_id' , $user_id , PDO::PARAM_STR );
$marks->execute();

?>



                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="">La matière</th>
                            <th class="">Point</th>
                        </tr>
                    </thead>
                    <tbody>


<?php while ($row = $marks->fetch()) { ?>

                        <tr>
              <td>
                            <?php 

                if (!empty($row['subject_id'])) {

                  $stmt_check3 = $connect->prepare("SELECT * FROM subjects WHERE id=:subject_id");
                  $stmt_check3->bindParam (':subject_id' , $row['subject_id'] , PDO::PARAM_STR );
                  $stmt_check3->execute();

                  if ($stmt_check3->rowCount() == 1) {

                    $rowget3 = $stmt_check3->fetch();

                    echo $rowget3['name'];

                  } else { echo '-' ;}
                    
                } else { echo '-';}


                ?>
                  
                </td>

                            <td><?php echo $row['mark']; ?></td>

                        </tr>


<?php } ?>

                    </tbody>
                </table>





            </div><!-- /.col -->



    </div>
  </div>


</body>
</html>

<?php } } ?>