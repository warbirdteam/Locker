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

if (isset($_POST['fidFriendly']) && !empty($_POST['fidFriendly']) && is_numeric($_POST['fidFriendly'])) {
    $fid = $_POST['fidFriendly'];

    $get_apikey = new db_request();
    $apikey = $get_apikey->getRawAPIKeyByUserID($_SESSION['userid']);

    $api_request = new api_request($apikey);
    $faction = $api_request->getFactionAPI($fid);

    if (!empty($faction) && $faction['ID'] != NULL) {


      $db_request_check_enemy_faction = new db_request();
      $row = $db_request_check_enemy_faction->getFriendlyFactionByFactionID($fid);

      if (!empty($row)) {
        $_SESSION['error'] = "The faction you entered is already a friendly faction.";
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
      $db_request_add_enemy_faction->insertFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);

      getFriendlyFactionMembers("1468764", $fid);

      $_SESSION['success'] = "Friendly Faction <b>". $fname . " [" . $fid . "]</b> added.";
      header("Location: ../war.php");
      exit;
    } //if faction api exists
} //post fidEnemy set

$_SESSION['error'] = "The faction you entered does not exist.";
header("Location: ../war.php");
exit;


function getFriendlyFactionMembers($userid, $factionID) {

  $db_request = new db_request();
  $apikey = $db_request->getRawAPIKeyByUserID($userid);

  $api_request = new api_request($apikey);
  $factionData = $api_request->getFactionAPI($factionID);

  //save faction info to database
  $fid = $factionData['ID'];
  $fname = $factionData['name'];
  $leader = $factionData['leader'];
  $coleader = $factionData['co-leader'];
  $age = $factionData['age'];
  $best_chain = $factionData['best_chain'];
  $total_members = count($factionData['members']);
  $respect = $factionData['respect'];

  $row = $db_request->getFriendlyFactionByFactionID($fid);

  if($row) {
    $db_request->updateFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);
  } else {
    $db_request->insertFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);
  }


  $members = $factionData['members']; //members array

  $dbMemberData = $db_request->getFriendlyMembersByFaction($fid);

  if(!empty($dbMemberData) && !empty($members)) {

    $diff = array_diff_key($dbMemberData, $members);

    //delete member from database if exists in diff array
    while ($cut = current($diff)) {
      $cutuser = key($diff);
      $memberData = $db_request->getFriendlyMemberByTornID($cutuser);
      if ($memberData) {
        $db_request->removeFriendlyMemberByTornID($cutuser);
      }
      next($diff);
    } //while

  }



  while ($member = current($members)) {
    $userid = key($members);
    $row = $db_request->getFriendlyMemberByTornID($userid);

    if($row) {
      $db_request->updateFriendlyMember($userid, $member);
    } else {
      $db_request->insertFriendlyMember($userid, $fid, $member);
    }

    next($members);
  }

} //getFriendlyFactionMembers Function
?>
