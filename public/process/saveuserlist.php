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
  switch (strtolower($_POST['role'])) {
    case 'admin':
      $role = strtolower($_POST['role']);
      break;
    case 'leadership':
      $role = strtolower($_POST['role']);
      break;
    case 'member':
      $role = strtolower($_POST['role']);
      break;

    default:
      exit();
      break;
  }

  $db_request->updateSiteUserRoleBySiteID($siteID, $role);
} else {
  exit();
}

?>
