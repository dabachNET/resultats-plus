<?php session_start();

include '../includes/config.php';

if (isset($_SESSION ["admin_panel"])) {
    session_destroy();
    header("location: ../index.php");
    die();
}


else {
	header("location: ../index.php");
    die();
}

 ?>