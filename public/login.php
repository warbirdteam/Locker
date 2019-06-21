<?php
session_start();
include_once("../misc/db_connect.php");
if(isset($_POST['login_button'])) {
	$user_email = trim($_POST['user_email']);
	$user_password = sha1(trim($_POST['password']));
	//$enc = sha1($user_password);
	
	$sql = "SELECT tornid, username, password, tornuserkey, userrole, useremail FROM users WHERE useremail='$user_email' and password='$user_password'";
	$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
	$num_rows = mysqli_num_rows($resultset);
	$row = mysqli_fetch_assoc($resultset);	
		
	if($num_rows == 1){				
		echo "ok";
		$_SESSION['user_session'] = $row['tornid'];
		$_SESSION['key'] = $row['tornuserkey'];
		$_SESSION['role'] = $row['userrole'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['useremail'] = $row['useremail'];
	} else {				
		echo "email or password does not exist."; // wrong details 
	}		
}
?>
