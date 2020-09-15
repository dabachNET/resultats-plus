<?php session_start();

if (isset($_SESSION ['admin_panel'])) {
  header("location: index.php") ;
  die();
}


$title = 'LOGIN'; include 'header.php'; 


?>



<div class="col-md-12">
<div class="row">

        
            <div class="col-md-4 offset-md-4 bk-right">
                <h4 class="mb-50 text-center">LOGIN</h4>



<?php if(isset($_GET['alert'])) { ?>

  <?php if($_GET['alert'] == 'error') { ?>

  <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
    <strong><?php echo $_GET['msg']; ?></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

  <?php } ?>

<?php } ?>



                <form method="POST" action="action_lg.php" accept-charset="UTF-8">
                  
                  <input type="hidden" name="_token" value="<?php echo ENCRYPTION_KEY; ?>">

                  <input class="form-control" type="text" name="username" placeholder="Username" required>
                  <input class="form-control" type="password" name="password" placeholder="Password" required>

                  <button type="submit" name="submit" class="btn btn-default btn-lg btn-block text-center">Login</button>

                </form>
            </div>

</div>
</div>


<?php include 'footer.php'; ?>