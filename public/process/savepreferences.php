<?php
//start the session array
session_start();
//If cannot find site ID, empty session array and send to login page with error message
if(!isset($_SESSION['siteID'])){
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
	exit;
}

include_once(__DIR__ . "/../../includes/autoloader.inc.php");

$share_api = isset($_POST['share_api']) && $_POST['share_api'] == 1 ? 1 : 0;

$db_request = new db_request();
$db_request->updateSiteUserPreferencesBySiteID($_SESSION['siteID'], $share_api);

?>
