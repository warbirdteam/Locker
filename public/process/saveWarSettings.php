<?php
//##### LEADERSHIP & ADMIN ONLY PAGE
//start the session array
session_start();
//If cannot find site ID, empty session array and send to login page with error message
if(!isset($_SESSION['siteID'])){
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
	exit;
}
if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership') {
	//##### LEADERSHIP & ADMIN ONLY PAGE
  //load classes files in classes folder
  include_once(__DIR__ . "/../../misc/getFriendlyFactionMembers.php");
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: ../welcome.php");
  exit;
}

$revives = isset($_POST['revives']) && $_POST['revives'] == 1 ? 1 : 0;
$assists = isset($_POST['assists']) && $_POST['assists'] == 1 ? 1 : 0;
$akwars = isset($_POST['akwars']) && $_POST['akwars'] == 1 ? 1 : 0;
$assist_api = isset($_POST['assist_api']) && $_POST['assist_api'] == 1 ? 1 : 0;



$db_request = new db_request();
$db_request->updateToggleStatusByName('revives', $revives);
$db_request->updateToggleStatusByName('assists', $assists);
$db_request->updateToggleStatusByName('akwars', $akwars);
$db_request->updateToggleStatusByName('assist_api', $assist_api);


?>
