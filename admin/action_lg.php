<?php 
session_start();

if (isset($_POST['submit'])) {

require '../includes/config.php';
include '../includes/display_errors.php';

$_token = htmlspecialchars($_POST['_token']);
$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

if ($_token == ENCRYPTION_KEY) {

	$stmt_login = $connect->prepare("SELECT * FROM users WHERE username=:username");
    $stmt_login->bindParam (':username' , $username , PDO::PARAM_STR );
    $stmt_login->execute();

    if ($stmt_login->rowCount() == 1) {

    	$admin_fetch = $stmt_login->fetch();

    	if (password_verify($password, $admin_fetch['password'])) {

    		$rand = md5(uniqid(rand()));
    		$_SESSION ['admin_panel'] = $rand;

    		header("location: index.php");
        	die();

    	} else {
    		header("location: login.php?alert=error&msg=Vérifiez que votre nom d'utilisateur ou mot de passe est correct");
        	die();
    	}

    } else {
    	header("location: login.php?alert=error&msg=Vérifiez que votre nom d'utilisateur ou mot de passe est correct");
        	die();
    }


} else {
	die();
}

}


 ?>