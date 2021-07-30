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

$db_request = new db_request();

if (isset($_POST['siteID'])) {
  $siteID = $_POST['siteID'];

  if ($_SESSION['siteID'] == $siteID) {
    exit();
  }

  $row = $db_request->getSiteUserPreferencesBySiteID($siteID);

  if (empty($row)) {
      exit();
  }
} else {
  exit();
}


if (isset($_POST['role'])) {

  $roles  = ["admin","leadership","member","guest","none"]; // the white list of allowed field names
  $key     = array_search($_POST['role'], $roles); // see if we have such a name
  $field = $roles[$key];

  if ($field == NULL) {
    exit();
  }

  $db_request->updateSiteUserRoleBySiteID($siteID, $field);
} else {
  exit();
}



?>
