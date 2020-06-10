<?php
//require_once('../bootstrap.php');
//use Cascade\Cascade;
session_start();
include_once("../../includes/autoloader.inc.php");



if (isset($_POST['apikey']) && !empty($_POST['apikey'])) {
	$api = $_POST['apikey'];
	$register = new db_login($api);
	$register->register();
}

$error = new Error_Message("You did not enter anything into the API textbox.","../index.php");
?>
