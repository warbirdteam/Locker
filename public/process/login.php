<?php
//require_once('../bootstrap.php');
//use Cascade\Cascade;
session_start();
include_once(__DIR__ . "\..\..\includes\autoloader.inc.php");



if (isset($_POST['apikey']) && !empty($_POST['apikey'])) {
	$api = $_POST['apikey'];
	$login = new db_login($api);
	$row = $login->login();

	if(!empty($row)) {
		$_SESSION['userid'] = $row['tornid'];
		$_SESSION['role'] = $row['userrole'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['factionid'] = $row['factionid'];
		//Cascade::getLogger('audit')->info('Successful login.', ['user' => $user_email]);
		header("Location: ../welcome.php");
		exit();
	} else {
		//Cascade::getLogger('audit')->info('Failed login.', ['user' => $user_email]);
		$error = new Error_Message("No user found. You are not registered.","../index.php");
	}
}
$error = new Error_Message("You did not enter anything into the API textbox.","../index.php");
?>
