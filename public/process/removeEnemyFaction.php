<?php
session_start();
if(!isset($_SESSION['siteID'])){
  $_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: ../index.php");
  exit;
}

if ($_SESSION['roleValue'] <= 2) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
  exit;
}

include_once(__DIR__ . "/../../includes/autoloader.inc.php");

if (isset($_POST['enemyRemove']) && !empty($_POST['enemyRemove']) && is_numeric($_POST['enemyRemove'])) {
    $fid = $_POST['enemyRemove'];

    $db_request_check_enemy_faction = new db_request();
    $faction = $db_request_check_enemy_faction->getEnemyFactionByFactionID($fid);

    if (!empty($faction)) {
      $db_request_remove_faction = new db_request();
      $db_request_remove_faction->removeEnemyFactionByFactionID($fid);
      $db_request_remove_faction->removeAllEnemyMembersByFactionID($fid);


      $success = new Success_Message("Enemy Faction <b>". $faction['factionName'] . " [" . $faction['factionID'] . "]</b> removed from list.","../war.php");
      header("Location: ../war.php");
      exit;
    } else {
      $_SESSION['error'] = "The enemy faction you tried to remove appears to already be removed.";
      header("Location: ../war.php");
      exit;
    }
}

$_SESSION['error'] = "An error occurred when removing the listed faction.";
header("Location: ../war.php");
exit;
?>
