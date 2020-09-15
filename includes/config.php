<?php 
	/** 
	Configuration
	Copyright © 2019 Résultats PLUS. All Rights Reserved.
	Developed by DABACH NET - dabach.net@gmail.com - www.dabach.net
	*/
 
	// BASE_PATH with / at the end of link  
	 define( 'BASE_PATH', 'http://localhost/'); 
	 define( 'ENCRYPTION_KEY', 'j7F3CQWqMS62NoxpbdwiKgtaYEyXfcvh'); 
 
	 $DB_SERVER = "localhost"; 
	 $DB_USER = ""; 
	 $DB_PASS = ""; 
	 $DB_DATABASE = ""; 
	 $INSTALL = false; 
 
	 try { 
	 $connect =  new PDO("mysql:host=$DB_SERVER; dbname=$DB_DATABASE", $DB_USER,$DB_PASS); 
	 } 
 
	 catch (PDOException $e) { 
	 if ($INSTALL == false) { 
	 include 'install/index.php'; 
	 die(); 
	 } else { 
	 die("Database Error..!"); } 
	 } 
 
	 $connect->query("set charcter_set_server = 'utf8'"); 
	 $connect->query("set names'utf8' "); 

 
?>