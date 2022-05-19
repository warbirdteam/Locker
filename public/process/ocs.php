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

$db_request = new db_request();

if (isset($_POST['pa1']) && isset($_POST['pa2']) && isset($_POST['pa3']) && isset($_POST['pa4']) && isset($_POST['pa5']) && is_numeric($_POST['pa1']) && is_numeric($_POST['pa2']) && is_numeric($_POST['pa3']) && is_numeric($_POST['pa4']) && is_numeric($_POST['pa5'])) {
    
    
    $db_request->updateSiteVariableByName($_POST['pa1'], "pa1");
    $db_request->updateSiteVariableByName($_POST['pa2'], "pa2");
    $db_request->updateSiteVariableByName($_POST['pa3'], "pa3");
    $db_request->updateSiteVariableByName($_POST['pa4'], "pa4");
    $db_request->updateSiteVariableByName($_POST['pa5'], "pa5");
    
    $success = new Success_Message("Updated PA pay percentages.","../organizedcrimes.php");
    header("Location: ../organizedcrimes.php");
    exit;
}
if (isset($_POST['ids']) && isset($_POST['fid']) && is_numeric($_POST['fid'])) {
  $userID = $db_request->getFactionKeyholderByFactionID($_POST['fid']);
  

  $apikey = $db_request->getRawAPIKeyByUserID($userID);

  $api_request = new api_request($apikey);
  $factionData = $api_request->getFactionBalances($_POST['fid']);

  $ids = explode(",", $_POST['ids']);

  $returnArray = [];

  foreach ($ids as $id) {
    $returnArray[$id] = $factionData['donations'][$id]['money_balance'];
  }

  echo json_encode($returnArray);
}
else {
    echo "POST values not correct.";
    header("Location: ../welcome.php");
}




?>