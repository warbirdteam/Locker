<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$db_request = new db_request();
$factions = $db_request->getAllEnemyFactions();

foreach($factions as $faction) {
  getEnemyFactionMembers('1468764', $faction['factionID']);
}



function getEnemyFactionMembers($userid, $factionID) {

  $db_request = new db_request();
  $apikey = $db_request->getRawAPIKeyByUserID($userid);

  $db_request_check_enemy_faction = new db_request();
  $row = $db_request_check_enemy_faction->getEnemyFactionByFactionID($factionID);

  if (!empty($row)) {
    //faction is already in list of enemy factions
    $factionTimestamp = $row['timestamp'];
    $now = time();
    if($now >= ($factionTimestamp + 3600)) {
      //continue to gather faction data
    } else {
      exit; //skip api pull and update because it was recently updated an hour ago
    }
  }


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
  $timestamp = time();

  $row = $db_request->getEnemyFactionByFactionID($fid);

  if($row) {
    $db_request->updateEnemyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect, $timestamp);
  } else {
    $db_request->insertEnemyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect, $timestamp);
  }


  $members = $factionData['members']; //members array

  $dbMemberData = $db_request->getEnemyMembersByFaction($fid);

  if(!empty($dbMemberData) && !empty($members)) {

    $diff = array_diff_key($dbMemberData, $members);

    //delete member from database if exists in diff array
    while ($cut = current($diff)) {
      $cutuser = key($diff);
      $memberData = $db_request->getEnemyMemberByTornID($cutuser);
      if ($memberData) {
        $db_request->removeEnemyMemberByTornID($cutuser);
      }
      next($diff);
    } //while

  }



  while ($member = current($members)) {
    $userid = key($members);
    $row = $db_request->getEnemyMemberByTornID($userid);

    if($row) {
      $db_request->updateEnemyMember($userid, $member);
    } else {
      $db_request->insertEnemyMember($userid, $fid, $member);
    }

    next($members);
  }

} //getEnemyFactionMembers Function





?>
