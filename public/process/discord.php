<?php
session_start();
if(!isset($_SESSION['siteID'])){
  $_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	exit();
}

if (!isset($_SESSION['roleValue'])) {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	exit();
}

//ADMIN ONLY
if ($_SESSION['roleValue'] <= 3) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	exit();
}


include_once(__DIR__ . "/../../includes/autoloader.inc.php");



if (isset($_POST['commandID'])) {
  $commandID = $_POST['commandID'];

  $db_request = new db_request();

  //Command Toggle
  if (isset($_POST['enabled']) && !isset($_POST['roleID']) && !isset($_POST['channelID'])) {
    $enabled = $_POST['enabled'];

    $db_request->updateDiscordCommandToggle($commandID, $enabled);
  }

  //Command Role Toggle
  if (isset($_POST['enabled']) && isset($_POST['roleID']) && !isset($_POST['channelID'])) {
    $enabled = $_POST['enabled'];
    $roleID = $_POST['roleID'];

    $db_request_cmd = new db_request();
    $commandPerm = $db_request_cmd->getDiscordPermissionByCommandIDandRoleID($commandID, $roleID);
    if ($commandPerm) {
      if ($enabled == 0) {
        $db_request->DeleteDiscordCommandRole($commandID, $roleID);
      }
    } else {
      if ($enabled == 1) {
        $db_request->InsertDiscordCommandRole($commandID, $roleID);
      }
    }
  }

  //Command Channel Toggle
  if (isset($_POST['enabled']) && !isset($_POST['roleID']) && isset($_POST['channelID'])) {
    $enabled = $_POST['enabled'];
    $channelID = $_POST['channelID'];

    $db_request_cmd = new db_request();
    $commandPerm = $db_request_cmd->getDiscordPermissionByCommandIDandChannelID($commandID, $channelID);
    if ($commandPerm) {
      if ($enabled == 0) {
        $db_request->DeleteDiscordCommandChannel($commandID, $channelID);
      }
    } else {
      if ($enabled == 1) {
        $db_request->InsertDiscordCommandChannel($commandID, $channelID);
      }
    }
  }


} else {
  exit();
}





?>
