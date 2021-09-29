<?php
//##### ADMIN ONLY PAGE
//start the session array
session_start();
//If cannot find site ID, empty session array and send to login page with error message
if(!isset($_SESSION['siteID'])){
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
	exit;
}
if ($_SESSION['role'] == 'admin') {
	//##### ADMIN ONLY PAGE
	//load classes files in classes folder
	include_once(__DIR__ . "/../../includes/autoloader.inc.php");
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: ../welcome.php");
	exit;
}

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
