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

if (isset($_POST['fidEnemy']) && !empty($_POST['fidEnemy']) && is_numeric($_POST['fidEnemy'])) {
    $fid = $_POST['fidEnemy'];

    $get_apikey = new db_request();
    $apikey = $get_apikey->getRawAPIKeyByUserID($_SESSION['userid']);

    $api_request = new api_request($apikey);
    $faction = $api_request->getFactionAPI($fid);

    if (!empty($faction) && $faction['ID'] != NULL) {


      $db_request_check_enemy_faction = new db_request();
      $row = $db_request_check_enemy_faction->getEnemyFactionByFactionID($fid);

      if (!empty($row)) {
        $_SESSION['error'] = "The faction you entered is already an enemy faction.";
        header("Location: ../war.php");
        exit;
      }

      $fid = $faction['ID'];
      $fname = $faction['name'];
      $leader = $faction['leader'];
      $coleader = $faction['co-leader'];
      $age = $faction['age'];
      $best_chain = $faction['best_chain'];
      $total_members = count($faction['members']);
      $respect = $faction['respect'];

      $db_request_add_enemy_faction = new db_request();
      $db_request_add_enemy_faction->insertEnemyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);

      include_once(__DIR__ . "/../../misc/getEnemyFactionMembers.php");

      $_SESSION['success'] = "Enemy Faction <b>". $fname . " [" . $fid . "]</b> added.";
      header("Location: ../war.php");
      exit;
    } //if faction api exists
} //post fidEnemy set

$_SESSION['error'] = "The faction you entered does not exist.";
header("Location: ../war.php");
exit;
?>
