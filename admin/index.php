<?php session_start();


if (!isset($_SESSION ['admin_panel'])) {
  header("location: login.php") ;
  die('Stop using NoRedirect Tools!');
}

$title = 'Administration'; include 'header.php'; 

$students = $connect->query("SELECT * FROM users where is_student=1 ORDER BY id DESC");
$classes = $connect->query("SELECT * FROM classes ORDER BY id DESC");
$marks = $connect->query("SELECT * FROM marks ORDER BY id DESC");
$subjects = $connect->query("SELECT * FROM subjects ORDER BY id DESC");

?>



<div class="col-md-12">
<div class="row">

        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon orange-bg"><i class="fa fa-graduation-cap"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">étudiants</span>
              <span class="info-box-number"><?php echo $students->rowCount(); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon red-bg"><i class="fa fa-th-large"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">classes</span>
              <span class="info-box-number"><?php echo $classes->rowCount(); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

      


        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon purple-bg"><i class="fa fa-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">matières</span>
              <span class="info-box-number"><?php echo $subjects->rowCount(); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>


        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon green-bg"><i class="fa fa-file-text"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">résultats</span>
              <span class="info-box-number"><?php echo $marks->rowCount(); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->


</div>
</div>


<?php include 'footer.php'; ?>