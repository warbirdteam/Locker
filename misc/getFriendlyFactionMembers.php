<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$db_request_fact = new db_request();
$factions = $db_request_fact->getAllFriendlyFactions();
$rowCount = $db_request_fact->row_count;


foreach($factions as $faction) {
  if ($rowCount > 5) {
    sleep(1);
  }
  getFriendlyFactionMembers('1468764', $faction['factionID']);
}



function getFriendlyFactionMembers($userid, $factionID) {

  $db_request = new db_request();
  $apikey = $db_request->getRawAPIKeyByUserID($userid);

  $db_request_check_friendly_faction = new db_request();
  $row = $db_request_check_friendly_faction->getFriendlyFactionByFactionID($factionID);

  if (!empty($row)) {
    //faction is already in list of enemy factions
    $factionTimestamp = $row['timestamp'];
    $now = time();
    if($now >= ($factionTimestamp + 3600)) {
      //continue to gather faction data
    } else {
      return; //skip api pull and update because it was recently updated an hour ago
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

  $row = $db_request->getFriendlyFactionByFactionID($fid);

  if($row) {
    $db_request->updateFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect, $timestamp);
  } else {
    $db_request->insertFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect, $timestamp);
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
