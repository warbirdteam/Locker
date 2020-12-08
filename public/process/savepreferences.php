<?php
session_start();
if(!isset($_SESSION['siteID'])){
  $_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: ../index.php");
}

include_once(__DIR__ . "/../../includes/autoloader.inc.php");

$share_api = isset($_POST['share_api']) && $_POST['share_api'] == 1 ? 1 : 0;

$db_request = new db_request();
$db_request->updateSiteUserPreferencesBySiteID($_SESSION['siteID'], $share_api);

?>
