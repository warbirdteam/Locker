<?php
//require_once('bootstrap.php');
//use Cascade\Cascade;
session_start();
include_once(__DIR__ . "/../../includes/autoloader.inc.php");



if (isset($_POST['apikey']) && !empty($_POST['apikey'])) {
	$api = $_POST['apikey'];

	$register = new DB_register($api);

}

$error = new Error_Message("You did not enter anything into the API Textbox.","register.php");
?>
