<?php
session_start();
include_once("db_connect.php");
if(isset($_POST['login_button'])) {
	$user_email = trim($_POST['user_email']);
	$user_password = sha1(trim($_POST['password']));
	//$enc = sha1($user_password);
	
	$sql = "SELECT tornid, username, password, useremail FROM users WHERE useremail='$user_email' and password='$user_password'";
	$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
	$row = mysqli_fetch_assoc($resultset);	
		
	if($row['password']==$user_password){				
		echo "ok";
		$_SESSION['user_session'] = $row['tornid'];
	} else {				
		echo "email or password does not exist."; // wrong details 
	}		
}
?>