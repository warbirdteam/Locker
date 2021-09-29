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
	include_once(__DIR__ . "/../../includes/autoloader.inc.php");
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: ../welcome.php");
	exit;
}


if (isset($_POST['friendlyRemove']) && !empty($_POST['friendlyRemove']) && is_numeric($_POST['friendlyRemove'])) {
    $fid = $_POST['friendlyRemove'];

    $db_request_check_enemy_faction = new db_request();
    $faction = $db_request_check_enemy_faction->getFriendlyFactionByFactionID($fid);

    if (!empty($faction)) {
      $db_request_remove_faction = new db_request();
      $db_request_remove_faction->removeFriendlyFactionByFactionID($fid);
      $db_request_remove_faction->removeAllFriendlyMembersByFactionID($fid);


      $success = new Success_Message("Friendly Faction <b>". $faction['factionName'] . " [" . $faction['factionID'] . "]</b> removed from list.","../war.php");
      header("Location: ../war.php");
      exit;
    } else {
      $_SESSION['error'] = "The friendly faction you tried to remove appears to already be removed.";
      header("Location: ../war.php");
      exit;
    }
}

$_SESSION['error'] = "An error occurred when removing the listed faction.";
header("Location: ../war.php");
exit;
?>
