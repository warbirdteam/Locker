<?php
session_start();
if(!isset($_SESSION['siteID'])){
  $_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: ../index.php");
}

if ($_SESSION['roleValue'] <= 2) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
}

include_once(__DIR__ . "/../../includes/autoloader.inc.php");

$revives = isset($_POST['revives']) && $_POST['revives'] == 1 ? 1 : 0;
$assists = isset($_POST['assists']) && $_POST['assists'] == 1 ? 1 : 0;
$akwars = isset($_POST['akwars']) && $_POST['akwars'] == 1 ? 1 : 0;


$db_request = new db_request();
$db_request->updateToggleStatusByName('revives', $revives);
$db_request->updateToggleStatusByName('assists', $assists);
$db_request->updateToggleStatusByName('akwars', $akwars);

?>
